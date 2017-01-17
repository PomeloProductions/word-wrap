<?php
/*
    "WordPress Plugin Template" Copyright (C) 2015 Michael Simpson  (email : michael.d.simpson@gmail.com)

    This file is part of WordPress Plugin Template for WordPress.

    WordPress Plugin Template is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    WordPress Plugin Template is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with Contact Form to Database Extension.
    If not, see http://www.gnu.org/licenses/gpl-3.0.html
*/


use WordWrap\Configuration\ConfigFactory;
use WordWrap\LifeCycle;

class WordWrap {

    public static function init($pluginDirectory) {


        $fullPath = ABSPATH . "wp-content/plugins/" . $pluginDirectory;
        $configInstance = ConfigFactory::inflate($fullPath);

        if ($configInstance->LifeCycle->className) {
            $lifeCycleClass = $configInstance->rootNameSpace . "\\" . $configInstance->LifeCycle->className;

            $aPlugin = new $lifeCycleClass($configInstance, $fullPath);
        }
        else {
            $aPlugin = new LifeCycle($configInstance, $fullPath);
        }

        // Install the plugin
        // NOTE: this file gets run each time you *activate* the plugin.
        // So in WP when you "install" the plugin, all that does it dump its files in the plugin-templates directory
        // but it does not call any of its code.
        // So here, the plugin tracks whether or not it has run its install operation, and we ensure it is run only once
        // on the first activation
        if (!$aPlugin->isInstalled()) {
            $aPlugin->install();
        } else if ($aPlugin->isInstalledCodeAnUpgrade()) {
            // Perform any version-upgrade activities prior to activation (e.g. database changes)
            $aPlugin->upgrade();
        }

        // Add callbacks to hooks
        $aPlugin->initActionsAndFilters();

        // Register the Plugin Activation Hook
        register_activation_hook(__FILE__, array(&$aPlugin, 'activate'));


        // Register the Plugin Deactivation Hook
        register_deactivation_hook(__FILE__, array(&$aPlugin, 'deactivate'));
    }
}
