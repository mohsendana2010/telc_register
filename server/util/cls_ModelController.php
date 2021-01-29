<?php
/**
 * Created by PhpStorm.
 * User: 49176
 * Date: 30.10.2020
 * Time: 15:03
 */

require_once('./util/helper.php');
require_once('./models/tbl_exam_date.php');
require_once('./models/tbl_exam_type.php');
require_once('./models/tbl_telcMember.php');
require_once('./util/cls_Email.php');
require_once('./util/cls_JWT.php');
require_once('./util/cls_Captcha.php');
require_once('./util/cls_Encryption.php');

class cls_ModelController
{

//========== TelcMember
  public function saveTelcMember()
  {
    $verify = $this->verifyCaptcha();
    if ($verify) {
      $item = new tbl_telcMember();
      $rpl = $item->save();
      if ($rpl) {
        if (!($item->id > -1)) {
          $email = new cls_Email();
          $email->sendEmail($item->email, $item->firstName . ' ' . $item->lastName,
            "Telc Prüfung anmeldung bei Diwan-Marburg Akademie GmbH",
            $item->makeTelcBodyEmail($item));
        }
        return $rpl;
      } else {
        return "DB-Error";
      }

    } else {
      return "captchaError";
    }
  }

  public function selectTelcMember()
  {
    $item = new tbl_telcMember();
    return $item->find_all();
  }

  public function deleteTelcMember()
  {
    $item = new tbl_telcMember();
    return $item->delete();
  }

  public function fieldsTelcMember()
  {
    $item = new tbl_telcMember();
    return $item->setShowFields();
  }

//========== ExamType
  public function saveExamType()
  {
    $item = new tbl_exam_type();
    return $item->save();
  }

  public function selectExamType()
  {
    $item = new tbl_exam_type();
    return $item->find_all();
  }

  public function deleteExamType()
  {
    $item = new tbl_exam_type();
    return $item->delete();
  }

  public function fieldsExamType()
  {
    $item = new tbl_exam_type();
    $item->setShowFields();
    return $item->showFields;
  }

  //========== ExamDate
  public function saveExamDate()
  {
    $item = new tbl_exam_date();
    return $item->save();
  }

  public function selectExamDate()
  {
    $item = new tbl_exam_date();
    return $item->find_all();
  }

  public function deleteExamDate()
  {
    $item = new tbl_exam_date();
    return $item->delete();
  }

  public function fieldsExamDate()
  {
    $item = new tbl_exam_date();
    $item->setShowFields();
    return $item->showFields;
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
//    $jwt   = new cls_JWT();
//    return $jwt->jwtEncode();
//    $jwtTocken = "https://jwt.io/#debugger-io?token=eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQ.t0D_vRC1JUaV5sJgT46dXXUoXeztFWiV7MDiwL6F_jU";
    $jwtTocken = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vZXhhbXBsZS5vcmciLCJhdWQiOiJodHRwOi8vZXhhbXBsZS5jb20iLCJpYXQiOjEzNTY5OTk1MjQsIm5iZiI6MTM1NzAwMDAwMH0.Z1Ga3o6rULYArvIh4qOnaOKwOEfeneEFfU-Kj93qgjg";

//        return $jwt->jwtEncode();
//    return $jwt->jwtDecode($jwtTocken);

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