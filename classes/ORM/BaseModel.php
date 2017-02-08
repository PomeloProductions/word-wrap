<?php
/**
 * Created by PhpStorm.
 * User: bryce
 * Date: 5/3/15
 * Time: 2:52 AM
 */

namespace WordWrap\ORM;

use DateTime;
use Exception;


/**
 * Base class for building models.
 *
 * @author Brandon Wamboldt <brandon.wamboldt@gmail.com>
 */
abstract class BaseModel implements ModelInterface {

    /**
     * @var int the default primary key
     */
    public $id;

    /**
     * @var DateTime the time at which this model was deleted
     */
    public $deleted_at = null;

    /**
     * Get the column used as the primary key, defaults to 'id'.
     *
     * @return string
     */

    /**
     * @var array $datetimeFields - all DateTimes for a specific class (will be overridden in plugin)
     */
    protected $datetimeFields = [];

    public static function getPrimaryKey() {
        return 'id';
    }

    /**
     * Runs the create syntax for this table
     */
    public static function installTable() {

        $SQL = "CREATE TABLE IF NOT EXISTS `" .  static::getFullTableName() . "` (";
        $SQL.= "`" . static::getPrimaryKey() . "` int(11) unsigned NOT NULL AUTO_INCREMENT,";
        foreach(static::getFields() as $key => $value) {
            $SQL.= "`" . $key . "` " . $value. ",";
        }

        $SQL.= "`deleted_at` DATETIME,";

        $SQL.= "PRIMARY KEY (`" . static::getPrimaryKey(). "`)";
        $SQL.= ") ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

        global $wpdb;
        $wpdb->query($SQL);
    }

    /**
     * Updates the table from the old plugin version to the new plugin version
     *
     * @param $oldVersion
     */
    public static function updateTable($oldVersion) {

        $newFields = static::getUpdateFields($oldVersion);

        if (count($newFields)) {

            $SQL = "ALTER TABLE `" . static::getFullTableName() . "` ";

            foreach ($newFields as $key => $value) {
                $SQL.= "ADD `" . $key . "` " . $value;
            }

            global $wpdb;
            $wpdb->query($SQL);
        }
    }

    /**
     * Returns any new fields needed on an update
     *
     * @param $oldVersion
     * @return array
     */
    protected static function getUpdateFields($oldVersion) {
        return [];
    }

    /**
     * Returns the full table name for this table
     *
     * @return string
     */
    protected static function getFullTableName() {
        return static::getTablePrefix() . static::getTableName();
    }

    /**
     * Return configured table prefix.
     * @return string
     */
    public function getTablePrefix() {
        global $wpdb;
        return $wpdb->prefix;
    }

    /**
     * Constructor.
     *
     * @param array $properties
     * @param array|bool $datetimeFields @deprecated all the fields that will need to be auto converted to DateTime
     */
    public function __construct(array $properties = array(), $datetimeFields = false) {
        $model_props = $this->properties();
        $properties  = array_intersect_key($properties, $model_props);
        if($datetimeFields){
            $this->datetimeFields = $datetimeFields;
        }
        $this->datetimeFields[] = "deleted_at";

        foreach ($properties as $property => $value) {
            if($value != null) {
                if (!in_array($property, $this->datetimeFields))
                    $this->{$property} = maybe_unserialize($value);
                elseif ($value)
                    $this->{$property} = new DateTime($value);
            }
        }
    }

    /**
     * Magically handle getters and setters.
     *
     * @param  string $function
     * @param  array  $arguments
     * @return mixed
     */
    public function __call($function, $arguments) {
        // Getters following the pattern 'get_{$property}'
        if (substr($function, 0, 4) == 'get_') {
            $model_props = $this->properties();
            $property    = substr($function, 4);

            if (array_key_exists($property, $model_props)) {
                return $this->{$property};
            }
        }

        // Setters following the pattern 'set_{$property}'
        if (substr($function, 0, 4) == 'set_') {
            $model_props = $this->properties();
            $property    = substr($function, 4);

            if (array_key_exists($property, $model_props)) {
                $this->{$property} = $arguments[0];
            }
        }
    }

    /**
     * Return the value of the primary key.
     *
     * @return integer
     */
    public function primary_key() {
        return $this->{static::getPrimaryKey()};
    }

    /**
     * Get all of the properties of this model as an array.
     *
     * @return array
     */
    public function to_array() {
        return $this->properties();
    }

    /**
     * Convert complex objects to strings to insert into the database.
     *
     * @param  array $props
     * @return array
     */
    public function flatten_props($props) {
        $availableFields = static::getFields();

        $fieldNames = array_keys($availableFields);

        foreach ($props as $property => $value) {
            if(in_array($property, $fieldNames)) {

                if (is_object($value) && get_class($value) == 'DateTime') {
                    $props[$property] = $value->format('Y-m-d H:i:s');
                } elseif (is_array($value)) {
                    $props[$property] = serialize($value);
                } elseif ($value instanceof AbstractClass) {
                    $props[$property] = $value->primary_key();
                }
            }
            else
                unset($props[$property]);
        }

        return $props;
    }

