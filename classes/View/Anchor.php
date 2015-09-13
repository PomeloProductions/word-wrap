<?php
/**
 * Created by PhpStorm.
 * User: bryce
 * Date: 9/12/15
 * Time: 9:15 PM
 */

namespace WordWrap\View;


class Anchor extends View {

    /**
     * @var string href to open when link is clicked
     */
    public $href;

    /**
     * @var string content to put in the link
     */
    public $content;

    /**
     * @var bool whether or not we want to open this link in a new tab/window
     */
    public $openWindow = false;

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
     * @return string of the content of this link
     */
    public function export() {
        $target = ($this->openWindow ? "_blank" : "");
        return "<a href='$this->href' target='$target'>$this->content</a>";
    }
}