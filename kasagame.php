<?php
require_once('config.php');
session_start();

$merchant_id="179"; //Mağaza ID
$api_key="71fff565e99086ea80022b1041586286"; //Oluşturulan API Key
$return_id=$_SESSION["username"]; // Üye kullanıcı adı session yakalamak için
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://kasagame.com/api/", //KASAGAME API
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "json",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "merchant_id=$merchant_id&api_key=$api_key&return_id=$return_id",
  CURLOPT_HTTPHEADER => array(
    "cache-control: no-cache",
    "content-type: application/x-www-form-urlencoded",
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
	
$obj = json_decode($response);
if ($obj->success=="100")
{
  Header("Location: $obj->message");
}
else
{
  echo $response;
}

}