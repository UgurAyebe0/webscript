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
@media screen and (min-width:700px){
	.burasi{
		min-width:400px;
	}
}
@media screen and (max-width:700px){
	body{
		overflow-x:auto;
	}
}
</style>

  <!-- BANNER WRAP -->
  <div class="banner-wrap forum-banner">
    <!-- BANNER -->
    <div class="banner grid-limit">
      <h2 class="banner-title">Sıralamalar</h2>
      <p class="banner-sections">
        <span class="banner-section">Anasayfa</span>
        <!-- ARROW ICON -->
        <svg class="arrow-icon">
          <use xlink:href="#svg-arrow"></use>
        </svg>
        <!-- /ARROW ICON -->
        <span class="banner-section">Sıralama</span>

       
      </p>
    </div>
    <!-- /BANNER -->
  </div>
  <!-- /BANNER WRAP -->
<?php include_once('slidenews.php'); ?>

  <!-- LAYOUT CONTENT FULL -->
  <div class="layout-content-full grid-limit">

    <div class="filters-row">

      <div class="option-list">
<?php
if($_REQUEST['p'] == ''){$puan = 'selected';}else{$puan = '';}
if($_REQUEST['p'] == 'faction'){$faction = 'selected';}else{$faction = '';}
if($_REQUEST['p'] == 'skyblock'){$skyblock = 'selected';}else{$skyblock = '';}
if($_REQUEST['p'] == 'skypvp'){$skypvp = 'selected';}else{$skypvp = '';}
if($_REQUEST['p'] == 'bedwars'){$bedwars = 'selected';}else{$bedwars = '';}
if($_REQUEST['p'] == 'skywars'){$skywars = 'selected';}else{$skywars = '';}
if($_REQUEST['p'] == 'murder'){$murder = 'selected';}else{$murder = '';}
if($_REQUEST['p'] == 'buildbattle'){$buildbattle = 'selected';}else{$buildbattle = '';}
if($_REQUEST['p'] == 'speedbuilders'){$speedbuilders = 'selected';}else{$speedbuilders = '';}
if($_REQUEST['p'] == 'hungergames'){$hungergames = 'selected';}else{$hungergames = '';}
if($_REQUEST['p'] == 'eggwars'){$eggwars = 'selected';}else{$eggwars = '';}
if($_REQUEST['p'] == 'koyunhirsizi'){$koyunhirsizi = 'selected';}else{$koyunhirsizi = '';}
if($_REQUEST['p'] == 'cehennemvadisi'){$cehennemvadisi = 'selected';}else{$cehennemvadisi = '';}
?>
        <a href="<?php echo $domain2.'siralama'; ?>"><p class="option-list-item <?php echo $puan; ?>">PUAN</p></a>
        <a href="<?php echo $domain2.'siralama/'; ?>faction"><p class="option-list-item  <?php echo $faction; ?>">FACTION</p></a>
        <a href="<?php echo $domain2.'siralama/'; ?>skyblock"><p class="option-list-item  <?php echo $skyblock; ?>">SKYBLOCK</p></a>
        <a href="<?php echo $domain2.'siralama/'; ?>skypvp"><p class="option-list-item  <?php echo $skypvp; ?>">SKYPVP</p></a>
        <a href="<?php echo $domain2.'siralama/'; ?>bedwars"><p class="option-list-item  <?php echo $bedwars; ?>">BEDWARS</p></a>
        <a href="<?php echo $domain2.'siralama/'; ?>skywars"><p class="option-list-item  <?php echo $skywars; ?>">SKYWARS</p></a>
        <a href="<?php echo $domain2.'siralama/'; ?>murder"><p class="option-list-item  <?php echo $murder; ?>">MURDER</p></a>
        <a href="<?php echo $domain2.'siralama/'; ?>buildbattle"><p class="option-list-item  <?php echo $buildbattle; ?>">BUILDBATTLE</p></a>
        <a href="<?php echo $domain2.'siralama/'; ?>speedbuilders"><p class="option-list-item  <?php echo $speedbuilders; ?>">SPEEDBUILDERS</p></a>
        <a href="<?php echo $domain2.'siralama/'; ?>hungergames"><p class="option-list-item  <?php echo $hungergames; ?>">HUNGERGAMES</p></a>
        <a href="<?php echo $domain2.'siralama/'; ?>eggwars"><p class="option-list-item  <?php echo $eggwars; ?>">EGGWARS</p></a>
        <a href="<?php echo $domain2.'siralama/'; ?>koyunhirsizi"><p class="option-list-item  <?php echo $koyunhirsizi; ?>">KOYUN HIRSIZI</p></a>
        <a href="<?php echo $domain2.'siralama/'; ?>cehennemvadisi"><p class="option-list-item  <?php echo $cehennemvadisi; ?>">CEHENNEM VADİSİ</p></a>
      </div>

    </div>
    <!-- /FILTERS ROW -->
<div class="countdown-text-wrap">
          <p id="ew1-cd-text" class="countdown-text"></p>
          <p class="countdown-text-info" style="display:none;">Gün<span class="countdown-text-info-separator">:</span>Saat<span class="countdown-text-info-separator">:</span>Dakika<span class="countdown-text-info-separator">:</span>Saniye</p>
          <div id="ew1-pgb-cd" class="progress-bar" style="display:none;"></div>
		  
<div class="row" style="margin-top:15px;">
	<div class="col-lg-12">
		<div class="alert alert-warning" role="alert">
			
			Faction, Skyblock ve Skypvp oyunlarında aylık sıralamayı oyun içerisindeki top5 alanından görebilirsiniz.<br><br>1. olana <b>15 Kredi</b>, 2. olana <b>10 Kredi</b>, 3. olana <b>5 Kredi</b> ödülü verilir.
		</div>
	</div>
</div>		  
        </div>

    <!-- TABLE -->
<?php if($_REQUEST['p'] == ''){ ?>

    <div class="table forum-topics">
      <div class="table-row-header">
        <div class="table-row-header-item padded-big" style="display:table-cell;">
          <p class="table-row-header-title">Sıra</p>
        </div>
        <div class="table-row-header-item padded-big" style="display:table-cell;">
          <p class="table-row-header-title">#</p>
        </div>
		<div class="table-row-header-item padded-big" style="display:table-cell;">
          <p class="table-row-header-title">İsim</p>
        </div>
        <div class="table-row-header-item padded-big" style="display:table-cell;">
          <p class="table-row-header-title">Puan</p>
        </div>      
      </div>

<?php
$hostsec 	=	"87.248.157.101:3306";
$usersec 	=	"candycra_server";
$passsec 	=	"GhzeR8aqX8yu#!"; 
$dbikic		=	"candycra_Puan";


$baglanuc = mysql_connect($hostsec, $usersec, $passsec) or die (mysql_Error());


mysql_select_db($dbikic, $baglanuc) or die (mysql_Error());



mysql_query("SET CHARACTER SET 'utf8'");
mysql_query("SET NAMES 'utf8'");
$eee = mysql_query("SELECT * FROM cc3_balance  ORDER BY balance DESC LIMIT 25",$baglanuc); 
$i=1;
while($ihqqsan=mysql_fetch_assoc($eee)) 
{  
$username_id=$ihqqsan["username_id"];
$balance=$ihqqsan["balance"];

$ugetircc = mysql_fetch_array(mysql_query("SELECT * FROM cc3_account WHERE id='$username_id'",$baglanuc));


$puankullanici = $kpanel->prepare("select * from Kullanicilar where (uuid = :uuid)");
$result = $puankullanici->execute(array(":uuid" => $ugetircc["uuid"]));
$puankullanici  = $puankullanici->fetch(PDO::FETCH_ASSOC);

$player_nameplayer_name=$puankullanici["username"];

// 
$oyuncu = $kpanel->prepare("select * from Kullanicilar where (username = '".$puankullanici["username"]."')");
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
$rank='<span class="tag-ornament" style="vertical-align:middle;margin-top: 0px;margin-left: 5px;background:'.$renk.';">'.$grupadi['name'].'</span>';

echo '<div class="table-rows">';

echo '<div class="table-row large">';
if($i == '1'){
	echo '<div class="table-row-item" style="width:52px;display:table-cell;">';
	echo '<p class="table-text bold"><img src="'.$domain2.'img/gold.png" style="width:32px;"></p>';
	echo '</div>';
}elseif($i == '2'){
	echo '<div class="table-row-item" style="width:52px;display:table-cell;">';
	echo '<p class="table-text bold"><img src="'.$domain2.'img/silver.png" style="width:32px;"></p>';
	echo '</div>';
}elseif($i == '3'){
	echo '<div class="table-row-item" style="width:52px;display:table-cell;">';
	echo '<p class="table-text bold"><img src="'.$domain2.'img/bronz.png" style="width:32px;"></p>';
	echo '</div>';
}else{
	echo '<div class="table-row-item" style="width:52px;display:table-cell;">';
	echo '<p class="table-text bold">'.$i.'</p>';
	echo '</div>';
}


echo '<div class="table-row-item" style="display:table-cell;">';
echo '<p class="table-text bold"><a href="'.$domain2.'profil/'.$player_nameplayer_name.'"><img src="https://cravatar.eu/avatar/'.$player_nameplayer_name.'" style="width:32px;"> </a></p>';
echo '</div>';

echo '<div class="table-row-item" style="display:table-cell;">';
echo '<a href="'.$domain2.'profil/'.$player_nameplayer_name.'"><p class="table-text bold" style="text-transform:none;">'.$rank.'&nbsp;'.$player_nameplayer_name.'</p></a>';
echo '</div>';
	  
echo '<div class="table-row-item" style="display:table-cell;">';
echo '<a href="'.$domain2.'profil/'.$player_nameplayer_name.'"><p class="table-text bold">'.$balance.'</p></a>';
echo '</div>';  
        
echo '</div>';

echo '</div>';

$i++; }
?>	   
      
    </div>
	
<?php } ?>
    <!-- /TABLE -->
	
	<!-- TABLE -->
