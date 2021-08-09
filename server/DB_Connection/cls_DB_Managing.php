<?php

/**
 * Created by PhpStorm.
 * User: 49176
 * Date: 27.04.2021
 * Time: 22:22
 */

require_once('./util/helper.php');
include_once('./models/tbl_tables.php');
include_once('./models/tbl_tables_columns.php');

class cls_DB_Managing extends cls_DB_Object
{

  #region general protected Function
  /**
   * creat New Tabel
   * @param String $tableName
   * @param Boolean $adderColumns = false, if true then add adderUser ana TS
   * @param String $idColumn = 'bigint' or 'int'
   *
   * @return Boolean
   */
  protected function creatNewTable($tableName, $adderColumns = false, $idColumn = 'bigint')
  {
    global $database;
    if (!$this->isTableExist($tableName)) {
      $sql = 'CREATE TABLE `' . $tableName . '` ( id ';
      $sql .= strtoupper($idColumn) == 'INT' ? 'INT' : 'bigint';
      $sql .= '(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY';
      if ($adderColumns) {
        $sql .= ', adderUser VARCHAR(50) NOT NULL DEFAULT \'\' , TS VARCHAR(20) NOT NULL DEFAULT \'\' ';
      }
      $sql .= ' )';
      $database->query($sql);
      return ($database->affected_rows() == 1) ? true : false;
    } else {
      return true;
    }
  }

  /**
   * is Table exist
   * @param String $tableName
   *
   * @return Boolean
   */
  protected function isTableExist($tableName)
  {
    global $database;
    $this->changeConfirm_query(false);
    $tableName = $database->escape_value($tableName);

    $sql = 'SELECT 1 FROM ' . $tableName . ' limit 1';
    $result_set = $database->query($sql);
    $this->changeConfirm_query(true);
    if ($result_set) {
      return true;
    } else {
      return false;
    }
  }

  /**
   * get all Tables
   *
   * @return array of Tables name
   */
  protected function getAllTables()
  {
    $sql = 'SHOW TABLES';
    $result_set = self::find_by_sql($sql, false);
    $return = array();
    foreach ($result_set as $value) {
      foreach ($value as $v) {
        $return[] = $v;
      }
    }
    return $return;
  }

  protected function getAllTriggers()
  {
    $sql = 'SHOW TRIGGERS';
    $result_set = self::find_by_sql($sql, false);
    return $result_set;
  }

  /**
   * if a table don have adderUser ana TS, then add adderColumns
   * @param String $tableName
   *
   * @return Boolean
   */
  protected function addAdderColumns($tableName)
  {
    if ($this->creatNewTable($tableName, false)) {
      if (!$this->ifAdderColumnsExist($tableName)) {
        global $database;
        $sql = 'ALTER TABLE `' . $tableName . '` ADD `adderUser` VARCHAR(50) NOT NULL , ADD `TS` VARCHAR(20) NOT NULL AFTER `adderUser`';
        $database->query($sql);
        return true;
      }
    }
    return true;
  }

  /**
   * add new column in a table in data base (mysql)
   * @param String $tableName name of table
   * @param String $columnsName name of column
   * @param $arrayColumnsInfo
   * @param string $addAfterColumn
   */
  protected function addNewColumn($tableName, $columnsName, $arrayColumnsInfo, $addAfterColumn = '')
  {
    global $database;
    $tableName = $database->escape_value($tableName);
    $columnsName = $database->escape_value($columnsName);
    if (empty($this->ifColumnNameExist($tableName, $columnsName))) {
      $newColumnInfo = join(' ', $arrayColumnsInfo);
//      $newColumnInfo = '';
//      if (gettype($arrayColumnsInfo) == 'string') {
//        $newColumnInfo = $database->escape_value($arrayColumnsInfo) . ' ';
//      } else if (gettype($arrayColumnsInfo) == 'array') {
//        for ($i = 0; $i < count($arrayColumnsInfo); $i++) {
//          $newColumnInfo .= $database->escape_value($arrayColumnsInfo[$i]) . ' ';
//        }
//      }
      $lastColumnName = $this->ifAdderColumnsExist($tableName);
      if (!empty($lastColumnName) && empty($addAfterColumn)) {
        $newColumnInfo .= ' AFTER `' . $lastColumnName . '`';
      } else if ($addAfterColumn != '') {
        $newColumnInfo .= ' AFTER `' . $addAfterColumn . '`';
      }

      if ($this->creatNewTable($tableName, false)) {
        $sql = 'ALTER TABLE `' . $tableName . '` ADD `' . $columnsName . '` ' . $newColumnInfo;
        $database->query($sql);
      }
    }
  }

