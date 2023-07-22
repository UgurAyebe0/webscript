<?php 
include_once('header2.php'); echo '<style>.close {    margin-top: -29px;}</style>';

$yeniurunm = '';
$anasayfam = '';
$urunlerm = '';
$yenikategorim = '';
$kategorilerm = '';
$sayfaeklem = '';
$sayfalarm = '';
$haberlerm = '';
$habereklem = '';
$logom = 'active';
class ResizeImage {
    var $image;
    var $image_type;
    static function makeDir($path) {
        return is_dir($path) ||  mkdir($path, 0777, true);
    }
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
    function save($filename, $image_type=IMAGETYPE_JPEG, $compression=75, $permissions=null) {
       // do this or they'll all go to jpeg
        $image_type=$this->image_type;
        if( $image_type == IMAGETYPE_JPEG ) {
            imagejpeg($this->image,$filename,$compression);
        } elseif( $image_type == IMAGETYPE_GIF ) {
            imagegif($this->image,$filename);  
        } elseif( $image_type == IMAGETYPE_PNG ) {
            // need this for transparent png to work          
            imagealphablending($this->image, false);
            imagesavealpha($this->image,true);
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
    function resize($width,$height,$forcesize='n') {
      /* optional. if file is smaller, do not resize. */
        if ($forcesize == 'n') {
          if ($width > $this->getWidth() && $height > $this->getHeight()){
              $width = $this->getWidth();
              $height = $this->getHeight();
          }
        }
        $new_image = imagecreatetruecolor($width, $height);
        /* Check if this image is PNG or GIF, then set if Transparent*/  
        if(($this->image_type == IMAGETYPE_GIF) || ($this->image_type==IMAGETYPE_PNG)){
            imagealphablending($new_image, false);
            imagesavealpha($new_image,true);
            $transparent = imagecolorallocatealpha($new_image, 255, 255, 255, 127);
            imagefilledrectangle($new_image, 0, 0, $width, $height, $transparent);
        }
        imagecopyresampled($new_image, $this->image, 0, 0, 0, 0, $width, $height, $this->getWidth(), $this->getHeight());
        $this->image = $new_image;   
    }
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
							<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Logo <span> - Logo Değiştir</h4>
						</div>

						<div class="heading-elements">
							<div class="heading-btn-group">
								<a href="#" class="btn btn-link btn-float has-text"><i class="icon-bars-alt text-primary"></i><span>İstatistik</span></a>
								<a href="#" class="btn btn-link btn-float has-text"><i class="icon-calendar5 text-primary"></i> <span>Ürünler</span></a>
							</div>
						</div>
					</div>

					<div class="breadcrumb-line">
						<ul class="breadcrumb">
							<li><a href="/webpanel/"><i class="icon-home2 position-left"></i> Anasayfa</a></li>
							<li class="active">Logo Değiştir</li>
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
				<div class="content">
					<div class="panel panel-flat">
						<div class="panel-body">
						<?php 
						if($_SESSION['yenihaber'] != ''){
							echo $core->bootstrap->alertBS($_SESSION['yenihaber'],"info",15,true);
							$_SESSION['yenihaber'] = '';
						}
$logo = $db->prepare("select * from gorseller where (id = '1')");
$result = $logo->execute();
$logo = $logo->fetch(PDO::FETCH_ASSOC);
						?>
							<form class="form-horizontal" method="POST" enctype="multipart/form-data">
								<fieldset class="content-group">
									<legend class="text-bold"><i class="fa fa-edit"></i> Logo Değiştir</legend>
									
									<div class="form-group">
										<label class="control-label col-lg-2">Logo</label>
										<div class="col-lg-10">
											<img src="../images/<?php echo $logo['logo']; ?>" style="width:100px;border-radius:5px;margin-bottom:10px;">
											<input type="file" class="btn btn-block btn-info" name="logo" id="logo" lang="tr">
										</div>
									</div>

								</fieldset>
								<div class="text-right">
									<input type="submit" class="btn btn-success" style="min-width:150px;" value="Güncelle" name="yenihaberekle">
								</div>
							</form>
						</div>
					</div>
<?php
if($_POST['yenihaberekle']){
	$isim = $gorsel['logo'];
	if($_FILES["logo"]["tmp_name"] != NULL){
		$kaynak		= $_FILES["logo"]["tmp_name"]; // Yüklenen dosyanın adı	
		$yukle		= $klasor.basename($_FILES['logo']['name']);	
		$dosya		= $_FILES['logo']['name'];
	
		$urlresim=$kaynak;//urleyi alıyoruz
		$uzanti=substr($dosya,-4);//urlnin son 4 harfini alıyoruz.Bu uzantıya denk geliyor.
	
		$isim = "gorsel_".rand(10,9999999).$uzanti;
		$konum = "../images/".$isim;//resim kayıt edileceği yer.
		touch($konum);
		$al=file_get_contents($urlresim);
		$kaydet=file_put_contents($konum,$al);	
		$image = new ResizeImage();
		$image->load($konum);
		#$image->resizeToWidth(300);
		$image->save($konum);
	}
	
	
	$logoguncelle = $db->query("update gorseller set logo = '".$isim."' where (id = '1')"); 
	
	$_SESSION['yenihaber'] = 'Logonuz başarıyla güncellenmiştir.';
	header('Location:logo.php');
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
</body>
</html>