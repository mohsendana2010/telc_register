<?php
/**
 * Created by PhpStorm.
 * User: 49176
 * Date: 22.06.2021
 * Time: 08:12
 */

include_once('./DB_Connection/cls_DB_Object.php');
require_once('./util/helper.php');

class generalModels extends cls_DB_Object
{
  protected static $table_name ;
  protected static $db_fields ;
  protected static $db_txtFields;

  public static $instance_count = 0;
  public static $sql_count = 0;
  public $authorization;
  public $showFields = array();

  function __construct($TableName)
  {
    self::$table_name = $TableName;
    self::$db_fields = readFieldsOfTables(self::$table_name);
    self::$db_txtFields = readTxtFieldsOfTable(self::$table_name);
    foreach (self::$db_fields as $key)
    {
      $this->{$key} = null;
    }
    $this->authorization = authorizationVerify();
    try{
      if (isset($this->authorization)) {
        if (isset($this->authorization->user)) {
          $this->adderUser = $this->authorization->user;
        }
      }
    } catch (Exception $ex){}
  }


  public function save()
  {
    if (isset($this->authorization->access)) {
      if ($this->authorization->access) {
        return parent::save();
      }
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
    if ($this->authorization->access) {
    $field = makeFindAllFields($this->fields());
    return parent::select($jsonEncode, $field );
    }
  }

  public function fields()
  {
    for ($i = 0; $i < count(self::$db_fields); $i++) {
      if (strpos(self::$db_fields[$i], 'adder') === false && self::$db_fields[$i] != 'TS' ){
        array_push($this->showFields, self::$db_fields[$i]);
      }
    }
    return ($this->showFields);
  }

  public function headerFilter(){
    $headerFilter = ($this->fields());
    $tempHeaderFilter = array();
    foreach ($headerFilter as $v){
      $tempHeaderFilter[] = self::$db_txtFields[$v];
    }
    return ($tempHeaderFilter);
  }
}