<div class="layout-sidebar layout-item gutter-medium">
      <div class="widget-sidebar">
<?php 
$ay=date(m);
if($_SESSION['username'] != ''){ 
$favorikontrol = $db->prepare("select * from favorioyunlar where (username = '".$_SESSION['username']."') && (oyunid = '".$oyun['id']."')");
$result = $favorikontrol->execute();
$favorikontrol  = $favorikontrol->fetch(PDO::FETCH_ASSOC);

if($favorikontrol['username'] == ''){
?>
				<form method="POST">				
				<input type="text" name="favoriekle" value="favori" class="hidden">
				<button onclick = "this.form.submit();" class="button blue" style="font-size: 11px;font-weight: 700;text-transform: none;"><i class="fa fa-heart" style="padding-top:1px;"></i> Favori Oyunlarıma Ekle
				<div class="button-ornament">
					<!-- ARROW ICON -->
					<svg class="arrow-icon medium">
					  <use xlink:href="#svg-arrow-medium"></use>
					</svg>
					<!-- /ARROW ICON -->

					<!-- CROSS ICON -->
					<svg class="cross-icon small">
					  <use xlink:href="#svg-cross-small"></use>
					</svg>
					<!-- /CROSS ICON -->
				</div>
				</button>
				</form>
<?php
}else{
?>
				<form method="POST">				
				<input type="text" name="favoriekle" value="cikar" class="hidden">
				<button onclick = "this.form.submit();" class="button red" style="font-size: 11px;font-weight: 700;text-transform: none;">Favori Oyunlarımdan Çıkart
				<div class="button-ornament">
					<!-- ARROW ICON -->
					<svg class="arrow-icon medium">
					  <use xlink:href="#svg-arrow-medium"></use>
					</svg>
					<!-- /ARROW ICON -->

					<!-- CROSS ICON -->
					<svg class="cross-icon small">
					  <use xlink:href="#svg-cross-small"></use>
					</svg>
					<!-- /CROSS ICON -->
				</div>				
				</button>
				</form>

<?php
}

if($_POST['favoriekle'] == 'favori'){
	$username = $_SESSION['username'];
	$oyunn = $oyun['baslik'];
	$oyunid = $oyun['id'];
	$stamp = time();
	
	$db->query("insert into favorioyunlar (username, oyun, oyunid, stamp) values ('$username', '$oyunn', '$oyunid', '$stamp')");
	
	header('Location:'.$domain2.'oyundetay/'.$oyun['url']);
}

if($_POST['favoriekle'] == 'cikar'){
	$username = $_SESSION['username'];
	$oyunn = $oyun['baslik'];
	$oyunid = $oyun['id'];
	$stamp = time();
	
	$db->query("delete from favorioyunlar where (username = '".$_SESSION['username']."') && (oyunid = '".$oyun['id']."')");
	
	header('Location:'.$domain2.'oyundetay/'.$oyun['url']);
}

?>


				
<?php } ?>
      </div>
	  
<!--Top 5 Başlangıç -->	
<style>
.widget-top-player .top-player-stats {
    justify-content: space-between;
}
</style>
<div class="widget-sidebar">
        <div class="section-title-wrap violet">
          <h2 class="section-title medium" style="margin-top: 0px;">Top 5 Oyuncu</h2>
          <div class="section-title-separator"></div>
        </div>
