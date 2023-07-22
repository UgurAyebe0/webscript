<?php  

function yetkivarmi($gorunecekicerik,$gelenyetki,$us_kul_adi_soyadi,$yetki){
	
$hgetir= mysql_fetch_array(mysql_query("SELECT * FROM personeller_yetkileri WHERE  personel_kullanici_adi='$us_kul_adi_soyadi' and yetki_adi='$gelenyetki'"));  
        $yetki_adi=$hgetir["yetki_adi"];  
		if($yetki_adi!="" or $yetki=="1" ){
			echo $gorunecekicerik;
		}
}

function ihsanguvenlik(){
	
	session_start();
header("content-type: text/html; charset=utf-8");
if(!isset($_SESSION['ilk_zaman'])){
  $_SESSION['ilk_zaman'] = time();
}else{
  $_SESSION['giris']++;
}
if($_SESSION['giris']>=3 && (time() - $_SESSION['ilk_zaman']<5)){
    die("Adresinizden yuksek baglanti geldigi icin suan engelledik. Bir kac saniye sonra tekrar dene");
}else if((time() - $_SESSION['ilk_zaman'])>=5){
   $_SESSION['ilk_zaman'] = time();
   $_SESSION['giris']     = 0;
}

}
function ytlFormat($para){ return @number_format($para,2,',','.');}  

set_time_limit(0);

date_default_timezone_set('Europe/Istanbul');

function sendRequest($site_name,$send_xml,$header_type=array('Content-Type: text/xml'))
{
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,$site_name);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS,$send_xml);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch, CURLOPT_HTTPHEADER,$header_type);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	@curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_TIMEOUT, 120);

	$result = curl_exec($ch);

	return $result;
}function yuzde($sayi, $yuzde_deger,$secenek){
 
$yuzdemiz = ($sayi * $yuzde_deger) / 100;
$fark = $sayi - $yuzdemiz;
$topla = $sayi + $yuzdemiz;
$carp = $sayi * $yuzdemiz;
$bol = $sayi / $yuzdemiz;
 
if($secenek == 1){
return $yuzdemiz;
}else if($secenek == 2){
return $fark;
}else if($secenek == 3){
return $topla;
}else if($secenek == 4){
return $carp;
}else if($secenek == 5){
return $bol;
}else{
return $yuzdemiz;
}
}

function logtut($commerce_id,$icerik){ 
$ekle = mysql_query("INSERT INTO loglar (commerce_id, icerik) VALUES ('$commerce_id', '$icerik')");
if($ekle){
 
}else{
echo "Log Eklenemedi";
}
}

function kasakayitekle($aciklama,$tur,$cari,$giren,$cikan,$baglan)
{ 

// $islem_tarihiaada= date("Y-m-d H:i:s"); 
// $kasayakayiteklesql = mysql_query("INSERT INTO kasa (tarih, aciklama,tur,cari,giren,cikan) VALUES ('$islem_tarihiaada', '$aciklama','$tur','$cari','$giren','$cikan')",$baglan);
// if($kasayakayiteklesql){
 
// }else{
// echo "Kasaya Kayıt Eklenemedi";
// echo mysql_error();
// }
}


function ihsanlog($kullanici_adiasdada,$sayfa_linkiassadd){ 

$yerel_adres=getenv("REMOTE_ADDR"); 
$islem_tarihiaada= date("Y.m.d H:i:s"); 
if($sayfa_linkiassadd!="merttugoto.com/admin/bildirimvarmi.php"){
$ekle = mysql_query("INSERT INTO ihsanlog (local_ip,kullanici_adi, sayfa_linki,islem_tarihi) VALUES ('$yerel_adres', '$kullanici_adiasdada', '$sayfa_linkiassadd','$islem_tarihiaada')");
if($ekle){
 
}else{
echo "Log Eklenemedi";
}
}
}

function satirsayisigetir($veritabaniadi,$sorgukodu,$veritabanisi){
	if($veritabanisi==""){
		$sorgukodu="baglan";
	}
	$query = mysql_query("SELECT COUNT(*) FROM $veritabaniadi $sorgukodu",$veritabanisi);
	
$say = mysql_fetch_array($query);
	echo $say[0];
}


function p($par, $st = false)
{
    if( $st ) 
    {
        return mysql_real_escape_string($_POST[$par]);
    }

    return mysql_real_escape_string($_POST[$par]);
}

function result_array($par)
{
    $a = array();
    while ($b = mysql_fetch_array($par)) {
        $a[] = $b;
    }
    return $a;
}

function g($par)
{
    return strip_tags(trim(addslashes(htmlentities($_GET[$par]))));
}  

function GetIP(){
	if(getenv("HTTP_CLIENT_IP")) {
 		$ip = getenv("HTTP_CLIENT_IP");
 	} elseif(getenv("HTTP_X_FORWARDED_FOR")) {
 		$ip = getenv("HTTP_X_FORWARDED_FOR");
 		if (strstr($ip, ',')) {
 			$tmp = explode (',', $ip);
 			$ip = trim($tmp[0]);
 		}
 	} else {
 	$ip = getenv("REMOTE_ADDR");
 	}
return $ip; }
function kisalt($par, $uzunluk = 50)
{
    if( $uzunluk < strlen($par) ) 
    {
        $par = mb_substr($par, 0, $uzunluk, "UTF-8") . "...";
    }

    return $par;
}

function session_olustur($par)
{
    foreach( $par as $anahtar => $deger ) 
    {
        $_SESSION[$anahtar] = $deger;
    }
}

