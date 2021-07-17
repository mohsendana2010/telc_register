<?php
/**
 * Created by PhpStorm.
 * User: 49176
 * Date: 15.07.2021
 * Time: 06:45
 */

class cls_Managing_Version extends cls_DB_Managing
{
    protected function insertIntoTblVersion($version, $description = ''){
      $tableName = 'tbl_version';
      if (!$this->isTableExist($tableName)) {
        return false;
      }
      $item = new generalModels($tableName);
      $item->version = $version;
      $item->description = $description;

      $item->save();
    }

  /**
   * check Last Version
   * @return bool
   */
  protected function checkLastVersion($currentVersion, $description = ''){
      //todo get last Version
//    if ($lastVersion <= $currentVersion)
      if (true)
      {
        $this->insertIntoTblVersion($currentVersion, $description);
        return true;
      }
      else {
        return false;
      }
    }

}