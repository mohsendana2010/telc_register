<?php
/**
 * Created by PhpStorm.
 * User: 49176
 * Date: 19.10.2020
 * Time: 12:15
 */
session_start();

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Credentials: true");
header("Content-type: application/Json; charst=UTR-8");
header("Access-Control-Allow-Headers: *");
//header('Content-Type: text/html; charset=UTF-8');


//require_once("Strings.php");
require_once('./util/cls_String.php');
require_once('./util/cls_ModelController.php');
//require_once("ServiceLayerConnect.php");


//
//header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
//header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
//header('Content-type: application/json; charset=utf-8');
//Headers


//cors();

//$tM = new tbl_exam_date();
//$tM->date = "2020-12-20";
//   $tM->create();

if (isset($_POST[cls_String::$command])) {
  handleCommand(new $ModelController(), $_POST[cls_String::$command]);


} else {
//  $data = json_decode(file_get_contents("php://input"), TRUE);
//  $id = $data['id'];
  $md = new $ModelController();
  echo 'php version : ';
  echo phpversion();

  echo '  session id: ';
  echo session_id() . "      ";
//  $tmp = $md->selectExamType();
//  echo var_dump($tmp);

}
//function fetchToken($form)
//{
//  $token = md5(uniqid(microtime(), true));
//  $_SESSION['token'][$form] = $token;
//  // Just return it, don't echo and return
//  return $token;
//}
//
//function matchToken($form)
//{
//  if (!isset($_POST['token'][$form]))
//    return false;
//  // I would clear the token after matched
//  if ($_POST['token'][$form] === $_SESSION['token'][$form]) {
//    $_SESSION['token'][$form] = NULL;
//    return true;
//  }
//  // I would return false by default, not true
//  return false;
//}


/**
 * @param $mc_modelController
 * @param $command string
 */
function handleCommand($mc, $command)
{
  if ($command == cls_String::$login) {


  } elseif ($command === "insertExamType") {
    echo $mc->insertExamType();

  } elseif ($command === "selectExamType") {
    echo $mc->selectExamType();

  }  elseif ($command === "deleteExamType") {
    echo $mc->deleteExamType();

  } elseif ($command === "insertExamDate") {

    echo $mc->insertExamDate();
  }
}
