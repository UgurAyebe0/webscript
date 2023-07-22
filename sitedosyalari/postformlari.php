
<?php
include ("admin/system/ayar.php");
									if(p("uyekaydi")){
										$ip_adresi = GetIP();
										$kadi=TemizVeri($_POST['kadi']);
										$email=TemizVeri($_POST['email']);
										$sifre=substr(TemizVeri($_POST['sifre']),0,18);
										$sifre2=substr(TemizVeri($_POST['sifre2']),0,18);
										$konay=Kontrol($kadi);
										$emailonay=EmailKontrol($email);
										$sifreonay=KontrolSifre($sifre);
										$s1=mysql_num_rows(mysql_query("SELECT username FROM Kullanicilar WHERE username='$kadi' LIMIT 1",$baglan));
										$s2=mysql_num_rows(mysql_query("SELECT email FROM Kullanicilar WHERE email='$email' LIMIT 1",$baglan));
										$data=Array();
										$uuid=Uuid($kadi);
										if ($kadi==null OR $email==null OR $sifre==null)
										{
										?>
											<div class="alert alert-danger" role="alert">
												<span class="badge badge-danger">Hata</span>
												Lütfen boş alan bırakmayınız.
											</div>
										<?php
										}
										else if ($sifre!=$sifre2)
										{
										?>
											<div class="alert alert-danger" role="alert">
												<span class="badge badge-danger">Hata</span>
												Şifreniz birbiriyle uyuşmuyor.
											</div>
										<?php
										}
										else if (strtoupper($_POST['dk']) != $_SESSION['dogrulamakodu'])
										{
										?>
											<div class="alert alert-danger" role="alert">
												<span class="badge badge-danger">Hata</span>
												Dogrulama kodunu yanlış girdiniz.
											</div>
										<?php
										}
										else if ($konay)
										{
										?>
											<div class="alert alert-danger" role="alert">
												<span class="badge badge-danger">Hata</span>
												Girdiğiniz kullanıcı adı uygun olmayan karakter içeriyor.
											</div>
										<?php
										}
										else if (strlen($kadi)<3 OR strlen($kadi)>16)
										{
										?>
											<div class="alert alert-danger" role="alert">
												<span class="badge badge-danger">Hata</span>
												Kullanıcı adınız en az 3 karakter en fazla 16 karakter olmalıdır.
											</div>
										<?php
										}
										else if (!$emailonay)
										{
										?>
											<div class="alert alert-danger" role="alert">
												<span class="badge badge-danger">Hata</span>
												Lütfen doğru email adresi giriniz.
											</div>
										<?php
										}
										else if ($sifreonay)
										{
										?>
											<div class="alert alert-danger" role="alert">
												<span class="badge badge-danger">Hata</span>
												Lütfen şifrenizde özel karakter ve türkçe karakter kullanmayınız.
											</div>
										<?php
										}
										else if (strlen($sifre)<6 OR strlen($sifre)>18)
										{
										?>
											<div class="alert alert-danger" role="alert">
												<span class="badge badge-danger">Hata</span>
												Şifreniz en az 6 , en çok 18 karakter uzunluğunda olmalıdır.
											</div>
										<?php
										}
										else if (!isset($_POST['onay']))
										{
										?>
											<div class="alert alert-danger" role="alert">
												<span class="badge badge-danger">Hata</span>
												Lütfen şartları ve polikaları onaylayınız.
											</div>
										<?php
										}
										else if ($s1>0)
										{
										?>
											<div class="alert alert-danger" role="alert">
												<span class="badge badge-danger">Hata</span>
												Bu kullanıcı adıyla daha önceden kayıt olunmuş.
											</div>
										<?php
										}
										else if ($s2>0)
										{
										?>
											<div class="alert alert-danger" role="alert">
												<span class="badge badge-danger">Hata</span>
												Bu eposta adresiyle daha önceden kayıt olunmuş.
											</div>
										<?php
										}
										else if ($uuid=='')
										{
										?>
											<div class="alert alert-danger" role="alert">
												<span class="badge badge-danger">Hata</span>
												Uuid oluşturulamadı. Lütfen daha sonra tekrar deneyiniz.
											</div>
										<?php
										}
										else {
											$sifrehash=Sifrele($sifre);
											$sifrehash2=SifreleSite($sifre);
											$sorgu=mysql_query("INSERT INTO Kullanicilar SET username = '$kadi', password = '$sifrehash', passwordsite = '$sifrehash2', email = '$email', uuid='$uuid', kayitip='$ip_adresi'",$baglan);
											if($sorgu){
											?>
												<div class="alert alert-success text-white" role="alert">
													<span class="badge badge-success">Başarılı</span>
													Başarıyla kayıt oldunuz lütfen giriş yapınız.
												</div> 
											<?php
											}
											else {
											?>
												<div class="alert alert-danger" role="alert">
													<span class="badge badge-danger">Hata</span>
													Bir hata oluştu lütfen daha sonra tekrar deneyin.
												</div>
											<?php
											}
										}
									}
								?>
 <?php
									if(p("girisyap")){
										$ip_adresi = GetIP();
										$kadi=substr(TemizVeri($_POST['kadi']),0,16);
										$sifre=substr(TemizVeri($_POST['sifre']),0,18);
										$konay=Kontrol($kadi);
										if ($kadi==null OR $sifre==null)
										{
										?>
											<div class="alert alert-danger" role="alert">
												<span class="badge badge-danger">Hata</span>
												Lütfen boş alan bırakmayınız.
											</div>
										<?php
										}
										else if (strtoupper($_POST['dk']) != $_SESSION['dogrulamakodu'])
										{
											mysql_query("INSERT INTO GirisLog (IpAdresi,KullaniciAdi) VALUES ('$ip_adresi','$kadi')",$baglan);
										?>
											<div class="alert alert-danger" role="alert">
												<span class="badge badge-danger">Hata</span>
												Dogrulama kodunu yanlış girdiniz.
											</div>
										<?php
										}
										else if (strlen($kadi)<3 OR strlen($kadi)>16)
										{
											mysql_query("INSERT INTO GirisLog (IpAdresi,KullaniciAdi) VALUES ('$ip_adresi','$kadi')",$baglan);
										?>
											<div class="alert alert-danger" role="alert">
												<span class="badge badge-danger">Hata</span>
												Kullanıcı adınız veya şifreniz yanlış.
											</div>
										<?php
										}
										else if (strlen($sifre)<6 OR strlen($sifre)>18)
										{
											mysql_query("INSERT INTO GirisLog (IpAdresi,KullaniciAdi) VALUES ('$ip_adresi','$kadi')",$baglan);
										?>
											<div class="alert alert-danger" role="alert">
												<span class="badge badge-danger">Hata</span>
												Kullanıcı adınız veya şifreniz yanlış.
											</div>
										<?php
										}
										else {
											$sifrehash=SifreleSite($sifre);
											$sorgu=mysql_query("SELECT * FROM Kullanicilar WHERE username = '$kadi' AND passwordsite = '$sifrehash' LIMIT 1",$baglan);
											$sonuc=mysql_num_rows($sorgu);
											if($sonuc==1){
												mysql_query("INSERT INTO GirisLog (IpAdresi,KullaniciAdi,Durum) VALUES ('$ip_adresi','$kadi','Başarılı')",$baglan);
												$kid=mysql_fetch_array(mysql_query("SELECT KullaniciId,uuid,username From Kullanicilar WHERE username='$kadi'",$baglan));
												$_SESSION["login"] = "true";
												$_SESSION["kid"] = $kid[0];
												$_SESSION["uuid"] = $kid[1];
												$_SESSION["sitekullaniciadi"] = $kid[2];
												ob_end_flush();
											?>
												<div class="alert alert-success text-white" role="alert">
													<span class="badge badge-success">Başarılı</span>
													Giriş başarılı
												</div>
												<meta http-equiv="refresh" content="1;URL=index.php">
											<?php
											}
											else {
												mysql_query("INSERT INTO GirisLog (IpAdresi,KullaniciAdi) VALUES ('$ip_adresi','$kadi')",$baglan);
											?>
												<div class="alert alert-danger" role="alert">
													<span class="badge badge-danger">Hata</span>
												<?php echo $kadi; ?> - <?php echo $sifrehash; ?>  	Kullanıcı adınız veya şifreniz yanlış.
												</div>
											<?php
											}
										}
									}
								?>