<?php if($_REQUEST['p'] == 'faction'){ 

$hostsece 	=	"87.248.157.101:3306";
$usersece 	=	"candycra_server";
$passsece 	=	"GhzeR8aqX8yu#!"; 
$dbikice		=	"candycra_Faction";

$baglanuce = mysql_connect($hostsece, $usersece, $passsece) or die (mysql_Error());

mysql_select_db($dbikice, $baglanuce) or die (mysql_Error());

mysql_query("SET CHARACTER SET 'utf8'");
mysql_query("SET NAMES 'utf8'");
$eeec = mysql_query("SELECT * FROM BattleLevelsData  ORDER BY level DESC LIMIT 5",$baglanuce); 
$i=1;
while($ihqqsane=mysql_fetch_assoc($eeec)) 
{  
$namename=$ihqqsane["name"]; 
$score=$ihqqsane["score"];
$kills=$ihqqsane["kills"];
$killstreak=$ihqqsane["killstreak"];
$topstreak=$ihqqsane["topstreak"];
$booster=$ihqqsane["booster"];
$level=$ihqqsane["level"];

$oyuncu = $kpanel->prepare("select * from Kullanicilar where (username = '".$namename."')");
$result = $oyuncu->execute();
$oyuncu  = $oyuncu->fetch(PDO::FETCH_ASSOC);
	
$grup = $yetkiler->prepare("select * from perm_playergroups where (playeruuid = '".$oyuncu["uuid"]."') && (groupid != '16') && (groupid != '17') && (groupid != '18') order by groupid desc");
$result = $grup->execute();
$grup  = $grup->fetch(PDO::FETCH_ASSOC);

$grupadi = $yetkiler->prepare("select * from perm_groups where (id = '".$grup['groupid']."')");
$result = $grupadi->execute();
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


if($i == '1'){
	echo '<div class="widget-top-player">';
	  echo '<img class="top-player-img" src="https://minotar.net/body/'.$namename.'" alt="top-player" style="height: 105px;">';
	  echo '<div class="top-player-info-wrap">';
		echo '<div class="top-player-info">';
echo '<div class="team-info-wrap">';
  echo '<div class="team-info" style="margin: 6px 0 0px;">';
	echo '<a href="'.$domain2.'profil/'.$namename.'" style="color:#363636 !important;"><p class="team-country" style="font-size: 1em;color:#363636 !important;text-transform:none;">'.$namename.' <span class="tag-ornament" style="vertical-align:middle;margin-top: 0px;margin-left: 5px;background:'.$renk.';">'.$grupadi['name'].'</span></a></p>';
  echo '</div>';
echo '</div>';		  
		echo '</div>';
#echo '<div class="arc-rate-wrap tiny">';
  #echo '<div id="ew1-tp-rate-01" class="arc rate small negative"></div>';
#echo '</div>';
	  echo '</div> ';
	  echo '<div class="top-player-stats">';
	  
		echo '<div class="top-player-stat">';
		  echo '<p class="top-player-stat-title">'.$level.'</p>';
		  echo '<p class="top-player-stat-text">Level</p>';
		echo '</div>';
		echo '<div class="top-player-stat">';
		  echo '<p class="top-player-stat-title">'.$kills.'</p>';
		  echo '<p class="top-player-stat-text">Öldürme</p>';
		echo '</div>';
		echo '<div class="top-player-stat">';
		  echo '<p class="top-player-stat-title">'.$killstreak.'</p>';
		  echo '<p class="top-player-stat-text">Seri kill</p>';
		echo '</div>';
		

	  echo '</div>';
	echo '</div>';
}else{
if($i == '2'){
	echo '<div class="table top-players" style="margin-bottom: 0px;">';
	  echo '<div class="table-row-header">';
		echo '<div class="table-row-header-item left">';
		  echo '<p class="table-row-header-title">Adı</p>';
		echo '</div>';
		echo '<div class="table-row-header-item padded">';
		  echo '<p class="table-row-header-title">Level</p>';
		echo '</div>';
		echo '<div class="table-row-header-item padded">';
		  echo '<p class="table-row-header-title">Öldürme</p>';
		echo '</div>';

	  echo '</div>';
	  echo '<div class="table-rows no-color">';
}	

echo '<div class="table-row">';
  echo '<div class="table-row-item">';
	echo '<div class="team-info-wrap">';
	  echo '<img class="user-avatar tiny" src="https://cravatar.eu/avatar/'.$namename.'" alt="'.$namename.'">';
	  echo '<div class="team-info">';
echo '<a href="'.$domain2.'profil/'.$namename.'" style="color:#363636 !important;"><p class="team-country" style="font-size: .8em;color:#363636 !important;text-transform:none;">'.$namename.' ';
#echo '<span class="tag-ornament" style="vertical-align:middle;margin-top: 0px;margin-left: 5px;background:'.$renk.';">'.$grupadi['name'].'</span>';
echo '</a></p>';		
	  echo '</div>';
	echo '</div>';
  echo '</div>';

  echo '<div class="table-row-item">';
	echo '<p class="table-text bold">'.$level.'</p>';
  echo '</div>';  
  
  echo '<div class="table-row-item">';
	echo '<p class="table-text bold">'.$kills.'</p>';
  echo '</div>';
  


echo '</div>';


}
$i++;
}
?>
          </div>
        </div>
		
<?php } ?>	
<?php if($_REQUEST['p'] == 'skyblock'){ 
$hostsecea 	=	"87.248.157.101:3306";
$usersecea 	=	"candycra_server";
$passsecea 	=	"GhzeR8aqX8yu#!"; 
$dbikicea	=	"candycra_Istatikler";

$baglanucea = mysql_connect($hostsecea, $usersecea, $passsecea) or die (mysql_Error());

mysql_select_db($dbikicea, $baglanucea) or die (mysql_Error());

mysql_query("SET CHARACTER SET 'utf8'");
mysql_query("SET NAMES 'utf8'");
$eeeca = mysql_query("SELECT * FROM skyblock_leaderheadsplayersdata_monthly where stat_type='asb-level' && (month = $ay) ORDER BY stat_value DESC LIMIT 5",$baglanucea); 
$i=1;
while($ihqqsanea=mysql_fetch_assoc($eeeca)) 
{  
$player_idplayer_idplayer_id=$ihqqsanea["player_id"]; 
$scorestat_value=$ihqqsanea["stat_value"]; 
								
$ugetceircc = mysql_fetch_array(mysql_query("SELECT * FROM leaderheadsplayers WHERE player_id='$player_idplayer_idplayer_id'",$baglanucea));
$player_nameplayenamer_name=$ugetceircc["name"]; 


$ugetirccce = mysql_fetch_array(mysql_query("SELECT * FROM skyblock_leaderheadsplayersdata_monthly WHERE player_id='$player_idplayer_idplayer_id' and stat_type='kills' && (month = $ay)",$baglanucea));
$oldurmestat_value=$ugetirccce["stat_value"];


$ugetircccec = mysql_fetch_array(mysql_query("SELECT * FROM skyblock_leaderheadsplayersdata_monthly WHERE player_id='$player_idplayer_idplayer_id' and stat_type='mobkills' && (month = $ay)",$baglanucea));
$mobkillsstat_value=$ugetircccec["stat_value"];

$oyuncu = $kpanel->prepare("select * from Kullanicilar where (username = '".$player_nameplayenamer_name."')");
$result = $oyuncu->execute();
$oyuncu  = $oyuncu->fetch(PDO::FETCH_ASSOC);
	
$grup = $yetkiler->prepare("select * from perm_playergroups where (playeruuid = '".$oyuncu["uuid"]."') && (groupid != '16') && (groupid != '17') && (groupid != '18') order by groupid desc");
$result = $grup->execute();
$grup  = $grup->fetch(PDO::FETCH_ASSOC);

$grupadi = $yetkiler->prepare("select * from perm_groups where (id = '".$grup['groupid']."')");
$result = $grupadi->execute();
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


if($i == '1'){
	echo '<div class="widget-top-player">';
	  echo '<img class="top-player-img" src="https://minotar.net/body/'.$player_nameplayenamer_name.'" alt="top-player" style="height: 105px;">';
	  echo '<div class="top-player-info-wrap">';
		echo '<div class="top-player-info">';
echo '<div class="team-info-wrap">';
  echo '<div class="team-info" style="margin: 6px 0 0px;">';
	echo '<a href="'.$domain2.'profil/'.$player_nameplayenamer_name.'" style="color:#363636 !important;"><p class="team-country" style="font-size: 1em;color:#363636 !important;text-transform:none;">'.$player_nameplayenamer_name.' <span class="tag-ornament" style="vertical-align:middle;margin-top: 0px;margin-left: 5px;background:'.$renk.';">'.$grupadi['name'].'</span></a></p>';
  echo '</div>';
echo '</div>';		    
		echo '</div>';
#echo '<div class="arc-rate-wrap tiny">';
  #echo '<div id="ew1-tp-rate-01" class="arc rate small negative"></div>';
#echo '</div>';
	  echo '</div> ';
	  echo '<div class="top-player-stats">';
	  
		echo '<div class="top-player-stat">';
		  echo '<p class="top-player-stat-title">'.$scorestat_value.'</p>';
		  echo '<p class="top-player-stat-text">Ada Seviyesi</p>';
		echo '</div>';

		echo '<div class="top-player-stat">';
		  echo '<p class="top-player-stat-title">'.$mobkillsstat_value.'</p>';
		  echo '<p class="top-player-stat-text">Mob Öldürme</p>';
		echo '</div>';
		

	  echo '</div>';
	echo '</div>';
}else{
if($i == '2'){
	echo '<div class="table top-players" style="margin-bottom: 0px;">';
	  echo '<div class="table-row-header">';
		echo '<div class="table-row-header-item left">';
		  echo '<p class="table-row-header-title">Adı</p>';
		echo '</div>';
		echo '<div class="table-row-header-item padded">';
		  echo '<p class="table-row-header-title">Ada Seviyesi</p>';
		echo '</div>';
		echo '<div class="table-row-header-item padded">';
		  echo '<p class="table-row-header-title">Mob Öldürme</p>';
		echo '</div>';

	  echo '</div>';
	  echo '<div class="table-rows no-color">';
}	

echo '<div class="table-row">';
  echo '<div class="table-row-item">';
	echo '<div class="team-info-wrap">';
	  echo '<img class="user-avatar tiny" src="https://cravatar.eu/avatar/'.$player_nameplayenamer_name.'" alt="'.$player_nameplayenamer_name.'">';
	  echo '<div class="team-info">';
echo '<a href="'.$domain2.'profil/'.$player_nameplayenamer_name.'" style="color:#363636 !important;"><p class="team-country" style="font-size: 9px;color:#363636 !important;text-transform:none;">'.$player_nameplayenamer_name.' ';
#echo '<span class="tag-ornament" style="vertical-align:middle;margin-top: 0px;margin-left: 5px;background:'.$renk.';">'.$grupadi['name'].'</span>';
echo '</a></p>';		
	  echo '</div>';
	echo '</div>';
  echo '</div>';

  echo '<div class="table-row-item">';
	echo '<p class="table-text bold">'.$scorestat_value.'</p>';
  echo '</div>';  
  
  echo '<div class="table-row-item">';
	echo '<p class="table-text bold">'.$mobkillsstat_value.'</p>';
  echo '</div>';
  


echo '</div>';


}
$i++;
}
?>
          </div>
        </div>
<?php } ?>	
<?php if($_REQUEST['p'] == 'skypvp'){ 

$hostsecea 	=	"87.248.157.101:3306";
$usersecea 	=	"candycra_server";
$passsecea 	=	"GhzeR8aqX8yu#!"; 
$dbikicea	=	"candycra_Istatikler";

$baglanucea = mysql_connect($hostsecea, $usersecea, $passsecea) or die (mysql_Error());

mysql_select_db($dbikicea, $baglanucea) or die (mysql_Error());

mysql_query("SET CHARACTER SET 'utf8'");
mysql_query("SET NAMES 'utf8'");
$eeecac = mysql_query("SELECT * FROM skypvp_leaderheadsplayersdata_monthly where stat_type='kills' && (month = $ay) ORDER BY stat_value DESC LIMIT 5",$baglanucea); 
$i=1;
while($ihqqsaneac=mysql_fetch_assoc($eeecac)) 
{  
$player_idplayer_idplayer_idc=$ihqqsaneac["player_id"]; 
$scorestat_valuec=$ihqqsaneac["stat_value"]; 
								
$ugetceircc = mysql_fetch_array(mysql_query("SELECT * FROM leaderheadsplayers WHERE player_id='$player_idplayer_idplayer_idc'",$baglanucea));
$player_nameplayenamer_name=$ugetceircc["name"]; 


$ucgetircccec = mysql_fetch_array(mysql_query("SELECT * FROM skypvp_leaderheadsplayersdata_monthly WHERE player_id='$player_idplayer_idplayer_idc' and stat_type='balance' && (month = $ay)",$baglanucea));
$balancestat_valuec=$ucgetircccec["stat_value"];

$oyuncu = $kpanel->prepare("select * from Kullanicilar where (username = '".$player_nameplayenamer_name."')");
$result = $oyuncu->execute();
$oyuncu  = $oyuncu->fetch(PDO::FETCH_ASSOC);
	
$grup = $yetkiler->prepare("select * from perm_playergroups where (playeruuid = '".$oyuncu["uuid"]."') && (groupid != '16') && (groupid != '17') && (groupid != '18') order by groupid desc");
$result = $grup->execute();
$grup  = $grup->fetch(PDO::FETCH_ASSOC);

$grupadi = $yetkiler->prepare("select * from perm_groups where (id = '".$grup['groupid']."')");
$result = $grupadi->execute();
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


if($i == '1'){
	echo '<div class="widget-top-player">';
	  echo '<img class="top-player-img" src="https://minotar.net/body/'.$player_nameplayenamer_name.'" alt="top-player" style="height: 105px;">';
	  echo '<div class="top-player-info-wrap">';
		echo '<div class="top-player-info">';
echo '<div class="team-info-wrap">';
  echo '<div class="team-info" style="margin: 6px 0 0px;">';
	echo '<a href="'.$domain2.'profil/'.$player_nameplayenamer_name.'" style="color:#363636 !important;"><p class="team-country" style="font-size: 1em;color:#363636 !important;text-transform:none;">'.$player_nameplayenamer_name.' <span class="tag-ornament" style="vertical-align:middle;margin-top: 0px;margin-left: 5px;background:'.$renk.';">'.$grupadi['name'].'</span></a></p>';
  echo '</div>';
echo '</div>';		  
		echo '</div>';
#echo '<div class="arc-rate-wrap tiny">';
  #echo '<div id="ew1-tp-rate-01" class="arc rate small negative"></div>';
#echo '</div>';
	  echo '</div> ';
	  echo '<div class="top-player-stats">';
	  
		echo '<div class="top-player-stat">';
		  echo '<p class="top-player-stat-title">'.$scorestat_valuec.'</p>';
		  echo '<p class="top-player-stat-text">Öldürme</p>';
		echo '</div>';
		echo '<div class="top-player-stat">';
		  echo '<p class="top-player-stat-title">'.$balancestat_valuec.'</p>';
		  echo '<p class="top-player-stat-text">Bakiye</p>';
		echo '</div>';

		

	  echo '</div>';
	echo '</div>';
}else{
if($i == '2'){
	echo '<div class="table top-players" style="margin-bottom: 0px;">';
	  echo '<div class="table-row-header">';
		echo '<div class="table-row-header-item left">';
		  echo '<p class="table-row-header-title">Adı</p>';
		echo '</div>';
		echo '<div class="table-row-header-item padded">';
		  echo '<p class="table-row-header-title">Öldürme</p>';
		echo '</div>';
		echo '<div class="table-row-header-item padded">';
		  echo '<p class="table-row-header-title">Bakiye</p>';
		echo '</div>';

	  echo '</div>';
	  echo '<div class="table-rows no-color">';
}	

echo '<div class="table-row">';
  echo '<div class="table-row-item">';
	echo '<div class="team-info-wrap">';
	  echo '<img class="user-avatar tiny" src="https://cravatar.eu/avatar/'.$player_nameplayenamer_name.'" alt="'.$player_nameplayenamer_name.'">';
	  echo '<div class="team-info">';
echo '<a href="'.$domain2.'profil/'.$player_nameplayenamer_name.'" style="color:#363636 !important;"><p class="team-country" style="font-size: .8em;color:#363636 !important;text-transform:none;">'.$player_nameplayenamer_name.' ';
#echo '<span class="tag-ornament" style="vertical-align:middle;margin-top: 0px;margin-left: 5px;background:'.$renk.';">'.$grupadi['name'].'</span>';
echo '</a></p>';		
	  echo '</div>';
	echo '</div>';
  echo '</div>';  

  echo '<div class="table-row-item">';
	echo '<p class="table-text bold">'.$scorestat_valuec.'</p>';
  echo '</div>';  
  
  echo '<div class="table-row-item">';
	echo '<p class="table-text bold">'.$balancestat_valuec.'</p>';
  echo '</div>';
  


echo '</div>';


}
$i++;
}
?>
          </div>
        </div>
		
<?php } ?>	

