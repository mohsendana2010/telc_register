<?php
/**
 * Created by PhpStorm.
 * User: 49176
 * Date: 13.03.2021
 * Time: 18:44
 */
require_once("./models/tbl_users.php");

require_once('./util/cls_Email.php');
require_once('./util/cls_JWT.php');
require_once('./util/cls_Captcha.php');
require_once('./util/cls_Encryption.php');

class cls_Login
{
  public function login()
  {
    //find user
    $item = new  tbl_users();
    $tmpArray = ['user' => $_POST['user']];
    $findItem = $item->find_by_attribute($tmpArray);
    if ($findItem) {
//      verifying password
      if ($findItem[0]['password'] == $_POST['password']) {
        $firstName = $findItem[0]['firstName'];
        $lastName = $findItem[0]['lastName'];
        $access = true;
        $nextTime = date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s") . " +15 minutes"));
        $encrypt = new cls_Encryption();
        $key = base64_encode($encrypt->encrypt($firstName . " " . $lastName . "," . $nextTime));
        $payload = array(
          "firstName" => $firstName,
          "lastName" => $lastName,
//          "time" => $nextTime,
          "key" => $key,
          "access" => $access,
        );
//        make token from class jwt
        $jwt = new cls_JWT();
        $token = $jwt->jwtEncode($payload);
        $loginArray = array(
          "firstName" => $firstName,
          "lastName" => $lastName,
          "token" => $token,
          "access" => $access,
          "loggedIn" => true,
        );
        return json_encode($loginArray);
      } else {
        $loginArray = array(
          "firstName" => "",
          "lastName" => "",
          "token" => "",
          "access" => "",
          "loggedIn" => false,
        );
        return json_encode($loginArray);
      }

    }
    return false;
  }

  public function loginVerify()
  {
    if (isset($_POST['token'])) {
      $postToken = $_POST['token'];
      $loginObject = $this->tokenVerify($postToken);

      if ($loginObject != false) {
        $firstName = $loginObject->firstName;
        $lastName = $loginObject->lastName;
        $nextTime = date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s") . " +15 minutes"));
        $access = $loginObject->access;
        $encrypt = new cls_Encryption();
        $key = base64_encode($encrypt->encrypt($firstName . " " . $lastName . "," . $nextTime));
        $payload = array(
          "firstName" => $firstName,
          "lastName" => $lastName,
//          "time" => $nextTime,
          "key" => $key,
          "access" => $access
        );
        $jwt = new cls_JWT();
        $token = $jwt->jwtEncode($payload);
        $loginArray = array(
          "firstName" => $firstName,
          "lastName" => $lastName,
          "token" => $token,
          "access" => $access,
          "loggedIn" => true,
        );
        return json_encode($loginArray);
      } else {
        $loginArray = array(
          "firstName" => "",
          "lastName" => "",
          "token" => "",
          "access" => "",
          "loggedIn" => false,
        );
        return json_encode($loginArray);
      }
    }
  }

  public function headerAuthorizationVerify()
  {
    $token = "";
    $headers = apache_request_headers();
    if (isset($headers['Authorization'])) {
      $token = $headers['Authorization'];
      if ($token != "") {
        $loginObject = $this->tokenVerify($token);
        if ($loginObject != null) {
          return $loginObject;
        }
      }
    }
    $loginObject = (object)array(
      "firstName" => "",
      "lastName" => "",
//          "time" => $nextTime,
      "key" => "",
      "access" => false
    );
    return $loginObject;
  }

  /*
   *       Tocken Verify
   * @param    String  $tocken The object to convert
   * @return      object
   */
  private function tokenVerify($tocken)
  {
    try {
      $jwt = new cls_JWT();
      //todo  if that is right
      $loginObject = $jwt->jwtDecode($tocken);
      //todo  if that is right

      $encrypt = new cls_Encryption();
      $keyDecrypt = $encrypt->decrypt(base64_decode($loginObject->key));
      $explodeKeyDecrypt = explode(",", $keyDecrypt);
      $timeNow = date("Y-m-d H:i:s");

      if (strtotime($timeNow) <= strtotime($explodeKeyDecrypt[1])) {
        return $loginObject;
      }
//    $loginObject = (object) array(
//      "firstName" => "",
//      "lastName" => "",
////          "time" => $nextTime,
//      "key" => "",
//      "access" => false
//    );
      return null;

    } catch (Exception $e){
      return null;
    }
  }

}