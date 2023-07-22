<?php
$host="87.248.157.101";
$kullaniciadi="candycra_site";
$sifre="pw9ND4pZXY4o@!";
$veritabaniadi="candycra_kpanel";

$baglanti = @mysql_connect($host, $kullaniciadi, $sifre);
$veritabani = @mysql_select_db($veritabaniadi);
 
if($baglanti && $veritabani) {

} else {
   echo 'Veritabani baglantisi kurulamadi. Lutfen config.php dosyasini kontrol ediniz.';
}
mysql_query("SET NAMES UTF8");

date_default_timezone_set('Europe/Istanbul');

function GetIP(){
	if(getenv("HTTP_CLIENT_IP")) {
		$ip = getenv("HTTP_CLIENT_IP");
	}
	elseif(getenv("HTTP_X_FORWARDED_FOR"))
	{
		$ip = getenv("HTTP_X_FORWARDED_FOR");
		if (strstr($ip, ',')) {
			$tmp = explode (',', $ip);
			$ip = trim($tmp[0]);
		} 
	} 
	else { 
		$ip = getenv("REMOTE_ADDR");
	}
	return $ip; 
}

function Sifrele($veri) {
	$char=array_merge(range('0', '9'), range('a', 'f'));
	$maxCharIndex = count($char) - 1;
	$salt="";
	for ($i = 0; $i < 16; ++$i) {
		$salt .= $char[mt_rand(0, $maxCharIndex)];
	}
	$s1='$SHA$' . $salt . '$' . hash('sha256', hash('sha256', $veri). $salt);
	return $s1;
}

function SifreleSite($veri) {
	$s1 = md5($veri);
	$s2 = sha1($s1);
	$s3 = crc32($s2);
	return $s3;
}

function Kontrol($nick){
	return preg_match('/[^a-zA-Z0-9_]/', $nick);
}

function KontrolSifre($sifre) {
	if (preg_match('/[^a-zA-Z0-9_]/', $sifre)) {
		return true;
    }
    else {
        return false;
    }
} 

function EmailKontrol($email){
      $pattern = "^[_a-z0-9-]+(.[_a-z0-9-]+)*@[a-z0-9-]+(.[a-z0-9-]+)*(.[a-z]{2,3})$";
      if (eregi($pattern, $email)){
         return true;
      }
      else {
         return false;
      }
}

function uuidFromString($string) {
    $val = md5($string, true);
    $byte = array_values(unpack('C16', $val));

    $tLo = ($byte[0] << 24) | ($byte[1] << 16) | ($byte[2] << 8) | $byte[3];
    $tMi = ($byte[4] << 8) | $byte[5];
    $tHi = ($byte[6] << 8) | $byte[7];
    $csLo = $byte[9];
    $csHi = $byte[8] & 0x3f | (1 << 7);

    if (pack('L', 0x6162797A) == pack('N', 0x6162797A)) {
        $tLo = (($tLo & 0x000000ff) << 24) | (($tLo & 0x0000ff00) << 8) | (($tLo & 0x00ff0000) >> 8) | (($tLo & 0xff000000) >> 24);
        $tMi = (($tMi & 0x00ff) << 8) | (($tMi & 0xff00) >> 8);
        $tHi = (($tHi & 0x00ff) << 8) | (($tHi & 0xff00) >> 8);
    }

    $tHi &= 0x0fff;
    $tHi |= (3 << 12);
   
    $uuid = sprintf(
        '%08x-%04x-%04x-%02x%02x-%02x%02x%02x%02x%02x%02x',
        $tLo, $tMi, $tHi, $csHi, $csLo,
        $byte[10], $byte[11], $byte[12], $byte[13], $byte[14], $byte[15]
    );
    return $uuid;
}

function Uuid($string)
{
    $string = uuidFromString("OfflinePlayer:".$string);
    return $string;
}


function Kredi($kid) {
	$sorgu=mysql_fetch_array(mysql_query("SELECT Kredi FROM Kullanicilar WHERE KullaniciId='$kid' LIMIT 1"));
	return $sorgu[0];
}

function TemizVeri($mVar){
	if(is_array($mVar)){ 
	foreach($mVar as $gVal => $gVar){
	if(!is_array($gVar)){
	$mVar[$gVal] = htmlspecialchars(strip_tags(urldecode(mysql_real_escape_string(addslashes(stripslashes(stripslashes(trim(htmlspecialchars_decode($gVar)))))))));
	}else{ 
	$mVar[$gVal] = TemizVeri($gVar);
	}
	}
	}else{
	$mVar = htmlspecialchars(strip_tags(urldecode(mysql_real_escape_string(addslashes(stripslashes(stripslashes(trim(htmlspecialchars_decode($mVar)))))))));
	}
	return $mVar; 
}

function EpostaGonder($kullaniciid,$hash) {
	include ("eposta/sablon.php");
	$mesaj=epostasablon($kullaniciid,$hash);
	$kullanicibilgileri=mysql_fetch_array(mysql_query("SELECT username,email FROM Kullanicilar WHERE KullaniciId='$kullaniciid'"));
	require("eposta/class.phpmailer.php");
	$mail = new PHPMailer();
	$mail->SetLanguage("tr", "phpmailer/language");
	$mail->CharSet  ="utf-8";
	$mail->Encoding="base64";
	$mail->IsSMTP(); 					// send via SMTP
	$mail->isHTML(true);
	$mail->SMTPSecure = 'ssl';
	$mail->Host     = "smtp.yandex.ru"; // SMTP servers
	$mail->SMTPAuth = true;     // turn on SMTP authentication
	$mail->Username = "kullanici@candycraft.net";  // SMTP username
	$mail->Password = "jAURQ2KAsj5SCKEn@!!"; // SMTP password
	$mail->Port     = 465;
	$mail->From     = "kullanici@candycraft.net"; // smtp kullanıcı adınız ile aynı olmalı
	$mail->Fromname = $email_headers;
	$mail->AddAddress("$kullanicibilgileri[1]","$kullanicibilgileri[0]");
	$mail->Subject  =  "Candy Craft Kullanıcı İşlemleri";
	$mail->Body     =  $mesaj;
	
	if(!$mail->Send())
	{
		return "1";
	}
	else 
	{
		return "0";
	}
}

function EpostaHash($uzunluk = 16) {
	$karakterler = 'qwertyuopasdfghjklizxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM1234567890';
	return substr(str_shuffle($karakterler), 0, $uzunluk);
}
?>