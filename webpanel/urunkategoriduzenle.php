<?php 
include_once('header2.php'); 
echo '<style>.close {
    margin-top: -29px;
}</style>';
$yeniurunm = '';
$anasayfam = '';
$urunlerm = '';
$urunkategorilerm = 'active';
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

 $kategori = $kpanel->prepare("select * from UrunKategorileri where (UrunKategoriId = '".$_REQUEST['id']."')");
 $result = $kategori->execute();
 $kategori   = $kategori->fetch(PDO::FETCH_ASSOC);
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
							<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Ürün Kategoriler <span> - Kategori Düzenle</h4>
						</div>


					</div>

					<div class="breadcrumb-line">
						<ul class="breadcrumb">
							<li><a href="/webpanel/"><i class="icon-home2 position-left"></i> Anasayfa</a></li>
							<li class="active">Kategori Düzenle</li>
						</ul>


					</div>
				</div>
				<div class="content">
					<div class="panel panel-flat">
						<div class="panel-body">
						<?php 
						if($_SESSION['yenikategori'] != ''){
							echo '<div class="alert alert-success" role="alert">'.$_SESSION['yenikategori'].'</div>';
							$_SESSION['yenikategori'] = '';
						}
						
						?>
							<form class="form-horizontal" method="POST" enctype="multipart/form-data">
								<fieldset class="content-group">
									<legend class="text-bold"><i class="fa fa-edit"></i> Kategori Düzenle</legend>
									<div class="form-group">
										<label class="control-label col-lg-2">Kategori Adı</label>
										<div class="col-lg-10">
											<input type="text" class="form-control" name="kategoriadi" value="<?php echo $kategori['KategoriAdi']; ?>" required>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-lg-2">Üst Kategori</label>
										<div class="col-lg-10">
											<select class="form-control" name="ustkategori" id="kategori" required>

											
<?php 
if($kategori['AltKategori'] == '0'){
	echo '<option value="0">Üst Kategori</option>';
}else{
	echo '<option value="'.$kategori['UstKategori'].'">'.$kategori['UstKategori'].'</option>';
}
echo '<option value="0">Üst Kategori</option>';
$kategoriler = $kpanel->query("select * from UrunKategorileri where (AltKategori = '0')");
foreach($kategoriler as $kate){
		echo '<option value="'.$kate['KategoriAdi'].'">'.$kate['KategoriAdi'].'</option>';
		
}
?>
											</select>
										</div>
									</div>
								</fieldset>
								
								<div class="text-right">
									<input type="submit" class="btn btn-success" style="min-width:150px;" onclick="return yenikategori();" value="Güncelle" name="yenikategoriekle">
								</div>
							</form>
						</div>
					</div>
<?php
if($_POST['yenikategoriekle']){

	$kategoriadi = $_POST['kategoriadi'];
if($_POST['ustkategori'] == '0'){
	$ustkategori = '';
	$altkategori = '0';
}else{
	$ustkategori = $_POST['ustkategori'];
	$altkategori = '1';
}
	if($kategori['AltKategori'] == '0' ){
		
		$ustkaydet = $kpanel->query("update UrunKategorileri set UstKategori = '".$kategoriadi."') where (UstKategori = '".$kategori['KategoriAdi']."')");
	}
	
	$kategorikaydet = $kpanel->query("update UrunKategorileri set KategoriAdi = '".$kategoriadi."', AltKategori = '".$altkategori."', UstKategori = '".$ustkategori."') where (UrunKategoriId = '".$kategori['UrunKategoriId']."')");
	$_SESSION['yenikategori'] = 'Kategoriniz başarıyla güncellenmiştir.';
	header('Location:urunkategoriduzenle.php');
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
function yenikategori() {
return	confirm("Kategori güncellenecektir, onaylıyor musunuz?");
}
</script>
</body>
</html>