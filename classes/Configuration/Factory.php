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
     * @return Root We will be constructing an instance of our Root configuration and returning it
     */
    public static function inflate($pluginName) {
        $path = get_home_path() . "wp-content/plugins/" . $pluginName . "/info.json";
        if(!file_exists($path))
            throw new Exception("Unable to find plugin configuration. Please make sure that you have a info.json included in the root of your plugin");

        $fileContents = file_get_contents($path);
        $json = json_decode($fileContents, true);

        return new Root($json);
    }

    //TODO create a function to write out an instance of base to file
}