<style>
@media screen and (max-width:1260px){
	.layout-sidebar.layout-item.gutter-medium{
		display:block !important;
	}
	.section-title.medium{
		margin-top:20px !important;
	}

}
</style>
<div class="layout-sidebar layout-item gutter-medium">

      <div class="widget-sidebar bunugizle">
        <form method="GET" class="sidebar-search-form" action="<?php echo $domain2; ?>oyuncuara">
          <div class="submit-input full blue">
		  
            <input type="text" id="sidebar-search1" name="ara" placeholder="Oyuncularda Ara...">
            <button class="submit-input-button">
              <svg class="search-icon small">
                <use xlink:href="#svg-search"></use>
              </svg>
            </button>
          </div>
        </form>
      </div>
      <div class="widget-sidebar">
        <div class="section-title-wrap violet small-space">
          <h2 class="section-title medium" style="margin-top: 0px;">Sunucu Durumu</h2>
          <div class="section-title-separator"></div>
        </div>

		 <div class="team-info-wrap" style="background-image:url('<?php echo $domain2; ?>img/bg123.jpg');background-size:cover;min-height:200px;padding-top: 25px;">
		 <p style="width:100%;text-align:center;font-size: 0.9em;"> 
			<span style="color: #fff;font-size: 13px;font-weight: 700;">IP:</span> <span style="color: #ffb400;font-size: 15px;font-weight: 700;">mc.candycraft.net</span>
		 </p><br>
		 <p style="width:100%;text-align:center;"><button onclick="window.location='<?php echo $domain2.'macerayakatil'; ?>'" class="button violet" ><i class="fa fa-gamepad" style="font-size:20px;margin-right: 10px;float: left;margin-top: 11px;"></i> MACERAYA KATIL
		 <div class="button-ornament">
		  <svg class="arrow-icon medium">
			<use xlink:href="#svg-arrow-medium"></use>
		  </svg>
		  <svg class="cross-icon small">
			<use xlink:href="#svg-cross-small"></use>
		  </svg>
		 </div>
		 </button></p><br>
		 <p style="width:100%;text-align:center;font-size: 0.9em;"> 
<?php 
$jsondata = file_get_contents("https://api.minetools.eu/ping/play.candycraft.net/25565");
$array = json_decode($jsondata,true);
$online = $array['players']['online'];
?>		
<span style="color: #ffb400;font-size: 15px;font-weight: 700;"><?php echo $online; ?></span> <span style="color: #fff;font-size: 13px;font-weight: 700;">Kişi Oynuyor</span>	
		 </p><br>
		 </div>
		 
      </div>
<?php
$anketler = $db->query("select * from anketsoru where (yayin = '1')");
foreach($anketler as $anket){
	#$cevapkontrol['kullanici'] = '';
	echo '<div class="widget-sidebar">';
        echo '<div class="section-title-wrap violet small-space">';
          echo '<h2 class="section-title medium" style="margin-top: 0px;">Anket</h2>';
          echo '<div class="section-title-separator"></div>';
        echo '</div>';
		echo '<p class="post-preview-title" style="font-size: 13px;text-transform: none;">'.$anket['soru'].'</p>';

$cevaplar = $db->query("select * from anketcevap where (yayin = '1') && (anketid = '".$anket['id']."') order by sira asc");
$cevapkontrol = $db->prepare("select * from anketkullanici where (kullanici = '".$_SESSION['username']."') && (anketid = '".$anket['id']."')");
$result = $cevapkontrol->execute();
$cevapkontrol  = $cevapkontrol->fetch(PDO::FETCH_ASSOC);

if(($_SESSION['username'] != '') && ($cevapkontrol['kullanici'] == '')){
echo '<form method="POST">';
foreach($cevaplar as $cevap){	
		echo '<div class="radio-item" style="width:100%;margin-top:10px;">'; 
		  echo '<input type="radio" id="sc_radio_'.$cevap['id'].'" name="sc_r_1" value="'.$cevap['id'].'" required>'; 
		  echo '<div class="radio-circle blue"></div>'; 
		  echo '<label for="sc_radio_'.$cevap['id'].'" class="rl-label">'.$cevap['cevap'].'</label>'; 
		echo '</div>';
}	
echo '<input type="submit" name="anketioyla_'.$anket['id'].'" value="Oy Ver" class="button violet small" style="margin:0 auto;margin-top:10px;">';
echo '</form>';	 
if($_POST['anketioyla_'.$anket['id'].'']){
	$anketid = $anket['id'];
	$cevapid = $_POST['sc_r_1'];
	$zaman = time();
	$kullanici = $_SESSION['username'];	
	$db->query("insert into anketkullanici (anketid, kullanici, cevapid, stamp) values ('$anketid', '$kullanici', '$cevapid', '$zaman') ");
$anketc = $db->prepare("select * from anketcevap where (id = '".$cevapid."') && (anketid = '".$anketid."')");
$result = $anketc->execute();
$anketc  = $anketc->fetch(PDO::FETCH_ASSOC);
$yenioy = $anketc['oy'] + 1;
$db->query("update anketcevap set oy = '".$yenioy."' where (id = '".$cevapid."') && (anketid = '".$anketid."')");
$url = $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
header('Location:https://'.$url);
	
}
}else{  
$cevaplarr = $db->query("select * from anketcevap where (yayin = '1') && (anketid = '".$anket['id']."') order by sira asc");
foreach($cevaplarr as $cevapp){
$toplamoy += $cevapp['oy'];
}
$cevaplarrr = $db->query("select * from anketcevap where (yayin = '1') && (anketid = '".$anket['id']."') order by sira asc");
foreach($cevaplarrr as $cevappp){
$yuzde = ($cevappp['oy'] * 100) / $toplamoy;
echo '<p style="margin-top: 5px;font-size: 12px;font-weight: 401;">'.$cevappp['cevap'].' ('.$cevappp['oy'].')</p>';
echo '<div class="progress" style="height: 10px;margin-bottom: 10px;">';
	echo '<div class="progress-bar" role="progressbar" aria-valuenow="'.$yuzde.'" aria-valuemin="0" aria-valuemax="100" style="width:'.$yuzde.'%">';
	echo '</div>';
echo '</div>';
}
}
    echo '</div>';
}
?>	  
      <div class="widget-sidebar">
        <div class="section-title-wrap violet small-space">
          <h2 class="section-title medium" style="margin-top: 0px;">Son Forum Konuları</h2>
          <div class="section-title-separator"></div>
        </div>
		<div class="table standings" style="margin-bottom: 0px;">
          <div class="table-rows">
