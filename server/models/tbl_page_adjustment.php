<?php
/**
 * Created by PhpStorm.
 * User: 49176
 * Date: 22.09.2021
 * Time: 17:44
 */

class tbl_page_adjustment extends generalModels
{
  protected static $table_name = 'tbl_page_adjustment';


  function __construct()
  {
    parent::__construct(self::$table_name);
  }

  public function saveAdjustment(){
//    $this->user = getUser();
//    cls_DB_Object::fillVariable();
//    $attributeArray = array('user' => $this->user,
//      'page' => $this->page);
    $result = $this->selectByUser();
    if (!empty($result)){
      $this->id = $result[0]['id'];
    }
    return cls_DB_Object::save();
  }

  public function selectByUser(){
    $this->user = getUser();
    cls_DB_Object::fillVariable();
    $attributeArray = array('user' => $this->user,
      'page' => $this->page);
    $result = cls_DB_Object::find_by_attribute($attributeArray);
    return $result;
  }

  public function selectAllAdjustmentByUser(){
    $this->user = getUser();
    $attributeArray = array('user' => $this->user);
    $result = cls_DB_Object::find_by_attribute($attributeArray);
    return $result;
  }

}