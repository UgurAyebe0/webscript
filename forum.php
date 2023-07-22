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
        <p class="option-list-item selected">Tüm Kategoriler</p>
        <!-- /OPTION LIST ITEM -->

        <!-- OPTION LIST ITEM 
        <p class="option-list-item">Yeni (0)</p>
        <!-- /OPTION LIST ITEM -->

        <!-- OPTION LIST ITEM 
        <p class="option-list-item">Okunmayan (0)</p>
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
      </div>
      <!-- /FORUM ACTIONS -->
    </div>
    <!-- /FILTERS ROW -->

    <!-- TABLE -->
    <div class="table forum-categories">
      <div class="table-row-header">
        <div class="table-row-header-item left">
          <p class="table-row-header-title">Kategoriler</p>
        </div>
        <div class="table-row-header-item padded-large burayigizle">
          <p class="table-row-header-title">Konu</p>
        </div>
        <div class="table-row-header-item padded-large">
          <p class="table-row-header-title">Mesaj</p>
        </div>
        <div class="table-row-header-item left">
          <p class="table-row-header-title">Güncelleme</p>
        </div>
      </div>

      <div class="table-rows no-color">
<?php
$forumkonular = $db->query("select * from forumkategoriler where (yayin = '1') && (alt_id = '0')");
foreach($forumkonular as $anakonu){
	$i = 0;
	$ii = $db->prepare("select count(*) from forumkonular where (forumkategori = :forumkategori) && (yayin = '1')");
	$result = $ii->execute(array(":forumkategori" => $anakonu['id']));
	$i   = $ii->fetchColumn();
	echo '<div class="table-row large">';
	  echo '<div class="table-row-item burasi">';
		echo '<div class="forum-category-wrap">';
		  echo '<span class="forum-category-title">'.$anakonu['kategori_TR'].'</span>';
		  echo '<p class="forum-category-description">'.$anakonu['aciklama'].'</p>';
$altkategoriler = $db->query("select * from forumkategoriler where (yayin = '1') && (alt_id = '".$anakonu['id']."')");

$b = 0;
echo '<ul class="link-list v2 negative">';
foreach($altkategoriler as $alt){
	$konular = $db->query("select * from forumkonular where (forumkategori = '".$alt['id']."') && (yayin = '1')");
		if($konular != NULL){
			foreach($konular as $konu){
				$konumesajlarr = $db->prepare("select count(*) from forummesajlar where (konuid = :konuid) && (yayin = '1')");
				$resultttttt = $konumesajlarr->execute(array(":konuid" => $konu['id']));
				$konumesajlar   = $konumesajlarr->fetchColumn();
				$b = $b + $konumesajlar;
			}
			
		}
		$sonkonuu = $db->prepare("select * from forumkonular where (forumkategori = :forumkategori) && (username != '') && (yayin = '1') order by stamp desc limit 1");

		$resultttttt = $sonkonuu->execute(array(":forumkategori" => $alt['id']));
		$sonkonu   = $sonkonuu->fetch(PDO::FETCH_ASSOC);
		
		if($sonkonu['forumkategori'] != ''){
			$sonmesajj = $db->prepare("select * from forummesajlar where (konuid = :konuid) && (yayin = '1') order by stamp desc limit 1");
			$result = $sonmesajj->execute(array(":konuid" => $sonkonu['id']));
		$sonmesaj   = $sonmesajj->fetch(PDO::FETCH_ASSOC);
		}
		
		
		$aa = $db->prepare("select count(*) from forumkonular where (forumkategori = :forumkategori) && (yayin = '1') ");
		$resulttttt = $aa->execute(array(":forumkategori" => $alt['id']));
		$a   = $aa->fetchColumn();
		$i = $i + $a;
		
		
		echo '<li class="link-list-item"><a href="'.$domain2.'forumkategori/'.$alt['kategorikodu'].'" style="color:#696969;"><i class="fa fa-folder-open"></i> '.$alt['kategori_TR'].' ('.$a.')</a> </li>';
		
		
		
}
		echo '</ul>';
		echo '</div>';
	  echo '</div>';
	  echo '<div class="table-row-item padded-large burayigizle">';
		echo '<p class="table-text bold light">'.$i.'</p>';
	  echo '</div>';
	  echo '<div class="table-row-item padded-large">';
		echo '<p class="table-text bold light">'.$b.'</p>';
	  echo '</div>';
	  echo '<div class="table-row-item">';
		echo '<div class="forum-post-links">';
		  echo '<div class="forum-post-link-wrap">';
if($sonmesaj['username'] != NULL){
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
echo '<style>
	.label-warning::before{
		background:rgba(255,255,255,0);
	}
	</style>';	
	
	echo '<div class="table standings" style="border: 0px;margin-bottom: 0px;">';
		echo '<div class="table-rows">';
			echo '<div class="table-row">';
			echo '<div class="table-row-item position" style="border:0px;">';
			
			
		echo '<div class="team-info-wrap">';
		  echo '<img class="team-logo small gizle" src="https://cravatar.eu/avatar/'.$sonmesaj['username'].'" alt="'.$sonmesaj['username'].'">';
		  echo '<div class="team-info">';
			echo '<a href="'.$domain2.'profil/'.$sonmesaj['username'].'" style="color: #363636;"><p class="team-country" style="color: #363636;line-height: 1em;font-size: .875em;font-family: \'Exo\',sans-serif;font-weight: 700;text-transform:none;">'.$sonmesaj['username'].' <span class="tag-ornament gizle" style="vertical-align:middle;margin-top: 0px;margin-left: 5px;background:'.$renk.';">'.$grupadi['name'].'</span></a></p>';
		  echo '</div>';
		echo '</div>';
			echo '</div>';
			
			echo '<div class="table-row-item"  style="border:0px;"><p class="table-text bold light"><i class="fa fa-calendar"></i> '.date("d.m.Y H:i",$sonmesaj['stamp']).'</p></div>';
			echo '</div>';
			
		echo '</div>';
	echo '</div>';
	echo '<a class="table-text bold light" style="text-transform:none;text-align:left;" href="'.$domain.'forumdetay/'.$secilikategori['id'].'/'.$sonmesaj['konuid'].'" >'.mb_substr(strip_tags($sonmesaj['mesaj']),0,'220','utf-8').'...</a>';
 
}else{  
	echo '<p>Henüz mesaj yok</p>';
}
		  echo '</div>';
		echo '</div>';
	  echo '</div>';
	echo '</div>';
}
?>	  
      </div>
    </div>
  </div>
<?php include_once('footer.php'); ?>