<?php include_once('header.php'); ?>
<style>
.banner-wrap.forum-banner {
    background: url("<?php echo $domain; ?>images/home-slide/galeri_9854494.jpg") no-repeat center,linear-gradient(45deg, #f30a5c, #1c95f3);
    background-size: auto, auto;
    background-size: cover;
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
          <li class="dropdown-list-item active">
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
		  <li class="dropdown-list-item">
            <a href="<?php echo $domain2; ?>videolarim" class="dropdown-list-item-link">Videolarım</a>
          </li>
        </ul>
      </div>
    </div>

    <div class="layout-body">
      <!-- SECTION TITLE WRAP -->
      <div class="section-title-wrap blue">
        <h2 class="section-title medium">Durumum</h2>
        <div class="section-title-separator"></div>
      </div>
      <!-- /SECTION TITLE WRAP -->

<div class="layout-item grid-2col_3 centered gutter-mid" style="margin-top:10px;">
<?php
	echo '<div class="post-preview medium movie-news" style="border:1px solid #ddd;border-radius:7px;padding-bottom:10px;">';
            echo '<div class="post-preview-img-wrap" style="max-height:225px;overflow:hidden;">';
              echo '<figure class="post-preview-img liquid">';
                echo '<img src="'.$domain.'images/ccpuan.jpg" alt="CC-Puan">';
              echo '</figure>';
				echo '<span class="tag-ornament" style="top: 10px;width: 100%;text-align: center;">CC-Puan</span>';
				echo '<p class="post-preview-text"></p>';
			echo '</div>';
$puanidd = $puan->prepare("select * from cc3_account where (name = '".$_SESSION['username']."')");
$result = $puanidd->execute();
$puanid = $puanidd->fetch(PDO::FETCH_ASSOC);

$puanimm = $puan->prepare("select * from cc3_balance where (username_id = :username_id)");
$result = $puanimm->execute(array(":username_id" => $puanid['id']));
$puanim = $puanimm->fetch(PDO::FETCH_ASSOC);
echo '<div class="col-md-6 col-xs-6" style="padding-right:0px;">';
	echo '<p style="border-bottom:1px dotted #ddd;padding-left:15px;font-weight:700;">Puan</p>';
	echo '<p style="border-bottom:1px dotted #ddd;padding-left:15px;font-weight:700;">Sıralama</p>';

	echo '</div>';
	echo '<div class="col-md-6 col-xs-6" style="padding-left:0px;">';
	echo '<p style="border-bottom:1px dotted #ddd;padding-left:15px;">';
	if($puanim['balance'] != NULL){
		echo $puanim['balance'];
	}else{
		echo '0';
	}
	echo '</p>';
	echo '<p style="border-bottom:1px dotted #ddd;padding-left:15px;">';
		echo '10000+';
	echo '</p>';
	echo '</div>';			
    echo '</div>';
	
	#
	echo '<div class="post-preview medium movie-news" style="border:1px solid #ddd;border-radius:7px;padding-bottom:10px;">';
            echo '<div class="post-preview-img-wrap" style="max-height:225px;overflow:hidden;">';
              echo '<figure class="post-preview-img liquid">';
                echo '<img src="'.$domain.'images/faction.jpg" alt="Faction">';
              echo '</figure>';
				echo '<span class="tag-ornament" style="top: 10px;width: 100%;text-align: center;">Faction</span>';
				echo '<p class="post-preview-text"></p>';
			echo '</div>';
$factiondurumm = $faction->prepare("select * from BattleLevelsData where (uuid = '".$_SESSION['uuid']."')");
$result = $factiondurumm->execute();
$factiondurum = $factiondurumm->fetch(PDO::FETCH_ASSOC);

if($factiondurum != NULL){
	$score=$factiondurum["score"];
	$kills=$factiondurum["kills"];
	$killstreak=$factiondurum["killstreak"];
	$level=$factiondurum["level"];
	

$sqls = $faction->query("select * from BattleLevelsData order by level desc");
$i = 1;
foreach($sqls as $sql){
	if($sql['uuid'] == $_SESSION['uuid']){
		$siraaaaaaaaaaa = $i;
	}else{
		$i++;
	}
}

}else{
	$score='0';
	$kills='0';
	$killstreak='0';
	$level='0';
	$siraaaaaaaaaaa = '10000+';
}
echo '<div class="col-md-6 col-xs-6" style="padding-right:0px;">';
	echo '<p style="border-bottom:1px dotted #ddd;padding-left:15px;font-weight:700;">Sıra</p>';
	echo '<p style="border-bottom:1px dotted #ddd;padding-left:15px;font-weight:700;">Level</p>';
	echo '<p style="border-bottom:1px dotted #ddd;padding-left:15px;font-weight:700;">Skor</p>';
	echo '<p style="border-bottom:1px dotted #ddd;padding-left:15px;font-weight:700;">Öldürme</p>';
	echo '<p style="border-bottom:1px dotted #ddd;padding-left:15px;font-weight:700;">Seri kill</p>';
	echo '</div>';
	echo '<div class="col-md-6 col-xs-6" style="padding-left:0px;">';
	echo '<p style="border-bottom:1px dotted #ddd;padding-left:15px;">'.$siraaaaaaaaaaa.'</p>';
	echo '<p style="border-bottom:1px dotted #ddd;padding-left:15px;">'.$level.'</p>';
	echo '<p style="border-bottom:1px dotted #ddd;padding-left:15px;">'.$score.'</p>';
	echo '<p style="border-bottom:1px dotted #ddd;padding-left:15px;">'.$kills.'</p>';
	echo '<p style="border-bottom:1px dotted #ddd;padding-left:15px;">'.$killstreak.'</p>';
	echo '</div>';		
    echo '</div>';
	
	#skyblock
	echo '<div class="post-preview medium movie-news" style="border:1px solid #ddd;border-radius:7px;padding-bottom:10px;">';
            echo '<div class="post-preview-img-wrap" style="max-height:225px;overflow:hidden;">';
              echo '<figure class="post-preview-img liquid">';
                echo '<img src="'.$domain.'images/skyblock.jpg" alt="SkyBlock">';
              echo '</figure>';
				echo '<span class="tag-ornament" style="top: 10px;width: 100%;text-align: center;">SkyBlock</span>';
				echo '<p class="post-preview-text"></p>';
			echo '</div>';
$playerid = $istatistikler->prepare("select * from leaderheadsplayers where (uuid = '".$_SESSION['uuid']."')");
$result = $playerid->execute();
$playerid = $playerid->fetch(PDO::FETCH_ASSOC);

if($playerid['player_id'] != ''){
	$oyuncuid= $playerid["player_id"];
#ada seviyesi	
	$ada = $istatistikler->prepare("select * from skyblock_leaderheadsplayersdata_alltime where (player_id = '".$oyuncuid."') && (stat_type = 'asb-level')");
	$result = $ada->execute();
	$ada = $ada->fetch(PDO::FETCH_ASSOC);
	if($ada != NULL){
		$adaseviyesi = $ada['stat_value'];
	}else{
		$adaseviyesi = '0';
	}
#öldürme
	$oldurme = $istatistikler->prepare("select * from skyblock_leaderheadsplayersdata_alltime where (player_id = '".$oyuncuid."') && (stat_type = 'kills')");
	$result = $oldurme->execute();
	$oldurme = $oldurme->fetch(PDO::FETCH_ASSOC);
	if($oldurme != NULL){
		$oldurmesayisi = $oldurme['stat_value'];
	}else{
		$oldurmesayisi = '0';
	}
#mob öldürme
	$moboldurme = $istatistikler->prepare("select * from skyblock_leaderheadsplayersdata_alltime where (player_id = '".$oyuncuid."') && (stat_type = 'mobkills')");
	$result = $moboldurme->execute();
	$moboldurme = $moboldurme->fetch(PDO::FETCH_ASSOC);
	if($moboldurme != NULL){
		$moboldurmesayisi = $moboldurme['stat_value'];
	}else{
		$moboldurmesayisi = '0';
	}

$sqls = $istatistikler->query("select * from skyblock_leaderheadsplayersdata_alltime where (stat_type = 'asb-level') order by stat_value desc");
$i = 1;
foreach($sqls as $sql){
	if($sql['player_id'] == $oyuncuid){
		$sirra = $i;
	}else{
		$i++;
	}
}

}else{
	$adaseviyesi='0';
	$oldurmesayisi='0';
	$moboldurmesayisi='0';
	$sirra = '10000+';
}

if($sirra == ''){
	$sirra = '10000+';
}
echo '<div class="col-md-6 col-xs-6" style="padding-right:0px;">';
	echo '<p style="border-bottom:1px dotted #ddd;padding-left:15px;font-weight:700;">Sıra</p>';
	echo '<p style="border-bottom:1px dotted #ddd;padding-left:15px;font-weight:700;">Ada Seviyesi</p>';
	echo '<p style="border-bottom:1px dotted #ddd;padding-left:15px;font-weight:700;">Öldürme</p>';
	echo '<p style="border-bottom:1px dotted #ddd;padding-left:15px;font-weight:700;">Mob Öldürme</p>';

	echo '</div>';
	echo '<div class="col-md-6 col-xs-6" style="padding-left:0px;">';
	echo '<p style="border-bottom:1px dotted #ddd;padding-left:15px;">'.$sirra.'</p>';
	echo '<p style="border-bottom:1px dotted #ddd;padding-left:15px;">'.$adaseviyesi.'</p>';
	echo '<p style="border-bottom:1px dotted #ddd;padding-left:15px;">'.$oldurmesayisi.'</p>';
	echo '<p style="border-bottom:1px dotted #ddd;padding-left:15px;">'.$moboldurmesayisi.'</p>';
	echo '</div>';		
    echo '</div>';
	
	#skypvp
	echo '<div class="post-preview medium movie-news" style="border:1px solid #ddd;border-radius:7px;padding-bottom:10px;">';
            echo '<div class="post-preview-img-wrap" style="max-height:225px;overflow:hidden;">';
              echo '<figure class="post-preview-img liquid">';
                echo '<img src="'.$domain.'images/skypvp.jpg" alt="SkyPvP">';
              echo '</figure>';
				echo '<span class="tag-ornament" style="top: 10px;width: 100%;text-align: center;">SkyPvP</span>';
				echo '<p class="post-preview-text"></p>';
			echo '</div>';
$playerid = $istatistikler->prepare("select * from leaderheadsplayers where (uuid = '".$_SESSION['uuid']."')");
$result = $playerid->execute();
$playerid = $playerid->fetch(PDO::FETCH_ASSOC);

if($playerid['player_id'] != ''){
	$oyuncuid= $playerid["player_id"];
#bakiye seviyesi	
	$bakiye = $istatistikler->prepare("SELECT * FROM skypvp_leaderheadsplayersdata_alltime where stat_type='balance' && (player_id = '".$oyuncuid."')");
	$result = $bakiye->execute();
	$bakiye = $bakiye->fetch(PDO::FETCH_ASSOC);
	if($bakiye != NULL){
		$bakiyesi = $bakiye['stat_value'];
	}else{
		$bakiyesi = '0';
	}
#öldürme
	$oldurme = $istatistikler->prepare("SELECT * FROM skypvp_leaderheadsplayersdata_alltime where stat_type='kills' && (player_id = '".$oyuncuid."')");
	$result = $oldurme->execute();
	$oldurme = $oldurme->fetch(PDO::FETCH_ASSOC);
	if($oldurme != NULL){
		$oldurmesayisi = $oldurme['stat_value'];
	}else{
		$oldurmesayisi = '0';
	}


$sqls = $istatistikler->query("SELECT * FROM skypvp_leaderheadsplayersdata_alltime where stat_type='kills' order by stat_value desc");
$i = 1;
foreach($sqls as $sql){
	if($sql['player_id'] == $oyuncuid){
		$sirrra = $i;
	}else{
		$i++;
	}
}

}else{
	$bakiyesi='0';
	$oldurmesayisi='0';
	$sirrra = '10000+';
}
if($sirrra == ''){
	$sirrra = '10000+';
}

echo '<div class="col-md-6 col-xs-6" style="padding-right:0px;">';
	echo '<p style="border-bottom:1px dotted #ddd;padding-left:15px;font-weight:700;">Sıra</p>';
	echo '<p style="border-bottom:1px dotted #ddd;padding-left:15px;font-weight:700;">Öldürme</p>';
	echo '<p style="border-bottom:1px dotted #ddd;padding-left:15px;font-weight:700;">Bakiye</p>';

	echo '</div>';
	echo '<div class="col-md-6 col-xs-6" style="padding-left:0px;">';
	echo '<p style="border-bottom:1px dotted #ddd;padding-left:15px;">'.$sirrra.'</p>';
	echo '<p style="border-bottom:1px dotted #ddd;padding-left:15px;">'.$oldurmesayisi.'</p>';
	echo '<p style="border-bottom:1px dotted #ddd;padding-left:15px;">'.$bakiyesi.'</p>';
	echo '</div>';	
    echo '</div>';
	
	#bedwars
	echo '<div class="post-preview medium movie-news" style="border:1px solid #ddd;border-radius:7px;padding-bottom:10px;">';
            echo '<div class="post-preview-img-wrap" style="max-height:225px;overflow:hidden;">';
              echo '<figure class="post-preview-img liquid">';
                echo '<img src="'.$domain.'images/bedwars.jpg" alt="BedWars">';
              echo '</figure>';
				echo '<span class="tag-ornament" style="top: 10px;width: 100%;text-align: center;">BedWars</span>';
				echo '<p class="post-preview-text"></p>';
			echo '</div>';
$name = $_SESSION['username'];
$playerid = $oyunlar->prepare("SELECT * FROM global_stats where (name = '".$name."')");
$result = $playerid->execute();
$playerid = $playerid->fetch(PDO::FETCH_ASSOC);

if($playerid['Name'] != ''){
	$oyuncuid= $playerid["player_id"];

	$bedw = $oyunlar->prepare("SELECT * FROM global_stats where (name = '".$name."')");
	$result = $bedw->execute();
	$bedw = $bedw->fetch(PDO::FETCH_ASSOC);
	if($bedw != NULL){
		$kazanma = $bedw['wins'];
		$oldurme = $bedw['kills'];
		$oynananoyun = $bedw['games_played'];
		$kirilanyatak = $bedw['beds_destroyed'];
	}else{
		$kazanma = '0';
		$oldurme = '0';
		$oynananoyun = '0';
		$kirilanyatak = '0';
	}



$sqls = $oyunlar->query("SELECT * FROM global_stats order by wins desc");
$i = 1;
foreach($sqls as $sql){
	if($sql['Name'] == $name){
		$siraaaaaaaa = $i;
	}else{
		$i++;
	}
}

}else{
	$kazanma = '0';
	$oldurme = '0';
	$oynananoyun = '0';
	$kirilanyatak = '0';
	$siraaaaaaaa = '10000+';
}
echo '<div class="col-md-6 col-xs-6" style="padding-right:0px;">';
	echo '<p style="border-bottom:1px dotted #ddd;padding-left:15px;font-weight:700;">Sıra</p>';
	echo '<p style="border-bottom:1px dotted #ddd;padding-left:15px;font-weight:700;">Kazanma</p>';
	echo '<p style="border-bottom:1px dotted #ddd;padding-left:15px;font-weight:700;">Öldürme</p>';
	echo '<p style="border-bottom:1px dotted #ddd;padding-left:15px;font-weight:700;">Oynanan Oyun</p>';
	echo '<p style="border-bottom:1px dotted #ddd;padding-left:15px;font-weight:700;">Kırılan Yatak</p>';

	echo '</div>';
	echo '<div class="col-md-6 col-xs-6" style="padding-left:0px;">';
	echo '<p style="border-bottom:1px dotted #ddd;padding-left:15px;">'.$siraaaaaaaa.'</p>';
	echo '<p style="border-bottom:1px dotted #ddd;padding-left:15px;">'.$kazanma.'</p>';
	echo '<p style="border-bottom:1px dotted #ddd;padding-left:15px;">'.$oldurme.'</p>';
	echo '<p style="border-bottom:1px dotted #ddd;padding-left:15px;">'.$oynananoyun.'</p>';
	echo '<p style="border-bottom:1px dotted #ddd;padding-left:15px;">'.$kirilanyatak.'</p>';
	echo '</div>';		
    echo '</div>';
	
	#skywars
	echo '<div class="post-preview medium movie-news" style="border:1px solid #ddd;border-radius:7px;padding-bottom:10px;">';
            echo '<div class="post-preview-img-wrap" style="max-height:225px;overflow:hidden;">';
              echo '<figure class="post-preview-img liquid">';
                echo '<img src="'.$domain.'images/skywars.jpg" alt="SkyWars">';
              echo '</figure>';
				echo '<span class="tag-ornament" style="top: 10px;width: 100%;text-align: center;">SkyWars</span>';
				echo '<p class="post-preview-text"></p>';
			echo '</div>';
$name = $_SESSION['username'];
$playerid = $oyunlar->prepare("SELECT * FROM SkyWars_Data  where (username = '".$name."')");
$result = $playerid->execute();
$playerid = $playerid->fetch(PDO::FETCH_ASSOC);

if($playerid['username'] != ''){
	$oyuncuid= $playerid["username"];

	$bedw = $oyunlar->prepare("SELECT * FROM SkyWars_Data  where (username = '".$name."')");
	$result = $bedw->execute();
	$bedw = $bedw->fetch(PDO::FETCH_ASSOC);
	if($bedw != NULL){
		$kazanma = $bedw['wins'];
		$oldurme = $bedw['kills'];
		$oynananoyun = $bedw['played'];
		$olme = $bedw['deaths'];

	}else{
		$kazanma = '0';
		$oldurme = '0';
		$oynananoyun = '0';
		$olme = '0';
	}



$sqls = $oyunlar->query("SELECT * FROM SkyWars_Data order by wins desc");
$i = 1;
foreach($sqls as $sql){
	if($sql['username'] == $name){
		$sir = $i;
	}else{
		$i++;
	}
}

}else{
	$kazanma = '0';
	$oldurme = '0';
	$oynananoyun = '0';
	$olme = '0';
	$sir = '10000+';
}

if($sir == ''){
	$sir = '10000+';
}
echo '<div class="col-md-6 col-xs-6" style="padding-right:0px;">';
	echo '<p style="border-bottom:1px dotted #ddd;padding-left:15px;font-weight:700;">Sıra</p>';
	echo '<p style="border-bottom:1px dotted #ddd;padding-left:15px;font-weight:700;">Kazanma</p>';
	echo '<p style="border-bottom:1px dotted #ddd;padding-left:15px;font-weight:700;">Öldürme</p>';
	echo '<p style="border-bottom:1px dotted #ddd;padding-left:15px;font-weight:700;">Ölme</p>';
	echo '<p style="border-bottom:1px dotted #ddd;padding-left:15px;font-weight:700;">Oynanan Oyun</p>';

	echo '</div>';
	echo '<div class="col-md-6 col-xs-6" style="padding-left:0px;">';
	echo '<p style="border-bottom:1px dotted #ddd;padding-left:15px;">'.$sir.'</p>';
	echo '<p style="border-bottom:1px dotted #ddd;padding-left:15px;">'.$kazanma.'</p>';
	echo '<p style="border-bottom:1px dotted #ddd;padding-left:15px;">'.$oldurme.'</p>';
	echo '<p style="border-bottom:1px dotted #ddd;padding-left:15px;">'.$olme.'</p>';
	echo '<p style="border-bottom:1px dotted #ddd;padding-left:15px;">'.$oynananoyun.'</p>';
	echo '</div>';		
    echo '</div>';
	
	#katilkim
	echo '<div class="post-preview medium movie-news" style="border:1px solid #ddd;border-radius:7px;padding-bottom:10px;">';
            echo '<div class="post-preview-img-wrap" style="max-height:225px;overflow:hidden;">';
              echo '<figure class="post-preview-img liquid">';
                echo '<img src="'.$domain.'images/katilkim.jpg" alt="Katil Kim">';
              echo '</figure>';
				echo '<span class="tag-ornament" style="top: 10px;width: 100%;text-align: center;">Katil Kim</span>';
				echo '<p class="post-preview-text"></p>';
			echo '</div>';
$name = $_SESSION['username'];
$playerid = $oyunlar->prepare("SELECT * FROM MurderData  where (playername = '".$name."')");
$result = $playerid->execute();
$playerid = $playerid->fetch(PDO::FETCH_ASSOC);

if($playerid['playername'] != ''){
	$oyuncuid= $playerid["playername"];

	$bedw = $oyunlar->prepare("SELECT * FROM MurderData  where (playername = '".$name."')");
	$result = $bedw->execute();
	$bedw = $bedw->fetch(PDO::FETCH_ASSOC);
	if($bedw != NULL){
		$kazanma = $bedw['wins'];
		$oldurme = $bedw['kills'];
		$skor = $bedw['score'];
		$olme = $bedw['deaths'];

	}else{
		$kazanma = '0';
		$oldurme = '0';
		$skor = '0';
		$olme = '0';
	}



$sqls = $oyunlar->query("SELECT * FROM MurderData order by wins desc");
$i = 1;
foreach($sqls as $sql){
	if($sql['playername'] == $name){
		$siraaaaaa = $i;
	}else{
		$i++;
	}
}

}else{
	$kazanma = '0';
	$oldurme = '0';
	$skor = '0';
	$olme = '0';
	$siraaaaaa = '10000+';
}

echo '<div class="col-md-6 col-xs-6" style="padding-right:0px;">';
	echo '<p style="border-bottom:1px dotted #ddd;padding-left:15px;font-weight:700;">Sıra</p>';
	echo '<p style="border-bottom:1px dotted #ddd;padding-left:15px;font-weight:700;">Kazanma</p>';
	echo '<p style="border-bottom:1px dotted #ddd;padding-left:15px;font-weight:700;">Öldürme</p>';
	echo '<p style="border-bottom:1px dotted #ddd;padding-left:15px;font-weight:700;">Ölme</p>';
	echo '<p style="border-bottom:1px dotted #ddd;padding-left:15px;font-weight:700;">Skor</p>';

	echo '</div>';
	echo '<div class="col-md-6 col-xs-6" style="padding-left:0px;">';
	echo '<p style="border-bottom:1px dotted #ddd;padding-left:15px;">'.$siraaaaaa.'</p>';
	echo '<p style="border-bottom:1px dotted #ddd;padding-left:15px;">'.$kazanma.'</p>';
	echo '<p style="border-bottom:1px dotted #ddd;padding-left:15px;">'.$oldurme.'</p>';
	echo '<p style="border-bottom:1px dotted #ddd;padding-left:15px;">'.$olme.'</p>';
	echo '<p style="border-bottom:1px dotted #ddd;padding-left:15px;">'.$skor.'</p>';
	echo '</div>';		
    echo '</div>';
	
	#buildbattle
	echo '<div class="post-preview medium movie-news" style="border:1px solid #ddd;border-radius:7px;padding-bottom:10px;">';
            echo '<div class="post-preview-img-wrap" style="max-height:225px;overflow:hidden;">';
              echo '<figure class="post-preview-img liquid">';
                echo '<img src="'.$domain.'images/buildbattle.jpg" alt="BuildBattle">';
              echo '</figure>';
				echo '<span class="tag-ornament" style="top: 10px;width: 100%;text-align: center;">BuildBattle</span>';
				echo '<p class="post-preview-text"></p>';
			echo '</div>';
$oyuncuid= $_SESSION["uuid"];

	$bedw = $oyunlar->prepare("SELECT * FROM masterbuilders  where (UUID = '".$oyuncuid."')");
	$result = $bedw->execute();
	$bedw = $bedw->fetch(PDO::FETCH_ASSOC);
	if($bedw != NULL){
		$kazanma = $bedw['Wins'];
		$oynananoyun = $bedw['PlayedGames'];

	}else{
		$kazanma = '0';
		$oynananoyun = '0';
	}



$sqls = $oyunlar->query("SELECT * FROM masterbuilders order by Wins desc");
$i = 1;

foreach($sqls as $sql){
	if($sql['UUID'] == $oyuncuid){
		$siraaaa = $i;
	}else{
		$i++;
	}
}

if($siraaaa == ''){
	$siraaaa = '10000+';
}

echo '<div class="col-md-6 col-xs-6" style="padding-right:0px;">';
	echo '<p style="border-bottom:1px dotted #ddd;padding-left:15px;font-weight:700;">Sıra</p>';
	echo '<p style="border-bottom:1px dotted #ddd;padding-left:15px;font-weight:700;">Kazanma</p>';
	echo '<p style="border-bottom:1px dotted #ddd;padding-left:15px;font-weight:700;">Oynanan Oyun</p>';

	echo '</div>';
	echo '<div class="col-md-6 col-xs-6" style="padding-left:0px;">';
	echo '<p style="border-bottom:1px dotted #ddd;padding-left:15px;">'.$siraaaa.'</p>';
	echo '<p style="border-bottom:1px dotted #ddd;padding-left:15px;">'.$kazanma.'</p>';
	echo '<p style="border-bottom:1px dotted #ddd;padding-left:15px;">'.$oynananoyun.'</p>';
	echo '</div>';		
    echo '</div>';
	
	#speedbuilders
	echo '<div class="post-preview medium movie-news" style="border:1px solid #ddd;border-radius:7px;padding-bottom:10px;">';
            echo '<div class="post-preview-img-wrap" style="max-height:225px;overflow:hidden;">';
              echo '<figure class="post-preview-img liquid">';
                echo '<img src="'.$domain.'images/speedbuilders.jpg" alt="SpeedBuilders">';
              echo '</figure>';
				echo '<span class="tag-ornament" style="top: 10px;width: 100%;text-align: center;">SpeedBuilders</span>';
				echo '<p class="post-preview-text"></p>';
			echo '</div>';
$oyuncuid= $_SESSION["uuid"];

	$bedw = $oyunlar->prepare("SELECT * FROM speedbuilders  where (uuid = '".$oyuncuid."')");
	$result = $bedw->execute();
	$bedw = $bedw->fetch(PDO::FETCH_ASSOC);
	if($bedw != NULL){
		$kazanma = $bedw['wins'];
		$mukemmeluyum = $bedw['pbuilds'];

	}else{
		$kazanma = '0';
		$mukemmeluyum = '0';
	}



$sqls = $oyunlar->query("SELECT * FROM speedbuilders order by wins desc");
$i = 1;

foreach($sqls as $sql){
	if($sql['uuid'] == $oyuncuid){
		$siraaa = $i;
	}else{
		$i++;
	}
}
if($siraaa == ''){
	$siraaa = '10000+';
}
echo '<div class="col-md-6 col-xs-6" style="padding-right:0px;">';
	echo '<p style="border-bottom:1px dotted #ddd;padding-left:15px;font-weight:700;">Sıra</p>';
	echo '<p style="border-bottom:1px dotted #ddd;padding-left:15px;font-weight:700;">Kazanma</p>';
	echo '<p style="border-bottom:1px dotted #ddd;padding-left:15px;font-weight:700;">Mükemmel Uyum</p>';

	echo '</div>';
	echo '<div class="col-md-6 col-xs-6" style="padding-left:0px;">';
	echo '<p style="border-bottom:1px dotted #ddd;padding-left:15px;">'.$siraaa.'</p>';
	echo '<p style="border-bottom:1px dotted #ddd;padding-left:15px;">'.$kazanma.'</p>';
	echo '<p style="border-bottom:1px dotted #ddd;padding-left:15px;">'.$mukemmeluyum.'</p>';
	echo '</div>';		
    echo '</div>';
	
	#hungergames
	echo '<div class="post-preview medium movie-news" style="border:1px solid #ddd;border-radius:7px;padding-bottom:10px;">';
            echo '<div class="post-preview-img-wrap" style="max-height:225px;overflow:hidden;">';
              echo '<figure class="post-preview-img liquid">';
                echo '<img src="'.$domain.'images/hungergames.jpg" alt="HungerGames">';
              echo '</figure>';
				echo '<span class="tag-ornament" style="top: 10px;width: 100%;text-align: center;">HungerGames</span>';
				echo '<p class="post-preview-text"></p>';
			echo '</div>';
$oyuncuid= $_SESSION["uuid"];

	$bedw = $oyunlar->prepare("SELECT * FROM sg_  where (player_uuid = '".$oyuncuid."')");
	$result = $bedw->execute();
	$bedw = $bedw->fetch(PDO::FETCH_ASSOC);
	if($bedw != NULL){
		$kazanma = $bedw['Wins'];
		$oldurme = $bedw['Kills'];
		$olme = $bedw['Deaths'];
		$oynananoyun = $bedw['Gamesplayed'];

	}else{
		$kazanma = '0';
		$oldurme = '0';
		$olme = '0';
		$oynananoyun = '0';
	}



$sqls = $oyunlar->query("SELECT * FROM sg_ order by Wins desc");
$i = 1;

foreach($sqls as $sql){
	if($sql['player_uuid'] == $oyuncuid){
		$siraa = $i;
	}else{
		$i++;
	}
}
if($siraa == ''){
	$siraa = '10000+';
}
echo '<div class="col-md-6 col-xs-6" style="padding-right:0px;">';
	echo '<p style="border-bottom:1px dotted #ddd;padding-left:15px;font-weight:700;">Sıra</p>';
	echo '<p style="border-bottom:1px dotted #ddd;padding-left:15px;font-weight:700;">Kazanma</p>';
	echo '<p style="border-bottom:1px dotted #ddd;padding-left:15px;font-weight:700;">Öldürme</p>';
	echo '<p style="border-bottom:1px dotted #ddd;padding-left:15px;font-weight:700;">Ölme</p>';
	echo '<p style="border-bottom:1px dotted #ddd;padding-left:15px;font-weight:700;">Oynanan Oyun</p>';

	echo '</div>';
	echo '<div class="col-md-6 col-xs-6" style="padding-left:0px;">';
	echo '<p style="border-bottom:1px dotted #ddd;padding-left:15px;">'.$siraa.'</p>';
	echo '<p style="border-bottom:1px dotted #ddd;padding-left:15px;">'.$kazanma.'</p>';
	echo '<p style="border-bottom:1px dotted #ddd;padding-left:15px;">'.$oldurme.'</p>';
	echo '<p style="border-bottom:1px dotted #ddd;padding-left:15px;">'.$olme.'</p>';
	echo '<p style="border-bottom:1px dotted #ddd;padding-left:15px;">'.$oynananoyun.'</p>';
	echo '</div>';			
    echo '</div>';
#Koyun Hırsızı
	echo '<div class="post-preview medium movie-news" style="border:1px solid #ddd;border-radius:7px;padding-bottom:10px;">';
            echo '<div class="post-preview-img-wrap" style="max-height:225px;overflow:hidden;">';
              echo '<figure class="post-preview-img liquid">';
                echo '<img src="https://i.hizliresim.com/WGIab6.png" alt="KoyunHirsizi">';
              echo '</figure>';
				echo '<span class="tag-ornament" style="top: 10px;width: 100%;text-align: center;">Koyun Hırsızı</span>';
				echo '<p class="post-preview-text"></p>';
			echo '</div>';
$oyuncuad= $_SESSION["username"];

	$bedw = $oyunlar->prepare("SELECT * FROM sheepquest where (username = '".$oyuncuad."')");
	$result = $bedw->execute();
	$bedw = $bedw->fetch(PDO::FETCH_ASSOC);
	if($bedw != NULL){
		$kazanma = $bedw['wins'];
		$oldurme = $bedw['kills'];
		$olme = $bedw['deaths'];
		$calinankoyun = $bedw['sgrecord'];

	}else{
		$kazanma = '0';
		$oldurme = '0';
		$olme = '0';
		$calinankoyun = '0';
	}



$sqls = $oyunlar->query("SELECT * FROM sheepquest order by wins desc");
$i = 1;

foreach($sqls as $sql){
	if($sql['username'] == $oyuncuad){
		$siraas = $i;
	}else{
		$i++;
	}
}
if($siraas == ''){
	$siraas = '10000+';
}
echo '<div class="col-md-6 col-xs-6" style="padding-right:0px;">';
	echo '<p style="border-bottom:1px dotted #ddd;padding-left:15px;font-weight:700;">Sıra</p>';
	echo '<p style="border-bottom:1px dotted #ddd;padding-left:15px;font-weight:700;">Kazanma</p>';
	echo '<p style="border-bottom:1px dotted #ddd;padding-left:15px;font-weight:700;">Öldürme</p>';
	echo '<p style="border-bottom:1px dotted #ddd;padding-left:15px;font-weight:700;">Ölme</p>';
	echo '<p style="border-bottom:1px dotted #ddd;padding-left:15px;font-weight:700;">En Fazla Koyun Çalma</p>';

	echo '</div>';
	echo '<div class="col-md-6 col-xs-6" style="padding-left:0px;">';
	echo '<p style="border-bottom:1px dotted #ddd;padding-left:15px;">'.$siraas.'</p>';
	echo '<p style="border-bottom:1px dotted #ddd;padding-left:15px;">'.$kazanma.'</p>';
	echo '<p style="border-bottom:1px dotted #ddd;padding-left:15px;">'.$oldurme.'</p>';
	echo '<p style="border-bottom:1px dotted #ddd;padding-left:15px;">'.$olme.'</p>';
	echo '<p style="border-bottom:1px dotted #ddd;padding-left:15px;">'.$calinankoyun.'</p>';
	echo '</div>';			
    echo '</div>';


	#eggwars
	echo '<div class="post-preview medium movie-news" style="border:1px solid #ddd;border-radius:7px;padding-bottom:10px;">';
            echo '<div class="post-preview-img-wrap" style="max-height:225px;overflow:hidden;">';
              echo '<figure class="post-preview-img liquid">';
                echo '<img src="'.$domain.'images/eggwars.jpg" alt="EggWars">';
              echo '</figure>';
				echo '<span class="tag-ornament" style="top: 10px;width: 100%;text-align: center;">EggWars</span>';
				echo '<p class="post-preview-text"></p>';
			echo '</div>';
$oyuncuid= $_SESSION["uuid"];

	$bedw = $oyunlar->prepare("SELECT * FROM eggwars_players  where (player_uuid = '".$oyuncuid."')");
	$result = $bedw->execute();
	$bedw = $bedw->fetch(PDO::FETCH_ASSOC);
	if($bedw != NULL){

		$score=$bedw["wins"];
		$kills=$bedw["kills"];
		$oynanan=$bedw["played"];
		$yumurta=$bedw["eggs"];

	}else{

		$score='0'; 
		$kills='0'; 
		$oynanan='0'; 
		$yumurta='0'; 
	}



$sqls = $oyunlar->query("SELECT * FROM eggwars_players order by kills desc");
$i = 1;

foreach($sqls as $sql){
	if($sql['player_uuid'] == $oyuncuid){
		$sira = $i;
	}else{
		$i++;
	}
}
if($sira == ''){
	$sira = '10000+';
}
echo '<div class="col-md-6 col-xs-6" style="padding-right:0px;">';
	echo '<p style="border-bottom:1px dotted #ddd;padding-left:15px;font-weight:700;">Sıra</p>';
	echo '<p style="border-bottom:1px dotted #ddd;padding-left:15px;font-weight:700;">Kazanma</p>';
	echo '<p style="border-bottom:1px dotted #ddd;padding-left:15px;font-weight:700;">Öldürme</p>';
	echo '<p style="border-bottom:1px dotted #ddd;padding-left:15px;font-weight:700;">Oynanan</p>';
	echo '<p style="border-bottom:1px dotted #ddd;padding-left:15px;font-weight:700;">Kırılan Yumurta</p>';

	echo '</div>';
	echo '<div class="col-md-6 col-xs-6" style="padding-left:0px;">';
	echo '<p style="border-bottom:1px dotted #ddd;padding-left:15px;">'.$sira.'</p>';
	echo '<p style="border-bottom:1px dotted #ddd;padding-left:15px;">'.$score.'</p>';
	echo '<p style="border-bottom:1px dotted #ddd;padding-left:15px;">'.$kills.'</p>';
	echo '<p style="border-bottom:1px dotted #ddd;padding-left:15px;">'.$oynanan.'</p>';
	echo '<p style="border-bottom:1px dotted #ddd;padding-left:15px;">'.$yumurta.'</p>';
	echo '</div>';			
    echo '</div>';
	
	#
	echo '<div class="post-preview medium movie-news" style="border:1px solid #ddd;border-radius:7px;padding-bottom:10px;">';
            echo '<div class="post-preview-img-wrap" style="max-height:225px;overflow:hidden;">';
              echo '<figure class="post-preview-img liquid">';
                echo '<img src="'.$domain.'images/cehennemvadisi.jpg" alt="Cehennem Vadisi">';
              echo '</figure>';
				echo '<span class="tag-ornament" style="top: 10px;width: 100%;text-align: center;">Cehennem Vadisi</span>';
				echo '<p class="post-preview-text"></p>';
			echo '</div>';
$oyuncuid= $_SESSION["uuid"];

	$bedw = $oyunlar->prepare("SELECT * FROM ZombieSurvivalData where (player_uuid = '".$oyuncuid."')");
	$result = $bedw->execute();
	$bedw = $bedw->fetch(PDO::FETCH_ASSOC);
	if($bedw != NULL){

		$score=$bedw["HighestRound"];
		$kills=$bedw["Kills"];
		$oynanan=$bedw["Revives"];
		$yumurta=$bedw["GamesPlayed"];

	}else{

		$score='0'; 
		$kills='0'; 
		$oynanan='0'; 
		$yumurta='0'; 
	}



$sqls = $oyunlar->query("SELECT * FROM ZombieSurvivalData order by HighestRound desc");
$i = 1;

foreach($sqls as $sql){
	if($sql['player_uuid'] == $oyuncuid){
		$sira = $i;
	}else{
		$i++;
	}
}
if($sira == ''){
	$sira = '10000+';
}
echo '<div class="col-md-6 col-xs-6" style="padding-right:0px;">';
	echo '<p style="border-bottom:1px dotted #ddd;padding-left:15px;font-weight:700;">Sıra</p>';
	echo '<p style="border-bottom:1px dotted #ddd;padding-left:15px;font-weight:700;">Round Skoru</p>';
	echo '<p style="border-bottom:1px dotted #ddd;padding-left:15px;font-weight:700;">Zombi Öldürme</p>';
	echo '<p style="border-bottom:1px dotted #ddd;padding-left:15px;font-weight:700;">Canlandırma</p>';
	echo '<p style="border-bottom:1px dotted #ddd;padding-left:15px;font-weight:700;">Oynanan Oyun</p>';

	echo '</div>';
	echo '<div class="col-md-6 col-xs-6" style="padding-left:0px;">';
	echo '<p style="border-bottom:1px dotted #ddd;padding-left:15px;">'.$sira.'</p>';
	echo '<p style="border-bottom:1px dotted #ddd;padding-left:15px;">'.$score.'</p>';
	echo '<p style="border-bottom:1px dotted #ddd;padding-left:15px;">'.$kills.'</p>';
	echo '<p style="border-bottom:1px dotted #ddd;padding-left:15px;">'.$oynanan.'</p>';
	echo '<p style="border-bottom:1px dotted #ddd;padding-left:15px;">'.$yumurta.'</p>';
	echo '</div>';	
    echo '</div>';





?>






</div>


    </div>

  </div>

<?php include_once('footer.php'); ?>