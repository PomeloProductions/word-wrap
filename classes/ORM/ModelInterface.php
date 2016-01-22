<?php
/**
 * Created by PhpStorm.
 * User: bryce
 * Date: 5/3/15
 * Time: 2:55 AM
 */

namespace WordWrap\ORM;

/**
 * Interface for ORM models.
 *
 * @author Brandon Wamboldt <brandon.wamboldt@gmail.com>
 */
interface ModelInterface {
    /**
     * Overwrite this in your concrete class. Returns the table name used to
     * store models of this class.
     *
     * @return string the table name without a prefix
     */
    public static function getTableName();

    /**
     * Get an array of fields to search during a search query.
     *
     * @return array
     */
    public static function getSearchableFields();

    /**
     * Get an array of all fields for this Model with a key and a value
     * The key should be the name of the column in the database and the value should be the structure of it
     *
     * @return array
     */
    public static function getFields();
}