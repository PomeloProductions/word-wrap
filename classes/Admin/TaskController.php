<?php
/**
 * Created by PhpStorm.
 * User: bryce
 * Date: 9/2/15
 * Time: 10:24 PM
 */

namespace WordWrap\Admin;


use WordWrap\Assets\View\View;
use WordWrap\Configuration\Page;
use WordWrap\Configuration\Task;
use WordWrap\LifeCycle;

abstract class TaskController {

    /**
     * @var LifeCycle the current running instance of LifeCycle
     */
    protected $lifeCycle;

    /**
     * @var AdminController the configuration of this task
     */
    protected $adminController;

    /**
     * @var Task the task that this controller is represented by
     */
    protected $task;

    /**
     * @param LifeCycle $lifeCycle the current running life cycle of this plugin
     * @param AdminController $adminController the configuration for this controller
     * @param Task $task the configuration for this controller
     */
    public function __construct(LifeCycle $lifeCycle, AdminController $adminController, Task $task = null) {

        $this->lifeCycle = $lifeCycle;
        $this->adminController = $adminController;
        $this->task = $task;

        $action = $this->checkAction();

        $this->processRequest($action);
    }

    /**
     * Checks whether or not there is currently an action being carrying out
     * @return string the action the user is carrying out
     */
    private function checkAction() {
        $action = null;
        if(isset($_POST["action"]))
            $action = $_POST["action"];
        elseif(isset($_GET["action"]))
            $action = $_GET["action"];

        if($action && !in_array($action, $this->task->actions))
            $action = null;

        return $action;
    }

    /**
     * override this to setup anything that needs to be done before
     * @param $action string the action the user is trying to complete
     */
    public abstract function processRequest($action = null);

    /**
     * @return string the content of the page to render
     */
    public final function renderPageContent() {

        $hasSidebar = $this->task != null && $this->task->sidebar;

        if($hasSidebar)
            $pageContentContainer = new View($this->lifeCycle, "admin_page_with_sidebar", "admin_html");
        else
            $pageContentContainer = new View($this->lifeCycle, "admin_page_without_sidebar", "admin_html");


        $pageContentContainer->setTemplateVar("content", $this->renderMainContent());

        if($hasSidebar)
            $pageContentContainer->setTemplateVar("sidebar", $this->renderSidebarContent());

        return $pageContentContainer->export();
    }

    /**
     * override to render the main page
     */
    protected abstract function renderMainContent();


    /**
     * override to render the main page
     */
    protected abstract function renderSidebarContent();

    /**
     * Override this in child controllers in order to specify a different task name
     * @return string checks to see if a task name is set and returns empty string if it is not
     */
    public function getTaskName() {
        if($this->task != null)
            return $this->task->name;

        return "";
    }
}