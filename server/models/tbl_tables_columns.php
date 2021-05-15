<?php
/**
 * Created by PhpStorm.
 * User: 49176
 * Date: 13.05.2021
 * Time: 16:37
 */

class tbl_tables_columns extends cls_DB_Object
{
  protected static $table_name = 'tbl_tables_columns';
  protected static $db_fields = array('id', 'tableName', 'field', 'type', 'null', 'key', 'default', 'extra', 'adderUser', 'adderDateTime');

  function __construct()
  {
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
  public function setShowFields(){
    for ($i = 0; $i < count(self::$db_fields); $i++) {
      array_push($this->showFields, self::$db_fields[$i]);
    }
    return $this->showFields;
  }
}
{

}