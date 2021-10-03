<?php
/**
 * Created by PhpStorm.
 * User: 49176
 * Date: 14.07.2021
 * Time: 16:54
 */
require_once('cls_Managing_Version.php');

class cls_version_1_1_2 extends cls_Managing_Version
{

  private $version = '1_1_2';
  private $description = '';//todo write the description

  public function doVersion()
  {
//    return $this->writeForAllTablesTextFile();
//    return $this->fillOneTableOfColumns('tbl_page_adjustment');
//    return $this->writeForAllTablesTextFile();
    if ($this->checkLastVersion($this->version, $this->description) ) {
      $this->addAdderColumnsToAllTables();
      $this->createTableOfTables();
      $this->createTableOfColumns();
      $this->writeAllTriggers();
      $this->fillTableOfTables();
      $this->fillAllTableOfColumns();
      $this->writeForAllTablesTextFile();
    }
  }
}