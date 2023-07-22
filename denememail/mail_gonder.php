<?php
require("class.phpmailer.php");
$mail = new PHPMailer(); // create a new object
$mail->IsSMTP(); // enable SMTP
$mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
$mail->SMTPAuth = true; // authentication enabled
$mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
$mail->Host = "31.192.214.197";
$mail->Port = 465; // or 587
$mail->IsHTML(true);
$mail->SetLanguage("tr", "phpmailer/language");
$mail->CharSet  ="utf-8";

$mail->Username = "candycraft@minecraft.com.tc"; // Mail adresi
$mail->Password = "8g3?OSQcc!vv"; // Parola
$mail->SetFrom("candycraft@minecraft.com.tc", "Baslik"); // Mail adresi

$mail->AddAddress("seven.ozan@hotmail.com"); // Gönderilecek kişi

$mail->Subject = "Siteden Gönderildi";
$mail->Body = "$name<br />$email<br />$subject<br />$message";

if(!$mail->Send()){
                echo "Mailer Error: ".$mail->ErrorInfo;
} else {
                echo "Message has been sent";
}

?>