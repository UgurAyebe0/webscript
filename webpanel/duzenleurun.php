<?php 
include_once('header2.php'); 

$yeniurunm = '';
$anasayfam = '';
$urunlerm = '';
$yenikategorim = '';
$kategorilerm = '';
$sayfaeklem = '';
$urunduzenlem = 'active';
$urun = $kpanel->prepare("select * from Urunler where (UrunId = '".$_REQUEST['p']."')");
$result = $urun->execute();
$urun   = $urun->fetch(PDO::FETCH_ASSOC);



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
							<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Ürünler <span> - Ürün Düzenle</h4>
						</div>

					</div>

					<div class="breadcrumb-line">
						<ul class="breadcrumb">
							<li><a href="/webpanel/"><i class="icon-home2 position-left"></i> Anasayfa</a></li>
							<li class="active">Ürün Düzenle</li>
						</ul>


					</div>
				</div>
				<div class="content">
					<div class="panel panel-flat">
						<div class="panel-body">
						<?php 
						if($_SESSION['yeniurun'] != ''){
							echo '<div class="alert alert-success" role="alert">'.$_SESSION['yeniurun'].'</div>';
							$_SESSION['yeniurun'] = '';
						}
						
						?>
							<form class="form-horizontal" method="POST" enctype="multipart/form-data">
								<fieldset class="content-group">
									<legend class="text-bold"><i class="fa fa-edit"></i> <?php echo $urun['Adi']; ?> - Düzenle</legend>

									<div class="form-group">
										<label class="control-label col-lg-2">Ürün Adı</label>
										<div class="col-lg-10">
											<input type="text" class="form-control" name="Adi" value="<?php echo $urun['Adi']; ?>" required>
										</div>
									</div>
									
									<div class="form-group">
										<label class="control-label col-lg-2">Ürün Sırası</label>
										<div class="col-lg-10">
											<input type="text" class="form-control" placeholder="Ürünün sırasını belirtiniz" name="Sira" value="<?php echo $urun['Sira']; ?>">
										</div>
									</div>

									<div class="form-group">
										<label class="control-label col-lg-2">Kategori</label>
										<div class="col-lg-10">
											<select class="form-control" name="kategori" id="kategori" required>
<?php
if($urun['AltKategoriId'] == '0'){
	$secilikategori = $kpanel->prepare("select * from UrunKategorileri where (UrunKategoriId = '".$urun['UrunKategoriId']."')");
	$result = $secilikategori->execute();
	$secilikategori   = $secilikategori->fetch(PDO::FETCH_ASSOC);
		echo '<option value="'.$urun['UrunKategoriId'].'">'.$secilikategori['KategoriAdi'].'</option>';
	}else{
	
	$secilikategori = $kpanel->prepare("select * from UrunKategorileri where (UrunKategoriId = '".$urun['AltKategoriId']."')");
	$result = $secilikategori->execute();
	$secilikategori   = $secilikategori->fetch(PDO::FETCH_ASSOC);
		$ustkategori = $kpanel->prepare("select * from UrunKategorileri where (KategoriAdi = '".$secilikategori['UstKategori']."')");
		$result = $ustkategori->execute();
		$ustkategori   = $ustkategori->fetch(PDO::FETCH_ASSOC);
		echo '<option value="'.$secilikategori['UrunKategoriId'].'">'.$ustkategori['KategoriAdi'].' --> '.$secilikategori['KategoriAdi'].'</option>';
	}


 
$kategoriler = $kpanel->query("select * from UrunKategorileri");
foreach($kategoriler as $kategori){
	if($kategori['AltKategori'] == '0'){
		echo '<option value="'.$kategori['UrunKategoriId'].'">'.$kategori['KategoriAdi'].'</option>';
	}else{
		$ustkategori = $kpanel->prepare("select * from UrunKategorileri where (KategoriAdi = '".$kategori['UstKategori']."')");
		$result = $ustkategori->execute();
		$ustkategori   = $ustkategori->fetch(PDO::FETCH_ASSOC);
		echo '<option value="'.$kategori['UrunKategoriId'].'">'.$ustkategori['KategoriAdi'].' --> '.$kategori['KategoriAdi'].'</option>';
	}
	
}
?>
											</select>
										</div>
									</div>

									<div class="form-group">
										<label class="control-label col-lg-2">Açıklama</label>
										<div class="col-lg-10">
											<textarea class="form-control ckeditor" name="Aciklama"><?php echo $urun['Aciklama']; ?></textarea>
										</div>
									</div>
					
									<div class="form-group">
										<label class="control-label col-lg-2">Kısa Açıklama</label>
										<div class="col-lg-10">
											<input type="text" class="form-control" name="KisaAciklama" value="<?php echo $urun['KisaAciklama']; ?>">
										</div>
									</div>
									
									<div class="form-group">
										<label class="control-label col-lg-2">Fiyat (Kredi)</label>
										<div class="col-lg-10">
											<input type="text" class="form-control" name="Fiyat" value="<?php echo $urun['Fiyat']; ?>" required>
										</div>
									</div>
									
									<div class="form-group">
										<label class="control-label col-lg-2">Stok</label>
										<div class="col-lg-10">
											<select class="form-control" name="Stok" id="Stok" required>
											<option value="-1">Sınırsız</option>
											</select>
										</div>
									</div>
									
									<div class="form-group">
										<label class="control-label col-lg-2">Süre</label>
										<div class="col-lg-10">
											<select class="form-control" name="Sure" id="Sure" required>
										<?php
										if($urun['Sure'] == '-1'){
											echo '<option value="'.$urun['Sure'].'">Süresiz</option>';
										}else{
											echo '<option value="'.$urun['Sure'].'">'.$urun['Sure'].' Gün</option>';
										}
											
										?>
											<option value="-1">Sınırsız</option>
											<option value="15">15 Gün</option>
											<option value="30">30 Gün</option>
											</select>
										</div>
									</div>
									
									<div class="form-group">
										<label class="control-label col-lg-2">Geçerli Yerler</label>
										<div class="col-lg-10">
											<select class="form-control" name="GecerliYerler" id="GecerliYerler" required>
									<?php
											echo '<option value="'.$urun['GecerliYerler'].'">'.$urun['GecerliYerler'].'</option>';
									?>
											<option value="Global">Global</option>
											<option value="Faction">Faction</option>
											<option value="SkyBlock">SkyBlock</option>
											<option value="SkyPvP">SkyPvP</option>
											</select>
										</div>
									</div>
									
									<div class="form-group">
										<label class="control-label col-lg-2">Veri</label>
										<div class="col-lg-10">
											<textarea class="form-control" name="Veri"><?php echo $urun['Veri']; ?></textarea>
										</div>
									</div>
									
									<div class="form-group">
										<label class="control-label col-lg-2">Resim Değiştir</label>
										<div class="col-lg-3">
											<img src="<?php echo $urun['Resim']; ?>" style="max-width:100%;">
										</div>
										<div class="col-lg-7">
											<input type="file" class="btn btn-block btn-info" name="gorsel" id="gorsel" lang="tr">
										</div>
									</div>
									
									
									
								</fieldset>
								<div class="text-right">
									<input type="submit" class="btn btn-success" style="min-width:150px;" onclick="return yeniurun();" value="Güncelle" name="yeniurunekle">
								</div>
							</form>
						</div>
					</div>
