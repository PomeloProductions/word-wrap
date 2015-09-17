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
     * @var RequiredAssets[] any required assets needed for this admin css assets will be dumped before html,
     *                          js assets will be dumped after html
     */
    public $RequiredAssets = [];

}