<?php
/**
 * Created by PhpStorm.
 * User: 49176
 * Date: 26.12.2020
 * Time: 11:09
 */

use Gregwar\Captcha\CaptchaBuilder;
use Gregwar\Captcha\PhraseBuilder;

require_once('./util/cls_Encryption.php');

class cls_Captcha
{
  private $permitted_chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234678abcdefghijklmnopqrstuvwxyz';

  public function generate_string($input, $strength = 5)
  {
    $input_length = strlen($input);
    $random_string = '';
    for ($i = 0; $i < $strength; $i++) {
      $random_character = $input[mt_rand(0, $input_length - 1)];
      $random_string .= $random_character;
    }

    return $random_string;
  }

  public function captcha_string()
  {
    $string_length = 5;
    return $this->generate_string($this->permitted_chars, $string_length);
  }

  public function generate_captcha()
  {
    $strCaptcha = $this->captcha_string();
//    $strCaptcha =  "hellosal" ;
    $captchaImage = $this->generate_Image($strCaptcha);

    $timeNow = date("Y-m-d H:i:s");

    $encrypt = new cls_Encryption();
    $captchaEncrypt = base64_encode($encrypt->encrypt($strCaptcha . "," . $timeNow));

    $captcha = [];
    $captcha['captchaEncrypt'] = $captchaEncrypt;
    $captcha['captchaImage'] = $captchaImage;

    return json_encode($captcha);
  }

  public function verifying_captcha($captchaEncrypt, $captchaCode)
  {
    $encrypt = new cls_Encryption();
    $captchaDecrypt = $encrypt->decrypt(base64_decode($captchaEncrypt));
    $explodeCaptchaDecrypt = explode(",", $captchaDecrypt);
    $timeNow = date("Y-m-d H:i:s");

    if (strtotime($timeNow) - strtotime($explodeCaptchaDecrypt[1]) <= 180) {

      if (strtoupper($captchaCode) == strtoupper($explodeCaptchaDecrypt[0])) {
        return true;
      } else
        return false;
    } else
      return false;
  }

  public function generate_Image($strCaptcha)
  {
    $builder = new CaptchaBuilder($strCaptcha);
    $builder->build();
//    $builder->save('out.jpg');
    return $builder->inline();
  }


}