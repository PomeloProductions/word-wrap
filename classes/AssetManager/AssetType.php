<?php
/**
 * Created by PhpStorm.
 * User: bryce
 * Date: 5/24/15
 * Time: 6:21 PM
 */

namespace WordWrap\AssetManager;


abstract class AssetType {

    /**
     * @var string the location of all the assets of this asset type
     */
    private $assetLocation;

    /**
     * @param $assetLocation string the locations of the assets for this type
     */
    function __construct($assetLocation) {
        $this->assetLocation = $assetLocation;
    }

    /**
     * @return string the locations
     */
    public function getAssetLocation() {
        return $this->assetLocation;
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