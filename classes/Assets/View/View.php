<?php
/**
 * Created by PhpStorm.
 * User: bryce
 * Date: 5/24/15
 * Time: 5:29 PM
 */

namespace WordWrap\Assets\View;


use WordWrap\Assets\BaseAsset;
use WordWrap\LifeCycle;

class View extends BaseAsset {

    /**
     * @param $lifeCycle LifeCycle the current running LifeCycle
     * @param $templateName string|null the name of the template we are loading
     * @param $templateType string the type of template we are using, defaults to HTML
     */
    function __construct($lifeCycle, $templateName = null, $templateType = "html") {
        parent::__construct($lifeCycle, $templateName, $templateType);
    }

}