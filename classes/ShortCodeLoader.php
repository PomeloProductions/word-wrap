<?php
/*
    "WordPress Plugin Template" Copyright (C) 2015 Michael Simpson  (email : michael.d.simpson@gmail.com)

    This file is part of WordPress Plugin Template for WordPress.

    WordPress Plugin Template is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    WordPress Plugin Template is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with Contact Form to Database Extension.
    If not, see http://www.gnu.org/licenses/gpl-3.0.html
*/
namespace WordWrap;

use Exception;

abstract class ShortCodeLoader {

    /**
     * @var LifeCycle the lifecycle of the plugin
     */
    var $lifeCycle;

    /**
     * @param LifeCycle $lifeCycle the current running plugin lifecycle
     */
    public function __construct(LifeCycle $lifeCycle) {
        $this->lifeCycle = $lifeCycle;
    }

    /**
     * @param  $shortcodeName mixed either string name of the shortcode
     * (as it would appear in a post, e.g. [shortcodeName])
     *
     * @return void
     */
    public function register($shortcodeName) {

        add_shortcode($shortcodeName, array($this, 'handleShortCodeWrapper'));

        add_action('wp_footer', array($this, 'addScript'));
    }

    /**
     * takes the attributes for the shortcode and sends them to depricated handleShortCode function to see if it returns
     * null, if it returns null then plugin is NOT using deprecated function, so we then call onShortcode. Return which
     * ever has a value. If exception is thrown in plugin, it will end up in catch statement.
     *
     * @param $atts
     * @return string
     */
    public final function handleShortcodeWrapper($atts){
        try{
            $handleShortCode = $this->handleShortcode($atts);
            if($handleShortCode != null) {
                return $handleShortCode;
            }

            return $this->onShortcode($atts);

        }catch(Exception $e){
            exit($e->getMessage());
        }
    }
    /**
     * @deprecated Override this function and add actual shortcode handling here
     * @param  $atts array shortcode inputs
     * @return string shortcode content
     */
    public function handleShortcode($atts){
        return null;
    }

    /**
     * Override this function and add actual shortcode handling here
     * @param  $atts array shortcode inputs
     * @return string shortcode content
     */
    public abstract function onShortcode($atts);
    public abstract function addScript();

}
