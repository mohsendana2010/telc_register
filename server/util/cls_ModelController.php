<?php
/**
 * Created by PhpStorm.
 * User: 49176
 * Date: 30.10.2020
 * Time: 15:03
 */

require_once('./models/tbl_exam_date.php');
require_once('./models/tbl_exam_type.php');

class cls_ModelController
{
  public function insertExamType()
  {
    $item = new tbl_exam_type();
    return $item->save();
  }

  public function selectExamType()
  {
    $item = new tbl_exam_type();
    return $item->find_all();
  }                    

  public function insertExamDate()
  {
    $item = new tbl_exam_date();
    $item->fillVariable()  ;
    return $item->save();
  }

  


}

$ModelController = new cls_ModelController();