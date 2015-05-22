<?php
/**
 * Created by PhpStorm.
 * User: bryce
 * Date: 5/20/15
 * Time: 9:17 PM
 */

namespace WordWrap\AssetManager;


class CSSAsset extends Asset{

    public function __construct($assetLocations) {
        parent::__construct("css", $assetLocations);
    }

    public function dumpAssets() {
        echo '<style type="text/css">';
        parent::dumpAssets();
        echo '</style>';
    }

}