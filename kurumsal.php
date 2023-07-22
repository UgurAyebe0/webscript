<?php
include_once('header.php');
$hakkimizdaa = $db->prepare("select * from hakkimizda where (id = '1')");
$result = $hakkimizdaa->execute();
$hakkimizda   = $hakkimizdaa->fetch(PDO::FETCH_ASSOC);
?>
<style>
.banner-wrap.forum-banner {
    background: url("<?php echo $domain; ?>images/home-slide/galeri_9854494.jpg") no-repeat center,linear-gradient(45deg, #f30a5c, #1c95f3);
    background-size: auto, auto;
    background-size: cover;
}
.player-preview .player-preview-info {
    padding: 19px;
}
</style>
  <!-- BANNER WRAP -->
  <div class="banner-wrap forum-banner">
    <!-- BANNER -->
    <div class="banner grid-limit">
      <h2 class="banner-title"><?php echo $hakkimizda['baslik']; ?></h2>
      <p class="banner-sections">
        <span class="banner-section">Anasayfa</span>
        <!-- ARROW ICON -->
        <svg class="arrow-icon">
          <use xlink:href="#svg-arrow"></use>
        </svg>
        <!-- /ARROW ICON -->
        <span class="banner-section"><?php echo $hakkimizda['baslik']; ?></span>
      </p>
    </div>
    <!-- /BANNER -->
  </div>
  <!-- /BANNER WRAP -->

<?php include_once('slidenews.php'); ?>
<!--faq-item-content accordion-open--> 
  <!-- LAYOUT CONTENT FULL -->
  <div class="layout-content-full grid-limit">

<?php echo $hakkimizda['icerik']; ?>

<!--<div class="post-author-info small light">
	<i class="fa fa-calendar meta-icon"></i>
	Yayınlanma <?php echo date("d.m.Y H:i", $hakkimizda['stamp']); ?>
</div>-->

<div class="widget-item">
      <div class="section-title-wrap violet">
        <h2 class="section-title medium">Yönetim Ekibi</h2>
        <div class="section-title-separator"></div>
      </div>

      <div class="widget-player-preview">
<?php
$gorevliler = $db->query("select * from gorevliler where (yayin = '1') order by sira asc");

foreach($gorevliler as $gorevli){
if($gorevli['gorev'] == 'Kurucu'){
	$renk = '#AA0000';
}elseif($gorevli['gorev'] == 'Yetkili'){
	$renk = '#FFAA00';
}elseif($gorevli['gorev'] == 'Rehber'){
	$renk = '#55FF55';
}

	echo '<div class="player-preview">';
	  echo '<a href="'.$domain2.'profil/'.$gorevli['username'].'" class="button-more-info">';
		echo '<svg class="plus-cc-icon medium">';
		  echo '<use xlink:href="#svg-plus-cc"></use>';
		echo '</svg>';
	  echo '</a>';
	  echo '<a href="'.$domain2.'profil/'.$gorevli['username'].'">';
		echo '<div class="player-preview-img-wrap">';
		  echo '<img class="player-preview-img" src="https://minotar.net/body/'.$gorevli['username'].'" alt="player-01" style="max-height: 328px;padding-left: 10px;">';
		echo '</div>';
	  echo '</a>';
	  echo '<div class="player-preview-info">';
		echo '<p class="player-preview-nickname">';
		echo '<p class="team-country" style="font-size: .8em;color:'.$renk.'"><a href="'.$domain2.'profil/'.$gorevli['username'].'" style="color:'.$renk.' !important;">'.$gorevli['username'].' <span class="tag-ornament" style="vertical-align:middle;margin-top: 0px;margin-left: 5px;background:'.$renk.';">'.$gorevli['gorev'].'</span></a></p>';
		echo '</p>';
		echo '<p class="player-preview-name">'.$gorevli['adi'].'</p>';
	  echo '</div>';
	echo '</div>';
}
?>      
		
		 
  

      </div>
	  
    </div>


  </div>
  <!-- /LAYOUT CONTENT FULL -->
<?php include_once('footer.php'); ?>