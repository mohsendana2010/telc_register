<?php
/**
 * Created by PhpStorm.
 * User: 49176
 * Date: 29.10.2020
 * Time: 17:27
 */

include_once('./DB_Connection/cls_DB_Object.php');

class tbl_exam_type extends cls_DB_Object
{
  protected static $table_name = "tbl_exam_type";
  protected static $db_fields = array("id", "language", "type", "subtype", "description");

  public $id;
  public $language;
  public $type;
  public $subtype;
  public $description;

  public static $instance_count = 0;
  public static $sql_count = 0;


  public function save()
  {
//    validation() ;     // TODO: Change the autogenerated stub

    return parent::save();
  }

  public $showFields = [];
  public function setShowFields(){
    for ($i = 0; $i < count(self::$db_fields); $i++) {
      array_push($this->showFields, self::$db_fields[$i]);
    }
  }


}