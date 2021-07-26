<?php
/**
 * Created by PhpStorm.
 * User: 49176
 * Date: 04.07.2021
 * Time: 12:53
 */
require_once('cls_Managing_Version.php');

class cls_version_1_1_1 extends cls_Managing_Version
{
  //make table of version in database
  private $version = '1_1_1';
  private $description = 'make table of version in database';
  private function createTableOfVersion()
  {
    $tableName = 'tbl_version';

    $this->creatNewTable($tableName, true, 'INT');

    $clmN = array();
    $clmN[] = array('columnName' => 'version', 'columnsInfo' => array('varchar(10) COLLATE utf8_unicode_ci NOT NULL'));
    $clmN[] = array('columnName' => 'description', 'columnsInfo' => array('TEXT NOT NULL'));

    for ($i = 0; $i < count($clmN); $i++) {
      $this->addNewColumn($tableName, $clmN[$i]['columnName'], $clmN[$i]['columnsInfo'], $i != 0 ? $clmN[$i - 1]['columnName'] : 'id');
    }

    $this->extraActForTable($tableName);
    return true;
  }

  private function extraActForTable($tableName)
  {
    $this->creatTriggerTable($tableName);
    $this->writeAllTriggersForOneTable($tableName);
    $this->makeTextFileForTable($tableName);
  }

  public function doVersion()
  {
    if ($this->checkLastVersion($this->version, $this->description)){
      $this->createTableOfVersion();
    }
  }


}