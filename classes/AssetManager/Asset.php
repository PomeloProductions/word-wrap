<?php
/**
 * Created by PhpStorm.
 * User: bryce
 * Date: 5/20/15
 * Time: 8:52 PM
 */

namespace WordWrap\AssetManager;

use \Exception;

class Asset {

    /**
     * @var string the type of assets we will be using
     */
    protected $assetType;

    /**
     * @var string the root location where all of our assets will be
     */
    protected $assetLocations;

    /**
     * @var string[][] of all our assets that have been loaded
     */
    protected $loadedAssets = [];

    function __construct($assetType, $assetLocations) {
        $this->assetType = $assetType;
        $this->assetLocations = $assetLocations;
    }

    /**
     * @param $assetName
     * @param array $replaceValues
     * @param null $fileExtension the extension of the files we are looking for, this will default to
     * @throws Exception if the asset we are looking for is not found
     */
    public function addAsset($assetName, $replaceValues = [], $fileExtension = null) {

        $fileExtension = $fileExtension == null ? $this->assetType : $fileExtension;
        $assetPath = $this->assetLocations . $assetName . "." . $fileExtension;
        if(!file_exists($assetPath ))
            throw new Exception("Unable to find asset " . $assetName . " at path " . $assetPath);

        $assetContents = file_get_contents($assetPath);
        foreach($replaceValues as $key => $value)
            $assetContents = str_replace('{{' . $key . '}}', $value, $assetContents);

        $this->loadedAssets[] = ['name' => $assetName, "contents" => $assetContents];
    }

    /**
     * This will dump all assets out to the browser window
     */
    public function dumpAssets() {
        foreach($this->loadedAssets as $asset) {
            echo $asset["contents"];
        }
    }

}