<?php
/**
 * Created by PhpStorm.
 * User: 49176
 * Date: 11.05.2021
 * Time: 23:24
 */
include_once('./DB_Connection/cls_DB_Object.php');
require_once('./util/helper.php');

class tbl_tables extends cls_DB_Object
{
  protected static $table_name = 'tbl_tables';
  protected static $db_fields ;//= array('id', 'name', 'lastChangeDate',  'adderUser', 'adderDateTime');

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
    return parent::save();
  }

  public $showFields = [];
  public function fields(){
    for ($i = 0; $i < count(self::$db_fields); $i++) {
      array_push($this->showFields, self::$db_fields[$i]);
    }
    return json_encode($this->showFields);
  }
}