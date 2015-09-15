<?php
/**
 * Created by PhpStorm.
 * User: bryce
 * Date: 9/13/15
 * Time: 2:58 AM
 */

namespace WordWrap\View;


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

        ob_start();
        wp_editor($this->content, $this->editorId);
        $this->setTemplateVar("editor", ob_get_clean());

    }

}