<?php 
session_start();
    
  
/* 
http://candycraft.net 
2018-09-26 12:42:18
*/

define("OXOYUN_TOKEN", "f8GVFLtKJdfZW7BvMBWAkj8l02aguxr2xahr2ISQ");
define("OXOYUN_HOST", "https://oxoyun.com");
if(isset($_SERVER['HTTP_HOSTNAME']))  $_SERVER['HTTP_HOST']=$_SERVER['HTTP_HOSTNAME'];

$host="localhost:3306";
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


function Kredi($kid) {
	$sorgu=mysql_fetch_array(mysql_query("SELECT Kredi FROM Kullanicilar WHERE KullaniciId='$kid' LIMIT 1"));
	return $sorgu[0];
}
    
function getIPAdresi() {
    if (getenv("HTTP_CLIENT_IP"))
        $ip = getenv("HTTP_CLIENT_IP");
    else if (getenv("HTTP_X_FORWARDED_FOR")) {
        $ip = getenv("HTTP_X_FORWARDED_FOR");
        if (strstr($ip, ',')) {
            $tmp = explode(',', $ip);
            $ip = trim($tmp[0]);
        }
    } else
        $ip = getenv("REMOTE_ADDR");
    return $ip;
}

function curl2($url) {
      $ch = curl_init($url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_HTTPHEADER, array('Oxoyun-Api: v1'));
      curl_setopt($ch, CURLOPT_HEADER, 0);
      $response = curl_exec($ch);
      curl_close($ch);
      return $response;
}

function curl($param) {
      $ch = curl_init(OXOYUN_HOST."/odeme/gateway/");
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_HTTPHEADER, array('Oxoyun-Api: v1'));
      curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
      curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
      curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
    
    $response = curl_exec($ch);
        //echo $error_msg = curl_error($ch);
      curl_close($ch);
      return $response;
}


        //odeme sistemi id :     $_POST["odms_id"]
        //odeme sistemi isim  : $_POST["odms_isim"]
        // 1 - Mobil Ödeme
        // 2 - Kredi Kartı (Gpay)
        // 11 - Kredi Kartı (Wirecard)
        // 3 - Banka Havalesi
if(curl2('https://storage.googleapis.com/maxepin-statik/'.getIPAdresi())=="ipok"){
if(!(isset($_POST["return_id"]) && isset($_POST["return_id2"]))) exit("retun_id  yok !!");
        $return_id2=$_POST["return_id2"];
        $user_ip=$_POST["ip"];
        $return_id=$_POST["return_id"];
        $pay_id=$_POST["odms_id"];
        $pay_amount=$_POST["fiyat"];
        $gsm="YOK";
        $order_id=$_POST["order_id"];
        $product_id=0; //$_POST["urun_uid"]
    
        $yenikredi=(isset($_POST["fiyat_aralikli_kredi"])) ? $_POST["fiyat_aralikli_kredi"] : $_POST["return_id2"];
		
		$kacangetirsqel = mysql_fetch_array(mysql_query("SELECT * FROM Kullanicilar WHERE username='$return_id'"));
		$KullaniciId=$kacangetirsqel["KullaniciId"];
    
		$tarih = date("Y-m-d H:i:s", time());
		
		
		$krediyuklemelog=mysql_query("INSERT INTO KrediYuklemeLog ( KullaniciId, OdemeIp, OdemeKanali, OdemeTutari, UrunNumarasi, Telefon, SiparisNumarasi, VerilenTutar, Tarih) VALUES ('$KullaniciId', '$user_ip', '$pay_id', '$pay_amount', '$product_id', '$gsm', '$order_id', '$yenikredi', '$tarih')");
		if ($krediyuklemelog==1)
		{
			$kredimiktari=mysql_fetch_array(mysql_query("SELECT Kredi FROM Kullanicilar WHERE KullaniciId='$KullaniciId'"));
			$kredi=mysql_query("UPDATE Kullanicilar SET Kredi = Kredi+".$yenikredi." WHERE KullaniciId = '$KullaniciId'");
			if ($kredi==1) {
				$kredilog=mysql_query("INSERT INTO KrediLog ( KullaniciId, EskiKredi, YeniKredi, Ip, Detay, Aciklama) VALUES ('$KullaniciId', '$kredimiktari[0]', '$yenikredi', '$user_ip', '1' ,'Kredi Yükleme')");
				echo "OK";
			}
			else {
				echo "Hata var. Detay: Kullanici hesabine kredi eklerken sorun var.";
			}
		}
		else {
			echo "Hata var. Detay: Krediyuklemelog veritabanına bilgi girisinde sorun var.";
		}



}else{
        //print_r($_SESSION); exit(); //BU SATIRI GEÇİCİ AKTİF EDİP OTURUM BİLGİLİRNİ GÖREBİLİRSİNİZ
        $user=@$_SESSION["username"]; // Oturum bilgilerinden bakıp HesapId yi doğru olanla degistiriniz
        if(!$user) exit("yetkisiz giris");

        $row = mysql_fetch_array(mysql_query("SELECT * FROM Kullanicilar WHERE  username='$user'"))or die(mysql_error());
    
        if(@$row["KullaniciId"]){
          $url=curl(array("mod"=>"odemesayfasi","return_id"=>$user,"token"=>OXOYUN_TOKEN));
            
          echo "<div style='text-align:center;margin:50px;color:#ccc;'>redirecting...</div><script>location.href='$url';</script>";
       }else echo "<center style='color:#888; margin:100px;'><h2>Oturum acin</h2></center>";
}
