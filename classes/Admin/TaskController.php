<?php
/**
 * Created by PhpStorm.
 * User: bryce
 * Date: 9/2/15
 * Time: 10:24 PM
 */

namespace WordWrap\Admin;


use WordWrap\Configuration\Task;

abstract class TaskController {

    /**
     * @var Task the configuration of this task
     */
    public $task;

    /**
     * @param Task $task the configuration for this controller
     */
    public function __construct(Task $task) {
        $this->task = $task;


    }

    /**
     * override to render the main page
     */
    public abstract function renderMainContent();


    /**
     * override to render the main page
     */
    public abstract function renderSidebarContent();
}