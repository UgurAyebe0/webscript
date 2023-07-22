<?php
//{
//	"Grup":"",
//	"Serverlar": {		
//		"SkyBlock": [ "s1", "s1", "s3" ],
//		"BungeeCord": [ "s1", "s1", "s3" ]
//	} 	
//}

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

$sorgu=mysql_query("SELECT * FROM UrunLog WHERE Durum=0");
while ($deger = mysql_fetch_array($sorgu)) {
	$kid=$deger['KullaniciId'];
	$urunid=$deger['UrunId'];
	$kullanici=mysql_fetch_array(mysql_query("SELECT username,uuid FROM Kullanicilar WHERE KullaniciId='$kid'"));
	mysql_select_db("candycra_Yetkiler");
	$uuidsorgu=mysql_query("SELECT groupid FROM perm_playergroups WHERE playeruuid='$kullanici[1]'");
	$uuiddizi=array();
	while ($uuidsonuc=mysql_fetch_array($uuidsorgu)) {
		 array_push($uuiddizi,'$uuidsonuc[0]');
	}
	$uuiddizisonuc=array_search('6',$uuiddizi);
	if ($uuiddizisonuc==false) {
		mysql_query("INSERT INTO perm_playergroups (playeruuid,groupid,server) VALUES ('$kullanici[1]','6','')");
	}
	mysql_select_db("candycra_kpanel");
	$urun=mysql_fetch_array(mysql_query("SELECT Veri,Sure FROM Urunler WHERE UrunId='$urunid'"));
	$sure=$urun[1];
	$cikti=json_decode($urun[0], true);
	$grupadi=$cikti['Grup'];
	$urunlogid=$deger['UrunLogId'];
	if ($cikti['Grup']!=null){
		mysql_select_db("candycra_Yetkiler");
		$groupid=mysql_fetch_array(mysql_query("SELECT id FROM perm_groups WHERE name='$grupadi'"));
		$varmi=mysql_fetch_array(mysql_query("SELECT COUNT(id),groupid,expires FROM perm_playergroups WHERE playeruuid='$kullanici[1]' AND (groupid=8 OR groupid=9 OR groupid=10) LIMIT 1"));
		if ($varmi[0]==0) {
			mysql_select_db("candycra_kpanel");
			mysql_query("UPDATE UrunLog SET Durum='1' WHERE UrunLogId='$urunlogid'");
			mysql_select_db("candycra_Yetkiler");
			if ($sure==-1) {
				$sonuc=mysql_query("INSERT INTO perm_playergroups (playeruuid,groupid,server) VALUES ('$kullanici[1]','$groupid[0]','')");
				echo "KullaniciAdi: $kullanici[1] , GrupAdi: $groupid[0] verildi.<br>";
			}
			else {
				$sure2=date("Y-m-d H:i:s",strtotime("$sure day"));
				$sonuc=mysql_query("INSERT INTO perm_playergroups (playeruuid,groupid,expires,server) VALUES ('$kullanici[1]','$groupid[0]','$sure2','')");
				echo "KullaniciAdi: $kullanici[1] , GrupAdi: $groupid[0], Sure: $sure2 verildi.<br>";
			}
		}
		else {
			if ($varmi[1]==$groupid[0]) {
				mysql_select_db("candycra_kpanel");
				mysql_query("UPDATE UrunLog SET Durum='1' WHERE UrunLogId='$urunlogid'");
				mysql_select_db("candycra_Yetkiler");
				mysql_query("DELETE FROM perm_playergroups WHERE playeruuid='$kullanici[1]'");
				if ($sure==-1) {
					$sonuc=mysql_query("INSERT INTO perm_playergroups (playeruuid,groupid,server) VALUES ('$kullanici[1]','$groupid[0]','')");
					echo "KullaniciAdi: $kullanici[1] , GrupAdi: $groupid[0] verildi.<br>";
				}
				else {
					$sure2 = strtotime("$sure day",strtotime($varmi[2]));
					$sure2 = date("Y-m-d H:i:s" ,$sure2 );
					$sonuc=mysql_query("INSERT INTO perm_playergroups (playeruuid,groupid,expires,server) VALUES ('$kullanici[1]','$groupid[0]','$sure2','')");
					echo "KullaniciAdi: $kullanici[1] , GrupAdi: $groupid[0], Sure: $sure2 verildi.<br>";
				}
			}
			else {
				mysql_select_db("candycra_kpanel");
				mysql_query("UPDATE UrunLog SET Durum='1' WHERE UrunLogId='$urunlogid'");
				mysql_select_db("candycra_Yetkiler");
				mysql_query("DELETE FROM perm_playergroups WHERE playeruuid='$kullanici[1]'");
				if ($sure==-1) {
					$sonuc=mysql_query("INSERT INTO perm_playergroups (playeruuid,groupid,server) VALUES ('$kullanici[1]','$groupid[0]','')");
					echo "KullaniciAdi: $kullanici[1] , GrupAdi: $groupid[0] verildi.<br>";
				}
				else {
					$sure2=date("Y-m-d H:i:s",strtotime("$sure day"));
					$sonuc=mysql_query("INSERT INTO perm_playergroups (playeruuid,groupid,expires,server) VALUES ('$kullanici[1]','$groupid[0]','$sure2','')");
					echo "KullaniciAdi: $kullanici[1] , GrupAdi: $groupid[0], Sure: $sure2 verildi.<br>";
				}
			}
		}
		mysql_select_db("candycra_kpanel");
	}
	if ($cikti['Serverlar']!=null){
		$sayi=count($cikti['Serverlar']['BungeeCord']);
		if ($sayi!=0){
			for ($t=0;$t<$sayi;$t++) {
				mysql_select_db("candycra_Yetkiler");
				$perm=$cikti['Serverlar']['BungeeCord'][$t];
				$varmi=mysql_fetch_array(mysql_query("SELECT COUNT(id) FROM perm_playerpermissions WHERE playeruuid='$kullanici[1]' AND permission='$perm' LIMIT 1"));
				if ($varmi[0]==0) {
					mysql_select_db("candycra_kpanel");
					mysql_query("UPDATE UrunLog SET Durum='1' WHERE UrunLogId='$urunlogid'");
					mysql_select_db("candycra_Yetkiler");
					if ($sure==-1) {
						$sonuc=mysql_query("INSERT INTO perm_playerpermissions (playeruuid,permission,server) VALUES ('$kullanici[1]','$perm','')");
						echo "KullaniciAdi: $kullanici[1] , Perm: $perm , Server: BungeeCord verildi.<br>";
					}
					else {
						$sure2=date("Y-m-d H:i:s",strtotime("$sure day"));
						$sonuc=mysql_query("INSERT INTO perm_playerpermissions (playeruuid,permission,server,expires) VALUES ('$kullanici[1]','$perm','','$sure2')");
						echo "KullaniciAdi: $kullanici[1] , Perm: $perm , Server: BungeeCord , Sure: $sure2 verildi.<br>";
					}
				}
				else {
					echo "KullaniciAdi: $kullanici[1] , Perm: $perm , Server: BungeeCord verilemedi. Neden: Aldığı ürün halen var.<br>";
				}
				mysql_select_db("candycra_kpanel");
			}
		}
		$sayi=count($cikti['Serverlar']['SkyBlock']);
		if ($sayi!=0){
			for ($t=0;$t<$sayi;$t++) {
				mysql_select_db("candycra_Yetkiler");
				$perm=$cikti['Serverlar']['SkyBlock'][$t];
				$varmi=mysql_fetch_array(mysql_query("SELECT COUNT(id) FROM perm_playerpermissions WHERE playeruuid='$kullanici[1]' AND permission='$perm' AND server='skyblock' LIMIT 1"));
				if ($varmi[0]==0) {
					mysql_select_db("candycra_kpanel");
					mysql_query("UPDATE UrunLog SET Durum='1' WHERE UrunLogId='$urunlogid'");
					mysql_select_db("candycra_Yetkiler");
					if ($sure==-1) {
						$sonuc=mysql_query("INSERT INTO perm_playerpermissions (playeruuid,permission,server) VALUES ('$kullanici[1]','$perm','skyblock')");
						echo "KullaniciAdi: $kullanici[1] , Perm: $perm , Server: SkyBlock verildi.<br>";
					}
					else {
						if ($grupadi!=null) {
							$sonuc=mysql_query("INSERT INTO perm_playerpermissions (playeruuid,permission,server) VALUES ('$kullanici[1]','$perm','skyblock')");
							echo "KullaniciAdi: $kullanici[1] , Perm: $perm , Server: SkyBlock verildi.<br>";
						}
						else {
							$sure2=date("Y-m-d H:i:s",strtotime("$sure day"));
							$sonuc=mysql_query("INSERT INTO perm_playerpermissions (playeruuid,permission,server,expires) VALUES ('$kullanici[1]','$perm','skyblock','$sure2')");
							echo "KullaniciAdi: $kullanici[1] , Perm: $perm , Server: SkyBlock , Sure: $sure2 verildi.<br>";
						}
					}
				}
				else {
					echo "KullaniciAdi: $kullanici[1] , Perm: $perm , Server: SkyBlock verilemedi. Neden: Aldığı ürün halen var.<br>";
				}
				mysql_select_db("candycra_kpanel");
			}
		}
		$sayi=count($cikti['Serverlar']['Faction']);
		if ($sayi!=0){
			for ($t=0;$t<$sayi;$t++) {
				mysql_select_db("candycra_Yetkiler");
				$perm=$cikti['Serverlar']['Faction'][$t];
				$varmi=mysql_fetch_array(mysql_query("SELECT COUNT(id) FROM perm_playerpermissions WHERE playeruuid='$kullanici[1]' AND permission='$perm' AND server='faction' LIMIT 1"));
				if ($varmi[0]==0) {
					mysql_select_db("candycra_kpanel");
					mysql_query("UPDATE UrunLog SET Durum='1' WHERE UrunLogId='$urunlogid'");
					mysql_select_db("candycra_Yetkiler");
					if ($sure==-1) {
						$sonuc=mysql_query("INSERT INTO perm_playerpermissions (playeruuid,permission,server) VALUES ('$kullanici[1]','$perm','faction')");
						echo "KullaniciAdi: $kullanici[1] , Perm: $perm , Server: Faction verildi.<br>";
					}
					else {
						if ($grupadi!=null) {
							$sonuc=mysql_query("INSERT INTO perm_playerpermissions (playeruuid,permission,server) VALUES ('$kullanici[1]','$perm','faction')");
							echo "KullaniciAdi: $kullanici[1] , Perm: $perm , Server: Faction verildi.<br>";
						}
						else {
							$sure2=date("Y-m-d H:i:s",strtotime("$sure day"));
							$sonuc=mysql_query("INSERT INTO perm_playerpermissions (playeruuid,permission,server,expires) VALUES ('$kullanici[1]','$perm','faction','$sure2')");
							echo "KullaniciAdi: $kullanici[1] , Perm: $perm , Server: Faction , Sure: $sure2 verildi.<br>";
						}
					}
				}
				else {
					echo "KullaniciAdi: $kullanici[1] , Perm: $perm , Server: Faction verilemedi. Neden: Aldığı ürün halen var.<br>";
				}
				mysql_select_db("candycra_kpanel");
			}
		}
		$sayi=count($cikti['Serverlar']['SkyPvP']);
		if ($sayi!=0){
			for ($t=0;$t<$sayi;$t++) {
				mysql_select_db("candycra_Yetkiler");
				$perm=$cikti['Serverlar']['SkyPvP'][$t];
				$varmi=mysql_fetch_array(mysql_query("SELECT COUNT(id) FROM perm_playerpermissions WHERE playeruuid='$kullanici[1]' AND permission='$perm' AND server='skypvp' LIMIT 1"));
				if ($varmi[0]==0) {
					mysql_select_db("candycra_kpanel");
					mysql_query("UPDATE UrunLog SET Durum='1' WHERE UrunLogId='$urunlogid'");
					mysql_select_db("candycra_Yetkiler");
					if ($sure==-1) {
						$sonuc=mysql_query("INSERT INTO perm_playerpermissions (playeruuid,permission,server) VALUES ('$kullanici[1]','$perm','skypvp')");
						echo "KullaniciAdi: $kullanici[1] , Perm: $perm , Server: SkyPvP verildi.<br>";
					}
					else {
						if ($grupadi!=null) {
							$sonuc=mysql_query("INSERT INTO perm_playerpermissions (playeruuid,permission,server) VALUES ('$kullanici[1]','$perm','skypvp')");
							echo "KullaniciAdi: $kullanici[1] , Perm: $perm , Server: SkyPvP verildi.<br>";
						}
						else {
							$sure2=date("Y-m-d H:i:s",strtotime("$sure day"));
							$sonuc=mysql_query("INSERT INTO perm_playerpermissions (playeruuid,permission,server,expires) VALUES ('$kullanici[1]','$perm','skypvp','$sure2')");
							echo "KullaniciAdi: $kullanici[1] , Perm: $perm , Server: SkyPvP , Sure: $sure2 verildi.<br>";
						}
					}
				}
				else {
					echo "KullaniciAdi: $kullanici[1] , Perm: $perm , Server: SkyPvP verilemedi. Neden: Aldığı ürün halen var.<br>";
				}
				mysql_select_db("candycra_kpanel");
			}
		}
		$sayi=count($cikti['Serverlar']['OzelServer']);
		if ($sayi!=0){
			for ($t=0;$t<$sayi;$t++) {
				$ozelserverismi=$deger['UrunServerIsmi'];
				mysql_select_db("candycra_Yetkiler");
				$perm=$cikti['Serverlar']['OzelServer'][$t];
				$varmi=mysql_fetch_array(mysql_query("SELECT COUNT(id) FROM perm_playerpermissions WHERE playeruuid='$kullanici[1]' AND permission='$perm' AND server='$ozelserverismi' LIMIT 1"));
				if ($varmi[0]==0) {
					mysql_select_db("candycra_kpanel");
					mysql_query("UPDATE UrunLog SET Durum='1' WHERE UrunLogId='$urunlogid'");
					mysql_select_db("candycra_Yetkiler");
					if ($sure==-1) {
						$sonuc=mysql_query("INSERT INTO perm_playerpermissions (playeruuid,permission,server) VALUES ('$kullanici[1]','$perm','$ozelserverismi')");
						echo "KullaniciAdi: $kullanici[1] , Perm: $perm , Server: $ozelserverismi verildi.<br>";
					}
					else {
						if ($grupadi!=null) {
							$sonuc=mysql_query("INSERT INTO perm_playerpermissions (playeruuid,permission,server) VALUES ('$kullanici[1]','$perm','$ozelserverismi')");
							echo "KullaniciAdi: $kullanici[1] , Perm: $perm , Server: $ozelserverismi verildi.<br>";
						}
						else {
							$sure2=date("Y-m-d H:i:s",strtotime("$sure day"));
							$sonuc=mysql_query("INSERT INTO perm_playerpermissions (playeruuid,permission,server,expires) VALUES ('$kullanici[1]','$perm','$ozelserverismi','$sure2')");
							echo "KullaniciAdi: $kullanici[1] , Perm: $perm , Server: $ozelserverismi , Sure: $sure2 verildi.<br>";
						}
					}
				}
				else {
					echo "KullaniciAdi: $kullanici[1] , Perm: $perm , Server: $ozelserverismi verilemedi. Neden: Aldığı ürün halen var.<br>";
				}
				mysql_select_db("candycra_kpanel");
			}
		}
	}
}
?>