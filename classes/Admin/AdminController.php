<?php

/**
 * Created by PhpStorm.
 * User: bryce
 * Date: 9/2/15
 * Time: 7:54 PM
 */

namespace WordWrap\Admin;

use WordWrap\Configuration\Admin;
use WordWrap\Configuration\AdminMenu;
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

    public function __construct(LifeCycle $lifeCycle, Admin $admin) {
        $this->lifeCycle = $lifeCycle;
        $this->admin = $admin;

        add_action( 'admin_menu', [$this, "addMenus"] );
    }

    /**
     * adds Menus to the sidebar of the admin
     */
    public function addMenus() {

        foreach($this->admin->AdminMenu as $menu) {
            \add_menu_page('Theme Page Title', $menu->name, $menu->capability, $menu->getSlug(), [$this, 'renderPage'], $menu->icon, $menu->position);
        }
    }

    /**
     * Called from internal word press when we need to display the requested page
     */
    public function renderPage() {

        $this->lifeCycle->assetManager->registerAssetType("admin_html", __DIR__ . "/../assets/html/");

        $currentPage = isset($_GET["page"]) ? $_GET["page"] : "";

        foreach ($this->admin->AdminMenu as $menu) {
            if ($menu->getSlug() == $currentPage) {
                $defaultTask = null;

                $currentTask = isset($_GET["task"]) ? $_GET["task"] : "";
                //TODO trigger task to run find default if task is not in get show list of available tasks if no default is defined
            }
        }

    }

}