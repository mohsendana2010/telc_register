<?php
/**
 * Created by PhpStorm.
 * User: 49176
 * Date: 29.10.2020
 * Time: 17:12
 */

include_once('./DB_Connection/cls_DB_Object.php');
require_once('./util/helper.php');

class tbl_exam_date extends generalModels
{
  protected static $table_name = 'tbl_exam_date';

  function __construct()
  {
    parent::__construct(self::$table_name);
  }

  public function select($jsonEncode = true, $field = '*')
  {
//    if ($this->authorization->access) {
    $field = makeFindAllFields(parent::fields());
    return cls_DB_Object::select($jsonEncode, $field);
//    }
  }
}