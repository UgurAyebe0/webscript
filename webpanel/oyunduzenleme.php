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
$oyunlarm = 'active';
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
 $oyun = $db->prepare("select * from oyunlar where (id = '".$_REQUEST['id']."')");
 $result = $oyun->execute();
 $oyun  = $oyun->fetch(PDO::FETCH_ASSOC);
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
							<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Oyunlar <span> - Oyun Düzenle</h4>
						</div>


					</div>

					<div class="breadcrumb-line">
						<ul class="breadcrumb">
							<li><a href="/webpanel/"><i class="icon-home2 position-left"></i> Anasayfa</a></li>
							<li class="active">Oyun Düzenle</li>
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
									<legend class="text-bold"><i class="fa fa-edit"></i> Oyun Düzenle</legend>

									<div class="form-group">
										<label class="control-label col-lg-2">Oyun Adı</label>
										<div class="col-lg-10">
											<input type="text" class="form-control" name="baslik" value="<?php echo $oyun['baslik']; ?>" required>
										</div>
									</div>									
									<div class="form-group">
										<label class="control-label col-lg-2">Kısa Açıklama</label>
										<div class="col-lg-10">
											<textarea class="form-control" name="kisa_aciklama"><?php echo $oyun['kisa_aciklama']; ?></textarea>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-lg-2">Detaylı Bilgi</label>
										<div class="col-lg-10">
											<textarea class="form-control ckeditor" name="aciklama"><?php echo $oyun['aciklama']; ?></textarea>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-lg-2">Konu</label>
										<div class="col-lg-10">
											<input type="text" class="form-control" name="konu" value="<?php echo $oyun['konu']; ?>" placeholder="Hayatta Kalma, Vahşi Batı vb.">
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-lg-2">Özellik</label>
										<div class="col-lg-10">
											<input type="text" class="form-control" name="ozellik"  value="<?php echo $oyun['ozellik']; ?>" placeholder="Aksiyon, Macera, Battle Royale vb.">
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-lg-2">Kapak Resmi</label>
										<div class="col-lg-2"><img src="../images/blog/<?php echo $oyun['gorsel']; ?>" style="max-width:100%;"></div>
										<div class="col-lg-8">
											<input type="file" class="btn btn-block btn-info" name="gorsel" id="gorsel" lang="tr">
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-lg-2">Arkaplan Resmi</label>
										<div class="col-lg-2"><img src="../images/blog/<?php echo $oyun['arkaplan']; ?>" style="max-width:100%;"></div>
										<div class="col-lg-8">
											<input type="file" class="btn btn-block btn-info" name="gorsel2" id="gorsel2" lang="tr">
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
	$isim = $oyun['gorsel'];
	$isim2 = $oyun['arkaplan'];
	if($_FILES["gorsel"]["tmp_name"] != NULL){
		$kaynak		= $_FILES["gorsel"]["tmp_name"]; // Yüklenen dosyanın adı	
		$yukle		= $klasor.basename($_FILES['gorsel']['name']);	
		$dosya		= $_FILES['gorsel']['name'];
	
		$urlresim=$kaynak;//urleyi alıyoruz
		$uzanti=substr($dosya,-4);//urlnin son 4 harfini alıyoruz.Bu uzantıya denk geliyor.
	
		$isim = "blog_".rand(10,9999999).$uzanti;
		$konum = "../images/blog/".$isim;//resim kayıt edileceği yer.
		touch($konum);
		$al=file_get_contents($urlresim);
		$kaydet=file_put_contents($konum,$al);	
		$image = new SimpleImage();
		$image->load($konum);	
		#$image->resizeToWidth(850);	
		$image->save($konum);
	}
	if($_FILES["gorsel2"]["tmp_name"] != NULL){
		$kaynak2		= $_FILES["gorsel2"]["tmp_name"]; // Yüklenen dosyanın adı	
		$yukle2		= $klasor.basename($_FILES['gorsel2']['name']);	
		$dosya2		= $_FILES['gorsel2']['name'];
	
		$urlresim2=$kaynak2;//urleyi alıyoruz
		$uzanti2=substr($dosya2,-4);//urlnin son 4 harfini alıyoruz.Bu uzantıya denk geliyor.
	
		$isim2 = "blog_".rand(10,9999999).$uzanti2;
		$konum2 = "../images/blog/".$isim2;//resim kayıt edileceği yer.
		touch($konum2);
		$al2=file_get_contents($urlresim2);
		$kaydet2=file_put_contents($konum2,$al2);	
		$image = new SimpleImage();
		$image->load($konum2);	
		#$image->resizeToWidth(850);	
		$image->save($konum2);
	}
	
	$url = seoUrl($_POST['baslik']);	
	$baslik = $_POST['baslik'];
	$kisaaciklama = $_POST['kisa_aciklama'];
	$aciklama = $_POST['aciklama'];
	$konu = $_POST['konu'];
	$ozellik = $_POST['ozellik'];
	$id = $oyun['id'];
	
	$urunkaydet = $db->query("update oyunlar set baslik = '".$baslik."', url = '".$url."', gorsel = '".$isim."', arkaplan = '".$isim2."', kisa_aciklama = '".$kisaaciklama."', aciklama = '".$aciklama."', konu = '".$konu."', ozellik = '".$ozellik."' where (id = '".$id."')");
	$_SESSION['yenisayfa'] = 'Oyun başarıyla güncellenmiştir.';
	header('Location:oyunduzenleme.php?id='.$oyun['id']);
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
function yenisayfa() {
return	confirm("Oyun güncellenecektir, onaylıyor musunuz?");
}
</script>
</body>
</html>