<?php
$forumkon = $db->query("select * from forumkonular where (yayin = '1') order by stamp desc limit 5;");
$forumkon->execute();
$forumkon = $forumkon->fetchAll();
foreach($forumkon as $forkon){

if($forkon['username'] != ''){
$secilikat = $db->prepare("select * from forumkategoriler where (id = '".$forkon['forumkategori']."')");
$result = $secilikat->execute();
$secilikat = $secilikat->fetch(PDO::FETCH_ASSOC);

$mesajyazannnn = $kpanel->prepare("select * from Kullanicilar where (username = '".$forkon['username']."')");
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
	echo '<div class="table-row">';
	  echo '<div class="table-row-item position">';
		echo '<div class="team-info-wrap">';
		  echo '<img class="team-logo small" src="https://cravatar.eu/avatar/'.$forkon['username'].'" alt="'.$forkon['username'].'">';
		  echo '<div class="team-info">';
			echo '<p class="team-name"><a href="'.$domain2.'forumdetay/'.$secilikat['id'].'/'.$forkon['id'].'" style="color: #363636;">'.mb_substr(strip_tags($forkon['yorum']),0,'25','utf-8').'...</a></p>';
			echo '<a href="'.$domain2.'profil/'.$forkon['username'].'" style="color:'.$renkkkk.' !important;"><p class="team-country" style="font-size: .8em;color:'.$renkkkk.' !important;">'.$forkon['username'].' <span class="tag-ornament" style="vertical-align:middle;margin-top: 0px;margin-left: 5px;background:'.$renkkkk.';">'.$grupadiiii['name'].'</span></a></p>';
		  echo '</div>';
		echo '</div>';
	  echo '</div>';
	  echo '<div class="table-row-item">';
	  echo '</div>';
	echo '</div>';

	}
	}

?>
          </div>
        </div>
      </div>
      <div class="widget-sidebar">

        <div class="section-title-wrap violet small-space">
          <h2 class="section-title medium" style="margin-top: 0px;">Son Forum Mesajları</h2>
          <div class="section-title-separator"></div>
        </div>

		<div class="table standings" style="margin-bottom: 0px;">
          <div class="table-rows">
