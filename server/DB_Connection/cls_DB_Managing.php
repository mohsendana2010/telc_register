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

  #region protected Function
  /**
   * creat New Tabel
   * @param String $tableName
   * @param Boolean $adderColumns = false, if true then add adderUser ana adderDateTime
   * @param String $idColumn = 'bigint' or 'int'
   *
   * @return Boolean
   */
  private function creatNewTable($tableName, $adderColumns = false, $idColumn = 'bigint')
  {
    global $database;
    if (!$this->isTableExist($tableName)) {
      $sql = 'CREATE TABLE `' . $tableName . '` ( id ';
      $sql .= strtoupper($idColumn) == 'INT' ? 'INT' : 'bigint';
      $sql .= '(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY';
      if ($adderColumns) {
        $sql .= ', adderUser VARCHAR(50) NOT NULL, adderDateTime VARCHAR(20) NOT NULL ';
      }
      $sql .= ' )';
      $database->query($sql);
      return ($database->affected_rows() == 1) ? true : false;
    } else {
      return true;
    }


    //    $result_set = $database->query($sql);
    //    $object_array = array();
    //    while ($row = $database->fetch_assoc($result_set)) {
    //      $object_array[] = self::instantiate($row);
    //    }
    //    return json_encode($object_array);

    //      $sql = 'DROP TABLE ' .  $tableName;
    //      $database->query($sql);

    //    if ($object_array[0]->1 == "1")

    //    ALTER TABLE `tbl_tables_columns` ADD `null` TINYINT NOT NULL AFTER `type`, ADD `key` VARCHAR(100) NOT NULL AFTER `null`, ADD `default` VARCHAR(50) NOT NULL AFTER `key`, ADD `extra` VARCHAR(100) NOT NULL AFTER `default`;

    //
  }

  /**
   * is Table exist
   * @param String $tableName
   *
   * @return Boolean
   */
  private function isTableExist($tableName)
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
  private function getAllTables()
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

  private function getAllTriggers()
  {
    $sql = 'SHOW TRIGGERS';
    $result_set = self::find_by_sql($sql, false);
    return $result_set;
  }

  /**
   * look for column 'adderUser' if there is
   *
   * @param String $tableName name of table
   *
   * @return array  gives last name of found column, or leer String
   */
  private function getAllColumnsOfTable($tableName)
  {
    global $database;
    $tableName = $database->escape_value($tableName);
    $sql = 'SHOW COLUMNS FROM ' . $tableName;
    return self::find_by_sql($sql, false);
  }

  /**
   * look for column 'adderUser' if there is
   * @param String $tableName name of table
   *
   * @return gives last name of found column, or leer String
   */
  private function ifAdderColumnsExist($tableName)
  {
    return $this->ifColumnNameExist($tableName, 'adderUser');
  }

  /**
   * look for column if there is
   *
   * @param String $tableName name of table
   * @param String $columnName name of column
   *
   * @return String gives last name of found column, or leer String
   */
  private function ifColumnNameExist($tableName, $columnName)
  {
    global $database;
    $tableName = $database->escape_value($tableName);
    $result_set = $this->getAllColumnsOfTable($tableName);
    for ($i = 0; $i < count($result_set); $i++) {
      if ($result_set[$i]['Field'] == $columnName) {
        return $result_set[$i - 1]['Field'];
      }
    }
    return '';
  }

  /*
   * if a table don have adderUser ana adderDateTime, then add adderColumns
   * @param String $tableName
   *
   * @return Boolean
   */
  private function addAdderColumns($tableName)
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

  private function addAdderColumnsForAllTables()
  {
    $allTables = $this->getAllTables();
    foreach ($allTables as $eachTable) {
      $this->addAdderColumns($eachTable);
    }
  }


  /**
   * add new column in a table in data base (mysql)
   * @param String $tableName name of table
   * @param String $columnsName name of column
   * @param $arrayColumnsInfo
   * @param string $addAfterColumn
   */
  private function addNewColumn($tableName, $columnsName, $arrayColumnsInfo, $addAfterColumn = '')
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

  private function addIndexToColumnOfTable($tableName, $columnsName)
  {
    global $database;
    $tableName = $database->escape_value($tableName);
    $columnsName = $database->escape_value($columnsName);
    if ($this->isTableExist($tableName)) {
      $sql = 'ALTER TABLE `' . $tableName . '` ADD INDEX(`' . $columnsName . '`)';
      $database->query($sql);
    }
  }

  private function addUniqueToColumnOfTable($tableName, $columnsName)
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

  private function creatTriggerTable($tableName)
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
        $this->addNewColumn($tableName, $clmN[$i]['tableName'], $clmN[$i]['columnsName'], $i != 0 ? $clmN[$i - 1]['tableName'] : 'id');
      }

      $this->addIndexToColumnOfTable($tableName, $clmN[0][$txtTableName]);
      $this->addIndexToColumnOfTable($tableName, $clmN[1][$txtTableName]);
      $this->addIndexToColumnOfTable($tableName, 'adderUser');
    }
  }

  private function createTriggerTableForAllTables()
  {
    $allTables = $this->getAllTables();
    foreach ($allTables as $eachTable) {
      if (strpos($eachTable, 'trigger') === false) {
        $this->creatTriggerTable($eachTable);
      }
    }
  }

  /**
   * delete Trigger
   * @param string $triggerName
   * @return bool|mysqli_result
   */
  private function deleteTrigger($triggerName)
  {
    global $database;
    $sqlDrop = 'DROP TRIGGER IF EXISTS `' . $triggerName . '`;';
    $result_set = $database->query($sqlDrop);
    return $result_set;
  }

  private function deleteAllTriggers()
  {
    $allTriggers = $this->getAllTriggers();
    foreach ($allTriggers as $eachTrigger) {
      $this->deleteTrigger($eachTrigger['Trigger']);
    }
  }

  private function writeTrigger($tableName, $act, $allTrigger, $allFieldsOfTable)
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

  #endregion


  private function createTableOfTables()
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

  private function createTableOfColumns()
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
  private function fillTableOfTables()
  {
    $tableName = 'tbl_tables';
    if (!$this->isTableExist($tableName)) {
      $this->createTableOfTables();
    }
    $resultGetAllTables = $this->getAllTables();
    $item = new tbl_tables();
    $tableOfTablesItems = $item->find_all(false);

    $tableNameArray = makeArrayOfColumnInArrayOfObject($tableOfTablesItems, 'name');
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
  private function fillTableOfColumns()
  {
    //    set_time_limit(300);
    $tableName = 'tbl_tables_columns';
    if (!$this->isTableExist($tableName)) {
      $this->createTableOfColumns();
    }
    $this->fillTableOfTables();
    $itemTables = new tbl_tables();
    $tableOfTablesItems = $itemTables->find_all(false);
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
   * add AdderColumns To All Tables
   */
  private function addAdderColumnsToAllTables()
  {
    $resultGetAllTables = $this->getAllTables();
    foreach ($resultGetAllTables as $value) {
      $this->addAdderColumns($value);
    }
  }

  private function makeForAllTablesTextFile()
  {
    $tableName = 'tableName';
    $filed = 'field';
    $allTables = $this->getAllTables();
    foreach ($allTables as $eachTable) {
      $itemTables_columns = new tbl_tables_columns();
      $attributeArray = array($tableName => $eachTable);
      $findAllColumnsOfTables = $itemTables_columns->find_by_attribute($attributeArray);

      $arrayTemp = makeArrayOfColumnInArrayOfObject($findAllColumnsOfTables, $filed);
      writeFieldsOfTables($eachTable, join(',', $arrayTemp));
    }
  }

  private function writeAllTriggers()
  {
    $this->createTriggerTableForAllTables();
    $allTriggers = $this->getAllTriggers();
    $allTables = $this->getAllTables();
    foreach ($allTables as $eachTable) {
      if (strpos($eachTable, 'trigger') === false) {
        $allFieldsOfTable = $this->getAllColumnsOfTable($eachTable);
        $this->writeTrigger($eachTable, 'UPDATE', $allTriggers, $allFieldsOfTable);
        $this->writeTrigger($eachTable, 'DELETE', $allTriggers, $allFieldsOfTable);
      }
    }
  }


  public function doGeneralManaging()
  {
    $this->addAdderColumnsToAllTables();
    $this->fillTableOfColumns();
    $this->makeForAllTablesTextFile();
    $this->writeAllTriggers();
  }

  public function creatTableByUser($tableName)
  {


  }

  public function test()
  {

    //      return $this->addAdderColumnsToAllTables();
    //    $itemTables_columns = new tbl_tables_columns();
    //    $attributeArray = array('tableName' => 'tbl_exam_type');
    //    $findAllColumnsOfTables = $itemTables_columns->find_by_attribute($attributeArray);
    //
    //    $arrayTemp = makeArrayOfColumnInArrayOfObject($findAllColumnsOfTables, 'field');
    //
    //    writeFieldsOfTables('tbl_exam_type', join(',', $arrayTemp));
    //    readFieldsOfTables('tbl_exam_type');

    //    $return = $this->writeAllTriggers();
    //    $return = $this->fillTableOfColumns();
    //    $return = $this->addAdderColumnsForAllTables();
    $return = $this->doGeneralManaging();

    //    $return = '';
    //    $allTables = $this->getAllTables();
    //    foreach ($allTables as $eachTable) {
    //      if (strpos($eachTable, 'trigger') === false) {
    //        $return .= ' '. $eachTable;
    //      }
    //    }


    return $return;
  }
}
