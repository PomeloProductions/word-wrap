<?php
/**
 * Created by PhpStorm.
 * User: bryce
 * Date: 3/10/17
 * Time: 1:55 AM
 */

namespace WordWrap\Configuration;


class CrudColumn extends Base
{

    /**
     * @var string The name of the column
     */
    public $name;

    /**
     * @var string|null The value to display if the field value is true
     */
    public $trueValue = null;

    /**
     * @var string|null The value to display if the field value is false
     */
    public $falseValue = null;

    /**
     * @var bool Whether or not this column is an image field
     */
    public $isImage = false;
}