  protected function addIndexToColumnOfTable($tableName, $columnsName)
  {
    global $database;
    $tableName = $database->escape_value($tableName);
    $columnsName = $database->escape_value($columnsName);
    if ($this->isTableExist($tableName)) {
      $sql = 'ALTER TABLE `' . $tableName . '` ADD INDEX(`' . $columnsName . '`)';
      $database->query($sql);
    }
  }

  protected function addUniqueToColumnOfTable($tableName, $columnsName)
  {
    global $database;
    $tableName = $database->escape_value($tableName);
    $columnsName = $database->escape_value($columnsName);
    if ($this->isTableExist($tableName)) {
      $sql = 'ALTER TABLE `' . $tableName . '` ADD UNIQUE(`' . $columnsName . '`)';
      $database->query($sql);
    }
  }

  protected function creatTriggerTable($tableName)
  {
    $txtTableName = 'tableName';
    $columnsName = 'columnsName';
    $tableName = $tableName . '_trigger' ;
    if (!$this->isTableExist($tableName)) {
      $this->creatNewTable($tableName, true);
      $clmN = array();
      $clmN[] = array($txtTableName => 'idTable', $columnsName => array('bigint(11) COLLATE utf8_unicode_ci NOT NULL'));
      $clmN[] = array($txtTableName => 'act', $columnsName => array('varchar(10) COLLATE utf8_unicode_ci NOT NULL'));
      $clmN[] = array($txtTableName => 'oldData', $columnsName => array('LONGTEXT COLLATE utf8_unicode_ci NOT NULL'));

      for ($i = 0; $i < count($clmN); $i++) {
        $this->addNewColumn($tableName, $clmN[$i][$txtTableName], $clmN[$i][$columnsName], $i != 0 ? $clmN[$i - 1]['tableName'] : 'id');
      }
      $this->addIndexToColumnOfTable($tableName, $clmN[0][$txtTableName]);
      $this->addIndexToColumnOfTable($tableName, $clmN[1][$txtTableName]);
      $this->addIndexToColumnOfTable($tableName, 'adderUser');
    }
  }


  /**
   * delete Trigger
   * @param string $triggerName
   * @return bool|mysqli_result
   */
  protected function deleteTrigger($triggerName)
  {
    global $database;
    $sqlDrop = 'DROP TRIGGER IF EXISTS `' . $triggerName . '`;';
    $result_set = $database->query($sqlDrop);
    return $result_set;
  }

  protected function deleteAllTriggers()
  {
    $allTriggers = $this->getAllTriggers();
    foreach ($allTriggers as $eachTrigger) {
      $this->deleteTrigger($eachTrigger['Trigger']);
    }
  }

  /**
   * @param $tableName
   * @param $act
   * @param $allTrigger
   * @param $allFieldsOfTable
   * @return bool|mysqli_result
   */
  protected function writeTrigger($tableName, $act, $allTrigger, $allFieldsOfTable)
  {
    global $database;

    $tableNameTrigger = $tableName . '_trigger' ;
    $triggerName = $act . '_' . $tableName;
    $arraySearchTrigger = findItemInArrayOfObject($allTrigger, 'Trigger', $triggerName);

    $sql = 'CREATE TRIGGER `' . $triggerName . '` BEFORE ' . $act . ' ON `' . $tableName . '` FOR EACH ROW insert into ' . $tableNameTrigger . ' VALUES (null,old.id,\'' . $act . '\',CONCAT(';
    foreach ($allFieldsOfTable as $v) {
      $sql .= '\'/' . $v['Field'] . ':\',old.' . $v['Field'] . ',';
    }
    $sql = substr($sql, 0, -1);
    $sql .= '),';
    if (strtolower($act) == 'update') {
      $sql .= 'new.adderUser';
    } else {
      $sql .= '\'\'';
    }
    $sql .= ', NOW())';

    if (count($arraySearchTrigger) > 0) {
      $this->deleteTrigger($triggerName);
    }
    $result_set = $database->query($sql);
    return $result_set;
  }

  /**
   * @param $tableName
   */
  protected function makeTextFileForTable($tableName){
    $strTableName = 'tableName';
    $field = 'Field';
    $findAllColumnsOfTables = $this->getAllColumnsOfTable($tableName);
    $itemTbl = new tbl_tables_columns();
    $searchArray = array('tableName' => $tableName);
    $findArrayOfItemTbl = $itemTbl->find_by_attribute($searchArray);
    $arrayTemp = array();
    foreach ($findAllColumnsOfTables as $v) {
      $arrayTemp[$v[$field]] =  findItemInArrayOfObject($findArrayOfItemTbl, 'field', $v[$field])['headerFilter'];
    }
    writeFieldsOfTables($tableName, json_encode($arrayTemp));
  }

