<?php 
include_once('header2.php'); 
echo '<style>.close {
    margin-top: -29px;
}</style>';
$yeniurunm = '';
$anasayfam = '';
$urunlerm = '';
$yenikategorim = '';
$kategorilerm = '';
$sayfaeklem = '';
$sayfalarm = '';$iletisimm = 'active';
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
 
 $iletisim = $db->prepare("select * from iletisim where (id = '1')");
 $result = $iletisim->execute();
 $iletisim   = $iletisim->fetch(PDO::FETCH_ASSOC);
 
 
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
							<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">İletişim <span> - İletişim Bilgileri</h4>
						</div>
	
					</div>
					<div class="breadcrumb-line">
						<ul class="breadcrumb">
							<li><a href="/webpanel/"><i class="icon-home2 position-left"></i> Anasayfa</a></li>
							<li class="active">İletişim Bilgileri</li>
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
									<legend class="text-bold"><i class="fa fa-edit"></i> İletişim Bilgileri</legend>
									<div class="form-group">
										<label class="control-label col-lg-2">Telefon</label>
										<div class="col-lg-10">
											<input type="text" class="form-control" name="telefon" value="<?php echo $iletisim['telefon']; ?>">
										</div>
									</div>									<div class="form-group">										<label class="control-label col-lg-2">Faks</label>										<div class="col-lg-10">											<input type="text" class="form-control" name="faks" value="<?php echo $iletisim['faks']; ?>">										</div>									</div>									<div class="form-group">										<label class="control-label col-lg-2">GSM</label>										<div class="col-lg-10">											<input type="text" class="form-control" name="gsm" value="<?php echo $iletisim['gsm']; ?>">										</div>									</div>									<div class="form-group">										<label class="control-label col-lg-2">Adres</label>										<div class="col-lg-10">											<input type="text" class="form-control" name="adres" value="<?php echo $iletisim['adres']; ?>">										</div>									</div>									<div class="form-group">										<label class="control-label col-lg-2">İlçe</label>										<div class="col-lg-10">											<input type="text" class="form-control" name="ilce" value="<?php echo $iletisim['ilce']; ?>">										</div>									</div>									<div class="form-group">										<label class="control-label col-lg-2">İl</label>										<div class="col-lg-10">											<input type="text" class="form-control" name="il" value="<?php echo $iletisim['il']; ?>">										</div>									</div>									<div class="form-group">										<label class="control-label col-lg-2">Email</label>										<div class="col-lg-10">											<input type="text" class="form-control" name="email" value="<?php echo $iletisim['email']; ?>">										</div>									</div>									<div class="form-group">										<label class="control-label col-lg-2">Facebook</label>										<div class="col-lg-10">											<input type="text" class="form-control" name="facebook" value="<?php echo $iletisim['facebook']; ?>">										</div>									</div>									<div class="form-group">										<label class="control-label col-lg-2">Instagram</label>										<div class="col-lg-10">											<input type="text" class="form-control" name="instagram" value="<?php echo $iletisim['instagram']; ?>">										</div>									</div>									<div class="form-group">										<label class="control-label col-lg-2">Youtube</label>										<div class="col-lg-10">											<input type="text" class="form-control" name="youtube" value="<?php echo $iletisim['youtube']; ?>">										</div>									</div>									<div class="form-group">										<label class="control-label col-lg-2">Discord</label>										<div class="col-lg-10">											<input type="text" class="form-control" name="linkedin" value="<?php echo $iletisim['linkedin']; ?>">										</div>									</div>									<div class="form-group">										<label class="control-label col-lg-2">Twitter</label>										<div class="col-lg-10">											<input type="text" class="form-control" name="twitter" value="<?php echo $iletisim['twitter']; ?>">										</div>									</div>									<div class="form-group">										<label class="control-label col-lg-2">Google+</label>										<div class="col-lg-10">											<input type="text" class="form-control" name="google" value="<?php echo $iletisim['google']; ?>">										</div>									</div>									<div class="form-group">										<label class="control-label col-lg-2">Google Map Enlem</label>										<div class="col-lg-10">											<input type="text" class="form-control" name="enlem" value="<?php echo $iletisim['enlem']; ?>">										</div>									</div>									<div class="form-group">										<label class="control-label col-lg-2">Google Map Boylam</label>										<div class="col-lg-10">											<input type="text" class="form-control" name="boylam" value="<?php echo $iletisim['boylam']; ?>">										</div>									</div>
								</fieldset>
								<div class="text-right">
									<input type="submit" class="btn btn-success" style="min-width:150px;" onclick="return yenikategori();" value="Güncelle" name="iletisimguncelle">
								</div>
							</form>
						</div>
					</div>
<?php
if($_POST['iletisimguncelle']){
	
	$telefon = $_POST['telefon'];
	$faks = $_POST['faks'];
	$gsm = $_POST['gsm'];
	$adres = $_POST['adres'];
	$ilce = $_POST['ilce'];
	$il = $_POST['il'];
	$email = $_POST['email'];
	$facebook = $_POST['facebook'];
	$instagram = $_POST['instagram'];
	$youtube = $_POST['youtube'];
	$linkedin = $_POST['linkedin'];
	$twitter = $_POST['twitter'];
	$google = $_POST['google'];
	$enlem = $_POST['enlem'];
	$boylam = $_POST['boylam'];
	
	
	$iletisimguncelle = $db->query("update iletisim set telefon = '".$telefon."', faks = '".$faks."', gsm = '".$gsm."', adres = '".$adres."', ilce = '".$ilce."', il = '".$il."', email = '".$email."', facebook = '".$facebook."', instagram = '".$instagram."', youtube = '".$youtube."', linkedin = '".$linkedin."', twitter = '".$twitter."', google = '".$google."', enlem = '".$enlem."', boylam = '".$boylam."' where (id = '1')");
	$_SESSION['yenikategori'] = 'İletişim bilgileriniz güncellenmiştir.';
	header('Location:iletisim.php');
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
function yenikategori() {
return	confirm("İletişim Bilgileriniz Güncellenecektir, Onaylıyor musunuz?");
}
</script>
</body>
</html>