<?php
/**
 * Created by PhpStorm.
 * User: 49176
 * Date: 19.10.2020
 * Time: 10:18
 */

define("dbhost", "localhost");
define("dbuser", "root");
define("dbpass", "");
define("dbname", "diwan");

//define("dbhost", "db770598120.hosting-data.io");
//define("dbuser", "dbo770598120");
//define("dbpass", "Diwan12345Diwan");
//define("dbname", "db770598120");


class cls_DB_Connection
{

  private $connection;
  private $last_query;
  private $magic_quotes_active;
  private $real_escape_string_exist;

  function __construct() {
    $this->magic_quotes_active = get_magic_quotes_gpc();
    $this->real_escape_string_exist = function_exists("mysqli_real_escape_string");
    $this->open_connection();
  }

  public function open_connection() {
    $this->connection = mysqli_connect(dbhost, dbuser, dbpass, dbname);
    if (!$this->connection) {
      die("Database connection failedd mmm" . mysqli_error());
    }
  }

  public function close_connection() {
    if (isset($this->connection)) {
      mysqli_close($this->connection);
      unset($this->connection);
    }
  }

  public function confirm_query($result_set) {
    if (!$result_set) {
      $output = "Database query is failed! ";
      $output .= mysqli_connect_error() . "<br />" . "<br />";
      $output .= "Last SQL Qurey: " . $this->last_query;
      die($output);
    }
  }

  public function query($sql_query) {
    $this->last_query = $sql_query;
    $result = mysqli_query($this->connection, $sql_query);
    $this->confirm_query($result);
    return $result;
  }

  public function escape_value($value) {

    if ($this->real_escape_string_exist) { //php v. 4.3.0 or higher
      if ($this->magic_quotes_active) {
        $value = stripslashes($value);
      } else {
        $value = mysqli_real_escape_string($this->connection, $value);
      }
    } else {//before php v.4.3.0
      if (!$this->magic_quotes_active) {
        $value = addcslashes($value, "\\");
      }
    }
    return $value;
  }

  public function fetch_assoc($result_set) {
    return mysqli_fetch_assoc($result_set);
  }

  public function num_rows($result_set) {
    return mysqli_num_rows($result_set);
  }

  public function insert_id() {
    return mysqli_insert_id($this->connection);
  }

  public function affected_rows() {
    return mysqli_affected_rows($this->connection);
  }

}

$database = new cls_DB_Connection();