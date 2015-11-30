<?php
/**
 * Created by PhpStorm.
 * User: bryce
 * Date: 11/29/15
 * Time: 11:50 PM
 */

namespace WordWrap\Assets\Template\Mustache;


use Mustache_Engine;

class MustacheFactory {

    private static $mustacheEngine;

    /**
     * @return Mustache_Engine the current instance of our mustache engine
     */
    public function getMustacheEngine() {

        if (static::$mustacheEngine == null)
            static::$mustacheEngine = new Mustache_Engine();

        return static::$mustacheEngine;
    }

}