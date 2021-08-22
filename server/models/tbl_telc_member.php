<?php
/**
 * Created by PhpStorm.
 * User: 49176
 * Date: 13.06.2021
 * Time: 22:29
 */

include_once('./DB_Connection/cls_DB_Object.php');
require_once('./util/helper.php');

class tbl_telc_member extends generalModels
{

  protected static $table_name = 'tbl_telc_member';
  public $showFields = ['id', 'archiveNumber', 'sheetNumber', 'memberNr', 'firstName', 'lastName', 'gender', 'birthday', 'email', 'mobile', 'co', 'streetNr', 'postCode', 'place', 'country', 'birthCountry', 'birthCity', 'examDate', 'examType', 'title', 'nativeLanguage', 'partExam', 'lastMemberNr', 'description', 'accommodationRequest', 'newsletterSubscribe', 'remarks', 'passed', 'grades', 'registerDate', 'registerTime'];

  function __construct()
  {
    parent::__construct(self::$table_name);
  }

  public function save()
  {
    $this->registerDate = date('Y-m-d');
    $this->registerTime = date('H:i:s');
    return cls_DB_Object::save();
  }

  /**
   * @return bool
   */
  public function update()
  {
    if ($this->authorization->access) {
      if (isset($_POST['passed'])) {
        if ($_POST['passed'] == 'true')
          $this->passed = 1;
        else
          $this->passed = false;
      }
      return cls_DB_Object::save();
    }
  }



//  public function fields()
//  {
//    for ($i = 0; $i < count(self::$db_fields); $i++) {
//      if (strpos(self::$db_fields[$i], 'adder') === false && self::$db_fields[$i] != 'TS' ){
////        $showFields[] = self::$db_fields[$i];
//        array_push($this->showFields, self::$db_fields[$i]);
//      }
//    }
//    return ($this->showFields);
//  }

  public function fields()
  {
//    for ($i = 0; $i < count(self::$db_fields); $i++) {
//      array_push($this->showFields, self::$db_fields[$i]);
//    }
    return ($this->showFields);
  }


  function makeTelcBodyEmail($item)
  {
    $tabHteml = '' &#160;&#160;&#160;&#160;';
      $mailText = 'Sehr ';

    $item->gender == 'male' ? $mailText .= ' geehrter Herr ' : $mailText .= 'geehrte Frau ';
//    if ($item->gender == 'male') {
//      $mailText .= ' geehrter Herr ';
//    } else {
//      $mailText .= 'geehrte Frau ';
//    }
    $mailText .= ucfirst($item->firstName) . ' ' . ucfirst($item->lastName) . '<br/>';
    $mailText .= 'Sie haben sich erfolgreich für die telc-Prüfung angemeldet' . '<br/>' . '<br/>';
    $mailText .= 'Die von Ihnen zugesandten Daten lauten:' . '<br/>';
    $mailText .= $tabHteml . 'Name:' . ucfirst($item->lastName) . '<br/>';
    $mailText .= $tabHteml . 'Vorname:  ' . ucfirst($item->firstName) . '<br/>';
    $mailText .= $tabHteml . 'Email:  ' . $item->email . '<br/>';
    $mailText .= $tabHteml . 'Prüfungs Niveau:  ' . $item->examType . '<br/>';
    $mailText .= $tabHteml . 'Prüfungs Datum:  ' . $item->examDate . '<br/>';
    if ($item->description != '') {
      $mailText .= $tabHteml . 'Ihre Nachricht:  ' . $item->description . '<br/>';
    }

    $mailText .= '<br/>';
    $mailText .= 'Innerhalb der nächsten zwei Arbeitstagen erhalten Sie eine persönliche Bestätigung von unseren Mitarbeitern.' . '<br/>';
    $mailText .= 'Dabei erhalten Sie weitere Informationen.' . '<br/>' . '<br/>';

    $mailText .= 'Mit freundlichen Grüßen' . '<br/>';
    $mailText .= 'Diwan-Marburg Akademie' . '<br/>' . '<br/>';

    $mailText .= 'Sollten Diese Email nicht Für Sie bestimmen sein, bitte ignorieren Sie diese.' . '<br/>' . '<br/>';

    $mailText .= 'www.diwan-marburg.de' . '<br/>';
    $mailText .= 'Tel.: 06421-9839100' . '<br/>';
    $mailText .= 'Neue Kasseler Str. 2' . '<br/>';
    $mailText .= '35039 Marburg' . '<br/>';
    $mailText .= '&#9993;Email: info@diwan-marburg.de' . '<br/>' . '<br/>';

    $mailText .= 'Bitte besuchen Sie unseren Kanal für mehr Allgemeinwissen unter' . '<br/>';
    $mailText .= 'https//t.me/telc_c1' . '<br/>';
    return $mailText;
  }

}