<?php if($_REQUEST['p'] == 'faction'){ ?>
    <div class="table forum-topics">
      <div class="table-row-header">

        <div class="table-row-header-item padded-big" style="display:table-cell;">
          <p class="table-row-header-title">Sıra</p>
        </div>
        <div class="table-row-header-item padded-big" style="display:table-cell;">
          <p class="table-row-header-title">#</p>
        </div>
		<div class="table-row-header-item padded-big" style="display:table-cell;">
          <p class="table-row-header-title">İsim</p>
        </div>
		<div class="table-row-header-item padded-big" style="display:table-cell;">
          <p class="table-row-header-title">Level</p>
        </div>
        <div class="table-row-header-item padded-big" style="display:table-cell;">
          <p class="table-row-header-title">Skor</p>
        </div> 
		<div class="table-row-header-item padded-big" style="display:table-cell;">
          <p class="table-row-header-title">Öldürme</p>
        </div> 
		<div class="table-row-header-item padded-big" style="display:table-cell;">
          <p class="table-row-header-title">Seri kill</p>
        </div> 
      </div>

<?php
$hostsece 	=	"87.248.157.101:3306";
	$usersece 	=	"candycra_server";
	$passsece 	=	"GhzeR8aqX8yu#!"; 
	$dbikice		=	"candycra_Faction";
	
	$baglanuce = mysql_connect($hostsece, $usersece, $passsece) or die (mysql_Error());
	
	mysql_select_db($dbikice, $baglanuce) or die (mysql_Error());

	mysql_query("SET CHARACTER SET 'utf8'");
	mysql_query("SET NAMES 'utf8'");
	$eeec = mysql_query("SELECT * FROM BattleLevelsData  ORDER BY level DESC LIMIT 25",$baglanuce); 
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

// 
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
$rank='<span class="tag-ornament" style="vertical-align:middle;margin-top: 0px;margin-left: 5px;background:'.$renk.';">'.$grupadi['name'].'</span>';

echo '<div class="table-rows">';

echo '<div class="table-row large">';
if($i == '1'){
	echo '<div class="table-row-item" style="width:52px;display:table-cell;">';
	echo '<p class="table-text bold"><img src="'.$domain2.'img/gold.png" style="width:32px;"></p>';
	echo '</div>';
}elseif($i == '2'){
	echo '<div class="table-row-item" style="width:52px;display:table-cell;">';
	echo '<p class="table-text bold"><img src="'.$domain2.'img/silver.png" style="width:32px;"></p>';
	echo '</div>';
}elseif($i == '3'){
	echo '<div class="table-row-item" style="width:52px;display:table-cell;">';
	echo '<p class="table-text bold"><img src="'.$domain2.'img/bronz.png" style="width:32px;"></p>';
	echo '</div>';
}else{
	echo '<div class="table-row-item" style="width:52px;display:table-cell;">';
	echo '<p class="table-text bold">'.$i.'</p>';
	echo '</div>';
}


echo '<div class="table-row-item" style="display:table-cell;">';
echo '<p class="table-text bold"><a href="'.$domain2.'profil/'.$namename.'"><img src="https://cravatar.eu/avatar/'.$namename.'" style="width:32px;"> </a></p>';
echo '</div>';

echo '<div class="table-row-item" style="display:table-cell;">';
echo '<a href="'.$domain2.'profil/'.$namename.'"><p class="table-text bold" style="text-transform:none;">'.$rank.'&nbsp;'.$namename.'</p></a>';
echo '</div>';
	  
echo '<div class="table-row-item" style="display:table-cell;">';
echo '<a href="'.$domain2.'profil/'.$namename.'"><p class="table-text bold">'.$level.'</p></a>';
echo '</div>';  

echo '<div class="table-row-item" style="display:table-cell;">';
echo '<a href="'.$domain2.'profil/'.$namename.'"><p class="table-text bold">'.$score.'</p></a>';
echo '</div>';

echo '<div class="table-row-item" style="display:table-cell;">';
echo '<a href="'.$domain2.'profil/'.$namename.'"><p class="table-text bold">'.$kills.'</p></a>';
echo '</div>';

echo '<div class="table-row-item" style="display:table-cell;">';
echo '<a href="'.$domain2.'profil/'.$namename.'"><p class="table-text bold">'.$killstreak.'</p></a>';
echo '</div>';
        
echo '</div>';

echo '</div>';

$i++; }
?>	   
      
    </div>

	
<?php } ?>
    <!-- /TABLE -->
  <!-- TABLE -->
<?php if($_REQUEST['p'] == 'koyunhirsizi'){ ?>
    <div class="table forum-topics">
      <div class="table-row-header">

        <div class="table-row-header-item padded-big" style="display:table-cell;">
          <p class="table-row-header-title">Sıra</p>
        </div>
        <div class="table-row-header-item padded-big" style="display:table-cell;">
          <p class="table-row-header-title">#</p>
        </div>
    <div class="table-row-header-item padded-big" style="display:table-cell;">
          <p class="table-row-header-title">İsim</p>
        </div>
    <div class="table-row-header-item padded-big" style="display:table-cell;">
          <p class="table-row-header-title">Kazanma</p>
        </div>
        <div class="table-row-header-item padded-big" style="display:table-cell;">
          <p class="table-row-header-title">Öldürme</p>
        </div> 
    <div class="table-row-header-item padded-big" style="display:table-cell;">
          <p class="table-row-header-title">En Fazla Koyun Çalma</p>
        </div>  
      </div>

<?php
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
$koyunhirsiziveri = $khdb->query("SELECT * FROM sheepquest order by wins desc limit 25", PDO::FETCH_ASSOC);
foreach($koyunhirsiziveri as $koyunhirsizidetay){

$kazanma=$koyunhirsizidetay['wins'];
$oyuncuad=$koyunhirsizidetay['username'];
$oldurme=$koyunhirsizidetay['kills'];
$koyuncalma=$koyunhirsizidetay['sgrecord'];

// 
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
$rank='<span class="tag-ornament" style="vertical-align:middle;margin-top: 0px;margin-left: 5px;background:'.$renk.';">'.$grupadi['name'].'</span>';

echo '<div class="table-rows">';

echo '<div class="table-row large">';
if($i == '1'){
  echo '<div class="table-row-item" style="width:52px;display:table-cell;">';
  echo '<p class="table-text bold"><img src="'.$domain2.'img/gold.png" style="width:32px;"></p>';
  echo '</div>';
}elseif($i == '2'){
  echo '<div class="table-row-item" style="width:52px;display:table-cell;">';
  echo '<p class="table-text bold"><img src="'.$domain2.'img/silver.png" style="width:32px;"></p>';
  echo '</div>';
}elseif($i == '3'){
  echo '<div class="table-row-item" style="width:52px;display:table-cell;">';
  echo '<p class="table-text bold"><img src="'.$domain2.'img/bronz.png" style="width:32px;"></p>';
  echo '</div>';
}else{
  echo '<div class="table-row-item" style="width:52px;display:table-cell;">';
  echo '<p class="table-text bold">'.$i.'</p>';
  echo '</div>';
}

echo '<div class="table-row-item" style="display:table-cell;">';
echo '<p class="table-text bold"><a href="'.$domain2.'profil/'.$oyuncuad.'"><img src="https://cravatar.eu/avatar/'.$oyuncuad.'" style="width:32px;"> </a></p>';
echo '</div>';

echo '<div class="table-row-item" style="display:table-cell;">';
echo '<a href="'.$domain2.'profil/'.$oyuncuad.'"><p class="table-text bold" style="text-transform:none;">'.$rank.'&nbsp;'.$oyuncuad.'</p></a>';
echo '</div>';
    
echo '<div class="table-row-item" style="display:table-cell;">';
echo '<a href="'.$domain2.'profil/'.$oyuncuad.'"><p class="table-text bold">'.$kazanma.'</p></a>';
echo '</div>';  

echo '<div class="table-row-item" style="display:table-cell;">';
echo '<a href="'.$domain2.'profil/'.$oyuncuad.'"><p class="table-text bold">'.$oldurme.'</p></a>';
echo '</div>';

echo '<div class="table-row-item" style="display:table-cell;">';
echo '<a href="'.$domain2.'profil/'.$oyuncuad.'"><p class="table-text bold">'.$koyuncalma.'</p></a>';
echo '</div>';

        
echo '</div>';

echo '</div>';

$i++; }
?>     
      
    </div>
<?php } ?>
    <!-- /TABLE -->

    <!-- TABLE -->
