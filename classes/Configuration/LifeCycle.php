<?php
/**
 * Created by PhpStorm.
 * User: bryce
 * Date: 5/3/15
 * Time: 11:07 PM
 */

namespace WordWrap\Configuration;


class LifeCycle extends Base {

    /**
     * @var string the class name of this plugins LifeCycle
     */
    public $className;

    /**
     * @var string the prefix for any options either tables or wp_options
     */
    public $optionsPrefix;

    /**
     * @var Admin the configuration for the admin section of the site
     */
    public $Admin;

    /**
     * @var AssetLocation[]|null an array of all asset locations that word wrap will initialize
     */
    public $AssetLocation;
}