function go($urlsi){
	?>
	<SCRIPT LANGUAGE="JavaScript">
<!-- 
window.location="<?php echo $urlsi; ?>";
// -->
</script>
	<?php
}
function seo($s)
{
 $tr = array('ş','Ş','ı','I','İ','ğ','Ğ','ü','Ü','ö','Ö','Ç','ç','(',')','/',':',',');
 $eng = array('s','s','i','i','i','g','g','u','u','o','o','c','c','','','-','-','');
 $s = str_replace($tr,$eng,$s);
 $s = strtolower($s);
 $s = preg_replace('/&amp;amp;amp;amp;amp;amp;amp;amp;amp;.+?;/', '', $s);
 $s = preg_replace('/\s+/', '-', $s);
 $s = preg_replace('|-+|', '-', $s); 
 $s = preg_replace("@[^a-z0-9\-_şıüğçİŞĞÜÇ]+@i","-",$s);
 $s = preg_replace('/#/', '', $s);
 $s = str_replace('.', '', $s);
 $s = trim($s, '--');
 return $s;
}

function kategoriler()
{
    $kategoriSorgu = mysql_query("SELECT * FROM ckategoriler WHERE flag = 3 ORDER BY id ASC");
    while( $kategoriSonuc = mysql_fetch_object($kategoriSorgu) ) 
    {
        echo "        \t<tr><a title=\"";
        echo $kategoriSonuc->iname;
        echo "\" href=\"kategori-";
        echo $kategoriSonuc->seo;
        echo "\">";
        echo $kategoriSonuc->iname;
        echo "</a></tr>\r\n        ";
    }
}

function slider()
{
    $SliderSorgu = mysql_query("SELECT * FROM slider WHERE durum = 1 ORDER BY id ASC");
    while( $SliderSonuc = mysql_fetch_object($SliderSorgu) ) 
    {
        echo " <img alt=\"";
        echo $SliderSonuc->adi;
        echo "\" style='display: none; width: 555px; height: auto;' src=\"uploads/slider/";
        echo $SliderSonuc->resim;
        echo "\"   />       ";
    }
}

function sepetekle()
{
    if( isset($_GET["ekle"]) ) 
    {
        $gelen = $_GET["ekle"];
        $secenek = implode("|", $_POST["secenek"]);
        $bulundu = false;
        $i = 0;
        if( !isset($_SESSION["urunler"]) || count($_SESSION["urunler"]) < 1 ) 
        {
            $_SESSION["urunler"][] = array( "id" => $gelen, "adet" => intval($_POST["adet"]), "secenek" => $secenek );
        }
        else
        {
            for( $i = 0; $i < count($_SESSION["urunler"]); $i++ ) 
            {
                if( $_SESSION["urunler"][$i]["id"] == $gelen ) 
                {
                    $_SESSION["urunler"][$i]["adet"] += intval($_POST["adet"]);
                    $_SESSION["urunler"][$i]["secenek"] = $secenek;
                    $bulundu = true;
                }

            }
            if( $bulundu == false ) 
            {
                $_SESSION["urunler"][] = array( "id" => $gelen, "adet" => intval($_POST["adet"]), "secenek" => $secenek );
            }

        }

        header("Location:sepet.html");
        exit();
    }

}

function karsilastirmaekle()
{
    if( isset($_GET["kekle"]) ) 
    {
        $kgelen = $_GET["kekle"];
        $bulundu = false;
        $i = 0;
        if( !isset($_SESSION["karsilastirmalar"]) || count($_SESSION["karsilastirmalar"]) < 1 ) 
        {
            $_SESSION["karsilastirmalar"][] = array( "id" => $kgelen );
        }
        else
        {
            for( $i = 0; $i < count($_SESSION["karsilastirmalar"]); $i++ ) 
            {
                if( $_SESSION["karsilastirmalar"][$i]["id"] == $kgelen ) 
                {
                    $bulundu = true;
                }

            }
            if( $bulundu == false ) 
            {
                $_SESSION["karsilastirmalar"][] = array( "id" => $kgelen );
            }

        }

        header("Location:karsilastir.html");
        exit();
    }

}

function upla()
{
    if( $_POST["sid"] ) 
    {
        $urun_id = $_POST["sid"];
        $mesaj["mesaj"] = "Gelen id" . $urun_id;
        echo json_encode($mesaj, JSON_UNESCAPED_UNICODE);
    }

}

function sepetsil()
{
    if( isset($_GET["sil"]) && isset($_GET["sil"]) != "" ) 
    {
        $i = 0;
        $gelen = $_GET["sil"];
        foreach( $_SESSION["urunler"] as $item ) 
        {
            $i++;
            while( list($key, $value) = each($item) ) 
            {
                if( $key == "id" && $value == $gelen ) 
                {
                    array_splice($_SESSION["urunler"], $i - 1, 1);
                }

            }
            header("Location:" . $_SERVER["HTTP_REFERER"]);
        }
        if( $gelen == "" ) 
        {
            unset($_SESSION["urunler"]);
        }

    }

}

function karsilastirmasil()
{
    if( isset($_GET["ksil"]) && isset($_GET["ksil"]) != "" ) 
    {
        $i = 0;
        $gelen = $_GET["ksil"];
        foreach( $_SESSION["karsilastirmalar"] as $item ) 
        {
            $i++;
            while( list($key, $value) = each($item) ) 
            {
                if( $key == "id" && $value == $gelen ) 
                {
                    array_splice($_SESSION["karsilastirmalar"], $i - 1, 1);
                }

            }
            header("Location:" . $_SERVER["HTTP_REFERER"]);
        }
        if( $gelen == "" ) 
        {
            unset($_SESSION["karsilastirmalar"]);
        }

    }

}

function sayfalar()
{
    $SayfaSorgu = mysql_query("SELECT * FROM sayfalar WHERE durum = 1 ORDER BY id ASC");
    while( $SayfaSonuc = mysql_fetch_object($SayfaSorgu) ) 
    {
        echo "\t\t\t <li class=\"link_container\"><a href=\"sayfa-detay-";
        echo $SayfaSonuc->seo;
        echo ".html\">";
        echo $SayfaSonuc->adi;
        echo "</a></li>\r\n         ";
    }
}