<?php if($_REQUEST['p'] == 'skyblock'){ ?>

    <div class="table forum-topics">
      <div class="table-row-header">

        <div class="table-row-header-item padded-big" style="display:table-cell;">
          <p class="table-row-header-title">Sıra</p>
        </div>
        <div class="table-row-header-item padded-big" style="display:table-cell;">
          <p class="table-row-header-title">#</p>
        </div>
		<div class="table-row-header-item padded-big" style="display:table-cell;">
          <p class="table-row-header-title">İsim</p>
        </div>
        <div class="table-row-header-item padded-big" style="display:table-cell;">
          <p class="table-row-header-title">Ada Seviyesi</p>
        </div>  
		<div class="table-row-header-item padded-big" style="display:table-cell;">
          <p class="table-row-header-title">Öldürme</p>
        </div>  
		<div class="table-row-header-item padded-big" style="display:table-cell;">
          <p class="table-row-header-title">Mob Öldürme</p>
        </div>  
      </div>

<?php
$hostsecea 	=	"87.248.157.101:3306";
$usersecea 	=	"candycra_server";
$passsecea 	=	"GhzeR8aqX8yu#!"; 
$dbikicea	=	"candycra_Istatikler";

$baglanucea = mysql_connect($hostsecea, $usersecea, $passsecea) or die (mysql_Error());

mysql_select_db($dbikicea, $baglanucea) or die (mysql_Error());

mysql_query("SET CHARACTER SET 'utf8'");
mysql_query("SET NAMES 'utf8'");
$eeeca = mysql_query("SELECT * FROM skyblock_leaderheadsplayersdata_alltime where stat_type='asb-level'  ORDER BY stat_value DESC LIMIT 25",$baglanucea); 
$i=1;
while($ihqqsanea=mysql_fetch_assoc($eeeca)) 
{  
$player_idplayer_idplayer_id=$ihqqsanea["player_id"]; 
$scorestat_value=$ihqqsanea["stat_value"]; 
								
$ugetceircc = mysql_fetch_array(mysql_query("SELECT * FROM leaderheadsplayers WHERE player_id='$player_idplayer_idplayer_id'",$baglanucea));
$player_nameplayenamer_name=$ugetceircc["name"]; 


$ugetirccce = mysql_fetch_array(mysql_query("SELECT * FROM skyblock_leaderheadsplayersdata_alltime WHERE player_id='$player_idplayer_idplayer_id' and stat_type='kills'",$baglanucea));
$oldurmestat_value=$ugetirccce["stat_value"];


$ugetircccec = mysql_fetch_array(mysql_query("SELECT * FROM skyblock_leaderheadsplayersdata_alltime WHERE player_id='$player_idplayer_idplayer_id' and stat_type='mobkills'",$baglanucea));
$mobkillsstat_value=$ugetircccec["stat_value"];

// 
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
$rank='<span class="tag-ornament" style="vertical-align:middle;margin-top: 0px;margin-left: 5px;background:'.$renk.';">'.$grupadi['name'].'</span>';


echo '<div class="table-rows">';

echo '<div class="table-row large">';
if($i == '1'){
	echo '<div class="table-row-item" style="width:52px;display:table-cell;">';
	echo '<p class="table-text bold"><img src="'.$domain2.'img/gold.png" style="width:32px;"></p>';
	echo '</div>';
}elseif($i == '2'){
	echo '<div class="table-row-item" style="width:52px;display:table-cell;">';
	echo '<p class="table-text bold"><img src="'.$domain2.'img/silver.png" style="width:32px;"></p>';
	echo '</div>';
}elseif($i == '3'){
	echo '<div class="table-row-item" style="width:52px;display:table-cell;">';
	echo '<p class="table-text bold"><img src="'.$domain2.'img/bronz.png" style="width:32px;"></p>';
	echo '</div>';
}else{
	echo '<div class="table-row-item" style="width:52px;display:table-cell;">';
	echo '<p class="table-text bold">'.$i.'</p>';
	echo '</div>';
}


echo '<div class="table-row-item" style="display:table-cell;">';
echo '<p class="table-text bold"><a href="'.$domain2.'profil/'.$player_nameplayenamer_name.'"><img src="https://cravatar.eu/avatar/'.$player_nameplayenamer_name.'" style="width:32px;"> </a></p>';
echo '</div>';

echo '<div class="table-row-item" style="display:table-cell;">';
echo '<a href="'.$domain2.'profil/'.$player_nameplayenamer_name.'"><p class="table-text bold" style="text-transform:none;">'.$rank.'&nbsp;'.$player_nameplayenamer_name.'</p></a>';
echo '</div>';
	  
echo '<div class="table-row-item" style="display:table-cell;">';
echo '<a href="'.$domain2.'profil/'.$player_nameplayenamer_name.'"><p class="table-text bold">'.$scorestat_value.'</p></a>';
echo '</div>'; 

echo '<div class="table-row-item" style="display:table-cell;">';
echo '<a href="'.$domain2.'profil/'.$player_nameplayenamer_name.'"><p class="table-text bold">'.$oldurmestat_value.'</p></a>';
echo '</div>'; 

echo '<div class="table-row-item" style="display:table-cell;">';
echo '<a href="'.$domain2.'profil/'.$player_nameplayenamer_name.'"><p class="table-text bold">'.$mobkillsstat_value.'</p></a>';
echo '</div>';  
        
echo '</div>';

echo '</div>';

$i++; }
?>	   
      
    </div>
	
<?php } ?>
    <!-- /TABLE -->

    <!-- TABLE -->
