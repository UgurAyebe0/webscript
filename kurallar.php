<?php
include_once('header.php');
?>
<style>
.banner-wrap.forum-banner {
    background: url("<?php echo $domain; ?>images/home-slide/galeri_9854494.jpg") no-repeat center,linear-gradient(45deg, #f30a5c, #1c95f3);
    background-size: auto, auto;
    background-size: cover;
}
</style>
  <!-- BANNER WRAP -->
  <div class="banner-wrap forum-banner">
    <!-- BANNER -->
    <div class="banner grid-limit">
      <h2 class="banner-title">KURALLAR</h2>
      <p class="banner-sections">
        <span class="banner-section">Anasayfa</span>
        <!-- ARROW ICON -->
        <svg class="arrow-icon">
          <use xlink:href="#svg-arrow"></use>
        </svg>
        <!-- /ARROW ICON -->
        <span class="banner-section">KURALLAR</span>
      </p>
    </div>
    <!-- /BANNER -->
  </div>
  <!-- /BANNER WRAP -->

<?php include_once('slidenews.php'); ?>
<!--faq-item-content accordion-open--> 
  <!-- LAYOUT CONTENT FULL -->
  <div class="layout-content-full grid-limit">
<?php
$kategoriler = $db->query("select * from kuralkategoriler where (yayin = '1') order by sira asc");
foreach($kategoriler as $kat){
	echo '<div class="section-title-wrap violet small-space">';
	  echo '<h2 class="section-title medium">'.$kat['kategori_TR'].'</h2>';
	  echo '<div class="section-title-separator"></div>';
	echo '</div>';
	echo '<p class="post-preview-text">'.$kat['aciklama'].'</p>';
	echo '<div class="faq-items">';
$sorular = $db->query("select * from kural where (yayin = '1') && (kategori = '".$kat['id']."') order by sira asc");
if($sorular != NULL){
	foreach($sorular as $soru){
	  echo '<div class="faq-item">';
		echo '<div class="faq-item-trigger" style="padding-right: 16%;">';
		  echo '<p class="faq-item-title" style="text-transform:none;">'.$soru['soru'].'</p>';
		  echo '<div class="faq-item-decoration" style="position: absolute;right: 11%;">';
			echo '<svg class="plus-cc-icon">';
			  echo '<use xlink:href="#svg-plus-cc"></use>';
			echo '</svg>';
			echo '<svg class="minus-cc-icon">';
			  echo '<use xlink:href="#svg-minus-cc"></use>';
			echo '</svg>';
		  echo '</div>';
		echo '</div>';
		echo '<div class="faq-item-content" style="padding-bottom:10px;">';
		  echo '<p class="faq-item-text">'.$soru['cevap'].'</p>';
		echo '</div>';
	  echo '</div>';
	}
}
	echo '</div>';
}
?>  





  </div>
  <!-- /LAYOUT CONTENT FULL -->
<?php include_once('footer.php'); ?>