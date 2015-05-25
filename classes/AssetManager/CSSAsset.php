<?php
/**
 * Created by PhpStorm.
 * User: bryce
 * Date: 5/20/15
 * Time: 9:17 PM
 */

namespace WordWrap\AssetManager;


class CSSAsset extends AssetType{

    /**
     * @param string $assetLocations the location where all css assets will be located
     */
    public function __construct($assetLocations) {
        parent::__construct($assetLocations, "css");
    }

    /**
     * We will need to echo out an opening css tag here
     */
    public function onPreDump() {
        echo '<style type="text/css">';
    }

    /**
     * We will need to echo out a closing css tag here
     */
    public function onPostDump(){
        echo '</style>';
    }
}