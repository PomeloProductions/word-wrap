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

class Controller {

    public function __construct(Admin $admin) {
        $this->addMenus($admin->AdminMenus);
    }

    /**
     * @param AdminMenu[] $menus all menus this admin requires
     */
    private function addMenus(array $menus) {

        foreach($menus as $menu) {
            $slug = strtolower( str_replace(" ", "_", $menu->name) );
            add_menu_page('Theme Page Title', $menu->name, $menu->capability, $slug, [$this, 'renderPage'], $menu->icon, $menu->position);
        }
    }

    public function renderPage() {

    }

}