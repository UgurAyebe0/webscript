<?php 
include_once('header2.php'); 
ob_start();
echo '<style>.close {
    margin-top: -29px;
}</style>';
$yeniurunm = '';
$anasayfam = '';
$urunlerm = '';
$yenikategorim = '';
$kategorilerm = '';
$sayfaeklem = '';
$sayfalarm = '';
$haberlerm = '';
$habereklem = '';
$hizmetlerm = '';
$hizmeteklem = '';
$yeniresimm = '';
$yenislidem= 'active';
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
      $new_image = imagecreatetruecolor(1920, 800);
	  imagefill($new_image, 0, 0, imagecolorallocate($new_image, 255, 255, 255));
      imagecopyresampled($new_image, $this->image, ((1920 - $width) / 2), ((800 - $height) / 2), 0, 0, $width, $height, $this->getWidth(), $this->getHeight());
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
							<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Slider <span> - Yeni Slide Ekle</h4>
						</div>

					
					</div>

					<div class="breadcrumb-line">
						<ul class="breadcrumb">
							<li><a href="/webpanel/"><i class="icon-home2 position-left"></i> Anasayfa</a></li>
							<li class="active">Yeni Slide Ekle</li>
						</ul>

	
					</div>
				</div>
				<div class="content">
					<div class="panel panel-flat">
						<div class="panel-body">
						<?php 
						if($_SESSION['yeniresim'] != ''){
							
							$_SESSION['yeniresim'] = '';
							header('Location:/webpanel/sliderlar.php');
						}
						
						?>
							<form class="form-horizontal" method="POST" enctype="multipart/form-data">
								<fieldset class="content-group">
									<legend class="text-bold"><i class="fa fa-plus"></i> Yeni Slide Ekle</legend>
									<div class="form-group">
										<label class="control-label col-lg-2">Görsel</label>
										<div class="col-lg-10">
											<input type="file" class="btn btn-block btn-info" name="gorsel" id="gorsel" lang="tr" required>
										</div>
									</div>
									<div class="form-group">
									<label class="control-label col-lg-2">Link</label>
									<div class="col-lg-10">
									<input type="text" class="form-control" name="link" >
									</div>
									</div>	
									<div class="form-group">
									<label class="control-label col-lg-2">Buton Adı</label>
									<div class="col-lg-10">
									<input type="text" class="form-control" name="butonadi" >
									</div>
									</div>	
									<div class="form-group">
										<label class="control-label col-lg-2">Başlık</label>
										<div class="col-lg-10">
											<input type="text" class="form-control" name="baslik" >
										</div>
									</div>
	
									<div class="form-group">
									<label class="control-label col-lg-2">Açıklama</label>
									<div class="col-lg-10">
									<input type="text" class="form-control" name="aciklama" >
									</div>
									</div>	
				
								</fieldset>
								<div class="text-right">
									<input type="submit" class="btn btn-success" style="min-width:150px;" onclick="return yeniresim();" value="Kaydet" name="yeniresimekle">
								</div>
							</form>
						</div>
					</div>
<?php
if($_POST['yeniresimekle']){
	$isim = '';
	if($_FILES["gorsel"]["tmp_name"] != NULL){
		$kaynak		= $_FILES["gorsel"]["tmp_name"]; // Yüklenen dosyanın adı	
		$yukle		= $klasor.basename($_FILES['gorsel']['name']);	
		$dosya		= $_FILES['gorsel']['name'];
	
		$urlresim=$kaynak;//urleyi alıyoruz
		$uzanti=substr($dosya,-4);//urlnin son 4 harfini alıyoruz.Bu uzantıya denk geliyor.
	
		$isim = "galeri_".rand(999,9999999).$uzanti;
		$konum = "../images/home-slide/".$isim;//resim kayıt edileceği yer.
		touch($konum);
		$al=file_get_contents($urlresim);  
		$kaydet=file_put_contents($konum,$al);	
		$image = new SimpleImage();
		$image->load($konum);	
		#$image->resizeToWidth(1920);	
		$image->save($konum);
	}
	
	$link = $_POST['link'];
	$butonadi = $_POST['butonadi'];
	$baslik = $_POST['baslik'];
	$aciklama = $_POST['aciklama'];
	
	
	$slidekaydet = $db->query("insert into slider (link, butonadi, baslik, aciklama, gorsel, yayin) values ('$link', '$butonadi', '$baslik', '$aciklama', '$isim', '1')");
	$_SESSION['yeniresim'] = 'Slide başarıyla sisteme eklenmiştir.';
	header('Location:yenislide.php');
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
function yeniresim() {
return	confirm("Girdiğiniz slide sisteme eklenecektir, onaylıyor musunuz?");
}
</script>
</body>
</html>