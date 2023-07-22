<?php
$magaza_id="179"; //KASAGAME tarafından oluşturulan Mağaza ID
$api_sifre="71fff565e99086ea80022b1041586286"; //KASAGAME tarafından oluşturulan API Key

$callback_data = $_POST;
$amount = $callback_data['amount']; // Sipariş tutarı
$product_id = $callback_data['product_id']; // Ürün No.
$order_id= $_POST["order_id"]; // Sipariş Numarası
$order_date = $callback_data['order_date']; //Sipariş tarihi
$merchant_id = $callback_data['merchant_id']; //Mağaza No.
$return_id = $callback_data['return_id']; //Geri Dönen veri (kulllanıcı adı vs.)
$return_id2 = $callback_data['return_id2']; //Geri Dönen veri (isteğe bağlı opsiyon.)
$user_ip ="127.0.0.1"; //Ödeme yapan ip adresi
$api_key = $callback_data['api_key']; //API Key
$product_return = $callback_data['product_return']; //Ürüne ait dönen veri. 1 ise Vip, 2 ise vip+ ,3 svip , 4 svip+ , 5 uvip, 6 uvip+


if ($merchant_id==$magaza_id && $api_key=$api_sifre)
{

$host="87.248.157.101:3306";
$kullaniciadi="candycra_site";
$sifre="pw9ND4pZXY4o@!";
$veritabaniadi="candycra_kpanel";

$baglanti = @mysql_connect($host, $kullaniciadi, $sifre);
$veritabani = @mysql_select_db($veritabaniadi);
mysql_query("SET NAMES UTF8");

date_default_timezone_set('Europe/Istanbul');
        $yenikredi=$product_return;
		
		$kacangetirsqel = mysql_fetch_array(mysql_query("SELECT * FROM Kullanicilar WHERE username='$return_id'"));
		$KullaniciId=$kacangetirsqel["KullaniciId"];
    
		$tarih = date("Y-m-d H:i:s", time());
		
		$krediyuklemelog=mysql_query("INSERT INTO KrediYuklemeLog ( KullaniciId, OdemeIp, OdemeKanali, OdemeTutari, UrunNumarasi, Telefon, SiparisNumarasi, VerilenTutar, Tarih) VALUES ('$KullaniciId', '$user_ip', '13', '$amount', '$product_id', '$order_id', '$order_id', '$yenikredi', '$tarih')");
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
			echo "Hata var. Detay: Krediyuklemelog veritabanına bilgi girisinde sorun var. -$return_id- ('$KullaniciId', '$user_ip', '13', '$amount', '$product_id', '$order_id', '$order_id', '$yenikredi', '$tarih')";
		}    
//
	
}