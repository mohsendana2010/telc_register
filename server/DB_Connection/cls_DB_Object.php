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

  /**
   * find all of Table
   * @param Boolean $jsonEncode = true
   * @param string $field
   *
   * @return String  if $jsonEncode = true
   */
  public function select($jsonEncode = true, $field = '*')
  {
    return self::find_by_sql('SELECT ' . $field . ' FROM ' . static::$table_name, $jsonEncode);
  }

  /**
   * @param int $id
   * @param string $field
   *
   * @return array
   */
  public static function find_by_id($id = 0, $field = '*')
  {
    global $database;
    $result_array = self::find_by_sql('SELECT ' . $field . ' FROM ' . static::$table_name . ' WHERE id =' . $database->escape_value($id) . ' ', false);
    return !empty($result_array) ? $result_array : array();
  }

  /**
   * find by attribute
   *
   * @param Array (attributeName => value)
   *
   * @return array of find Items
   */
  public function find_by_attribute($attributeArray)
  {
    global $database;
    $whereString = "";
    if (gettype($attributeArray) == "array") {
      $keys = array_keys($attributeArray);
      $value = array_values($attributeArray);
      for ($i = 0; $i < count($attributeArray); $i++) {
        $whereString .= " " . $database->escape_value($keys[$i]) . " = '" . $database->escape_value($value[$i]) . "' ";
        if ($i < count($attributeArray) - 1) {
          $whereString .= "and";
        }
      }
      $return = array();
      $result_array = self::find_by_sql("SELECT * FROM " . static::$table_name . " WHERE {$whereString} ", false);
      if (!empty($result_array)) {
        $return = $result_array;
      }
      return $return;
    }

  }

  public static function find_by_sql($sqlQuery = "", $jsonEncode = true)
  {
    global $database;
    $result_set = $database->query($sqlQuery);
    $object_array = array();
    while ($row = $database->fetch_assoc($result_set)) {
      $object_array[] = self::instantiate($row);
    }
    if ($jsonEncode) {

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
        if ($this->$fields == null || $this->$fields == '') {
          $this->$fields = $_POST[$fields];
        }
      }
      if (!empty($this->ifAdderColumnsExist(static::$table_name))) {
//        if (isset($this->TS)) {
          $this->TS = date('Y-m-d H:i:s');
          if (isset($this->authorization->user)){
            $this->adderUser = $this->authorization->user ;
          }
//        }
      }
    }
  }
  public function test(){

    if (!empty($this->ifAdderColumnsExist(static::$table_name))) {
      if (isset($this->TS)) {
        return 'mohsen jun';
        $this->TS = date('Y-m-d H:i:s');
//          $this->adderUser = $this->authorization->firstName . ' ' . $this->authorization->lastName;
      }else {

        return static::$db_fields;
      }
    }
  }

  public function attributes()
  {
    // return an arrya of attribute keys and their values
    $attribute = [];
    foreach (static::$db_fields as $field) {
      if (property_exists($this, $field)) {
        if (isset($this->$field)) {
          $attribute[$field] = $this->$field;
        }
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

  protected function save()
  {
    $this->fillVariable();
    return isset($this->id) ? $this->update() : $this->create();
  }

  /**
   * @return bool
   */
  private function create()
  {
    global $database;
    //do not forget your SQL syntax and good habits
    $attribute = $this->sanitized_attributes();
//    array_shift($attribute);
    $sql = 'INSERT INTO `' . static::$table_name . '` (`';
    $sql .= join('`, `', array_keys($attribute));
    $sql .= "`) VALUES ('";
    $sql .= join("', '", array_values($attribute));
    $sql .= "')";
    if ($database->query($sql)) {
      $this->id = $database->insert_id();
      return true;
    } else {
      return false;
    }
  }

  private function update()
  {
    global $database;
    $attribute = $this->sanitized_attributes();
    $attribute_pairs = [];
    foreach ($attribute as $key => $value) {
      $attribute_pairs[] = "`$key` = '{$value}'";
    }
    $id = array_shift($attribute_pairs);
    $sql = 'UPDATE `' . static::$table_name . '` SET ';
    $sql .= join(', ', $attribute_pairs);
    $sql .= ' WHERE ';
    $sql .= $id;
    $database->query($sql);
    return ($database->affected_rows() == 1) ? true : false;
  }

  protected function delete()
  {
    global $database;
    $this->fillVariable();
    $attribute = $this->sanitized_attributes();
    $attribute_pairs = array();
    foreach ($attribute as $key => $value) {
      if ($key != 'TS' && $key != 'adderUser')
        $attribute_pairs[] = "`$key` = '{$value}'";
    }

    $sql = "DELETE FROM " . static::$table_name;
    $sql .= " WHERE ";//id= " . $database->escape_value($this->id);
    if ($this->id != null && $this->id >= 0 ) {
      $sql .= "id=" . $database->escape_value($this->id);
    } else if (count($attribute_pairs) > 0) {
      $sql .= join(' and ', $attribute_pairs);
    }

    $database->query($sql);
    return ($database->affected_rows() == 1) ? true : false;
  }

  /**
   * change Confirm Query of Database, that dont die the qury
   *
   * @param  Boolean $confirm_query
   */
  protected function changeConfirm_query($confirm_query)
  {
    global $database;
    $database->confirm_query = $confirm_query;
  }


  /**
   * look for column 'adderUser' if there is
   * @param String $tableName name of table
   *
   * @return String gives last name of found column, or leer String
   */
  public function ifAdderColumnsExist($tableName)
  {
    return $this->ifColumnNameExist($tableName, 'adderUser');
  }

  /**
   * look for column if there is
   *
   * @param String $tableName name of table
   * @param String $columnName name of column
   *
   * @return String gives last name of found column, or leer String
   */
  protected function ifColumnNameExist($tableName, $columnName)
  {
    global $database;
    $tableName = $database->escape_value($tableName);
    $result_set = $this->getAllColumnsOfTable($tableName);
    for ($i = 0; $i < count($result_set); $i++) {
      if ($result_set[$i]['Field'] == $columnName) {
        return $result_set[$i - 1]['Field'];
      }
    }
    return '';
  }

  /**
   * look for column 'adderUser' if there is
   * @param String $tableName name of table
   *
   * @return array  gives last name of found column, or leer String
   */
  protected function getAllColumnsOfTable($tableName)
  {
    global $database;
    $tableName = $database->escape_value($tableName);
    $sql = 'SHOW COLUMNS FROM ' . $tableName;
    return self::find_by_sql($sql, false);
  }


}