<?php if($_REQUEST['p'] == 'skypvp'){ ?>

    <div class="table forum-topics">
      <div class="table-row-header">

        <div class="table-row-header-item padded-big" style="display:table-cell;">
          <p class="table-row-header-title">Sıra</p>
        </div>
        <div class="table-row-header-item padded-big" style="display:table-cell;">
          <p class="table-row-header-title">#</p>
        </div>
		<div class="table-row-header-item padded-big" style="display:table-cell;">
          <p class="table-row-header-title">İsim</p>
        </div>
        <div class="table-row-header-item padded-big" style="display:table-cell;">
          <p class="table-row-header-title">Öldürme</p>
        </div>
		<div class="table-row-header-item padded-big" style="display:table-cell;">
          <p class="table-row-header-title">Bakiye</p>
        </div>
      </div>

<?php
$hostsecea 	=	"87.248.157.101:3306";
$usersecea 	=	"candycra_server";
$passsecea 	=	"GhzeR8aqX8yu#!"; 
$dbikicea	=	"candycra_Istatikler";

$baglanucea = mysql_connect($hostsecea, $usersecea, $passsecea) or die (mysql_Error());

mysql_select_db($dbikicea, $baglanucea) or die (mysql_Error());

mysql_query("SET CHARACTER SET 'utf8'");
mysql_query("SET NAMES 'utf8'");
$eeecac = mysql_query("SELECT * FROM skypvp_leaderheadsplayersdata_alltime where stat_type='kills'  ORDER BY stat_value DESC LIMIT 25",$baglanucea); 
$i=1;
while($ihqqsaneac=mysql_fetch_assoc($eeecac)) 
{  
$player_idplayer_idplayer_idc=$ihqqsaneac["player_id"]; 
$scorestat_valuec=$ihqqsaneac["stat_value"]; 
								
$ugetceircc = mysql_fetch_array(mysql_query("SELECT * FROM leaderheadsplayers WHERE player_id='$player_idplayer_idplayer_idc'",$baglanucea));
$player_nameplayenamer_name=$ugetceircc["name"]; 


$ucgetircccec = mysql_fetch_array(mysql_query("SELECT * FROM skypvp_leaderheadsplayersdata_alltime WHERE player_id='$player_idplayer_idplayer_idc' and stat_type='balance'",$baglanucea));
$balancestat_valuec=$ucgetircccec["stat_value"];


// 
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
$rank='<span class="tag-ornament" style="vertical-align:middle;margin-top: 0px;margin-left: 5px;background:'.$renk.';">'.$grupadi['name'].'</span>';


echo '<div class="table-rows">';

echo '<div class="table-row large">';
if($i == '1'){
	echo '<div class="table-row-item" style="width:52px;display:table-cell;">';
	echo '<p class="table-text bold"><img src="'.$domain2.'img/gold.png" style="width:32px;"></p>';
	echo '</div>';
}elseif($i == '2'){
	echo '<div class="table-row-item" style="width:52px;display:table-cell;">';
	echo '<p class="table-text bold"><img src="'.$domain2.'img/silver.png" style="width:32px;"></p>';
	echo '</div>';
}elseif($i == '3'){
	echo '<div class="table-row-item" style="width:52px;display:table-cell;">';
	echo '<p class="table-text bold"><img src="'.$domain2.'img/bronz.png" style="width:32px;"></p>';
	echo '</div>';
}else{
	echo '<div class="table-row-item" style="width:52px;display:table-cell;">';
	echo '<p class="table-text bold">'.$i.'</p>';
	echo '</div>';
}


echo '<div class="table-row-item" style="display:table-cell;">';
echo '<p class="table-text bold"><a href="'.$domain2.'profil/'.$player_nameplayenamer_name.'"><img src="https://cravatar.eu/avatar/'.$player_nameplayenamer_name.'" style="width:32px;"> </a></p>';
echo '</div>';

echo '<div class="table-row-item" style="display:table-cell;">';
echo '<a href="'.$domain2.'profil/'.$player_nameplayenamer_name.'"><p class="table-text bold" style="text-transform:none;">'.$rank.'&nbsp;'.$player_nameplayenamer_name.'</p></a>';
echo '</div>';
	  
echo '<div class="table-row-item" style="display:table-cell;">';
echo '<a href="'.$domain2.'profil/'.$player_nameplayenamer_name.'"><p class="table-text bold">'.$scorestat_valuec.'</p></a>';
echo '</div>';  

echo '<div class="table-row-item" style="display:table-cell;">';
echo '<a href="'.$domain2.'profil/'.$player_nameplayenamer_name.'"><p class="table-text bold">'.$balancestat_valuec.'</p></a>';
echo '</div>'; 
        
echo '</div>';

echo '</div>';

$i++; }
?>	   
      
    </div>
	
<?php } ?>
    <!-- /TABLE -->

    <!-- TABLE -->
<?php if($_REQUEST['p'] == 'bedwars'){ ?>

    <div class="table forum-topics">
      <div class="table-row-header">

        <div class="table-row-header-item padded-big" style="display:table-cell;">
          <p class="table-row-header-title">Sıra</p>
        </div>
        <div class="table-row-header-item padded-big" style="display:table-cell;">
          <p class="table-row-header-title">#</p>
        </div>
		<div class="table-row-header-item padded-big" style="display:table-cell;">
          <p class="table-row-header-title">İsim</p>
        </div>
        <div class="table-row-header-item padded-big" style="display:table-cell;">
          <p class="table-row-header-title">Kazanma</p>
        </div> 
		<div class="table-row-header-item padded-big" style="display:table-cell;">
          <p class="table-row-header-title">Öldürme</p>
        </div>
		<div class="table-row-header-item padded-big" style="display:table-cell;">
          <p class="table-row-header-title">Oynanan Oyun</p>
        </div>
		<div class="table-row-header-item padded-big" style="display:table-cell;">
          <p class="table-row-header-title">Kırılan Yatak</p>
        </div>
      </div>

<?php
$hostseceax 	=	"87.248.157.101:3306";
$userseceax 	=	"candycra_server";
$passseceax 	=	"GhzeR8aqX8yu#!"; 
$dbikiceacx		=	"candycra_Oyunlar";

$baglanuceacx = mysql_connect($hostseceax, $userseceax, $passseceax) or die (mysql_Error());

mysql_select_db($dbikiceacx, $baglanuceacx) or die (mysql_Error());

mysql_query("SET CHARACTER SET 'utf8'");
mysql_query("SET NAMES 'utf8'");
$eeecacx = mysql_query("SELECT * FROM global_stats ORDER BY Wins DESC LIMIT 25",$baglanuceacx); 
$i=1;
while($ihqqsaneacx=mysql_fetch_assoc($eeecacx)) 
{  
$NameNameNameName=$ihqqsaneacx["name"]; 
$WinsWins=$ihqqsaneacx["wins"]; 
$KillsKills=$ihqqsaneacx["kills"]; 
$GamesPlayedGamesPlayed=$ihqqsaneacx["games_played"]; 
$BedsBrokenBedsBrokenBedsBroken=$ihqqsaneacx["beds_destroyed"]; 

// 
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
$rank='<span class="tag-ornament" style="vertical-align:middle;margin-top: 0px;margin-left: 5px;background:'.$renk.';">'.$grupadi['name'].'</span>';


echo '<div class="table-rows">';

echo '<div class="table-row large">';
if($i == '1'){
	echo '<div class="table-row-item" style="width:52px;display:table-cell;">';
	echo '<p class="table-text bold"><img src="'.$domain2.'img/gold.png" style="width:32px;"></p>';
	echo '</div>';
}elseif($i == '2'){
	echo '<div class="table-row-item" style="width:52px;display:table-cell;">';
	echo '<p class="table-text bold"><img src="'.$domain2.'img/silver.png" style="width:32px;"></p>';
	echo '</div>';
}elseif($i == '3'){
	echo '<div class="table-row-item" style="width:52px;display:table-cell;">';
	echo '<p class="table-text bold"><img src="'.$domain2.'img/bronz.png" style="width:32px;"></p>';
	echo '</div>';
}else{
	echo '<div class="table-row-item" style="width:52px;display:table-cell;">';
	echo '<p class="table-text bold">'.$i.'</p>';
	echo '</div>';
}



echo '<div class="table-row-item" style="display:table-cell;">';
echo '<p class="table-text bold"><a href="'.$domain2.'profil/'.$NameNameNameName.'"><img src="https://cravatar.eu/avatar/'.$NameNameNameName.'" style="width:32px;"> </a></p>';
echo '</div>';

echo '<div class="table-row-item" style="display:table-cell;">';
echo '<a href="'.$domain2.'profil/'.$NameNameNameName.'"><p class="table-text bold" style="text-transform:none;">'.$rank.'&nbsp;'.$NameNameNameName.'</p></a>';
echo '</div>';
	  
echo '<div class="table-row-item" style="display:table-cell;">';
echo '<a href="'.$domain2.'profil/'.$NameNameNameName.'"><p class="table-text bold">'.$WinsWins.'</p></a>';
echo '</div>';  

echo '<div class="table-row-item" style="display:table-cell;">';
echo '<a href="'.$domain2.'profil/'.$NameNameNameName.'"><p class="table-text bold">'.$KillsKills.'</p></a>';
echo '</div>'; 

echo '<div class="table-row-item" style="display:table-cell;">';
echo '<a href="'.$domain2.'profil/'.$NameNameNameName.'"><p class="table-text bold">'.$GamesPlayedGamesPlayed.'</p></a>';
echo '</div>'; 

echo '<div class="table-row-item" style="display:table-cell;">';
echo '<a href="'.$domain2.'profil/'.$NameNameNameName.'"><p class="table-text bold">'.$BedsBrokenBedsBrokenBedsBroken.'</p></a>';
echo '</div>'; 
        
echo '</div>';

echo '</div>';

$i++; }
?>	   
      
    </div>
	
<?php } ?>
    <!-- /TABLE -->

    <!-- TABLE -->
