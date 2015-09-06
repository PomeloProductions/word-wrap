<?php
/**
 * Created by PhpStorm.
 * User: bryce
 * Date: 9/3/15
 * Time: 12:42 AM
 */

namespace WordWrap\Configuration;


class Task extends Base {

    /**
     * @var string the name of the task
     */
    public $name;

    /**
     * @var string the full class name of the task, which needs to include the full name space
     */
    public $className;

    /**
     * @var bool whether or not to render the sidebar for this task
     */
    public $sidebar;

    /**
     * @var bool whether or not this is the default task, or we will list all other tasks
     */
    public $default;

    /**
     * @return string the slug for this menu
     */
    public function getSlug() {
        return strtolower( str_replace(" ", "_", $this->name) );
    }
}