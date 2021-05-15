<?php
/**
 * Created by PhpStorm.
 * User: 49176
 * Date: 13.03.2021
 * Time: 18:44
 */
require_once('./util/helper.php');
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
    $findItem = $this->findUser();
    if ($findItem) {
//      verifying password
      $encrypt = new cls_Encryption();
      if ($encrypt->verifyHashPassword($_POST['password'],
        $findItem[0]['password'])) {
        $tokenArray = $this->makeTokenArray($findItem, "+15 minutes");
        return json_encode($tokenArray);
      } else {
        $tokenArray = array(
          "firstName" => "",
          "lastName" => "",
          "token" => "",
          "access" => "",
          "loggedIn" => false,
        );
        return json_encode($tokenArray);
      }
    }
    return false;
  }

  public function findUser()
  {
    $item = new  tbl_users();
    $tmpArray = ['user' => $_POST['user']];
    $findItem = $item->find_by_attribute($tmpArray);
    if (count($findItem) == 1) {
      return $findItem;
    } else {
      return false;
    }
  }

  public function makeTokenArray($userObject, $delayTime)
  {
    $encrypt = new cls_Encryption();
    $firstName = $userObject[0]['firstName'];
    $lastName = $userObject[0]['lastName'];
    $access = true;
    $nextTime = date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s") . " " . $delayTime));
    $key = base64_encode($encrypt->encrypt($firstName . " " . $lastName . "," . $nextTime));
    $payload = array(
      "firstName" => $firstName,
      "lastName" => $lastName,
//          "time" => $nextTime,
      "key" => $key,
      "access" => $access,
    );
    $jwt = new cls_JWT();
    $token = $jwt->jwtEncode($payload);
    $tokenArray = array(
      "firstName" => $firstName,
      "lastName" => $lastName,
      "token" => $token,
      "access" => $access,
      "loggedIn" => true,
    );
    return $tokenArray;
  }

  public function loginVerify()
  {
    if (isset($_POST['Authorization'])) {
      $postToken = $_POST['Authorization'];
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

  public function forgotPassword($email)
  {


  }

  public function replacePassword()
  {

  }

  public function headerAuthorizationVerify()
  {
    if (isset($_POST['Authorization'])) {
      $token = $_POST['Authorization'];
      if (!empty($token)) {
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
   * Token Verify
   * @param    String  $token The object to convert
   * @return      object
   */
  private function tokenVerify($token)
  {
    try {
      $jwt = new cls_JWT();
      //todo  if that is right
      $loginObject = $jwt->jwtDecode($token);
      //todo  if that is right

      $encrypt = new cls_Encryption();
      $keyDecrypt = $encrypt->decrypt(base64_decode($loginObject->key));
      $explodeKeyDecrypt = explode(",", $keyDecrypt);
      $timeNow = date("Y-m-d H:i:s");

      if (isLifeServer()) {
        if (strtotime($timeNow) <= strtotime($explodeKeyDecrypt[1])) {
          return $loginObject;
        } else {
          return null;
        }
      } else {
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

    } catch (Exception $e) {
      return null;
    }
  }

  function makeForgotPasswordEmail($item)
  {
    $tabHteml = "&#160;&#160;&#160;&#160;";
    $mailText = "To change your password, please click on the link below ";

    $mailText .= $tabHteml . "Vorname:  " . ucfirst($item->firstName) . "<br/>";


    $mailText .= "Mit freundlichen Grüßen" . "<br/>";
    $mailText .= "Diwan-Marburg Akademie" . "<br/>" . "<br/>";

    $mailText .= "Sollten Diese Email nicht Für Sie bestimmen sein, bitte ignorieren Sie diese." . "<br/>" . "<br/>";

    $mailText .= "www.diwan-marburg.de" . "<br/>";
    $mailText .= "Tel.: 06421-9839100" . "<br/>";
    $mailText .= "Neue Kasseler Str. 2" . "<br/>";
    $mailText .= "35039 Marburg" . "<br/>";
    $mailText .= "&#9993;Email: info@diwan-marburg.de" . "<br/>" . "<br/>";

    $mailText .= "Bitte besuchen Sie unseren Kanal für mehr Allgemeinwissen unter" . "<br/>";
    $mailText .= "https//t.me/telc_c1" . "<br/>";
    return $mailText;
  }

}