<?php if($_REQUEST['p'] == 'skywars'){ ?>

    <div class="table forum-topics">
      <div class="table-row-header">

        <div class="table-row-header-item padded-big" style="display:table-cell;">
          <p class="table-row-header-title">Sıra</p>
        </div>
        <div class="table-row-header-item padded-big" style="display:table-cell;">
          <p class="table-row-header-title">#</p>
        </div>
		<div class="table-row-header-item padded-big" style="display:table-cell;">
          <p class="table-row-header-title">İsim</p>
        </div>
        <div class="table-row-header-item padded-big" style="display:table-cell;">
          <p class="table-row-header-title">Kazanma</p>
        </div> 
		<div class="table-row-header-item padded-big" style="display:table-cell;">
          <p class="table-row-header-title">Öldürme</p>
        </div> 
		<div class="table-row-header-item padded-big" style="display:table-cell;">
          <p class="table-row-header-title">Ölme</p>
        </div> 
		<div class="table-row-header-item padded-big" style="display:table-cell;">
          <p class="table-row-header-title">Oynanan Oyun</p>
        </div> 
      </div>

<?php
$hostseceax 	=	"87.248.157.101:3306";
$userseceax 	=	"candycra_server";
$passseceax 	=	"GhzeR8aqX8yu#!"; 
$dbikiceacx		=	"candycra_Oyunlar";
$baglanuceacx = mysql_connect($hostseceax, $userseceax, $passseceax) or die (mysql_Error());

mysql_select_db($dbikiceacx, $baglanuceacx) or die (mysql_Error());

mysql_query("SET CHARACTER SET 'utf8'");
mysql_query("SET NAMES 'utf8'");
$eeecacee = mysql_query("SELECT * FROM SkyWars_Data  ORDER BY Wins DESC LIMIT 25",$baglanuceacx); 
$i=1;
while($ihqqsaneacxee=mysql_fetch_assoc($eeecacee)) 
{  
$NameNameNameNameusername=$ihqqsaneacxee["username"]; 
$WinsWinsWins=$ihqqsaneacxee["wins"]; 
$KillsKillsKills=$ihqqsaneacxee["kills"]; 
$deathsdeathsdeaths=$ihqqsaneacxee["deaths"]; 
$playedplayedplayed=$ihqqsaneacxee["played"]; 

// 
$oyuncu = $kpanel->prepare("select * from Kullanicilar where (username = '".$NameNameNameNameusername."')");
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
$rank='<span class="tag-ornament" style="vertical-align:middle;margin-top: 0px;margin-left: 5px;background:'.$renk.';">'.$grupadi['name'].'</span>';


echo '<div class="table-rows">';

echo '<div class="table-row large">';
if($i == '1'){
	echo '<div class="table-row-item" style="width:52px;display:table-cell;">';
	echo '<p class="table-text bold"><img src="'.$domain2.'img/gold.png" style="width:32px;"></p>';
	echo '</div>';
}elseif($i == '2'){
	echo '<div class="table-row-item" style="width:52px;display:table-cell;">';
	echo '<p class="table-text bold"><img src="'.$domain2.'img/silver.png" style="width:32px;"></p>';
	echo '</div>';
}elseif($i == '3'){
	echo '<div class="table-row-item" style="width:52px;display:table-cell;">';
	echo '<p class="table-text bold"><img src="'.$domain2.'img/bronz.png" style="width:32px;"></p>';
	echo '</div>';
}else{
	echo '<div class="table-row-item" style="width:52px;display:table-cell;">';
	echo '<p class="table-text bold">'.$i.'</p>';
	echo '</div>';
}


echo '<div class="table-row-item" style="display:table-cell;">';
echo '<p class="table-text bold"><a href="'.$domain2.'profil/'.$NameNameNameNameusername.'"><img src="https://cravatar.eu/avatar/'.$NameNameNameNameusername.'" style="width:32px;"> </a></p>';
echo '</div>';

echo '<div class="table-row-item" style="display:table-cell;">';
echo '<a href="'.$domain2.'profil/'.$NameNameNameNameusername.'"><p class="table-text bold" style="text-transform:none;">'.$rank.'&nbsp;'.$NameNameNameNameusername.'</p></a>';
echo '</div>';
	  
echo '<div class="table-row-item" style="display:table-cell;">';
echo '<a href="'.$domain2.'profil/'.$NameNameNameNameusername.'"><p class="table-text bold">'.$WinsWinsWins.'</p></a>';
echo '</div>';  

echo '<div class="table-row-item" style="display:table-cell;">';
echo '<a href="'.$domain2.'profil/'.$NameNameNameNameusername.'"><p class="table-text bold">'.$KillsKillsKills.'</p></a>';
echo '</div>';  

echo '<div class="table-row-item" style="display:table-cell;">';
echo '<a href="'.$domain2.'profil/'.$NameNameNameNameusername.'"><p class="table-text bold">'.$deathsdeathsdeaths.'</p></a>';
echo '</div>';  

echo '<div class="table-row-item" style="display:table-cell;">';
echo '<a href="'.$domain2.'profil/'.$NameNameNameNameusername.'"><p class="table-text bold">'.$playedplayedplayed.'</p></a>';
echo '</div>';  
        
echo '</div>';

echo '</div>';

$i++; }
?>	   
      
    </div>
	
<?php } ?>
    <!-- /TABLE -->

    <!-- TABLE -->
<?php if($_REQUEST['p'] == 'murder'){ ?>

    <div class="table forum-topics">
      <div class="table-row-header">

        <div class="table-row-header-item padded-big" style="display:table-cell;">
          <p class="table-row-header-title">Sıra</p>
        </div>
        <div class="table-row-header-item padded-big" style="display:table-cell;">
          <p class="table-row-header-title">#</p>
        </div>
		<div class="table-row-header-item padded-big" style="display:table-cell;">
          <p class="table-row-header-title">İsim</p>
        </div>
        <div class="table-row-header-item padded-big" style="display:table-cell;">
          <p class="table-row-header-title">Kazanma</p>
        </div>
		<div class="table-row-header-item padded-big" style="display:table-cell;">
          <p class="table-row-header-title">Öldürme</p>
        </div>
		<div class="table-row-header-item padded-big" style="display:table-cell;">
          <p class="table-row-header-title">Ölme</p>
        </div>
		<div class="table-row-header-item padded-big" style="display:table-cell;">
          <p class="table-row-header-title">Skor</p>
        </div>
      </div>

<?php
$hostseceax 	=	"87.248.157.101:3306";
$userseceax 	=	"candycra_server";
$passseceax 	=	"GhzeR8aqX8yu#!"; 
$dbikiceacx		=	"candycra_Oyunlar";
$baglanuceacx = mysql_connect($hostseceax, $userseceax, $passseceax) or die (mysql_Error());

mysql_select_db($dbikiceacx, $baglanuceacx) or die (mysql_Error());

mysql_query("SET CHARACTER SET 'utf8'");
mysql_query("SET NAMES 'utf8'");
$eeecacee = mysql_query("SELECT * FROM MurderData  ORDER BY Wins DESC LIMIT 25",$baglanuceacx); 
$i=1;
while($ihqqsaneacxeee=mysql_fetch_assoc($eeecacee)) 
{  
$playernameplayernameplayername=$ihqqsaneacxeee["playername"]; 
$winswinswinswinswins=$ihqqsaneacxeee["wins"]; 
$KillsKillsKillkills=$ihqqsaneacxeee["kills"]; 
$deathsdeathsdedeathsaths=$ihqqsaneacxeee["deaths"]; 
$scorescorescorescore=$ihqqsaneacxeee["score"]; 

// 
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
$rank='<span class="tag-ornament" style="vertical-align:middle;margin-top: 0px;margin-left: 5px;background:'.$renk.';">'.$grupadi['name'].'</span>';



echo '<div class="table-rows">';

echo '<div class="table-row large">';
if($i == '1'){
	echo '<div class="table-row-item" style="width:52px;display:table-cell;">';
	echo '<p class="table-text bold"><img src="'.$domain2.'img/gold.png" style="width:32px;"></p>';
	echo '</div>';
}elseif($i == '2'){
	echo '<div class="table-row-item" style="width:52px;display:table-cell;">';
	echo '<p class="table-text bold"><img src="'.$domain2.'img/silver.png" style="width:32px;"></p>';
	echo '</div>';
}elseif($i == '3'){
	echo '<div class="table-row-item" style="width:52px;display:table-cell;">';
	echo '<p class="table-text bold"><img src="'.$domain2.'img/bronz.png" style="width:32px;"></p>';
	echo '</div>';
}else{
	echo '<div class="table-row-item" style="width:52px;display:table-cell;">';
	echo '<p class="table-text bold">'.$i.'</p>';
	echo '</div>';
}


echo '<div class="table-row-item" style="display:table-cell;">';
echo '<p class="table-text bold"><a href="'.$domain2.'profil/'.$playernameplayernameplayername.'"><img src="https://cravatar.eu/avatar/'.$playernameplayernameplayername.'" style="width:32px;"> </a></p>';
echo '</div>';

echo '<div class="table-row-item" style="display:table-cell;">';
echo '<a href="'.$domain2.'profil/'.$playernameplayernameplayername.'"><p class="table-text bold" style="text-transform:none;">'.$rank.'&nbsp;'.$playernameplayernameplayername.'</p></a>';
echo '</div>';
	  
echo '<div class="table-row-item" style="display:table-cell;">';
echo '<a href="'.$domain2.'profil/'.$playernameplayernameplayername.'"><p class="table-text bold">'.$winswinswinswinswins.'</p></a>';
echo '</div>';  

echo '<div class="table-row-item" style="display:table-cell;">';
echo '<a href="'.$domain2.'profil/'.$playernameplayernameplayername.'"><p class="table-text bold">'.$KillsKillsKillkills.'</p></a>';
echo '</div>';  

echo '<div class="table-row-item" style="display:table-cell;">';
echo '<a href="'.$domain2.'profil/'.$playernameplayernameplayername.'"><p class="table-text bold">'.$deathsdeathsdedeathsaths.'</p></a>';
echo '</div>';  

echo '<div class="table-row-item" style="display:table-cell;">';
echo '<a href="'.$domain2.'profil/'.$playernameplayernameplayername.'"><p class="table-text bold">'.$scorescorescorescore.'</p></a>';
echo '</div>';  
        
echo '</div>';

echo '</div>';

$i++; }
?>	   
      
    </div>
	
<?php } ?>
    <!-- /TABLE -->

    <!-- TABLE -->
