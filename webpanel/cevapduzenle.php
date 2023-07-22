<?php 
include_once('header2.php');

$anketlerm = 'active';
echo '<style>.close {    margin-top: -29px;}</style>';
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
}      if( $permissions != null) {
chmod($filename,$permissions);
}   }   
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
}   function resize($width,$height) {
$new_image = imagecreatetruecolor(850, 700);
imagefill($new_image, 0, 0, imagecolorallocate($new_image, 255, 255, 255));
imagecopyresampled($new_image, $this->image, ((850 - $width) / 2), ((700 - $height) / 2), 0, 0, $width, $height, $this->getWidth(), $this->getHeight());
$this->image = $new_image;
}}
function seoUrl($kyilmaz){ 
$harflerSayilarBosluklarTireler = '/[^\-\s\pN\pL]+/u';
$bosluguYenileTirelerle = '/[\-\s]+/'; 
$tr = array('ş','Ş','ı','I','İ','ğ','Ğ','ü','Ü','ö','Ö','Ç','ç','(',')','/',':',','); 
$eng = array('s','s','i','i','i','g','g','u','u','o','o','c','c','','','-','-',''); 
$kyilmaz = str_replace($tr,$eng,$kyilmaz); 
$kyilmaz= preg_replace($harflerSayilarBosluklarTireler,'',mb_strtolower($kyilmaz,'UTF-8')); 
$kyilmaz= preg_replace($bosluguYenileTirelerle,'-',$kyilmaz); 
$kyilmaz = trim ($kyilmaz, '-'); return $kyilmaz; 
}
$makale = $db->prepare("select * from anketcevap where (id = '".$_REQUEST['id']."')");
$result = $makale->execute();
$makale   = $makale->fetch(PDO::FETCH_ASSOC);
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
							<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Anketler <span> - Cevap Düzenleme</h4>
						</div>

					</div>
					<div class="breadcrumb-line">
						<ul class="breadcrumb">
							<li><a href="/webpanel/"><i class="icon-home2 position-left"></i> Anasayfa</a></li>
							<li class="active">Cevap Düzenleme</li>
						</ul>
						<div class="" style="float:right;padding-top:5px;padding-bottom:5px;">
							<a href="/webpanel/anketler.php" class="btn btn-primary btn-sm" style="margin-right:10px;"> Anketler <i class="fa fa-folder"></i></a>
							<a href="/webpanel/yenianket.php" class="btn btn-warning btn-sm" style="margin-right:10px;"> Yeni Anket <i class="fa fa-plus"></i></a>
							<a href="/webpanel/anketcevaplar.php" class="btn btn-primary btn-sm" style="margin-right:10px;"> Cevap Listesi <i class="fa fa-list-ul"></i></a>
							<a href="/webpanel/yenicevap.php" class="btn btn-primary btn-sm" style="margin-right:10px;"> Yeni Cevap <i class="fa fa-plus"></i></a>
							
						</div>
					</div>
				</div>
				<!-- /page header -->
				<!-- Content area -->
				<div class="content">
					<!-- ürünler -->
					<div class="panel panel-flat">
						<div class="panel-heading">
							<h5 class="panel-title"><i class="fa fa-th-list"></i> <?php echo $makale['baslik']; ?></h5>
							<div class="heading-elements">
								<ul class="icons-list">
			                		<li><a data-action="collapse"></a></li>
			                		<li><a data-action="reload"></a></li>
			                	</ul>
		                	</div>
						</div>						
						<div class="panel-body">						
						<?php 						
						if($_SESSION['yenisayfa'] != ''){							
						echo '<div class="alert alert-success" role="alert">'.$_SESSION['yenisayfa'].'</div>';						
						$_SESSION['yenisayfa'] = '';						
						}						
						?>							
						<form class="form-horizontal" method="POST" enctype="multipart/form-data">								
						<fieldset class="content-group">									
						<legend class="text-bold"><i class="fa fa-edit"></i> Cevap Düzenle</legend>									
									
						<div class="form-group">										
						<label class="control-label col-lg-2">Cevap</label>										
						<div class="col-lg-10">											
						<input type="text" class="form-control" name="cevap" value="<?php echo $makale['cevap']; ?>" required>
						</div>									
						</div>									
								
						<div class="form-group">
										<label class="control-label col-lg-2">Anket Soru</label>
										<div class="col-lg-10">
											<select class="form-control" name="anketid" id="kategori" required>
											
<?php 
$kategoriler = $db->query("select * from anketsoru");

$makalekat = $db->prepare("select * from anketsoru where (id = '".$makale['anketid']."')");
$result = $makalekat->execute();
$makalekat   = $makalekat->fetch(PDO::FETCH_ASSOC);


echo '<option value="'.$makalekat['id'].'">'.$makalekat['soru'].'</option>';
echo '<option value="'.$makalekat['id'].'">Lütfen Anket Seçiniz</option>';
foreach($kategoriler as $kategori){


		echo '<option value="'.$kategori['id'].'">'.$kategori['soru'].'</option>';

	
}
?>
											</select>
										</div>
									</div>
						<div class="form-group">										
						<label class="control-label col-lg-2">Sıra</label>										
						<div class="col-lg-10">											
						<input type="text" class="form-control" name="sira" value="<?php echo $makale['sira']; ?>" required>
						</div>									
						</div>
							
						</fieldset>								
						<div class="text-right">									
						<input type="submit" class="btn btn-success" style="min-width:150px;" onclick="return guncelle();" value="Güncelle" name="makaleguncelle">								
						</div>							
						</form>						
						</div>
					</div>
					<?php
					if($_POST['makaleguncelle']){	
						
	
					$makaleguncelle = $db->query("update anketcevap set anketid = '".$_POST['anketid']."', cevap = '".$_POST['cevap']."', sira = '".$_POST['sira']."' where (id = '".$_REQUEST['id']."')");	
					$_SESSION['yenisayfa'] = 'Cevap güncellenmiştir.';	
					header('Location:cevapduzenle.php?id='.$_REQUEST['id']);
					}
					?>
					<!-- /urunler -->
					<?php include_once('footer.php'); ?>
				</div>
				<!-- /content area -->
			</div>
			<!-- /main content -->
		</div>
		<!-- /page content -->
	</div>
<script>
	$(document).ready(function() {
		$("#kategori").select2();  
	});
</script>
<script>
function guncelle() {
return	confirm("Seçtiğiniz cevap güncellenecektir, onaylıyor musunuz?");
}
</script>
</body>
</html>