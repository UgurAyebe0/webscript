<?php 
include_once('header2.php'); 
echo '<style>.close {
    margin-top: -29px;
}</style>';
$yenireferansm = 'active';
$anasayfam = '';
$urunlerm = '';
$yenikategorim = '';
$kategorilerm = '';
$sayfaeklem = '';
$sayfalarm = '';
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
      $new_image = imagecreatetruecolor(640, 468);
	  imagefill($new_image, 0, 0, imagecolorallocate($new_image, 255, 255, 255));
      imagecopyresampled($new_image, $this->image, ((640 - $width) / 2), ((468 - $height) / 2), 0, 0, $width, $height, $this->getWidth(), $this->getHeight());
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
							<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Referanslar <span> - Yeni Referans Ekle</h4>
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
							<li class="active">Yeni Referans Ekle</li>
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
						if($_SESSION['yeniurun'] != ''){
							echo $core->bootstrap->alertBS($_SESSION['yeniurun'],"info",15,true);
							$_SESSION['yeniurun'] = '';
						}
						
						?>
							<form class="form-horizontal" method="POST" enctype="multipart/form-data">
								<fieldset class="content-group">
									<legend class="text-bold"><i class="fa fa-plus"></i> Yeni Referans Ekle</legend>

									<div class="form-group">
										<label class="control-label col-lg-2">Referans TR</label>
										<div class="col-lg-10">
											<input type="text" class="form-control" name="baslik" required>
										</div>
									</div>
									
									<div class="form-group">
										<label class="control-label col-lg-2">Referans EN</label>
										<div class="col-lg-10">
											<input type="text" class="form-control" name="baslik_EN" required>
										</div>
									</div>

									<div class="form-group">
										<label class="control-label col-lg-2">Açıklama TR</label>
										<div class="col-lg-10">
											<textarea class="form-control ckeditor" name="aciklama"></textarea>
										</div>
									</div>
									
									<div class="form-group">
										<label class="control-label col-lg-2">Açıklama EN</label>
										<div class="col-lg-10">
											<textarea class="form-control ckeditor" name="aciklama_EN"></textarea>
										</div>
									</div>
									
									<div class="form-group">
										<label class="control-label col-lg-2">Kapak Fotoğrafı</label>
										<div class="col-lg-10">
											<input type="file" class="btn btn-block btn-info" name="gorsel" id="gorsel" lang="tr">
										</div>
									</div>
								</fieldset>
								<div class="text-right">
									<input type="submit" class="btn btn-success" style="min-width:150px;" onclick="return yeniurun();" value="Kaydet" name="yeniurunekle">
								</div>
							</form>
						</div>
					</div>
<?php
if($_POST['yeniurunekle']){
	$isim = '';
	if($_FILES["gorsel"]["tmp_name"] != NULL){
		$kaynak		= $_FILES["gorsel"]["tmp_name"]; // Yüklenen dosyanın adı	
		$yukle		= $klasor.basename($_FILES['gorsel']['name']);	
		$dosya		= $_FILES['gorsel']['name'];
	
		$urlresim=$kaynak;//urleyi alıyoruz
		$uzanti=substr($dosya,-4);//urlnin son 4 harfini alıyoruz.Bu uzantıya denk geliyor.
	
		$isim = "ref_".rand(999,99999).$uzanti;
		$konum = "../images/referanslar/".$isim;//resim kayıt edileceği yer.
		touch($konum);
		$al=file_get_contents($urlresim);
		$kaydet=file_put_contents($konum,$al);	
		$image = new SimpleImage();
		$image->load($konum);	
		$image->save($konum);
	}
	
	$refkaydet = $core->db->query("insert into referanslar (baslik, baslik_EN, aciklama, aciklama_EN, gorsel, yayin, stamp) values (:baslik, :baslik_EN, :aciklama, :aciklama_EN, :gorsel, :yayin, :stamp);",array('baslik' => $_POST['baslik'], 'baslik_EN' => $_POST['baslik_EN'], 'aciklama' => $_POST['aciklama'], 'aciklama_EN' => $_POST['aciklama_EN'], 'gorsel' => $isim, 'yayin' => '1', 'stamp' => time()));
	$_SESSION['yeniurun'] = 'Referans başarıyla sisteme eklenmiştir.';
	header('Location:yenireferans.php');
}
?>
					<?php include_once('footer.php'); ?>
				</div>
			</div>
		</div>
	</div>
<script>
	$(document).ready(function() {
		$("#kategori").select2();  
	});
</script>
<script>
function yeniurun() {
return	confirm("Girdiğiniz referans sisteme eklenecektir, onaylıyor musunuz?");
}
</script>
</body>
</html>