<?php if($_REQUEST['p'] == 'buildbattle'){ ?>

    <div class="table forum-topics">
      <div class="table-row-header">

        <div class="table-row-header-item padded-big" style="display:table-cell;">
          <p class="table-row-header-title">Sıra</p>
        </div>
        <div class="table-row-header-item padded-big" style="display:table-cell;">
          <p class="table-row-header-title">#</p>
        </div>
		<div class="table-row-header-item padded-big" style="display:table-cell;">
          <p class="table-row-header-title">İsim</p>
        </div>
        <div class="table-row-header-item padded-big" style="display:table-cell;">
          <p class="table-row-header-title">Kazanma</p>
        </div>
		<div class="table-row-header-item padded-big" style="display:table-cell;">
          <p class="table-row-header-title">Oynanan Oyun</p>
        </div>
      </div>

<?php
$hostseceax 	=	"87.248.157.101:3306";
$userseceax 	=	"candycra_server";
$passseceax 	=	"GhzeR8aqX8yu#!"; 
$dbikiceacx		=	"candycra_Oyunlar";
$baglanuceacx = mysql_connect($hostseceax, $userseceax, $passseceax) or die (mysql_Error());

mysql_select_db($dbikiceacx, $baglanuceacx) or die (mysql_Error());
$eeeacacee = mysql_query("SELECT * FROM masterbuilders  ORDER BY Wins DESC, PlayedGames DESC LIMIT 25",$baglanuceacx); 
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
// 
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
$rank='<span class="tag-ornament" style="vertical-align:middle;margin-top: 0px;margin-left: 5px;background:'.$renk.';">'.$grupadi['name'].'</span>';

echo '<div class="table-rows">';

echo '<div class="table-row large">';
if($i == '1'){
	echo '<div class="table-row-item" style="width:52px;display:table-cell;">';
	echo '<p class="table-text bold"><img src="'.$domain2.'img/gold.png" style="width:32px;"></p>';
	echo '</div>';
}elseif($i == '2'){
	echo '<div class="table-row-item" style="width:52px;display:table-cell;">';
	echo '<p class="table-text bold"><img src="'.$domain2.'img/silver.png" style="width:32px;"></p>';
	echo '</div>';
}elseif($i == '3'){
	echo '<div class="table-row-item" style="width:52px;display:table-cell;">';
	echo '<p class="table-text bold"><img src="'.$domain2.'img/bronz.png" style="width:32px;"></p>';
	echo '</div>';
}else{
	echo '<div class="table-row-item" style="width:52px;display:table-cell;">';
	echo '<p class="table-text bold">'.$i.'</p>';
	echo '</div>';
}


echo '<div class="table-row-item" style="display:table-cell;">';
echo '<p class="table-text bold"><a href="'.$domain2.'profil/'.$player_nameplayer_nameplayer_nameplayer_name.'"><img src="https://cravatar.eu/avatar/'.$player_nameplayer_nameplayer_nameplayer_name.'" style="width:32px;"> </a></p>';
echo '</div>';

echo '<div class="table-row-item" style="display:table-cell;">';
echo '<a href="'.$domain2.'profil/'.$player_nameplayer_nameplayer_nameplayer_name.'"><p class="table-text bold" style="text-transform:none;">'.$rank.'&nbsp;'.$player_nameplayer_nameplayer_nameplayer_name.'</p></a>';
echo '</div>';
	  
echo '<div class="table-row-item" style="display:table-cell;">';
echo '<a href="'.$domain2.'profil/'.$player_nameplayer_nameplayer_nameplayer_name.'"><p class="table-text bold">'.$WinsWinsWinsWinsWinsWins.'</p></a>';
echo '</div>';  

echo '<div class="table-row-item" style="display:table-cell;">';
echo '<a href="'.$domain2.'profil/'.$player_nameplayer_nameplayer_nameplayer_name.'"><p class="table-text bold">'.$PlayedGamesPlayedGamesPlayedGamesPlayedGamesPlayedGamesPlayedGames.'</p></a>';
echo '</div>'; 
        
echo '</div>';

echo '</div>';

$i++; }
?>	   
      
    </div>
	
<?php } ?>
    <!-- /TABLE -->

    <!-- TABLE -->
<?php if($_REQUEST['p'] == 'speedbuilders'){ ?>

    <div class="table forum-topics">
      <div class="table-row-header">

        <div class="table-row-header-item padded-big" style="display:table-cell;">
          <p class="table-row-header-title">Sıra</p>
        </div>
        <div class="table-row-header-item padded-big" style="display:table-cell;">
          <p class="table-row-header-title">#</p>
        </div>
		<div class="table-row-header-item padded-big" style="display:table-cell;">
          <p class="table-row-header-title">İsim</p>
        </div>
        <div class="table-row-header-item padded-big" style="display:table-cell;">
          <p class="table-row-header-title">Kazanma</p>
        </div>     
		<div class="table-row-header-item padded-big" style="display:table-cell;">
          <p class="table-row-header-title">Mükemmel Uyum</p>
        </div> 
      </div>

<?php
$hostseceax 	=	"87.248.157.101:3306";
$userseceax 	=	"candycra_server";
$passseceax 	=	"GhzeR8aqX8yu#!"; 
$dbikiceacx		=	"candycra_Oyunlar";
$baglanuceacx = mysql_connect($hostseceax, $userseceax, $passseceax) or die (mysql_Error());

mysql_select_db($dbikiceacx, $baglanuceacx) or die (mysql_Error()); 
$eeeacacee = mysql_query("SELECT * FROM speedbuilders  ORDER BY wins DESC LIMIT 25",$baglanuceacx); 
$i=1;
while($ihqqsanceacxeee=mysql_fetch_assoc($eeeacacee)) 
{  
$UUIDusername=$ihqqsanceacxeee["username"]; 
$winscwins=$ihqqsanceacxeee["wins"]; 
$pbuildspbuildspbuilds=$ihqqsanceacxeee["pbuilds"];

// 
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
$rank='<span class="tag-ornament" style="vertical-align:middle;margin-top: 0px;margin-left: 5px;background:'.$renk.';">'.$grupadi['name'].'</span>';


echo '<div class="table-rows">';

echo '<div class="table-row large">';
if($i == '1'){
	echo '<div class="table-row-item" style="width:52px;display:table-cell;">';
	echo '<p class="table-text bold"><img src="'.$domain2.'img/gold.png" style="width:32px;"></p>';
	echo '</div>';
}elseif($i == '2'){
	echo '<div class="table-row-item" style="width:52px;display:table-cell;">';
	echo '<p class="table-text bold"><img src="'.$domain2.'img/silver.png" style="width:32px;"></p>';
	echo '</div>';
}elseif($i == '3'){
	echo '<div class="table-row-item" style="width:52px;display:table-cell;">';
	echo '<p class="table-text bold"><img src="'.$domain2.'img/bronz.png" style="width:32px;"></p>';
	echo '</div>';
}else{
	echo '<div class="table-row-item" style="width:52px;display:table-cell;">';
	echo '<p class="table-text bold">'.$i.'</p>';
	echo '</div>';
}


echo '<div class="table-row-item" style="display:table-cell;">';
echo '<p class="table-text bold"><a href="'.$domain2.'profil/'.$UUIDusername.'"><img src="https://cravatar.eu/avatar/'.$UUIDusername.'" style="width:32px;"> </a></p>';
echo '</div>';

echo '<div class="table-row-item" style="display:table-cell;">';
echo '<a href="'.$domain2.'profil/'.$UUIDusername.'"><p class="table-text bold" style="text-transform:none;">'.$rank.'&nbsp;'.$UUIDusername.'</p></a>';
echo '</div>';
	  
echo '<div class="table-row-item" style="display:table-cell;">';
echo '<a href="'.$domain2.'profil/'.$UUIDusername.'"><p class="table-text bold">'.$winscwins.'</p></a>';
echo '</div>';  
 
echo '<div class="table-row-item" style="display:table-cell;">';
echo '<a href="'.$domain2.'profil/'.$UUIDusername.'"><p class="table-text bold">'.$pbuildspbuildspbuilds.'</p></a>';
echo '</div>';  
 
echo '</div>';

echo '</div>';

$i++; }
?>	   
      
    </div>
	
<?php } ?>
    <!-- /TABLE -->

    <!-- TABLE -->