  /**
   * write All Triggers For One Table
   * @param $tableName
   * @param array $allTriggersName
   */
  protected function writeAllTriggersForOneTable($tableName, $allTriggersName = array()){
    if (count($allTriggersName) == 0){
      $allTriggersName =  $this->getAllTriggers();
    }
    $allFieldsOfTable = $this->getAllColumnsOfTable($tableName);
    $this->writeTrigger($tableName, 'UPDATE', $allTriggersName, $allFieldsOfTable);
    $this->writeTrigger($tableName, 'DELETE', $allTriggersName, $allFieldsOfTable);
  }

  #endregion

  #region extra fuction for all Table

  /**
   * add AdderColumns To All Tables
   */
  protected function addAdderColumnsToAllTables()
  {
    $resultGetAllTables = $this->getAllTables();
    foreach ($resultGetAllTables as $value) {
      $this->addAdderColumns($value);
    }
  }

  /**
   * create table of tables
   * @return bool
   */
  protected function createTableOfTables()
  {
    $tableName = 'tbl_tables';

    $this->creatNewTable($tableName, true, 'INT');

    $clmN = array();
    $clmN[] = array('tableName' => 'name', 'columnsName' => array('varchar(50) COLLATE utf8_unicode_ci NOT NULL'));
    $clmN[] = array('tableName' => 'lastChangeDate', 'columnsName' => array('date NOT NULL'));

    for ($i = 0; $i < count($clmN); $i++) {
      $this->addNewColumn($tableName, $clmN[$i]['tableName'], $clmN[$i]['columnsName'], $i != 0 ? $clmN[$i - 1]['tableName'] : 'id');
    }

    $this->addUniqueToColumnOfTable($tableName, 'name');

    return true;
  }

  /**
   * create table of columns
   * @return bool
   */
  protected function createTableOfColumns()
  {
    $tableName = 'tbl_tables_columns';
    $columnName = 'culumnName';
    $colunmInfo = 'columnInfo';
    $this->creatNewTable($tableName, true,);

    $clmN = array();
    $clmN[] = array($columnName => 'tableName', $colunmInfo => array('varchar(50) COLLATE utf8_unicode_ci NOT NULL'));
    $clmN[] = array($columnName => 'field', $colunmInfo => array('varchar(50) COLLATE utf8_unicode_ci NOT NULL'));
    $clmN[] = array($columnName => 'type', $colunmInfo => array('varchar(50) COLLATE utf8_unicode_ci NOT NULL'));
    $clmN[] = array($columnName => 'null', $colunmInfo => array('tinyint(1) NOT NULL'), 'id');
    $clmN[] = array($columnName => 'key', $colunmInfo => array('varchar(10) COLLATE utf8_unicode_ci NOT NULL'));
    $clmN[] = array($columnName => 'default', $colunmInfo => array('varchar(50) COLLATE utf8_unicode_ci NOT NULL'));
    $clmN[] = array($columnName => 'extra', $colunmInfo => array('varchar(50) COLLATE utf8_unicode_ci NOT NULL'));
    $clmN[] = array($columnName => 'headerFilter', $colunmInfo => array('TINYINT NOT NULL DEFAULT \'1\''));

//    ALTER TABLE `tbl_tables_columns` ADD `headerFilter` TINYINT NOT NULL DEFAULT '1' AFTER `extra`;

    for ($i = 0; $i < count($clmN); $i++) {
      $this->addNewColumn($tableName, $clmN[$i][$columnName], $clmN[$i][$colunmInfo], $i != 0 ? $clmN[$i - 1][$columnName] : 'id');
    }

    $this->addIndexToColumnOfTable($tableName, $clmN[0][$columnName]);
    $this->addIndexToColumnOfTable($tableName, $clmN[1][$columnName]);

    return true;
  }

  /**
   * fill Table Of Tables
   */
  protected function fillTableOfTables()
  {
    $tableName = 'tbl_tables';
    if (!$this->isTableExist($tableName)) {
      $this->createTableOfTables();
    }
    $resultGetAllTables = $this->getAllTables();
    $item = new tbl_tables();
    $tableOfTablesItems = $item->select(false);

    $tableNameArray = makeArrayOfColumnFromArrayOfObject($tableOfTablesItems, 'name');
    foreach ($tableNameArray as $v)
    {
      if (!in_array($v, $resultGetAllTables)){
        $item = new tbl_tables();
        $item->name = $v;
        $item->delete();
      }
    }
    foreach ($resultGetAllTables as $v) {
      if (!in_array($v, $tableNameArray)) {
        $item = new tbl_tables();
        $item->name = $v;
        $item->changeConfirm_query(false);
        $item->save();
      }
    }
  }

