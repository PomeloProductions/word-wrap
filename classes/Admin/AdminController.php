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

class AdminController {

    /**
     * @var Admin the configuration for this controllers configuration
     */
    private $admin;

    public function __construct(Admin $admin) {

        $this->admin = $admin;
        add_action( 'admin_menu', [$this, "addMenus"] );
    }

    /**
     */
    public function addMenus() {

        foreach($this->admin->AdminMenu as $menu) {
            $slug = strtolower( str_replace(" ", "_", $menu->name) );
            \add_menu_page('Theme Page Title', $menu->name, $menu->capability, $slug, [$this, 'renderPage'], $menu->icon, $menu->position);
        }
    }

    public function renderPage() {

    }

}