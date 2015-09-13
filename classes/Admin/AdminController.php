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
use WordWrap\Configuration\Task;
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
     * @var AdminMenu the current page that is being used
     */
    public $currentPage;

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

        if($this->currentPage == null) {
            //TODO render default page
        }
        else {

            $defaultTask = null;

            $requestedTask = isset($_GET["task"]) ? $_GET["task"] : "";

            //TODO find task to run, and then run it
        }


    }

    /**
     * @param $name string name of property called
     * @return mixed
     */
    public function __get($name) {

        switch($name)  {
            case "currentPage" :
                $requestedPage = isset($_GET["page"]) ? $_GET["page"] : "";

                foreach( $this->admin->AdminMenu as $menu) {
                    if($menu->getSlug() == $requestedPage) {
                        $this->currentPage = $menu;
                        return $this->currentPage;
                    }
                }
        }

    }

}