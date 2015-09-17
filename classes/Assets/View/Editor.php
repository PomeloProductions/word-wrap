<?php
/**
 * Created by PhpStorm.
 * User: bryce
 * Date: 9/13/15
 * Time: 2:58 AM
 */

namespace WordWrap\Assets\View;


use WordWrap\LifeCycle;

class Editor extends View {

    /**
     * @var string the id of this editor
     */
    private $editorId;

    /**
     * @var string the content to fill this editor with
     */
    private $content;

    /**
     * @var string the title of this editor
     */
    private $title;

    /**
     * @var null|int for the total height of the editor
     */
    private $height = null;

    /**
     * @param LifeCycle $lifeCycle
     * @param null|string $editorId
     * @param string $content
     * @param $title
     */
    public function __construct(LifeCycle $lifeCycle, $editorId, $content, $title) {
        parent::__construct($lifeCycle, "admin_editor", "admin_html");

        $this->editorId = $editorId;
        $this->content = $content;
        $this->title = $title;

        $this->setTemplateVar("editor_id", $this->editorId);
        $this->setTemplateVar("title", $this->title);

    }

    public function setHeight($height) {
        $this->height = $height;
    }

    public function export() {

        $settings = [];

        if($this->height)
            $settings["editor_height"] = $this->height;

        ob_start();
        wp_editor($this->content, $this->editorId, $settings);
        $this->setTemplateVar("editor", ob_get_clean());

        return parent::export();
    }
}