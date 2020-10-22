<?php
/**
 * Created by PhpStorm.
 * User: 49176
 * Date: 19.10.2020
 * Time: 12:15
 */

session_start();

//require_once("Strings.php");
require_once('./util/cls_String.php');
//require_once("ServiceLayerConnect.php");


//
//header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
//header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
//header('Content-type: application/json; charset=utf-8');

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Credentials: true");

header("Access-Control-Allow-Headers: *");

//cors();


if (isset($_POST[cls_String::$command])) {
//  handleCommand(new ServiceLayerConnect(), $_POST[cls_String::$command]);
  echo 'true';
  echo 'session id :';
  echo session_id();
}
else {
//  $data = json_decode(file_get_contents("php://input"), TRUE);
//  $id = $data['id'];
  echo 'php version : ';
   echo phpversion();

  echo '  session id :';
  echo session_id();

}
function fetchToken($form)
{
  $token  =   md5(uniqid(microtime(), true));
  $_SESSION['token'][$form]   =   $token;
  // Just return it, don't echo and return
  return $token;
}

function matchToken($form)
{
  if(!isset($_POST['token'][$form]))
    return false;
  // I would clear the token after matched
  if($_POST['token'][$form] === $_SESSION['token'][$form]) {
    $_SESSION['token'][$form]   =   NULL;
    return true;
  }
  // I would return false by default, not true
  return false;
}


/**
 * @param $sl ServiceLayerConnect
 * @param $command string
 */
function handleCommand($sl, $command)
{
  if ($command == Strings::$login) {
    $loginType = $_POST[Strings::$query];
    $user = $_POST[Strings::$user];
    $pass = $_POST[Strings::$pass];

    if (strlen($pass) >= 8) {
      if (substr($pass, 0, 3) == 'LM#') {
        $pass = substr($pass, 3);
        if ($loginType == 'Email') {
          $email = strtolower($user);
          $query = "BusinessPartners?\$filter=Password eq '$pass' and EmailAddress eq '$email'";
        } else {
          $query = "BusinessPartners?\$filter=Password eq '$pass' and CardCode eq '$user'";
        }
        echo $sl->login(str_replace(' ', '%20', $query));
      } else {
        echo false;
      }
    } else {
      echo false;
    }
  } elseif ($command == Strings::$employeeLogin) {
    $user = $_POST[Strings::$user];
    $pass = $_POST[Strings::$pass];
    echo $sl->employeeLogin($user, $pass);
  }
}
