<?php include_once('header.php'); 

?>
<style>
.post-preview.landscape.big .post-preview-title, .post-preview.medium .post-preview-title, .promo-banner .promo-banner-info .promo-banner-title, .section-slider-bg .section-slider-title {
    font-size: 1.525em;
    line-height: 1.2307692308em;
}
.banner-wrap.movie-reviews {
    background: url("<?php echo $domain; ?>images/home-slide/galeri_9854494.jpg") no-repeat center,linear-gradient(45deg, #f30a5c, #1c95f3);
    background-size: auto, auto;
    background-size: cover;
}
</style>
  <div class="banner-wrap movie-reviews">
    <div class="banner grid-limit">
      <h2 class="banner-title">Haber & Duyurular</h2>
      <p class="banner-sections">
        <span class="banner-section">Anasayfa</span>
        <svg class="arrow-icon">
          <use xlink:href="#svg-arrow"></use>
        </svg>
        <span class="banner-section"><?php echo piril($_REQUEST['ara']); ?>" için Haber Sonuçları</span>
      </p>
    </div>
  </div>
<?php include_once('slidenews.php'); ?>
  <div class="layout-content-1 layout-item-3-1 grid-limit">
    <div class="layout-body">
      <div class="layout-item grid-2col_3 centered gutter-mid">
<?php
$haberler = $db->query("select * from makaleler where (yayin = '1') && (baslik like '%".piril($_REQUEST['ara'])."%') or (icerik like '%".piril($_REQUEST['ara'])."%')  limit 50");

if(isset($haberler)){
foreach($haberler as $haber){
$yorumsayi = $db->prepare("select count(*) from haberyorum where (haber = :haber) && (yayin = '1')");
$result = $yorumsayi->execute(array(":haber" => $haber['id']));
$yorumsayi   = $yorumsayi->fetchColumn();
$kategorii = $db->prepare("select * from kategoriler where (id = :id)");
$result = $kategorii->execute(array(":id" => $haber['kategori']));
$kategori   = $kategorii->fetch(PDO::FETCH_ASSOC);
$metin = mb_substr(strip_tags($haber['icerik']),0,'150','utf-8').'...' ;
	echo '<div class="post-preview medium movie-news">';
          echo '<a href="'.$domain2.'haber/'.$haber['urlkodu'].'">';
            echo '<div class="post-preview-img-wrap">';
              echo '<figure class="post-preview-img liquid">';
                echo '<img src="'.$domain.'images/blog/'.$haber['gorsel'].'" alt="post-03">';
              echo '</figure>';
            echo '</div>';
          echo '</a>';
          echo '<a href="'.$domain.'kategori/'.$kategori['kategorikodu'].'" class="tag-ornament">'.$kategori['kategori_TR'].'</a>';
          echo '<a href="'.$domain2.'haber/'.$haber['urlkodu'].'" class="post-preview-title">'.$haber['baslik'].'</a>';
          echo '<div class="post-author-info-wrap">';
            echo '<a href="'.$domain2.'profil/'.$haber['yazar'].'">';
              echo '<figure class="user-avatar tiny liquid">';
                echo '<img src="https://cravatar.eu/avatar/'.$haber['yazar'].'" alt="user-03">';
              echo '</figure>';
            echo '</a>';
            echo '<p class="post-author-info small light">Yazar <a href="'.$domain2.'profil/'.$haber['yazar'].'" class="post-author">'.$haber['yazar'].'</a><span class="separator">|</span>'.date("d.m.y H:i", $haber['stamp']).'<span class="separator">|</span> <i class="fa fa-book"></i> '.$haber['okunma'].' Okunma <span class="separator">|</span><a href="'.$domain2.'haber/'.$haber['urlkodu'].'#yorumlar" class="post-comment-count"><i class="fa fa-comments"></i> '.$yorumsayi.' Yorum</a></p>';
          echo '</div>';
          echo '<p class="post-preview-text">'.$metin.'</p>';
    echo '</div>';
}
}
?>   
      </div>
    </div>
<?php include_once('sidebarhaber.php'); ?>
  </div>
<?php include_once('footer.php'); ?>