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


  function __construct()
  {
    parent::__construct(self::$table_name);
  }

//  public function select($jsonEncode = true, $field = '*')
//  {
////    if ($this->authorization->access) {
//    $field = makeFindAllFields($this->fields());
//    return parent::select($jsonEncode, $field );
////    }
//  }

}