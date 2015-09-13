<?php
namespace WordWrap\Admin\Task;
use WordWrap\Admin\TaskController;
use WordWrap\Configuration\Task;

/**
 * Created by PhpStorm.
 * User: bryce
 * Date: 9/12/15
 * Time: 1:01 PM
 */
class AvailableTasks extends TaskController {


    /**
     * @var Task[] all available taks for the current page
     */
    private $availableTask;

    /**
     * override this to setup anything that needs to be done before
     */
    public function setup() {
        $availableTask = $this->adminController->currentPage->Task;
    }

    /**
     * override to render the main page
     */
    public function renderMainContent() {
        //TODO render all tasks in a list
    }

    /**
     * override to render the main page
     */
    public function renderSidebarContent() {
        // TODO: Implement renderSidebarContent() method.
    }
}