<?php if($_REQUEST['p'] == 'eggwars'){ 

$hostsece 	=	"87.248.157.101:3306";
$usersece 	=	"candycra_server";
$passsece 	=	"GhzeR8aqX8yu#!"; 
$dbikice	=	"candycra_Oyunlar";

$baglanuce = mysql_connect($hostsece, $usersece, $passsece) or die (mysql_Error());

mysql_select_db($dbikice, $baglanuce) or die (mysql_Error());

mysql_query("SET CHARACTER SET 'utf8'");
mysql_query("SET NAMES 'utf8'");
$eeec = mysql_query("SELECT * FROM eggwars_players  ORDER BY wins DESC LIMIT 5",$baglanuce); 
$i=1;
while($ihqqsane=mysql_fetch_assoc($eeec)) 
{  
$namename=$ihqqsane["name"]; 
$score=$ihqqsane["wins"];
$kills=$ihqqsane["kills"];
$oynanan=$ihqqsane["played"];
$yumurta=$ihqqsane["eggs"];

$oyuncu = $kpanel->prepare("select * from Kullanicilar where (username = '".$namename."')");
$result = $oyuncu->execute();
$oyuncu  = $oyuncu->fetch(PDO::FETCH_ASSOC);
	
$grup = $yetkiler->prepare("select * from perm_playergroups where (playeruuid = '".$oyuncu["uuid"]."') && (groupid != '16') && (groupid != '17') && (groupid != '18') order by groupid desc");
$result = $grup->execute();
$grup  = $grup->fetch(PDO::FETCH_ASSOC);

$grupadi = $yetkiler->prepare("select * from perm_groups where (id = '".$grup['groupid']."')");
$result = $grupadi->execute();
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


if($i == '1'){
	echo '<div class="widget-top-player">';
	  echo '<img class="top-player-img" src="https://minotar.net/body/'.$namename.'" alt="top-player" style="height: 105px;">';
	  echo '<div class="top-player-info-wrap">';
		echo '<div class="top-player-info">';
echo '<div class="team-info-wrap">';
  echo '<div class="team-info" style="margin: 6px 0 0px;">';
	echo '<a href="'.$domain2.'profil/'.$namename.'" style="color:#363636 !important;"><p class="team-country" style="font-size: 1em;color:#363636 !important;text-transform:none;">'.$namename.' <span class="tag-ornament" style="vertical-align:middle;margin-top: 0px;margin-left: 5px;background:'.$renk.';">'.$grupadi['name'].'</span></a></p>';
  echo '</div>';
echo '</div>';		  
		echo '</div>';
#echo '<div class="arc-rate-wrap tiny">';
  #echo '<div id="ew1-tp-rate-01" class="arc rate small negative"></div>';
#echo '</div>';
	  echo '</div> ';
	  echo '<div class="top-player-stats">';
	  
		echo '<div class="top-player-stat">';
		  echo '<p class="top-player-stat-title">'.$score.'</p>';
		  echo '<p class="top-player-stat-text">Kazanma</p>';
		echo '</div>';
		echo '<div class="top-player-stat">';
		  echo '<p class="top-player-stat-title">'.$yumurta.'</p>';
		  echo '<p class="top-player-stat-text">Kırılan Yumurta</p>';
		echo '</div>';

		

	  echo '</div>';
	echo '</div>';
}else{
if($i == '2'){
	echo '<div class="table top-players" style="margin-bottom: 0px;">';
	  echo '<div class="table-row-header">';
		echo '<div class="table-row-header-item left">';
		  echo '<p class="table-row-header-title">Adı</p>';
		echo '</div>';
		echo '<div class="table-row-header-item padded">';
		  echo '<p class="table-row-header-title">Kazanma</p>';
		echo '</div>';
		echo '<div class="table-row-header-item padded">';
		  echo '<p class="table-row-header-title">Kırılan Yumurta</p>';
		echo '</div>';

	  echo '</div>';
	  echo '<div class="table-rows no-color">';
}	

echo '<div class="table-row">';
  echo '<div class="table-row-item">';
	echo '<div class="team-info-wrap">';
	  echo '<img class="user-avatar tiny" src="https://cravatar.eu/avatar/'.$namename.'" alt="'.$player_nameplayenamer_name.'">';
	  echo '<div class="team-info">';
echo '<a href="'.$domain2.'profil/'.$namename.'" style="color:#363636 !important;"><p class="team-country" style="font-size: .8em;color:#363636 !important;text-transform:none;">'.$namename.' ';
#echo '<span class="tag-ornament" style="vertical-align:middle;margin-top: 0px;margin-left: 5px;background:'.$renk.';">'.$grupadi['name'].'</span>';
echo '</a></p>';		
	  echo '</div>';
	echo '</div>';
  echo '</div>';  

  echo '<div class="table-row-item">';
	echo '<p class="table-text bold">'.$score.'</p>';
  echo '</div>';  
  
  echo '<div class="table-row-item">';
	echo '<p class="table-text bold">'.$yumurta.'</p>';
  echo '</div>';
  


echo '</div>';


}
$i++;
}
?>
          </div>
        </div>
		
<?php } ?>	









