<?php 
include_once('header2.php');
$yeniurunm = '';
$anasayfam = '';
$urunlerm = '';
$yenikategorim = '';
$kategorilerm = '';
$sayfaeklem = '';
$sayfalarm = '';
$makalelerm = 'active';
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
$kyilmaz= preg_replace($harflerSayilarBosluklarTireler,'',$kyilmaz); 
$kyilmaz= preg_replace($bosluguYenileTirelerle,'-',$kyilmaz); 
$kyilmaz = trim ($kyilmaz, '-'); return $kyilmaz; 
}
$makale = $db->prepare("select * from makaleler where (id = '".$_REQUEST['id']."')");
$result = $makale->execute();
$makale = $makale->fetch(PDO::FETCH_ASSOC);	
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
							<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Blog <span> - Makale Düzenleme</h4>
						</div>
						<div class="heading-elements">
							<div class="heading-btn-group">
								<a href="#" class="btn btn-link btn-float has-text"><i class="icon-bars-alt text-primary"></i><span>İstatistik</span></a>
							</div>
						</div>
					</div>
					<div class="breadcrumb-line">
						<ul class="breadcrumb">
							<li><a href="/webpanel/"><i class="icon-home2 position-left"></i> Anasayfa</a></li>
							<li class="active">Makale Düzenleme</li>
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
						<legend class="text-bold"><i class="fa fa-edit"></i> Makale Düzenle</legend>									
						<div class="form-group">										
						<label class="control-label col-lg-2">Görsel</label>										
						<div class="col-lg-10">											
						<img src="../images/blog/<?php echo $makale['gorsel']; ?>" width="200">										
						</div>									
						</div>									
						<div class="form-group">										
						<label class="control-label col-lg-2">Başlık</label>										
						<div class="col-lg-10">											
						<input type="text" class="form-control" name="baslik" value="<?php echo $makale['baslik']; ?>" required>
						</div>									
						</div>									
						<div class="form-group">										
						<label class="control-label col-lg-2">Kategori</label>										
						<div class="col-lg-10">											
						<select id="kategori" name="kategori">								
						<?php								
						$secilikategori = $db->prepare("select * from kategoriler where (id = '".$makale['kategori']."')");	
						$result = $secilikategori->execute();
						$secilikategori   = $secilikategori->fetch(PDO::FETCH_ASSOC);	
						
						
						echo '<option value="'.$secilikategori['id'].'">'.$secilikategori['kategori_TR'].'</option>';								
						$kategoriler = $db->query("select * from kategoriler where (yayin = '1')");								
						foreach($kategoriler as $kategori){									
							
							echo '<option value="'.$kategori['id'].'">'.$kategori['kategori_TR'].'</option>';								
						}
						?>											
						</select>										
						</div>									
						</div>									
						<div class="form-group">										
						<label class="control-label col-lg-2">İçerik</label>										
						<div class="col-lg-10">											
						<textarea class="form-control ckeditor" name="icerik"><?php echo $makale['icerik']; ?></textarea>
						</div>									
						</div>									
						<div class="form-group">										
						<label class="control-label col-lg-2">Kapak Resmi</label>										
						<div class="col-lg-10">											
						<input type="file" class="btn btn-block btn-info" name="gorsel" id="gorsel" lang="tr">										
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
					$isim = $makale['gorsel'];	
					if($_FILES["gorsel"]["tmp_name"] != NULL){		
					$kaynak		= $_FILES["gorsel"]["tmp_name"]; 
					// Yüklenen dosyanın adı			
					$yukle		= $klasor.basename($_FILES['gorsel']['name']);			
					$dosya		= $_FILES['gorsel']['name'];		
					$urlresim=$kaynak;//urleyi alıyoruz		
					$uzanti=substr($dosya,-4);//urlnin son 4 harfini alıyoruz.Bu uzantıya denk geliyor.		
					$isim = "blog_".rand(10,99999999).$uzanti;		
					$konum = "../images/blog/".$isim;//resim kayıt edileceği yer.		
					touch($konum);		
					$al=file_get_contents($urlresim);		
					$kaydet=file_put_contents($konum,$al);			
					$image = new SimpleImage();		
					$image->load($konum);			
					#$image->resizeToWidth(850);			
					$image->save($konum);	}	
					$url = seoUrl($_POST['baslik']);

					$baslik = $_POST['baslik'];
					$kategori = $_POST['kategori'];
					$icerik = $_POST['icerik'];
					$id = $_REQUEST['id'];
					
					
					$makaleguncelle = $db->query("update makaleler set baslik = '".$baslik."', urlkodu = '".$url."', kategori = '".$kategori."', icerik = '".$icerik."', gorsel = '".$isim."' where (id = '".$id."')");	
					$_SESSION['yenisayfa'] = 'Makale güncellenmiştir.';	
					header('Location:makaleduzenle.php?id='.$_REQUEST['id']);
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
	<!-- /page container -->
<script>	
	$(document).ready(function() {
	$("#kategori").select2();  	});
</script>
<script>
function guncelle() {
return	confirm("Seçtiğiniz makale güncellenecektir, onaylıyor musunuz?");
}
</script>
</body>
</html>