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
      <h2 class="banner-title">YARDIM MERKEZI</h2>
      <p class="banner-sections">
        <span class="banner-section">Anasayfa</span>
        <!-- ARROW ICON -->
        <svg class="arrow-icon">
          <use xlink:href="#svg-arrow"></use>
        </svg>
        <!-- /ARROW ICON -->
        <span class="banner-section">YARDIM MERKEZI</span>
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
$kategoriler = $db->query("select * from ssskategoriler where (yayin = '1') order by sira asc");
echo '<div class="section-title-wrap violet small-space">';
foreach($kategoriler as $kat){

$katid=$kat['id'];
$renk=$kat['renk'];
$nRows = $db->query('select count(*) AS soru FROM sss where yayin=1 and kategori = '.$katid.' ')->fetchColumn(); 
if ($katid==$_GET['p']) {
echo '<style>';
echo '#k'.$katid.'{';
echo 'background-color: '.$renk.';color: white;';
echo '}';
echo '</style>'; 
}else{
echo '<style>';
echo '#k'.$katid.'{';
echo 'background-color: white;color: '.$renk.';';
echo '}';
echo '</style>'; 
}
echo '<a href="'.$domain2.'yardim_merkezi?p='.$katid.'" id="k'.$katid.'" class="button"><i class="fa fa-'.$kat['icon'].'" style="font-size:20px;margin-right: 10px;float: left;margin-top:11px;"></i>'.$kat['kategori_TR'].' ('.$nRows.')</a>';
}
echo '<div class="section-title-separator"></div>';
echo '</div>';
?>

<?php 
if (isset($_GET['p'])) {
$sorular = $db->query("select * from sss where (yayin = '1') && (kategori = '".$_GET['p']."') order by sira asc");
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
}else{
	echo '<center><h3>Yardım Merkezine Hoşgeldin!</h3>';
	echo '<p>Yukarıdan Kategori Seçerek GENEL Soruları ve Bilgileri Öğrenebilirsin</p></center>';
}
?>
  </div>
  <!-- /LAYOUT CONTENT FULL -->
<?php include_once('footer.php'); ?>