<?php if($_REQUEST['p'] == 'hungergames'){ ?>

    <div class="table forum-topics">
      <div class="table-row-header">

        <div class="table-row-header-item padded-big" style="display:table-cell;">
          <p class="table-row-header-title">Sıra</p>
        </div>
        <div class="table-row-header-item padded-big" style="display:table-cell;">
          <p class="table-row-header-title">#</p>
        </div>
		<div class="table-row-header-item padded-big" style="display:table-cell;">
          <p class="table-row-header-title">İsim</p>
        </div>
        <div class="table-row-header-item padded-big" style="display:table-cell;">
          <p class="table-row-header-title">Kazanma</p>
        </div>     
		<div class="table-row-header-item padded-big" style="display:table-cell;">
          <p class="table-row-header-title">Öldürme</p>
        </div>
		<div class="table-row-header-item padded-big" style="display:table-cell;">
          <p class="table-row-header-title">Ölme</p>
        </div>
		<div class="table-row-header-item padded-big" style="display:table-cell;">
          <p class="table-row-header-title">Oynanan oyun</p>
        </div>
      </div>

<?php
$hostseceax 	=	"87.248.157.101:3306";
$userseceax 	=	"candycra_server";
$passseceax 	=	"GhzeR8aqX8yu#!"; 
$dbikiceacx		=	"candycra_Oyunlar";
$baglanuceacx = mysql_connect($hostseceax, $userseceax, $passseceax) or die (mysql_Error());

mysql_select_db($dbikiceacx, $baglanuceacx) or die (mysql_Error()); 
$eeeacacee = mysql_query("SELECT * FROM sg_  ORDER BY Wins DESC LIMIT 25",$baglanuceacx); 
$i=1;
while($ihqqsanceacxeee=mysql_fetch_assoc($eeeacacee)) 
{  
$UUIDusernplayer_nameame=$ihqqsanceacxeee["player_name"]; 
$WinscWinscWins=$ihqqsanceacxeee["Wins"]; 
$KillscKillscKills=$ihqqsanceacxeee["Kills"]; 
$DeathscDeathscDeaths=$ihqqsanceacxeee["Deaths"]; 
$GamesplayedcGamesplayedcGamesplayed=$ihqqsanceacxeee["Gamesplayed"]; 

// 
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
$rank='<span class="tag-ornament" style="vertical-align:middle;margin-top: 0px;margin-left: 5px;background:'.$renk.';">'.$grupadi['name'].'</span>';


echo '<div class="table-rows">';

echo '<div class="table-row large">';
if($i == '1'){
	echo '<div class="table-row-item" style="width:52px;display:table-cell;">';
	echo '<p class="table-text bold"><img src="'.$domain2.'img/gold.png" style="width:32px;"></p>';
	echo '</div>';
}elseif($i == '2'){
	echo '<div class="table-row-item" style="width:52px;display:table-cell;">';
	echo '<p class="table-text bold"><img src="'.$domain2.'img/silver.png" style="width:32px;"></p>';
	echo '</div>';
}elseif($i == '3'){
	echo '<div class="table-row-item" style="width:52px;display:table-cell;">';
	echo '<p class="table-text bold"><img src="'.$domain2.'img/bronz.png" style="width:32px;"></p>';
	echo '</div>';
}else{
	echo '<div class="table-row-item" style="width:52px;display:table-cell;">';
	echo '<p class="table-text bold">'.$i.'</p>';
	echo '</div>';
}


echo '<div class="table-row-item" style="display:table-cell;">';
echo '<p class="table-text bold"><a href="'.$domain2.'profil/'.$UUIDusernplayer_nameame.'"><img src="https://cravatar.eu/avatar/'.$UUIDusernplayer_nameame.'" style="width:32px;"> </a></p>';
echo '</div>';

echo '<div class="table-row-item" style="display:table-cell;">';
echo '<a href="'.$domain2.'profil/'.$UUIDusernplayer_nameame.'"><p class="table-text bold" style="text-transform:none;">'.$rank.'&nbsp;'.$UUIDusernplayer_nameame.'</p></a>';
echo '</div>';
	  
echo '<div class="table-row-item" style="display:table-cell;">';
echo '<a href="'.$domain2.'profil/'.$UUIDusernplayer_nameame.'"><p class="table-text bold">'.$WinscWinscWins.'</p></a>';
echo '</div>';  

echo '<div class="table-row-item" style="display:table-cell;">';
echo '<a href="'.$domain2.'profil/'.$UUIDusernplayer_nameame.'"><p class="table-text bold">'.$KillscKillscKills.'</p></a>';
echo '</div>';  

echo '<div class="table-row-item" style="display:table-cell;">';
echo '<a href="'.$domain2.'profil/'.$UUIDusernplayer_nameame.'"><p class="table-text bold">'.$DeathscDeathscDeaths.'</p></a>';
echo '</div>';  

echo '<div class="table-row-item" style="display:table-cell;">';
echo '<a href="'.$domain2.'profil/'.$UUIDusernplayer_nameame.'"><p class="table-text bold">'.$GamesplayedcGamesplayedcGamesplayed.'</p></a>';
echo '</div>';  
        
echo '</div>';

echo '</div>';

$i++; }
?>	   
      
    </div>
	
<?php } ?>
    <!-- /TABLE -->

    <!-- TABLE -->
