<?php
/**
 * Created by PhpStorm.
 * User: bryce
 * Date: 5/24/15
 * Time: 6:02 PM
 */

namespace WordWrap\AssetManager;


class AssetManager {



    /**
     * @var AssetType[string] all asset types that we have loaded into our application
     */
    private $assetTypes;

    /**
     * @var Asset[string][string] all assets that have been loaded.
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
     * @param $fileExtension null|string an optional override for the file extension, default will be $assetType if not supplied
     */
    public function registerAssetType($assetType, $assetLocation, AssetType $assetTypeObject = null, $fileExtension = null) {

    }

    /**
     * @param $assetType
     * @param $assetName
     */
    public function loadAsset($assetType, $assetName) {

    }
}