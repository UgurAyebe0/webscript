<?php 
include_once('header2.php'); 
echo '<style>.close {
    margin-top: -29px;
}</style>';

$kullanicilarm = 'active';
$kullanici = $kpanel->prepare("select * from Kullanicilar where (KullaniciId = '".$_REQUEST['id']."')");
$result = $kullanici->execute();
$kullanici   = $kullanici->fetch(PDO::FETCH_ASSOC);

$grup = $yetkiler->prepare("select * from perm_playergroups where (playeruuid = '".$kullanici["uuid"]."') && (groupid != '16') && (groupid != '17') && (groupid != '18')  order by groupid desc");
$result = $grup->execute();
$grup  = $grup->fetch(PDO::FETCH_ASSOC);

$grupadi = $yetkiler->prepare("select * from perm_groups where (id = '".$grup['groupid']."')");
$result = $grupadi->execute();
$grupadi  = $grupadi->fetch(PDO::FETCH_ASSOC);
if($grupadi['name'] == NULL){$grupadi['name'] = 'Oyuncu';}
if($grupadi['id'] == '6' or $grupadi['id'] == NULL){
	$renk = '#5555FF';

}elseif($grupadi['id'] == '15'){
	$renk = '#AA0000';
}elseif($grupadi['id'] == '7'){
	$renk = '#55FFFF';
}elseif($grupadi['id'] == '8'){
	$renk = '#00AAAA';
}elseif($grupadi['id'] == '9'){
	$renk = '#00AA00';
}elseif($grupadi['id'] == '10'){
	$renk = '#AA00AA';
}elseif($grupadi['id'] == '11'){
	$renk = '#55FF55';
}elseif($grupadi['id'] == '12'){
	$renk = '#FF55FF';
}elseif($grupadi['id'] == '13'){
	$renk = '#FFAA00';
}elseif($grupadi['id'] == '14'){
	$renk = '#AA0000';
}


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
							<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Kullanıcı Yönetimi <span></h4>
						</div>

					</div>

					<div class="breadcrumb-line">
						<ul class="breadcrumb">
							<li><a href="/webpanel/"><i class="icon-home2 position-left"></i> Anasayfa</a></li>
							<li class="active">Kullanıcı Yönetimi</li>
							
						</ul>
						<div class="" style="float:right;padding-top:5px;padding-bottom:5px;">
							<a href="/webpanel/kullanicidetay.php?id=<?php echo $kullanici['KullaniciId']; ?>" class="btn btn-primary btn-sm" style="margin-right:10px;"> Genel Yönetim </a>
							<a href="/webpanel/kullanicisatislar.php?id=<?php echo $kullanici['KullaniciId']; ?>" class="btn btn-primary btn-sm" style="margin-right:10px;"> Satınalma Geçmişi </a>
							<a href="/webpanel/kullaniciyuklemeler.php?id=<?php echo $kullanici['KullaniciId']; ?>" class="btn btn-primary btn-sm" style="margin-right:10px;"> Kredi Geçmişi </a>
						</div>

					</div>
				</div>
				<div class="content">
					<div class="panel panel-flat">
						<div class="panel-body">
						<?php 
						if($_SESSION['konuduzenleme'] != ''){
							echo '<div class="alert alert-success" role="alert">'.$_SESSION['konuduzenleme'].' '.$_SESSION['kontrol'].' '.$_SESSION['emailkaydet'].'</div>';
							$_SESSION['konuduzenleme'] = '';
							$_SESSION['kontrol'] = '';
							$_SESSION['emailkaydet'] = '';
						}
						
						?>
							<form class="form-horizontal" method="POST" enctype="multipart/form-data">
								<fieldset class="content-group">
									<legend>
	<?php								
	echo '<a href="'.$domain.'profile.php?p='.$kullanici['username'].'" style="text-decoration:none;text-transform: none;" target="_blank"> <img alt="" src="https://minepic.org/avatar/'.$kullanici['username'].'" height="15" width="15" style="margin-right: 5px;margin-top: -3px;"> '.$kullanici['username'].'</a>';
	echo '<span class="label" style="font-size:12px;vertical-align:middle;position: absolute;margin-top: -3px;margin-left: 5px;background:'.$renk.';transform: skew(-7deg);border-radius:0px;">'.$grupadi['name'].'</span>';
	?>
	
	<div class="col-md-2" style="float:right;text-transform:none;"><strong>Toplam Kredi:</strong> <span style="font-size:14px;color:red;"><?php echo $kullanici['Kredi']; ?></span></div>
	</legend>
									
									<div class="form-group">
										<label class="control-label col-lg-3">Site içi forum ve yorumlarda yasakla</label>
										<div class="col-lg-4" style="font-size:24 !important">
