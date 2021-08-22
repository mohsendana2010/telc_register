<?php
/**
 * Created by PhpStorm.
 * User: 49176
 * Date: 13.05.2021
 * Time: 16:37
 */

include_once('./DB_Connection/cls_DB_Object.php');
require_once('./util/helper.php');

class tbl_tables_columns extends generalModels
{
  protected static $table_name = 'tbl_tables_columns';

  function __construct()
  {
    parent::__construct(self::$table_name);
  }



}