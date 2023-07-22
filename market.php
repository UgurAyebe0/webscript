<?php
include_once('header.php');
$host="87.248.157.101:3306";
$kullaniciadi="candycra_site";
$sifre="pw9ND4pZXY4o@!";
$veritabaniadi="candycra_kpanel";

$baglanti = @mysql_connect($host, $kullaniciadi, $sifre);
$veritabani = @mysql_select_db($veritabaniadi);
mysql_query("SET NAMES 'utf8'");
mysql_query("set character_set_client='utf8'");
mysql_query("set character_set_results='utf8'");
mysql_query("set collation_connection='utf8'");
$sitekullaniciadi = $_SESSION["username"];
$sitekullanicisifre = $_SESSION["sitekullanicisifre"];

if($sitekullaniciadi == ""){
	
	header('Location:'.$domain2);
}

$_REQUEST = piril($_REQUEST);

$sayfada = 15;
$kategoriid=null;
if($_GET['kategori']!=""){
	$kategorinumarasi=TemizVeri($_GET['kategori']);
	$altkategorinumarasi=TemizVeri($_GET['altkategori']);
	$kategorisayi=mysql_fetch_array(mysql_query("SELECT UrunKategoriId FROM UrunKategorileri ORDER BY UrunKategoriId DESC LIMIT 1"));
	$kategorivarmi=mysql_fetch_array(mysql_query("SELECT COUNT(UrunKategoriId),KategoriAdi FROM UrunKategorileri WHERE UrunKategoriId='$kategorinumarasi' LIMIT 1"));
	if ($kategorivarmi[0] != 0) {
		if($kategorinumarasi < $kategorisayi[0] || $kategorinumarasi > 0) {
			if($altkategorinumarasi < $kategorisayi[0] || $altkategorinumarasi > 0) {
				if($altkategorinumarasi!=""){
					$altkategorivarmi=mysql_fetch_array(mysql_query("SELECT COUNT(UrunKategoriId) FROM UrunKategorileri WHERE UrunKategoriId='$altkategorinumarasi' AND AltKategori='1' LIMIT 1"));
					if ($altkategorivarmi[0] != 0){
						$kategoriid="WHERE UrunKategoriId='$kategorinumarasi' AND AltKategoriId='$altkategorinumarasi'";
					}
				}
				else {
					$kategoriid="WHERE UrunKategoriId='$kategorinumarasi'";
				}
			}
		}
	}
	
}
$sorgu = mysql_query("SELECT COUNT(*) AS toplam FROM Urunler $kategoriid");
$sonuc = mysql_fetch_assoc($sorgu);
$toplam_icerik = $sonuc['toplam'];

$toplam_sayfa = ceil($toplam_icerik / $sayfada);

$sayfa = isset($_GET['sayfa']) ? (int) $_GET['sayfa'] : 1;

if($sayfa < 1) $sayfa = 1; 
if($sayfa > $toplam_sayfa) $sayfa = $toplam_sayfa; 

$limit = ($sayfa - 1) * $sayfada;