<?php if($_REQUEST['p'] == 'koyun-hirsizi'){ 

$khhost="87.248.157.101:3306";
$khdb="candycra_Oyunlar";
$khuser="candycra_server";
$khpass="GhzeR8aqX8yu#!";

try {
$khdb = new PDO("mysql:host=$khhost;dbname=$khdb;charset=utf8", "$khuser", "$khpass");
} catch ( PDOException $e ){
print $e->getMessage();
}
$i=1;
$koyunhirsiziveri = $khdb->query("SELECT * FROM sheepquest order by wins desc limit 5", PDO::FETCH_ASSOC);
foreach($koyunhirsiziveri as $koyunhirsizidetay){

$kazanma=$koyunhirsizidetay['wins'];
$oyuncuad=$koyunhirsizidetay['username'];
$koyuncalma=$koyunhirsizidetay['sgrecord'];


$oyuncu = $kpanel->prepare("select * from Kullanicilar where (username = '".$oyuncuad."')");
$result = $oyuncu->execute();
$oyuncu  = $oyuncu->fetch(PDO::FETCH_ASSOC);
	
$grup = $yetkiler->prepare("select * from perm_playergroups where (playeruuid = '".$oyuncu["uuid"]."') && (groupid != '16') && (groupid != '17') && (groupid != '18') order by groupid desc");
$result = $grup->execute();
$grup  = $grup->fetch(PDO::FETCH_ASSOC);

$grupadi = $yetkiler->prepare("select * from perm_groups where (id = '".$grup['groupid']."')");
$result = $grupadi->execute();
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


if($i == '1'){
	echo '<div class="widget-top-player">';
	  echo '<img class="top-player-img" src="https://minotar.net/body/'.$oyuncuad.'" alt="top-player" style="height: 105px;">';
	  echo '<div class="top-player-info-wrap">';
		echo '<div class="top-player-info">';
echo '<div class="team-info-wrap">';
  echo '<div class="team-info" style="margin: 6px 0 0px;">';
	echo '<a href="'.$domain2.'profil/'.$oyuncuad.'" style="color:#363636 !important;"><p class="team-country" style="font-size: 1em;color:#363636 !important;text-transform:none;">'.$oyuncuad.' <span class="tag-ornament" style="vertical-align:middle;margin-top: 0px;margin-left: 5px;background:'.$renk.';">'.$grupadi['name'].'</span></a></p>';
  echo '</div>';
echo '</div>';		  
		echo '</div>';
#echo '<div class="arc-rate-wrap tiny">';
  #echo '<div id="ew1-tp-rate-01" class="arc rate small negative"></div>';
#echo '</div>';
	  echo '</div> ';
	  echo '<div class="top-player-stats">';
	  
		echo '<div class="top-player-stat">';
		  echo '<p class="top-player-stat-title">'.$kazanma.'</p>';
		  echo '<p class="top-player-stat-text">Kazanma</p>';
		echo '</div>';
		echo '<div class="top-player-stat">';
		  echo '<p class="top-player-stat-title">'.$koyuncalma.'</p>';
		  echo '<p class="top-player-stat-text">En Fazla Koyun Çalma</p>';
		echo '</div>';

		

	  echo '</div>';
	echo '</div>';
}else{
if($i == '2'){
	echo '<div class="table top-players" style="margin-bottom: 0px;">';
	  echo '<div class="table-row-header">';
		echo '<div class="table-row-header-item left">';
		  echo '<p class="table-row-header-title">Adı</p>';
		echo '</div>';
		echo '<div class="table-row-header-item padded">';
		  echo '<p class="table-row-header-title">Kazanma</p>';
		echo '</div>';
		echo '<div class="table-row-header-item padded">';
		  echo '<p class="table-row-header-title">En Fazla Koyun Çalma</p>';
		echo '</div>';

	  echo '</div>';
	  echo '<div class="table-rows no-color">';
}	

echo '<div class="table-row">';
  echo '<div class="table-row-item">';
	echo '<div class="team-info-wrap">';
	  echo '<img class="user-avatar tiny" src="https://cravatar.eu/avatar/'.$oyuncuad.'" alt="'.$oyuncuad.'">';
	  echo '<div class="team-info">';
echo '<a href="'.$domain2.'profil/'.$oyuncuad.'" style="color:#363636 !important;"><p class="team-country" style="font-size: .8em;color:#363636 !important;text-transform:none;">'.$oyuncuad.' ';
#echo '<span class="tag-ornament" style="vertical-align:middle;margin-top: 0px;margin-left: 5px;background:'.$renk.';">'.$grupadi['name'].'</span>';
echo '</a></p>';		
	  echo '</div>';
	echo '</div>';
  echo '</div>';  

  echo '<div class="table-row-item">';
	echo '<p class="table-text bold">'.$kazanma.'</p>';
  echo '</div>';  
  
  echo '<div class="table-row-item">';
	echo '<p class="table-text bold">'.$koyuncalma.'</p>';
  echo '</div>';
  


echo '</div>';


}
$i++;
}
?>
          </div>
        </div>
		
<?php } ?>























