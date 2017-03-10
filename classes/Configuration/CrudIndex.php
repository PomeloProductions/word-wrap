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
     * @var CrudColumn[] the columns to display on the main index
     */
    public $CrudColumn;
}