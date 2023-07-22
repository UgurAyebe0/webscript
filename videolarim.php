<?php
include_once('header.php');

?>
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
		  <li class="dropdown-list-item active">
            <a href="<?php echo $domain2; ?>videolarim" class="dropdown-list-item-link">Videolarım</a>
          </li>
        </ul>
		
		
		
		
      </div>
    </div>

    <div class="layout-body"> 
      <!-- SECTION TITLE WRAP -->
      <div class="section-title-wrap blue">
        <h2 class="section-title medium">Videolarım</h2>
        <div class="section-title-separator"></div>
      </div>
      <!-- /SECTION TITLE WRAP -->

<div class="col-md-12"> 
<div class="filters-row">
<div class="option-list">
<a href="<?php echo $domain2.'videolarim'; ?>"><p class="option-list-item selected">Tüm Videolarım</p></a>
<a href="<?php echo $domain2.'yenivideo'; ?>"><p class="option-list-item">Yeni Video Ekle</p></a>
</div>
</div>
 <?php  
		if($_SESSION['kontrol'] != ''){
			echo '<div class="alert alert-warning" role="alert" style="margin-top:10px;">'.$_SESSION['kontrol'].'</div>';
			$_SESSION['kontrol'] = '';
		}		
	?>

<?php
$sayfada = 12;

$toplam_icerik = $db->prepare("select count(*) from youtube where (yayin = '1')");
$result = $toplam_icerik->execute();
$toplam_icerik   = $toplam_icerik->fetchColumn();

$toplam_sayfa = ceil($toplam_icerik / $sayfada);

$sayfa = isset($_GET['sayfa']) ? (int) $_GET['sayfa'] : 1;

if($sayfa < 1) $sayfa = 1; 
if($sayfa > $toplam_sayfa) $sayfa = $toplam_sayfa; 

$limit = ($sayfa - 1) * $sayfada;

$yukleyen = $_SESSION['username'];

$videolar = $db->query("select * from youtube where (yukleyen = '".$yukleyen."') order by stamp desc LIMIT ".$limit." , ".$sayfada."");

$videolar->execute();
$videolar = $videolar->fetchAll();
?>
<div class="post-preview-showcase grid-3col centered">
        
		
		<!-- POST PREVIEW -->
<?php

foreach($videolar as $video){
	echo '<div class="post-preview video game-review">';
		echo '<a href="'.$domain2.'video/'.$video['urlkodu'].'">';
			echo '<div class="post-preview-img-wrap">';
				echo '<figure class="post-preview-img liquid imgLiquid_bgSize imgLiquid_ready" style="background-image: url(&quot;'.$domain.'images/blog/'.$video['kapak'].'&quot;); background-size: cover; background-position: center center; background-repeat: no-repeat;"><img src="'.$domain.'images/blog/'.$video['kapak'].'" alt="post-02" style="display: none;"></figure>';
				echo '<div class="post-preview-overlay">';
					echo '<div class="play-button">';
						echo '<svg class="play-button-icon">';
							echo '<use xlink:href="#svg-play"></use>';
						echo '</svg>';
					echo '</div>';
				echo '</div>';
			echo '</div>';
		echo '</a>';
if($video['yayin'] != '1'){
	echo '<a href="'.$domain2.'video/'.$video['urlkodu'].'" class="tag-ornament" style="text-transform:none;top: 10px;width: 100%;text-align: center;">Onay Bekliyor</a>';
}else{
	echo '<a href="'.$domain2.'video/'.$video['urlkodu'].'" class="tag-ornament" style="text-transform:none;top: 10px;width: 100%;text-align: center;background-color:#18bb45;">Yayınlandı</a>';
}
	echo '<form method="POST">';
	echo '<input type="submit" name="sil'.$video['id'].'" class="tag-ornament" style="left:auto;right:0;background-color:#f90808;" value="X Sil" onclick="return sayfasil()">';

	echo '</form>';
		echo '<a href="'.$domain2.'video/'.$video['urlkodu'].'" class="tag-ornament" style="text-transform:none;">'.$video['yukleyen'].'</a>';
		
		echo '<a href="'.$domain2.'video/'.$video['urlkodu'].'" class="post-preview-title" style="min-height:35px;">'.$video['baslik'].'</a>';  
		echo '<div class="post-author-info-wrap">';
	if($video['yukleyen'] == 'CandyCraft'){
		echo '<p class="post-author-info small light">Yükleyen <a href="'.$domain.'" class="post-author">'.$video['yukleyen'].'</a><span class="separator">|</span>'.date("d.m.y H:i",$video['stamp']).'</p>';
	}else{
		echo '<p class="post-author-info small light">Yükleyen <a href="'.$domain2.'profil/'.$video['yukleyen'].'" class="post-author">'.$video['yukleyen'].'</a><span class="separator">|</span>'.date("d.m.y H:i",$video['stamp']).'</p>';
	}  
		echo '</div>';
	echo '</div>';
	
	if($_POST['sil'.$video['id']]){
		
		$db->query("delete from youtube where (id = '".$video['id']."') && (yukleyen = '".$yukleyen."')");
		
		$videokontrol = $db->prepare("select * from encokvideo where (username = '".$yukleyen."')");
		$result = $videokontrol->execute();
		$videokontrol  = $videokontrol->fetch(PDO::FETCH_ASSOC);
		
		$sayi = $videokontrol['videosayi'] - 1;
		
		$db->query("update encokvideo set videosayi = '".$sayi."' where (username = '".$yukleyen."')");
		
		header('Location:'.$domain2.'videolarim');
	}
}
?>		
        
        <!-- /POST PREVIEW -->
    
        

        

        
      </div>


   
</div>



    </div>

  </div>

<?php include_once('footer.php'); ?>
<script>
function sayfasil() {
return	confirm("Seçtiğiniz video sistemden silinecektir, onaylıyor musunuz?");
}
</script>