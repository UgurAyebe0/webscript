<?php 
include_once('header2.php'); 
echo '<style>.close {
    margin-top: -29px;
}</style>';

$forummesajlarm = 'active';
$mesaj = $db->prepare("select * from forummesajlar where (id = '".$_REQUEST['id']."')");
$result = $mesaj->execute();
$mesaj   = $mesaj->fetch(PDO::FETCH_ASSOC);

$konuid = $mesaj['konuid'];

$konu = $db->prepare("select * from forumkonular where (id = '".$konuid."')");
$resultt = $konu->execute();
$konu   = $konu->fetch(PDO::FETCH_ASSOC);



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
							<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Forum Yönetimi <span> - Mesaj Düzenleme</h4>
						</div>

					</div>

					<div class="breadcrumb-line">
						<ul class="breadcrumb">
							<li><a href="/webpanel/"><i class="icon-home2 position-left"></i> Anasayfa</a></li>
							<li class="active">Forum Mesaj Düzenleme - Konu: <?php echo $konu['baslik']; ?></li>
						</ul>

					</div>
				</div>
				<div class="content">
					<div class="panel panel-flat">
						<div class="panel-body">
						<?php 
						if($_SESSION['konuduzenleme'] != ''){
							echo '<div class="alert alert-success" role="alert">'.$_SESSION['konuduzenleme'].'</div>';
							$_SESSION['konuduzenleme'] = '';
						}
						
						?>
							<form class="form-horizontal" method="POST" enctype="multipart/form-data">
								<fieldset class="content-group">
									<legend class="text-bold"><i class="fa fa-edit"></i> Mesaj Düzenleme - Gönderen <span style="text-transform:none !important;color: #b61a1a;"><?php echo $mesaj['username']; ?></span></legend>
									

									<div class="form-group">
										<label class="control-label col-lg-2">İçerik</label>
										<div class="col-lg-10">
											<textarea class="form-control ckeditor" name="yorum"><?php echo $mesaj['mesaj']; ?></textarea>
										</div>
									</div>

									<div class="form-group">
										<label class="control-label col-lg-2">Yayın</label>
										<div class="col-lg-10" style="font-size:24 !important">
<?php 
if($mesaj['yayin'] == '1'){
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
									
								</fieldset>
								<div class="text-right">
									<input type="submit" class="btn btn-success" style="min-width:150px;" onclick="return konuduzenleme();" value="Güncelle" name="konuduzenleme">
								</div>
							</form>
						</div>
					</div>
<?php
if($_POST['konuduzenleme']){
	$baslik = strip_tags($_POST['baslik']);
	$yorum = $_POST['yorum'];
	$yayin = $_POST['yayin'];
	$sabit = $_POST['sabit'];

	$konukaydet = $db->query("update forummesajlar set mesaj = '".$yorum."', yayin = '".$yayin."' where (id = '".$_REQUEST['id']."') ");
	$_SESSION['konuduzenleme'] = 'Mesaj başarıyla güncellenmiştir.';
	header('Location:forummesajduzenle.php?id='.$_REQUEST['id']);
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
function konuduzenleme() {
return	confirm("Mesaj güncellenecektir, onaylıyor musunuz?");
}
</script>
</body>
</html>