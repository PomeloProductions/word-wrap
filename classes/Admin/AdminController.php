<?php

/**
 * Created by PhpStorm.
 * User: bryce
 * Date: 9/2/15
 * Time: 7:54 PM
 */

namespace WordWrap\Admin;

use WordWrap\Admin\Tasks\AvailableTasks;
use WordWrap\Assets\StyleSheet\CSS;
use WordWrap\Assets\View\View;
use WordWrap\Configuration\Admin;
use WordWrap\Configuration\Page;
use WordWrap\LifeCycle;

class AdminController {

    /**
     * @var LifeCycle the current running LifeCycle
     */
    private $lifeCycle;
    /**
     * @var Admin the configuration for this controllers configuration
     */
    private $admin;

    /**
     * @var Page the current page that is being used
     */
    private $currentPage;

    public function __construct(LifeCycle $lifeCycle, Admin $admin) {
        $this->lifeCycle = $lifeCycle;
        $this->admin = $admin;

        add_action( 'admin_menu', [$this, "addMenus"] );
    }

    /**
     * adds Menus to the sidebar of the admin
     */
    public function addMenus() {

        foreach($this->admin->Page as $page) {
            \add_menu_page('Theme Page Title', $page->name, $page->capability, $page->getSlug(), [$this, 'renderPage'], $page->icon, $page->position);
        }
    }

    /**
     * Called from internal word press when we need to display the requested page
     */
    public function renderPage() {

        foreach($this->admin->RequiredAssets as $requiredAsset) {
            if($requiredAsset->type == "css") {
                $asset = new CSS($this->lifeCycle, $requiredAsset->name);

                echo $asset->export();
            }
        }

        $this->lifeCycle->assetManager->registerAssetType("admin_html", __DIR__ . "/../../assets/html/");

        $pageContainer = new View($this->lifeCycle, "admin_container", "admin_html");

        if($this->getCurrentPage() == null) {

            $pageContainer->setTemplateVar("page_title", "Page Not Found");

            //TODO render default page
        }
        else {

            $defaultTask = null;
            $currentTask = null;
            $taskController = null;

            $requestedTask = isset($_GET["task"]) ? $_GET["task"] : "";


            $pageContainer->setTemplateVar("page_title", $this->currentPage->name);

            foreach ($this->getCurrentPage()->Task as $task) {
                if($task->default)
                    $defaultTask = $task;
                if($task->getSlug() == $requestedTask) {
                    $currentTask = $task;
                    break;
                }
            }

            if($currentTask == null && $defaultTask != null)
                $currentTask = $defaultTask;

            if($currentTask == null) {
                $taskController = new AvailableTasks($this->lifeCycle, $this);
            }
            else {
                if(strpos($currentTask->className, "\\") === 0)
                    $taskClass = $this->lifeCycle->rootConfig->rootNameSpace . $currentTask->className;
                else
                    $taskClass = $currentTask->className;
                $taskController = new $taskClass($this->lifeCycle, $this, $currentTask);
            }

            $pageContainer->setTemplateVar("task_title", $taskController->getTaskName());
            $pageContainer->setTemplateVar("task_content", $taskController->renderPageContent());
        }

        echo $pageContainer->export();

    }

    /**
     * @return Page|null
     */
    public function getCurrentPage() {

        if($this->currentPage == null) {
            $requestedPage = isset($_GET["page"]) ? $_GET["page"] : "";

            foreach ($this->admin->Page as $page) {
                if ($page->getSlug() == $requestedPage) {
                    $this->currentPage = $page;
                    break;
                }
            }
        }

        return $this->currentPage;
    }

}