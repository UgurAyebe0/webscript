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
@media screen and (min-width:700px){
	.burasi{
		min-width:400px;
	}
}
.link-list-item a {
    font-size: .85em;
}
.table-row.large .table-row-item .table-text {
    font-size: .8875em;
}
@media screen and (max-width:700px){
	.burayigizle{
		display:none;
	}
}
</style>
<?php
$forumkategori = $db->prepare("select * from forumkategoriler where (kategorikodu = '".$_REQUEST['p']."')");
$result = $forumkategori->execute();
$forumkategori   = $forumkategori->fetch(PDO::FETCH_ASSOC);

$sayfada = 10;

$toplam_icerik = $db->prepare("select count(*) from forumkonular where (yayin = '1') && (forumkategori = '".$forumkategori['id']."') ");
$result = $toplam_icerik->execute();
$toplam_icerik   = $toplam_icerik->fetchColumn();

$toplam_sayfa = ceil($toplam_icerik / $sayfada);

$sayfa = isset($_GET['sayfa']) ? (int) $_GET['sayfa'] : 1;

if($sayfa < 1) $sayfa = 1; 
if($sayfa > $toplam_sayfa) $sayfa = $toplam_sayfa; 

$limit = ($sayfa - 1) * $sayfada;


?>

  <!-- BANNER WRAP -->
  <div class="banner-wrap forum-banner">
    <!-- BANNER -->
    <div class="banner grid-limit">
      <h2 class="banner-title">Forum</h2>
      <p class="banner-sections">
        <span class="banner-section">Anasayfa</span>
        <!-- ARROW ICON -->
        <svg class="arrow-icon">
          <use xlink:href="#svg-arrow"></use>
        </svg>
        <!-- /ARROW ICON -->
        <span class="banner-section">Forum</span>
        <!-- ARROW ICON -->
        <svg class="arrow-icon">
          <use xlink:href="#svg-arrow"></use>
        </svg>
        <!-- /ARROW ICON -->
        <span class="banner-section">Kategoriler</span>
		<!-- ARROW ICON -->
        <svg class="arrow-icon">
          <use xlink:href="#svg-arrow"></use>
        </svg>
        <!-- /ARROW ICON -->
        <span class="banner-section"><?php echo $forumkategori['kategori_TR']; ?></span>
      </p>
    </div>
    <!-- /BANNER -->
  </div>
  <!-- /BANNER WRAP -->
<?php include_once('slidenews.php'); ?>

  <!-- LAYOUT CONTENT FULL -->
  <div class="layout-content-full grid-limit">
    <!-- FILTERS ROW -->
    <div class="filters-row">
      <!-- OPTION LIST -->
      <div class="option-list">
		<!-- OPTION LIST ITEM -->
        <a href="<?php echo $domain2.'forumlar'; ?>"><p class="option-list-item">Tüm Kategoriler</p></a>
        <!-- /OPTION LIST ITEM -->
        <!-- OPTION LIST ITEM -->
        <p class="option-list-item selected"><?php echo $forumkategori['kategori_TR']; ?></p>
        <!-- /OPTION LIST ITEM -->

        

      </div>
      <!-- /OPTION LIST -->

      <!-- FORUM ACTIONS -->
      <div class="forum-actions">
        <!-- DROPDOWN SIMPLE WRAP -->
        <div class="dropdown-simple-wrap">
          <!-- CURRENT OPTION -->
          <div id="forums-search-dropdown-trigger" class="current-option">
            <!-- BUTTON -->
            <p class="button small red">Forumlarda Ara</p>
            <!-- /BUTTON -->
          </div>
          <!-- /CURRENT OPTION -->
  
          <!-- DP OPTIONS -->
          <div id="forums-search-dropdown" class="dp-options medium">
            <form class="form-wrap" action="<?php echo $domain2; ?>sonuc">
              <div class="form-row">
                <div class="form-item">
                  <div class="submit-input red">
                    <input type="text" id="forum_search_input" name="ara" placeholder="Ne aramıştınız?...">
                    <button class="submit-input-button">
                      <svg class="arrow-icon medium">
                        <use xlink:href="#svg-arrow-medium"></use>
                      </svg>
                    </button>
                  </div>
                </div>
              </div>
            </form>
          </div>
          <!-- /DP OPTIONS -->
        </div>
        <!-- /DROPDOWN SIMPLE WRAP -->
<?php
$kullanici = $kpanel->prepare("select * from Kullanicilar where (username = '".$_SESSION['username']."')");
$result = $kullanici->execute();
$kullanici  = $kullanici->fetch(PDO::FETCH_ASSOC);

