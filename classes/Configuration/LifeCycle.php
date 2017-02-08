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
     * @var string|null The optional database name space that will be used as a prefix
     *                  between the global WordPress prefix, and the individual tables of this plugin.
     *                  This will also be used to name space options
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