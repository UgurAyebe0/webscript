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
        <span class="banner-section">Arkadaşlarım</span>
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

$ben = $bungeecord->prepare("select * from fr_players where (player_uuid = :player_uuid)");
$result = $ben->execute(array(":player_uuid" => $_SESSION['uuid']));
$ben  = $ben->fetch(PDO::FETCH_ASSOC);

$arkadaslarim = $bungeecord->query("select * from fr_friend_assignment where (friend1_id = '".$ben['player_id']."')");

$arkadaslarim2 = $bungeecord->query("select * from fr_friend_assignment where (friend2_id = '".$ben['player_id']."')");

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
          <li class="dropdown-list-item">
            <a href="<?php echo $domain2; ?>profil_ayarlarim" class="dropdown-list-item-link">Profil Ayarlarım</a>
          </li>
		  <li class="dropdown-list-item active">
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

      </div>
    </div>

    <div class="layout-body"> 
      <!-- SECTION TITLE WRAP -->
      <div class="section-title-wrap blue">
        <h2 class="section-title medium">Arkadaşlarım</h2>
        <div class="section-title-separator"></div>
      </div>
      <!-- /SECTION TITLE WRAP -->

<div class="col-md-12" style="margin-top:15px;"> 
<?php

if($ben['player_name'] != ''){
	foreach($arkadaslarim as $ark){
		$benn = $bungeecord->prepare("select * from fr_players where (player_id = :player_id)");
		$result = $benn->execute(array(":player_id" => $ark["friend2_id"]));
		$benn  = $benn->fetch(PDO::FETCH_ASSOC);
		
		$gercekkisi = $kpanel->prepare("select * from Kullanicilar where (uuid = :uuid)");
		$result = $gercekkisi->execute(array(":uuid" => $benn["player_uuid"]));
		$gercekkisi  = $gercekkisi->fetch(PDO::FETCH_ASSOC);
		
		echo '<div class="col-md-2">';
			echo '<div class="angled-img">';
				echo '<div class="img" style="text-align: center;">';
					echo '<a href="'.$domain.'profil/'.$gercekkisi['username'].'" style="text-decoration:none;"><img src="https://cravatar.eu/avatar/'.$gercekkisi['username'].'" class="user-avatar big" alt="NAVI"></a>';
				echo '</div>';
				echo '<div class="text" style="text-align: center;padding-top: 10px;padding-bottom:10px;">';
					echo '<a class="account-info-username" href="'.$domain.'profil/'.$gercekkisi['username'].'" style="text-decoration:none;color: #363636;line-height: 1em;font-size: .875em;font-family: \'Exo\',sans-serif;
font-weight: 700;">';
						echo $gercekkisi['username'].'<br>';
						
					echo '</a>';
				echo '</div>';
			echo '</div>';
		echo '</div>';
	}
	foreach($arkadaslarim2 as $ark2){
		$benn = $bungeecord->prepare("select * from fr_players where (player_id = :player_id)");
		$result = $benn->execute(array(":player_id" => $ark2["friend1_id"]));
		$benn  = $benn->fetch(PDO::FETCH_ASSOC);
		
		$gercekkisi = $kpanel->prepare("select * from Kullanicilar where (uuid = :uuid)");
		$result = $gercekkisi->execute(array(":uuid" => $benn["player_uuid"]));
		$gercekkisi  = $gercekkisi->fetch(PDO::FETCH_ASSOC);
		
		echo '<div class="col-md-2">';
			echo '<div class="angled-img">';
				echo '<div class="img" style="text-align: center;">';
					echo '<a href="'.$domain.'profil/'.$gercekkisi['username'].'" style="text-decoration:none;"><img src="https://cravatar.eu/avatar/'.$gercekkisi['username'].'" class="user-avatar big" alt="NAVI"></a>';
				echo '</div>';
				echo '<div class="text" style="text-align: center;padding-top: 10px;padding-bottom:10px;">';
					echo '<a class="account-info-username" href="'.$domain.'profil/'.$gercekkisi['username'].'" style="text-decoration:none;color: #363636;line-height: 1em;font-size: .875em;font-family: \'Exo\',sans-serif;
font-weight: 700;">';
						echo $gercekkisi['username'].'<br>';
						
					echo '</a>';
				echo '</div>';
			echo '</div>';
		echo '</div>';
	}
}else{
	echo '<p class="alert alert-warning text-center" style="width:100%;">Arkadaş listeniz boş.</p>';
}
?>

</div>
    </div>
  </div>

<?php include_once('footer.php'); ?>