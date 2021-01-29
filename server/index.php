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

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Credentials: true");
header("Content-type: application/Json; charst=UTR-8");
header("Access-Control-Allow-Headers: *");
//header('Content-Type: text/html; charset=UTF-8');


//require_once("Strings.php");
require_once('./util/cls_String.php');
require_once('./util/cls_ModelController.php');
//require_once("ServiceLayerConnect.php");



if (isset($_POST[cls_String::$command])) {
  handleCommand(new $ModelController(), $_POST[cls_String::$command]);


} else {
//  $data = json_decode(file_get_contents("php://input"), TRUE);
//  $id = $data['id'];
  $md = new $ModelController();
  echo 'php version : ';

  ini_set('sendmail_from', 'mohsend2010@yahoo.com');
  echo ini_get('sendmail_from');
//  echo phpversion();

  echo '  session id: ';
  echo session_id() . "      ";
//  $tmp = $md->selectExamType();
//  echo var_dump($tmp);

}


/**
 * @param $mc_modelController
 * @param $command string
 */
function handleCommand($mc, $command)
{
  if ($command == cls_String::$login) {

    //========== TelcMember
  } elseif ($command === "saveTelcMember") {
    echo $mc->saveTelcMember();

  } elseif ($command === "selectTelcMember") {
    echo $mc->selectTelcMember();

  } elseif ($command === "deleteTelcMember") {
    echo $mc->deleteTelcMember();

  } elseif ($command === "fieldsTelcMember") {
    echo json_encode($mc->fieldsTelcMember());
//========== ExamType
  } elseif ($command === "saveExamType") {
    echo $mc->saveExamType();

  } elseif ($command === "selectExamType") {
    echo $mc->selectExamType();

  } elseif ($command === "deleteExamType") {
    echo $mc->deleteExamType();

  } elseif ($command === "fieldsExamType") {
    echo json_encode($mc->fieldsExamType());

    //========== ExamDate
  } elseif ($command === "saveExamDate") {
    echo $mc->saveExamDate();
  } elseif ($command === "selectExamDate") {
    echo $mc->selectExamDate();

  } elseif ($command === "deleteExamDate") {
    echo $mc->deleteExamDate();

  } elseif ($command === "fieldsExamDate") {
    echo json_encode($mc->fieldsExamDate());

    //========== Captcha
  }  elseif ($command === "getCaptcha") {
    echo $mc->getCaptcha();

  }elseif ($command === "verifyCaptcha") {
//    echo $_POST['captchaEncrypt'];
    echo $mc->verifyCaptcha();

  } elseif ($command === "test") {
    header('Content-type: image/jpeg');
    echo ($mc->test());
//    echo 'data:image/png;base64,' . ($mc->test()) ;



  }
}
