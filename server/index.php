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
  echo 'php version : ';


}


/**
 * @param $mc_modelController
 * @param $command string
 */
function handleCommand($mc, $command)
{
  if ($command == 'login') {
    echo $mc->login();

  } else {
    echo $mc->$command();
  }

//  elseif ($command === "saveTelcMember") {
//    echo $mc->saveTelcMember();
//
//  } elseif ($command === "selectTelcMember") {
//    echo $mc->$command();
//
//  } elseif ($command === "deleteTelcMember") {
//    echo $mc->deleteTelcMember();
//
//  } elseif ($command === "fieldsTelcMember") {
//    echo $mc->fieldsTelcMember();
////========== ExamType
//  } elseif ($command === "saveExamType") {
//    echo $mc->saveExamType();
//
//  } elseif ($command === "selectExamType") {
//    echo $mc->selectExamType();
//
//  } elseif ($command === "deleteExamType") {
//    echo $mc->deleteExamType();
//
//  } elseif ($command === "fieldsExamType") {
//    echo ($mc->fieldsExamType());
//
//    //========== ExamDate
//  } elseif ($command === "saveExamDate") {
//    echo $mc->saveExamDate();
//  } elseif ($command === "selectExamDate") {
//    echo $mc->selectExamDate();
//
//  } elseif ($command === "deleteExamDate") {
//    echo $mc->deleteExamDate();
//
//  } elseif ($command === "fieldsExamDate") {
//    echo ($mc->fieldsExamDate());
//
//    //========== Captcha
//  }  elseif ($command === "getCaptcha") {
//    echo $mc->getCaptcha();
//
//  }elseif ($command === "verifyCaptcha") {
////    echo $_POST['captchaEncrypt'];
//    echo $mc->verifyCaptcha();
//
//  } elseif ($command === "test") {
//    echo ($mc->test());
//    echo 'data:image/png;base64,' . ($mc->test()) ;
//}


}