<?php if($_REQUEST['p'] == 'bedwars'){ 

$hostseceax 	=	"87.248.157.101:3306";
$userseceax 	=	"candycra_server";
$passseceax 	=	"GhzeR8aqX8yu#!"; 
$dbikiceacx		=	"candycra_Oyunlar";

$baglanuceacx = mysql_connect($hostseceax, $userseceax, $passseceax) or die (mysql_Error());

mysql_select_db($dbikiceacx, $baglanuceacx) or die (mysql_Error());

mysql_query("SET CHARACTER SET 'utf8'");
mysql_query("SET NAMES 'utf8'");
$eeecacx = mysql_query("SELECT * FROM global_stats ORDER BY Wins DESC LIMIT 5",$baglanuceacx); 
$i=1;
while($ihqqsaneacx=mysql_fetch_assoc($eeecacx)) 
{  
$NameNameNameName=$ihqqsaneacx["name"]; 
$WinsWins=$ihqqsaneacx["wins"]; 
$KillsKills=$ihqqsaneacx["kills"]; 
$GamesPlayedGamesPlayed=$ihqqsaneacx["games_played"]; 
$BedsBrokenBedsBrokenBedsBroken=$ihqqsaneacx["beds_destroyed"]; 

$oyuncu = $kpanel->prepare("select * from Kullanicilar where (username = '".$NameNameNameName."')");
$result = $oyuncu->execute();
$oyuncu  = $oyuncu->fetch(PDO::FETCH_ASSOC);
	
$grup = $yetkiler->prepare("select * from perm_playergroups where (playeruuid = '".$oyuncu["uuid"]."') && (groupid != '16') && (groupid != '17') && (groupid != '18') order by groupid desc");
$result = $grup->execute();
$grup  = $grup->fetch(PDO::FETCH_ASSOC);

$grupadi = $yetkiler->prepare("select * from perm_groups where (id = '".$grup['groupid']."')");
$result = $grupadi->execute();
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


if($i == '1'){
	echo '<div class="widget-top-player">';
	  echo '<img class="top-player-img" src="https://minotar.net/body/'.$NameNameNameName.'" alt="top-player" style="height: 105px;">';
	  echo '<div class="top-player-info-wrap">';
		echo '<div class="top-player-info">';
echo '<div class="team-info-wrap">';
  echo '<div class="team-info" style="margin: 6px 0 0px;">';
	echo '<a href="'.$domain2.'profil/'.$NameNameNameName.'" style="color:#363636 !important;"><p class="team-country" style="font-size: 1em;color:#363636 !important;text-transform:none;">'.$NameNameNameName.' <span class="tag-ornament" style="vertical-align:middle;margin-top: 0px;margin-left: 5px;background:'.$renk.';">'.$grupadi['name'].'</span></a></p>';
  echo '</div>';
echo '</div>';		  
		echo '</div>';
#echo '<div class="arc-rate-wrap tiny">';
  #echo '<div id="ew1-tp-rate-01" class="arc rate small negative"></div>';
#echo '</div>';
	  echo '</div> ';
	  echo '<div class="top-player-stats">';
	  
		echo '<div class="top-player-stat">';
		  echo '<p class="top-player-stat-title">'.$WinsWins.'</p>';
		  echo '<p class="top-player-stat-text">Kazanma</p>';
		echo '</div>';
		echo '<div class="top-player-stat">';
		  echo '<p class="top-player-stat-title">'.$BedsBrokenBedsBrokenBedsBroken.'</p>';
		  echo '<p class="top-player-stat-text">Kırılan Yatak</p>';
		echo '</div>';

		

	  echo '</div>';
	echo '</div>';
}else{
if($i == '2'){
	echo '<div class="table top-players" style="margin-bottom: 0px;">';
	  echo '<div class="table-row-header">';
		echo '<div class="table-row-header-item left">';
		  echo '<p class="table-row-header-title">Adı</p>';
		echo '</div>';
		echo '<div class="table-row-header-item padded">';
		  echo '<p class="table-row-header-title">Kazanma</p>';
		echo '</div>';
		echo '<div class="table-row-header-item padded">';
		  echo '<p class="table-row-header-title">Kırılan Yatak</p>';
		echo '</div>';

	  echo '</div>';
	  echo '<div class="table-rows no-color">';
}	

echo '<div class="table-row">';
  echo '<div class="table-row-item">';
	echo '<div class="team-info-wrap">';
	  echo '<img class="user-avatar tiny" src="https://cravatar.eu/avatar/'.$NameNameNameName.'" alt="'.$NameNameNameName.'">';
	  echo '<div class="team-info">';
echo '<a href="'.$domain2.'profil/'.$NameNameNameName.'" style="color:#363636 !important;"><p class="team-country" style="font-size: .8em;color:#363636 !important;text-transform:none;">'.$NameNameNameName.' ';
#echo '<span class="tag-ornament" style="vertical-align:middle;margin-top: 0px;margin-left: 5px;background:'.$renk.';">'.$grupadi['name'].'</span>';
echo '</a></p>';		
	  echo '</div>';
	echo '</div>';
  echo '</div>';  

  echo '<div class="table-row-item">';
	echo '<p class="table-text bold">'.$WinsWins.'</p>';
  echo '</div>';  
  
  echo '<div class="table-row-item">';
	echo '<p class="table-text bold">'.$BedsBrokenBedsBrokenBedsBroken.'</p>';
  echo '</div>';
  


echo '</div>';


}
$i++;
}
?>
          </div>
        </div>
		
<?php } ?>	

<?php if($_REQUEST['p'] == 'katil-kim'){ 

$hostseceax 	=	"87.248.157.101:3306";
$userseceax 	=	"candycra_server";
$passseceax 	=	"GhzeR8aqX8yu#!"; 
$dbikiceacx		=	"candycra_Oyunlar";
$baglanuceacx = mysql_connect($hostseceax, $userseceax, $passseceax) or die (mysql_Error());

mysql_select_db($dbikiceacx, $baglanuceacx) or die (mysql_Error());

mysql_query("SET CHARACTER SET 'utf8'");
mysql_query("SET NAMES 'utf8'");
$eeecacee = mysql_query("SELECT * FROM MurderData  ORDER BY Wins DESC LIMIT 5",$baglanuceacx); 
$i=1;
while($ihqqsaneacxeee=mysql_fetch_assoc($eeecacee)) 
{  
$playernameplayernameplayername=$ihqqsaneacxeee["playername"]; 
$winswinswinswinswins=$ihqqsaneacxeee["wins"]; 
$KillsKillsKillkills=$ihqqsaneacxeee["kills"]; 
$deathsdeathsdedeathsaths=$ihqqsaneacxeee["deaths"]; 
$scorescorescorescore=$ihqqsaneacxeee["score"]; 

$oyuncu = $kpanel->prepare("select * from Kullanicilar where (username = '".$playernameplayernameplayername."')");
$result = $oyuncu->execute();
$oyuncu  = $oyuncu->fetch(PDO::FETCH_ASSOC);
	
$grup = $yetkiler->prepare("select * from perm_playergroups where (playeruuid = '".$oyuncu["uuid"]."') && (groupid != '16') && (groupid != '17') && (groupid != '18') order by groupid desc");
$result = $grup->execute();
$grup  = $grup->fetch(PDO::FETCH_ASSOC);

$grupadi = $yetkiler->prepare("select * from perm_groups where (id = '".$grup['groupid']."')");
$result = $grupadi->execute();
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


if($i == '1'){
	echo '<div class="widget-top-player">';
	  echo '<img class="top-player-img" src="https://minotar.net/body/'.$playernameplayernameplayername.'" alt="top-player" style="height: 105px;">';
	  echo '<div class="top-player-info-wrap">';
		echo '<div class="top-player-info">';
echo '<div class="team-info-wrap">';
  echo '<div class="team-info" style="margin: 6px 0 0px;">';
	echo '<a href="'.$domain2.'profil/'.$playernameplayernameplayername.'" style="color:#363636 !important;"><p class="team-country" style="font-size: 1em;color:#363636 !important;text-transform:none;">'.$playernameplayernameplayername.' <span class="tag-ornament" style="vertical-align:middle;margin-top: 0px;margin-left: 5px;background:'.$renk.';">'.$grupadi['name'].'</span></a></p>';
  echo '</div>';
echo '</div>';		  
		echo '</div>';
#echo '<div class="arc-rate-wrap tiny">';
  #echo '<div id="ew1-tp-rate-01" class="arc rate small negative"></div>';
#echo '</div>';
	  echo '</div> ';
	  echo '<div class="top-player-stats">';
	  
		echo '<div class="top-player-stat">';
		  echo '<p class="top-player-stat-title">'.$winswinswinswinswins.'</p>';
		  echo '<p class="top-player-stat-text">Kazanma</p>';
		echo '</div>';
		echo '<div class="top-player-stat">';
		  echo '<p class="top-player-stat-title">'.$scorescorescorescore.'</p>';
		  echo '<p class="top-player-stat-text">Skor</p>';
		echo '</div>';

		

	  echo '</div>';
	echo '</div>';
}else{
if($i == '2'){
	echo '<div class="table top-players" style="margin-bottom: 0px;">';
	  echo '<div class="table-row-header">';
		echo '<div class="table-row-header-item left">';
		  echo '<p class="table-row-header-title">Adı</p>';
		echo '</div>';
		echo '<div class="table-row-header-item padded">';
		  echo '<p class="table-row-header-title">Kazanma</p>';
		echo '</div>';
		echo '<div class="table-row-header-item padded">';
		  echo '<p class="table-row-header-title">Skor</p>';
		echo '</div>';

	  echo '</div>';
	  echo '<div class="table-rows no-color">';
}	

echo '<div class="table-row">';
  echo '<div class="table-row-item">';
	echo '<div class="team-info-wrap">';
	  echo '<img class="user-avatar tiny" src="https://cravatar.eu/avatar/'.$playernameplayernameplayername.'" alt="'.$playernameplayernameplayername.'">';
	  echo '<div class="team-info">';
echo '<a href="'.$domain2.'profil/'.$playernameplayernameplayername.'" style="color:#363636 !important;"><p class="team-country" style="font-size: .8em;color:#363636 !important;text-transform:none;">'.$playernameplayernameplayername.' ';
#echo '<span class="tag-ornament" style="vertical-align:middle;margin-top: 0px;margin-left: 5px;background:'.$renk.';">'.$grupadi['name'].'</span>';
echo '</a></p>';		
	  echo '</div>';
	echo '</div>';
  echo '</div>';  

  echo '<div class="table-row-item">';
	echo '<p class="table-text bold">'.$winswinswinswinswins.'</p>';
  echo '</div>';  
  
  echo '<div class="table-row-item">';
	echo '<p class="table-text bold">'.$scorescorescorescore.'</p>';
  echo '</div>';
  


echo '</div>';


}
$i++;
}
?>
          </div>
        </div>
		
<?php } ?>	

