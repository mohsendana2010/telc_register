<?php
/**
 * Created by PhpStorm.
 * User: 49176
 * Date: 13.01.2021
 * Time: 18:53
 */

use Defuse\Crypto\Key;
use Defuse\Crypto\Crypto;
use Defuse\Crypto\KeyProtectedByPassword;


class cls_Encryption
{
  function loadEncryptionKeyFromConfig()
  {
//    $keyAscii = "097 100 102";// ... load the contents of /etc/daveapp-secret-key.txt
//    return Key::loadFromAsciiSafeString($keyAscii);
    $key = \Dcrypt\OpensslKey::create(32);
    return "bMyww5qYpWykE2u2tJQYcV8tAH+6QUrrqm4620bf04I=";
  }

  function encrypt($secret_data)
  {
    $key = $this->loadEncryptionKeyFromConfig();
    $encrypted = $this->encryptWithKey($secret_data, $key);
    return $encrypted;
  }

  function decrypt($secret_data)
  {
    $key = $this->loadEncryptionKeyFromConfig();
    $plaintext = $this->decryptWithKey($secret_data, $key);
    return $plaintext;
  }

  function encryptWithKey($secret_data, $key)
  {
    $encrypted = \Dcrypt\Aes::encrypt($secret_data, $key);
    return $encrypted;
  }

  function decryptWithKey($secret_data, $key)
  {
    $plaintext = \Dcrypt\Aes::decrypt($secret_data, $key);
    return $plaintext;
  }

  function CreateUserAccount($password)
  {
    // ... other user account creation stuff, including password hashing

    $protected_key = KeyProtectedByPassword::createRandomPasswordProtectedKey($password);
    $protected_key_encoded = $protected_key->saveToAsciiSafeString();
    return $protected_key_encoded;
    // ... save $protected_key_encoded into the user's account record
  }

  private function hashPasswordSalt()
  {
    return "kE2u2tJQYcV8tAH+asf52h1jjkE2u2tJQYcV8tAH+4";
  }

  function encryptHashPassword($password)
  {
    return password_hash($password . $this->hashPasswordSalt(), PASSWORD_DEFAULT);
//     $optionen = [
//       'cost' => 12,
//     ];
//    return password_hash("mohsen", PASSWORD_BCRYPT, $optionen)
  }

  /**
   * verify hash password from data base
   * @param $password string  password from user
   * @param $hashedPassword string password from database
   * @return boolean
   */
  function verifyHashPassword($password, $hashedPassword)
  {
    if (password_verify($password. $this->hashPasswordSalt(), $hashedPassword)) {
      return true;
    } else {
      return false;
    }
  }


}