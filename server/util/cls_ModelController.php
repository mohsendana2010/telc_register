<?php
/**
 * Created by PhpStorm.
 * User: 49176
 * Date: 30.10.2020
 * Time: 15:03
 */

if ($handle = opendir('./models')) {
  while (false !== ($entry = readdir($handle))) {
    if ($entry != "." && $entry != "..") {
      require_once("./models/$entry");
    }
  }
  closedir($handle);
}


require_once('./util/helper.php');
//require_once('./models/tbl_exam_date.php');
//require_once('./models/tbl_exam_type.php');
//require_once('./models/tbl_telcMember.php');
//require_once('./models/tbl_users.php');
require_once('./util/cls_Email.php');
require_once('./util/cls_JWT.php');
require_once('./util/cls_Captcha.php');
require_once('./util/cls_Encryption.php');
require_once('./util/cls_Login.php');


class cls_ModelController
{
  public function login()
  {
    $item = new cls_Login;
    return $item->login();
  }

  public function loginVerify()
  {
    $item = new cls_Login;
    return $item->loginVerify();
  }


  private function instance($instance)
  {
//    $item = new  tbl_users();
//    $findItem = $item->save();


    $item = new $instance();
    $authorization = new cls_Login;
    $item->authorization  = $authorization->headerAuthorizationVerify();
    return $item;
  }

  private function save($instanceStr)
  {
    return $this->instance($instanceStr)->save();
  }

  private function select($instanceStr)
  {
    return $this->instance($instanceStr)->find_all();
  }

  private function delete($instanceStr)
  {
    return $this->instance($instanceStr)->delete();
  }

  private function fields($instanceStr)
  {
    return json_encode($this->instance($instanceStr)->setShowFields());
  }


  //========== Users
  public function saveUsers()
  {
    return $this->save('tbl_users');
  }

  public function selectUsers()
  {
    return $this->select('tbl_users');
  }

  public function deleteUsers()
  {
    return $this->delete('tbl_users');
  }

  public function fieldsUsers()
  {
    return $this->fields('tbl_users');
  }

//========== TelcMember
  public function saveTelcMember()
  {
    $verify = $this->verifyCaptcha();
    if ($verify) {
//    if (true) {
//      return $this->save('tbl_telcMember');
      $item = new tbl_telcMember();
      $rpl = $item->save();
      if ($rpl) {
        if (isset($_POST['status'])) {
          if ($_POST['status'] == 'update') {
            return "success";
          }
        } else {
//          $email = new cls_Email();
//          $email->sendEmail($item->email, $item->firstName . ' ' . $item->lastName,
//            "Telc Prüfung anmeldung bei Diwan-Marburg Akademie GmbH",
//            $item->makeTelcBodyEmail($item));
          return "success";
        }
      } else {
        return $rpl;
      }
    } else {
      return "captchaError";
    }
  }

  public function selectTelcMember()
  {
    return $this->select('tbl_telcMember');
  }

  public function deleteTelcMember()
  {
    return $this->delete('tbl_telcMember');
  }

  public function fieldsTelcMember()
  {
    return $this->fields('tbl_telcMember');
  }

//========== ExamType
  public function saveExamType()
  {
    return $this->save('tbl_exam_type');
  }

  public function selectExamType()
  {
    return $this->select('tbl_exam_type');
  }

  public function deleteExamType()
  {
    return $this->delete('tbl_exam_type');
  }

  public function fieldsExamType()
  {
    return $this->fields('tbl_exam_type');
  }

  //========== ExamDate
  public function saveExamDate()
  {
    return $this->save('tbl_exam_date');
  }

  public function selectExamDate()
  {
    return $this->select('tbl_exam_date');
  }

  public function deleteExamDate()
  {
    return $this->delete('tbl_exam_date');
  }

  public function fieldsExamDate()
  {
    return $this->fields('tbl_exam_date');
  }

  //========== Session
  public function saveSession()
  {
    return $this->save('tbl_session');
  }

  public function selectSession()
  {
    return $this->select('tbl_session');
  }

  public function deleteSession()
  {
    return $this->delete('tbl_session');
  }

  public function fieldsSession()
  {
    return $this->fields('tbl_session');
  }

