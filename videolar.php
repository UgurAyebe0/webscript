<?php
include_once('header.php');

$sayfada = 12;

$toplam_icerik = $db->prepare("select count(*) from youtube where (yayin = '1')");
$result = $toplam_icerik->execute();
$toplam_icerik   = $toplam_icerik->fetchColumn();

$toplam_sayfa = ceil($toplam_icerik / $sayfada);

$sayfa = isset($_GET['sayfa']) ? (int) $_GET['sayfa'] : 1;

if($sayfa < 1) $sayfa = 1; 
if($sayfa > $toplam_sayfa) $sayfa = $toplam_sayfa; 

$limit = ($sayfa - 1) * $sayfada;

if($_SESSION['sirala'] == NULL or $_SESSION['sirala'] == 'yeni'){
	$videolar = $db->query("select * from youtube where (yayin = '1') order by stamp desc LIMIT ".$limit." , ".$sayfada."");
}elseif($_SESSION['sirala'] == 'eski'){
	$videolar = $db->query("select * from youtube where (yayin = '1') order by stamp asc LIMIT ".$limit." , ".$sayfada."");
}elseif($_SESSION['sirala'] == 'yuksek'){
	$videolar = $db->query("select * from youtube where (yayin = '1') order by izlenme desc LIMIT ".$limit." , ".$sayfada."");
}elseif($_SESSION['sirala'] == 'alcak'){
	$videolar = $db->query("select * from youtube where (yayin = '1') order by izlenme asc LIMIT ".$limit." , ".$sayfada."");
}elseif($_SESSION['sirala'] == 'cok'){
	$videolar = $db->query("select * from youtube where (yayin = '1') order by begen desc LIMIT ".$limit." , ".$sayfada."");
}elseif($_SESSION['sirala'] == 'az'){
	$videolar = $db->query("select * from youtube where (yayin = '1') order by begen asc LIMIT ".$limit." , ".$sayfada."");
}


$videolar->execute();
$videolar = $videolar->fetchAll();


