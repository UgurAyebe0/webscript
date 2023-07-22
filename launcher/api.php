 <html>

<body>

	<form action="" method="POST">

		<input type="text" name="sifre" value="<?php 	$sifre="cclauncher"+"Fi357com";

	$sifre2=md5($sifre); echo $sifre2; ?>"></input></br>

		<input type="text" name="kullaniciadi"></input></br>

		<input type="text" name="kullanicisifre"></input></br>

		<input type="submit">

	</form>

</body>

</html>

<?php



if($_POST) {

	$sifre="cclauncher"+"Fi357com";

	$sifre2=md5($sifre);

	if ($_POST['sifre']==$sifre2){

		$host="87.248.157.101:3306";

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

			$ip_adresi=GetIP();



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

			function SifreleSite($veri) {

				$s1 = md5($veri);

				$s2 = sha1($s1);

				$s3 = crc32($s2);

				return $s3;

			}

			

			$ipkontrol=mysql_query("SELECT COUNT(*) FROM GirisLog WHERE IpAdresi='$ip_adresi' AND Durum='Başarısız' AND Uygulama='Launcher' AND Tarih >= NOW() - INTERVAL 1 hour");

			$ipkontrol2=mysql_fetch_array($ipkontrol);

			if ($ipkontrol2[0] > 3) {

				echo "$ipkontrol2[0] defa yanlış giriş yaptığınız için 1 saat yasaklandınız.";

			}

			else {

				$launcherkullanici=TemizVeri($_POST['kullaniciadi']);

				$launchersifre=TemizVeri($_POST['kullanicisifre']);

				if ($launcherkullanici==null || $launchersifre==null) {

					echo "Lütfen boş alan bırakmayınız.";

				}

				else if(strlen($launcherkullanici)<3 || strlen($launcherkullanici)>16)

				{

					mysql_query("INSERT INTO GirisLog (IpAdresi,KullaniciAdi,Uygulama) VALUES ('$ip_adresi','$launcherkullanici','Launcher')");

					echo "Kullanıcı adınız veya şifreniz yanlış.";

				}			

				else if(strlen($launchersifre)<6 || strlen($launchersifre)>18)

				{

					mysql_query("INSERT INTO GirisLog (IpAdresi,KullaniciAdi,Uygulama) VALUES ('$ip_adresi','$launcherkullanici','Launcher')");

					echo "Kullanıcı adınız veya şifreniz yanlış.";

				}

				else {

					$sifrehash=SifreleSite($launchersifre);

					$sorgu=mysql_query("SELECT * FROM Kullanicilar WHERE username = '$launcherkullanici' AND passwordsite = '$sifrehash' LIMIT 1");

					$sonuc=mysql_num_rows($sorgu);

					if($sonuc==1){

						mysql_query("INSERT INTO GirisLog (IpAdresi,KullaniciAdi,Durum,Uygulama) VALUES ('$ip_adresi','$launcherkullanici','Başarılı','Launcher')");

						echo "Giriş başarılı yönlendiriliyorsunuz.";

					}

					else {

						mysql_query("INSERT INTO GirisLog (IpAdresi,KullaniciAdi,Uygulama) VALUES ('$ip_adresi','$launcherkullanici','Launcher')");

						echo "Kullanıcı adınız veya şifreniz yanlış.";

					}

				}

			}

	}

}

?>