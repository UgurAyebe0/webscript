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
img{
	max-width:100% !important;
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

$talep = $db->prepare("select * from destekmerkezi where (destekid = '".$_REQUEST["p"]."') && (username = '".$kredi['username']."') order by stamp desc limit 1");
$result = $talep->execute();
$talep  = $talep->fetch(PDO::FETCH_ASSOC);
if($talep['username'] == ''){
	header('Location:'.$domain2.'destekmerkezi');
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
        <span class="banner-section">Destek Merkezi</span>
		<!-- ARROW ICON -->
        <svg class="arrow-icon">
          <use xlink:href="#svg-arrow"></use>
        </svg>
        <!-- /ARROW ICON -->
        <span class="banner-section"><?php echo $talep['konu']; ?>  - #<?php echo $talep['destekid']; ?></span>
      </p>
    </div>
    <!-- /BANNER -->
  </div>
 <?php
  if($_SESSION['gonderildi'] != NULL){
	echo '<script>alert(\''.$_SESSION['gonderildi'].'\')</script>';
	$_SESSION['gonderildi'] = NULL;
}
?>
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
		  <li class="dropdown-list-item">
            <a href="<?php echo $domain2; ?>arkadaslarim" class="dropdown-list-item-link">Arkadaşlarım</a>
          </li>
		  <li class="dropdown-list-item">
            <a href="<?php echo $domain2; ?>mesajlarim" class="dropdown-list-item-link">Mesajlarım</a>
          </li>
		  <li class="dropdown-list-item active">
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
        <h2 class="section-title medium">Destek Merkezi</h2>
        <div class="section-title-separator"></div>
      </div>
      <!-- /SECTION TITLE WRAP -->
<div class="col-md-12">
<div class="filters-row">
<div class="option-list">
<a href="<?php echo $domain2.'destekmerkezi'; ?>"><p class="option-list-item">Tüm Taleplerim</p></a>
<a href="<?php echo $domain2.'talepolustur'; ?>"><p class="option-list-item">Yeni Talep</p></a>
<a href="<?php echo $domain2.'destekdetay/'.$talep['destekid']; ?>"><p class="option-list-item selected"><?php echo $talep['konu']; ?>  - #<?php echo $talep['destekid']; ?></p></a>
</div>
</div>
<?php

echo '<div class="alert alert-success" role="alert">';
echo '<span class="badge badge-success" style="border-radius:2px;">Durum:</span> <span style="font-size: .925em;font-family: \'Exo\',sans-serif;font-weight:700;padding: 19px;">'.$talep['durum'].'</span>';
echo '</div>';

$talepler = $db->query("select * from destekmerkezi where (destekid = '".$talep['destekid']."') order by stamp asc");

echo '<div class="table forum-topics">';
echo '<div class="table-row-header">';

echo '<div class="table-row-header-item padded-big" style="display:table-cell;">';
  echo '<p class="table-row-header-title" style="text-align:left;">Gönderen</p>';
echo '</div>';

echo '<div class="table-row-header-item padded-big" style="display:table-cell;">';
  echo '<p class="table-row-header-title" style="text-align:left;">Mesaj</p>';
echo '</div>';

echo '<div class="table-row-header-item padded-big" style="display:table-cell;">';
  echo '<p class="table-row-header-title">Tarih</p>';
echo '</div>';

echo '</div>';
echo '<div class="table-rows">';

foreach($talepler as $tal){

echo '<div class="table-row large">';

if($tal['admin'] == '0'){
	$grup = $yetkiler->prepare("select * from perm_playergroups where (playeruuid = :playeruuid) && (groupid != '16') && (groupid != '17') && (groupid != '18') order by groupid desc");
$result = $grup->execute(array(":playeruuid" => $kredi["uuid"]));
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
echo '<div class="table-row-item" style="display:table-cell;min-width: 200px;">'; 
echo '<div class="team-info-wrap">';
		  echo '<img class="team-logo small gizle" src="https://cravatar.eu/avatar/'.$kredi['username'].'" alt="'.$kredi['username'].'">';
		  echo '<div class="team-info">';
			echo '<a href="'.$domain2.'profil/'.$kredi['username'].'" style="color:'.$renk.' !important;"><p class="team-country" style="font-size: .8em;color:'.$renk.' !important;text-transform:none;">'.$kredi['username'].' <span class="tag-ornament gizle" style="vertical-align:middle;margin-top: 0px;margin-left: 5px;background:'.$renk.';">'.$grupadi['name'].'</span></a></p>';
		  echo '</div>';
		echo '</div>';
echo '</div>'; 

}else{
$oyuncu = $kpanel->prepare("select * from Kullanicilar where (username = :username)");
$result = $oyuncu->execute(array(":username" => $tal["yetkili"]));
$oyuncu  = $oyuncu->fetch(PDO::FETCH_ASSOC);
$grup = $yetkiler->prepare("select * from perm_playergroups where (playeruuid = :playeruuid) && (groupid != '16') && (groupid != '17') && (groupid != '18') order by groupid desc");
$result = $grup->execute(array(":playeruuid" => $oyuncu["uuid"]));
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
echo '<div class="table-row-item" style="display:table-cell;min-width: 200px;">'; 
echo '<div class="team-info-wrap">';
		  echo '<img class="team-logo small gizle" src="https://cravatar.eu/avatar/'.$oyuncu['username'].'" alt="'.$oyuncu['username'].'">';
		  echo '<div class="team-info">';
			echo '<a href="'.$domain2.'profil/'.$oyuncu['username'].'" style="color:'.$renk.' !important;"><p class="team-country" style="font-size: .8em;color:'.$renk.' !important;text-transform:none;">'.$oyuncu['username'].' <span class="tag-ornament gizle" style="vertical-align:middle;margin-top: 0px;margin-left: 5px;background:'.$renk.';">'.$grupadi['name'].'</span></a></p>';
		  echo '</div>';
		echo '</div>';
echo '</div>';
}
echo '<div class="table-row-item" style="display:table-cell;">'; 
echo '<p class="" style="text-transform:none;">'.$tal['icerik'].'</p>'; 
echo '</div>'; 
  
echo '<div class="table-row-item" style="display:table-cell;min-width:100px;">'; 
echo '<p class="table-text bold" ><i class="fa fa-calendar"></i> '.date("d.m.y H:i", $tal['stamp']).'</p>'; 
echo '</div>';

echo '</div>';
	}
	
echo '</div>';	
echo '</div>';	
?>
<?php 
if($talep['durum'] != 'Kapatıldı'){
?>
<form method="POST" class="comment-form">
<div class="form-row">
<div class="form-item blue">
	<label for="eski" class="rl-label">Yanıt Gönder</label>
	<textarea placeholder="Yanıtınız" class="top ckeditor" name="mesaj" rows="5" required></textarea>
  </div> 
</div>
<button onclick = "this.form.submit();" class="button blue" name="mesajikaydet" style="margin-top:10px;">Gönder
	<span class="button-ornament">
	  <svg class="arrow-icon medium">
		<use xlink:href="#svg-arrow-medium"></use>
	  </svg>

	  <svg class="cross-icon small">
		<use xlink:href="#svg-cross-small"></use>
	  </svg>
	</span>
	</button>

</form>
<?php
if($_POST['mesaj'] != NULL){
	$kontroll = $db->prepare("select * from destekmerkezi where (username = :username) order by stamp desc limit 1");
	$result = $kontroll->execute(array(":username" => $_SESSION['username']));
	$kontrol   = $kontroll->fetch(PDO::FETCH_ASSOC);
	
	$zamankontrol = time() - $kontrol['stamp'];  
	if($zamankontrol >= 90 ){
	$username = $kredi['username'];
	$konu = $talep['konu'];
	$departman = $talep['departman'];
	$durum = 'Bekliyor';
	$stamp = time();
	$icerik = $_POST['mesaj'];
	$destekid = $_REQUEST['p'];
	$yayin = '1';
	$admin = '0';
	$kapali = '0';
	
	$db->query("insert into destekmerkezi (username, konu, departman, durum, stamp, icerik, destekid, yayin, admin, kapali) values ('$username', '$konu', '$departman', '$durum', '$stamp', '$icerik', '$destekid', '$yayin', '$admin', '$kapali') ");
	
	$db->query("update destekmerkezi set durum = 'Bekliyor' where (destekid = '".$_REQUEST['p']."')");
	
	$_SESSION['gonderildi'] = 'Talebiniz başarıyla gönderilmiştir.En kısa sürede yanıtlanacaktır.';
	
	header('Location:'.$domain2.'destekdetay/'.$_REQUEST['p']);	
	}else{
		echo '<script>alert(\'Yeni mesaj göndermeden önce 90sn beklemelisiniz\')</script>';
	}
}
}else{
echo '<div class="alert alert-warning" role="alert">';
echo '<span class="badge badge-warning">NOT:</span> Destek talebi kapatıldığı için yanıt veremezsiniz.';
echo '</div>';
}
?>



</div>


    </div>

  </div>

<?php include_once('footer.php'); ?>