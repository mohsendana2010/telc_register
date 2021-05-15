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
  /*
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

  /*
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
    $result_set = $database->query($sql, false);
    $this->changeConfirm_query(true);
    if ($result_set) {
      return true;
    } else {
      return false;
    }
  }

  /*
   * get all Tables
   *
   * @return Array of Tables name
   */
  protected function getAllTabels()
  {
    global $database;
    $sql = 'SHOW TABLES';
    $result_set = self::find_by_sql($sql, false);
    return $result_set;
//    SHOW TRIGGERS LIKE 'tbl_exam_date'
  }

  /*
   * look for column 'adderUser' if there is
   *
   * @param String $tableName name of table
   *
   * @return array  gives last name of found column, or leer String
   */
  protected function getAllColumnsOfTable($tableName)
  {
    global $database;
    $tableName = $database->escape_value($tableName);
    $sql = 'SHOW COLUMNS FROM ' . $tableName;
    return self::find_by_sql($sql, false);
  }

  /*
   * look for column 'adderUser' if there is
   * @param String $tableName name of table
   * @return gives last name of found column, or leer String
   */
  protected function ifAdderColumnsExist($tableName)
  {
    return $this->ifColumnNameExist($tableName, 'adderUser');
  }

  /*
  * look for column if there is
   *
  * @param String $tableName name of table
  * @param String $columnsName name of column
   *
  * @return  gives last name of found column, or leer String
  */
  protected function ifColumnNameExist($tableName, $columnName)
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

  /*
   * add new column in a table in data base (mysql)
   * @param String $tableName name of table
   * @param String $columnsName name of column
   * @param String or Array $arrayColumnsInfo
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

  #endregion


  public function createTableOfTables()
  {
    $tableName = 'tbl_tables';

    $this->creatNewTable($tableName, true, 'INT');

    $clmN = array();
    $clmN[] = array('tableName'=>'name','columnsName'=> array('varchar(50) COLLATE utf8_unicode_ci NOT NULL'));
    $clmN[] = array('tableName'=>'lastChangeDate', 'columnsName'=>array('date NOT NULL'));

    for($i = 0; $i < count($clmN); $i++){
      $this->addNewColumn($tableName, $clmN[$i]['tableName'],$clmN[$i]['columnsName'] , $i != 0 ? $clmN[$i - 1]['tableName'] : 'id');
    }

    $this->addUniqueToColumnOfTable($tableName, 'name');

    return true;
  }

  public function createTableOfColumns()
  {
    $tableName = 'tbl_tables_columns';
    $this->creatNewTable($tableName, true,);

    $clmN = array();
    $clmN[] = array('tableName'=>'tableName','columnsName'=> array('varchar(50) COLLATE utf8_unicode_ci NOT NULL'));
    $clmN[] = array('tableName'=>'field', 'columnsName'=>array('varchar(50) COLLATE utf8_unicode_ci NOT NULL'));
    $clmN[] = array('tableName'=>'type', 'columnsName'=>array('varchar(50) COLLATE utf8_unicode_ci NOT NULL'));
    $clmN[] = array('tableName'=>'null', 'columnsName'=>array('tinyint(1) NOT NULL'), 'id');
    $clmN[] = array('tableName'=>'key', 'columnsName'=>array('varchar(10) COLLATE utf8_unicode_ci NOT NULL'));
    $clmN[] = array('tableName'=>'default','columnsName'=> array('varchar(50) COLLATE utf8_unicode_ci NOT NULL'));
    $clmN[] = array('tableName'=>'extra', 'columnsName'=>array('varchar(50) COLLATE utf8_unicode_ci NOT NULL'));

    for($i = 0; $i < count($clmN); $i++){
      $this->addNewColumn($tableName, $clmN[$i]['tableName'],$clmN[$i]['columnsName'] , $i != 0 ? $clmN[$i - 1]['tableName'] : 'id');
    }

    $this->addIndexToColumnOfTable($tableName, $clmN[0]['tableName']);
    $this->addIndexToColumnOfTable($tableName, $clmN[1]['tableName']);

    return true;
  }

  public function fillTableOfTables()
  {
    $tableName = 'tbl_tables';
    if (!$this->isTableExist($tableName)) {
      $this->createTableOfTables();
    }
    $resultGetAllTables = $this->getAllTabels();
    $item = new tbl_tables();
    $tableOfTablesItems = $item->find_all(false);
    $tableNameArray = array();
    foreach ($tableOfTablesItems as $value) {
      $tableNameArray[] = $value['name'];
    }
    foreach ($resultGetAllTables as $value) {
      foreach ($value as $v) {
        if (!in_array($v, $tableNameArray)) {
          $item = new tbl_tables();
          $item->name = $v;
          $item->changeConfirm_query(false);
          $item->save();
        }
      }
    }
  }

  public function fillTableOfColumns()
  {
//    set_time_limit(300);
    $tableName = 'tbl_tables_columns';
    if (!$this->isTableExist($tableName)) {
      $this->createTableOfColumns();
    }
    $this->fillTableOfTables();
    $itemTabels = new tbl_tables();
    $tableOfTablesItems = $itemTabels->find_all(false);
//    $tableNameArray = array();
    foreach ($tableOfTablesItems as $value) {
      $columnsInfo = $this->getAllColumnsOfTable($value['name']);

      $itemTables_columns = new tbl_tables_columns();
      $attributeArray = array('tableName' => $value['name']);
      $findAllColumnsOfTables = $itemTables_columns->find_by_attribute($attributeArray);
      foreach ($columnsInfo as $v) {
        if (empty(findItemInArrayOfObject($findAllColumnsOfTables,'field',  $v['Field']))) {
          $item = new tbl_tables_columns();
          $item->tableName = $value['name'];
          $item->field = $v['Field'];
          $item->type = $v['Type'];
          $item->null = $v['Null'];
          $item->key = $v['Key'];
          $item->default = $v['Default'];
          $item->extra = $v['Extra'];
          $item->changeConfirm_query(false);
          $item->save();
        }
      }
    }
    return true;
  }


  public function test()
  {

    $itemTables_columns = new tbl_tables_columns();
    $attributeArray = array('tableName' => 'tbl_users');
    $return = $itemTables_columns->find_by_attribute($attributeArray);
    $return =findItemInArrayOfObject($return, 'field', 'dd');
//    $return = $this->isTableExist('tbl_tables_columns');
//    $return = $this->getAllColumnsOfTable('tbl_exam_date');
    return $return;
//    $resultGetAllTables = $this->getAllTabels();
//    $str = '';
//    foreach($resultGetAllTables as $value)
//    {
//      foreach ($value as  $item)
//      {
//        $str .= $item. ' ';
//      }
//    }
  }


}