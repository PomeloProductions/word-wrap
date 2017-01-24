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
class RootConfig extends Base {


    /**
     * @var string the name of this plugin
     */
    public $pluginName;

    /**
     * @var string the name of the root NameSpace of this plugin
     */
    public $rootNameSpace;

    /**
     * @var string the name that the user sees when interacting with this plugin
     */
    public $displayName;

    /**
     * @var string the minimum php version that this plugin requires to run
     */
    public $minPHPVersion;

    /**
     * @var LifeCycle the configuration that details the lifecycle declaration of this plugin
     */
    public $LifeCycle;

}