function bilgiler()
{
    $SayfaSorgu = mysql_query("SELECT * FROM bilgiler WHERE durum = 1 ORDER BY id ASC");
    while( $SayfaSonuc = mysql_fetch_object($SayfaSorgu) ) 
    {
        echo "\t\t\t <li class=\"link_container\"><a href=\"Bilgiler/";
        echo $SayfaSonuc->seo;
        echo ".html\">";
        echo $SayfaSonuc->adi;
        echo "</a></li>\r\n         ";
    }
}

function reklam()
{
    $Sorgu = Sorgu("SELECT * FROM reklam WHERE durum = '1' ORDER BY id DESC");
    while( $Sonuc = Sonuc($Sorgu) ) 
    {
        echo "   \r\n\t\t\t<li><a href=\"";
        echo $Sonuc->url;
        echo "\"><img src=\"uploads/reklam/kucuk/";
        echo $Sonuc->resim;
        echo "\" alt=\"slide-left\"></a></li>\r\n\t\t";
    }
}

function haberler()
{
    $HaberSorgu = mysql_query("SELECT * FROM haberler WHERE durum = 1 ORDER BY id ASC");
    while( $HaberSonuc = mysql_fetch_object($HaberSorgu) ) 
    {
        echo "<li>\r\n\t\t\t\t<a href=\"haber-detay-" . $HaberSonuc->seo . "\">" . kisalt($HaberSonuc->adi, 30) . "</a>\r\n\t\t\t </li>";
    }
}

function Sorgu($sorgu)
{
    return mysql_query($sorgu);
}
 
function say($say)
{
    return mysql_num_rows($say);
}

function kod($uzunluk = 8, $buyuk_harf = 1, $kucuk_harf = 1, $sayi_kullan = 1, $ozel_karakter = "")
{
    $buyukler = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $kucukler = "abcdefghijklmnopqrstuvwxyz";
    $sayilar = "0123456789";
    if( $buyuk_harf ) 
    {
        $seed_length += 26;
        $seed .= $buyukler;
    }

    if( $kucuk_harf ) 
    {
        $seed_length += 26;
        $seed .= $kucukler;
    }

    if( $sayi_kullan ) 
    {
        $seed_length += 10;
        $seed .= $sayilar;
    }

    if( $ozel_karakter ) 
    {
        $seed_length += strlen($ozel_karakter);
        $seed .= $ozel_karakter;
    }

    for( $x = 1; $x <= $uzunluk; $x++ ) 
    {
        $sifre .= $seed[rand(0, $seed_length - 1)];
    }
    return $sifre;
}

function uret($uzunluk)
    {
 
     if(!is_numeric($uzunluk) || $uzunluk <= 0)
        {
            $uzunluk = 8;
        }
        if($uzunluk  > 32)
        {
            $uzunluk = 32;
        }
 
  $karakter = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
 
  mt_srand(microtime() * 1000000);
 
        for($i = 0; $i < $uzunluk; $i++)
        {
            $key = mt_rand(0,strlen($karakter)-1);
            $pwd = $pwd . $karakter{$key};
        }
 
        for($i = 0; $i < $uzunluk; $i++)
        {
            $key1 = mt_rand(0,strlen($pwd)-1);
            $key2 = mt_rand(0,strlen($pwd)-1);
 
            $tmp = $pwd{$key1};
            $pwd{$key1} = $pwd{$key2};
            $pwd{$key2} = $tmp;
        }
 
        return $pwd;
    }
	
	 

function ip()
{
    if( getenv("HTTP_CLIENT_IP") ) 
    {
        $ip = getenv("HTTP_CLIENT_IP");
    }
    else
    {
        if( getenv("HTTP_X_FORWARDED_FOR") ) 
        {
            $ip = getenv("HTTP_X_FORWARDED_FOR");
            if( strstr($ip, ",") ) 
            {
                $tmp = explode(",", $ip);
                $ip = trim($tmp[0]);
            }

        }
        else
        {
            $ip = getenv("REMOTE_ADDR");
        }

    }

    return $ip;
}

function sipolustur($ip_adresi,$uyeid,$odeme_sekli,$durum,$adres  ,$tarih,$ek,$siparisidsi){
	 	$eee = mysql_query("SELECT * FROM sepet_bekleyen where ip_adresi='$ip_adresi' and sepet_durumu='0'"); 
while($ihqqsan=mysql_fetch_assoc($eee)) 
{  
$id=$ihqqsan["id"];
$urun_fiyati=$ihqqsan["urun_fiyati"];
$toplamurun_fiyati=$toplamurun_fiyati+$urun_fiyati;
}
$sipekle = mysql_query("INSERT INTO siparisler (uyeid, odeme_sekli,durum,adres,fiyat,sno,ip,tarih,ek  ) VALUES ('$uyeid', '$odeme_sekli','$durum','$adres','$toplamurun_fiyati','$id','$ip_adresi','$tarih','$ek' )");
if($sipekle){
	$konu="Siparişiniz Oluşturulmuştur";
   $icerik = 'Ad Soyad: ' . $ad_soyad . '<br/>E-Posta: '. $email . '<br/>Şifre : ' . $sifre;
      mail($email, $konu, $icerik);
	  
	   
$siparisguncelle = mysql_query("UPDATE sepet_bekleyen SET sepet_durumu='1',siparis_id='$siparisidsi' WHERE ip_adresi='$ip_adresi' AND sepet_durumu='0'");
 
if($siparisguncelle)
{ 
}
else
{
    echo "Hata oluştu";
}
 
mysql_close($baglanti);


}else{
echo "Bilgiler Eklenemedi";
echo mysql_error();
}
}
 
