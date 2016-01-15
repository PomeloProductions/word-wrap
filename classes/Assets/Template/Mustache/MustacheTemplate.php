<?php
/**
 * Created by PhpStorm.
 * User: bryce
 * Date: 11/29/15
 * Time: 11:40 PM
 */

namespace WordWrap\Assets\Template\Mustache;


use WordWrap\Assets\BaseAsset;
use WordWrap\LifeCycle;

class MustacheTemplate extends BaseAsset {


    /**
     * @var MustacheFactory this instance's factory
     */
    private $mustacheFactory;

    /**
     * @var Object the data object to use as the templates content
     */
    private $dataObject;

    /**
     * @param LifeCycle $lifeCycle current life cycle instance
     * @param string $assetName the name of the asset we are loading
     * @param Object $dataObject the data for this template
     */
    public function __construct($lifeCycle, $assetName, $dataObject = null) {
        parent::__construct($lifeCycle, $assetName, "mustache");

        if (!$dataObject)
            $dataObject = (object) [];

        $this->dataObject = $dataObject;

        $this->mustacheFactory = new MustacheFactory();
    }

    public function export() {

        $engine = $this->mustacheFactory->getMustacheEngine();

        return $engine->render($this->getTemplateContent(), $this->dataObject);
    }

    /**
     * @return string any content that needs to be echoed before export
     */
    public function onPreExport() {
        // TODO: nothing needs to be done
    }

    /**
     * @return string any content that needs to be echoed after export
     */
    public function onPostExport()  {
        // TODO: nothing needs to be done
    }
}