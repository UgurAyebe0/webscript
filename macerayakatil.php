<?php
include_once('header.php');
$hakkimizdaa = $db->prepare("select * from macera where (id = '1')");
$result = $hakkimizdaa->execute();
$hakkimizda   = $hakkimizdaa->fetch(PDO::FETCH_ASSOC);
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

<div class="post-author-info small light">
	<i class="fa fa-calendar meta-icon"></i>
	Yayınlanma <?php echo date("d.m.Y H:i", $hakkimizda['stamp']); ?>
</div>




  </div>
  <!-- /LAYOUT CONTENT FULL -->
<?php include_once('footer.php'); ?>