function uyekaydiolustur($ad_soyad,$email,$telefon,$ilce,$adres,$ulke,$sehir,$aciklama,$vergi_dairesi,$vergi_numarasi,$odemetipi,$odemedurumu,$siparisidsi){
	
	$ip=GetIP();
$ugetir = mysql_fetch_array(mysql_query("SELECT * FROM uyeler WHERE email='$email'"));
$ad_soyasdasad=$ugetir["ad_soyad"];
$uyeidsi=$ugetir["id"];
if($ad_soyasdasad==""){


	$sifre=uret(6);
	   $tarih = date("Y.m.d H:i:s"); 

	$ekle = mysql_query("INSERT INTO uyeler (ad_soyad, email,telefon,sifre,ip,tarih,ilce,adres,ulke,sehir,vergi_dairesi,vergi_numarasi) VALUES ('$ad_soyad', '$email','$telefon','$sifre','$ip','$tarih','$ilce','$adres','$ulke','$sehir','$vergi_dairesi','$vergi_numarasi')");
 
if($ekle){
	$konu="Parça Center Üyelik Bilgileri ";
   $icerik = 'Ad Soyad: ' . $ad_soyad . '<br/>E-Posta: '. $email . '<br/>Şifre : ' . $sifre;
      mail($email, $konu, $icerik);
	  
$ugetir = mysql_fetch_array(mysql_query("SELECT * FROM uyeler WHERE email='$email'"));
$newuyeidsi=$ugetir["id"]; 
sipolustur($ip,$newuyeidsi,$odemetipi,$odemedurumu,$adres,$tarih,$aciklama,$siparisidsi);
}else{
 
echo "Bilgiler Eklenemedi";
echo mysql_error();
 
}
}else {
	   $tarih = date("Y.m.d H:i:s");
sipolustur($ip,$uyeidsi,$odemetipi,$odemedurumu,$adres,$tarih,$aciklama,$siparisidsi);
	
	
}

}

function sadeuyekaydiolustur($ad_soyad,$email,$telefon,$ilce,$adres,$ulke,$sehir,$aciklama,$vergi_dairesi,$vergi_numarasi,$odemetipi,$odemedurumu,$siparisidsi){
	
	$ip=GetIP();
$ugetir = mysql_fetch_array(mysql_query("SELECT * FROM uyeler WHERE email='$email'"));
$ad_soyasdasad=$ugetir["ad_soyad"];
$uyeidsi=$ugetir["id"];
if($ad_soyasdasad==""){


	$sifre=uret(6);
	   $tarih = date("Y.m.d H:i:s"); 

	$ekle = mysql_query("INSERT INTO uyeler (ad_soyad, email,telefon,sifre,ip,tarih,ilce,adres,ulke,sehir,vergi_dairesi,vergi_numarasi) VALUES ('$ad_soyad', '$email','$telefon','$sifre','$ip','$tarih','$ilce','$adres','$ulke','$sehir','$vergi_dairesi','$vergi_numarasi')");
 
if($ekle){
	$konu="Parça Center Üyelik Bilgileri ";
   $icerik = 'Ad Soyad: ' . $ad_soyad . '<br/>E-Posta: '. $email . '<br/>Şifre : ' . $sifre;
      mail($email, $konu, $icerik);
	   
}else{
 
echo "Bilgiler Eklenemedi";
echo mysql_error();
 
}
}else { 
	
	
}

}

function turkcetarih($f, $zt = 'now'){  
    $z = date("$f", strtotime($zt));  
    $donustur = array(  
        'Monday'    => 'Pazartesi',  
        'Tuesday'   => 'Salı',  
        'Wednesday' => 'Çarşamba',  
        'Thursday'  => 'Perşembe',  
        'Friday'    => 'Cuma',  
        'Saturday'  => 'Cumartesi',  
        'Sunday'    => 'Pazar',  
        'January'   => 'Ocak',  
        'February'  => 'Şubat',  
        'March'     => 'Mart',  
        'April'     => 'Nisan',  
        'May'       => 'Mayıs',  
        'June'      => 'Haziran',  
        'July'      => 'Temmuz',  
        'August'    => 'Ağustos',  
        'September' => 'Eylül',  
        'October'   => 'Ekim',  
        'November'  => 'Kasım',  
        'December'  => 'Aralık',  
        'Mon'       => 'Pts',  
        'Tue'       => 'Sal',  
        'Wed'       => 'Çar',  
        'Thu'       => 'Per',  
        'Fri'       => 'Cum',  
        'Sat'       => 'Cts',  
        'Sun'       => 'Paz',  
        'Jan'       => 'Oca',  
        'Feb'       => 'Şub',  
        'Mar'       => 'Mar',  
        'Apr'       => 'Nis',  
        'Jun'       => 'Haz',  
        'Jul'       => 'Tem',  
        'Aug'       => 'Ağu',  
        'Sep'       => 'Eyl',  
        'Oct'       => 'Eki',  
        'Nov'       => 'Kas',  
        'Dec'       => 'Ara',  
    );  
    foreach($donustur as $en => $tr){  
        $z = str_replace($en, $tr, $z);  
    }  
    if(strpos($z, 'Mayıs') !== false && strpos($f, 'F') === false) $z = str_replace('Mayıs', 'May', $z);  
    return $z;  
}  
function tarih($par)
{
    $explode = explode(" ", $par);
    $explode2 = explode("-", $explode[0]);
    $zaman = substr($explode[1], 0, 5);
    if( $explode2[1] == "01" ) 
    {
        $ay = "Ocak";
    }
    else
    {
        if( $explode2[1] == "02" ) 
        {
            $ay = "Şubat";
        }
        else
        {
            if( $explode2[1] == "03" ) 
            {
                $ay = "Mart";
            }
            else
            {
                if( $explode2[1] == "04" ) 
                {
                    $ay = "Nisan";
                }
                else
                {
                    if( $explode2[1] == "05" ) 
                    {
                        $ay = "Mayıs";
                    }
                    else
                    {
                        if( $explode2[1] == "06" ) 
                        {
                            $ay = "Haziran";
                        }
                        else
                        {
                            if( $explode2[1] == "07" ) 
                            {
                                $ay = "Temmuz";
                            }
                            else
                            {
                                if( $explode2[1] == "08" ) 
                                {
                                    $ay = "Ağustos";
                                }
                                else
                                {
                                    if( $explode2[1] == "09" ) 
                                    {
                                        $ay = "Eylül";
                                    }
                                    else
                                    {
                                        if( $explode2[1] == "10" ) 
                                        {
                                            $ay = "Ekim";
                                        }
                                        else
                                        {
                                            if( $explode2[1] == "11" ) 
                                            {
                                                $ay = "Kasım";
                                            }
                                            else
                                            {
                                                if( $explode2[1] == "12" ) 
                                                {
                                                    $ay = "Aralık";
                                                }

                                            }

                                        }

                                    }

                                }

                            }

                        }

                    }

                }

            }

        }

    }

    return $explode2[2] . " " . $ay . " " . $explode2[0] . ", " . $zaman;
}

