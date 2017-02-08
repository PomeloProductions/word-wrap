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
    public $className = null;

    /**
     * @var string the prefix for any options either tables or wp_options
     */
    public $databaseNameSpace;

    /**
     * @var null|Admin the configuration for the admin section of the site or null if there is no admin
     */
    public $Admin = null;

    /**
     * @var AssetLocation[] an array of all asset locations that word wrap will initialize
     */
    public $AssetLocation = [];

    /**
     * @var ShortCode[] any short codes that have been defined in configuration
     */
    public $ShortCode = [];

    /**
     * @var Model[] any models defined inside of configuration
     */
    public $Model = [];
}