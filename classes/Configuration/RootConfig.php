<?php
/**
 * Created by PhpStorm.
 * User: bryce
 * Date: 5/3/15
 * Time: 11:07 PM
 */

namespace WordWrap\Configuration;

/**
 * Class RootConfig the root of all info.json files
 * @package WordWrap\Configuration
 */
class RootConfig extends Base{

    /**
     * @var RootConfig
     * @deprecated replace usages with instance reference in LifeCycle
     */
    public static $instance;

    /**
     * @var string the name of this plugin
     */
    public $pluginName;

    /**
     * @var string the name of the root NameSpace of this plugin
     */
    public $rootNameSpace;

    /**
     * @var LifeCycle the configuration that details the lifecycle declaration of this plugin
     */
    public $LifeCycle;

    /**
     * @var string the prefix for any options either tables or wp_options
     */
    public $optionsPrefix;

    /**
     * @var Admin the configuration for the admin section of the site
     */
    public $Admin;


}