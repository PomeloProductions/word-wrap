<?php
/**
 * Created by PhpStorm.
 * User: bryce
 * Date: 5/24/15
 * Time: 5:28 PM
 */

namespace WordWrap\Assets\View;

use WordWrap\LifeCycle;

class ViewCollection extends View{

    /**
     * @var View[][] all of the views that this collection contains.
     *                  Key 1 is the name of the collection in the template which will have the following syntax [[<key-1>]]
     *                  Key 2 will just be a numerical array of the views in the order in which they were added
     */
    protected $childViews;

    /**
     * @param $lifeCycle LifeCycle the current running LifeCycle
     * @param $templateName string the name of the template we are loading
     * @param $templateType string the type of template we are using, defaults to HTML
     */
    function __construct($lifeCycle, $templateName, $templateType = "html") {
        parent::__construct($lifeCycle, $templateName, $templateType);
        $this->childViews = [];
    }

    /**
     * @param $collection string the name of the collection we are adding to
     * @param View $view a new child to add to the collection
     */
    public function addChildView($collection, View $view) {
        if(!isset($this->childViews[$collection]))
            $this->childViews[$collection] = [];

        $this->childViews[$collection][] = $view;
    }

    /**
     * @param $collection string the name of the collection we are adding to
     * @param View[] $views a new child to add to the collection
     */
    public function addChildViews($collection, array $views) {
        if(!isset($this->childViews[$collection]))
            $this->childViews[$collection] = [];

        $this->childViews[$collection] = array_merge($this->childViews[$collection], $views);
    }

    /**
     * @param $strip bool defaults to false in order to keep with php7 standards
     * @return string processes all child views into exported html
     */
    public function export($strip = false) {
        $processedContents = parent::export($strip);

        foreach($this->childViews as $collection => $views) {
            $processedViews = "";

            foreach($views as $view) {
                $processedViews.= $view->export();
            }

            $processedContents = str_replace("[[" . $collection . "]]", $processedViews, $processedContents);
        }

        $processedContents = $this->stripEmptyBrackets($processedContents);

        return $processedContents;
    }
}