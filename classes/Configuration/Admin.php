<?php
/**
 * Created by PhpStorm.
 * User: bryce
 * Date: 9/2/15
 * Time: 7:34 PM
 */

namespace WordWrap\Configuration;


class Admin extends Base {

    /**
     * @var Page[] all admin menu's associated with this plugin
     */
    public $Page;

    /**
     * @var AssetSet[]|null all assets needed for the admin or null if none where created
     */
    public $AssetSet = null;

}