<?php
if($_POST['yeniurunekle']){
	$isim = '';

	if($_FILES["gorsel"]["tmp_name"] != NULL){
		$kaynak		= $_FILES["gorsel"]["tmp_name"]; // Yüklenen dosyanın adı	
		$yukle		= $klasor.basename($_FILES['gorsel']['name']);	
		$dosya		= $_FILES['gorsel']['name'];
	
		$urlresim=$kaynak;//urleyi alıyoruz
		$uzanti=substr($dosya,-4);//urlnin son 4 harfini alıyoruz.Bu uzantıya denk geliyor.
	
		$isim = "urun_".rand(10,9999999).$uzanti;
		$konum = "../images/urunler/".$isim;//resim kayıt edileceği yer.
		touch($konum);
		$al=file_get_contents($urlresim);
		$kaydet=file_put_contents($konum,$al);	
		$image = new ResizeImage();
		$image->load($konum);	
		#$image->resizeToWidth(600);	
		$image->save($konum);
	}
	
	
	$Adi = $_POST['Adi'];
	$Aciklama = $_POST['Aciklama'];
	$KisaAciklama = $_POST['KisaAciklama'];
	if($isim != ''){
		$Resim = $core->config['global']['domain'].'images/urunler/'.$isim;
	}else{
		$Resim = $urun['Resim'];
	}
	$Fiyat = $_POST['Fiyat'];
	
	$kategoriid = $_POST['kategori'];
	
	$sira = $_POST['Sira'];
	
	$kategorikontrol = $kpanel->prepare("select * from UrunKategorileri where (UrunKategoriId = '".$kategoriid."')");
	$result = $kategorikontrol->execute();
	$kategorikontrol   = $kategorikontrol->fetch(PDO::FETCH_ASSOC);
	
	if($kategorikontrol['AltKategori'] == '0'){
		$UrunKategoriId = $kategoriid;
		$AltKategoriId = '0';
	}else{
		$kategoriad = $kategorikontrol['UstKategori'];
		$ustkat = $kpanel->prepare("select * from UrunKategorileri where (KategoriAdi = '".$kategoriad."')");
		$result = $ustkat->execute();
		$ustkat = $ustkat->fetch(PDO::FETCH_ASSOC);
		$UrunKategoriId = $ustkat['UrunKategoriId'];
		$AltKategoriId = $kategoriid;
	}
	$Stok = $_POST['Stok'];
	$Sure = $_POST['Sure'];
	$GecerliYerler = $_POST['GecerliYerler'];
	$Veri = $_POST['Veri'];
	
	$urunkaydet = $kpanel->query("Update Urunler set Adi = '".$Adi."', Aciklama = '".$Aciklama."', KisaAciklama = '".$KisaAciklama."', Resim = '".$Resim."', Fiyat = '".$Fiyat."', UrunKategoriId = '".$UrunKategoriId."', AltKategoriId = '".$AltKategoriId."', Stok = '".$Stok."', Sure = '".$Sure."', GecerliYerler = '".$GecerliYerler."', Veri = '".$Veri."', Sira = '".$sira."' where (UrunId = '".$_REQUEST['p']."')");
	
	$_SESSION['yeniurun'] = 'Ürününüz başarıyla güncellenmiştir.';
	header('Location:duzenleurun.php?p='.$urun['UrunId']);
}
?>
					<?php include_once('footer.php'); ?>
				</div>
			</div>
		</div>
	</div>
<script>
	$(document).ready(function() {
		$("#kategori").select2();  
		$("#GecerliYerler").select2();  
		$("#Sure").select2();  
		$("#Stok").select2();  
	});
</script>
<script>
function yeniurun() {
return	confirm("Ürün güncellenecektir, onaylıyor musunuz?");
}
</script>
</body>
</html>