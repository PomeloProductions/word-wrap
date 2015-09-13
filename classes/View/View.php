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
    private $template;

    /**
     * @var string[] all template variables this view will use
     */
    private $templateVars;

    /**
     * @param $lifeCycle LifeCycle the current running LifeCycle
     * @param $templateName string|null the name of the template we are loading
     * @param $templateType string the type of template we are using, defaults to HTML
     */
    function __construct($lifeCycle, $templateName = null, $templateType = "html") {
        $this->lifeCycle = $lifeCycle;

        if($templateName != null) {
            $this->lifeCycle->assetManager->loadAsset($templateType, $templateName);

            $this->template = $this->lifeCycle->assetManager->getAsset($templateType, $templateName);
        }

        $this->templateVars = [];
    }

    /**
     * @param $key string the key for this particular variable
     * @param $value string the value for this particular variable
     */
    public function setTemplateVar($key, $value) {
        $this->templateVars[$key] = $value;
    }

    /**
     * @return string the exported view html
     */
    public function export($strip = true) {
        $processedContents = $this->template->getAssetContents();

        foreach($this->templateVars as $key => $value)
            $processedContents = str_replace('{{' . $key . '}}', $value, $processedContents);

        if($strip)
            $processedContents = $this->stripEmptyBrackets($processedContents);

        return $processedContents;
    }

    protected function stripEmptyBrackets($contents) {

        $contents = preg_replace('/\[{2}.*\]{2}/', '', $contents);
        $contents = preg_replace('/\{{2}.*\}{2}/', '', $contents);

        return $contents;
    }
}