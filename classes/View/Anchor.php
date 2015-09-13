<?php
/**
 * Created by PhpStorm.
 * User: bryce
 * Date: 9/12/15
 * Time: 9:15 PM
 */

namespace WordWrap\View;


use WordWrap\LifeCycle;

class Anchor extends View {

    /**
     * @var string href to open when link is clicked
     */
    private $href;

    /**
     * @var string content to put in the link
     */
    private $content;

    /**
     * @var bool whether or not we want to open this link in a new tab/window
     */
    private $openWindow = false;

    /**
     * @var array string of classes to attach to this anchor
     */
    private $classes = [];

    /**
     * @param LifeCycle $lifeCycle the life cycle for this class
     */
    public function __constructor(LifeCycle $lifeCycle) {
        parent::__construct($lifeCycle);
    }

    /**
     * @param $href string the url for this link
     */
    public function setHref($href) {
        $this->href = $href;
    }

    /**
     * @param $content string the content for the link
     */
    public function setContent($content) {
        $this->content = $content;
    }

    /**
     * tells us whether or not we are suppose to open this in a new tab/window
     */
    public function openNewWindow() {
        $this->openWindow = true;
    }

    /**
     * @param $class string adds a class to this link
     */
    public function addClass($class) {
        $this->classes[] = $class;
    }

    /**
     * @return string of the content of this link
     */
    public function export() {
        $class = implode(" ", $this->classes);
        $target = ($this->openWindow ? "_blank" : "");

        return "<a href='$this->href' target='$target' class='$class'>$this->content</a>";
    }
}