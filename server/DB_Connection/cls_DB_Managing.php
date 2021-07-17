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
   * @param Boolean $adderColumns = false, if true then add adderUser ana adderDateTime
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
        $sql .= ', adderUser VARCHAR(50) NOT NULL DEFAULT \'\' , adderDateTime VARCHAR(20) NOT NULL DEFAULT \'\' ';
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
   * if a table don have adderUser ana adderDateTime, then add adderColumns
   * @param String $tableName
   *
   * @return Boolean
   */
  protected function addAdderColumns($tableName)
  {
    if ($this->creatNewTable($tableName, false)) {
      if (!$this->ifAdderColumnsExist($tableName)) {
        global $database;
        $sql = 'ALTER TABLE `' . $tableName . '` ADD `adderUser` VARCHAR(50) NOT NULL , ADD `adderDateTime` VARCHAR(20) NOT NULL AFTER `adderUser`';
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
      $newColumnInfo = '';
      if (gettype($arrayColumnsInfo) == 'string') {
        $newColumnInfo = $database->escape_value($arrayColumnsInfo) . ' ';
      } else if (gettype($arrayColumnsInfo) == 'array') {
        for ($i = 0; $i < count($arrayColumnsInfo); $i++) {
          $newColumnInfo .= $database->escape_value($arrayColumnsInfo[$i]) . ' ';
        }
      }
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


    //    DROP INDEX c2 ON t
    //    ALTER TABLE `t` ADD UNIQUE(`c2`);
    //    ALTER TABLE `diwan`.`t` DROP INDEX `c2_31`, ADD UNIQUE `c2_3` (`c2`) USING BTREE;
    //    ALTER TABLE `tbl_tables` ADD UNIQUE(`name`)

    //    SHOW TRIGGERS LIKE 'tbl_exam_date'
  }

  protected function creatTriggerTable($tableName)
  {
    $txtTableName = 'tableName';
    $columnsName = 'columnsName';
    $tableName = 'trigger_' . $tableName;
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
    $triggerName = $act . '_' . $tableName;
    $arraySearchTrigger = findItemInArrayOfObject($allTrigger, 'Trigger', $triggerName);

    $sql = 'CREATE TRIGGER `' . $triggerName . '` BEFORE ' . $act . ' ON `' . $tableName . '` FOR EACH ROW insert into trigger_' . $tableName . ' VALUES (null,old.id,\'' . $act . '\',CONCAT(';
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
    $arrayTemp = makeArrayOfColumnFromArrayOfObject($findAllColumnsOfTables, $field);
    writeFieldsOfTables($tableName, join(',', $arrayTemp));
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
    $this->creatNewTable($tableName, true,);

    $clmN = array();
    $clmN[] = array('tableName' => 'tableName', 'columnsName' => array('varchar(50) COLLATE utf8_unicode_ci NOT NULL'));
    $clmN[] = array('tableName' => 'field', 'columnsName' => array('varchar(50) COLLATE utf8_unicode_ci NOT NULL'));
    $clmN[] = array('tableName' => 'type', 'columnsName' => array('varchar(50) COLLATE utf8_unicode_ci NOT NULL'));
    $clmN[] = array('tableName' => 'null', 'columnsName' => array('tinyint(1) NOT NULL'), 'id');
    $clmN[] = array('tableName' => 'key', 'columnsName' => array('varchar(10) COLLATE utf8_unicode_ci NOT NULL'));
    $clmN[] = array('tableName' => 'default', 'columnsName' => array('varchar(50) COLLATE utf8_unicode_ci NOT NULL'));
    $clmN[] = array('tableName' => 'extra', 'columnsName' => array('varchar(50) COLLATE utf8_unicode_ci NOT NULL'));

    for ($i = 0; $i < count($clmN); $i++) {
      $this->addNewColumn($tableName, $clmN[$i]['tableName'], $clmN[$i]['columnsName'], $i != 0 ? $clmN[$i - 1]['tableName'] : 'id');
    }

    $this->addIndexToColumnOfTable($tableName, $clmN[0]['tableName']);
    $this->addIndexToColumnOfTable($tableName, $clmN[1]['tableName']);

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
    //    foreach ($tableOfTablesItems as $value) {
    //      $tableNameArray[] = $value['name'];
    //    }

    foreach ($resultGetAllTables as $v) {
      if (!in_array($v, $tableNameArray)) {
        $item = new tbl_tables();
        $item->name = $v;
        $item->changeConfirm_query(false);
        $item->save();
      }
    }
  }

  /**
   * fill Table Of Columns
   *
   * @return bool
   */
  protected function fillTableOfColumns()
  {
    //    set_time_limit(300);
    $tableName = 'tbl_tables_columns';
    if (!$this->isTableExist($tableName)) {
      $this->createTableOfColumns();
    }
    $this->fillTableOfTables();
    $itemTables = new tbl_tables();
    $tableOfTablesItems = $itemTables->select(false);
    foreach ($tableOfTablesItems as $value) {
      $columnsInfo = $this->getAllColumnsOfTable($value['name']);

      $itemTables_columns = new tbl_tables_columns();
      $attributeArray = array('tableName' => $value['name']);
      $findAllColumnsOfTables = $itemTables_columns->find_by_attribute($attributeArray);
      foreach ($columnsInfo as $v) {
        $item = new tbl_tables_columns();
        $item->tableName = $value['name'];
        $item->field = $v['Field'];
        $item->type = $v['Type'];
        $item->null = $v['Null'];
        $item->key = $v['Key'];
        $item->default = $v['Default'];
        $item->extra = $v['Extra'];
        $findRowInColumnsOfTables = findItemInArrayOfObject($findAllColumnsOfTables, 'field', $v['Field']);
        if (!empty($findRowInColumnsOfTables)) {
          $item->id = $findRowInColumnsOfTables['id'];
        }
        $item->changeConfirm_query(false);
        $item->save();
        $item->changeConfirm_query(true);
      }
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
      if (strpos($eachTable, 'trigger') === false) {//todo joda kardan 7 charakter aval va moghaayese kardn.
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

  public function creatTableByUser($tableName)
  {


  }

  public function  changeDateBase()
  {
    //CREATE TABLE tbl_telc_member LIKE tbl_telcmember
//    INSERT INTO tbl_telc_member SELECT * FROM tbl_telcmember
    return 'salam mama';
  }

  public  function test()
  {
    $return = $this->makeTextFileForTable('tbl_exam_type');


    return json_encode($return);
  }
}
