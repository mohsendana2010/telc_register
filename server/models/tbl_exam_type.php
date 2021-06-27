<?php
/**
 * Created by PhpStorm.
 * User: 49176
 * Date: 29.10.2020
 * Time: 17:27
 */

include_once('./DB_Connection/cls_DB_Object.php');
require_once('./util/helper.php');

class tbl_exam_type extends cls_DB_Object
{
  protected static $table_name = 'tbl_exam_type';
  protected static $db_fields ;
//    = array('id', 'language', 'type', 'subtype', 'description');

  function __construct()
  {
    self::$db_fields = readFieldsOfTables(self::$table_name);
    foreach (self::$db_fields as $key)
    {
      $this->{$key} = null;
    }
  }

  public static $instance_count = 0;
  public static $sql_count = 0;
  public $authorization;


  public function save()
  {
    if ($this->authorization->access) {
      return parent::save();
    }
  }

  public function delete()
  {
    if ($this->authorization->access) {
      return parent::delete();
    }
  }

  public function select($jsonEncode = true, $field = '*')
  {
//    if ($this->authorization->access) {
    $field = makeFindAllFields(json_decode($this->fields()));
      return parent::select($jsonEncode, $field );
//    }
  }



  public $showFields = [];

  public function fields()
  {
    for ($i = 0; $i < count(self::$db_fields); $i++) {
      if (strpos(self::$db_fields[$i], 'adder') === false){
        array_push($this->showFields, self::$db_fields[$i]);
      }
    }
    return json_encode($this->showFields);
  }


}