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
$sayfalarm = '';
$forumkategorilerm = 'active';

$kat = $db->prepare("select * from forumkategoriler where (id = '".$_REQUEST['id']."')");
$result = $kat->execute();
$kat   = $kat->fetch(PDO::FETCH_ASSOC);


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
							<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Forum Yönetimi <span> - Kategori Düzenle</h4>
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
						if($_SESSION['yenisayfa'] != ''){
							echo '<div class="alert alert-success" role="alert">'.$_SESSION['yenisayfa'].'</div>';
							$_SESSION['yenisayfa'] = '';
						}
						
						?>
							<form class="form-horizontal" method="POST" enctype="multipart/form-data">
								<fieldset class="content-group">
									<legend class="text-bold"><i class="fa fa-edit"></i> Kategori Düzenle</legend>

									<div class="form-group">
										<label class="control-label col-lg-2">Kategori Adı</label>
										<div class="col-lg-10">
											<input type="text" class="form-control" name="kategori_TR" value="<?php echo $kat['kategori_TR']; ?>" required>
										</div>
									</div>
								
									<div class="form-group">
										<label class="control-label col-lg-2">Üst Kategori</label>
										<div class="col-lg-10">
										<select id="kategori" name="alt_id">
										
<?php
if ($kat['alt_id'] == '0'){
	echo '<option value="0">Ana Kategori</option>';
}else{
	$secili = $kat['alt_id'];
$skat = $db->prepare("select * from forumkategoriler where (id = '".$secili."')");
$result = $skat->execute();
$skat   = $skat->fetch(PDO::FETCH_ASSOC);
	echo '<option value="'.$kat['alt_id'].'">'.$skat['kategori_TR'].'</option>';
	echo '<option value="0">Ana Kategori</option>';
}
?>	
										
							<?php
							$kategoriler = $db->query("select * from forumkategoriler where (yayin = '1') && (alt_id = '0')");
							foreach($kategoriler as $kategori){
								echo '<option value="'.$kategori['id'].'">'.$kategori['kategori_TR'].'</option>';
							}
							?>
										</select>
										</div>
									</div>

									<div class="form-group">
										<label class="control-label col-lg-2">Açıklama</label>
										<div class="col-lg-10">
											<textarea class="form-control" name="aciklama"><?php echo $kat['aciklama']; ?></textarea>
										</div>
									</div>
									
									<div class="form-group">
										<label class="control-label col-lg-2">Yayın</label>
										<div class="col-lg-10" style="font-size:24 !important">
<?php 
if($kat['yayin'] == '1'){
?>										
											<input type="radio" name="yayin" id="aktif" value="1" style="width:10%" checked> <label for="aktif" class="text-success" style="width:50%;">Aktif</label><hr>
											<input type="radio" name="yayin" id="pasif" style="width:10%" value="0"> <label class="text-danger" for="pasif" style="width:50%">Pasif</label>
<?php 
}else{
?>	
											<input type="radio" name="yayin" id="aktif" value="1" style="width:10%" > <label for="aktif" class="text-success" style="width:50%;">Aktif</label><hr>
											<input type="radio" name="yayin" id="pasif" style="width:10%" value="0" checked> <label class="text-danger" for="pasif" style="width:50%">Pasif</label>

<?php 
}
?>											
										</div>
									</div>
									
									<hr>
									<div class="form-group">
										<label class="control-label col-lg-2">Sadece Yöneticiler</label>
										<div class="col-lg-10" style="font-size:24 !important">
<?php 
if($kat['yoneticiler'] == '1'){
?>										
											<input type="radio" name="yonetici" id="evet" value="1" style="width:10%" checked> <label for="evet" class="text-success" style="width:50%;">Evet</label><hr>
											<input type="radio" name="yonetici" id="hayir" style="width:10%" value="0"> <label class="text-danger" for="hayir" style="width:50%">Hayır</label>
<?php 
}else{
?>	
											<input type="radio" name="yonetici" id="evet" value="1" style="width:10%" > <label for="evet" class="text-success" style="width:50%;">Evet</label><hr>
											<input type="radio" name="yonetici" id="hayir" style="width:10%" value="0" checked> <label class="text-danger" for="hayir" style="width:50%">Hayır</label>

<?php 
}
?>											
										</div>
									</div>
									
								</fieldset>
								<div class="text-right">
									<input type="submit" class="btn btn-success" style="min-width:150px;" onclick="return yenisayfa();" value="Güncelle" name="yenisayfaekle">
								</div>
							</form>
						</div>
					</div>
<?php
if($_POST['yenisayfaekle']){
	
	$url = seoUrl($_POST['kategori_TR']);
	
	$baslik = $_POST['kategori_TR'];
	$kategori = $_POST['alt_id'];
	$icerik = $_POST['aciklama'];
	$yayin = $_POST['yayin'];
	$yonetici = $_POST['yonetici'];
	
	$urunkaydet = $db->query("update forumkategoriler set kategori_TR = '".$baslik."', kategorikodu = '".$url."', alt_id = '".$kategori."', aciklama = '".$icerik."', yayin = '".$yayin."', yoneticiler = '".$yonetici."' where (id = '".$_REQUEST['id']."')");
	$_SESSION['yenisayfa'] = 'Kategori başarıyla güncellenmiştir.';
	header('Location:forumkategoriduzenle.php?id='.$_REQUEST['id']);
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
return	confirm("Girdiğiniz kategori güncellenecektir, onaylıyor musunuz?");
}
</script>
</body>
</html>