if($kullanici['yasakli'] == '1'){
	
}elseif($_SESSION["login"] == "true"){
	if($forumkategori['yoneticiler'] == '1'){

$grupp = $yetkiler->prepare("select * from perm_playergroups where (playeruuid = :playeruuid) order by groupid desc");
$result = $grupp->execute(array(":playeruuid" => $_SESSION["uuid"]));
$grupp  = $grupp->fetch(PDO::FETCH_ASSOC);		
		if(($grupp['groupid'] == '11') or ($grupp['groupid'] == '12') or ($grupp['groupid'] == '13') or ($grupp['groupid'] == '14') or ($grupp['groupid'] == '15') or ($grupp['groupid'] == '16') or ($grupp['groupid'] == '17') or ($grupp['groupid'] == '18')){
			echo '<div class="mt-10 pull-right">';
				echo '<span> <button class="button small blue popup-create-topic-trigger" data-toggle="modal" data-target="#yenikonubaslat"><i class="fa fa-plus"></i> Yeni Konu Başlat</button></span>';
			echo '</div>';
		}else{
			
		}
		
	}else{
		echo '<div class="mt-10 pull-right">';
			echo '<span> <button class="button small blue popup-create-topic-trigger" data-toggle="modal" data-target="#yenikonubaslat"><i class="fa fa-plus"></i> Yeni Konu Başlat</button></span>';
		echo '</div>';
	}
	
}
?>
<?php
echo '<div id="yenikonubaslat" class="modal" style="z-index:6667;">';
  echo '<div class="modal-dialog" style="width:90%;">';
    echo '<div class="modal-content">';
	
      echo '<div class="modal-header">';
        echo '<button type="button" class="close" data-dismiss="modal">&times;</button>';
        echo '<h5 class="modal-title">Konunun açılacağı kategori:  '.$forumkategori['kategori_TR'].'</h5>';
      echo '</div>';
	  
      echo '<div class="modal-body">';
        echo '<form method="POST" class="comment-form">';
			echo '<div class="comment-cont clearfix">';
			echo '<div class="youplay-input">';
				echo '<input type="text" placeholder="Başlık Belirtiniz" name="yenikonu" required>';
			echo '</div>';
				echo '<div class="" style="margin-top:15px;">';
					echo '<textarea class="top ckeditor" name="forummesaj" required></textarea>';
				echo '</div>';
				
			echo '</div>';
		
      echo '</div>';
	  
      echo '<div class="modal-footer">';
        echo '<button onclick = this.form.submit(); class="button blue" name="mesajkaydet" style="margin-top:10px;">Konuyu Kaydet</button>';
		echo '</form>';
      echo '</div>';
	  
    echo '</div>';
  echo '</div>';
echo '</div>';


if($_POST['yenikonu'] != ''){
	$yenikonu = strip_tags($_POST['yenikonu']);
	$icerik = $_POST['forummesaj'];
	$kat = $forumkategori['id'];
	$uuid = $_SESSION['uuid'];
	$user = $_SESSION['username'];
	$stamp = time();
	$yayin = '1';
	$sabit = '0';
	if($icerik != ''){
	$db->query("insert into forumkonular (username, forumkategori, baslik, yorum, yayin, stamp, uuid, sabit) values ('$user', '$kat', '$yenikonu', '$icerik', '$yayin', '$stamp', '$uuid', '$sabit')");
	
		/**/
		$sonid = $db->prepare("select * from forumkonular where (username = '".$user."') order by id desc limit 1");
		$result = $sonid->execute();
		$sonid  = $sonid->fetch(PDO::FETCH_ASSOC);
		
		$usernamee = $_SESSION["username"];
		$konuu = $sonid['id'];
		$forummesajj = $_POST['forummesaj'];
		$zaman = time();
		$uuidd = $_SESSION['uuid'];
		$bubirkonu = '1';

		$db->query("insert into forummesajlar (username, konuid, mesaj, yayin, stamp, uuid, gosterme) values ('$usernamee','$konuu','$forummesajj','1','$zaman','$uuidd','$bubirkonu')");
		
		$mesajkontrol = $db->prepare("select * from encokmesaj where (uuid = '".$uuidd."')");
		$result = $mesajkontrol->execute();
		$mesajkontrol  = $mesajkontrol->fetch(PDO::FETCH_ASSOC);
		
		if($mesajkontrol != NULL){
			$sayi = $mesajkontrol['mesajsayi'] + 1;
			$db->query("update encokmesaj set mesajsayi = '$sayi', stamp = '$zaman' where (uuid = '$uuidd')");

		}else{
			$db->query("insert into encokmesaj (username, uuid, mesajsayi, stamp) values ('$usernamee','$uuidd','1','$zaman')");
		}
	
		/**/
	
	$_SESSION['konukaydedildi'] = 'Açtığınız konu yayına alınmıştır.';
	
	}else{
		$_SESSION['konukaydedildi'] = 'Hata: Konu kaydedilmedi. Lütfen içeriği boş bırakmayınız.';	
	}
	header('Location:'.$domain2.'forumkategori/'.$forumkategori['kategorikodu']);
	
	
}