<?php 
if($kullanici['yasakli'] == '1'){
?>										
											<input type="radio" name="yasakli" id="evet" value="1" style="width:10%" checked> <label for="evet" class="text-success" style="width:50%;">Evet</label><hr>
											<input type="radio" name="yasakli" id="hayir" style="width:10%" value="0"> <label class="text-danger" for="hayir" style="width:50%">Hayır</label>
<?php 
}else{
?>	
											<input type="radio" name="yasakli" id="evet" value="1" style="width:10%" > <label for="evet" class="text-success" style="width:50%;">Evet</label><hr>
											<input type="radio" name="yasakli" id="hayir" style="width:10%" value="0" checked> <label class="text-danger" for="hayir" style="width:50%">Hayır</label>

<?php 
}
?>											
										</div>
										<div class="col-lg-5" style="font-size:24 !important">
										<textarea class="form-control" name="nedeni" rows="4" placeholder="Yasaklanma nedenini belirtiniz..."></textarea>
										</div>
									</div>
									<legend></legend>
									<div class="form-group">
										<label class="control-label col-lg-3">Toplam Kredisini Güncelle <br><small>(sadece rakam giriniz)</small></label>
										<div class="col-lg-9">
											<input type="text" class="form-control" name="Kredi" value="<?php echo $kullanici['Kredi']; ?>">
										</div>
									</div>
									<legend></legend>
									<div class="form-group">
										<label class="control-label col-lg-2">E-Posta</label>
										<div class="col-lg-10">
											<input type="text" class="form-control" name="email" value="<?php echo $kullanici['email']; ?>">
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-lg-2">Skype</label>
										<div class="col-lg-10">
											<input type="text" class="form-control" name="skype" value="<?php echo $kullanici['skype']; ?>">
										</div>
									</div>
									
									<div class="form-group">
										<label class="control-label col-lg-2">Discord</label>
										<div class="col-lg-10">
											<input type="text" class="form-control" name="discord" value="<?php echo $kullanici['discord']; ?>">
										</div>
									</div>
									
									<div class="form-group">
										<label class="control-label col-lg-2">Steam</label>
										<div class="col-lg-10">
											<input type="text" class="form-control" name="steam" value="<?php echo $kullanici['steam']; ?>">
										</div>
									</div>
									
									<div class="form-group">
										<label class="control-label col-lg-2">Youtube</label>
										<div class="col-lg-10">
											<input type="text" class="form-control" name="youtube" value="<?php echo $kullanici['youtube']; ?>">
										</div>
									</div>
									
									<div class="form-group">
										<label class="control-label col-lg-2">Hakkında</label>
										<div class="col-lg-10">
											<textarea class="form-control" name="hakkimda" rows="4" placeholder="Hakkında..."><?php echo $kullanici['hakkimda']; ?></textarea>
										</div>
									</div>
									<legend></legend>
									
									<div class="form-group">
										<label class="control-label col-lg-2">Parolası</label>
										<div class="col-lg-10">
											<input type="text" class="form-control" name="parola" placeholder="Değiştirmeyecekseniz boş bırakınız">
										</div>
									</div>
									
								</fieldset>
								<div class="text-right">
									<input type="submit" class="btn btn-success" style="min-width:150px;" onclick="return kullaniciduzenleme();" value="Kaydet" name="kullaniciduzenleme">
								</div>
							</form>
						</div>
					</div>
<?php
if($_POST['kullaniciduzenleme']){
	$yasakli = $_POST['yasakli'];
	$nedeni = $_POST['nedeni'];
	$skype = $_POST['skype'];
	$discord = $_POST['discord'];
	$steam = $_POST['steam'];
	$youtube = $_POST['youtube'];
	$hakkimda = $_POST['hakkimda'];
	$kredi = $_POST['Kredi'];
	if($_POST['email'] == $kullanici['email']){
		$gemail = $kullanici['email'];
	}else{
		$emailkontrol = $kpanel->prepare("select * from Kullanicilar where (email = '".$_POST['email']."')");
		$result = $emailkontrol->execute();
		$emailkontrol   = $emailkontrol->fetch(PDO::FETCH_ASSOC);
		if($emailkontrol['username'] == ''){
			$gemail = $_POST['email'];
		}else{
			$gemail = $kullanici['email'];
			$_SESSION['emailkaydet'] = 'Değiştirmek istediğiniz email sistemde kayıtlı olduğu için değiştirilemedi';
		}
	}

	$kullanicikaydet = $kpanel->query("update Kullanicilar set yasakli = '".$yasakli."', nedeni = '".$nedeni."', email = '".$gemail."', skype = '".$skype."', discord = '".$discord."', steam = '".$steam."', youtube = '".$youtube."', hakkimda = '".$hakkimda."', Kredi = '".$kredi."' where (KullaniciId = '".$_REQUEST['id']."') ");
	
	
if($_POST['parola'] != ''){
	
	if(strlen($_POST['parola'])<6 OR strlen($_POST['parola'])>18){
		echo '<script> alert(\'Şifre en az 6 karakter, en fazla 18 karakter olabilir. Lütfen tekrar deneyiniz.\'); </script>';
	}else{
		
		
			
			$yenisifre2 = Sifrele($_POST['parola']);	
			$yenisifre = SifreleSite($_POST['parola']);
					
			
			$kpanel->query("update Kullanicilar set password = '".$yenisifre2."', passwordsite = '".$yenisifre."' where (KullaniciId = '".$_REQUEST['id']."') ");
			$_SESSION['kontrol'] = 'Şifre başarıyla güncellenmiştir.';

		
		
	}
	
}
	
	
	
	$_SESSION['konuduzenleme'] = 'Kullanıcı başarıyla güncellenmiştir.';
	header('Location:kullanicidetay.php?id='.$_REQUEST['id']);
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
function kullaniciduzenleme() {
return	confirm("Kullanıcı güncellenecektir, onaylıyor musunuz?");
}
</script>
</body>
</html>