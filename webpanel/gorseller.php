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
$gorsellerm = 'active';
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
							<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Görseller <span> - Görselleri Düzenle</h4>
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
							<li class="active">Görselleri Düzenle</li>
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
$gorsel = $core->db->row("select * from gorseller where (id = '1')");
						?>
							<form class="form-horizontal" method="POST" enctype="multipart/form-data">
								<fieldset class="content-group">
									<legend class="text-bold"><i class="fa fa-edit"></i> Görselleri Düzenle</legend>
									
									<div class="form-group">
										<label class="control-label col-lg-2">Kurumsal</label>
										<div class="col-lg-10">
											<img src="../images/<?php echo $gorsel['hakkimizda']; ?>" style="width:200px;border-radius:2px;margin-bottom:10px;">
											<input type="file" class="btn btn-block btn-info" name="hakkimizda" id="hakkimizda" lang="tr">
										</div>
									</div>
									
									<div class="form-group">
										<label class="control-label col-lg-2">Referanslar</label>
										<div class="col-lg-10">
											<img src="../images/<?php echo $gorsel['projeler']; ?>" style="width:200px;border-radius:2px;margin-bottom:10px;">
											<input type="file" class="btn btn-block btn-info" name="projeler" id="projeler" lang="tr">
										</div>
									</div>
									
									<div class="form-group">
										<label class="control-label col-lg-2">Satış Sonrası</label>
										<div class="col-lg-10">
											<img src="../images/<?php echo $gorsel['blog']; ?>" style="width:200px;border-radius:2px;margin-bottom:10px;">
											<input type="file" class="btn btn-block btn-info" name="blog" id="blog" lang="tr">
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
	$isim = $gorsel['hakkimizda'];
	if($_FILES["hakkimizda"]["tmp_name"] != NULL){
		$kaynak		= $_FILES["hakkimizda"]["tmp_name"]; // Yüklenen dosyanın adı	
		$yukle		= $klasor.basename($_FILES['hakkimizda']['name']);	
		$dosya		= $_FILES['hakkimizda']['name'];
	
		$urlresim=$kaynak;//urleyi alıyoruz
		$uzanti=substr($dosya,-4);//urlnin son 4 harfini alıyoruz.Bu uzantıya denk geliyor.
	
		$isim = "gorsel_".rand(99,9999).$uzanti;
		$konum = "../images/".$isim;//resim kayıt edileceği yer.
		touch($konum);
		$al=file_get_contents($urlresim);
		$kaydet=file_put_contents($konum,$al);	
		$image = new ResizeImage();
		$image->load($konum);	
		$image->save($konum);
	}
	$isim2 = $gorsel['projeler'];
	if($_FILES["projeler"]["tmp_name"] != NULL){
		$kaynak2		= $_FILES["projeler"]["tmp_name"]; // Yüklenen dosyanın adı	
		$yukle2		= $klasor.basename($_FILES['projeler']['name']);	
		$dosya2		= $_FILES['projeler']['name'];
	
		$urlresim2=$kaynak2;//urleyi alıyoruz
		$uzanti2=substr($dosya2,-4);//urlnin son 4 harfini alıyoruz.Bu uzantıya denk geliyor.
	
		$isim2 = "gorsel_".rand(99,9999).$uzanti;
		$konum2 = "../images/".$isim2;//resim kayıt edileceği yer.
		touch($konum2);
		$al2=file_get_contents($urlresim2);
		$kaydet2=file_put_contents($konum2,$al2);	
		$image = new ResizeImage();
		$image->load($konum2);	
		$image->save($konum2);
	}
	$isim3 = $gorsel['blog'];
	if($_FILES["blog"]["tmp_name"] != NULL){
		$kaynak3		= $_FILES["blog"]["tmp_name"]; // Yüklenen dosyanın adı	
		$yukle3		= $klasor.basename($_FILES['blog']['name']);	
		$dosya3		= $_FILES['blog']['name'];
	
		$urlresim3=$kaynak3;//urleyi alıyoruz
		$uzanti3=substr($dosya3,-4);//urlnin son 4 harfini alıyoruz.Bu uzantıya denk geliyor.
	
		$isim3 = "gorsel_".rand(99,9999).$uzanti;
		$konum3 = "../images/".$isim3;//resim kayıt edileceği yer.
		touch($konum3);
		$al3=file_get_contents($urlresim3);
		$kaydet3=file_put_contents($konum3,$al3);	
		$image = new ResizeImage();
		$image->load($konum3);	
		$image->save($konum3);
	}
	
	
	$gorselguncelle = $core->db->query("update gorseller set hakkimizda = :hakkimizda, projeler = :projeler, blog = :blog where (id = '1');",array('hakkimizda' => $isim, 'projeler' => $isim2, 'blog' => $isim3)); 
	
	$_SESSION['yenihaber'] = 'Görsel başarıyla güncellenmiştir.';
	header('Location:gorseller.php');
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