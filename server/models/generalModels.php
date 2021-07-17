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
//    self::$db_fields = readFieldsOfTables(self::$table_name);= array('id', 'writingExamDate', 'speakingExamData',
//    'registrationDeadline', 'lastRegistrationDeadline', 'examTypes');


  function __construct($TableName)
  {
    self::$table_name = $TableName;
    self::$db_fields = readFieldsOfTables(self::$table_name);
    foreach (self::$db_fields as $key)
    {
      $this->{$key} = null;
    }
    $this->authorization = authorizationVerify();
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
    return parent::select($jsonEncode, $field);
//    }
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