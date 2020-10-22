<?php
/**
 * Created by PhpStorm.
 * User: 49176
 * Date: 19.10.2020
 * Time: 12:06
 */

function br() {
  return "<br />";
}

function hr() {
  return "<hr />";
}

function pre() {
  return "<pre>";
}

function e_pre() {
  return "</pre>";
}

function a() {
  return "<a>";
}

function e_a() {
  return "</a>";
}

function li() {
  return "<li>";
}

function e_li() {
  return "</li>";
}

function p() {
  return "<p>";
}

function e_p() {
  return "</p>";
}

function ppE() {
  return "../";
}

function redirect_to($new_location) {
  echo '<script> location.replace("../' . $new_location . '"); </script>';
  //header("Location:" . $new_location);
  exit();
}

function output_message($message = "") {
  if (!empty($message)) {
    return "<p class=\"message\">{$message}</p>";
  } else {
    return "";
  }
}

function __autoload($class_name) {
  $class_name = strtolower($class_name);
  $path = "../include/{$class_name}.php";
  if (file_exists($path)) {
    require_once($path);
  } else {
    die("The file {$class_name}.php could not be found");
  }
}

function form_errors($errors = array()) {
  $autput = "";
  if (!empty($errors)) {
    $autput .= "<div class=\"error\"> Please fix the following errors: <ul>";
    foreach ($errors as $key => $error) {
      $autput .= "<li>{$error}</li>";
    }
    $autput .= "</ul></div>";
  }
  return $autput;
}

function password_encrypt($password) {

  $hashed_format = "$2y$10$";
  $salt_length = 22;
  $salt = generate_salt($salt_length);
  $format_and_solt = $hashed_format . $salt;
  $hash = crypt($password, $format_and_solt);
  return $hash;
}

function generate_salt($length) {
  $unique_random_string = md5(uniqid(mt_rand(), TRUE));
  $base64_string = base64_decode($unique_random_string);
  $modified_base64_string = str_replace("+", ".", $base64_string);
  $salt = substr($modified_base64_string, 0, $length);
  return $salt;
}

function password_check($password, $existing_hash) {
  $hash = crypt($password, $existing_hash);
  if ($hash === $existing_hash) {
    return TRUE;
  } else {
    return false;
  }
}

function confirm_logged_in() {
  if (!isset($_SESSION["admin_id"])) { //$_SESSION["admin_id"] == admin
    redirect_to("login.php");
  }
}

function server_varriables() {
  if (isset($_SERVER)) {
    //server details
    $server_name = $_SERVER["SERVER_NAME"];
    $server_Address = $_SERVER["SERVER_ADDR"];
    $server_port = $_SERVER["SERVER_PORT"];
    $document_root = $_SERVER["DOCUMENT_ROOT"];
    //page details
    $php_self = $_SERVER["PHP_SELF"];
    $script_filename = $_SERVER["SCRIPT_FILENAME"];
    //request details
    $remote_addr = $_SERVER["REMOTE_ADDR"];
    $remote_port = $_SERVER["REMOTE_PORT"];
    $request_uri = $_SERVER["REQUEST_URI"];
    $query_string = $_SERVER["QUERY_STRING"];
    $request_method = $_SERVER["REQUEST_METHOD"];
    $request_time = $_SERVER["REQUEST_TIME"];
    $http_referer = $_SERVER["HTTP_REFERER"];
    $http_user_agent = $_SERVER["HTTP_USER_AGENT"];

    $output = br() . "server details :" . br() . $server_name . br() . $server_Address . br() . $server_port;
    $output .= br() . $document_root . "<br /><br />" . "page details:" . br() . $php_self . br() . $script_filename;
    $output .= "<br /><br />" . "request details:" . br() . $remote_addr . br() . $remote_port . br();
    $output .= $request_uri . br() . $query_string . br() . $request_method;
    $output .= br() . $request_time . br() . $http_referer . br();
    $output .= $http_user_agent . br();
    return $output;
  }
}

?>