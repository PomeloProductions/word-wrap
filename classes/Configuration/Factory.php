<?php
/**
 * Created by PhpStorm.
 * User: bryce
 * Date: 5/3/15
 * Time: 10:27 PM
 */

namespace WordWrap\Configuration;

use \Exception;
/**
 * This class is what will handle the parsing of the configuration json, and storing of it
 *
 * Class Factory
 * @package WordWrap\Configuration
 */

class Factory {


    /**
     * @param $pluginName string the name of the plugin that we are reading the configuration for
     * @throws Exception The json file should be located at the root of the plugin, and it should be named info.json
     *                      if it isn't then we have no idea what this plugin is about
     * @return Base We will be constructing an instance of our Base configuration and returning it
     */
    public static function inflate($pluginName) {

    }

    //TODO create a function to write out an instance of base to file
}