<?php if($_REQUEST['p'] == 'build-battle'){ 

$hostseceax 	=	"87.248.157.101:3306";
$userseceax 	=	"candycra_server";
$passseceax 	=	"GhzeR8aqX8yu#!"; 
$dbikiceacx		=	"candycra_Oyunlar";
$baglanuceacx = mysql_connect($hostseceax, $userseceax, $passseceax) or die (mysql_Error());

mysql_select_db($dbikiceacx, $baglanuceacx) or die (mysql_Error());
$eeeacacee = mysql_query("SELECT * FROM masterbuilders  ORDER BY Wins DESC, PlayedGames DESC LIMIT 5",$baglanuceacx); 
$i=1;
while($ihqqsanceacxeee=mysql_fetch_assoc($eeeacacee)) 
{  
$UUID=$ihqqsanceacxeee["UUID"]; 
$WinsWinsWinsWinsWinsWins=$ihqqsanceacxeee["Wins"]; 
$PlayedGamesPlayedGamesPlayedGamesPlayedGamesPlayedGamesPlayedGames=$ihqqsanceacxeee["PlayedGames"]; 
							
$ugetceirccCECE = mysql_fetch_array(mysql_query("SELECT * FROM fr_players WHERE player_uuid='$UUID'",$baglanuceacx));
$player_nameplayer_nameplayer_nameplayer_name=$ugetceirccCECE["player_name"]; 

if($ugetceirccCECE["player_name"] == ''){
	$kullanici = $kpanel->prepare("select * from Kullanicilar where (uuid = '".$UUID."')");
	$result = $kullanici->execute();
	$kullanici  = $kullanici->fetch(PDO::FETCH_ASSOC);
	$player_nameplayer_nameplayer_nameplayer_name = $kullanici['username'];
}

$oyuncu = $kpanel->prepare("select * from Kullanicilar where (username = '".$player_nameplayer_nameplayer_nameplayer_name."')");
$result = $oyuncu->execute();
$oyuncu  = $oyuncu->fetch(PDO::FETCH_ASSOC);
	
$grup = $yetkiler->prepare("select * from perm_playergroups where (playeruuid = '".$oyuncu["uuid"]."') && (groupid != '16') && (groupid != '17') && (groupid != '18') order by groupid desc");
$result = $grup->execute();
$grup  = $grup->fetch(PDO::FETCH_ASSOC);

$grupadi = $yetkiler->prepare("select * from perm_groups where (id = '".$grup['groupid']."')");
$result = $grupadi->execute();
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


if($i == '1'){
	echo '<div class="widget-top-player">';
	  echo '<img class="top-player-img" src="https://minotar.net/body/'.$player_nameplayer_nameplayer_nameplayer_name.'" alt="top-player" style="height: 105px;">';
	  echo '<div class="top-player-info-wrap">';
		echo '<div class="top-player-info">';
echo '<div class="team-info-wrap">';
  echo '<div class="team-info" style="margin: 6px 0 0px;">';
	echo '<a href="'.$domain2.'profil/'.$player_nameplayer_nameplayer_nameplayer_name.'" style="color:#363636 !important;"><p class="team-country" style="font-size: 1em;color:#363636 !important;text-transform:none;">'.$player_nameplayer_nameplayer_nameplayer_name.' <span class="tag-ornament" style="vertical-align:middle;margin-top: 0px;margin-left: 5px;background:'.$renk.';">'.$grupadi['name'].'</span></a></p>';
  echo '</div>';
echo '</div>';		  
		echo '</div>';
#echo '<div class="arc-rate-wrap tiny">';
  #echo '<div id="ew1-tp-rate-01" class="arc rate small negative"></div>';
#echo '</div>';
	  echo '</div> ';
	  echo '<div class="top-player-stats">';
	  
		echo '<div class="top-player-stat">';
		  echo '<p class="top-player-stat-title">'.$WinsWinsWinsWinsWinsWins.'</p>';
		  echo '<p class="top-player-stat-text">Kazanma</p>';
		echo '</div>';
		echo '<div class="top-player-stat">';
		  echo '<p class="top-player-stat-title">'.$PlayedGamesPlayedGamesPlayedGamesPlayedGamesPlayedGamesPlayedGames.'</p>';
		  echo '<p class="top-player-stat-text">Oynanan Oyun</p>';
		echo '</div>';

		

	  echo '</div>';
	echo '</div>';
}else{
if($i == '2'){
	echo '<div class="table top-players" style="margin-bottom: 0px;">';
	  echo '<div class="table-row-header">';
		echo '<div class="table-row-header-item left">';
		  echo '<p class="table-row-header-title">Adı</p>';
		echo '</div>';
		echo '<div class="table-row-header-item padded">';
		  echo '<p class="table-row-header-title">Kazanma</p>';
		echo '</div>';
		echo '<div class="table-row-header-item padded">';
		  echo '<p class="table-row-header-title">Oynanan Oyun</p>';
		echo '</div>';

	  echo '</div>';
	  echo '<div class="table-rows no-color">';
}	

echo '<div class="table-row">';
  echo '<div class="table-row-item">';
	echo '<div class="team-info-wrap">';
	  echo '<img class="user-avatar tiny" src="https://cravatar.eu/avatar/'.$player_nameplayer_nameplayer_nameplayer_name.'" alt="'.$player_nameplayer_nameplayer_nameplayer_name.'">';
	  echo '<div class="team-info">';
echo '<a href="'.$domain2.'profil/'.$player_nameplayer_nameplayer_nameplayer_name.'" style="color:#363636 !important;"><p class="team-country" style="font-size: .8em;color:#363636 !important;text-transform:none;">'.$player_nameplayer_nameplayer_nameplayer_name.' ';
#echo '<span class="tag-ornament" style="vertical-align:middle;margin-top: 0px;margin-left: 5px;background:'.$renk.';">'.$grupadi['name'].'</span>';
echo '</a></p>';		
	  echo '</div>';
	echo '</div>';
  echo '</div>';  

  echo '<div class="table-row-item">';
	echo '<p class="table-text bold">'.$WinsWinsWinsWinsWinsWins.'</p>';
  echo '</div>';  
  
  echo '<div class="table-row-item">';
	echo '<p class="table-text bold">'.$PlayedGamesPlayedGamesPlayedGamesPlayedGamesPlayedGamesPlayedGames.'</p>';
  echo '</div>';
  


echo '</div>';


}
$i++;
}
?>
          </div>
        </div>
		
<?php } ?>	

