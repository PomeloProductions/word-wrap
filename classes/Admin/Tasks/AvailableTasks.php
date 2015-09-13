<?php
namespace WordWrap\Admin\Tasks;
use WordWrap\Admin\TaskController;
use WordWrap\Configuration\Task;
use WordWrap\View\Anchor;
use WordWrap\View\ViewCollection;

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
     * @var string the slug of this page
     */
    private $pageSlug;

    /**
     * override this to setup anything that needs to be done before
     */
    public function setup() {
        $this->availableTask = $this->adminController->getCurrentPage()->Task;
        $this->pageSlug = $this->adminController->getCurrentPage()->getSlug();
    }

    public function getTaskName() {
        return "Available Tasks";
    }

    /**
     * override to render the main page
     */
    protected function renderMainContent() {
        $viewCollection = new ViewCollection($this->lifeCycle, "available_task/container", "admin_html");

        foreach($this->availableTask as $task) {
            $anchor = new Anchor($this->lifeCycle);

            $href = "?page=$this->pageSlug&task=" . $task->getSlug();

            $anchor->setContent($task->name);
            $anchor->setHref($href);
            $anchor->addClass("block_link");

            $viewCollection->addChildView("task_link", $anchor);
        }

        return $viewCollection->export();
    }

    /**
     * override to render the main page
     */
    protected function renderSidebarContent() {
        // TODO: Implement renderSidebarContent() method.
    }
}