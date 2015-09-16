<?php
/**
 * Created by PhpStorm.
 * User: bryce
 * Date: 9/15/15
 * Time: 11:41 PM
 */

namespace WordWrap\Configuration;


class AssetSet {

    /**
     * @var string the type of asset this is
     */
    public $type;

    /**
     * @var string the location of this set from the root of the server
     */
    public $location;

    /**
     * @var null|string the file extension of this asset type or null if it is just html, js, or css
     */
    public $fileExtension = null;

}