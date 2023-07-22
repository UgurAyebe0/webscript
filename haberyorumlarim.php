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
        <span class="banner-section">İstatistik</span>
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
          <li class="dropdown-list-item active">
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
        <h2 class="section-title medium">Son Aktiviteler</h2>
        <div class="section-title-separator"></div>
      </div>
      <!-- /SECTION TITLE WRAP -->


<div class="col-md-12">
<div class="filters-row">
<div class="option-list">
<a href="<?php echo $domain2.'panel'; ?>"><p class="option-list-item">Forum Mesajlarım</p></a>
<a href="<?php echo $domain2.'videoyorumlarim'; ?>"><p class="option-list-item">Video Yorumlarım</p></a>
<a href="<?php echo $domain2.'haberyorumlarim'; ?>"><p class="option-list-item selected">Haber Yorumlarım</p></a>
</div>
</div>
<?php 
$sayfada = 20;

$toplam_icerik = $db->prepare("select count(*) from haberyorum where (username = '".$_SESSION['username']."')");
$result = $toplam_icerik->execute();
$toplam_icerik   = $toplam_icerik->fetchColumn();

$toplam_sayfa = ceil($toplam_icerik / $sayfada);

$sayfa = isset($_GET['sayfa']) ? (int) $_GET['sayfa'] : 1;

if($sayfa < 1) $sayfa = 1; 
if($sayfa > $toplam_sayfa) $sayfa = $toplam_sayfa; 

$limit = ($sayfa - 1) * $sayfada;

$sonyorum = $db->query("select * from haberyorum where (username = '".$_SESSION['username']."') order by stamp desc LIMIT ".$limit." , ".$sayfada."");


if($toplam_icerik != '0'){
?>
<div class="table forum-topics">
<div class="table-row-header">

<div class="table-row-header-item padded-big" style="display:table-cell;">
	<p class="table-row-header-title">Tarih</p>
</div>
<div class="table-row-header-item padded-big" style="display:table-cell;">
	<p class="table-row-header-title">Haber</p>
</div>
<div class="table-row-header-item padded-big" style="display:table-cell;">
	<p class="table-row-header-title">Yorum</p>
</div>
<div class="table-row-header-item padded-big" style="display:table-cell;">
	<p class="table-row-header-title">Durum</p>
</div>
</div>
<div class="table-rows">
<?php
	$i = 0;
	foreach($sonyorum as $son){
		$secilihaber = $db->prepare("select * from makaleler where (id = '".$son['haber']."')");
		$result = $secilihaber->execute();
		$secilihaber = $secilihaber->fetch(PDO::FETCH_ASSOC);
		  
		$i++;
		echo '<div class="table-row large">';


		echo '<div class="table-row-item" style="display:table-cell;">';
			echo '<p class="table-text">'.date("d.m.Y H:i",$son['stamp']).'</p>';
		echo '</div>';
		echo '<div class="table-row-item" style="display:table-cell;">';
			echo '<a href="'.$domain2.'haber/'.$secilihaber['urlkodu'].'" style="text-decoration:none;"><p class="table-text">'.$secilihaber['baslik'].'</p></a>';
		echo '</div>';
		echo '<div class="table-row-item" style="display:table-cell;">';
			echo '<p class="table-text">'.mb_substr(strip_tags($son['yorum']),0,25,'UTF-8').'...</p>';
		echo '</div>';
		echo '<div class="table-row-item" style="display:table-cell;">';
		if($son['yayin'] == '1'){
			echo '<p class="table-text"><span class="label label-success" style="padding:7px;">Yayında</span></p>';
		}elseif($son['yayin'] == '0'){
			echo '<p class="table-text"><span class="label label-danger" style="padding:7px;">Onay Bekliyor</span></p>';
		}
		echo '</div>';

		echo '</div>';
	}
?>
  
</div>
</div>

<!-- PAGE NAVIGATION -->
    <div class="page-navigation blue spaced right">
	
<?php
$sayfa_goster = 7;
$en_az_orta = ceil($sayfa_goster/2);
$en_fazla_orta = ($toplam_sayfa+1) - $en_az_orta;
$sayfa_orta = $sayfa;
if($sayfa_orta < $en_az_orta) $sayfa_orta = $en_az_orta;
if($sayfa_orta > $en_fazla_orta) $sayfa_orta = $en_fazla_orta;
$sol_sayfalar = round($sayfa_orta - (($sayfa_goster-1) / 2));
$sag_sayfalar = round((($sayfa_goster-1) / 2) + $sayfa_orta); 
if($sol_sayfalar < 1) $sol_sayfalar = 1;
if($sag_sayfalar > $toplam_sayfa) $sag_sayfalar = $toplam_sayfa;
if ($toplam_sayfa>1) {
if($sayfa != 1){
?>	
<a href="<?php echo $domain2.'haberyorumlarim'; ?>?sayfa=<?php echo $sayfa-1; ?>" aria-controls="bootstrap-data-table" data-dt-idx="0" tabindex="0" class="page-link">
      <div class="slider-control big control-previous">
        <svg class="arrow-icon medium">
          <use xlink:href="#svg-arrow-medium"></use>
        </svg>
      </div>
	  </a>
<?php
}
for($s = $sol_sayfalar; $s <= $sag_sayfalar; $s++) {
					if($sayfa == $s) {
						?>
						<a href="#" class="page-navigation-item active"><?php echo $s; ?></a>
						<?php
					} else {
					?>
						<a class="page-navigation-item" href="<?php echo $domain2.'haberyorumlarim'; ?>?sayfa=<?php echo $s; ?>" aria-controls="bootstrap-data-table" data-dt-idx="1" tabindex="0" class="page-link"><?php echo $s; ?></a>
					<?php
					}
				}
				
if($sayfa != $toplam_sayfa) {				
				
?>
<a href="<?php echo $domain2.'haberyorumlarim'; ?>?sayfa=<?php echo $sayfa+1; ?>" aria-controls="bootstrap-data-table" data-dt-idx="0" tabindex="0" class="page-link">
      <div class="slider-control big control-next">
        <svg class="arrow-icon medium">
          <use xlink:href="#svg-arrow-medium"></use>
        </svg>
      </div>
	  </a>
<?php
}
}
?>
    </div>
    <!-- /PAGE NAVIGATION -->

<?php
}else{
	echo '<p class="text-center light">Henüz yorumunuz bulunmamaktadır.</p>';
}
?>	
</div>

    </div>

  </div>

<?php include_once('footer.php'); ?>