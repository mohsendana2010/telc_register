<?php

/**
 * Created by PhpStorm.
 * User: 49176
 * Date: 30.10.2020
 * Time: 15:03
 */
$modelsArray = array();
if ($handle = opendir('./models')) {
  while (false !== ($entry = readdir($handle))) {
    if ($entry != "." && $entry != ".." && stripos($entry, 'php')) {
      $modelsArray[] = $entry;
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

require_once('./util/cls_String.php');

require_once('./DB_Connection/cls_DB_Managing.php');//todo must be delete


class cls_ModelController
{

  public function command($command)
  {
    try {
      $class = new ReflectionClass('cls_ModelController');
      $publicFunctions = $class->getMethods(ReflectionMethod::IS_PUBLIC);
      foreach ($publicFunctions as $v) {
        if ($command == $v->name) {
          return $this->$command();
        }
      }
      $command2 = '';
      for ($i = 0; $i < strlen($command); $i++) {
        if (ctype_upper($command[$i])) {
          $command2 .= '_' . strtolower($command[$i]);
        } else {
          $command2 .= $command[$i];
        }
      }
      $command = $command2;
      $arrayCommand = array('save', 'select', 'delete', 'fields');
      foreach ($arrayCommand as $v) {
        if (strpos($command, $v) === 0) {
          $command = lcfirst(substr($command, strlen($v)));
          return $this->funcAct('tbl' . $command, $v);
        }
      }
    } catch (ReflectionException $e) {
    }
  }

  #region login and authentication functions
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


  public function forgotPassword()
  {
    if ($this->verifyCaptcha()) {
      $item = new cls_Login();
      $item->forgotPassword();
    } else {
      return cls_String::$captchaError;
    }
    return true;
  }


  public function newPassword()
  {
    $item = new cls_Login();
    return $item->newPassword();
  }
  #endregion

  #region general function
  private function instance($instance)
  {
    global $modelsArray;
    //    $item = new  tbl_users();
    //    $findItem = $item->save();
    foreach ($modelsArray as $foreItem) {
      if (substr($foreItem, 0, -4) === $instance) {
        $item = new $instance();
        $authorization = new cls_Login;
        $item->authorization = $authorization->headerAuthorizationVerify();
        return $item;
      }
    }
    $item = new generalModels($instance);
    $authorization = new cls_Login;
    $item->authorization = $authorization->headerAuthorizationVerify();
    return $item;
  }

  /**
   * @param String $instanceStr
   * @param String $act
   * @return mixed
   */
  private function funcAct(String $instanceStr, String $act)
  {
    return $this->instance($instanceStr)->$act();
  }

//  private function save($instanceStr)
//  {
//    return $this->instance($instanceStr)->save();
//  }
//
//  private function select($instanceStr)
//  {
//    return $this->instance($instanceStr)->find_all();
//  }
//
//  private function delete($instanceStr)
//  {
//    return $this->instance($instanceStr)->delete();
//  }
//
//  private function fields($instanceStr)
//  {
//    return json_encode($this->instance($instanceStr)->setShowFields());
//  }

  #endregion


  #region Users
//  public function saveUsers()
//  {
//    return $this->save('tbl_users');
//  }
//
//  public function selectUsers()
//  {
//    return $this->select('tbl_users');
//  }
//
//  public function deleteUsers()
//  {
//    return $this->delete('tbl_users');
//  }
//
//  public function fieldsUsers()
//  {
//    return $this->fields('tbl_users');
//  }

  #endregion

  #region TelcMember
  public function saveTelcMember()
  {
    if ($this->verifyCaptcha()) {
      $item = new tbl_telc_member();
      $rpl = $item->save();
      if ($rpl) {
        if ($item->id >= 0) {
          echo $item->id;
        }
        if (isLiveServer()) {
          $email = new cls_Email();
          $email->sendEmail(
            $item->email,
            $item->firstName . ' ' . $item->lastName,
            "Telc Prüfung anmeldung bei Diwan-Marburg Akademie GmbH",
            $item->makeTelcBodyEmail($item)
          );
        }
        return " success";
      } else {
        return $rpl;
      }
    } else {
      return cls_String::$captchaError;
    }
  }

  public function updateTelcMember()
  {
    $item = new tbl_telc_member();
    $authorization = new cls_Login;
    $item->authorization = $authorization->headerAuthorizationVerify();
    $rpl = $item->update();
    if ($rpl) {
      return "success";
    } else {
      return $rpl;
    }
  }

  public function selectTelcMember()
  {
    return $this->funcAct('tbl_telc_member', 'select');
  }

  public function deleteTelcMember()
  {
    return $this->funcAct('tbl_telc_member', 'delete');
  }

  public function fieldsTelcMember()
  {
    return $this->funcAct('tbl_telc_member', 'fields');
  }
  #endregion

  #region ExamType
//  public function saveExamType()
//  {
//    return $this->save('tbl_exam_type');
//  }
//
//  public function selectExamType()
//  {
//    return $this->select('tbl_exam_type');
//  }
//
//  public function deleteExamType()
//  {
//    return $this->delete('tbl_exam_type');
//  }
//
//  public function fieldsExamType()
//  {
//    return $this->fields('tbl_exam_type');
//  }
  #endregion

  #region ExamDate
//  public function saveExamDate()
//  {
//    return $this->save('tbl_exam_date');
//  }
//
//  public function selectExamDate()
//  {
//    return $this->select('tbl_exam_date');
//  }
//
//  public function deleteExamDate()
//  {
//    return $this->delete('tbl_exam_date');
//  }
//
//  public function fieldsExamDate()
//  {
//    return $this->fields('tbl_exam_date');
//  }
  #endregion

  #region Session
//  public function saveSession()
//  {
//    return $this->save('tbl_session');
//  }
//
//  public function selectSession()
//  {
//    return $this->select('tbl_session');
//  }
//
//  public function deleteSession()
//  {
//    return $this->delete('tbl_session');
//  }
//
//  public function fieldsSession()
//  {
//    return $this->fields('tbl_session');
//  }
  #endregion

  #region Captcha
  public function getCaptcha()
  {
    //    Captcha
    $captcha = new cls_Captcha();
    $data = $captcha->generate_captcha();
    return $data;
  }

  /**
   * @return bool
   */
  public function verifyCaptcha()
  {
    //    Captcha
    if (isLiveServer()) { // || true) {
      $captcha = new cls_Captcha();
      $captchaEncrypt = $_POST['captchaEncrypt'] ?? '';
      $captchaCode = $_POST['captchaCode'] ?? '';
      return $captcha->verifying_captcha($captchaEncrypt, $captchaCode);
    } else {
      return true;
    }
  }

  #endregion


  public function test()
  {
    global $modelsArray;
    $test = substr($modelsArray[0], 0, -4);
    return json_encode($test);

//    while (!ctype_lower($string1))
//    {
//    preg_match('/[A-Z]/', $string1, $matches, PREG_OFFSET_CAPTURE);
//    $string2 = substr($string1, 0, $matches[0][1]) . '_' . strtolower($matches[0][0]) . substr($string1, $matches[0][1] + 1);
//      $string1 = substr($string1, 0, $matches[0][1]) . '_' . strtolower($matches[0][0]) . substr($string1, $matches[0][1] + 1);
//
//    }
    return (($string2));


//    $item = new cls_DB_Managing();
//    return json_encode($item->mysqliGetCharset());

//    $myClass = new cls_ModelController();
//    $item = get_class_methods($myClass);

//    $class = new ReflectionClass('cls_ModelController');
//    $item = $class->getMethods(ReflectionMethod::IS_PUBLIC );

//    return json_encode($this->command('selectExamType'));
    //    call test Function from tlc_memebr
    //    $item = new tbl_telcMember();
    //    return json_encode($item->testAddNewTable());

//        $item = new cls_DB_Managing();
//        return json_encode($item->test());


    //    $authorization = new cls_Login;
    //    return json_encode($authorization->headerAuthorizationVerify());

    //    convert an image to base64 encoding
    //    $path = './fotos/ostern.jpg';
    //    $type = pathinfo($path, PATHINFO_EXTENSION);
    //    $data = file_get_contents($path);
    //    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
    //    return  $base64;


  }


  public function addLastTelcExam()
  {
    //    convert old data to my sql
    $headerOfTelcMember = array('archiveNumber', 'memberNr', 'gender', 'lastName', 'firstName', 'birthday', 'birthCountry', 'mobile', 'email', 'examDate', 'examType', 'remarks', 'passed');

    if (($handle = fopen("D:/XAMPP/htdocs/telc register/Telc Prüfungen NEUcsv.csv", "r")) !== FALSE) {
      while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
        $num = count($data);
        $item = new tbl_telcMember();
        for ($c = 0; $c < $num; $c++) {
          if ($headerOfTelcMember[$c] == "birthday") {
            $item->birthday = date("Y-m-d", strtotime($data[$c]));
            //            echo $headerOfTelcMember[$c] . ":" .date("Y-m-d", strtotime($data[$c]))  . "//-";
          } else if ($headerOfTelcMember[$c] == "examDate") {
            if (strlen($data[$c]) == 10) {
              $item->examDate = date("Y-m-d", strtotime($data[$c]));
              //              echo $headerOfTelcMember[$c] . ":" .date("Y-m-d", strtotime($data[$c]))  . "//-";
            } else if (strlen($data[$c]) == 13) {
              $item->examDate = date("Y-m-d", strtotime(substr($data[$c], 0, 2) . substr($data[$c], 5, 8)));
              //              echo $headerOfTelcMember[$c] . ":" .date("Y-m-d", strtotime(substr($data[$c],0,2) . substr($data[$c],5,8)))  . "//-";
            } else {
              echo $headerOfTelcMember[$c] . ":" . $data[$c] . "falseformoh//-";
            }
          } else if ($headerOfTelcMember[$c] == "archiveNumber") {
            $item->archiveNumber = $data[$c];
          } else if ($headerOfTelcMember[$c] == "memberNr") {
            $item->memberNr = $data[$c];
          } else if ($headerOfTelcMember[$c] == "gender") {
            $item->gender = $data[$c];
          } else if ($headerOfTelcMember[$c] == "lastName") {
            $item->lastName = $data[$c];
          } else if ($headerOfTelcMember[$c] == "firstName") {
            $item->firstName = $data[$c];
          } else if ($headerOfTelcMember[$c] == "birthCountry") {
            $item->birthCountry = $data[$c];
          } else if ($headerOfTelcMember[$c] == "email") {
            $item->email = $data[$c];
          } else if ($headerOfTelcMember[$c] == "mobile") {
            if ($data[$c] !== 'FALSE') {
              $item->mobile = $data[$c];
            }
          } else if ($headerOfTelcMember[$c] == "examType") {
            $item->examType = $data[$c];
          } else if ($headerOfTelcMember[$c] == "remarks") {
            $item->remarks = $data[$c];
          } else if ($headerOfTelcMember[$c] == "passed") {
            if ($data[$c] == 'TRUE') {
              $item->passed = 1;
            } else {
              $item->passed = 0;
            }
          } else {
            //            echo $headerOfTelcMember[$c] . ":" . $data[$c] . "//-";
          }
        }
        $item->save();
      }
      fclose($handle);
      echo 'fertig';
    } else {
      return 'false';
    }
  }
}


//add last telc exam


$ModelController = new cls_ModelController();
