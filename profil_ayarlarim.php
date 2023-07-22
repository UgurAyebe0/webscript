<?php include_once('header.php'); ?>
<style>
.banner-wrap.forum-banner {
    background: url("<?php echo $domain; ?>images/home-slide/galeri_9854494.jpg") no-repeat center,linear-gradient(45deg, #f30a5c, #1c95f3);
    background-size: auto, auto;
    background-size: cover;
}
@media screen and (max-width:700px){
	body{
		overflow-x:auto;
	}
}
</style>
<?php
if($_SESSION['username'] == NULL){
	header('Location:'.$domain2);
}
$kredi = $kpanel->prepare("select * from Kullanicilar where (uuid = :uuid)");
$result = $kredi->execute(array(":uuid" => $_SESSION["uuid"]));
$kredi  = $kredi->fetch(PDO::FETCH_ASSOC);

$alinanurun = $kpanel->prepare("select count(*) from UrunLog where (KullaniciId = :KullaniciId)");
$result = $alinanurun->execute(array(":KullaniciId" => $_SESSION["kid"]));
$alinanurun  = $alinanurun->fetchColumn();

$benn = $bungeecord->prepare("select * from fr_players where (player_uuid = :player_uuid)");
$result = $benn->execute(array(":player_uuid" => $_SESSION['uuid']));
$benn  = $benn->fetch(PDO::FETCH_ASSOC);

$arksayi = $bungeecord->prepare("select count(*) from fr_friend_assignment where (friend1_id = :friend1_id)");
$result = $arksayi->execute(array(":friend1_id" => $benn['player_id']));
$arksayi  = $arksayi->fetchColumn();

$arksayi2 = $bungeecord->prepare("select count(*) from fr_friend_assignment where (friend2_id = :friend1_id)");
$result = $arksayi2->execute(array(":friend1_id" => $benn['player_id']));
$arksayi2  = $arksayi2->fetchColumn();

$arkadassayi = $arksayi + $arksayi2;

$grup = $yetkiler->prepare("select * from perm_playergroups where (playeruuid = :playeruuid) && (groupid != '16') && (groupid != '17') && (groupid != '18') order by groupid desc");
$result = $grup->execute(array(":playeruuid" => $_SESSION["uuid"]));
$grup  = $grup->fetch(PDO::FETCH_ASSOC);

$grupadi = $yetkiler->prepare("select * from perm_groups where (id = :id)");
$result = $grupadi->execute(array(":id" => $grup['groupid']));
$grupadi  = $grupadi->fetch(PDO::FETCH_ASSOC);

if($grupadi['name'] == NULL){$grupadi['name'] = 'Oyuncu';}
if($grupadi['id'] == '6' or $grupadi['id'] == NULL){
	$renk = '#5555FF';

}elseif($grupadi['id'] == '15'){
	$renk = '#AA0000';
}elseif($grupadi['id'] == '7'){
	$renk = '#55FFFF';
}elseif($grupadi['id'] == '8'){
	$renk = '#00AAAA';
}elseif($grupadi['id'] == '9'){
	$renk = '#00AA00';
}elseif($grupadi['id'] == '10'){
	$renk = '#AA00AA';
}elseif($grupadi['id'] == '11'){
	$renk = '#55FF55';
}elseif($grupadi['id'] == '12'){
	$renk = '#FF55FF';
}elseif($grupadi['id'] == '13'){
	$renk = '#FFAA00';
}elseif($grupadi['id'] == '14'){
	$renk = '#AA0000';
}

?>
  <!-- BANNER WRAP -->
  <div class="banner-wrap forum-banner">
    <!-- BANNER -->
    <div class="banner grid-limit">
      <h2 class="banner-title">Hesabım</h2>
      <p class="banner-sections">
        <span class="banner-section">Anasayfa</span>
        <!-- ARROW ICON -->
        <svg class="arrow-icon">
          <use xlink:href="#svg-arrow"></use>
        </svg>
        <!-- /ARROW ICON -->
        <span class="banner-section">Profil Ayarlarım</span>
      </p>
    </div>
    <!-- /BANNER -->
  </div>
  <!-- /BANNER WRAP -->
<?php include_once('slidenews.php'); ?>

  <div class="layout-content-4 layout-item-1-3 grid-limit">
    <div class="layout-sidebar">
      <div class="account-info-wrap">
        <img class="user-avatar big" src="https://cravatar.eu/avatar/<?php echo $_SESSION['username']; ?>" alt="<?php echo $_SESSION['username']; ?>">
        <p class="account-info-username" style="text-transform:none;"><?php echo $_SESSION['username']; ?></p>
        <p class="account-info-name"><span class="tag-ornament" style="vertical-align:middle;margin-top: 0px;margin-left: 5px;background:<?php echo $renk; ?>;"><?php echo $grupadi['name']; ?></span></p>
        <div class="account-info-stats">
<?php 
	if($kredi['Kredi'] != NULL){
		$kredim = $kredi['Kredi']; 
	}else{
		$kredim = '0'; 
	}
	
$timebilgi = strtotime($kredi['kayittarihi']);
$songorulme = $bungeecord->prepare("select * from fr_players where (player_uuid = '".$_SESSION['uuid']."')");
$result = $songorulme->execute();
$songorulme   = $songorulme->fetch(PDO::FETCH_ASSOC);
$song = strtotime($songorulme['last_online']);	
?>
<?php
$bilgi = $kpanel->prepare("select * from Kullanicilar where (uuid = '".$_SESSION['uuid']."')");
$result = $bilgi->execute();
$bilgi  = $bilgi->fetch(PDO::FETCH_ASSOC);

?>
          <div class="account-info-stat">
            <p class="account-info-stat-value"><?php echo $kredim.' <a href="'.$domain.'krediyukle" title="Kredi Yükle"><img src="'.$domain.'images/plus.png" width="10px" style="margin-bottom:3px;"></a>'; ?></p>
            <p class="account-info-stat-title">Toplam Kredin</p>
          </div>
          <div class="account-info-stat">
            <p class="account-info-stat-value"><?php echo $alinanurun; ?></p>
            <p class="account-info-stat-title">ALINAN ÜRÜN</p>
          </div>
          <div class="account-info-stat">
            <p class="account-info-stat-value"><?php echo $arkadassayi; ?></p>
            <p class="account-info-stat-title">ARKADAŞ SAYISI</p>
          </div>
        </div>
		
		<div class="account-info-stats">
		<div class="account-info-stat">
            <p class="account-info-stat-title"><b>Kayıt:</b> <?php echo date("d.m.Y ",$timebilgi).' '; ?></p>
        </div>
		<div class="account-info-stat">
            <p class="account-info-stat-title"><b>Son Görülme:</b> <?php echo date("d.m.Y ",$song); ?></p>
        </div>
		</div>

        <ul class="dropdown-list void">
          <li class="dropdown-list-item">
            <a href="<?php echo $domain2; ?>durumum" class="dropdown-list-item-link">Durumum</a>
          </li>
          <li class="dropdown-list-item">
            <a href="<?php echo $domain2; ?>panel" class="dropdown-list-item-link">Son Aktiviteler</a>
          </li>
          <li class="dropdown-list-item">
            <a href="<?php echo $domain2; ?>gecmis" class="dropdown-list-item-link">Geçmiş</a>
          </li>
          <li class="dropdown-list-item active">
            <a href="<?php echo $domain2; ?>profil_ayarlarim" class="dropdown-list-item-link">Profil Ayarlarım</a>
          </li>
		  <li class="dropdown-list-item">
            <a href="<?php echo $domain2; ?>arkadaslarim" class="dropdown-list-item-link">Arkadaşlarım</a>
          </li>
		  <li class="dropdown-list-item">
            <a href="<?php echo $domain2; ?>mesajlarim" class="dropdown-list-item-link">Mesajlarım</a>
          </li>
		  <li class="dropdown-list-item">
            <a href="<?php echo $domain2; ?>destekmerkezi" class="dropdown-list-item-link">Destek Taleplerim</a>
          </li>
		  <li class="dropdown-list-item">
            <a href="<?php echo $domain2; ?>videolarim" class="dropdown-list-item-link">Videolarım</a>
          </li>
        </ul>
		
		<div class="side-block">
                    <div class="section-title-wrap blue">
        <h2 class="section-title medium">Bilgiler</h2>
        <div class="section-title-separator"></div>
      </div>
                    <div class="block-content" >
                        <div class="block-content p-0" style="padding-top:10px !important;">
                            <p class="">
                                <label class="label " style="min-width:50px;padding:10px;color: #363636;">
                                    Kullanıcı Adı:
                                    <span style="font-size:11px;font-weight:400;text-transform:none;">
                                       <?php echo $_SESSION['username']; ?> 
                                    </span>
                                </label>
                            </p>
                        </div>
                        
                        <div class="block-content p-0" style="padding-top:10px !important;">
                            <p class="">
                                <label class="label " style="min-width:50px;padding:10px;color: #363636;">
                                    UUID:
                                    <span style="font-size:11px;font-weight:400;text-transform:none;">
                                       <?php echo $_SESSION['uuid']; ?>  
                                    </span>
                                </label>
                            </p>
                        </div>

                        <div class="block-content p-0" style="padding-top:10px !important;">
                            <p class="">
                                <label class="label " style="min-width:50px;padding:10px;color: #363636;">
                                    Kayıt Tarihi:
                                    <span style="font-size:11px;font-weight:400;text-transform:none;">
                                       <?php echo date("d-m-Y H:i",strtotime($bilgi['kayittarihi'])); ?>
                                    </span>
                                </label>
                            </p>
                        </div>
                        <div class="block-content p-0" style="padding-top:10px !important;">
                            <p class="">
                                <label class="label " style="min-width:50px;padding:10px;color: #363636;">
                                    Eposta:
                                    <span style="font-size:11px;font-weight:400;text-transform:none;">
                                       <?php echo $bilgi['email']; ?>
                                    </span>
                                </label>
                            </p>
                        </div>
                    </div>
                </div>
		
		
      </div>
    </div>

    <div class="layout-body"> 
      <!-- SECTION TITLE WRAP -->
      <div class="section-title-wrap blue">
        <h2 class="section-title medium">Profil Ayarlarım</h2>
        <div class="section-title-separator"></div>
      </div>
      <!-- /SECTION TITLE WRAP -->

<div class="col-md-12"> 
<div class="filters-row">
<div class="option-list">
<p class="option-list-item selected">Şifre Güncelleme</p>
</div>

</div>
 <?php  
		if($_SESSION['kontrol'] != ''){
			echo '<div class="alert alert-warning" role="alert" style="margin-top:10px;">'.$_SESSION['kontrol'].'</div>';
			$_SESSION['kontrol'] = '';
		}		
	?>
<form class="account-settings-form" method="POST" style="margin-top:15px;">
				<div class="form-row">
                  <div class="form-item blue">
                    <label for="eski" class="rl-label">Eski Şifreniz</label>
                    <input type="password" id="eski" name="eski"  placeholder="Geçerli Şifreniz..." required>
               
                  </div> 
                </div>
                <div class="form-row">   
                  <div class="form-item half blue">
                    <label for="as_first_name" class="rl-label">Yeni Şifreniz</label>
                    <input type="password" id="as_first_name" name="yeni" placeholder="Yeni Şifreniz..." required>
                  </div>
                  <div class="form-item half blue">
                    <label for="as_last_name" class="rl-label">Tekrar Yeni Şifreniz</label>
                    <input type="password" id="as_last_name" name="yenikontrol" placeholder="Tekrar Yeni Şifreniz..." required>
                  </div>
				  
                </div>
                
                <div class="submit-button-wrap">
                  <button onclick = "this.form.submit();" class="button blue">
                    Şifreyi Güncelle
                    <span class="button-ornament">
                      <svg class="arrow-icon medium">
                        <use xlink:href="#svg-arrow-medium"></use>
                      </svg>

                      <svg class="cross-icon small">
                        <use xlink:href="#svg-cross-small"></use>
                      </svg>
                    </span>
                  </button>
                </div>
              </form>

<?php
if($_POST['eski'] != ''){
	if($_POST['yeni'] != $_POST['yenikontrol']){
		$_SESSION['kontrol'] = 'Girdiğiniz şifreler uyuşmuyor. Lütfen tekrar deneyiniz.';
		header('Location:'.$domain2.'profil_ayarlarim');
	}elseif($_POST['yeni'] == '' or $_POST['yenikontrol'] == ''){
		$_SESSION['kontrol'] = 'Boş alan bırakmayınız. Lütfen tekrar deneyiniz.';
		header('Location:'.$domain2.'profil_ayarlarim');
	}elseif(strlen($_POST['yeni'])<6 OR strlen($_POST['yeni'])>18){
		$_SESSION['kontrol'] = 'Şifreniz en az 6 karakter, en fazla 18 karakter olabilir. Lütfen tekrar deneyiniz.';
		header('Location:'.$domain2.'profil_ayarlarim');
	}else{
		$test = SifreleSite($_POST['eski']);
		$kontrolsifre = $kpanel->prepare("select * from Kullanicilar where (username = '".$_SESSION['username']."') && (passwordsite = '".$test."')");
		$result = $kontrolsifre->execute();
		$kontrolsifre   = $kontrolsifre->fetch(PDO::FETCH_ASSOC);
		
		if($kontrolsifre['password'] != ''){
			
			$yenisifre2 = Sifrele($_POST['yeni']);	
			$yenisifre = SifreleSite($_POST['yeni']);
					
			
			$kpanel->query("update Kullanicilar set password = '".$yenisifre2."', passwordsite = '".$yenisifre."' where (username = '".$_SESSION['username']."')");
			$_SESSION['kontrol'] = 'Şifreniz Başarıyla Güncellenmiştir.';
			header('Location:'.$domain2.'profil_ayarlarim');
		}else{
			$_SESSION['kontrol'] = 'Eski parolanızı hatalı girdiniz. Tekrar deneyiniz.';
			header('Location:'.$domain2.'profil_ayarlarim');
		}
		
	}
	
}
?>	
   
</div>

<div class="col-md-12" style="margin-top:30px;"> 
<div class="filters-row">
<div class="option-list">
<p class="option-list-item selected">İletişim Güncelleme</p>
</div>

</div>
<form class="account-settings-form" method="POST" style="margin-top:15px;">
				<div class="form-row">
                  <div class="form-item blue">
                    <label for="eski" class="rl-label">Skype</label>
                    <input type="text" id="eski" name="skype"  placeholder="..." value="<?php echo $bilgi['skype']; ?>" >
               
                  </div> 
                </div>
				<div class="form-row">
                  <div class="form-item blue">
                    <label for="eski" class="rl-label">Discord</label>
                    <input type="text" id="eski" name="discord"  placeholder="..." value="<?php echo $bilgi['discord']; ?>" >
               
                  </div> 
                </div>
				<div class="form-row">
                  <div class="form-item blue">
                    <label for="eski" class="rl-label">Steam</label>
                    <input type="text" id="eski" name="steam"  placeholder="..." value="<?php echo $bilgi['steam']; ?>" >
               
                  </div> 
                </div>
				<div class="form-row">
                  <div class="form-item blue">
                    <label for="eski" class="rl-label">Youtube</label>
                    <input type="text" id="eski" name="youtube"  placeholder="..." value="<?php echo $bilgi['youtube']; ?>" >
               
                  </div> 
                </div>
				<div class="form-row">
                  <div class="form-item blue">
                    <label for="eski" class="rl-label">Şehir</label>
<select name="il">
<?php 
if($bilgi['il'] != ''){
	echo '<option value="'.$bilgi['il'].'">'.$bilgi['il'].'</option>';
}
?>
										<option value="Belirtilmedi">Lütfen İl Seçiniz</option>

										<option value="Adana">Adana</option>

										<option value="Adıyaman">Adıyaman</option>

										<option value="Afyonkarahisar">Afyonkarahisar</option>

										<option value="Ağrı">Ağrı</option>

										<option value="Amasya">Amasya</option>

										<option value="Ankara">Ankara</option>

										<option value="Antalya">Antalya</option>

										<option value="Artvin">Artvin</option>

										<option value="Aydın">Aydın</option>

										<option value="Balıkesir">Balıkesir</option>

										<option value="Bilecik">Bilecik</option>

										<option value="Bingöl">Bingöl</option>

										<option value="Bitlis">Bitlis</option>

										<option value="Bolu">Bolu</option>

										<option value="Burdur">Burdur</option>

										<option value="Bursa">Bursa</option>

										<option value="Çanakkale">Çanakkale</option>

										<option value="Çankırı">Çankırı</option>

										<option value="Çorum">Çorum</option>

										<option value="Denizli">Denizli</option>

										<option value="Diyarbakır">Diyarbakır</option>

										<option value="Edirne">Edirne</option>

										<option value="Elazığ">Elazığ</option>

										<option value="Erzincan">Erzincan</option>

										<option value="Erzurum">Erzurum</option>

										<option value="Eskişehir">Eskişehir</option>

										<option value="Gaziantep">Gaziantep</option>

										<option value="Giresun">Giresun</option>

										<option value="Gümüşhane">Gümüşhane</option>

										<option value="Hakkari">Hakkari</option>

										<option value="Hatay">Hatay</option>

										<option value="Isparta">Isparta</option>

										<option value="Mersin">Mersin</option>

										<option value="İstanbul">İstanbul</option>

										<option value="İzmir">İzmir</option>

										<option value="Kars">Kars</option>

										<option value="Kastamonu">Kastamonu</option>

										<option value="Kayseri">Kayseri</option>

										<option value="Kırklareli">Kırklareli</option>

										<option value="Kırşehir">Kırşehir</option>

										<option value="Kocaeli">Kocaeli</option>

										<option value="Konya">Konya</option>

										<option value="Kütahya">Kütahya</option>

										<option value="Malatya">Malatya</option>

										<option value="Manisa">Manisa</option>

										<option value="Kahramanmaraş">Kahramanmaraş</option>

										<option value="Mardin">Mardin</option>

										<option value="Muğla">Muğla</option>

										<option value="Muş">Muş</option>

										<option value="Nevşehir">Nevşehir</option>

										<option value="Niğde">Niğde</option>

										<option value="Ordu">Ordu</option>

										<option value="Rize">Rize</option>

										<option value="Sakarya">Sakarya</option>

										<option value="Samsun">Samsun</option>

										<option value="Siirt">Siirt</option>

										<option value="Sinop">Sinop</option>

										<option value="Sivas">Sivas</option>

										<option value="Tekirdağ">Tekirdağ</option>

										<option value="Tokat">Tokat</option>

										<option value="Trabzon">Trabzon</option>

										<option value="Tunceli">Tunceli</option>

										<option value="Şanlıurfa">Şanlıurfa</option>

										<option value="Uşak">Uşak</option>

										<option value="Van">Van</option>

										<option value="Yozgat">Yozgat</option>

										<option value="Zonguldak">Zonguldak</option>

										<option value="Aksaray">Aksaray</option>

										<option value="Bayburt">Bayburt</option>

										<option value="Karaman">Karaman</option>

										<option value="Kırıkkale">Kırıkkale</option>

										<option value="Batman">Batman</option>

										<option value="Şırnak">Şırnak</option>

										<option value="Bartın">Bartın</option>

										<option value="Ardahan">Ardahan</option>

										<option value="Iğdır">Iğdır</option>

										<option value="Yalova">Yalova</option>

										<option value="Karabük">Karabük</option>

										<option value="Kilis">Kilis</option>

										<option value="Osmaniye">Osmaniye</option>

										<option value="Düzce">Düzce</option>

									</select>                   
               
                  </div> 
                </div>
				<div class="form-row">
                  <div class="form-item blue">
                    <label for="eski" class="rl-label">Hakkımda</label>
                    <textarea placeholder="Hakkımda" name="hakkimda" rows="5"> <?php echo $bilgi['hakkimda']; ?></textarea>
               
                  </div> 
                </div>
                
                <div class="submit-button-wrap">
                  <button onclick = "this.form.submit();" class="button blue">
                    Bilgileri Güncelle
                    <span class="button-ornament">
                      <svg class="arrow-icon medium">
                        <use xlink:href="#svg-arrow-medium"></use>
                      </svg>

                      <svg class="cross-icon small">
                        <use xlink:href="#svg-cross-small"></use>
                      </svg>
                    </span>
                  </button>
                </div>
              </form>
<?php
if($_POST['il'] != ''){
	
	$username = $_SESSION['username'];
	$skype = $_POST['skype'];
	$discord = $_POST['discord'];
	$steam = $_POST['steam'];
	$youtube = $_POST['youtube'];
	$il = $_POST['il'];
	$hakkimda = $_POST['hakkimda'];
	
	
	$profilguncelle = $kpanel->query("update Kullanicilar set skype = '".$skype."', discord = '".$discord."', steam = '".$steam."', youtube = '".$youtube."', il = '".$il."', hakkimda = '".$hakkimda."' where (username = '".$username."')");
	$_SESSION['kontrol'] = 'Bilgileriniz güncellenmiştir.';
	header('Location:'.$domain2.'profil_ayarlarim');
	
	
}


?>
	
   
</div>



    </div>

  </div>

<?php include_once('footer.php'); ?>