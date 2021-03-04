<?php
/**
 * Created by PhpStorm.
 * User: 49176
 * Date: 19.10.2020
 * Time: 10:20
 */

//include_once (path::$name_connection_DB);
include_once('cls_DB_Connection.php');

class cls_DB_Object
{

  protected static $table_name;
  protected static $db_fields;

  public static function find_all()
  {
    return self::find_by_sql("SELECT * FROM " . static::$table_name, true);
  }

  public static function find_by_id($id = 0)
  {
    $result_array = self::find_by_sql("SELECT * FROM " . static::$table_name . " WHERE id = {$id} ", true);
//        $found = $database->fetch_assoc($result_array);
//        return $found;
    return !empty($result_array) ? $result_array : FALSE;
//    return !empty($result_array) ? array_shift($result_array) : FALSE;
  }

  public static function find_by_attribute($attributeArray)
  {
    $whereString = "";
    if (gettype($attributeArray) == "array") {

      $keys = array_keys($attributeArray);
      $value = array_values($attributeArray);
      for ($i = 0; $i < count($attributeArray); $i++) {
        $whereString .= " " . $keys[$i] . " = '" . $value[$i] . "' ";
        if ($i < count($attributeArray) - 1) {
          $whereString .= "and";
        }
      }
      $result_array = self::find_by_sql("SELECT * FROM " . static::$table_name . " WHERE {$whereString} ", false);

      return !empty($result_array) ? $result_array : FALSE;
    }

  }

  public static function find_by_sql($sqlQuery = "", $encode = true)
  {
    global $database;
    $result_set = $database->query($sqlQuery);
    $object_array = array();
    while ($row = $database->fetch_assoc($result_set)) {
      $object_array[] = self::instantiate($row);
    }
    if ($encode) {

      $json_array = json_encode($object_array);
      return $json_array;
    }
    return $object_array;
  }

  private static function instantiate($record)
  {
    $array = json_decode(json_encode($record), true);
    return $array;
  }

  private function has_attribute($attribute)
  {

    $object_var = $this->attributes();
    return array_key_exists($attribute, $object_var);
  }

//    public function attributes() {
//        // return an arrya of attribute keys and their values
//        return get_object_vars($this);
//    }

  public function fillVariable()
  {
    foreach (static::$db_fields as $fields) {
      if (isset($_POST[$fields])) {
        $this->$fields = $_POST[$fields];
      }
    }
  }

  public function attributes()
  {
    // return an arrya of attribute keys and their values
    $attribute = [];
    foreach (static::$db_fields as $field) {
      if (property_exists($this, $field)) {
        $attribute[$field] = $this->$field;
      }
    }
    return $attribute;
  }

  protected function sanitized_attributes()
  {
    global $database;
    $clean_attributes = array();
    //
    foreach ($this->attributes() as $key => $value) {
      $clean_attributes[$key] = $database->escape_value($value);
    }
    return $clean_attributes;
  }

  public function save()
  {
    $this->fillVariable();
    return isset($this->id) ? $this->update() : $this->create();
  }

  protected function create()
  {
    global $database;
    //do not forget your SQL syntax and good habits
    $attribute = $this->sanitized_attributes();
    array_shift($attribute);
    $sql = "INSERT INTO " . static::$table_name . " (";
    $sql .= join(", ", array_keys($attribute));
    $sql .= ") VALUES ('";
    $sql .= join("', '", array_values($attribute));
    $sql .= "')";
    if ($database->query($sql)) {
      $this->id = $database->insert_id();
      return true;
    } else {
      return false;
    }
  }

  public function update()
  {
    global $database;
    $attribute = $this->sanitized_attributes();
    $attribute_pairs = [];
    foreach ($attribute as $key => $value) {
      $attribute_pairs[] = "{$key} = '{$value}'";
    }
    $id = array_shift($attribute_pairs);
    $sql = "UPDATE " . static::$table_name . " SET ";
    $sql .= join(", ", $attribute_pairs);
    $sql .= " WHERE ";
    $sql .= $id;
    $database->query($sql);
    return ($database->affected_rows() == 1) ? true : false;
  }

  public function delete()
  {
    $this->fillVariable();
    global $database;
    $sql = "DELETE FROM " . static::$table_name;
    $sql .= " WHERE id= " . $database->escape_value($this->id);
    $database->query($sql);
    return ($database->affected_rows() == 1) ? true : false;
  }

}