  protected function fillOneTableOfColumns($tableName){

    $columnsInfo = $this->getAllColumnsOfTable($tableName);
    $itemTables_columns = new tbl_tables_columns();
    $attributeArray = array('tableName' => $tableName);
    $findAllColumnsOfTables = $itemTables_columns->find_by_attribute($attributeArray);
    $return = array();
    foreach ($findAllColumnsOfTables as $v) {
      $delete = false;
      $tmp = findItemInArrayOfObject($columnsInfo,'Field', $v['field'] );
      if (count($tmp) == 0){
        $delete = true;
      } else if($tmp['Type'] != $v['type'] ){
        $delete = true;
      }
      if ($delete){

        $item = new tbl_tables_columns();
        $item->id = $v['id'];
        $item->delete();
      }
    }
    foreach ($columnsInfo as $v) {
      $save = true;
      $item = new tbl_tables_columns();
      $item->tableName = $tableName;
      $item->field = $v['Field'];
      $item->type = $v['Type'];
      $item->null = $v['Null'];
      $item->key = $v['Key'];
      $item->default = $v['Default'] ? $v['Default'] : '' ;
      $item->extra = $v['Extra'];
      $strType = strtolower($v['Type']);
      if ($strType == 'date') {
        $item->headerFilter = "2";
      } else if (strPosition($strType, 'char') >= 0  || strPosition($strType, 'text') >= 0   ) {
        $item->headerFilter = "1";
      } else {
        $item->headerFilter = "0";
      }
      $findRowInColumnsOfTables = findItemInArrayOfObject($findAllColumnsOfTables, 'field', $v['Field']);
      if (!empty($findRowInColumnsOfTables)) {
        //todo agar hame mavared moshabeh bud save nakonad
        $item->id = $findRowInColumnsOfTables['id'];
      }
      $item->changeConfirm_query(false);
      if ($save){
//       return  json_encode($item->save());
        $item->save();
      }
      $item->changeConfirm_query(true);
    }
  }

  /**
   * fill Table Of Columns
   *
   * @return bool
   */
  protected function fillAllTableOfColumns()
  {
    //    set_time_limit(300);
    $tableName = 'tbl_tables_columns';
    if (!$this->isTableExist($tableName)) {
      $this->createTableOfColumns();
    }

    $allTables = $this->getAllTables();
    foreach ($allTables as $value) {
      $this->fillOneTableOfColumns($value);
    }
    return true;
  }

  /**
   *make trigger Table for all Tables
   */
  protected function createTriggerTableForAllTables()
  {
    $allTables = $this->getAllTables();
    foreach ($allTables as $eachTable) {
      if (strpos($eachTable, 'trigger') === false) {
        $this->creatTriggerTable($eachTable);
      }
    }
  }

  /**
   * write Trigger rule for all Tables
   */
  protected function writeAllTriggers()
  {
    $this->createTriggerTableForAllTables();
    $allTriggersName = $this->getAllTriggers();
    $allTables = $this->getAllTables();
    foreach ($allTables as $eachTable) {
      if (strpos($eachTable, 'trigger') === false) {//todo joda kardan 7 charakter akhar va moghaayese kardn.
        $this->writeAllTriggersForOneTable($eachTable,$allTriggersName);
      }
    }
  }

  /**
   * write textFiles for all Tables
   * @return bool
   */
  protected function writeForAllTablesTextFile()
  {
    $allTables = $this->getAllTables();
    foreach ($allTables as $eachTable) {
      $this->makeTextFileForTable($eachTable);
    }
    return true;
  }

  #endregion



  public function doGeneralManaging()
  {
  }

  public function changeToTS()
  {
    global $database;
    $this->changeConfirm_query(false);
    //get all table
    $allTables = $this->getAllTables();
    foreach ($allTables as $eachTable) {
      $sql = 'ALTER TABLE `'.$eachTable.'` CHANGE `adderDateTime` `TS` VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL';
      $database->query($sql);

    }
    $this->changeConfirm_query(true);

  }

  public function  changeDateBase()
  {
    //CREATE TABLE tbl_telc_member LIKE tbl_telcmember
//    INSERT INTO tbl_telc_member SELECT * FROM tbl_telcmember
    return 'salam mama';
  }

  public  function test()
  {
    $return = $this->changeToTS();


    return json_encode($return);
  }
}
