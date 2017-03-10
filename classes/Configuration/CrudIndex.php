<?php
/**
 * Created by PhpStorm.
 * User: bryce
 * Date: 3/10/17
 * Time: 1:48 AM
 */

namespace WordWrap\Configuration;


class CrudIndex extends Base
{

    /**
     * @var string the class name of the model that this crud index is for
     */
    public $modelClass;

    /**
     * @var string the task name connected to the details link
     */
    public $viewTask;

    /**
     * @var string The display name of the model
     */
    public $displayName;

    /**
     * @var string\bool The action for creation, or false if none is allowed
     */
    public $createAction = false;

    /**
     * @var CrudColumn[] the columns to display on the main index
     */
    public $CrudColumn;
}