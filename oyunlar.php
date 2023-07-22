<?php include_once('header.php'); ?>
<style>
.post-preview.landscape.big .post-preview-title, .post-preview.medium .post-preview-title, .promo-banner .promo-banner-info .promo-banner-title, .section-slider-bg .section-slider-title {
    font-size: 1.525em;
    line-height: 1.2307692308em;
}
</style>
<style>
.banner-wrap.movie-reviews {
    background: url("<?php echo $domain; ?>images/home-slide/galeri_9854494.jpg") no-repeat center,linear-gradient(45deg, #f30a5c, #1c95f3);
    background-size: auto, auto;
    background-size: cover;
}
</style>
  <div class="banner-wrap movie-reviews">
    <div class="banner grid-limit">
      <h2 class="banner-title">Oyunlar</h2>
      <p class="banner-sections">
        <span class="banner-section">Anasayfa</span>
        <svg class="arrow-icon">
          <use xlink:href="#svg-arrow"></use>
        </svg>
        <span class="banner-section">Oyunlar</span>
      </p>
    </div>
  </div>
<?php include_once('slidenews.php'); ?>
  <div class="layout-content-full grid-limit">
    <div class="layout-body">
      <div class="layout-item grid-2col_3 centered gutter-mid">
<?php
$oyunlar = $db->query("select * from oyunlar where (yayin = '1') order by stamp asc");

if(isset($oyunlar)){
foreach($oyunlar as $oyun){
$metin = mb_substr(strip_tags($oyun['aciklama']),0,'120','utf-8').'...' ;
	echo '<div class="post-preview medium movie-news">';
          echo '<a href="'.$domain2.'oyundetay.php?p='.$oyun['url'].'">';
            echo '<div class="post-preview-img-wrap">';
              echo '<figure class="post-preview-img liquid">';
                echo '<img src="'.$domain.'images/blog/'.$oyun['gorsel'].'" alt="'.$oyun['baslik'].'">';
              echo '</figure>';
			  echo '<div class="post-preview-overlay">';
                echo '<div class="play-button">';
                  
                echo '</div>';
            echo '</div>';
            echo '</div>';
          echo '</a>';
          echo '<a href="'.$domain2.'oyundetay.php?p='.$oyun['url'].'" class="tag-ornament">'.$oyun['baslik'].'</a>';
          echo '<a href="'.$domain2.'oyundetay.php?p='.$oyun['url'].'" class="post-preview-title">'.$oyun['baslik'].'</a>';
          echo '<div class="post-author-info-wrap">';
            
            echo '<p class="post-author-info small light"><a href="'.$domain2.'oyundetay.php?p='.$oyun['url'].'" class="post-author">'.$oyun['konu'].'</a><span class="separator">|</span><a href="'.$domain2.'oyundetay.php?p='.$oyun['url'].'" class="post-comment-count">'.$oyun['ozellik'].'</a></p>';
          echo '</div>';
          echo '<p class="post-preview-text">'.$metin.'</p>';
    echo '</div>';
}
}
?>   
      </div>
    </div>
<?php #include_once('sidebarhaber.php'); ?>
  </div>
<?php include_once('footer.php'); ?>