?>
<style>
.banner-wrap.pixel-videos {
    background: url("<?php echo $domain; ?>images/home-slide/galeri_9854494.jpg") no-repeat center,linear-gradient(45deg, #f30a5c, #1c95f3);
    background-size: auto, auto;
    background-size: cover;
}
.widget-sidebar .section-title-wrap {
    margin-bottom: 10px;
}
</style>
  <!-- BANNER WRAP -->
  <div class="banner-wrap pixel-videos">
    <!-- BANNER -->
    <div class="banner grid-limit">
      <h2 class="banner-title">Videolar</h2>
      <p class="banner-sections">
        <span class="banner-section">Anasayfa</span>
        <!-- ARROW ICON -->
        <svg class="arrow-icon">
          <use xlink:href="#svg-arrow"></use>
        </svg>
        <!-- /ARROW ICON -->
        <span class="banner-section">Videolar</span>
      </p>
    </div>
    <!-- /BANNER -->
  </div>
  <!-- /BANNER WRAP -->

<?php include_once('slidenews.php'); ?>
<style>
.dp-options {
	z-index:99999 !important;
}
</style>
  <!-- LAYOUT CONTENT 1 -->
  <div class="layout-content-1 layout-item-3-1 grid-limit">
    <!-- LAYOUT BODY -->
    <div class="layout-body">
      <!-- SECTION TITLE WRAP -->
      <div class="section-title-wrap cyan small-space">
        <h2 class="section-title medium">Videolar</h2>
        <div class="section-title-separator"></div>
      </div>
      <!-- /SECTION TITLE WRAP -->

      <!-- FILTERS ROW -->
      <div class="filters-row">


        <!-- DROPDOWN SIMPLE WRAP -->
        <div class="dropdown-simple-wrap">
          <!-- DP CURRENT OPTION -->
          <div id="filter-03-dropdown-trigger" class="dp-current-option">
            <!-- DP CURRENT OPTION VALUE -->
            <div id="filter-03-dropdown-option-value" class="dp-current-option-value">
              <p class="dp-option-text" style="font-size: .825em;">Sırala Seçenekleri</p>
            </div>
            <!-- /DP CURRENT OPTION VALUE -->

            <!-- ARROW ICON -->
            <svg class="arrow-icon">
              <use xlink:href="#svg-arrow"></use>
            </svg>
            <!-- /ARROW ICON -->
          </div>
          <!-- /DP CURRENT OPTION -->

          <!-- DP OPTIONS -->
          <div id="filter-03-dropdown" class="dp-options small">
            <!-- DP OPTION -->
			
            <div class="dp-option">
			<form method="POST">
              <input type="submit" name="yeni" class="dp-option-text" style="font-size: .825em;background:#fff;" value="Yeniden Eskiye">
			</form>
            </div>
            <!-- /DP OPTION -->

            <!-- DP OPTION -->
            <div class="dp-option">
			<form method="POST">
              <input type="submit" name="eski" class="dp-option-text" style="font-size: .825em;background:#fff;" value="Eskiden Yeniye">
			</form>
            </div>
            <!-- /DP OPTION -->
			<!-- DP OPTION -->
            <div class="dp-option">
			<form method="POST">
              <input type="submit" name="yuksek" class="dp-option-text" style="font-size: .825em;background:#fff;" value="İzlenmeye Göre Yüksek">
			</form>
            </div>
            <!-- /DP OPTION -->
			<!-- DP OPTION -->
            <div class="dp-option">
			<form method="POST">
              <input type="submit" name="alcak" class="dp-option-text" style="font-size: .825em;background:#fff;" value="İzlenmeye Göre Düşük">
			</form>
            </div>
            <!-- /DP OPTION -->
			<!-- DP OPTION -->
            <div class="dp-option">
			<form method="POST">
              <input type="submit" name="cok" class="dp-option-text" style="font-size: .825em;background:#fff;" value="Beğeniye Göre Yüksek">
			</form>
            </div>
            <!-- /DP OPTION -->
			<!-- DP OPTION -->
            <div class="dp-option">
			<form method="POST">
              <input type="submit" name="az" class="dp-option-text" style="font-size: .825em;background:#fff;" value="Beğeniye Göre Düşük">
			</form>
            </div>
            <!-- /DP OPTION -->
          </div>
          <!-- /DP OPTIONS -->
        </div>
        <!-- /DROPDOWN SIMPLE WRAP -->
<?php
if(isset($_POST['yeni'])){
	$_SESSION['sirala'] = 'yeni';
	header('Location:'.$domain2.'tumvideolar');
}
if(isset($_POST['eski'])){
	$_SESSION['sirala'] = 'eski';
	header('Location:'.$domain2.'tumvideolar');
}
if(isset($_POST['yuksek'])){
	$_SESSION['sirala'] = 'yuksek';
	header('Location:'.$domain2.'tumvideolar');
}
if(isset($_POST['alcak'])){
	$_SESSION['sirala'] = 'alcak';
	header('Location:'.$domain2.'tumvideolar');
}
if(isset($_POST['cok'])){
	$_SESSION['sirala'] = 'cok';
	header('Location:'.$domain2.'tumvideolar');
}
if(isset($_POST['az'])){
	$_SESSION['sirala'] = 'az';
	header('Location:'.$domain2.'tumvideolar');
}
?>

      </div>
      <!-- /FILTERS ROW -->

      <!-- POST PREVIEW SHOWCASE -->
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
		echo '</a><a href="'.$domain2.'video/'.$video['urlkodu'].'" class="tag-ornament" style="text-transform:none;">'.$video['yukleyen'].'</a><a href="'.$domain2.'video/'.$video['urlkodu'].'" class="post-preview-title" style="min-height:35px;">'.$video['baslik'].'</a>';  
		echo '<div class="post-author-info-wrap">';
	if($video['yukleyen'] == 'CandyCraft'){
		echo '<p class="post-author-info small light">Yükleyen <a href="'.$domain.'" class="post-author">'.$video['yukleyen'].'</a><span class="separator">|</span>'.date("d.m.y H:i",$video['stamp']).'</p>';
	}else{
		echo '<p class="post-author-info small light">Yükleyen <a href="'.$domain2.'profil/'.$video['yukleyen'].'" class="post-author">'.$video['yukleyen'].'</a><span class="separator">|</span>'.date("d.m.y H:i",$video['stamp']).'</p>';
		
	}  
	echo '<p class="post-author-info small light"><i class="fa fa-eye"></i> '.$video['izlenme'].' Görüntülenme <span class="separator">|</span> <i class="fa fa-thumbs-up"></i> '.$video['begen'].' Beğeni</p>';
		echo '</div>';
	echo '</div>';
}
?>		
        
        <!-- /POST PREVIEW -->
    
        

        

        
      </div>
      <!-- /POST PREVIEW SHOWCASE -->

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
<a href="<?php echo $domain2.'tumvideolar'; ?>?sayfa=<?php echo $sayfa-1; ?>" aria-controls="bootstrap-data-table" data-dt-idx="0" tabindex="0" class="page-link">
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
						<a class="page-navigation-item" href="<?php echo $domain2.'tumvideolar'; ?>?sayfa=<?php echo $s; ?>" aria-controls="bootstrap-data-table" data-dt-idx="1" tabindex="0" class="page-link"><?php echo $s; ?></a>
					<?php
					}
				}
				
