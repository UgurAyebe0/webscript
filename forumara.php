<?php
include_once('header.php');
$sonuc = piril($_REQUEST['ara']);
?>
<style>
.banner-wrap.gaming-news {
    background: url("<?php echo $domain; ?>images/home-slide/galeri_9854494.jpg") no-repeat center,linear-gradient(45deg, #f30a5c, #1c95f3);
    background-size: auto, auto;
    background-size: cover;
}
</style>
  <!-- BANNER WRAP -->
  <div class="banner-wrap gaming-news">
    <!-- BANNER -->
    <div class="banner grid-limit">
      <h2 class="banner-title">Forumda Ara</h2>
      <p class="banner-sections">
        <span class="banner-section">Anasayfa</span>
        <!-- ARROW ICON -->
        <svg class="arrow-icon">
          <use xlink:href="#svg-arrow"></use>
        </svg>
        <!-- /ARROW ICON -->
        <span class="banner-section">"<?php echo piril($_REQUEST['ara']); ?>" için Forum Konuları</span>
      </p>
    </div>
    <!-- /BANNER -->
  </div>
  <!-- /BANNER WRAP -->

  <!-- LIVE NEWS WIDGET WRAP -->
<?php include_once('slidenews.php'); ?>
  <!-- /LIVE NEWS WIDGET WRAP -->

  <!-- LAYOUT CONTENT 1 -->
  <div class="layout-content-1 layout-item-3-1 grid-limit">
    <!-- LAYOUT BODY -->
    <div class="layout-body">
      <!-- LAYOUT ITEM -->
      <div class="layout-item gutter-big">
	  
<?php
$konular = $db->query("select * from forumkonular where (baslik like '%".piril($_REQUEST['ara'])."%')limit 50");


$oyuncusayii = $db->prepare("select count(*) from forumkonular where (baslik like '%".piril($_REQUEST['ara'])."%')");
$result = $oyuncusayii->execute();
$oyuncusayi   = $oyuncusayii->fetchColumn();

?> 
<div class="row">
<?php
if($oyuncusayi != 0){
?>
<div class="filters-row">


      <!-- OPTION LIST -->
      <div class="option-list">
        <!-- OPTION LIST ITEM -->
        <p class="option-list-item selected"><?php echo $oyuncusayi; ?> Sonuç Bulundu</p>
        <!-- /OPTION LIST ITEM -->

      </div>
      <!-- /OPTION LIST -->


    </div>
<?php
foreach($konular as $konu){
$secilikategori = $db->prepare("select * from forumkategoriler where (id = :id)");
$result = $secilikategori->execute(array(":id" => $konu['forumkategori']));
$secilikategori   = $secilikategori->fetch(PDO::FETCH_ASSOC);

	echo '<div class="col-lg-12 col-md-12 col-sm-12">';
		echo '<div class="row" style="border-bottom:1px solid #ddd;padding-bottom:20px;padding-top:10px;">';
		echo '<div class="col-xs-3 col-3" style="">';
					echo '<a href="'.$domain2.'forumkategori/'.$secilikategori['kategorikodu'].'">';
					echo '<span class="" style="font-size:12px;vertical-align:middle;border-radius:0px;background-color: #337ab7;color:#fff;padding:3px;font-weight:700;">'.$secilikategori['kategori_TR'].'</span></a>';
					echo '</div>';
					echo '<div class="col-xs-9 col-9">';
			echo '<a href="'.$domain2.'forumdetay/'.$konu['forumkategori'].'/'.$konu['id'].'" style="align:left;text-decoration:none;">';
				echo '<div class="bottom-info" style="text-align:left;">';
					echo '...'.$konu['baslik'].'';
					echo '</a>';
					echo '</div>';
					
				echo '</div>';
		echo '</div>';
	echo '</div>';
}
}else{
	echo '<p class="alert alert-warning text-center" style="width:100%;">Sonuç Bulunamadı.</p>';
}
?>
</div>
	  
      </div>
	  
<div class="layout-item padded own-grid">
        <div class="section-title-wrap yellow">
          <h2 class="section-title medium">Son Yüklenen Videolar</h2>
          <div class="section-title-separator"></div>
          <div id="gknews-slider1-controls" class="carousel-controls slider-controls yellow">
            <div class="slider-control control-previous">
              <svg class="arrow-icon medium">
                <use xlink:href="#svg-arrow-medium"></use>
              </svg>
            </div>
            <div class="slider-control control-next">
              <svg class="arrow-icon medium">
                <use xlink:href="#svg-arrow-medium"></use>
              </svg>
            </div>
          </div>
        </div>
        <div id="gknews-slider1" class="carousel" style="height:220px;">
          <div class="carousel-items">
<?php
$sonvideolar = $db->query("select * from youtube where (yayin = '1') && (vitrin = '1') order by stamp desc limit 12");
$sonvideolar->execute();
$sonvideolar = $sonvideolar->fetchAll();
foreach($sonvideolar as $svideo){
	echo '<div class="post-preview geeky-news">';
	  echo '<a href="'.$domain2.'video/'.$svideo['urlkodu'].'">';
		echo '<div class="post-preview-img-wrap">';
		  echo '<figure class="post-preview-img liquid">';
			echo '<img src="'.$domain.'images/blog/'.$svideo['kapak'].'" alt="post-02">';
		  echo '</figure>';
		echo '</div>';
	  echo '</a>';
	  echo '<a href="'.$domain2.'video/'.$svideo['urlkodu'].'" class="tag-ornament" style="text-transform:none;">'.$svideo['yukleyen'].'</a>';
	  echo '<a href="'.$domain2.'video/'.$svideo['urlkodu'].'" class="post-preview-title">'.$svideo['baslik'].'</a>';
	  echo '<div class="post-author-info-wrap">';
	if($svideo['yukleyen'] == 'CandyCraft'){
		echo '<p class="post-author-info small light">Yükleyen <a href="'.$domain.'" class="post-author">'.$svideo['yukleyen'].'</a><span class="separator">|</span>'.date("d.m.y H:i",$svideo['stamp']).'</p>';
	}else{
		echo '<p class="post-author-info small light">Yükleyen <a href="'.$domain2.'profil/'.$svideo['yukleyen'].'" class="post-author">'.$svideo['yukleyen'].'</a><span class="separator">|</span>'.date("d.m.y H:i",$svideo['stamp']).'</p>';
	}  
		
	  echo '</div>';
	echo '</div>';
}
?>
 
          </div>
        </div>
      </div>
      <div class="layout-item padded own-grid">
 
        <div class="section-title-wrap violet">
          <h2 class="section-title medium">Popüler Videolar</h2>
          <div class="section-title-separator"></div>

          <div id="esnews-slider1-controls" class="carousel-controls slider-controls violet">
            <div class="slider-control control-previous">

              <svg class="arrow-icon medium">
                <use xlink:href="#svg-arrow-medium"></use>
              </svg>
    
            </div>
            <div class="slider-control control-next">

              <svg class="arrow-icon medium">
                <use xlink:href="#svg-arrow-medium"></use>
              </svg>
  
            </div>
          </div>

        </div>

        <div id="esnews-slider1" class="carousel" style="height:220px;">

          <div class="carousel-items">

<?php
$populervideolar = $db->query("select * from youtube where (yayin = '1') && (vitrin = '1') order by izlenme desc limit 12");
$populervideolar->execute();
$populervideolar = $populervideolar->fetchAll();
foreach($populervideolar as $pvideo){
	echo '<div class="post-preview geeky-news">';
	  echo '<a href="'.$domain2.'video/'.$pvideo['urlkodu'].'">';
		echo '<div class="post-preview-img-wrap">';
		  echo '<figure class="post-preview-img liquid">';
			echo '<img src="'.$domain.'images/blog/'.$pvideo['kapak'].'" alt="post-02">';
		  echo '</figure>';
		echo '</div>';
	  echo '</a>';
	  echo '<a href="'.$domain2.'video/'.$pvideo['urlkodu'].'" class="tag-ornament" style="text-transform:none;">'.$pvideo['yukleyen'].'</a>';
	  echo '<a href="'.$domain2.'video/'.$pvideo['urlkodu'].'" class="post-preview-title">'.$pvideo['baslik'].'</a>';
	  echo '<div class="post-author-info-wrap">';
	if($pvideo['yukleyen'] == 'CandyCraft'){
		echo '<p class="post-author-info small light">Yükleyen <a href="'.$domain.'" class="post-author">'.$pvideo['yukleyen'].'</a><span class="separator">|</span>'.date("d.m.y H:i",$pvideo['stamp']).'</p>';
	}else{
		echo '<p class="post-author-info small light">Yükleyen <a href="'.$domain2.'profil/'.$pvideo['yukleyen'].'" class="post-author">'.$pvideo['yukleyen'].'</a><span class="separator">|</span>'.date("d.m.y H:i",$pvideo['stamp']).'</p>';
	}  
		
	  echo '</div>';
	echo '</div>';
}
?>
          </div>
        </div>
      </div>	  
	  
	  
    </div>
<?php include_once('sidebar.php'); ?>
  </div>
<?php include_once('footer.php'); ?>