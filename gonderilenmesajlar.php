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
        <span class="banner-section">Mesajlarım</span>
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
		  <li class="dropdown-list-item active">
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
        <h2 class="section-title medium">Mesajlarım</h2>
        <div class="section-title-separator"></div>
      </div>
      <!-- /SECTION TITLE WRAP -->
<div class="filters-row">
<div class="option-list">
<a href="<?php echo $domain2.'mesajlarim'; ?>"><p class="option-list-item">Mesajlarım</p></a>

<a href="<?php echo $domain2.'gonderilen'; ?>"><p class="option-list-item selected">Giden Kutusu</p></a>

<a href="<?php echo $domain2.'mesajyaz'; ?>"><p class="option-list-item">Mesaj Yaz</p></a>
</div>
</div>
<div class="col-md-12" style="margin-top:15px;"> 
<?php
$mesajlar = $db->query("select * from uyemesajlar where (gonderenkisi = '".$_SESSION['username']."') group by mesajid order by stamp desc");
$mesajlar->execute();
$mesajlar = $mesajlar->fetchAll();
if(!empty($mesajlar)){
echo '<div class="table forum-topics">';
echo '<div class="table-row-header">';
echo '<div class="table-row-header-item padded-big" style="display:table-cell;">';
  echo '<p class="table-row-header-title" style="text-align:left;">Tarih</p>';
echo '</div>';
echo '<div class="table-row-header-item padded-big" style="display:table-cell;">';
  echo '<p class="table-row-header-title" style="text-align:left;">Alıcı</p>';
echo '</div>';
echo '<div class="table-row-header-item padded-big" style="display:table-cell;">';
  echo '<p class="table-row-header-title">Konu</p>';
echo '</div>';
echo '<div class="table-row-header-item padded-big" style="display:table-cell;">';
  echo '<p class="table-row-header-title">Cevaplar</p>';
echo '</div>';
echo '</div>';
echo '<div class="table-rows">';

	foreach($mesajlar as $mes){
		$mesajid = $mes['mesajid'];
		$sonmesaj = $db->prepare("select * from uyemesajlar where (mesajid = '".$mesajid."') order by id desc limit 1");
		$result = $sonmesaj->execute();
		$sonmesaj  = $sonmesaj->fetch(PDO::FETCH_ASSOC);
		
		$mesajsayisi = $db->prepare("select count(*) from uyemesajlar where (mesajid = :mesajid)");
		$result = $mesajsayisi->execute(array(":mesajid" => $mesajid));
		$mesajsayisi  = $mesajsayisi->fetchColumn();
	
$mesajyazannnn = $kpanel->prepare("select * from Kullanicilar where (username = '".$mes['alankisi']."')");
$result = $mesajyazannnn->execute();
$mesajyazannnn  = $mesajyazannnn->fetch(PDO::FETCH_ASSOC);

$grupppp = $yetkiler->prepare("select * from perm_playergroups where (playeruuid = '".$mesajyazannnn["uuid"]."') && (groupid != '16') && (groupid != '17') && (groupid != '18') order by groupid desc");
$result = $grupppp->execute();
$grupppp  = $grupppp->fetch(PDO::FETCH_ASSOC);

$grupadiiii = $yetkiler->prepare("select * from perm_groups where (id = '".$grupppp['groupid']."')");
$result = $grupadiiii->execute();
$grupadiiii  = $grupadiiii->fetch(PDO::FETCH_ASSOC);
if($grupadiiii['name'] == NULL){$grupadiiii['name'] = 'Oyuncu';}
if($grupadiiii['id'] == '6' or $grupadiiii['id'] == NULL){
	$renkkkk = '#5555FF';

}elseif($grupadiiii['id'] == '15'){
	$renkkkk = '#AA0000';
}elseif($grupadiiii['id'] == '7'){
	$renkkkk = '#55FFFF';
}elseif($grupadiiii['id'] == '8'){
	$renkkkk = '#00AAAA';
}elseif($grupadiiii['id'] == '9'){
	$renkkkk = '#00AA00';
}elseif($grupadiiii['id'] == '10'){
	$renkkkk = '#AA00AA';
}elseif($grupadiiii['id'] == '11'){
	$renkkkk = '#55FF55';
}elseif($grupadiiii['id'] == '12'){
	$renkkkk = '#FF55FF';
}elseif($grupadiiii['id'] == '13'){
	$renkkkk = '#FFAA00';
}elseif($grupadiiii['id'] == '14'){
	$renkkkk = '#AA0000';
}	
	
echo '<div class="table-row large">';

echo '<div class="table-row-item" style="display:table-cell;min-width:100px;">'; 
echo '<p class="table-text bold" style="text-align:left;">'.date("d.m.Y H:i",$sonmesaj['stamp']).'</p>'; 
echo '</div>'; 

echo '<div class="table-row-item" style="display:table-cell;min-width:200px;">'; 
echo '<div class="team-info-wrap">';
		  echo '<img class="team-logo small" src="https://cravatar.eu/avatar/'.$mes['alankisi'].'" alt="'.$mes['alankisi'].'">';
		  echo '<div class="team-info">';
			echo '<a href="'.$domain2.'detay/'.$mesajid.'" style="color:'.$renkkkk.' !important;"><p class="team-country" style="font-size: .8em;color:'.$renkkkk.' !important;text-transform:none;">'.$mes['alankisi'].' <span class="tag-ornament" style="vertical-align:middle;margin-top: 0px;margin-left: 5px;background:'.$renkkkk.';">'.$grupadiiii['name'].'</span></a></p>';
		  echo '</div>';
		echo '</div>';

echo '</div>'; 

echo '<div class="table-row-item" style="display:table-cell;">'; 
echo '<a href="'.$domain2.'detay/'.$mesajid.'"><p class="table-text bold" style="text-transform:none;">'.$mes['konu'].'</p></a>'; 
echo '</div>'; 

echo '<div class="table-row-item" style="display:table-cell;">'; 
echo '<a href="'.$domain2.'detay/'.$mesajid.'"><p class="table-text bold">+'.$mesajsayisi.'</p></a>'; 
echo '</div>'; 

echo '</div>';
	}
	
echo '</div>';	
echo '</div>';	
	
}
?>

 


         


</div>
    </div>
  </div>

<?php include_once('footer.php'); ?>