$sorgu = mysql_query("SELECT * FROM Urunler $kategoriid && (yayin = '1') ORDER BY Sira asc LIMIT " . $limit . ", " . $sayfada);
if($_REQUEST['kategori'] == ''){
	$sorgu = mysql_query("SELECT * FROM Urunler where (yayin = '1') ORDER BY Sira asc LIMIT " . $limit . ", " . $sayfada);
}
?>
<style>
.product-preview-img{
	background-size:100% !important;
}
.banner-wrap.shop-banner {
    background: url("<?php echo $domain; ?>images/home-slide/galeri_9854494.jpg") no-repeat center,linear-gradient(45deg, #f30a5c, #1c95f3);
    background-size: auto, auto;
    background-size: cover;
}
.product-preview .add-to-bag {
    left: 27%;
}
@media screen and (min-width:1261px){
	.gizlebunu{
		display:none !important; 
	}
	
}
</style>
  <!-- BANNER WRAP -->
  <div class="banner-wrap shop-banner">
    <!-- BANNER -->
    <div class="banner grid-limit">
      <h2 class="banner-title">Market</h2>
      <p class="banner-sections">
        <span class="banner-section">Anasayfa</span>
        <!-- ARROW ICON -->
        <svg class="arrow-icon">
          <use xlink:href="#svg-arrow"></use>
        </svg>
        <!-- /ARROW ICON -->
        <span class="banner-section">Market</span>
      </p>
    </div>
    <!-- /BANNER -->
  </div>
  <!-- /BANNER WRAP -->

<?php
include_once('slidenews.php');
?>

  <div class="layout-content-full grid-limit">
 <div class="row">
	<div class="col-lg-12">
		<div class="alert alert-warning" role="alert">
			
			Ürünü aldıktan sonra oyuna giriş yapıp 30 saniye bekleyiniz, 30 saniye içerisinde ürün üzerinize gelecektir. Üzerinizde boş alan olmasına dikkat ediniz! Eğer zaten ürün aldığınız oyundaysanız 1 kere lobiye dönüp tekrar giriş yapınız.<br><br>
<span class="badge badge-warning">NOT:</span> <b>"Ürün 30 saniye içerisinde verilecektir"</b> Yazısını gördükten sonra oyundan çıkarsanız ürünü alamazsınız!
		</div>
	</div>
</div>

<div class="filter-heading multiple-items bottom-spaced gizlebunu">
        <div class="filter-heading-actions">
          <div class="dropdown-simple-wrap" style="position: relative;">
            <div id="filter-01-dropdown-trigger" class="dp-current-option">
              <div id="filter-01-dropdown-option-value" class="dp-current-option-value">
                <p class="dp-option-text" style="font-size: .825em;">KATEGORİLER</p>
              </div>
              <svg class="arrow-icon">
                <use xlink:href="#svg-arrow"></use>
              </svg>
            </div>
            <div id="filter-01-dropdown" class="dp-options small" style="position: absolute; z-index: 9999; top: -11.3333px; left: 0px; visibility: hidden; opacity: 0; transition: all 0.4s ease-in-out 0s;width:200px;padding-left:15px;" >
              <div class="dp-option">
                <a class="dp-option-text" href="<?php echo $domain2.'market'; ?>" style="font-size: .825em;">Tüm Ürünler</a>
              </div>

<?php
$kategoriler=mysql_query("SELECT * FROM UrunKategorileri WHERE AltKategori=0");
	while ($deger = mysql_fetch_array($kategoriler)) {	
$ustkat = $deger['KategoriAdi'];	
$altsayi = $kpanel->prepare("select count(*) from UrunKategorileri where (AltKategori = '1') && (UstKategori = '".$ustkat."')");
$result = $altsayi->execute();
$altsayi   = $altsayi->fetchColumn();	

?>
            <div class="dp-option">

              <a href="?kategori=<?php echo $deger['UrunKategoriId']; ?>" class="dp-option-text " style="font-size: .825em;"><?php echo $deger['KategoriAdi']; ?></a>
			  </div>
              
<?php 
$ustkat = $deger['KategoriAdi'];
$altkontrol = $kpanel->query("select * from UrunKategorileri where (AltKategori = '1') && (UstKategori = '".$ustkat."')");

if($altsayi != 0){


foreach($altkontrol as $altk){
	echo '<div class="dp-option" style="padding-left:20px;">';
	  echo '<a href="?kategori='.$deger['UrunKategoriId'].'&altkategori='.$altk['UrunKategoriId'].'" class="dp-option-text" style="font-size: .825em;">'.$altk['KategoriAdi'].'</a>';
	echo '</div>';
}


}

?>			  

              
            
<?php
	}
?>			  
			  
			  

            </div>

          </div>

        </div>

        
      </div>


  
    <div class="layout-content-5 layout-item-1-3" style="padding-top: 0px;">

      <div class="layout-sidebar layout-item gutter-medium">
        <div class="widget-sidebar">
          <div class="section-title-wrap violet no-space">
            <h2 class="section-title medium">Kategoriler</h2>
            <div class="section-title-separator"></div>
          </div>

          <ul class="dropdown-list accordion">
			
			<li class="dropdown-list-item selected">
              <a class="dropdown-list-item-link" href="<?php echo $domain2.'market'; ?>">Tüm Ürünler</a>
            </li>
<?php
$kategoriler=mysql_query("SELECT * FROM UrunKategorileri WHERE AltKategori=0");
	while ($deger = mysql_fetch_array($kategoriler)) {	
$ustkat = $deger['KategoriAdi'];	
$altsayi = $kpanel->prepare("select count(*) from UrunKategorileri where (AltKategori = '1') && (UstKategori = '".$ustkat."')");
$result = $altsayi->execute();
$altsayi   = $altsayi->fetchColumn();	
if($altsayi != 0){
	$akordiyon = 'accordion-trigger';
}else{
	$akordiyon = '';
}
?>
            <li class="dropdown-list-item selected">
<?php
if($altsayi != 0){
?>			
<div class="accordion-action">
<svg class="arrow-icon medium">
  <use xlink:href="#svg-arrow-medium"></use>
</svg>
</div>
<?php
}
?>
              <a href="?kategori=<?php echo $deger['UrunKategoriId']; ?>" class="dropdown-list-item-link <?php echo $akordiyon; ?>"><?php echo $deger['KategoriAdi']; ?></a>
			  
              
<?php 
$ustkat = $deger['KategoriAdi'];
$altkontrol = $kpanel->query("select * from UrunKategorileri where (AltKategori = '1') && (UstKategori = '".$ustkat."')");

if($altsayi != 0){
echo '<ul class="dropdown-inner-list accordion-content accordion-open">';

foreach($altkontrol as $altk){
	echo '<li class="dropdown-inner-list-item">';
	  echo '<a href="?kategori='.$deger['UrunKategoriId'].'&altkategori='.$altk['UrunKategoriId'].'" class="dropdown-inner-list-item-title">'.$altk['KategoriAdi'].'</a>';
	echo '</li>';
}

echo '</ul>';
}

?>			  

              
            </li>
<?php
	}
?>

          </ul>
        </div>
        
          <div class="grid-1col gutter-medium">
		  
<div class="widget-sidebar">
        <div class="section-title-wrap violet small-space">
          <h2 class="section-title medium">Son Satılanlar</h2>
          <div class="section-title-separator"></div>
        </div>
        <div class="table standings">
          <div class="table-row-header">
            <div class="table-row-header-item position">
              <p class="table-row-header-title">Alan Kişi</p>
            </div>
            <div class="table-row-header-item position">
              <p class="table-row-header-title">Ürün Adı</p>
            </div>

          </div>
          <div class="table-rows">		  
		  
		  
<?php
$alinanurunler = $kpanel->query("select * from UrunLog order by UrunLogId desc limit 5");

foreach($alinanurunler as $alinan){
	$i++;
$urun = $kpanel->prepare("select * from Urunler where (UrunId = :UrunId)");
$result = $urun->execute(array(":UrunId" => $alinan["UrunId"]));
$urun  = $urun->fetch(PDO::FETCH_ASSOC);	

$alankisi = $kpanel->prepare("select * from Kullanicilar where (KullaniciId = :KullaniciId)");
$result = $alankisi->execute(array(":KullaniciId" => $alinan["KullaniciId"]));
$alankisi  = $alankisi->fetch(PDO::FETCH_ASSOC);

$grup = $yetkiler->prepare("select * from perm_playergroups where (playeruuid = '".$alankisi["uuid"]."') && (groupid != '16') && (groupid != '17') && (groupid != '18') order by groupid desc");
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
	   echo '<a href="'.$domain2.'profil/'.$alankisi['username'].'" style="color:'.$renk.'">';
		echo '<div class="team-info-wrap">';
		  echo '<img class="team-logo small" src="https://cravatar.eu/avatar/'.$alankisi['username'].'" alt="'.$alankisi['username'].'">';
		  echo '<div class="team-info">';
			echo '<p class="team-name" style="text-transform:none;color:'.$renk.'">'.$alankisi['username'].'</p>';
			echo '<p class="team-country">'.$grupadi['name'].'</p>';
		  echo '</div>';
		echo '</div>';
		echo '</a>';
	  echo '</div>';
	  echo '<div class="table-row-item">';
	  echo '<form action="'.$domain2.'satinal" method="POST">';
			echo '<input type="hidden" name="urunid" value="'.$urun['UrunId'].'">';
			echo '<button type="submit" class="urunbuton" style="font-size:12px;background: transparent;font-weight:700;">'.$urun['Adi'].'</button>';
		echo '</form>';
	  echo '</div>';
	  
echo '</div>';

}

?>		  
	          </div>
        </div>
      </div>	  
		  

<div class="widget-sidebar">
        <div class="section-title-wrap violet small-space">
          <h2 class="section-title medium">Popüler Ürünler</h2>
          <div class="section-title-separator"></div>
        </div>
        <div class="table standings">
          <div class="table-row-header">
            <div class="table-row-header-item position">
              <p class="table-row-header-title">Ürün</p>
            </div>
            <div class="table-row-header-item position">
              <p class="table-row-header-title">Satılan</p>
            </div>

          </div>
          <div class="table-rows">		  
		  
		  
<?php
$sql = "select UrunId, count(*)  as siparissayisi from UrunLog group by UrunId order by siparissayisi desc limit 10";

if($query = mysql_query($sql))
{

while ($row = mysql_fetch_assoc($query))
{

$urun = $kpanel->prepare("select * from Urunler where (UrunId = :UrunId)");
$result = $urun->execute(array(":UrunId" => $row["UrunId"]));
$urun  = $urun->fetch(PDO::FETCH_ASSOC);	
	
echo '<div class="table-row">';
	  echo '<div class="table-row-item position">';
		echo '<div class="team-info-wrap">';
		  echo '<img class="team-logo small" src="'.$urun['Resim'].'" alt="'.$urun['Adi'].'">';
		  echo '<div class="team-info">';
		  
echo '<form action="'.$domain2.'satinal" method="POST">';
	echo '<input type="hidden" name="urunid" value="'.$urun['UrunId'].'">';
	echo '<button type="submit" class="urunbuton" style="font-size:12px;background: transparent;font-weight:700;">'.$urun['Adi'].'</button>';
echo '</form>';		  

		  echo '</div>';
		echo '</div>';

	  echo '</div>';
	  echo '<div class="table-row-item">';
		echo '<p class="table-text bold">'.$row['siparissayisi'].'</p>';
	  echo '</div>';
	  
echo '</div>';

}
}

?>		  
	          </div>
        </div>
      </div>



          </div>
          <!-- GRID 1COL -->
 
        <!-- /WIDGET SIDEBAR -->
      </div>
      <!-- /LAYOUT SIDEBAR -->

      <!-- LAYOUT BODY -->
      <div class="layout-body">
        <!-- WIDGET ITEM -->
        <div class="widget-item">
          <!-- SECTION TITLE WRAP -->
<?php
$ustkategori = $kpanel->prepare("select * from UrunKategorileri where (AltKategori = '0') && (UrunKategoriId = '".$_REQUEST['kategori']."')");
$result = $ustkategori->execute();
$ustkategori  = $ustkategori->fetch(PDO::FETCH_ASSOC);
$altkategorii = $kpanel->prepare("select * from UrunKategorileri where (AltKategori = '1') && (UrunKategoriId = '".$_REQUEST['altkategori']."')");
$result = $altkategorii->execute();
$altkategorii  = $altkategorii->fetch(PDO::FETCH_ASSOC);
?>		  
          <div class="section-title-wrap violet small-space">
            <h2 class="section-title medium">Ürünler
<?php
if($ustkategori['KategoriAdi'] != ''){
	echo ' - '.$ustkategori['KategoriAdi'];
}
if($altkategorii['KategoriAdi'] != ''){
	echo ' - '.$altkategorii['KategoriAdi'];
}
?>			
	 		
			</h2>
            <div class="section-title-separator"></div>
          </div>
          <!-- /SECTION TITLE WRAP -->

          <!-- FILTER HEADING -->
          <div class="filter-heading multiple-items bottom-spaced">
            <!-- FILTER HEADING TEXT -->
            <p class="filter-heading-text">Toplam <?php echo $toplam_icerik; ?> ürün bulundu</p>
            <!-- /FILTER HEADING TEXT -->

            <!-- FILTER HEADING ACTIONS -->
            
            <!-- /FILTER HEADING ACTIONS -->
          </div> 
          <!-- /FILTER HEADING -->

          <!-- GRID 3COL -->
          <div class="grid-3col centered gutter-mid">
<?php
while($deger = mysql_fetch_assoc($sorgu)) {
?>

							  		
            <div class="product-preview">
              <div class="product-preview-img-wrap">
                <span>
                  <figure class="product-preview-img liquid" style="background-size: 100% !important;"> 
                    <img src="<?php echo $deger['Resim']; ?>" alt="<?php echo $deger['Adi']; ?>" style="max-width:100% !important;">
                  </figure>
                </span>
              </div>
              <!--<div class="bubble-ornament pink favourites">
                <i class="icon-heart heart-icon"></i>
              </div>
              <div class="bubble-ornament cyan tag">
                <i class="icon-tag tag-icon"></i>
              </div>-->
              <span class="product-preview-title" style="text-align:center;"><?php echo $deger['Adi']; ?></span>
              <div class="product-preview-info">
                <span class="product-preview-category"><?php echo $deger['KisaAciklama']; ?></span>
  
              </div>
              <div class="product-price-wrap">
                <p class="product-preview-price current" style="width:100%;text-align: center;"><?php echo $deger['Fiyat']; ?> Kredi</p>
              </div>
			  <form action="<?php echo $domain2; ?>satinal" method="POST">
				<input type="hidden" name="urunid" value="<?php echo $deger['UrunId']; ?>">
				<button type="submit" class="button small violet add-to-bag">İncele</button>
			  </form>

            </div>
<?php
							}?>	      
            
           

           

          </div>
          <!-- /GRID 3COL -->

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
<a href="?sayfa=<?php echo $sayfa-1; ?>&kategori=<?php echo $kategorinumarasi; ?>&altkategori=<?php echo $altkategorinumarasi; ?>" aria-controls="bootstrap-data-table" data-dt-idx="0" tabindex="0" class="page-link">
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
						<a class="page-navigation-item" href="?sayfa=<?php echo $s; ?>&kategori=<?php echo $kategorinumarasi; ?>&altkategori=<?php echo $altkategorinumarasi; ?>" aria-controls="bootstrap-data-table" data-dt-idx="1" tabindex="0" class="page-link"><?php echo $s; ?></a>
					<?php
					}
				}
				
if($sayfa != $toplam_sayfa) {				
				
?>
<a href="?sayfa=<?php echo $sayfa+1; ?>&kategori=<?php echo $kategorinumarasi; ?>&altkategori=<?php echo $altkategorinumarasi; ?>" aria-controls="bootstrap-data-table" data-dt-idx="0" tabindex="0" class="page-link">
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
        <!-- /WIDGET ITEM -->
      </div>
      <!-- /LAYOUT BODY -->
    </div>
    <!-- /LAYOUT CONTENT 5 -->
  </div>
  <!-- LAYOUT CONTENT FULL -->
<?php
include_once('footer.php');
?>