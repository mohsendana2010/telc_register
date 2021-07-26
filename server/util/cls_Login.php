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
  /**
   * @return false|string
   */
  public function login()
  {
    $tokenArray = $this->makeTokenArray();
    $findItem = $this->findUser($_POST['user'] ?? '');
    if (count($findItem) == 1) {
//      verifying password
      $encrypt = new cls_Encryption();
      if ($encrypt->verifyHashPassword($_POST['password'],
        $findItem[0]['password'])) {
        if (true) {//todo exist tbl_login
          $tblLoginName = 'tbl_login';
          $tblLogin = new generalModels($tblLoginName);
          $tblLogin->userId = $findItem[0]['id'];
          $tblLogin->firstName = $findItem[0]['firstName'];
          $tblLogin->lastName = $findItem[0]['lastName'];
          $tblLogin->adderUser = $findItem[0]['user'];
          $tblLogin->save();
        }
        $tokenArray = $this->makeToken($findItem, "+15 minutes");
        return json_encode($tokenArray);
      }
    }
    return json_encode($tokenArray);
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

  /**
   * @param $userObject
   * @param $delayTime
   *
   * @return array
   */
  private function makeToken($userObject, $delayTime)
  {
    $firstName = $userObject[0]['firstName'];
    $lastName = $userObject[0]['lastName'];
    $user = $userObject[0]['user'];
    $access = true;
    $token = $this->makeJWTToken($firstName, $lastName, $user, $access, $delayTime);
    $tokenArray = $this->makeTokenArray($firstName, $lastName, $user, $token, $access, true);
    return $tokenArray;
  }

  private function makeJWTToken($firstName, $lastName, $user, $access, $delayTime, $data = array())
  {
    if (empty($data)) {
      $data = array('firstName' => $firstName, 'lastName' => $lastName, 'user' => $user);
    }
    $key = $this->makeKey($data, $delayTime);
    $payload = $this->makePayload($firstName, $lastName,$user, $key, $access);
    $jwt = new cls_JWT();
    return $jwt->jwtEncode($payload);
  }

  /**
   * @return false|string
   */
  public function loginVerify()
  {
    if (isset($_POST['Authorization'])) {
      $postToken = $_POST['Authorization'];
      $loginObject = $this->tokenVerify($postToken);
      if ($loginObject != false) {
        $firstName = $loginObject->firstName;
        $lastName = $loginObject->lastName;
        $user = $loginObject->user;
        $access = $loginObject->access;
        $token = $this->makeJWTToken($firstName, $lastName, $user, $access, '+15 minutes');
        $tokenArray = $this->makeTokenArray($firstName, $lastName, $user, $token, $access, true);

        return json_encode($tokenArray);
      } else {
        $tokenArray = $this->makeTokenArray();
        return json_encode($tokenArray);
      }
    }
  }

  public function forgotPassword()
  {
    $findItem = $this->findUser($_POST['user'] ?? '');
    if (count($findItem) == 1) {
      $item = $findItem[0];
      $firstName = $item['firstName'];
      $lastName = $item['lastName'];
      $user = $item['user'];
      $data = array('id' => $item['id'], 'user' => $item['user']);
      $token = $this->makeJWTToken($firstName, $lastName, $user, true, '1 day', $data);
      $outPut = $_SERVER['HTTP_REFERER'] . '/#/newpassword/?token=' . $token;

      $email = new cls_Email();
      $email->sendEmail($item['user'],
        $firstName . ' ' . $lastName,
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
  private function makePayload($firstName, $lastName,$user, $key, $access)
  {
    return array(
      "firstName" => $firstName,
      "lastName" => $lastName,
      "user" => $user,
//          "time" => $nextTime,
      "key" => $key,
      "access" => $access,
    );
  }

  /**
   * @param $data
   * @param $delayTime
   *
   * @return string base64_encode -> $encrypt->encrypt
   */
  private function makeKey($data, $delayTime)
  {
    $encrypt = new cls_Encryption();
    $nextTime = date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s") . " " . $delayTime));
    $data['dateTime'] = $nextTime;
    return base64_encode($encrypt->encrypt(json_encode($data)));
  }

  /**
   * @param string $firstName
   * @param string $lastName
   * @param string $user
   * @param string $token
   * @param string $access
   * @param bool $loggedIn
   *
   * @return array
   */
  private function makeTokenArray($firstName = '', $lastName = '', $user = '', $token = '', $access = '', $loggedIn = false)
  {
    return array(
      "firstName" => $firstName,
      "lastName" => $lastName,
      "user" => $user,
      "token" => $token,
      "access" => $access,
      "loggedIn" => $loggedIn,
    );
  }


  /**
   * @return bool
   */
  public function newPassword()
  {
    if (isset($_POST['Authorization'])) {
      $token = $_POST['Authorization'];
      $tokenObject = $this->tokenVerify($token);
      if ($tokenObject != false) {
        $keyDecrypt = $this->keyDecrypt($tokenObject->key);
        $id = $keyDecrypt->id;
        $user = $keyDecrypt->user;

        $item = new  tbl_users();
        $findUser = $item->find_by_id($id);
        if (!empty($findUser)) {
          if ($findUser[0]['user'] === $user) {
            $item->id = $id;
//            $item->password = $this->generatePassword($_POST['password']);
            $item->authorization = $tokenObject;
            $item->save();
            return true;
          };
        }
      }
    }
    return false;
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
    $loginObject = $this->makeTokenArray();
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
      $loginObject = $this->jwtDecode($token);
      if ($loginObject !== null) {
        $keyDecrypt = $this->keyDecrypt($loginObject->key);
        $explodeKeyDecrypt = $keyDecrypt->dateTime;
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
      } else {
        return null;
      }
    } catch (Exception $e) {
      return null;
    }
  }

  /**
   * @param $token
   * @return object|null
   */
  private function jwtDecode($token)
  {
    try {
      $jwt = new cls_JWT();
      //todo  if that is right
      return $jwt->jwtDecode($token);
      //todo  if that is right
    } catch (Exception $e) {
      return null;
    }
  }

  /**
   * @param $key string
   * @return array
   */
  private function keyDecrypt($key)
  {
    try {
      $encrypt = new cls_Encryption();
      return json_decode($encrypt->decrypt(base64_decode($key)));
    } catch (Exception $e) {
      return array();
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
  private function generatePassword($pass)
  {
    $encrypt = new cls_Encryption();
    return $encrypt->encryptHashPassword($pass);
  }

}