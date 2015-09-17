<?php

namespace WordWrap\Assets;
use WordWrap\AssetManager\Asset;
use WordWrap\LifeCycle;

/**
 * Created by PhpStorm.
 * User: bryce
 * Date: 9/17/15
 * Time: 12:39 AM
 */
abstract class BaseAsset{

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
     * @param $templateName string the name of the template we are loading
     * @param $templateType string the type of template we are using, defaults to HTML
     */
    function __construct($lifeCycle, $templateName, $templateType) {
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
     * @param bool @strip whether or not to strip out empty variables right away
     * @return string the exported view html
     */
    public function export($strip = true) {

        $preExport = $this->onPreExport();

        $processedContents = $this->template->getAssetContents();

        foreach($this->templateVars as $key => $value)
            $processedContents = str_replace('{{' . $key . '}}', $value, $processedContents);

        if($strip)
            $processedContents = $this->stripEmptyBrackets($processedContents);

        $postExport = $this->onPostExport();

        $processedContents = (empty($preExport) ? '' : $preExport) . $processedContents .
            (empty($postExport) ? '' : $postExport);

        return $processedContents;
    }

    /**
     * Removes empty brackets from exported content
     * @param $contents
     * @return mixed
     */
    protected function stripEmptyBrackets($contents) {

        $contents = preg_replace('/\[{2}.*\]{2}/', '', $contents);
        $contents = preg_replace('/\{{2}.*\}{2}/', '', $contents);

        return $contents;
    }

    /**
     * @return string any content that needs to be echoed before export
     */
    public abstract function onPreExport();

    /**
     * @return string any content that needs to be echoed after export
     */
    public abstract function onPostExport();

}