?>

      </div>
      <!-- /FORUM ACTIONS -->
    </div>
    <!-- /FILTERS ROW -->
<?php 
if($_SESSION['konukaydedildi'] != ''){
	echo '<div class="alert alert-success" role="alert">'.$_SESSION['konukaydedildi'].'</div>';
	$_SESSION['konukaydedildi'] = '';
}

?>  

    <!-- TABLE -->
    <div class="table forum-topics">
      <!-- TABLE ROW HEADER -->
      <div class="table-row-header">
        <!-- TABLE ROW HEADER ITEM -->
        <div class="table-row-header-item left">
          <p class="table-row-header-title">Konu</p>
        </div>
        <!-- /TABLE ROW HEADER ITEM -->





        <!-- TABLE ROW HEADER ITEM -->
        <div class="table-row-header-item padded-big">
          <p class="table-row-header-title">Mesaj</p>
        </div>
        <!-- /TABLE ROW HEADER ITEM -->

        <!-- TABLE ROW HEADER ITEM -->
        <div class="table-row-header-item padded-big">
          <p class="table-row-header-title">Güncelleme</p>
        </div>
        <!-- /TABLE ROW HEADER ITEM -->

       
      </div>
      <!-- /TABLE ROW HEADER -->

      <!-- TABLE ROWS -->
      <div class="table-rows">
<?php

