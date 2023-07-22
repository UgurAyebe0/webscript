<?php 
include_once('header2.php'); 
echo '<style>.close {    margin-top: -29px;}</style>';
$yeniurunm = '';
$anasayfam = '';
$urunlerm = '';
$yenikategorim = '';
$kategorilerm = '';
$sayfaeklem = '';
$sayfalarm = '';
$haberlerm = '';
$habereklem = '';
$bannerm = 'active';
$banner = $db->prepare("select * from banner where (id = '1')");
$result = $banner->execute();
$banner   = $banner->fetch(PDO::FETCH_ASSOC);	

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
							<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Anasayfa Banner <span> - Banner Düzenleme</h4>
						</div>


					</div>

					<div class="breadcrumb-line">
						<ul class="breadcrumb">
							<li><a href="/webpanel/"><i class="icon-home2 position-left"></i> Anasayfa</a></li>
							<li class="active">Banner Düzenleme</li>
						</ul>


					</div>
				</div>
				<div class="content">
					<div class="panel panel-flat">
						<div class="panel-body">
						<?php 
						if($_SESSION['haberduzenle'] != ''){
							echo $core->bootstrap->alertBS($_SESSION['haberduzenle'],"info",15,true);
							$_SESSION['haberduzenle'] = '';
						}
						
						?>
							<form class="form-horizontal" method="POST" enctype="multipart/form-data">
								<fieldset class="content-group">
									<legend class="text-bold"><i class="fa fa-edit"></i> Banner Düzenleme</legend>
									<div class="form-group">										
										<label class="control-label col-lg-2">Görsel</label>								
										<div class="col-lg-10">											
											<img src="../images/<?php echo $banner['gorsel']; ?>" width="200">
										</div>									
									</div>
									
									<div class="form-group">
										<label class="control-label col-lg-2">Link</label>
										<div class="col-lg-10">
											<input type="text" class="form-control" name="link" value="<?php echo $banner['link']; ?>" required>
										</div>
									</div>

									<div class="form-group">
										<label class="control-label col-lg-2">Görsel</label>
										<div class="col-lg-10">
											<input type="file" class="btn btn-block btn-info" name="gorsel" id="gorsel" lang="tr">
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-lg-2">Yayın Durumu</label>
										<div class="col-lg-10">
											<div class="col-lg-3 col-xs-6">
											<select name="yayin" class="form-control">
								<?php
									if($banner['yayin'] == '1'){
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
									</div>
									
								</fieldset>
								<div class="text-right">
									<input type="submit" class="btn btn-success" style="min-width:150px;" onclick="return haberduzenle();" value="Güncelle" name="haberduzenle">
								</div>
							</form>
						</div>
					</div>
<?php
if($_POST['haberduzenle']){
	$isim = $banner['gorsel'];
	if($_FILES["gorsel"]["tmp_name"] != NULL){
		$kaynak		= $_FILES["gorsel"]["tmp_name"]; // Yüklenen dosyanın adı	
		$yukle		= $klasor.basename($_FILES['gorsel']['name']);	
		$dosya		= $_FILES['gorsel']['name'];
	
		$urlresim=$kaynak;//urleyi alıyoruz
		$uzanti=substr($dosya,-4);//urlnin son 4 harfini alıyoruz.Bu uzantıya denk geliyor.
	
		$isim = "banner_".rand(10,99999).$uzanti;
		$konum = "../images/".$isim;//resim kayıt edileceği yer.
		touch($konum);
		$al=file_get_contents($urlresim);
		$kaydet=file_put_contents($konum,$al);	
		$image = new ResizeImage();
		$image->load($konum);	
		$image->save($konum);
	}
	
	$zaman = time();
	$yayin = $_POST['yayin'];
	$link = $_POST['link'];

	
	
	$haberkaydet = $db->query("update banner set gorsel = '".$isim."', link = '".$link."', yayin = '".$yayin."', stamp = '".$zaman."' where (id = '1')");
	
	$_SESSION['markaduzenle'] = 'Banner başarıyla güncellenmiştir.';
	
	header('Location:banner.php');
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
function yenihaber() {
return	confirm("Banner güncellenecektir, onaylıyor musunuz?");
}
</script>
</body>
</html>