<?php
/**
 * Created by PhpStorm.
 * User: bryce
 * Date: 1/21/16
 * Time: 10:35 PM
 */

namespace WordWrap\Configuration;


class ShortCode {

    /**
     * @var string the name of this short code, which will be what the user puts into the editor as the short code
     *      i.e. this value being set to 'word_wrap' would cause the short code [word_wrap] to be triggered
     */
    public $name;

    /**
     * @var string the class name for the short code being represented
     */
    public $className;
}