$forumkonularr = $db->query("select * from forumkonular where (yayin = '1') && (forumkategori = '".$forumkategori['id']."') order by stamp desc LIMIT ".$limit." , ".$sayfada."");
foreach($forumkonularr as $forumkonuu){
		
$mesajyazan = $kpanel->prepare("select * from Kullanicilar where (username = '".$forumkonuu['username']."')");
$result = $mesajyazan->execute();
$mesajyazan   = $mesajyazan->fetch(PDO::FETCH_ASSOC);

$grup = $yetkiler->prepare("select * from perm_playergroups where (playeruuid = '".$mesajyazan["uuid"]."') && (groupid != '16') && (groupid != '17') && (groupid != '18')  order by groupid desc");
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
  
	echo '<div class="table-row large">';
	  echo '<div class="table-row-item">';
		echo '<a href="'.$domain2.'forumdetay/'.$forumkategori['id'].'/'.$forumkonuu['id'].'" class="forum-post-link" style="color:#363636;">'.mb_substr(strip_tags($forumkonuu['baslik']),0,'54','utf-8').'...</a>';
		echo '<p class="forum-post-description-preview">';
		echo '<a class="table-text bold light" style="text-align:left;text-transform:none;margin-top:10px;margin-bottom:10px;" href="'.$domain2.'forumdetay/'.$forumkategori['id'].'/'.$forumkonuu['id'].'">'.mb_substr(strip_tags($forumkonuu['yorum']),0,'120','utf-8').'...</a>';
		echo '</p>';
		echo '<p>';
		
		echo '<div class="team-info-wrap">';
		  echo '<img class="team-logo small gizle" src="https://cravatar.eu/avatar/'.$forumkonuu['username'].'" alt="'.$forumkonuu['username'].'">';
		  echo '<div class="team-info">';
			echo '<a href="'.$domain2.'profil/'.$forumkonuu['username'].'" style="color: #363636;"><p class="team-country" style="color: #363636;line-height: 1em;font-size: .875em;font-family: \'Exo\',sans-serif;font-weight: 700;text-transform:none;">'.$forumkonuu['username'].' <span class="tag-ornament gizle" style="vertical-align:middle;margin-top: 0px;margin-left: 5px;background:'.$renk.';">'.$grupadi['name'].'</span> <span class="light small text-muted" style="font-size: 10px;padding-left:10px;"><i class="fa fa-calendar"></i> '.date("d.m.Y H:i",$forumkonuu['stamp']).'</span></a> </p>';
		  echo '</div>';
		echo '</div>';

		
		echo '</p>';
	  echo '</div>';
$mesajsayii = $db->prepare("select count(*) from forummesajlar where (yayin = '1') && (konuid = '".$forumkonuu['id']."')");
$result = $mesajsayii->execute();
$mesajsayi   = $mesajsayii->fetchColumn();
	  echo '<div class="table-row-item">';
		echo '<p class="table-text bold">'.$mesajsayi.'</p>';
	  echo '</div>';
echo '<div class="table-row-item" style="width:350px;">';
#güncelleme
$sonmesajj = $db->prepare("select * from forummesajlar where (konuid = :konuid) && (yayin = '1') order by stamp desc limit 1");
$result = $sonmesajj->execute(array(":konuid" => $forumkonuu['id']));
$sonmesaj   = $sonmesajj->fetch(PDO::FETCH_ASSOC);
if($sonmesaj['username'] != ''){
$mesajyazan = $kpanel->prepare("select * from Kullanicilar where (username = '".$sonmesaj['username']."')");
$result = $mesajyazan->execute();
$mesajyazan  = $mesajyazan->fetch(PDO::FETCH_ASSOC);
	
$grup = $yetkiler->prepare("select * from perm_playergroups where (playeruuid = '".$mesajyazan["uuid"]."') && (groupid != '16') && (groupid != '17') && (groupid != '18') order by groupid desc");
$result = $grup->execute();
$grup  = $grup->fetch(PDO::FETCH_ASSOC);

$grupadi = $yetkiler->prepare("select * from perm_groups where (id = '".$grup['groupid']."')");
$result = $grupadi->execute();
$grupadi  = $grupadi->fetch(PDO::FETCH_ASSOC);

$secilikonuu = $db->prepare("select * from forumkonular where (id = '".$sonmesaj['konuid']."')");
$result = $secilikonuu->execute();
$secilikonu   = $secilikonuu->fetch(PDO::FETCH_ASSOC);
$secilikategorii = $db->prepare("select * from forumkategoriler where (id = '".$secilikonu['forumkategori']."')");
$result = $secilikategorii->execute();
$secilikategori = $secilikategorii->fetch(PDO::FETCH_ASSOC);


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
	
	echo '<div class="team-info-wrap">';
	  echo '<img class="team-logo small gizle" src="https://cravatar.eu/avatar/'.$sonmesaj['username'].'" alt="'.$sonmesaj['username'].'">';
	  echo '<div class="team-info">';
		echo '<a href="'.$domain2.'profil/'.$sonmesaj['username'].'" style="color: #363636;"><p class="team-country" style="color: #363636;line-height: 1em;font-size: .875em;font-family: \'Exo\',sans-serif;font-weight: 700;text-transform:none;">'.$sonmesaj['username'].' <span class="tag-ornament gizle" style="vertical-align:middle;margin-top: 0px;margin-left: 5px;background:'.$renk.';">'.$grupadi['name'].'</span> <span class="light small text-muted" style="font-size: 10px;padding-left:10px;"><i class="fa fa-calendar"></i> '.date("d.m.Y H:i",$sonmesaj['stamp']).'</span></a> </p>';
	  echo '</div>';
	echo '</div>';


			

	echo '<a class="table-text bold light" style="text-align:left;text-transform:none;margin-top:10px;" href="'.$domain2.'forumdetay/'.$secilikategori['id'].'/'.$sonmesaj['konuid'].'" >'.mb_substr(strip_tags($sonmesaj['mesaj']),0,'220','utf-8').'...</a>';
 
}else{  
	echo '<p class="table-text bold light">Henüz mesaj yok</p>';
}

	  echo '</div>';          
	echo '</div>';


}

?>	  
        

        
      </div>
      <!-- /TABLE ROWS -->
    </div>
    <!-- /TABLE -->

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
<a href="<?php echo $domain2.'forumkategori/'.$forumkategori['kategorikodu']; ?>?sayfa=<?php echo $sayfa-1; ?>" aria-controls="bootstrap-data-table" data-dt-idx="0" tabindex="0" class="page-link">
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
						<a class="page-navigation-item" href="<?php echo $domain2.'forumkategori/'.$forumkategori['kategorikodu']; ?>?sayfa=<?php echo $s; ?>" aria-controls="bootstrap-data-table" data-dt-idx="1" tabindex="0" class="page-link"><?php echo $s; ?></a>
					<?php
					}
				}
				
if($sayfa != $toplam_sayfa) {				
				
?>
<a href="<?php echo $domain2.'forumkategori/'.$forumkategori['kategorikodu']; ?>?sayfa=<?php echo $sayfa+1; ?>" aria-controls="bootstrap-data-table" data-dt-idx="0" tabindex="0" class="page-link">
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
  </div>
  <!-- LAYOUT CONTENT FULL -->
<?php include_once('footer.php'); ?>