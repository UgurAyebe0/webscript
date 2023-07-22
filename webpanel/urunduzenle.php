<?php 
include_once('header2.php'); 

$yeniurunm = '';
$anasayfam = '';
$urunlerm = '';
$yenikategorim = '';
$kategorilerm = '';
$sayfaeklem = '';
$sayfalarm = '';
$urunduzenlem = 'active';
$urun = $db->prepare("select * from urunler where (id = '".$_REQUEST['p']."')");
$result = $urun->execute();
$urun   = $urun->fetch(PDO::FETCH_ASSOC);
class SimpleImage {
 
   var $image;
   var $image_type;
 
   function load($filename) {
 
      $image_info = getimagesize($filename);
      $this->image_type = $image_info[2];
      if( $this->image_type == IMAGETYPE_JPEG ) {
 
         $this->image = imagecreatefromjpeg($filename);
      } elseif( $this->image_type == IMAGETYPE_GIF ) {
 
         $this->image = imagecreatefromgif($filename);
      } elseif( $this->image_type == IMAGETYPE_PNG ) {
 
         $this->image = imagecreatefrompng($filename);
      }
   }
   function save($filename, $image_type=IMAGETYPE_JPEG, $compression=100, $permissions=null) {
 
      if( $image_type == IMAGETYPE_JPEG ) {
         imagejpeg($this->image,$filename,$compression);
      } elseif( $image_type == IMAGETYPE_GIF ) {
 
         imagegif($this->image,$filename);
      } elseif( $image_type == IMAGETYPE_PNG ) {
 
         imagepng($this->image,$filename);
      }
      if( $permissions != null) {
 
         chmod($filename,$permissions);
      }
   }
   function output($image_type=IMAGETYPE_JPEG) {
 
      if( $image_type == IMAGETYPE_JPEG ) {
         imagejpeg($this->image);
      } elseif( $image_type == IMAGETYPE_GIF ) {
 
         imagegif($this->image);
      } elseif( $image_type == IMAGETYPE_PNG ) {
 
         imagepng($this->image);
      }
   }
   function getWidth() {
 
      return imagesx($this->image);
   }
   function getHeight() {
 
      return imagesy($this->image);
   }
   function resizeToHeight($height) {
 
      $ratio = $height / $this->getHeight();
      $width = $this->getWidth() * $ratio;
      $this->resize($width,$height);
   }
 
   function resizeToWidth($width) {
      $ratio = $width / $this->getWidth();
      $height = $this->getheight() * $ratio;
      $this->resize($width,$height);
   }
 
   function scale($scale) {
      $width = $this->getWidth() * $scale/100;
      $height = $this->getheight() * $scale/100;
      $this->resize($width,$height);
   }
 
   function resize($width,$height) {
      $new_image = imagecreatetruecolor(600, 600);
	  imagefill($new_image, 0, 0, imagecolorallocate($new_image, 255, 255, 255));
      imagecopyresampled($new_image, $this->image, ((600 - $width) / 2), ((600 - $height) / 2), 0, 0, $width, $height, $this->getWidth(), $this->getHeight());
      $this->image = $new_image;
   }
}
function seoUrl($kyilmaz){
 $harflerSayilarBosluklarTireler = '/[^\-\s\pN\pL]+/u';
 $bosluguYenileTirelerle = '/[\-\s]+/';
 $tr = array('ş','Ş','ı','I','İ','ğ','Ğ','ü','Ü','ö','Ö','Ç','ç','(',')','/',':',',');
 $eng = array('s','s','i','i','i','g','g','u','u','o','o','c','c','','','-','-','');
 $kyilmaz = str_replace($tr,$eng,$kyilmaz);
 $kyilmaz= preg_replace($harflerSayilarBosluklarTireler,'',mb_strtolower($kyilmaz,'UTF-8'));
 $kyilmaz= preg_replace($bosluguYenileTirelerle,'-',$kyilmaz);
 $kyilmaz = trim ($kyilmaz, '-');
 return $kyilmaz;
 }