<?php
$forumkonular = $db->query("select * from forummesajlar where (yayin = '1') && (gosterme = '0') order by stamp desc limit 5;");
$forumkonular->execute();
$forumkonular = $forumkonular->fetchAll();

	foreach($forumkonular as $forumkonu){
		if($forumkonu['username'] != ''){
$secilikonuu = $db->prepare("select * from forumkonular where (id = '".$forumkonu['konuid']."')");
$result = $secilikonuu->execute();
$secilikonu   = $secilikonuu->fetch(PDO::FETCH_ASSOC);

$secilikategorii = $db->prepare("select * from forumkategoriler where (id = '".$secilikonu['forumkategori']."')");
$result = $secilikategorii->execute();
$secilikategori = $secilikategorii->fetch(PDO::FETCH_ASSOC);

$mesajyazan = $kpanel->prepare("select * from Kullanicilar where (username = '".$forumkonu['username']."')");
$result = $mesajyazan->execute();
$mesajyazan  = $mesajyazan->fetch(PDO::FETCH_ASSOC);

$grup = $yetkiler->prepare("select * from perm_playergroups where (playeruuid = '".$mesajyazan["uuid"]."') && (groupid != '16') && (groupid != '17') && (groupid != '18') order by groupid desc");
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
	echo '<div class="table-row">';
	  echo '<div class="table-row-item position">';
		echo '<div class="team-info-wrap">';
		  echo '<img class="team-logo small" src="https://cravatar.eu/avatar/'.$forumkonu['username'].'" alt="'.$forumkonu['username'].'">';
		  echo '<div class="team-info">';
			echo '<p class="team-name"><a href="'.$domain2.'forumdetay/'.$secilikategori['id'].'/'.$forumkonu['konuid'].'" style="color: #363636;">'.mb_substr(strip_tags($forumkonu['mesaj']),0,'25','utf-8').'...</a></p>';
			echo '<a href="'.$domain2.'profil/'.$forumkonu['username'].'" style="color:'.$renk.' !important;"><p class="team-country" style="font-size: .8em;color:'.$renk.'">'.$forumkonu['username'].' <span class="tag-ornament" style="vertical-align:middle;margin-top: 0px;margin-left: 5px;background:'.$renk.';">'.$grupadi['name'].'</span></a></p>';
		  echo '</div>';  
		echo '</div>';
	  echo '</div>';
	  echo '<div class="table-row-item">';
	  echo '</div>';
	echo '</div>';

}
}
?>
          </div>
        </div>
      </div>

      <div class="widget-sidebar">
        <div class="section-title-wrap violet small-space">
          <h2 class="section-title medium" style="margin-top: 0px;">Son Kredi Yükleyenler</h2>
          <div class="section-title-separator"></div>
        </div>
        <div class="table standings" style="margin-bottom: 0px;">
          <div class="table-row-header">
            <div class="table-row-header-item position">
              <p class="table-row-header-title">Kullanıcı Adı</p>
            </div>
            <div class="table-row-header-item position">
              <p class="table-row-header-title">Miktar</p>
            </div>
            <div class="table-row-header-item">
              <p class="table-row-header-title">Ödeme</p>
            </div>

          </div>
          <div class="table-rows">
<?php
$krediloglar = $kpanel->query("select * from KrediYuklemeLog order by Tarih desc limit 5");
$krediloglar->execute();
$krediloglar = $krediloglar->fetchAll();

foreach($krediloglar as $log){

if($log['OdemeKanali'] == '1'){
	$odemeturu = '<i class="fa fa-mobile"></i>';
}elseif($log['OdemeKanali'] == '2'){
	$odemeturu = '<i class="fa fa-credit-card"></i>';
}elseif($log['OdemeKanali'] == '3'){
	$odemeturu = '<i class="fa fa-university"></i>';
}elseif($log['OdemeKanali'] == '6'){
	$odemeturu = 'Oxoyun Elektonik Kod';
}elseif($log['OdemeKanali'] == '9'){
	$odemeturu = 'Gpay E-Cüzdan';
}elseif($log['OdemeKanali'] == '11'){
	$odemeturu = '<i class="fa fa-credit-card"></i>';
}elseif($log['OdemeKanali'] == '12'){
	$odemeturu = '<i class="fa fa-credit-card"></i>';
}elseif($log['OdemeKanali'] == '13'){
	$odemeturu = '<i class="fa fa-money"></i>';
}


 $sql = $kpanel->prepare("select * from Kullanicilar where (KullaniciId = :KullaniciId) limit 1;");
 $result = $sql->execute(array(":KullaniciId" => $log['KullaniciId']));
 $user   = $sql->fetch(PDO::FETCH_ASSOC);
 
 
$grup = $yetkiler->prepare("select * from perm_playergroups where (playeruuid = '".$user["uuid"]."') && (groupid != '16') && (groupid != '17') && (groupid != '18') order by groupid desc");
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


	echo '<div class="table-row">';
	  echo '<div class="table-row-item position">';
	   echo '<a href="'.$domain2.'profil/'.$user['username'].'" style="color:'.$renk.'">';
		echo '<div class="team-info-wrap">';
		  echo '<img class="team-logo small" src="https://cravatar.eu/avatar/'.$user['username'].'" alt="'.$user['username'].'">';
		  echo '<div class="team-info">';
			echo '<p class="team-name" style="text-transform:none;color:'.$renk.'">'.$user['username'].'</p>';
			echo '<p class="team-country">'.$grupadi['name'].'</p>';
		  echo '</div>';
		echo '</div>';
	  echo '</div>';  
	  echo '<div class="table-row-item">';
		echo '<p class="table-text bold">'.$log['VerilenTutar'].'</p>';
		
	  echo '</div>';
	  echo '<div class="table-row-item">';
		echo '<p class="table-text bold" style="font-size:0.8em;">'.$odemeturu.'</p>';
		
	  echo '</div>';
	  echo '</a>';
	echo '</div>';
	
	}

