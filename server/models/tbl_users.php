<?php
/**
 * Created by PhpStorm.
 * User: 49176
 * Date: 31.01.2021
 * Time: 14:45
 */
include_once('./DB_Connection/cls_DB_Object.php');
require_once('./util/helper.php');

class tbl_users extends cls_DB_Object
{
  protected static $table_name = 'tbl_users';
  protected static $db_fields ;
//  = array('id', 'firstName', 'lastName', 'user', 'password', 'access');

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
      if (isset($_POST['password'])) {
        $encrypt = new cls_Encryption();
        $this->password = $encrypt->encryptHashPassword($_POST['password']);
      }
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
    if ($this->authorization->access) {
      return parent::select($jsonEncode, $field);
    }
  }

  public $showFields = [];

  public function fields()
  {
    for ($i = 0; $i < count(self::$db_fields); $i++) {
      array_push($this->showFields, self::$db_fields[$i]);
    }
    return json_encode($this->showFields);
  }

}