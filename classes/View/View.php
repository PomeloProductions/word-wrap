<?php
/**
 * Created by PhpStorm.
 * User: bryce
 * Date: 5/24/15
 * Time: 5:29 PM
 */

namespace WordWrap\View;


use WordWrap\AssetManager\Asset;
use WordWrap\LifeCycle;

class View {

    /**
     * @var LifeCycle the current running instance of the plugin
     */
    protected $lifeCycle;

    /**
     * @var Asset the template this view uses
     */
    private $templateContent;

    /**
     * @var string[] all template variables this view will use
     */
    private $templateVars;

    /**
     * @param $lifeCycle LifeCycle the current running LifeCycle
     * @param $templateName string the name of the template we are loading
     */
    function __construct($lifeCycle, $templateName) {
        $this->lifeCycle = $lifeCycle;

        $this->lifeCycle->assetManager->loadAsset("html", $templateName);

        $this->templateContent = $this->lifeCycle->assetManager->getAsset("html", $templateName);

        $this->templateVars = [];
    }

    /**
     * @param $key string the key for this particular variable
     * @param $value string the value for this particular variable
     */
    public function setTemplateVar($key, $value) {
        $this->templateVars[$key] = $value;
    }

    public function export() {

    }
}