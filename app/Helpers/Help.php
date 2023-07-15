<?php

namespace App\Helpers;

class Help
{
   static function syscrypt($action, $string)
   {
      $output = false;
      $method = 'AES-128-CBC';
      $key    = 'PerfectPlay-2023';
      $iv     = 'A#78@568A8799QD5';
      $key    = hash('md5', $key);    
      $iv     = mb_substr(hash('md5', $iv), 0, 16);

      if ( $action == 'E89' ) {
          $output = openssl_encrypt($string, $method, $key, 0, $iv);
          $output = base64_encode($output);
      } else if( $action == 'D98' ) {
          $output = openssl_decrypt(base64_decode($string), $method, $key, 0, $iv);
      }

      return $output;
   }

}