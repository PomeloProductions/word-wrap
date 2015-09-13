<?php
/**
 * Created by PhpStorm.
 * User: bryce
 * Date: 5/24/15
 * Time: 6:02 PM
 */

namespace WordWrap\AssetManager;

use \Exception;

class AssetManager {



    /**
     * @var AssetType[] all asset types that we have loaded into our application
     */
    private $assetTypes;

    /**
     * @var Asset[][] all assets that have been loaded.
     *                      The assetType is the first key.
     *                      The assetName is the second key.
     */
    private $assets;

    /**
     * gets the object ready to manage our assets
     */
    public function __construct() {
        $this->assetTypes = [];
        $this->assets = [];
    }

    /**
     * Registers a new type of asset that can be loaded
     *
     * @param $assetType string what type of assets are located at this location
     * @param $assetLocation string the location where assets of this type will be located on the file system
     * @param $assetTypeObject AssetType|null this can be used in the case of a custom asset type.
     *                              Otherwise we will load some of the prebuilt asset types.
     * @throws Exception if we could not find the asset type object
     */
    public function registerAssetType($assetType, $assetLocation, AssetType $assetTypeObject = null) {
        if($assetTypeObject == null) {
            switch($assetType) {
                case "css":
                    $assetTypeObject = new CSSAsset($assetLocation);
                    break;
                case "html":
                case "admin_html":
                    $assetTypeObject = new HTMLAsset($assetLocation);
                    break;
                default:
                    throw new Exception("Unable to register type. You must either use one of the predefined asset types or pass in your own asset type object");
            }
        }
        $this->assets[$assetType] = [];
        $this->assetTypes[$assetType] = $assetTypeObject;
    }

    /**
     * @param $assetType string
     * @param $assetName string
     * @throws Exception if we are attempting to load an asset before the asset type is loaded.
     */
    public function loadAsset($assetType, $assetName) {
        if(!isset($this->assetTypes[$assetType]))
            throw new Exception("You must register your asset type before you can begin loading assets of that type.");

        if(isset($this->assets[$assetType][$assetName]))
            return;

        $assetTypeObject = $this->assetTypes[$assetType];
        $assetPath = $assetTypeObject->getAssetLocation() . $assetName . "." . $assetTypeObject->getFileExtension();
        $this->assets[$assetType][$assetName] = new Asset($assetPath);
    }

    /**
     * @param $type string the type of asset we are trying to get
     * @param $name string the name of the asset we are trying to get
     * @return Asset The already created asset
     * @throws Exception if we try to get an asset before we load it
     */
    public function getAsset($type, $name) {
        if(!isset($this->assetTypes[$type]))
            throw new Exception("You must register and load your asset before you can get it.");

        if(!isset($this->assets[$type][$name]))
            throw new Exception("You must load your asset before you can get it.");

        return $this->assets[$type][$name];
    }
}