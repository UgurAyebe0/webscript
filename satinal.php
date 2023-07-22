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
@media screen and (min-width:680px){
	.product-slider {
		height: auto !important;
		overflow: hidden;
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

  <!-- LAYOUT CONTENT FULL -->
  <div class="layout-content-full layout-item gutter-big grid-limit">
  
<?php
$kid=$_SESSION["kid"];
$uuid=$_SESSION["uuid"];
$username=$_SESSION["username"];
if (!$_POST){
	echo '<div style="position: absolute;top: 50%;left: 40%;margin-left: -160px;margin-top: -70px;" class="alert alert-danger" role="alert">
		<h4 class="alert-heading">Opps üzgünüm!</h4>
		<hr>
		<p> Bir hata oluştu lütfen işlemi daha sonra tekrar dene. Seni anasayfaya yönlendiriyorum.</p>
	</div>
	<meta http-equiv="refresh" content="3;URL='.$domain2.'market">';
	exit();
}

$urunid=TemizVeri($_POST['urunid']);
$urunid=piril($_POST['urunid']); 
	$urunsayi=mysql_fetch_array(mysql_query("SELECT UrunId FROM Urunler ORDER BY UrunId DESC LIMIT 1"));
	if ($urunid > $urunsayi[0] || $urunid <=0) {
		?>
			<div style="position: absolute;top: 50%;left: 40%;margin-left: -160px;margin-top: -70px;" class="alert alert-danger" role="alert">
				<h4 class="alert-heading">Opps üzgünüm!</h4>
				<hr>
				<p> Bir hata oluştu lütfen işlemi daha sonra tekrar dene. Seni anasayfaya yönlendiriyorum.</p>
			</div>
			<meta http-equiv="refresh" content="3;URL=<?php echo $domain2; ?>market">
		<?php
		exit();
	}
$urunvarmi=mysql_fetch_array(mysql_query("SELECT COUNT(UrunId) FROM Urunler WHERE UrunId='$urunid' LIMIT 1"));
		if ($urunvarmi[0] == 0) {
			?>
				<div style="position: absolute;top: 50%;left: 40%;margin-left: -160px;margin-top: -70px;" class="alert alert-danger" role="alert">
					<h4 class="alert-heading">Opps üzgünüm!</h4>
					<hr>
					<p> Bir hata oluştu lütfen işlemi daha sonra tekrar dene. Seni anasayfaya yönlendiriyorum.</p>
				</div>
				<meta http-equiv="refresh" content="3;URL=<?php echo $domain2; ?>market">
			<?php
			exit();
		}
		?>
<?php
				if($_POST['satinonay']=='true') {
					$urunswismi=TemizVeri($_POST['swismi']);
					echo $urunswismi;
					$urundetay=mysql_fetch_array(mysql_query("SELECT Adi,Fiyat,Stok FROM Urunler WHERE UrunId='$urunid' LIMIT 1"));
					$kreditutari=mysql_fetch_array(mysql_query("SELECT Kredi FROM Kullanicilar WHERE KullaniciId='$kid'"));
					if ($kreditutari[0] >= $urundetay[1] ) {
						if ($urundetay[2]!=-1) {
							if ($urundetay[2]==0) {
								?>
								<div class="row">
									<div class="col-lg-12">
										<div class="alert alert-danger" role="alert">
											<span class="badge badge-danger">Başarısız</span>
											Yeterli stok yok. Lütfen daha sonra tekrar deneyiniz.
										</div>
									</div>
									<meta http-equiv="refresh" content="3;URL=<?php echo $domain2; ?>market">
								</div>
								<?php
							}
							else {
								$tarih = date("Y-m-d H:i:s", time());
								$ip_adresi = GetIP();
								$yenikredi=$kreditutari[0]-$urundetay[1];
								$kredicikar=mysql_query("UPDATE Kullanicilar SET Kredi = $yenikredi WHERE KullaniciId = '$kid'");
								$kredilog=mysql_query("INSERT INTO KrediLog (KullaniciId,EskiKredi,YeniKredi,Ip,Detay,Aciklama,Tarih) VALUES ($kid,$kreditutari[0],$yenikredi,'$ip_adresi','0','$urundetay[0]','$tarih')");
								$urunlog=mysql_query("INSERT INTO UrunLog (KullaniciId,UrunId,Ip,UrunFiyati,Tarih,UrunServerIsmi,Durum) VALUES ($kid,$urunid,'$ip_adresi',$urundetay[1],'$tarih','$urunswismi','0')");
								$stok=mysql_query("UPDATE Urunler SET Stok = Stok-1 WHERE UrunId = $urunid");
								?>
								<div class="row">
									<div class="col-lg-12">
										<div class="alert alert-success" role="alert">
											<span class="badge badge-success text-white">Başarılı</span>
											Ürününüz başarılı şekilde alındı en geç 1 saat içinde ürününüz oyunda gelecektir.
										</div>
									</div>
									<meta http-equiv="refresh" content="3;URL=<?php echo $domain2; ?>market">
								</div>
								<?php
							}
						}
						else {
							$tarih = date("Y-m-d H:i:s", time());
							$ip_adresi = GetIP();
							$yenikredi=$kreditutari[0]-$urundetay[1];
							$kredicikar=mysql_query("UPDATE Kullanicilar SET Kredi = $yenikredi WHERE KullaniciId = '$kid'");
							$kredilog=mysql_query("INSERT INTO KrediLog (KullaniciId,EskiKredi,YeniKredi,Ip,Detay,Aciklama,Tarih) VALUES ($kid,$kreditutari[0],$yenikredi,'$ip_adresi','0','$urundetay[0]','$tarih')");
							$urunlog=mysql_query("INSERT INTO UrunLog (KullaniciId,UrunId,Ip,UrunFiyati,Tarih,UrunServerIsmi,Durum) VALUES ($kid,$urunid,'$ip_adresi',$urundetay[1],'$tarih','$urunswismi','0')");
							?>
							<div class="row">
								<div class="col-lg-12">
									<div class="alert alert-success" role="alert">
										<span class="badge badge-success">Başarılı</span>
										Ürününüz başarılı şekilde alındı en geç 30 dakika içinde ürününüz oyunda gelecektir.
									</div>
								</div>
								<meta http-equiv="refresh" content="3;URL=<?php echo $domain2; ?>market">
							</div>
							<?php
						}
					}
					else {
						?>
						<div class="row">
							<div class="col-lg-12">
								<div class="alert alert-danger" role="alert">
									<span class="badge badge-danger">Başarısız</span>
									Yeterli krediniz yok. Lütfen kredi yükleyiniz.
								</div>
							</div>
							<meta http-equiv="refresh" content="3;URL=/krediyukle">
						</div>
						<?php
					}
				}
				?>
<?php
						$urunler=mysql_query("SELECT * FROM Urunler WHERE UrunId='$urunid' LIMIT 1");
						while ($deger = mysql_fetch_array($urunler))
						{
					?>
<?php
	if($_POST['satinal']=="true") {
		$urunswismi=TemizVeri($_POST['swismi']);
		?> 
			<div class="product-category-wrap">
				<p class="product-price" style="font-weight:700;font-size:14px;margin-bottom:15px;text-align:center;">Ürünü gerçekten satın almak istiyor musun?</p>
				<form action="<?php echo $domain2; ?>satinal" method="POST" style="width:100%;text-align:center;">
					<input type="hidden" name="urunid" value="<?php echo $deger['UrunId']; ?>">
					<input type="hidden" name="satinonay" value="true">
					<input type="hidden" name="swismi" value="<?php echo $urunswismi; ?>">
					<button type="submit" class="button violet" style="margin-right:15px;">Evet 
					<div class="button-ornament">
					  <svg class="arrow-icon medium">
						<use xlink:href="#svg-arrow-medium"></use>
					  </svg>
					  <svg class="cross-icon small">
						<use xlink:href="#svg-cross-small"></use>
					  </svg>  
					</div>
					</button>
					<a class="button red" href="<?php echo $domain2; ?>market" style="text-decoration:none;">Hayır 
					<div class="button-ornament">
					  <svg class="arrow-icon medium">
						<use xlink:href="#svg-arrow-medium"></use>
					  </svg>
					  <svg class="cross-icon small">
						<use xlink:href="#svg-cross-small"></use>
					  </svg>
					</div>
					</a>
				</form>
			</div>
		<?php
	}
?>
    <div class="product-open-wrap">
      <div id="product-open-slider-01" class="product-slider-wrap">
        <div class="product-slider">
          <div class="product-slider-items">

            <div class="product-slider-item">
              <img src="<?php echo $deger['Resim']; ?>" alt="<?php echo $deger['Adi']; ?>" style="max-width:80%;height:auto;">
            </div>
          </div>
        </div>

        <!-- /PRODUCT SLIDER ROSTER ITEMS -->
      </div>
      <!-- /PRODUCT SLIDER WRAP -->

      <!-- PRODUCT OPEN -->
      <div class="product-open">
        <!-- PRODUCT NAME -->
        <p class="product-name"><?php echo $deger['Adi']; ?></p>
        <!-- /PRODUCT NAME -->


        <!-- PRODUCT PRICE -->
        <p class="product-price"><?php echo $deger['Fiyat']; ?> Kredi</p>
        <!-- /PRODUCT PRICE -->

        <!-- PRODUCT FEATURES -->
        <div class="product-features">
          <!-- PRODUCT FEATURE -->
          <div class="product-feature" style="margin-bottom: 20px;">
            <!-- PRODUCT FEATURE ICON -->
            <i class="product-feature-icon fa fa-calendar"></i>
            <!-- /PRODUCT FEATURE ICON -->

            <!-- PRODUCT FEATURE INFO -->
            <div class="product-feature-info">
              <!-- PRODUCT FEATURE TITLE -->
              <p class="product-feature-title">Ürün Süresi:</p>
              <!-- /PRODUCT FEATURE TITLE -->

              <!-- PRODUCT FEATURE TEXT -->
              <p class="product-feature-text">
			   <?php 
			   if ($deger['Sure']=='-1') {
			   	echo "Sınırsız";
			   }
			   else {
			   	echo $deger['Sure']." Gün";
			   }
			   ?>
			  </p>
              <!-- /PRODUCT FEATURE TEXT -->
            </div>
            <!-- /PRODUCT FEATURE INFO -->
          </div>
          <!-- /PRODUCT FEATURE -->

          <!-- PRODUCT FEATURE -->
          <div class="product-feature" style="margin-bottom: 20px;">
            <!-- PRODUCT FEATURE ICON -->
           <i class="product-feature-icon fa fa-map-marker"></i>
            <!-- /PRODUCT FEATURE ICON -->

            <!-- PRODUCT FEATURE INFO -->
            <div class="product-feature-info">
              <!-- PRODUCT FEATURE TITLE -->
              <p class="product-feature-title">Geçerli Olduğu Yerler:</p>
              <!-- /PRODUCT FEATURE TITLE -->

              <!-- PRODUCT FEATURE TEXT -->
              <p class="product-feature-text"><?php echo $deger['GecerliYerler']; ?></p>
              <!-- /PRODUCT FEATURE TEXT -->
            </div>
            <!-- /PRODUCT FEATURE INFO -->
          </div>
          <!-- /PRODUCT FEATURE -->

          <!-- PRODUCT FEATURE -->
          <div class="product-feature" style="margin-bottom: 20px;">
            <!-- PRODUCT FEATURE ICON -->
            <i class="product-feature-icon icon-layers"></i>
            <!-- /PRODUCT FEATURE ICON -->

            <!-- PRODUCT FEATURE INFO -->
            <div class="product-feature-info">
              <!-- PRODUCT FEATURE TITLE -->
              <p class="product-feature-title">Stok Durumu:</p>
              <!-- /PRODUCT FEATURE TITLE -->

              <!-- PRODUCT FEATURE TEXT -->
              <p class="product-feature-text">
			   <?php 
			   if ($deger['Stok']=='-1') {
			   	echo "Sınırsız";
			   }
			   else {
			   	echo $deger['Stok']." Adet";
			   }
			   ?> 
			  
			  </p>
              <!-- /PRODUCT FEATURE TEXT -->
            </div>
            <!-- /PRODUCT FEATURE INFO -->
          </div>
          <!-- /PRODUCT FEATURE -->
        </div>
        <!-- /PRODUCT FEATURES -->


        <div class="product-actions">
		
<?php
if($_POST['satinal']!="true") {
?>
	<div class="card p-30">
		<?php
		if ($deger['Stok']=='0') {
		?>
			<button type="button" class="button violet" aria-disabled="true" disabled>Stok Yok</button>
			<?php
		}
		else {
			if ($deger['Adi']=='VIP' OR $deger['Adi']=='VIP+' OR $deger['Adi']=='MVP') {	
			?>
				<div class="alert alert-danger" role="alert">			
					<span class="badge badge-danger">Uyarı:</span> <b>"Sadece Aşağıda Seçtiğiniz Sunucudaki <?php echo $vipad; ?> Eşyalarını Alırsınız!"</b> 
					<p>Seçimde Yaptığınız Herhangi Bir Hatada CC-Network Sorumlu Değildir!</p>
					<p>Lütfen Dikkatli Seçim Yapınız, İyi Oyunlar...</p>
				</div>
				</br>
				<form action="<?php echo $domain2; ?>satinal" method="POST">
					<input type="hidden" name="urunid" value="<?php echo $deger['UrunId']; ?>">
					<input type="hidden" name="satinal" value="true">
					<label>Özel Eşyalarınızı Hangi Sunucuda Almak istiyorsunuz?</label>
					<select name="swismi" style="font-size:15px;">
					  <option value="faction">Faction</option>
					  <option value="skyblock">SkyBlock</option>
					  <option value="skypvp">SkyPvP</option>
					</select>
					</br></br>
					<button type="submit" class="button violet">Satın Al
					<div class="button-ornament">
					  <svg class="arrow-icon medium">
						<use xlink:href="#svg-arrow-medium"></use>
					  </svg>
					  <svg class="cross-icon small">
						<use xlink:href="#svg-cross-small"></use>
					  </svg>
					</div>
					</button>
				</form>
				<?php
				}
				else {
				?>
				<form action="<?php echo $domain2; ?>satinal" method="POST">
					<input type="hidden" name="urunid" value="<?php echo $deger['UrunId']; ?>">
					<input type="hidden" name="satinal" value="true">
					<button type="submit" class="button violet">Satın Al
					<div class="button-ornament">
					  <svg class="arrow-icon medium">
						<use xlink:href="#svg-arrow-medium"></use>
					  </svg>
					  <svg class="cross-icon small">
						<use xlink:href="#svg-cross-small"></use>
					  </svg>
					</div>
					</button>
				</form>
				<?php
				}
		} ?>
	</div>
<?php } ?>		
		


        </div>


      </div>
    </div>

    <div id="tab-product-page" class="tab-wrap border-bottom">
      <!-- TAB HEADER -->
      <div class="tab-header border-top items-3">
        <!-- TAB HEADER ITEM -->
        <div class="tab-header-item selected">
          <!-- TAB HEADER ITEM TEXT -->
          <p class="tab-header-item-text">Açıklama</p>
          <!-- /TAB HEADER ITEM TEXT -->
        </div>
        <!-- /TAB HEADER ITEM -->
      </div>
      <!-- /TAB HEADER -->

      <!-- TAB BODY -->
      <div class="tab-body">
        <!-- TAB ITEM -->
        <div class="tab-item">
          <div class="post-open">
            <div class="post-open-body">
              <!-- POST OPEN CONTENT -->

                <?php echo $deger['Aciklama']; ?>
       
              <!-- /POST OPEN CONTENT -->
            </div>
          </div>
        </div>
        <!-- /TAB ITEM -->
      </div>
      <!-- /TAB BODY -->
    </div>
    <!-- /TAB WRAP -->
<?php
						}
?>

  </div>
  <!-- LAYOUT CONTENT FULL -->

<?php
include_once('footer.php');
?>