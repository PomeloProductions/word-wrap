<?php
/**
 * Created by PhpStorm.
 * User: bryce
 * Date: 5/24/15
 * Time: 5:29 PM
 */

namespace WordWrap\View;


use WordWrap\LifeCycle;

class View {

    /**
     * @var LifeCycle the current running instance of the plugin
     */
    protected $lifeCycle;

    private $templateContent;

    /**
     * @param $lifeCycle LifeCycle the current running LifeCycle
     * @param $templateName string the name of the template we are loading
     */
    function __construct($lifeCycle, $templateName) {
        $this->lifeCycle = $lifeCycle;

        $this->lifeCycle->assetManager->loadAsset("html", $templateName);
    }
}