  //========== Captcha
  public function getCaptcha()
  {
//    Captcha
    $captcha = new cls_Captcha();
    $data = $captcha->generate_captcha();
    return $data;
  }

  public function verifyCaptcha()
  {
//    Captcha
    $captcha = new cls_Captcha();
    $captchaEncrypt = $_POST['captchaEncrypt'];
    $captchaCode = $_POST['captchaCode'];
    $data = $captcha->verifying_captcha($captchaEncrypt, $captchaCode);
    return $data;
  }


  public function test()
  {
//    $headers = array();
//    foreach ($_SERVER as $key => $value) {
//      if (strpos($key, 'HTTP_') === 0) {
//        $headers[str_replace(' ', '', ucwords(str_replace('_', ' ', strtolower(substr($key, 5)))))] = $value;
//      }
//    }
//    return json_encode($headers);

    $item = new cls_Login;
    return json_encode($item->headerAutorizationVeryfy());


//    return ini_get( 'session.save_path');
//    return json_encode($_SESSION);
    $jwt = new cls_JWT();
//    return $jwt->jwtEncode();
    $jwtTocken =
// "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vZXhhbXBsZS5vcmciLCJhdWQiOiJodHRwOi8vZXhhbXBsZS5jb20iLCJpYXQiOjEzNTY5OTk1MjQsIm5iZiI6MTM1NzY2NjY2NjZ9.KU9MwhERWWmFLoeecdO-LMWvVHIUv9MFeWg_SkgHW9E";
      "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vZXhhbXBsZS5vcmciLCJhdWQiOiJodHRwOi8vZXhhbXBsZS5jb20iLCJpYXQiOjEzNTY5OTk1MjQsIm5iZiI6MTM1NzY2NjY2NjYsImRrZGsiOiJrZGtka2QifQ.G_k0nwdT1MfBa7ibqixamAkrqRiCDdtEzcoCCscLUuI";

//        return $jwt->jwtEncode();
//    return json_encode($jwt->jwtDecode($jwtTocken));
    $optionen = [
      'cost' => 12,
    ];
//    echo password_hash("mohsen", PASSWORD_BCRYPT, $optionen);

//    echo 'Argon2i-Hash: ' . password_hash('rasmuslerdorf', PASSWORD_ARGON2I);

//    echo password_hash("mohsen", PASSWORD_DEFAULT);
//    $2y$10$Jcgo1pSFNXsy1ANqtOgME.YwNn8gtTBRrHrpeHX.xgO/LpkCZS4q6

//    $hash = '$2y$12$RBrF2x0.3JHUbnqYzwnRDuBuKjnieUGZrGL/ER1vDkMpSzUDN87JW';
//
//    if (password_verify('mohsen', $hash)) {
//      echo 'Valides Passwort!';
//    } else {
//      echo 'Invalides Passwort.';
//    }
//    Captcha
//    $captcha = new cls_Captcha();
//    $data = $captcha->captcha_background();
//    return $data;

//
//         $salt = md5('helloasd');
//         return crypt('mohsen', '$1$'. 'hello'. '$');

//    $encrypt = new cls_Encryption();
//    $data = $encrypt->encrypt("MohsenDana");
//    $data1 = $encrypt->decrypt(base64_decode("9s2j/yBW9prG+WkB5S9P5fmRTwO6zCyArMqFlA9wvh2mmBb+soCv+uJfz3z+BxNboUlKGp2OWER3B0a/ihbZ4k7ixdIOVA=="));
////        return    $encrypt->loadEncryptionKeyFromConfig();
//    return ($data1);

//    $captcha = new cls_Captcha();
//    $data = $captcha->generate_captcha();
//    return $data;

//    iODVzkuEz3vWloNN7Z4q2yY6GzbJ8udxC74RjqAP7jBlOVoNBA8Hb3Cc/lQb4I2Db/3mi7LgvCAOqvhF2AURBDr0g0e5Hg==

//    convert an image to base64 encoding
//    $path = './fotos/ostern.jpg';
//    $type = pathinfo($path, PATHINFO_EXTENSION);
//    $data = file_get_contents($path);
//    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
//    return  $base64;


  }


}

$ModelController = new cls_ModelController();