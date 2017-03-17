<?php
/**
 * Created by PhpStorm.
 * User: bryce
 * Date: 9/16/15
 * Time: 11:32 PM
 */

namespace WordWrap\Configuration;


class RequiredAssets extends Base{

    /**
     * @var string the type of asset this is
     */
    public $type;

    /**
     * @var string the name of the required asset
     */
    public $name;

    /**
     * @var bool Whether or not to include this directly on the page, or use the built in enque functionality
     */
    public $outputOnPage = false;

}