<?php if($_REQUEST['p'] == 'speed-builders'){ 

$hostseceax 	=	"87.248.157.101:3306";
$userseceax 	=	"candycra_server";
$passseceax 	=	"GhzeR8aqX8yu#!"; 
$dbikiceacx		=	"candycra_Oyunlar";
$baglanuceacx = mysql_connect($hostseceax, $userseceax, $passseceax) or die (mysql_Error());

mysql_select_db($dbikiceacx, $baglanuceacx) or die (mysql_Error()); 
$eeeacacee = mysql_query("SELECT * FROM speedbuilders  ORDER BY wins DESC LIMIT 5",$baglanuceacx); 
$i=1;
while($ihqqsanceacxeee=mysql_fetch_assoc($eeeacacee)) 
{  
$UUIDusername=$ihqqsanceacxeee["username"]; 
$winscwins=$ihqqsanceacxeee["wins"]; 
$pbuildspbuildspbuilds=$ihqqsanceacxeee["pbuilds"];

$oyuncu = $kpanel->prepare("select * from Kullanicilar where (username = '".$UUIDusername."')");
$result = $oyuncu->execute();
$oyuncu  = $oyuncu->fetch(PDO::FETCH_ASSOC);
	
$grup = $yetkiler->prepare("select * from perm_playergroups where (playeruuid = '".$oyuncu["uuid"]."') && (groupid != '16') && (groupid != '17') && (groupid != '18') order by groupid desc");
$result = $grup->execute();
$grup  = $grup->fetch(PDO::FETCH_ASSOC);

$grupadi = $yetkiler->prepare("select * from perm_groups where (id = '".$grup['groupid']."')");
$result = $grupadi->execute();
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


if($i == '1'){
	echo '<div class="widget-top-player">';
	  echo '<img class="top-player-img" src="https://minotar.net/body/'.$UUIDusername.'" alt="top-player" style="height: 105px;">';
	  echo '<div class="top-player-info-wrap">';
		echo '<div class="top-player-info">';
echo '<div class="team-info-wrap">';
  echo '<div class="team-info" style="margin: 6px 0 0px;">';
	echo '<a href="'.$domain2.'profil/'.$UUIDusername.'" style="color:#363636 !important;"><p class="team-country" style="font-size: 1em;color:#363636 !important;text-transform:none;">'.$UUIDusername.' <span class="tag-ornament" style="vertical-align:middle;margin-top: 0px;margin-left: 5px;background:'.$renk.';">'.$grupadi['name'].'</span></a></p>';
  echo '</div>';
echo '</div>';		  
		echo '</div>';
#echo '<div class="arc-rate-wrap tiny">';
  #echo '<div id="ew1-tp-rate-01" class="arc rate small negative"></div>';
#echo '</div>';
	  echo '</div> ';
	  echo '<div class="top-player-stats">';
	  
		echo '<div class="top-player-stat">';
		  echo '<p class="top-player-stat-title">'.$winscwins.'</p>';
		  echo '<p class="top-player-stat-text">Kazanma</p>';
		echo '</div>';
		echo '<div class="top-player-stat">';
		  echo '<p class="top-player-stat-title">'.$pbuildspbuildspbuilds.'</p>';
		  echo '<p class="top-player-stat-text">Mükemmel Uyum</p>';
		echo '</div>';

		

	  echo '</div>';
	echo '</div>';
}else{
if($i == '2'){
	echo '<div class="table top-players" style="margin-bottom: 0px;">';
	  echo '<div class="table-row-header">';
		echo '<div class="table-row-header-item left">';
		  echo '<p class="table-row-header-title">Adı</p>';
		echo '</div>';
		echo '<div class="table-row-header-item padded">';
		  echo '<p class="table-row-header-title">Kazanma</p>';
		echo '</div>';
		echo '<div class="table-row-header-item padded">';
		  echo '<p class="table-row-header-title">Mükemmel Uyum</p>';
		echo '</div>';

	  echo '</div>';
	  echo '<div class="table-rows no-color">';
}	

echo '<div class="table-row">';
  echo '<div class="table-row-item">';
	echo '<div class="team-info-wrap">';
	  echo '<img class="user-avatar tiny" src="https://cravatar.eu/avatar/'.$UUIDusername.'" alt="'.$UUIDusername.'">';
	  echo '<div class="team-info">';
echo '<a href="'.$domain2.'profil/'.$UUIDusername.'" style="color:#363636 !important;"><p class="team-country" style="font-size: .8em;color:#363636 !important;text-transform:none;">'.$UUIDusername.' ';
#echo '<span class="tag-ornament" style="vertical-align:middle;margin-top: 0px;margin-left: 5px;background:'.$renk.';">'.$grupadi['name'].'</span>';
echo '</a></p>';		
	  echo '</div>';
	echo '</div>';
  echo '</div>';  

  echo '<div class="table-row-item">';
	echo '<p class="table-text bold">'.$winscwins.'</p>';
  echo '</div>';  
  
  echo '<div class="table-row-item">';
	echo '<p class="table-text bold">'.$pbuildspbuildspbuilds.'</p>';
  echo '</div>';
  


echo '</div>';


}
$i++;
}
?>
          </div>
        </div>
		
<?php } ?>	

<?php if($_REQUEST['p'] == 'hunger-games'){ 

$hostseceax 	=	"87.248.157.101:3306";
$userseceax 	=	"candycra_server";
$passseceax 	=	"GhzeR8aqX8yu#!"; 
$dbikiceacx		=	"candycra_Oyunlar";
$baglanuceacx = mysql_connect($hostseceax, $userseceax, $passseceax) or die (mysql_Error());

mysql_select_db($dbikiceacx, $baglanuceacx) or die (mysql_Error()); 
$eeeacacee = mysql_query("SELECT * FROM sg_  ORDER BY Wins DESC LIMIT 5",$baglanuceacx); 
$i=1;
while($ihqqsanceacxeee=mysql_fetch_assoc($eeeacacee)) 
{  
$UUIDusernplayer_nameame=$ihqqsanceacxeee["player_name"]; 
$WinscWinscWins=$ihqqsanceacxeee["Wins"]; 
$KillscKillscKills=$ihqqsanceacxeee["Kills"]; 
$DeathscDeathscDeaths=$ihqqsanceacxeee["Deaths"]; 
$GamesplayedcGamesplayedcGamesplayed=$ihqqsanceacxeee["Gamesplayed"]; 

$oyuncu = $kpanel->prepare("select * from Kullanicilar where (username = '".$UUIDusernplayer_nameame."')");
$result = $oyuncu->execute();
$oyuncu  = $oyuncu->fetch(PDO::FETCH_ASSOC);
	
$grup = $yetkiler->prepare("select * from perm_playergroups where (playeruuid = '".$oyuncu["uuid"]."') && (groupid != '16') && (groupid != '17') && (groupid != '18') order by groupid desc");
$result = $grup->execute();
$grup  = $grup->fetch(PDO::FETCH_ASSOC);

$grupadi = $yetkiler->prepare("select * from perm_groups where (id = '".$grup['groupid']."')");
$result = $grupadi->execute();
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


if($i == '1'){
	echo '<div class="widget-top-player">';
	  echo '<img class="top-player-img" src="https://minotar.net/body/'.$UUIDusernplayer_nameame.'" alt="top-player" style="height: 105px;">';
	  echo '<div class="top-player-info-wrap">';
		echo '<div class="top-player-info">';
echo '<div class="team-info-wrap">';
  echo '<div class="team-info" style="margin: 6px 0 0px;">';
	echo '<a href="'.$domain2.'profil/'.$UUIDusernplayer_nameame.'" style="color:#363636 !important;"><p class="team-country" style="font-size: 1em;color:#363636 !important;text-transform:none;">'.$UUIDusernplayer_nameame.' <span class="tag-ornament" style="vertical-align:middle;margin-top: 0px;margin-left: 5px;background:'.$renk.';">'.$grupadi['name'].'</span></a></p>';
  echo '</div>';
echo '</div>';		  
		echo '</div>';
#echo '<div class="arc-rate-wrap tiny">';
  #echo '<div id="ew1-tp-rate-01" class="arc rate small negative"></div>';
#echo '</div>';
	  echo '</div> ';
	  echo '<div class="top-player-stats">';
	  
		echo '<div class="top-player-stat">';
		  echo '<p class="top-player-stat-title">'.$WinscWinscWins.'</p>';
		  echo '<p class="top-player-stat-text">Kazanma</p>';
		echo '</div>';
		echo '<div class="top-player-stat">';
		  echo '<p class="top-player-stat-title">'.$KillscKillscKills.'</p>';
		  echo '<p class="top-player-stat-text">Öldürme</p>';
		echo '</div>';

		

	  echo '</div>';
	echo '</div>';
}else{
if($i == '2'){
	echo '<div class="table top-players" style="margin-bottom: 0px;">';
	  echo '<div class="table-row-header">';
		echo '<div class="table-row-header-item left">';
		  echo '<p class="table-row-header-title">Adı</p>';
		echo '</div>';
		echo '<div class="table-row-header-item padded">';
		  echo '<p class="table-row-header-title">Kazanma</p>';
		echo '</div>';
		echo '<div class="table-row-header-item padded">';
		  echo '<p class="table-row-header-title">Öldürme</p>';
		echo '</div>';

	  echo '</div>';
	  echo '<div class="table-rows no-color">';
}	

echo '<div class="table-row">';
  echo '<div class="table-row-item">';
	echo '<div class="team-info-wrap">';
	  echo '<img class="user-avatar tiny" src="https://cravatar.eu/avatar/'.$UUIDusernplayer_nameame.'" alt="'.$UUIDusernplayer_nameame.'">';
	  echo '<div class="team-info">';
echo '<a href="'.$domain2.'profil/'.$UUIDusernplayer_nameame.'" style="color:#363636 !important;"><p class="team-country" style="font-size: .8em;color:#363636 !important;text-transform:none;">'.$UUIDusernplayer_nameame.' ';
#echo '<span class="tag-ornament" style="vertical-align:middle;margin-top: 0px;margin-left: 5px;background:'.$renk.';">'.$grupadi['name'].'</span>';
echo '</a></p>';		
	  echo '</div>';
	echo '</div>';
  echo '</div>';  

  echo '<div class="table-row-item">';
	echo '<p class="table-text bold">'.$WinscWinscWins.'</p>';
  echo '</div>';  
  
  echo '<div class="table-row-item">';
	echo '<p class="table-text bold">'.$KillscKillscKills.'</p>';
  echo '</div>';
  


echo '</div>';


}
$i++;
}
?>
          </div>
        </div>
		
<?php } ?>	