    /**
     * Return an array of all the properties for this model. By default, returns
     * every class variable.
     *
     * @return array
     */
    public function properties() {
        return get_object_vars($this);
    }

    /**
     * Save this model to the database. Will create a new record if the ID
     * property isn't set, or update an existing record if the ID property is
     * set.
     *
     * @return integer
     */
    public function save() {
        global $wpdb;

        // Get the model's properties
        $props = $this->properties();

        // Flatten complex objects
        $props = $this->flatten_props($props);

        foreach($props as $key => $value) {
            if($value === null)
                unset($props[$key]);
        }

        // Insert or update?
        if (is_null($this->{static::getPrimaryKey()})) {
            $wpdb->insert($this->getFullTableName(), $props);

            $this->{static::getPrimaryKey()} = $wpdb->insert_id;
        } else {
            $wpdb->update(static::getFullTableName(), $props, array(static::getPrimaryKey() => $this->{static::getPrimaryKey()}));
        }

        return $this->id;
    }

    /**
     * Create a new model from the given data.
     *
     * @return static
     */
    public static function create($properties) {
        return new static($properties);
    }

    /**
     * Delete the model from the database. Returns true if it was successful
     * or false if it was not.
     *
     * @return boolean
     */
    public function destroy() {
        global $wpdb;

        return $wpdb->delete(static::getFullTableName(), array(static::getPrimaryKey() => $this->{static::getPrimaryKey()}));
    }

    /**
     * sets the models deleted at time to be now
     */
    public function delete() {
        $this->deleted_at = new DateTime();

        $this->save();
    }

    /**
     * Find a specific model by a given property value.
     *
     * @param  string $property
     * @param  string $value
     * @return false|static
     */
    public static function find_one_by($property, $value) {
        global $wpdb;

        // Escape the value
        $value = esc_sql($value);

        // Get the table name
        $table = static::getFullTableName();

        // Get the item
        $obj = $wpdb->get_row("SELECT * FROM `{$table}` WHERE `{$property}` = '{$value}'", ARRAY_A);

        // Return false if no item was found, or a new model
        return ($obj ? static::create($obj) : false);
    }

    /**
     * Find a specific model by it's unique ID.
     *
     * @param  integer $id
     * @return false|static
     */
    public static function find_one($id) {
        return static::find_one_by(static::getPrimaryKey(), (int) $id);
    }

    /**
     * Start a query to find models matching specific criteria.
     *
     * @return Query
     */
    public static function query() {
        $query = new Query(get_called_class());
        $query->set_searchable_fields(static::getSearchableFields());
        $query->set_primary_key(static::getPrimaryKey());

        return $query;
    }

    /**
     *
     * @param array $whereArgs all where arguments to use
     * @return static[] array of objects of called class
     * todo allow arrays to be arguments for escaping strings
     * todo allow deleted at override
     * @throws Exception if there where no where arguments passed in
     */
    public static function fetchWhere($whereArgs) {

        if (!count($whereArgs))
            throw new Exception("You must pass in at least one where argument");

        global $wpdb;
        $results = [];

        $table = static::getFullTableName();
        $whereStatement = implode(" AND ", $whereArgs);

        $SQL = "SELECT * FROM `" . $table . "` WHERE `deleted_at` IS NULL AND " . $whereStatement;

        $rows = $wpdb->get_results($SQL);

        foreach ($rows as $row)
            $results[] = static::create((array) $row);

        return $results;
    }

    /**
     * @param $SQL string the query to run
     * @return static[] array of results as objects
     */
    protected static function executeFetch($SQL) {

        global $wpdb;
        $results = [];

        $rows = $wpdb->get_results($SQL);

        foreach ($rows as $row)
            $results[] = static::create((array) $row);

        return $results;
    }

    /**
     *
     * @param $field string the field that we are ordering by
     * @param $direction string the direction of the field
     * @param string $where Any additional where that we want
     * @return static[] array of objects of called class
     * todo allow deleted at override
     */
    public static function fetchOrderedBy($field, $direction, $where = '') {

        global $wpdb;
        $results = [];

        $table = static::getFullTableName();

        $SQL = "SELECT * FROM `" . $table . "` WHERE `deleted_at` IS NULL " . $where . " ORDER BY `" . $field . "` " . $direction;

        $rows = $wpdb->get_results($SQL);

        foreach ($rows as $row)
            $results[] = static::create((array) $row);

        return $results;
    }

    /**
     * Return EVERY instance of this model from the database, with NO filtering.
     *
     * @return static[]
     */
    public static function all() {
        global $wpdb;

        // Get the table name
        $table = static::getFullTableName();

        // Get the items
        $results = $wpdb->get_results("SELECT * FROM `{$table}` WHERE `deleted_at` IS NULL");

        foreach ($results as $index => $result) {
            $results[$index] = static::create((array) $result);
        }

        return $results;
    }
}