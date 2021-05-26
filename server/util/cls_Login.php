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
    $findItem = $this->findUser($_POST['user'] ?? '');
    if (count($findItem) == 1) {
//      verifying password
      $encrypt = new cls_Encryption();
      if ($encrypt->verifyHashPassword($_POST['password'],
        $findItem[0]['password'])) {
        $tokenArray = $this->makeToken($findItem, "+15 minutes");
        return json_encode($tokenArray);
      } else {
        $tokenArray = $this->makeTokenArray('', '', '','', false);
        return json_encode($tokenArray);
      }
    }
    return false;
  }

  /**
   * find User
   * @param string $userName
   * @return array
   */
  public function findUser($userName)
  {
    $item = new  tbl_users();
    $tmpArray = ['user' => $userName];
    $findItem = $item->find_by_attribute($tmpArray);
    if (count($findItem) == 1) {
      return $findItem;
    }
    return array();
  }

  public function makeToken($userObject, $delayTime)
  {
    $firstName = $userObject[0]['firstName'];
    $lastName = $userObject[0]['lastName'];
    $access = true;
    $token = $this->makeJWTToken($firstName,$lastName,$access,$delayTime);
    $tokenArray = $this->makeTokenArray($firstName, $lastName, $token, $access, true);
    return $tokenArray;
  }

  private function makeJWTToken($firstName,$lastName,$access,$delayTime)
  {
    $key = $this->makeKey($firstName,$lastName,$delayTime);
    $payload = $this->makePayload($firstName, $lastName, $key, $access);
    $jwt = new cls_JWT();
    return $jwt->jwtEncode($payload);
  }

  public function loginVerify()
  {
    if (isset($_POST['Authorization'])) {
      $postToken = $_POST['Authorization'];
      $loginObject = $this->tokenVerify($postToken);
      if ($loginObject != false) {
        $firstName = $loginObject->firstName;
        $lastName = $loginObject->lastName;
        $access = $loginObject->access;
        $key = $this->makeKey($firstName,$lastName, ' +15 minutes');
        $payload = $this->makePayload($firstName, $lastName, $key, $access);
        $jwt = new cls_JWT();
        $token = $jwt->jwtEncode($payload);
        $tokenArray = $this->makeTokenArray($firstName, $lastName, $token, $access, true);

        return json_encode($tokenArray);
      } else {
        $tokenArray = $this->makeTokenArray('', '', '','', false);
        return json_encode($tokenArray);
      }
    }
  }

  public function forgotPassword()
  {
    $findItem = $this->findUser($_POST['user'] ?? '');
    if (count($findItem) == 1) {
      $firstName = $findItem[0]['firstName'];
      $lastName = $findItem[0]['lastName'];
//      $key = $this->makeKey($firstName,$lastName,'1 day');
//      $payload = $this->makePayload($firstName, $lastName, $key, '');
//      $jwt = new cls_JWT();
      $token = $this->makeJWTToken($firstName,$lastName,true,'1 day');
      $outPut = $_SERVER['HTTP_REFERER'] . '/#/test/?token=' . $token;

      $email = new cls_Email();
      $email->sendEmail($findItem[0]['user'],
        $findItem[0]['firstName'] . ' ' . $findItem[0]['lastName'],
        "new password confirmation",
        $outPut, false);//todo make a Efficient Email
    }
  }

  /**
   * @param $firstName
   * @param $lastName
   * @param $key
   * @param $access
   *
   * @return array
   */
  private function makePayload($firstName, $lastName, $key, $access)
  {
    return array(
      "firstName" => $firstName,
      "lastName" => $lastName,
//          "time" => $nextTime,
      "key" => $key,
      "access" => $access,
    );
  }

  /**
   * @param $firstName
   * @param $lastName
   * @param $delayTime
   *
   * @return string base64_encode -> $encrypt->encrypt
   */
  private function makeKey($firstName, $lastName, $delayTime)
  {
    $encrypt = new cls_Encryption();
    $nextTime = date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s") . " " . $delayTime));
    return base64_encode($encrypt->encrypt($firstName . " " . $lastName . "," . $nextTime));
  }

  /**
   * @param $firstName
   * @param $lastName
   * @param $token
   * @param $access
   * @param $loggedIn
   *
   * @return array
   */
  private function makeTokenArray($firstName, $lastName, $token, $access, $loggedIn)
  {
    return array(
      "firstName" => $firstName,
      "lastName" => $lastName,
      "token" => $token,
      "access" => $access,
      "loggedIn" => $loggedIn,
    );
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

  /**
   * Token Verify
   * @param    String $token The object to convert
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

      if (isLiveServer()) {
        if (strtotime($timeNow) <= strtotime($explodeKeyDecrypt[1])) {
          return $loginObject;
        } else {
          return null;
        }
      } else {
        return $loginObject;
      }

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


  /**
   * generate Password
   * @param $pass string
   *
   * @return bool|string
   */
  public function generatePassword($pass)
  {
    $encrypt = new cls_Encryption();
    return $encrypt->encryptHashPassword($pass);
  }

}