<?php if($_REQUEST['p'] == 'cehennem-vadisi'){ 

$hostsece 	=	"87.248.157.101:3306";
$usersece 	=	"candycra_server";
$passsece 	=	"GhzeR8aqX8yu#!"; 
$dbikice	=	"candycra_Oyunlar";

$baglanuce = mysql_connect($hostsece, $usersece, $passsece) or die (mysql_Error());

mysql_select_db($dbikice, $baglanuce) or die (mysql_Error());

mysql_query("SET CHARACTER SET 'utf8'");
mysql_query("SET NAMES 'utf8'");
$eeec = mysql_query("SELECT * FROM ZombieSurvivalData ORDER BY Kills DESC LIMIT 5",$baglanuce); 
$i=1;
while($ihqqsane=mysql_fetch_assoc($eeec)) 
{  
$namename=$ihqqsane["Name"]; 
$kills=$ihqqsane["Kills"];
$roundskor=$ihqqsane["HighestRound"];
$canlandirma=$ihqqsane["Revives"];
$oynama=$ihqqsane["GamesPlayed"];

$oyuncu = $kpanel->prepare("select * from Kullanicilar where (username = '".$namename."')");
$result = $oyuncu->execute();
$oyuncu  = $oyuncu->fetch(PDO::FETCH_ASSOC);
	
$grup = $yetkiler->prepare("select * from perm_playergroups where (playeruuid = '".$oyuncu["uuid"]."') && (groupid != '16') && (groupid != '17') && (groupid != '18') order by groupid desc");
$result = $grup->execute();
$grup  = $grup->fetch(PDO::FETCH_ASSOC);

$grupadi = $yetkiler->prepare("select * from perm_groups where (id = '".$grup['groupid']."')");
$result = $grupadi->execute();
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


if($i == '1'){
	echo '<div class="widget-top-player">';
	  echo '<img class="top-player-img" src="https://minotar.net/body/'.$namename.'" alt="top-player" style="height: 105px;">';
	  echo '<div class="top-player-info-wrap">';
		echo '<div class="top-player-info">';
echo '<div class="team-info-wrap">';
  echo '<div class="team-info" style="margin: 6px 0 0px;">';
	echo '<a href="'.$domain2.'profil/'.$namename.'" style="color:#363636 !important;"><p class="team-country" style="font-size: 12px;color:#363636 !important;text-transform:none;">'.$namename.' <span class="tag-ornament" style="vertical-align:middle;margin-top: 0px;margin-left: 5px;background:'.$renk.';">'.$grupadi['name'].'</span></a></p>';
  echo '</div>';
echo '</div>';		  
		echo '</div>';
#echo '<div class="arc-rate-wrap tiny">';
  #echo '<div id="ew1-tp-rate-01" class="arc rate small negative"></div>';
#echo '</div>';
	  echo '</div> ';
	  echo '<div class="top-player-stats">';
	  
		echo '<div class="top-player-stat">';
		  echo '<p class="top-player-stat-title">'.$kills.'</p>';
		  echo '<p class="top-player-stat-text">Zombi Öldürme</p>';
		echo '</div>';
		echo '<div class="top-player-stat">';
		  echo '<p class="top-player-stat-title">'.$canlandirma.'</p>';
		  echo '<p class="top-player-stat-text">Canlandırma</p>';
		echo '</div>';

		

	  echo '</div>';
	echo '</div>';
}else{
if($i == '2'){
	echo '<div class="table top-players" style="margin-bottom: 0px;">';
	  echo '<div class="table-row-header">';
		echo '<div class="table-row-header-item left">';
		  echo '<p class="table-row-header-title">Adı</p>';
		echo '</div>';
		echo '<div class="table-row-header-item padded">';
		  echo '<p class="table-row-header-title">Zombi Öldürme</p>';
		echo '</div>';
		echo '<div class="table-row-header-item padded">';
		  echo '<p class="table-row-header-title">Canlandırma</p>';
		echo '</div>';

	  echo '</div>';
	  echo '<div class="table-rows no-color">';
}	

echo '<div class="table-row">';
  echo '<div class="table-row-item">';
	echo '<div class="team-info-wrap">';
	  echo '<img class="user-avatar tiny" src="https://cravatar.eu/avatar/'.$namename.'" alt="'.$namename.'">';
	  echo '<div class="team-info">';
echo '<a href="'.$domain2.'profil/'.$namename.'" style="color:#363636 !important;"><p class="team-country" style="font-size: .8em;color:#363636 !important;text-transform:none;">'.$namename.' ';
#echo '<span class="tag-ornament" style="vertical-align:middle;margin-top: 0px;margin-left: 5px;background:'.$renk.';">'.$grupadi['name'].'</span>';
echo '</a></p>';		
	  echo '</div>';
	echo '</div>';
  echo '</div>';  

  echo '<div class="table-row-item">';
	echo '<p class="table-text bold">'.$kills.'</p>';
  echo '</div>';  
  
  echo '<div class="table-row-item">';
	echo '<p class="table-text bold">'.$canlandirma.'</p>';
  echo '</div>';
  


echo '</div>';


}
$i++;
}
?>
          </div>
        </div>
		
<?php } ?>	

      </div>
 
  
<!--Top 5 Bitiş -->	  
	  
	  
	  
	  
      

      <div class="widget-sidebar">

        <div class="section-title-wrap red">
          <h2 class="section-title medium" style="margin-top: 0px;">Oyunlar</h2>
          <div class="section-title-separator"></div>
        </div>

        <div class="post-preview-showcase grid-1col centered gutter-small">
<?php
$oyunlar = $db->query("select * from oyunlar where (yayin = '1') order by stamp asc");
$oyunlar->execute();
$oyunlar = $oyunlar->fetchAll();

foreach($oyunlar as $oyun){
	echo '<div class="post-preview tiny game-review">';
		echo '<a href="'.$domain2.'oyundetay/'.$oyun['url'].'">';
		  echo '<div class="post-preview-img-wrap">';
			echo '<figure class="post-preview-img liquid">';
			  echo '<img src="'.$domain.'images/blog/'.$oyun['gorsel'].'" alt="post-16">';
			echo '</figure>';
			echo '<div class="review-rating">';
			  #echo '<div id="sidebar-rate-2" class="arc tiny"></div>';
			echo '</div>';
		  echo '</div>';
		echo '</a>';
		echo '<a href="'.$domain2.'oyundetay/'.$oyun['url'].'" class="post-preview-title">'.$oyun['baslik'].'</a>';
		echo '<div class="post-author-info-wrap">';
		  echo '<p class="post-author-info small light"><a href="'.$domain2.'oyundetay/'.$oyun['url'].'" class="post-author">'.$oyun['konu'].'</a><span class="separator">|</span>'.$oyun['ozellik'].'</p>';
		echo '</div>';
	echo '</div>';
}
?>

		
          
		  
        </div>
      </div>



    </div>