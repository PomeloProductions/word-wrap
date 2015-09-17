<?php
/**
 * Created by PhpStorm.
 * User: bryce
 * Date: 5/24/15
 * Time: 6:21 PM
 */

namespace WordWrap\AssetManager\AssetTypes;


abstract class AssetType {

    /**
     * @var string the location of all the assets of this asset type
     */
    private $assetLocation;
    /**
     * @var string the extension of these assets
     */
    private $fileExtension;

    /**
     * @param $assetLocation string the locations of the assets for this type
     * @param $fileExtension string the extension of these assets
     */
    function __construct($assetLocation, $fileExtension) {
        $this->assetLocation = $assetLocation;
        $this->fileExtension = $fileExtension;
    }

    /**
     * @return string the location of all assets for this type
     */
    public function getAssetLocation() {
        return $this->assetLocation;
    }

    /**
     * @return string the file extension of all assets of this type
     */
    public function getFileExtension() {
        return $this->fileExtension;
    }

    /**
     * override this to do anything before we dump the assets to the client
     */
    public abstract function onPreDump();

    /**
     * override this to do anything after we dump the assets to the client
     */
    public abstract function onPostDump();

}