function taksit($fiyat, $taksit, $faiz)
{
    $sonuc = array(  );
    $sonuc[0] = $taksit;
    $sonuc[1] = number_format((double) $fiyat + $fiyat / 100 * $faiz, 2, ".", "");
    $sonuc[2] = number_format((double) $sonuc[1] / $taksit, 2, ".", "");
    return $sonuc;
}

function aktif($urlsi)
{
    $mesaj = "";
    if( strstr($_SERVER[HTTP_HOST] . "/" . $_SERVER[REQUEST_URI], $urlsi) ) 
    {
        $mesaj = "active";
    }

    return $mesaj;
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
	$mail->Username = "kullanici@candycraft.net"; // Gönderici adresiniz (e-posta adresiniz)
	$mail->Password = "jAURQ2KAsj5SCKEn@!!";  // SMTP password
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
function oturumkontrolana()
{
    $kullanici = $_SESSION["kullanici"];
    $sifre = $_SESSION["sifre"];
    $oturumkontrol = mysql_query("select * from Yoneticiler where kullanici_adi ='" . $kullanici . "' and kullanici_sifresi ='" . $sifre . "'");
    $durumsadas = mysql_fetch_array($oturumkontrol);
    if( $durumsadas ) 
    {
        return NULL;
    }else {

    echo "<script language=\"javascript\">window.location=\"giris.php\";</script>";
    exit();
}
}


 function smsgonder($smsnumarasi,$smsicerigi,$baslik){
	  if($baslik==""){
		  $baslik="MERTTUGOTO";
	  }
	 set_time_limit(0);

date_default_timezone_set('Europe/Istanbul');
 
 	$xml = '<SMS>
				<oturum>
					<kullanici>merttugoto</kullanici>
					<sifre>CNDQWER</sifre>
				</oturum>
				<baslik>'.$baslik.'</baslik>
				<mesaj>
					<metin>'.$smsicerigi.'</metin>
					<alici>'.$smsnumarasi.'</alici>
				</mesaj>
				<karaliste></karaliste>'.
				'<izin_link>false</izin_link>'.
				'<izin_telefon>false</izin_telefon>'.
			'</SMS>';
			
		 
	
	$sonuc	= sendRequest('http://www.dakiksms.com/api/xml_ozel_api.php', $xml);
	
	if (substr($sonuc, 0, 2) == 'OK')
	{
		list($ok, $mesaj_id) = explode('|', $sonuc); 
	}
	elseif (substr($sonuc, 0, 3) == 'ERR')
	{
		list($err, $mesaj) = explode('|', $sonuc);
		echo 'Hata (' . $err . ') oluştu. ' . $mesaj;
	}
	else
	{
		echo 'Bilinmeyen bir hata oluştu. ' . $sonuc;
	}
  }
 
    function money($money='0.00') {
        $money = explode('.',$money);
        if(count($money)!=2) return false;
        $money_left = $money['0'];
        $money_right = $money['1'];
        //DOKUZLAR
        if(strlen($money_left)==9){
            $i = (int) floor($money_left/100000000);
            if($i==1) $l9="YÜZ";
            if($i==2) $l9="İKİ YÜZ";
            if($i==3) $l9="ÜÇ YÜZ";
            if($i==4) $l9="DÖRT YÜZ";
            if($i==5) $l9="BEŞ YÜZ";
            if($i==6) $l9="ALTI YÜZ";
            if($i==7) $l9="YEDİ YÜZ";
            if($i==8) $l9="SEKİZ YÜZ";
            if($i==9) $l9="DOKUZ YÜZ";
            if($i==0) $l9="";
            $money_left = substr($money_left,1,strlen($money_left)-1);
        }
        //SEKİZLER
        if(strlen($money_left)==8){
            $i = (int) floor($money_left/10000000);
            if($i==1) $l8="ON";
            if($i==2) $l8="YİRMİ";
            if($i==3) $l8="OTUZ";
            if($i==4) $l8="KIRK";
            if($i==5) $l8="ELLİ";
            if($i==6) $l8="ATMIŞ";
            if($i==7) $l8="YETMİŞ";
            if($i==8) $l8="SEKSEN";
            if($i==9) $l8="DOKSAN";
            if($i==0) $l8="";
            $money_left=substr($money_left,1,strlen($money_left)-1);
        }
        //YEDİLER
        if(strlen($money_left)==7){
            $i = (int) floor($money_left/1000000);
            if($i==1){
                if($i!="NULL"){
                    $l7 = "BİR MİLYON";
                }else{
                    $l7 = "MİLYON";
                }
            }
            if($i==2) $l7="İKİ MİLYON";
            if($i==3) $l7="ÜÇ MİLYON";
            if($i==4) $l7="DÖRT MİLYON";
            if($i==5) $l7="BEŞ MİLYON";
            if($i==6) $l7="ALTI MİLYON";
            if($i==7) $l7="YEDİ MİLYON";
            if($i==8) $l7="SEKİZ MİLYON";
            if($i==9) $l7="DOKUZ MİLYON";
            if($i==0){
                if($i!="NULL"){
                    $l7="MİLYON";
                }else{
                    $l7="";
                }
            }
            $money_left=substr($money_left,1,strlen($money_left)-1);
        }
        //ALTILAR
        if(strlen($money_left)==6){
            $i = (int) floor($money_left/100000);
            if($i==1) $l6="YÜZ";
            if($i==2) $l6="İKİ YÜZ";
            if($i==3) $l6="ÜÇ YÜZ";
            if($i==4) $l6="DÖRT YÜZ";
            if($i==5) $l6="BEŞ YÜZ";
            if($i==6) $l6="ALTI YÜZ";
            if($i==7) $l6="YEDİ YÜZ";
            if($i==8) $l6="SEKİZ YÜZ";
            if($i==9) $l6="DOKUZ YÜZ";
            if($i==0) $l6="";
            $money_left = substr($money_left,1,strlen($money_left)-1);
        }
        //BEŞLER
        if(strlen($money_left)==5){
            $i = (int) floor($money_left/10000);
            if($i==1) $l5="ON";
            if($i==2) $l5="YİRMİ";
            if($i==3) $l5="OTUZ";
            if($i==4) $l5="KIRK";
            if($i==5) $l5="ELLİ";
            if($i==6) $l5="ATMIŞ";
            if($i==7) $l5="YETMİŞ";
            if($i==8) $l5="SEKSEN";
            if($i==9) $l5="DOKSAN";
            if($i==0) $l5="";
            $money_left=substr($money_left,1,strlen($money_left)-1);
        }
        //DÖRTLER
        if(strlen($money_left)==4){
            $i = (int) floor($money_left/1000);
            if($i==1){
                if($i!=""){
                    $l4 = "BİR BİN";
                }else{
                    $l4 = "BİN";
                }
            }
            if($i==2) $l4="İKİ BİN";
            if($i==3) $l4="ÜÇ BİN";
            if($i==4) $l4="DÖRT BİN";
            if($i==5) $l4="BEŞ BİN";
            if($i==6) $l4="ALTI BİN";
            if($i==7) $l4="YEDİ BİN";
            if($i==8) $l4="SEKZ BİN";
            if($i==9) $l4="DOKUZ BİN";
            if($i==0){
                if($i!=""){
                    $l4="BİN";
                }else{
                    $l4="";
                }
            }
            $money_left=substr($money_left,1,strlen($money_left)-1);
        }
        //ÜÇLER
        if(strlen($money_left)==3){
            $i = (int) floor($money_left/100);
            if($i==1) $l3="YÜZ";
            if($i==2) $l3="İKİYÜZ";
            if($i==3) $l3="ÜÇYÜZ";
            if($i==4) $l3="DÖRTYÜZ";
            if($i==5) $l3="BEŞYÜZ";
            if($i==6) $l3="ALTIYÜZ";
            if($i==7) $l3="YEDİYÜZ";
            if($i==8) $l3="SEKİZYÜZ";
            if($i==9) $l3="DOKUZYÜZ";
            if($i==0) $l3="";
            $money_left=substr($money_left,1,strlen($money_left)-1);
        }
        //İKİLER
        if(strlen($money_left)==2){
            $i = (int) floor($money_left/10);
            if($i==1) $l2="ON";
            if($i==2) $l2="YİRMİ";
            if($i==3) $l2="OTUZ";
            if($i==4) $l2="KIRK";
            if($i==5) $l2="ELLİ";
            if($i==6) $l2="ATMIŞ";
            if($i==7) $l2="YETMİŞ";
            if($i==8) $l2="SEKSEN";
            if($i==9) $l2="DOKSAN";
            if($i==0) $l2="";
            $money_left=substr($money_left,1,strlen($money_left)-1);
        }
        //BİRLER
        if(strlen($money_left)==1){
            $i = (int) floor($money_left/1);
            if($i==1) $l1="BİR";
            if($i==2) $l1="İKİ";
            if($i==3) $l1="ÜÇ";
            if($i==4) $l1="DÖRT";
            if($i==5) $l1="BEŞ";
            if($i==6) $l1="ALTI";
            if($i==7) $l1="YEDİ";
            if($i==8) $l1="SEKİZ";
            if($i==9) $l1="DOKUZ";
            if($i==0) $l1="";
            $money_left=substr($money_left,1,strlen($money_left)-1);
        }
        //SAĞ İKİ
        if(strlen($money_right)==2){
            $i = (int) floor($money_right/10);
            if($i==1) $r2="ON";
            if($i==2) $r2="YİRMİ";
            if($i==3) $r2="OTUZ";
            if($i==4) $r2="KIRK";
            if($i==5) $r2="ELLİ";
            if($i==6) $r2="ALTMIŞ";
            if($i==7) $r2="YETMİŞ";
            if($i==8) $r2="SEKSEN";
            if($i==9) $r2="DOKSAN";
            if($i==0) $r2="SIFIR";
            $money_right=substr($money_right,1,strlen($money_right)-1);
        }
        //SAĞ BİR
        if(strlen($money_right)==1){
            $i = (int) floor($money_right/1);
            if($i==1) $r1="BİR";
            if($i==2) $r1="İKİ";
            if($i==3) $r1="ÜÇ";
            if($i==4) $r1="DÖRT";
            if($i==5) $r1="BEŞ";
            if($i==6) $r1="ALTI";
            if($i==7) $r1="YEDİ";
            if($i==8) $r1="SEKİZ";
            if($i==9) $r1="DOKUZ";
            if($i==0) $r1="";
            $money_right=substr($money_right,1,strlen($money_right)-1);
        }
        return "$l9 $l8 $l7 $l6 $l5 $l4 $l3 $l2 $l1 TÜRK LİRASI $r2 $r1 KURUŞ";
    }


$kimlik = GetIP();  

// $ugetiqweqer = mysql_fetch_array(mysql_query("SELECT * FROM users WHERE ipadresi='$kimlik'"));
// $sadasdasd3223edas=$ugetiqweqer["name"];
// if($sadasdasd3223edas==""){
// header ("Location:http://www.google.com/"); 
// }
/*
 	$eee = mysql_query("SELECT * FROM users where ipadresi!='' "); 
while($ihqqsan=mysql_fetch_assoc($eee)) 
{  
$ipadresi=$ihqqsan["ipadresi"];
$hepipadresi=$hepipadresi."".$ipadresi.",";	
}
$banned_ips=array($hepipadresi); 
if (!in_array($kimlik,$hepipadresi)){ 
//yasaklı olanları başka bi sayfaya gönder 
header ("Location:http://www.google.com/"); 
echo $hepipadresi; 
die; 
} 
*/
	 
function mailgonder($alicininmailadresi,$mailbasligi,$mailicerigi){
	include '../crons/class.phpmailer.php';
$mail = new PHPMailer();
$mail->IsSMTP();
$mail->SMTPSecure = 'tls';
$mail->Host = 'smtp.yandex.com';
$mail->Port = 587;
$mail->Username = 'ihsan@merttugyazilim.com';
$mail->Password = 'aristotales***';
$mail->SetFrom($mail->Username, 'Merttuğ Otomotiv');
$mail->AddAddress($alicininmailadresi, $alicininmailadresi);
$mail->CharSet = 'UTF-8';
$mail->Subject = $mailbasligi;
$mail->MsgHTML($mailicerigi);
if($mail->Send()) {
    echo 'Mail gönderildi!';
} else {
    echo 'Mail gönderilirken bir hata oluştu: ' . $mail->ErrorInfo;
}
}



 
	
$key = 'AIzaSyABepRu-PYSVY0K79Vo9tbNlRECMrL8zMU';

class GoogleUrlApi {
	
	// Constructor
	function GoogleURLAPI($key,$apiURL = 'https://www.googleapis.com/urlshortener/v1/url') {
		// Keep the API Url
		$this->apiURL = $apiURL.'?key='.$key;
	}
	
	// Shorten a URL
	function shorten($url) {
		// Send information along
		$response = $this->send($url);
		// Return the result
		return isset($response['id']) ? $response['id'] : false;
	}
	
	// Expand a URL
	function expand($url) {
		// Send information along
		$response = $this->send($url,false);
		// Return the result
		return isset($response['longUrl']) ? $response['longUrl'] : false;
	}
	
	// Send information to Google
	function send($url,$shorten = true) {
		// Create cURL
		$ch = curl_init();
		// If we're shortening a URL...
		if($shorten) {
			curl_setopt($ch,CURLOPT_URL,$this->apiURL);
			curl_setopt($ch,CURLOPT_POST,1);
			curl_setopt($ch,CURLOPT_POSTFIELDS,json_encode(array("longUrl"=>$url)));
			curl_setopt($ch,CURLOPT_HTTPHEADER,array("Content-Type: application/json"));
		}
		else {
			curl_setopt($ch,CURLOPT_URL,$this->apiURL.'&shortUrl='.$url);
		}
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
		// Execute the post
		$result = curl_exec($ch);
		// Close the connection
		curl_close($ch);
		// Return the result
		return json_decode($result,true);
	}		
}
$googer = new GoogleURLAPI($key);




function ikiStringArasiniAl($myStr, $startStr, $endStr)
{
	$myArr = explode($endStr,$myStr);
 
	foreach($myArr as $myVal)
	{
		$myVal = $myVal."[endOfString]";
		$returnArr[] = BetweenStr($myVal,$startStr,'[endOfString]');
	}
	
	return  $returnArr;
}
 
function BetweenStr($InputString, $StartStr, $EndStr=0, $StartLoc=0) {
    if (($StartLoc = strpos($InputString, $StartStr, $StartLoc)) === false) { return; }
    $StartLoc += strlen($StartStr);
    if (!$EndStr) { $EndStr = $StartStr; }
    if (!$EndLoc = strpos($InputString, $EndStr, $StartLoc)) { return; }
    return substr($InputString, $StartLoc, ($EndLoc-$StartLoc));
}


function stokekle($urun_adi,$giren_adet,$cikan_adet,$muhasebe_kodu,$alis_fiyati,$satis_fiyati,$alis_fiyati_dolar,$satis_fiyati_dolar,$alinan_cari){
$islem_tarihiaada= date("Y.m.d H:i:s"); 
	$ekleseses = mysql_query("INSERT INTO stok (stok_giris_tarihi, stok_ekleyen,urun_adi,giren_adet,cikan_adet,muhasebe_kodu,alis_fiyati,satis_fiyati,alis_fiyati_dolar,satis_fiyati_dolar,alinan_cari) VALUES ('$islem_tarihiaada', 'test','$urun_adi','$giren_adet','$cikan_adet','$muhasebe_kodu','$alis_fiyati','$satis_fiyati','$alis_fiyati_dolar','$satis_fiyati_dolar','$alinan_cari')",$baglan);
 
if($ekleseses){
 
 
}else{
 
echo "Stok Kartı Eklenemedi";
 echo mysql_error();
}

}
			 
 function rasgeleSifre($uzunluk)
{
 $sifre = ''; //başlangıç değeri boş olarak ayarlanıyor.
 for($i=0;$i<$uzunluk;$i++)
 {
   switch(rand(1,3))
   {
     case 1: $sifre.=chr(rand(48,57));  break; //0-9
     case 2: $sifre.=chr(rand(65,90));  break; //A-Z
     case 3: $sifre.=chr(rand(97,122)); break; //a-z
   }
 }
 return $sifre;
}
$sifre=rasgeleSifre(6); 

$sorgu           = mysql_query("SELECT * FROM commerce where SiparisDurumu=2");
 

$odeme_bekleyenler     = mysql_num_rows($sorgu);

class yaziyla {
 
    var $sayi=0;
    var $kurus=0;
    var $eksi="";
    var $birim="TL";
    var $kurus_birim = "KR";
    var $bolukler;
    var $birler;
    var $onlar;
 
    function yaziyla($birim="TL", $kurus_birim="KR") {
 
        $this->birim          = $birim;
        $this->kurus_birim    = $kurus_birim;
        $this->bolukler       = array("","BİN","Milyon","Milyar","Trilyon","Katrilyon","Trilyar","Kentrilyon","Kentrilyar","Zontrilyar");
        $this->birler         = array("SIFIR","BİR","İKİ","ÜÇ","DÖRT","BEŞ","ALTI","YEDİ","SEKİZ","DOKUZ");
        $this->onlar          = array("","ON","YİRMİ","OTUZ","KIRK","ELLİ","ALTMIŞ","YETMİŞ","SEKSEN","DOKSAN","YÜZ");
 
    }
    function yaz($sayi) {
 
        $tam="";
        $kurus="";
        if($this->sayi_cozumle($sayi)) {
 
        //return "Hatalı Sayı Formatı!";
        return "";
        }
 
        if(($this->sayi+$this->kurus) == 0) return $this->birler[0].' '.$this->birim;
 
        if($this->sayi>0) $tam = $this->oku($this->sayi);
        if($this->kurus>0) $kurus = $this->oku($this->kurus);
 
        if( $this->sayi == 0 ) return $this->eksi.' '.$kurus.' '.$this->kurus_birim;
        if( $this->kurus == 0 ) return $this->eksi.' '.$tam.' '.$this->birim;
        return $this->eksi.' '.$tam.' '.$this->birim.' '.$kurus.' '.$this->kurus_birim;
    }
    function oku($sayi) {
 
    if($sayi == 0) return $this->birler[0];
        $ubb = sizeof($this->bolukler);
        $kac_sifir = 3 - (strlen($sayi) % 3);
        if($kac_sifir!=3) for($i=0;$i<$kac_sifir;++$i) { $sayi = "0$sayi"; }
 
        $k = 0; $sonuc = "";
        for($i = strlen($sayi); $i>0; $i-=3,++$k) {
 
           $boluk = $this->boluk_oku(substr($sayi, $i-3, 3));
           if($boluk) {
           if(($k == 1) && ($boluk == $this->birler[1])) $boluk = "";
           if(  $k > $ubb) $sonuc = $boluk ."Tanımsız(".($k*3).".Basamak) $sonuc";
           else $sonuc = $boluk . $this->bolukler[$k]." $sonuc";
           }
        }
        return $sonuc;
    }
    function boluk_oku($sayi) {
 
         $sayi = ((int)($sayi)) % 1000; $sonuc = "";
         $bir = $sayi % 10;
         $on_ = (int)($sayi / 10) % 10;
         $yuz = (int)($sayi / 100) % 10;
 
         if($yuz) { if($yuz == 1) $sonuc = $this->onlar[10];
         else $sonuc = $this->birler[$yuz].$this->onlar[10]; }
 
         if($on_) $sonuc = $sonuc.$this->onlar[$on_];
         if($bir) $sonuc = $sonuc.$this->birler[$bir];
         return $sonuc;
    }
    function sayi_cozumle($sayi) {
 
        $sayi = trim($sayi);
        if($sayi[0] == "-") { $this->eksi="Eksi"; $sayi = substr($sayi, 1); }
        if(preg_match("/^(0*\.0+|0*|\.0+)$/", $sayi)) { $this->sayi = $this->kurus = 0; return 0; }
        if(preg_match("/^(\d+)\.(\d+)$/", $sayi, $m))
        {
        $sayi = $m[1]; $this->sayi = (int)preg_replace("/^0+/","",$sayi);
        if(!preg_match("/^0+$/",$m[2])) $this->kurus = (int)$m[2];
        }
        else if(preg_match("/^0*(\d+)$/", $sayi, $m) || preg_match("/^0*(\d+)\.0+$/", $sayi, $m)) { $this->sayi = (int)$m[1]; }
        else if(preg_match("/^0*\.(\d+)$/", $sayi, $m)) { $this->sayi = 0; $this->kurus = (int)$m[1]; }
        else return 1;
        if($this->kurus>0) {
 
        $this->kurus= number_format('0.'.$this->kurus, 2);
        if( (int)$this->kurus == 1 ) { ++$this->sayi; $this->kurus = 0; }
        else $this->kurus = (int)str_replace("0.", "", $this->kurus);
        }
        return 0;
    }
}
$yaziyla = new yaziyla("TÜRK LİRASI", "KURUŞ");


function replace_tr($text) {
   $text = trim($text);
   $search = array('Ç','ç','Ğ','ğ','ı','İ','Ö','ö','Ş','ş','Ü','ü');
   $replace = array('C','C','G','G','I','I','O','O','S','S','U','U');
   $new_text = str_replace($search,$replace,$text);
   return $new_text;
} 

function replaceSpace($string)
{
	$string = preg_replace("/\s+/", " ", $string);
	$string = trim($string);
	return $string;
}


?>