if($sayfa != $toplam_sayfa) {				
				
?>
<a href="<?php echo $domain2.'tumvideolar'; ?>?sayfa=<?php echo $sayfa+1; ?>" aria-controls="bootstrap-data-table" data-dt-idx="0" tabindex="0" class="page-link">
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
    <!-- /LAYOUT BODY -->

    <!-- LAYOUT SIDEBAR -->
    <div class="layout-sidebar layout-item gutter-medium">
	
	<div class="widget-sidebar">
        <div class="section-title-wrap violet">
          <h2 class="section-title medium">En Çok Video Yükleyenler</h2>
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
$encokvideoatanlar = $db->query("select * from encokvideo order by videosayi desc limit 5");


foreach($encokvideoatanlar as $yuk){
$oyuncu = $kpanel->prepare("select * from Kullanicilar where (username = :username)");
$result = $oyuncu->execute(array(":username" => $yuk['username']));
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


	echo '<div class="table-row">';
	  echo '<div class="table-row-item position">';
	   echo '<a href="'.$domain2.'profil/'.$oyuncu['username'].'" style="color:'.$renk.'">';
		echo '<div class="team-info-wrap">';
		  echo '<img class="team-logo small" src="https://cravatar.eu/avatar/'.$oyuncu['username'].'" alt="'.$oyuncu['username'].'">';
		  echo '<div class="team-info">';
			echo '<p class="team-name" style="text-transform:none;color:'.$renk.'">'.$oyuncu['username'].' <span class="tag-ornament" style="vertical-align:middle;margin-top: 0px;margin-left: 5px;background:'.$renk.';">'.$grupadi['name'].'</span></p>';
			#echo '<p class="team-country">'.$grupadi['name'].'</p>';
		  echo '</div>';
		echo '</div>';
	  echo '</div>';
	  echo '<div class="table-row-item">';
		echo '<p class="table-text bold">'.$yuk['videosayi'].'</p>';
		echo '</a>';
	  echo '</div>';
	echo '</div>';
	
	}

?>
          </div>
          <!-- /TABLE ROWS -->
        </div>
        <!-- /TABLE -->
      </div>
	
	
	
	
      <!-- WIDGET SIDEBAR -->
      <div class="widget-sidebar">
        <!-- SECTION TITLE WRAP -->
        <div class="section-title-wrap cyan">
          <h2 class="section-title medium" style="margin-top: 0px;">Popüler Videolar</h2>
          <div class="section-title-separator"></div>
        </div>
        <!-- /SECTION TITLE WRAP -->

        <!-- POST PREVIEW SHOWCASE -->
        <div class="post-preview-showcase grid-1col centered gutter-small">
          <!-- POST PREVIEW -->
		  
          <?php
$populervideolar = $db->query("select * from youtube where (yayin = '1') && (vitrin = '1') order by izlenme desc limit 5");
$populervideolar->execute();
$populervideolar = $populervideolar->fetchAll();
foreach($populervideolar as $video){
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
		echo '</a><a href="'.$domain2.'video/'.$video['urlkodu'].'" class="tag-ornament" style="text-transform:none;">'.$video['yukleyen'].'</a><a href="'.$domain2.'video/'.$video['urlkodu'].'" class="post-preview-title" style="min-height:35px;">'.$video['baslik'].'</a>';  
		
	echo '</div>';
}
?>		
		  
          <!-- /POST PREVIEW -->

        </div>
        <!-- /POST PREVIEW SHOWCASE -->
      </div>
      <!-- /WIDGET SIDEBAR -->
    </div>
    <!-- /LAYOUT SIDEBAR -->
  </div>
  <!-- /LAYOUT CONTENT 1 -->

<?php include_once('footer.php'); ?>