<?php 
include_once('header2.php'); 
echo '<style>.close {
    margin-top: -29px;
}</style>';

$ssslerm = 'active';
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
      $new_image = imagecreatetruecolor(850, 700);
	  imagefill($new_image, 0, 0, imagecolorallocate($new_image, 255, 255, 255));
      imagecopyresampled($new_image, $this->image, ((850 - $width) / 2), ((700 - $height) / 2), 0, 0, $width, $height, $this->getWidth(), $this->getHeight());
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
							<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">S.S.S. <span> - Yeni Soru Ekle</h4>
						</div>

	
					</div>

					<div class="breadcrumb-line">
						<ul class="breadcrumb">
							<li><a href="/webpanel/"><i class="icon-home2 position-left"></i> Anasayfa</a></li>
							<li class="active">Soru Ekle</li>
						</ul>
						<div class="" style="float:right;padding-top:5px;padding-bottom:5px;">
							<a href="/webpanel/sssler.php" class="btn btn-primary btn-sm" style="margin-right:10px;"> SSS Listesi <i class="fa fa-list-ul"></i></a>
							<a href="/webpanel/yenisss.php" class="btn btn-warning btn-sm" style="margin-right:10px;"> Yeni Soru <i class="fa fa-plus"></i></a>
							<a href="/webpanel/ssskategoriler.php" class="btn btn-primary btn-sm" style="margin-right:10px;"> Kategoriler <i class="fa fa-folder"></i></a>
							<a href="/webpanel/yenissskategori.php" class="btn btn-primary btn-sm" style="margin-right:10px;"> Yeni Kategori <i class="fa fa-plus"></i></a>
						</div>

					</div>
				</div>
				<div class="content">
					<div class="panel panel-flat">
						<div class="panel-body">
						<?php 
						if($_SESSION['yenisayfa'] != ''){
							echo '<div class="alert alert-success" role="alert">'.$_SESSION['yenisayfa'].'</div>';
							$_SESSION['yenisayfa'] = '';
						}
						
						?>
							<form class="form-horizontal" method="POST" enctype="multipart/form-data">
								<fieldset class="content-group">
									<legend class="text-bold"><i class="fa fa-plus"></i> Soru Ekle</legend>

									<div class="form-group">
										<label class="control-label col-lg-2">Soru</label>
										<div class="col-lg-10">
											<input type="text" class="form-control" name="soru" required>
										</div>
									</div>
									
			

									<div class="form-group">
										<label class="control-label col-lg-2">Cevap</label>
										<div class="col-lg-10">
											<textarea class="form-control ckeditor" name="cevap"></textarea>
										</div>
									</div>
									
									<div class="form-group">
										<label class="control-label col-lg-2">Kategori</label>
										<div class="col-lg-10">
											<select class="form-control" name="kategori" id="kategori" required>
											<option>Lütfen Kategori Seçiniz</option>
<?php 
$kategoriler = $db->query("select * from ssskategoriler");
foreach($kategoriler as $kategori){


		echo '<option value="'.$kategori['id'].'">'.$kategori['kategori_TR'].'</option>';

	
}
?>
											</select>
										</div>
									</div>
									
									<div class="form-group">
										<label class="control-label col-lg-2">Sira</label>
										<div class="col-lg-10">
											<input type="text" class="form-control" name="sira" required>
										</div>
									</div>

								</fieldset>
								<div class="text-right">
									<input type="submit" class="btn btn-success" style="min-width:150px;" onclick="return yenisayfa();" value="Kaydet" name="yenisayfaekle">
								</div>
							</form>
						</div>
					</div>
<?php
if($_POST['yenisayfaekle']){
	$soru = $_POST['soru'];
	$cevap = $_POST['cevap'];
	$zaman = time();
	$sira = $_POST['sira'];
	$kategorii = $_POST['kategori'];
	
	
	$urunkaydet = $db->query("insert into sss (soru, cevap, yayin, sira, stamp, kategori) values ('$soru', '$cevap', '1', '$sira', '$zaman', '$kategorii')");
	$_SESSION['yenisayfa'] = 'Soru başarıyla sisteme eklenmiştir.';
	header('Location:yenisss.php');
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
function yenisayfa() {
return	confirm("Girdiğiniz soru sisteme eklenecektir, onaylıyor musunuz?");
}
</script>
</body>
</html>