?>
	<!-- Page container -->
	<div class="page-container">
		<!-- Page content -->
		<div class="page-content">
			<?php include_once('aside.php'); ?>
			<!-- Main content -->
			<div class="content-wrapper">
				<!-- Page header -->
				<div class="page-header page-header-default">
					<div class="page-header-content">
						<div class="page-title">
							<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Ürünler <span> - Ürün Düzenleme</h4>
						</div>

						<div class="heading-elements">
							<div class="heading-btn-group">
								<a href="#" class="btn btn-link btn-float has-text"><i class="icon-bars-alt text-primary"></i><span>İstatistik</span></a>
								<a href="#" class="btn btn-link btn-float has-text"><i class="icon-calendar5 text-primary"></i> <span>Ürünler</span></a>
							</div>
						</div>
					</div>

					<div class="breadcrumb-line">
						<ul class="breadcrumb">
							<li><a href="/webpanel/"><i class="icon-home2 position-left"></i> Anasayfa</a></li>
							<li class="active"><?php echo $urun['urunadi']; ?> - Ürün Düzenleme</li>
						</ul>

						<ul class="breadcrumb-elements">
							<li><a href="#"><i class="icon-comment-discussion position-left"></i> Destek</a></li>
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">
									<i class="icon-gear position-left"></i>
									Ayarlar
									<span class="caret"></span>
								</a>

								<ul class="dropdown-menu dropdown-menu-right">
									<li><a href="#"><i class="icon-user-lock"></i> Hesap Güvenliği</a></li>
									<li><a href="#"><i class="icon-statistics"></i> Analitik</a></li>
									<li><a href="#"><i class="icon-accessibility"></i> Ulaşabilirlik</a></li>
									<li class="divider"></li>
									<li><a href="#"><i class="icon-gear"></i> Tüm Ayarlar</a></li>
								</ul>
							</li>
						</ul>
					</div>
				</div>
				<div class="content">
					<div class="panel panel-flat">
						<div class="panel-body">
						<?php 
						if($_SESSION['urunduzenle'] != ''){
							echo '<div class="alert alert-success" role="alert">'.$_SESSION['urunduzenle'].'</div>';
							$_SESSION['urunduzenle'] = '';
						}
						
						?>
							<form class="form-horizontal" method="POST" enctype="multipart/form-data">
								<fieldset class="content-group">
									<legend class="text-bold"><i class="fa fa-edit"></i> Ürün Düzenleme</legend>

									<div class="form-group">
										<label class="control-label col-lg-2">Ürün Adı</label>
										<div class="col-lg-10">
											<input type="text" class="form-control" name="urunadi" value="<?php echo $urun['urunadi']; ?>" required>
										</div>
									</div>

									<div class="form-group">
										<label class="control-label col-lg-2">Kategori</label>
										<div class="col-lg-10">
											<select class="form-control" name="kategori" id="kategori" required>
											
<?php 
$secilikategori = $db->prepare("select * from kategoriler where (id = '".$urun['kategori']."')");
$result = $secilikategori->execute();
$secilikategori   = $secilikategori->fetch(PDO::FETCH_ASSOC);
$kategoriler = $db->query("select * from kategoriler where (yayin = '1')");
echo '<option value="'.$secilikategori['id'].'">'.$secilikategori['kategoriadi'].'</option>';
foreach($kategoriler as $kategori){
	echo '<option value="'.$kategori['id'].'">'.$kategori['kategoriadi'].'</option>';
}
?>
											</select>
										</div>
									</div>

									<div class="form-group">
										<label class="control-label col-lg-2">Açıklama</label>
										<div class="col-lg-10">
											<textarea class="form-control ckeditor" name="aciklama"><?php echo $urun['aciklama']; ?></textarea>
										</div>
									</div>

									<div class="form-group">
										<label class="control-label col-lg-2">Yükseklik</label>
										<div class="col-lg-10">
											<input type="text" class="form-control" name="yukseklik" value="<?php echo $urun['yukseklik']; ?>">
										</div>
									</div>
									
									<div class="form-group">
										<label class="control-label col-lg-2">En</label>
										<div class="col-lg-10">
											<input type="text" class="form-control" name="en" value="<?php echo $urun['en']; ?>">
										</div>
									</div>
									
									<div class="form-group">
										<label class="control-label col-lg-2">Boy</label>
										<div class="col-lg-10">
											<input type="text" class="form-control" name="boy" value="<?php echo $urun['boy']; ?>">
										</div>
									</div>
									
									<div class="form-group">
										<label class="control-label col-lg-2">Gramaj</label>
										<div class="col-lg-10">
											<input type="text" class="form-control" name="gramaj" value="<?php echo $urun['gramaj']; ?>">
										</div>
									</div>
									
									<div class="form-group">
										<label class="control-label col-lg-2">Renkler</label>
										<div class="col-lg-10">
											<input type="text" class="form-control" name="renkler" value="<?php echo $urun['renkler']; ?>">
										</div>
									</div>
									
									<div class="form-group">
										<label class="control-label col-lg-2">Görsel 1</label>
										<div class="col-lg-10">
											<input type="file" class="btn btn-block btn-info" name="gorsel" id="gorsel" lang="tr">
										</div>
									</div>
									
									<div class="form-group">
										<label class="control-label col-lg-2">Görsel 2</label>
										<div class="col-lg-10">
											<input type="file" class="btn btn-block btn-info" name="gorsel2" id="gorsel2" lang="tr">
										</div>
									</div>
									
									<div class="form-group">
										<label class="control-label col-lg-2">Görsel 3</label>
										<div class="col-lg-10">
											<input type="file" class="btn btn-block btn-info" name="gorsel3" id="gorsel3" lang="tr">
										</div>
									</div>
									
								</fieldset>
								<div class="text-right">
									<input type="submit" class="btn btn-success" style="min-width:150px;" onclick="return urunduzenle();" value="Kaydet" name="urunduzenle">
								</div>
							</form>
						</div>
					</div>
