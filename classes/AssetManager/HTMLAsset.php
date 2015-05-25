<?php
/**
 * Created by PhpStorm.
 * User: bryce
 * Date: 5/24/15
 * Time: 5:25 PM
 */

namespace WordWrap\AssetManager;


class HTMLAsset extends AssetType {

    /**
     * @param string $assetLocations the location where all html assets will be located
     */
    public function __construct($assetLocations) {
        parent::__construct($assetLocations, "html");
    }

    /**
     * override this to do anything before we dump the assets to the client
     */
    public function onPreDump() { }

    /**
     * override this to do anything after we dump the assets to the client
     */
    public function onPostDump() { }
}