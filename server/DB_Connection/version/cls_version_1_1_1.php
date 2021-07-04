<?php
/**
 * Created by PhpStorm.
 * User: 49176
 * Date: 04.07.2021
 * Time: 12:53
 */

class cls_version_1_1_1 extends cls_DB_Managing
{
  //make table of version in database

//  private function createTableOfversion()
//  {
//    $tableName = 'tbl_version';
//
//    $this->creatNewTable($tableName, true, 'INT');
//
//    $clmN = array();
//    $clmN[] = array('tableName' => 'name', 'columnsName' => array('varchar(50) COLLATE utf8_unicode_ci NOT NULL'));
//    $clmN[] = array('tableName' => 'lastChangeDate', 'columnsName' => array('date NOT NULL'));
//
//    for ($i = 0; $i < count($clmN); $i++) {
//      $this->addNewColumn($tableName, $clmN[$i]['tableName'], $clmN[$i]['columnsName'], $i != 0 ? $clmN[$i - 1]['tableName'] : 'id');
//    }
//
//    $this->addUniqueToColumnOfTable($tableName, 'name');
//
//    return true;
//  }





}