<?php if($_REQUEST['p'] == 'eggwars'){ ?>

    <div class="table forum-topics">
      <div class="table-row-header">

        <div class="table-row-header-item padded-big" style="display:table-cell;">
          <p class="table-row-header-title">Sıra</p>
        </div>
        <div class="table-row-header-item padded-big" style="display:table-cell;">
          <p class="table-row-header-title">#</p>
        </div>
		<div class="table-row-header-item padded-big" style="display:table-cell;">
          <p class="table-row-header-title">İsim</p>
        </div>
        <div class="table-row-header-item padded-big" style="display:table-cell;">
          <p class="table-row-header-title">Kazanma</p>
        </div>     
		<div class="table-row-header-item padded-big" style="display:table-cell;">
          <p class="table-row-header-title">Öldürme</p>
        </div>
		<div class="table-row-header-item padded-big" style="display:table-cell;">
          <p class="table-row-header-title">Oynanan Oyun</p>
        </div>
		<div class="table-row-header-item padded-big" style="display:table-cell;">
          <p class="table-row-header-title">Kırılan Yumurta</p>
        </div>
      </div>

<?php
$hostsece 	=	"87.248.157.101:3306";
$usersece 	=	"candycra_server";
$passsece 	=	"GhzeR8aqX8yu#!"; 
$dbikice	=	"candycra_Oyunlar";

$baglanuce = mysql_connect($hostsece, $usersece, $passsece) or die (mysql_Error());

mysql_select_db($dbikice, $baglanuce) or die (mysql_Error());

mysql_query("SET CHARACTER SET 'utf8'");
mysql_query("SET NAMES 'utf8'");
$eeec = mysql_query("SELECT * FROM eggwars_players  ORDER BY wins DESC LIMIT 25",$baglanuce); 
$i=1;
while($ihqqsane=mysql_fetch_assoc($eeec)) 
{  
$namename=$ihqqsane["name"]; 
$score=$ihqqsane["wins"];
$kills=$ihqqsane["kills"];
$oynanan=$ihqqsane["played"];
$yumurta=$ihqqsane["eggs"];

// 
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
$rank='<span class="tag-ornament" style="vertical-align:middle;margin-top: 0px;margin-left: 5px;background:'.$renk.';">'.$grupadi['name'].'</span>';

echo '<div class="table-rows">';

echo '<div class="table-row large">';
if($i == '1'){
	echo '<div class="table-row-item" style="width:52px;display:table-cell;">';
	echo '<p class="table-text bold"><img src="'.$domain2.'img/gold.png" style="width:32px;"></p>';
	echo '</div>';
}elseif($i == '2'){
	echo '<div class="table-row-item" style="width:52px;display:table-cell;">';
	echo '<p class="table-text bold"><img src="'.$domain2.'img/silver.png" style="width:32px;"></p>';
	echo '</div>';
}elseif($i == '3'){
	echo '<div class="table-row-item" style="width:52px;display:table-cell;">';
	echo '<p class="table-text bold"><img src="'.$domain2.'img/bronz.png" style="width:32px;"></p>';
	echo '</div>';
}else{
	echo '<div class="table-row-item" style="width:52px;display:table-cell;">';
	echo '<p class="table-text bold">'.$i.'</p>';
	echo '</div>';
}


echo '<div class="table-row-item" style="display:table-cell;">';
echo '<p class="table-text bold"><a href="'.$domain2.'profil/'.$namename.'"><img src="https://cravatar.eu/avatar/'.$namename.'" style="width:32px;"> </a></p>';
echo '</div>';

echo '<div class="table-row-item" style="display:table-cell;">';
echo '<a href="'.$domain2.'profil/'.$namename.'"><p class="table-text bold" style="text-transform:none;">'.$rank.'&nbsp;'.$namename.'</p></a>';
echo '</div>';
	  
echo '<div class="table-row-item" style="display:table-cell;">';
echo '<a href="'.$domain2.'profil/'.$namename.'"><p class="table-text bold">'.$score.'</p></a>';
echo '</div>';  

echo '<div class="table-row-item" style="display:table-cell;">';
echo '<a href="'.$domain2.'profil/'.$namename.'"><p class="table-text bold">'.$kills.'</p></a>';
echo '</div>'; 

echo '<div class="table-row-item" style="display:table-cell;">';
echo '<a href="'.$domain2.'profil/'.$namename.'"><p class="table-text bold">'.$oynanan.'</p></a>';
echo '</div>'; 

echo '<div class="table-row-item" style="display:table-cell;">';
echo '<a href="'.$domain2.'profil/'.$namename.'"><p class="table-text bold">'.$yumurta.'</p></a>';
echo '</div>'; 
        
echo '</div>';

echo '</div>';

$i++; }
?>	   
      
    </div>
	
<?php } ?>
    <!-- /TABLE -->

    <!-- TABLE -->
<?php if($_REQUEST['p'] == 'cehennemvadisi'){ ?>

    <div class="table forum-topics">
      <div class="table-row-header">

        <div class="table-row-header-item padded-big" style="display:table-cell;">
          <p class="table-row-header-title">Sıra</p>
        </div>
        <div class="table-row-header-item padded-big" style="display:table-cell;">
          <p class="table-row-header-title">#</p>
        </div>
		<div class="table-row-header-item padded-big" style="display:table-cell;">
          <p class="table-row-header-title">İsim</p>
        </div>
        <div class="table-row-header-item padded-big" style="display:table-cell;">
          <p class="table-row-header-title">Zombi Öldürme</p>
        </div> 
		<div class="table-row-header-item padded-big" style="display:table-cell;">
          <p class="table-row-header-title">Round Skoru</p>
        </div> 
		<div class="table-row-header-item padded-big" style="display:table-cell;">
          <p class="table-row-header-title">Canlandırma</p>
        </div> 
		<div class="table-row-header-item padded-big" style="display:table-cell;">
          <p class="table-row-header-title">Oynanan Oyun</p>
        </div> 
      </div>

<?php
$hostsece 	=	"87.248.157.101:3306";
$usersece 	=	"candycra_server";
$passsece 	=	"GhzeR8aqX8yu#!"; 
$dbikice	=	"candycra_Oyunlar";

$baglanuce = mysql_connect($hostsece, $usersece, $passsece) or die (mysql_Error());

mysql_select_db($dbikice, $baglanuce) or die (mysql_Error());

mysql_query("SET CHARACTER SET 'utf8'");
mysql_query("SET NAMES 'utf8'");
$eeec = mysql_query("SELECT * FROM ZombieSurvivalData ORDER BY Kills DESC LIMIT 25",$baglanuce); 
$i=1;
while($ihqqsane=mysql_fetch_assoc($eeec)) 
{  
$namename=$ihqqsane["Name"]; 
$kills=$ihqqsane["Kills"];
$roundskor=$ihqqsane["HighestRound"];
$canlandirma=$ihqqsane["Revives"];
$oynama=$ihqqsane["GamesPlayed"];

// 
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
$rank='<span class="tag-ornament" style="vertical-align:middle;margin-top: 0px;margin-left: 5px;background:'.$renk.';">'.$grupadi['name'].'</span>';


echo '<div class="table-rows">';

echo '<div class="table-row large">';
if($i == '1'){
	echo '<div class="table-row-item" style="width:52px;display:table-cell;">';
	echo '<p class="table-text bold"><img src="'.$domain2.'img/gold.png" style="width:32px;"></p>';
	echo '</div>';
}elseif($i == '2'){
	echo '<div class="table-row-item" style="width:52px;display:table-cell;">';
	echo '<p class="table-text bold"><img src="'.$domain2.'img/silver.png" style="width:32px;"></p>';
	echo '</div>';
}elseif($i == '3'){
	echo '<div class="table-row-item" style="width:52px;display:table-cell;">';
	echo '<p class="table-text bold"><img src="'.$domain2.'img/bronz.png" style="width:32px;"></p>';
	echo '</div>';
}else{
	echo '<div class="table-row-item" style="width:52px;display:table-cell;">';
	echo '<p class="table-text bold">'.$i.'</p>';
	echo '</div>';
}


echo '<div class="table-row-item" style="display:table-cell;">';
echo '<p class="table-text bold"><a href="'.$domain2.'profil/'.$namename.'"><img src="https://cravatar.eu/avatar/'.$namename.'" style="width:32px;"> </a></p>';
echo '</div>';

echo '<div class="table-row-item" style="display:table-cell;">';
echo '<a href="'.$domain2.'profil/'.$namename.'"><p class="table-text bold" style="text-transform:none;">'.$rank.'&nbsp;'.$namename.'</p></a>';
echo '</div>';
	  
echo '<div class="table-row-item" style="display:table-cell;">';
echo '<a href="'.$domain2.'profil/'.$namename.'"><p class="table-text bold">'.$kills.'</p></a>';
echo '</div>';  

echo '<div class="table-row-item" style="display:table-cell;">';
echo '<a href="'.$domain2.'profil/'.$namename.'"><p class="table-text bold">'.$roundskor.'</p></a>';
echo '</div>';  

echo '<div class="table-row-item" style="display:table-cell;">';
echo '<a href="'.$domain2.'profil/'.$namename.'"><p class="table-text bold">'.$canlandirma.'</p></a>';
echo '</div>';  

echo '<div class="table-row-item" style="display:table-cell;">';
echo '<a href="'.$domain2.'profil/'.$namename.'"><p class="table-text bold">'.$oynama.'</p></a>';
echo '</div>';  
        
echo '</div>';

echo '</div>';

$i++; }
?>	   
      
    </div>
	
<?php } ?>
    <!-- /TABLE -->
 
  </div>
  <!-- LAYOUT CONTENT FULL -->
<?php include_once('footer.php'); ?>