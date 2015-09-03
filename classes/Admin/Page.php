<?php
/**
 * Created by PhpStorm.
 * User: bryce
 * Date: 9/2/15
 * Time: 10:24 PM
 */

namespace WordWrap\Admin;


abstract class Page {

    /**
     * override to render this page
     */
    public abstract function render();
}