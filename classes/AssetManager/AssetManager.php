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
     * @param $pluginLocation string the location where assets of this type will be located in the plugin
     * @param $serverLocation string the location where assets of this type will be located on the file system
     * @param $fileExtension string|null the file extension this asset type uses
     */
    public function registerAssetType($assetType, $pluginLocation, $serverLocation, $fileExtension = null) {
        if($fileExtension == null)
            $fileExtension = $assetType;

        $this->assets[$assetType] = [];
        $this->assetTypes[$assetType] = new AssetType($pluginLocation, $serverLocation, $fileExtension);
    }

    /**
     * @param $assetType string
     * @param $assetName string
     * @throws Exception if we are attempting to load an asset before the asset type is loaded.
     */
    public function loadAsset($assetType, $assetName) {

        $assetTypeObject = $this->getAssetType($assetType);

        if(isset($this->assets[$assetType][$assetName]))
            return;

        $assetPath = $assetTypeObject->getServerLocation() . $assetName . "." . $assetTypeObject->getFileExtension();
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
            throw new Exception("You must register your asset before you can get it.");

        if(!isset($this->assets[$type][$name]))
            $this->loadAsset($type, $name);

        return $this->assets[$type][$name];
    }

    /**
     * Retrieves an asset type object from the manager
     *
     * @param $type
     * @return AssetType
     * @throws Exception
     */
    public function getAssetType ($type) {

        if (!isset($this->assetTypes[$type])) {
            throw new Exception("You must register your asset before you can get it.");
        }

        return $this->assetTypes[$type];
    }
}