<?php
/**
 * Created by PhpStorm.
 * User: 49176
 * Date: 06.12.2020
 * Time: 15:43
 */
require_once('./util/helper.php');


class tbl_telcMember extends cls_DB_Object
{

  protected static $table_name = "tbl_telcmember";
  protected static $db_fields = array("id", "memberNr", "firstName", "lastName", "gender", "birthday", "email", "mobile",
    "co", "streetNr", "postCode", "place", "country", "birthCountry", "birthCity", "job", "examDate", "examType",
    "payment", "paymentDate", "paymentType", "title", "phone", "fax", "nativeLanguage", "partExam",
    "lastMemberNr", "description", "accommodationRequest", "newsletterSubscribe", "registerDate", "registerTime");

  public $id;
  public $memberNr;
  public $firstName;
  public $lastName;
  public $gender;   //male or female
  public $birthday;
  public $email;
  public $mobile;
  public $co;
  public $streetNr;
  public $postCode;
  public $place;
  public $country;
  public $birthCountry;
  public $birthCity;
  public $job;
  public $examDate;
  public $examType;
  public $payment;
  public $paymentDate;
  public $paymentType;
  public $title;
  public $phone;
  public $fax;
  public $nativeLanguage;
  public $partExam;
  public $lastMemberNr;
  public $description;
  public $accommodationRequest;
  public $newsletterSubscribe;
  public $registerDate;
  public $registerTime;

  public static $instance_count = 0;
  public static $sql_count = 0;
  public $authorization;

  public function save()
  {
    $this->registerDate = date("Y-m-d");
    $this->registerTime = date("H:i");
    if (isset($_POST['id'])) {
      if ($this->authorization->access) {
        return parent::save();
      }
    } else {
      return parent::save();
    }

  }

  public function delete()
  {
    if ($this->authorization->access) {
      return parent::delete();
    }
  }

  public function find_all()
  {
    if ($this->authorization->access) {
      return parent::find_all();
    }
  }



  public $showFields = ["id", "memberNr", "firstName", "lastName", "gender", "birthday", "email", "mobile", "co",
    "streetNr", "postCode", "place", "country", "birthCountry", "birthCity", "examDate", "examType", "title",
    "nativeLanguage", "partExam", "lastMemberNr", "description", "accommodationRequest", "newsletterSubscribe",
    "registerDate", "registerTime"];

  public function setShowFields()
  {
//    for ($i = 0; $i < count(self::$db_fields); $i++) {
//      array_push($this->showFields, self::$db_fields[$i]);
//    }
    return $this->showFields;
  }


  function makeTelcBodyEmail($item)
  {
    $tabHteml = "&#160;&#160;&#160;&#160;";
    $mailText = "Sehr ";

    if ($item->gender == "male") {
      $mailText .= " geehrter Herr ";
    } else {
      $mailText .= "geehrte Frau ";
    }
    $mailText .= ucfirst($item->firstName) . ' ' . ucfirst($item->lastName) . "<br/>";
    $mailText .= "Sie haben sich erfolgreich für die telc-Prüfung angemeldet" . "<br/>" . "<br/>";
    $mailText .= "Die von Ihnen zugesandten Daten lauten:" . "<br/>";
    $mailText .= $tabHteml . "Name:" . ucfirst($item->lastName) . "<br/>";
    $mailText .= $tabHteml . "Vorname:  " . ucfirst($item->firstName) . "<br/>";
    $mailText .= $tabHteml . "Email:  " . $item->email . "<br/>";
    $mailText .= $tabHteml . "Prüfungs Niveau:  " . $item->examType . "<br/>";
    $mailText .= $tabHteml . "Prüfungs Datum:  " . $item->examDate . "<br/>";
    if ($item->description != "") {
      $mailText .= $tabHteml . "Ihre Nachricht:  " . $item->description . "<br/>";
    }

    $mailText .= "<br/>";
    $mailText .= "Innerhalb der nächsten zwei Arbeitstagen erhalten Sie eine persönliche Bestätigung von unseren Mitarbeitern." . "<br/>";
    $mailText .= "Dabei erhalten Sie weitere Informationen." . "<br/>" . "<br/>";

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


