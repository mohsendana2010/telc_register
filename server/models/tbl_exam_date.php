<?php
/**
 * Created by PhpStorm.
 * User: 49176
 * Date: 29.10.2020
 * Time: 17:12
 */
include_once('./DB_Connection/cls_DB_Object.php');

class tbl_exam_date extends cls_DB_Object
{
  protected static $table_name = "tbl_exam_date";
  protected static $db_fields = array("id", "writingExamDate", "speakingExamData",
    "registrationDeadline", "lastRegistrationDeadline", "examTypes");


  public $id;
  public $writingExamDate;
  public $speakingExamData;
  public $registrationDeadline;
  public $lastRegistrationDeadline;
  public $examTypes;

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

  public function find_all()
  {
//    if ($this->authorization->access) {
      return parent::find_all();
//    }
  }

  public $showFields = [];

  public function setShowFields()
  {
    for ($i = 0; $i < count(self::$db_fields); $i++) {
      array_push($this->showFields, self::$db_fields[$i]);
    }
    return $this->showFields;
  }

}