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

  protected static $table_name = 'tbl_telcmember';
  protected static $db_fields = array('id', 'archiveNumber', 'sheetNumber', 'memberNr', 'firstName', 'lastName', 'gender',
    'birthday', 'email', 'mobile', 'co', 'streetNr', 'postCode', 'place', 'country', 'birthCountry', 'birthCity',
    'job', 'examDate', 'examType', 'payment', 'paymentDate', 'paymentType', 'title', 'phone', 'fax',
    'nativeLanguage', 'partExam', 'lastMemberNr', 'description', 'accommodationRequest', 'newsletterSubscribe',
    'remarks', 'passed', 'grades', 'registerDate', 'registerTime');


  function __construct()
  {
    foreach (self::$db_fields as $key)
    {
      $this->{$key} = null;
    }
  }

  public static $instance_count = 0;
  public static $sql_count = 0;
  public $authorization;

  public function save()
  {
    $this->registerDate = date('Y-m-d');
    $this->registerTime = date('H:i');
    return parent::save();
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

      return parent::save();
    }
  }


  public function delete()
  {
    if ($this->authorization->access) {
      return parent::delete();
    }
  }

  public function find_all($jsonEncode = true, $field = '*')
  {
    if ($this->authorization->access) {
      return parent::find_all($jsonEncode, $field);
    }
  }


  public $showFields = ['id', 'archiveNumber', 'sheetNumber', 'memberNr', 'firstName', 'lastName', 'gender', 'birthday', 'email', 'mobile', 'co', 'streetNr', 'postCode', 'place', 'country', 'birthCountry', 'birthCity', 'examDate', 'examType', 'title', 'nativeLanguage', 'partExam', 'lastMemberNr', 'description', 'accommodationRequest', 'newsletterSubscribe', 'remarks', 'passed', 'grades', 'registerDate', 'registerTime'];

  public function setShowFields()
  {
//    for ($i = 0; $i < count(self::$db_fields); $i++) {
//      array_push($this->showFields, self::$db_fields[$i]);
//    }
    return $this->showFields;
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

  public function testAddNewTable()
  {
    return $this->getAllTabels();
  }
}