?>
          </div>
        </div>
      </div>

      <div class="widget-sidebar">
        <div class="section-title-wrap violet small-space">
          <h2 class="section-title medium" style="margin-top: 0px;">En Çok Kredi Yükleyenler</h2>
          <div class="section-title-separator"></div>
        </div>
        <div class="table standings" style="margin-bottom: 0px;">
          <div class="table-row-header">
            <div class="table-row-header-item position">
              <p class="table-row-header-title">Kullanıcı Adı</p>
            </div>
            <div class="table-row-header-item">
              <p class="table-row-header-title">Yüklenen</p>
            </div>
          </div>
          <div class="table-rows">
<?php
$host="87.248.157.101";
$kullaniciadi="candycra_site";
$sifre="pw9ND4pZXY4o@!";
$veritabaniadi="candycra_kpanel";

$baglanti = @mysql_connect($host, $kullaniciadi, $sifre);
$veritabani = @mysql_select_db($veritabaniadi);
$gun = date("Y-m-d 23:59:59", time());
$aybasi = date('Y-m-01 00:00:00',time());
$sql = "select KullaniciId, count(*)  as kredisayisi from KrediYuklemeLog where Tarih between '".$aybasi."' AND '".$gun."' group by KullaniciId order by sum(VerilenTutar) desc limit 5";

if($query = mysql_query($sql))
{
	while ($row = mysql_fetch_assoc($query))
	{
$oyuncu = $kpanel->prepare("select * from Kullanicilar where (KullaniciId = :KullaniciId)");
$result = $oyuncu->execute(array(":KullaniciId" => $row['KullaniciId']));
$oyuncu  = $oyuncu->fetch(PDO::FETCH_ASSOC);		

$krediler = $kpanel->query("select * from KrediYuklemeLog where (KullaniciId = '".$oyuncu['KullaniciId']."') && (Tarih between '".$aybasi."' AND '".$gun."')");	
$krediler->execute();
$krediler = $krediler->fetchAll();
$toplam = 0;	
foreach($krediler as $kre){
	$toplam += $kre['VerilenTutar'];
}
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


	echo '<div class="table-row">';
	  echo '<div class="table-row-item position">';
	   echo '<a href="'.$domain2.'profil/'.$oyuncu['username'].'" style="color:'.$renk.'">';
		echo '<div class="team-info-wrap">';
		  echo '<img class="team-logo small" src="https://cravatar.eu/avatar/'.$oyuncu['username'].'" alt="'.$oyuncu['username'].'">';
		  echo '<div class="team-info">';
			echo '<p class="team-name" style="text-transform:none;color:'.$renk.'">'.$oyuncu['username'].'</p>';
			echo '<p class="team-country">'.$grupadi['name'].'</p>';
		  echo '</div>';
		echo '</div>';
	  echo '</div>';
	  echo '<div class="table-row-item">';
		echo '<p class="table-text bold">'.$toplam.'</p>';
		echo '</a>';
	  echo '</div>';
	echo '</div>';
	
	}
	
}

?>
          </div>
          <!-- /TABLE ROWS -->
        </div>
<p class="team-name" ><b>Not:</b> Tablo her ay sonunda sıfırlanır. 
1. ye 50 kredi, 2. ye 25 kredi, 3. ye 10 kredi ödülü verilir.</p>        
<!-- /TABLE -->
      </div>
      <!-- /WIDGET SIDEBAR -->

	  
	  
	  
	  
      <!-- WIDGET SIDEBAR -->
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


      <!--<div class="widget-sidebar">
        <div class="section-title-wrap red">
          <h2 class="section-title medium">Instagram</h2>
          <div class="section-title-separator"></div>
        </div>
        <div class="photo-list"></div>
      </div>-->


    </div>