<?php

namespace WordWrap\Assets\StyleSheet;
use WordWrap\Assets\BaseAsset;
use WordWrap\LifeCycle;

/**
 * Created by PhpStorm.
 * User: bryce
 * Date: 9/17/15
 * Time: 12:57 AM
 */
class CSS extends BaseAsset {

    /**
     * @param LifeCycle $lifeCycle
     * @param string $assetName the name of the asset we are loading
     */
    public function __construct($lifeCycle, $assetName) {
        parent::__construct($lifeCycle, $assetName, "css");
    }

}