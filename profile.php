<?php include_once('header.php'); ?>
<style>
.banner-wrap.forum-banner {
    background: url("<?php echo $domain; ?>images/home-slide/galeri_9854494.jpg") no-repeat center,linear-gradient(45deg, #f30a5c, #1c95f3);
    background-size: auto, auto;
    background-size: cover;
}
.forum-category-wrap {
    width: auto;
	padding: 40px 0 40px 10px;
}
.link-list {
    width: auto;
}
.table.forum-topics .table-row-item:first-child {
    padding-left: 0px;
}

@media screen and (max-width:700px){
	body{
		overflow-x:auto;
	}
}
</style>
<?php
$oyuncu = $kpanel->prepare("select * from Kullanicilar where (username = :username)");
$result = $oyuncu->execute(array(":username" => $_REQUEST["p"]));
$oyuncu  = $oyuncu->fetch(PDO::FETCH_ASSOC);

$timebilgi = strtotime($oyuncu['kayittarihi']);
$songorulme = $bungeecord->prepare("select * from fr_players where (player_uuid = '".$oyuncu['uuid']."')");
$result = $songorulme->execute();
$songorulme   = $songorulme->fetch(PDO::FETCH_ASSOC);
$song = strtotime($songorulme['last_online']);

$ben = $bungeecord->prepare("select * from fr_players where (player_uuid = :player_uuid)");
$result = $ben->execute(array(":player_uuid" => $oyuncu['uuid']));
$ben  = $ben->fetch(PDO::FETCH_ASSOC);

$arkadaslarimsayi = $bungeecord->query("select count(*) from fr_friend_assignment where (friend1_id = '".$ben['player_id']."') ");
$result = $arkadaslarimsayi->execute();
$arkadaslarimsayi   = $arkadaslarimsayi->fetchColumn();


$arkadaslarim2sayi = $bungeecord->query("select count(*) from fr_friend_assignment where (friend2_id = '".$ben['player_id']."')");
$result = $arkadaslarim2sayi->execute();
$arkadaslarim2sayi   = $arkadaslarim2sayi->fetchColumn();

$sayi = $arkadaslarimsayi + $arkadaslarim2sayi;

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
?>
  <!-- BANNER WRAP -->
  <div class="banner-wrap forum-banner">
    <!-- BANNER -->
    <div class="banner grid-limit">
      <h2 class="banner-title" style="text-transform:none;"><?php echo $oyuncu['username']; ?></h2>
      <p class="banner-sections">
        <span class="banner-section">Anasayfa</span>
        <!-- ARROW ICON -->
        <svg class="arrow-icon">
          <use xlink:href="#svg-arrow"></use>
        </svg>
        <!-- /ARROW ICON -->
        <span class="banner-section">Kullanıcı İstatistik</span>
      </p>
    </div>
    <!-- /BANNER -->
  </div>
  <!-- /BANNER WRAP -->
<?php include_once('slidenews.php'); ?>
<?php
$puanidd = $puan->prepare("select * from cc3_account where (name = '".$oyuncu['username']."')");
$result = $puanidd->execute();
$puanid = $puanidd->fetch(PDO::FETCH_ASSOC);

$puanimm = $puan->prepare("select * from cc3_balance where (username_id = :username_id)");
$result = $puanimm->execute(array(":username_id" => $puanid['id']));
$puanim = $puanimm->fetch(PDO::FETCH_ASSOC);

$sqls = $puan->query("select * from cc3_balance order by balance desc");
$i = 1;
foreach($sqls as $sql){
	if($sql['username_id'] == $puanid['id']){
		$sira = $i;
	}else{
		$i++;
	}
}
if($sira == NULL){$sira='10000+';$puanim['balance'] = '0';}

?>

  <div class="layout-content-4 layout-item-1-3 grid-limit">
    <div class="layout-sidebar">
      <div class="account-info-wrap">
        <img class="user-avatar big" src="https://cravatar.eu/avatar/<?php echo $oyuncu['username']; ?>" alt="<?php echo $oyuncu['username']; ?>">
        <p class="account-info-username" style="text-transform:none;"><?php echo $oyuncu['username']; ?></p>
        <p class="account-info-name"><span class="tag-ornament" style="vertical-align:middle;margin-top: 0px;margin-left: 5px;background:<?php echo $renk; ?>;"><?php echo $grupadi['name']; ?></span></p>
        <div class="account-info-stats">

          <div class="account-info-stat">
            <p class="account-info-stat-value"><?php echo $sira; ?></p>
            <p class="account-info-stat-title">OYUNCU SIRASI</p>
          </div>
          <div class="account-info-stat">
            <p class="account-info-stat-value"><?php echo $puanim['balance']; ?></p>
            <p class="account-info-stat-title">OYUNCU PUANI</p>
          </div>
          <div class="account-info-stat">
            <p class="account-info-stat-value"><?php echo $sayi; ?></p>
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

        <div class="side-block">
<div class="section-title-wrap blue" style="margin-bottom:15px;">
<h2 class="section-title medium" style="text-transform:none;">Arkadaşları</h2>
<div class="section-title-separator"></div>
</div>
                    <div class="block-content pt-5">
                        <div class="row">
<?php
$ben = $bungeecord->prepare("select * from fr_players where (player_uuid = :player_uuid)");
$result = $ben->execute(array(":player_uuid" => $oyuncu['uuid']));
$ben  = $ben->fetch(PDO::FETCH_ASSOC);

$arkadaslarim = $bungeecord->query("select * from fr_friend_assignment where (friend1_id = '".$ben['player_id']."') ");
$arkadaslarim2 = $bungeecord->query("select * from fr_friend_assignment where (friend2_id = '".$ben['player_id']."')");
if($ben['player_name'] != NULL){
	foreach($arkadaslarim as $ark){
		$benn = $bungeecord->prepare("select * from fr_players where (player_id = :player_id)");
		$result = $benn->execute(array(":player_id" => $ark["friend2_id"]));
		$benn  = $benn->fetch(PDO::FETCH_ASSOC);
		
		$gercekkisi = $kpanel->prepare("select * from Kullanicilar where (uuid = :uuid)");
		$result = $gercekkisi->execute(array(":uuid" => $benn["player_uuid"]));
		$gercekkisi  = $gercekkisi->fetch(PDO::FETCH_ASSOC);
		echo '<div class="col-md-6 col-xs-6" style="margin-bottom: 10px;">';
			echo '<div class="angled-img">';
				echo '<div class="img"><a href="'.$domain2.'profil/'.$benn['player_name'].'">';
				if($gercekkisi['username'] != NULL){
					echo '<img class="user-avatar big" src="https://cravatar.eu/avatar/'.$gercekkisi['username'].'" class="img-responsive" alt="NAVI">';
				}else{
					echo '<img class="user-avatar big" src="https://cravatar.eu/avatar/'.$benn['player_name'].'" class="img-responsive" alt="NAVI">';
				}
					
				echo '</a></div>';
				echo '<div class="text" style="font-size:11px;margin-top:5px;text-align:center;">';
					echo '<a href="'.$domain2.'profil/'.$benn['player_name'].'">'.$benn['player_name'].'</a>';
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
		echo '<div class="col-md-6 col-xs-6" style="margin-bottom: 10px;">';
			echo '<div class="angled-img">';
				echo '<div class="img"><a href="'.$domain2.'profil/'.$benn['player_name'].'">';
				if($gercekkisi['username'] != NULL){
					echo '<img class="user-avatar big" src="https://cravatar.eu/avatar/'.$gercekkisi['username'].'" class="img-responsive" alt="NAVI">';
				}else{
					echo '<img class="user-avatar big" src="https://cravatar.eu/avatar/'.$benn['player_name'].'" class="img-responsive" alt="NAVI">';
				}
					
				echo '</a></div>';
				echo '<div class="text" style="font-size:11px;margin-top:5px;text-align:center;">';
					echo '<a href="'.$domain2.'profil/'.$benn['player_name'].'">'.$benn['player_name'].'</a>';
				echo '</div>';
			echo '</div>';
		echo '</div>';
	}
	
}else{
	echo '<p class="text-center" style="width:100%;">Arkadaş listesi boş</p>';
}
?>						
						
                            
                            

                        </div>
                    </div>
                </div>
      </div>
    </div>

    <div class="layout-body">
      <!-- SECTION TITLE WRAP -->
      <div class="section-title-wrap blue">
        <h2 class="section-title medium" style="text-transform:none;"><?php echo $oyuncu['username']; ?></h2>
        <div class="section-title-separator"></div>
      </div>
      <!-- /SECTION TITLE WRAP -->
<div class="filters-row">
<div class="option-list">
<a href="<?php echo $domain2.'profil/'.$oyuncu['username']; ?>"><p class="option-list-item selected">Genel</p></a>
<a href="<?php echo $domain2.'kullanici_istatistik/'.$oyuncu['username']; ?>"><p class="option-list-item">İstatistikler</p></a>
</div>
</div>	  
	  

<div class="layout-content-full grid-limit" style="margin-top:0px;padding-top:0px;">
<?php
$bilgi = $kpanel->prepare("select * from Kullanicilar where (uuid = '".$oyuncu['uuid']."')");
$result = $bilgi->execute();
$bilgi  = $bilgi->fetch(PDO::FETCH_ASSOC);
?>
<div class="table forum-topics">
	  
	  <div class="table-rows">
		<div class="table-row large">
		<div class="table-row-item" style="width:52px;display:table-cell;">
		<p class="table-text bold" style="text-align: left;padding-left: 10px;">Skype Adresi</p>
		</div>
		<div class="table-row-item" style="width:52px;display:table-cell;">
		<p class="table-text bold" style="text-align: left;padding-left: 10px;text-transform:none;"><?php echo $bilgi['skype']; ?></p>
		</div>
	    </div>
		
		<div class="table-row large">
		<div class="table-row-item" style="width:52px;display:table-cell;">
		<p class="table-text bold" style="text-align: left;padding-left: 10px;">Discord Adresi</p>
		</div>
		<div class="table-row-item" style="width:52px;display:table-cell;">
		<p class="table-text bold" style="text-align: left;padding-left: 10px;text-transform:none;"><?php echo $bilgi['discord']; ?></p>
		</div>
	    </div>
		
		<div class="table-row large">
		<div class="table-row-item" style="width:52px;display:table-cell;">
		<p class="table-text bold" style="text-align: left;padding-left: 10px;">Steam Adresi</p>
		</div>
		<div class="table-row-item" style="width:52px;display:table-cell;">
		<p class="table-text bold" style="text-align: left;padding-left: 10px;text-transform:none;"><?php echo $bilgi['steam']; ?></p>
		</div>
	    </div>
		
		<div class="table-row large">
		<div class="table-row-item" style="width:52px;display:table-cell;">
		<p class="table-text bold" style="text-align: left;padding-left: 10px;">Youtube Kanalı</p>
		</div>
		<div class="table-row-item" style="width:52px;display:table-cell;">
		<p class="table-text bold" style="text-align: left;padding-left: 10px;text-transform:none;"><?php echo $bilgi['youtube']; ?></p>
		</div>
	    </div>
		
		<div class="table-row large">
		<div class="table-row-item" style="width:52px;display:table-cell;">
		<p class="table-text bold" style="text-align: left;padding-left: 10px;">Bulunduğu İl</p>
		</div>
		<div class="table-row-item" style="width:52px;display:table-cell;">
		<p class="table-text bold" style="text-align: left;padding-left: 10px;text-transform:none;"><?php echo $bilgi['il']; ?></p>
		</div>
	    </div>
		
		<div class="table-row large">
		<div class="table-row-item" style="width:52px;display:table-cell;">
		<p class="table-text bold" style="text-align: left;padding-left: 10px;">Favori Oyunları</p>
		</div>
		<div class="table-row-item" style="width:52px;display:table-cell;">
		<p class="table-text bold" style="text-align: left;padding-left: 10px;text-transform:none;">
<?php
$favoriler = $db->query("select * from favorioyunlar where (username = '".$_REQUEST['p']."')");
foreach($favoriler as $favori){
	$oyun = $db->prepare("select * from oyunlar where (id = '".$favori['oyunid']."') ");
	$result = $oyun->execute();
	$oyun   = $oyun->fetch(PDO::FETCH_ASSOC);
	
	echo '<a href="'.$domain2.'oyundetay/'.$oyun['url'].'" target="_blank" >'.$favori['oyun'].'</a> ';
}
?>
	
		
		
		</p>
		</div>
	    </div>
		
		<div class="table-row large">
		<div class="table-row-item" style="width:52px;display:table-cell;">
		<p class="table-text bold" style="text-align: left;padding-left: 10px;">Hakkında</p>
		</div>
		<div class="table-row-item" style="width:52px;display:table-cell;">
		<p class="table-text bold" style="text-align: left;padding-left: 10px;text-transform:none;"><?php echo strip_tags($bilgi['hakkimda']); ?></p>
		</div>
	    </div>
		
	  </div>
	  
</div>
</div>



</div>


    </div>



<?php include_once('footer.php'); ?>