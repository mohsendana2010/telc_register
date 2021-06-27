<?php
/**
 * Created by PhpStorm.
 * User: 49176
 * Date: 19.10.2020
 * Time: 12:15
 * phpversion() server ionos  "5.6.40"
 * phpversion() local   "7.3.0"
 */
session_start();

require_once('./util/helper.php');

//header("Access-Control-Allow-Origin: origin-list");

//header("Access-Control-Allow-Origin: *");

if (!isLiveServer()) {
  header("Access-Control-Allow-Origin: http://localhost:8080");
} else {
  header("Access-Control-Allow-Origin: http://www.ids.diwan-marburg.de");
}
header('Access-Control-Allow-Credentials: true');
header("Content-type: application/Json; charst=UTR-8");
//header("Access-Control-Allow-Headers: *");
//header('Content-Type: text/html; charset=UTF-8');


require_once('./util/cls_String.php');
require_once('./util/cls_ModelController.php');


if (isset($_POST[cls_String::$command])) {
  handleCommand(new $ModelController(), $_POST[cls_String::$command]);


} else {
  echo 'php version : ' . phpversion();


}


/**
 * @param $mc
 * @param $command
 */
function handleCommand($mc, $command)
{
  if ($command == 'login') {
    echo $mc->login();

  } else {
    echo $mc->command($command);
  }
  try {
//   $test = $mc->saveSession();
//   echo json_encode($test);
  } catch (Exception $e) {

  }


}

