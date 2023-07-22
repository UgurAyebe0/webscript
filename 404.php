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
      <h2 class="banner-title">404 Sayfa Bulunamadı</h2>
      <p class="banner-sections">
        <span class="banner-section">Anasayfa</span>
        <!-- ARROW ICON -->
        <svg class="arrow-icon">
          <use xlink:href="#svg-arrow"></use>
        </svg>
        <!-- /ARROW ICON -->
        <span class="banner-section">404 Sayfa Bulunamadı</span>
      </p>
    </div>
    <!-- /BANNER -->
  </div>
  <!-- /BANNER WRAP -->

<?php include_once('slidenews.php'); ?>
<!--faq-item-content accordion-open--> 
  <!-- LAYOUT CONTENT FULL -->
  <div class="layout-content-full grid-limit">

<div class="error-display grid-limit">
      <!-- ERROR IMG -->
      <figure class="error-img liquid">
        <img src="<?php echo $domain; ?>img/other/error-img.png" alt="error-img">
      </figure>
      <!-- /ERROR IMG -->

      <!-- ERROR TITLE -->
      <p class="error-title">Oooooopsss!</p>
      <!-- /ERROR TITLE -->

      <!-- ERROR SUBTITLE -->
      <p class="error-subtitle">Bir şeyler yanlış gitti</p>
      <!-- /ERROR SUBTITLE -->

      <!-- ERROR TEXT -->
      <p class="error-text">Sayfa kaldırılmış veya hiçbir zaman var olmamış olabilir</p>
      <!-- /ERROR TEXT -->
    </div>
    <!-- /ERROR DISPLAY -->

    <!-- SECTION ACTIONS -->
    <div class="section-actions">


      <!-- BUTTON -->
      <a href="<?php echo $domain; ?>" class="button violet">
        Anasayfa'ya Dön
        <!-- BUTTON ORNAMENT -->
        <div class="button-ornament">
          <!-- ARROW ICON -->
          <svg class="arrow-icon medium">
            <use xlink:href="#svg-arrow-medium"></use>
          </svg>
          <!-- /ARROW ICON -->

          <!-- CROSS ICON -->
          <svg class="cross-icon small">
            <use xlink:href="#svg-cross-small"></use>
          </svg>
          <!-- /CROSS ICON -->
        </div>
        <!-- /BUTTON ORNAMENT -->
      </a>
      <!-- /BUTTON -->
    </div>




  </div>
  <!-- /LAYOUT CONTENT FULL -->
<?php include_once('footer.php'); ?>