<?php
namespace App\Helpers;

class DsHttp {
  public static function post($url, $body, $headers = []){
    $ch = curl_init();

    // set url 
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);

    $payload = json_encode( $body );
    curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );
    curl_setopt( $ch, CURLOPT_HTTPHEADER, [...$headers, 'Content-Type:application/json']);

    // return the transfer as a string 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    // $output contains the output string 
    $output = curl_exec($ch);

    // tutup curl 
    curl_close($ch);

    $result = json_decode($output);
    if(is_bool($result)) return $output;
    return $result;
  }
  public static function getData($url)
  {
    $ch = curl_init();

    // set url 
    curl_setopt($ch, CURLOPT_URL, $url);

    // return the transfer as a string 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    // $output contains the output string 
    $output = curl_exec($ch);

    // tutup curl 
    curl_close($ch);

    $result = json_decode($output);
    if(is_bool($result)) return $output;
    return $result;
  }
}