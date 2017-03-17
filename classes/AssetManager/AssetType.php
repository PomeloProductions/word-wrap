<?php
/**
 * Created by PhpStorm.
 * User: bryce
 * Date: 5/24/15
 * Time: 6:21 PM
 */

namespace WordWrap\AssetManager;


class AssetType {

    /**
     * @var string the
     */
    private $pluginDirectory;

    /**
     * @var string the location of all the assets of this asset type
     */
    private $serverLocation;
    /**
     * @var string the extension of these assets
     */
    private $fileExtension;

    /**
     * @param $pluginDirectory string the location of these assets relative to the plugin
     * @param $serverLocation string the locations of the assets for this type relative to the server root
     * @param $fileExtension string the extension of these assets
     */
    function __construct($pluginDirectory, $serverLocation, $fileExtension) {
        $this->pluginDirectory = $pluginDirectory;
        $this->serverLocation = $serverLocation;
        $this->fileExtension = $fileExtension;
    }

    /**
     * @return string the location of all assets for this type relative to the plugin root
     */
    public function getPluginDirectory () {
        return $this->pluginDirectory;
    }

    /**
     * @return string the location of all assets for this type relative to the server root
     * @deprecated
     */
    public function getAssetLocation () {
        return $this->getServerLocation();
    }

    /**
     * @return string the location of all assets for this type relative to the server root
     */
    public function getServerLocation () {
        return $this->serverLocation;
    }

    /**
     * @return string the file extension of all assets of this type
     */
    public function getFileExtension () {
        return $this->fileExtension;
    }

}