<?php
if($_POST['urunduzenle']){
	$isim = $urun['gorsel'];
	$isim2 = $urun['gorsel2'];
	$isim3 = $urun['gorsel3'];
	if($_FILES["gorsel"]["tmp_name"] != NULL){
		$kaynak		= $_FILES["gorsel"]["tmp_name"]; // Yüklenen dosyanın adı	
		$yukle		= $klasor.basename($_FILES['gorsel']['name']);	
		$dosya		= $_FILES['gorsel']['name'];
	
		$urlresim=$kaynak;//urleyi alıyoruz
		$uzanti=substr($dosya,-4);//urlnin son 4 harfini alıyoruz.Bu uzantıya denk geliyor.
	
		$isim = "urun_".rand(1000000,99999999999999).$uzanti;
		$konum = "../assets/images/urunler/".$isim;//resim kayıt edileceği yer.
		touch($konum);
		$al=file_get_contents($urlresim);
		$kaydet=file_put_contents($konum,$al);	
		$image = new SimpleImage();
		$image->load($konum);	
		$image->resizeToWidth(600);	
		$image->save($konum);
	}
	if($_FILES["gorsel2"]["tmp_name"] != NULL){
		$kaynak2		= $_FILES["gorsel2"]["tmp_name"]; // Yüklenen dosyanın adı	
		$yukle2		= $klasor.basename($_FILES['gorsel2']['name']);	
		$dosya2		= $_FILES['gorsel2']['name'];
	
		$urlresim2=$kaynak2;//urleyi alıyoruz
		$uzanti2=substr($dosya2,-4);//urlnin son 4 harfini alıyoruz.Bu uzantıya denk geliyor.
	
		$isim2 = "urun_".rand(1000000,99999999999999).$uzanti2;
		$konum2 = "../assets/images/urunler/".$isim2;//resim kayıt edileceği yer.
		touch($konum2);
		$al2=file_get_contents($urlresim2);
		$kaydet2=file_put_contents($konum2,$al2);	
		$image = new SimpleImage();
		$image->load($konum2);	
		$image->resizeToWidth(600);	
		$image->save($konum2);
	}
	if($_FILES["gorsel3"]["tmp_name"] != NULL){
		$kaynak3		= $_FILES["gorsel3"]["tmp_name"]; // Yüklenen dosyanın adı	
		$yukle3		= $klasor.basename($_FILES['gorsel3']['name']);	
		$dosya3		= $_FILES['gorsel3']['name'];
	
		$urlresim3=$kaynak3;//urleyi alıyoruz
		$uzanti3=substr($dosya3,-4);//urlnin son 4 harfini alıyoruz.Bu uzantıya denk geliyor.
	
		$isim3 = "urun_".rand(1000000,99999999999999).$uzanti3;
		$konum3 = "../assets/images/urunler/".$isim3;//resim kayıt edileceği yer.
		touch($konum3);
		$al3=file_get_contents($urlresim3);
		$kaydet3=file_put_contents($konum3,$al3);	
		$image = new SimpleImage();
		$image->load($konum3);
		$image->resizeToWidth(600);			
		$image->save($konum3);
	}
	$url = seoUrl($_POST['urunadi']);
	$urunguncelle = $core->db->query("update urunler set urunadi = :urunadi, urlkodu = :urlkodu, kategori = :kategori, yukseklik = :yukseklik, en = :en, boy = :boy, gramaj = :gramaj, renkler = :renkler, aciklama = :aciklama, gorsel = :gorsel, gorsel2 = :gorsel2, gorsel3 = :gorsel3, yayin = :yayin, stamp = :stamp where (id = :id);",array('urunadi' => $_POST['urunadi'], 'urlkodu' => $url, 'kategori' => $_POST['kategori'], 'yukseklik' => $_POST['yukseklik'], 'en' => $_POST['en'], 'boy' => $_POST['boy'], 'gramaj' => $_POST['gramaj'], 'renkler' => $_POST['renkler'], 'aciklama' => $_POST['aciklama'], 'gorsel' => $isim, 'gorsel2' => $isim2, 'gorsel3' => $isim3, 'yayin' => '1', 'stamp' => time(), 'id' => $_REQUEST['p']));
	$_SESSION['urunduzenle'] = 'Ürününüz başarıyla güncellenmiştir.';
	header('Location:urunduzenle.php?p='.$_REQUEST['p']);
}
?>
					<!-- /form horizontal -->			
					<?php include_once('footer.php'); ?>
				</div>
				<!-- /content area -->
			</div>
			<!-- /main content -->
		</div>
		<!-- /page content -->
	</div>
	<!-- /page container -->
<script>
	$(document).ready(function() {
		$("#kategori").select2();  
	});
</script>
<script>
function urunduzenle() {
return	confirm("Ürün güncellenecektir, onaylıyor musunuz?");
}
</script>
</body>
</html>