<?php
//include_once (path::$path_DBobject);
include_once('../DB_Connection/cls_DB_Object.php');

class tbl_TelcRegister extends cls_DB_Object {

  protected static $table_name = "tbl_TelcRegister";
  protected static $db_fields = array( "Id", "memberNr", "firstName", "lastName", "gender", "birthday", "Email", "mobile",
    "co", "streetNr", "postCode", "place", "country", "birthCountry", "birthCity", "job", "examDate", "examType",
    "payment", "paymentDate", "paymentType", "fastResults", "title", "phone", "fax", "message");

  public $Id; public $memberNr; public $firstName; public $lastName; public $gender; public $birthday; public $Email;
  public $mobile; public $co; public $streetNr; public $postCode; public $place; public $country; public $birthCountry;
  public $birthCity; public $job; public $examDate; public $examType; public $payment; public $paymentDate;
  public $paymentType; public $fastResult;public $title; public $phone; public $fax; public $message;

  public static $instance_count = 0;
  public static $sql_count = 0;



}

?>