<?php include_once('header.php'); 
$secilikategori = $db->prepare("select * from kategoriler where (kategorikodu = '".$_REQUEST['p']."')");
$result = $secilikategori->execute();
$secilikategori   = $secilikategori->fetch(PDO::FETCH_ASSOC);
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
        <span class="banner-section"><?php echo $secilikategori['kategori_TR']; ?></span>
      </p>
    </div>
  </div>
<?php include_once('slidenews.php'); ?>
  <div class="layout-content-1 layout-item-3-1 grid-limit">
    <div class="layout-body">
      <div class="layout-item grid-2col_3 centered gutter-mid">
<?php
$sayfada = 10;

$toplam_icerik = $db->prepare("select count(*) from makaleler where (yayin = '1') && (kategori = '".$secilikategori['id']."') ");
$result = $toplam_icerik->execute();
$toplam_icerik   = $toplam_icerik->fetchColumn();

$toplam_sayfa = ceil($toplam_icerik / $sayfada);

$sayfa = isset($_GET['sayfa']) ? (int) $_GET['sayfa'] : 1;

if($sayfa < 1) $sayfa = 1; 
if($sayfa > $toplam_sayfa) $sayfa = $toplam_sayfa; 

$limit = ($sayfa - 1) * $sayfada;

$haberler = $db->query("select * from makaleler where (yayin = '1') && (kategori = '".$secilikategori['id']."') order by stamp desc LIMIT ".$limit." , ".$sayfada."");

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
          echo '<a href="'.$domain.'kategori/'.$kategori['kategorikodu'].'" class="tag-ornament" style="background-color:'.$kategori['renk'].';">'.$kategori['kategori_TR'].'</a>';
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
<a href="<?php echo $domain2.'kategori/'.$_REQUEST['p']; ?>?sayfa=<?php echo $sayfa-1; ?>" aria-controls="bootstrap-data-table" data-dt-idx="0" tabindex="0" class="page-link">
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
						<a class="page-navigation-item" href="<?php echo $domain2.'kategori/'.$_REQUEST['p']; ?>?sayfa=<?php echo $s; ?>" aria-controls="bootstrap-data-table" data-dt-idx="1" tabindex="0" class="page-link"><?php echo $s; ?></a>
					<?php
					}
				}
				
if($sayfa != $toplam_sayfa) {				
				
?>
<a href="<?php echo $domain2.'kategori/'.$_REQUEST['p']; ?>?sayfa=<?php echo $sayfa+1; ?>" aria-controls="bootstrap-data-table" data-dt-idx="0" tabindex="0" class="page-link">
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
<?php include_once('sidebarhaber.php'); ?>
  </div>
<?php include_once('footer.php'); ?>