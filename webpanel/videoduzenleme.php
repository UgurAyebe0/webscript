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
$videolarm = 'active';
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
 
$video = $db->prepare("select * from youtube where (id = '".$_REQUEST['id']."')");
$result = $video->execute();
$video   = $video->fetch(PDO::FETCH_ASSOC);
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
							<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Videolar <span> - Video Düzenleme</h4>
						</div>


					</div>

					<div class="breadcrumb-line">
						<ul class="breadcrumb">
							<li><a href="/webpanel/"><i class="icon-home2 position-left"></i> Anasayfa</a></li>
							<li class="active">Video Düzenleme</li>
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
									<legend class="text-bold"><i class="fa fa-edit"></i> Video Düzenleme - Yükleyen <?php echo $video['yukleyen']; ?></legend>
									
									<div class="form-group">
										<label class="control-label col-lg-2">Başlık</label>
										<div class="col-lg-10">
											<input type="text" class="form-control" name="baslik" value="<?php echo $video['baslik']; ?>" required>
										</div>
									</div>									
									
									
									<div class="form-group">
										<label class="control-label col-lg-2">Link</label>
										<div class="col-lg-10">
											<input type="text" class="form-control" name="link" value="<?php echo $video['link']; ?>" placeholder="Youtube Video Linki">
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-lg-2">Kapak Resmi</label>
										<div class="col-lg-3">
											<img src="../images/blog/<?php echo $video['kapak']; ?>" style="width:100%;">
										</div>
										<div class="col-lg-7">
											<input type="file" class="btn btn-block btn-info" name="gorsel" id="gorsel" lang="tr" required>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-lg-2">Açıklama</label>
										<div class="col-lg-10">
											<textarea class="form-control ckeditor" name="aciklama"><?php echo $video['aciklama']; ?></textarea>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-lg-2">Vitrin</label>
										<div class="col-lg-10">
										<select id="vitrin" name="vitrin">
<?php
if($video['vitrin'] == '1'){
	echo '<option value="1">Evet</option>';
	echo '<option value="0">Hayır</option>';
}else{
	echo '<option value="0">Hayır</option>';
	echo '<option value="1">Evet</option>';	
}
?>

										

										</select>
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
	$isim = $video['kapak'];
	if($_FILES["gorsel"]["tmp_name"] != NULL){
		$kaynak		= $_FILES["gorsel"]["tmp_name"]; // Yüklenen dosyanın adı	
		$yukle		= $klasor.basename($_FILES['gorsel']['name']);	
		$dosya		= $_FILES['gorsel']['name'];
	
		$urlresim=$kaynak;//urleyi alıyoruz
		$uzanti=substr($dosya,-4);//urlnin son 4 harfini alıyoruz.Bu uzantıya denk geliyor.
	
		$isim = "video_".rand(10,99999).$uzanti;
		$konum = "../images/blog/".$isim;//resim kayıt edileceği yer.
		touch($konum);
		$al=file_get_contents($urlresim);
		$kaydet=file_put_contents($konum,$al);	
		$image = new SimpleImage();
		$image->load($konum);	
		#$image->resizeToWidth(850);	
		$image->save($konum);
	}

	$url = seoUrl($_POST['baslik']).'-'.rand(10,99999);	
	$baslik = $_POST['baslik'];
	$aciklama = $_POST['aciklama'];
	$link = $_POST['link'];
	$vitrin = $_POST['vitrin'];
	$id = $_REQUEST['id'];
	
	
	$urunkaydet = $db->query("update youtube set baslik = '".$baslik."', urlkodu = '".$url."', link = '".$link."', kapak = '".$isim."', aciklama = '".$aciklama."', vitrin = '".$vitrin."' where (id = '".$id."')");
	$_SESSION['yenisayfa'] = 'Video başarıyla güncellenmiştir.';
	header('Location:videoduzenleme.php?id='.$_REQUEST['id']);
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
		$("#vitrin").select2();  
	});
</script>
<script>
function yenisayfa() {
return	confirm("Video güncellenecektir, onaylıyor musunuz?");
}
</script>
</body>
</html>