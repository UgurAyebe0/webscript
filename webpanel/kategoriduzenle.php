<?php 
include_once('header2.php'); echo '<style>.close {    margin-top: -29px;}</style>';

$yeniurunm = '';
$anasayfam = '';
$urunlerm = '';
$yenikategorim = '';
$kategorilerm = '';
$sayfaeklem = '';
$sayfalarm = '';
$kategoriduzenlem = 'active';
$kategori = $db->prepare("select * from kategoriler where (id = '".$_REQUEST['id']."')");
$result = $kategori->execute();
$kategori   = $kategori->fetch(PDO::FETCH_ASSOC);

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
							<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Kategoriler <span> - Kategori Düzenleme</h4>
						</div>

						
					</div>

					<div class="breadcrumb-line">
						<ul class="breadcrumb">
							<li><a href="/webpanel/"><i class="icon-home2 position-left"></i> Anasayfa</a></li>
							<li class="active"><?php echo $kategori['kategori_TR']; ?> - Kategori Düzenleme</li>
						</ul>


					</div>
				</div>
				<div class="content">
					<div class="panel panel-flat">
						<div class="panel-body">
						<?php 						
						if($_SESSION['kategoriduzenle'] != ''){							
						echo '<div class="alert alert-success" role="alert">'.$_SESSION['kategoriduzenle'].'</div>';						
						$_SESSION['kategoriduzenle'] = '';						
						}						
						?>		
							<form class="form-horizontal" method="POST" enctype="multipart/form-data">
								<fieldset class="content-group">
									<legend class="text-bold"><i class="fa fa-edit"></i> Kategori Düzenleme</legend>
									<div class="form-group">
										<label class="control-label col-lg-2">Kategori Adı</label>
										<div class="col-lg-10">
											<input type="text" class="form-control" name="kategoriadi" value="<?php echo $kategori['kategori_TR']; ?>" required>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-lg-2">Renk</label>
										<div class="col-lg-10">
											<input type="color" class="form-control" name="renk" value="<?php echo $kategori['renk']; ?>" required>
										</div>
									</div>
								</fieldset>
								<div class="text-right">
									<input type="submit" class="btn btn-success" style="min-width:150px;" onclick="return kategoriduzenle();" value="Kaydet" name="kategoriduzenle">
								</div>
							</form>
						</div>
					</div>
<?php
if($_POST['kategoriduzenle']){
	$url = seoUrl($_POST['kategoriadi']);
	$kategoriadi = $_POST['kategoriadi'];
	$renk = $_POST['renk'];
	$id = $_REQUEST['id'];
	
	$kategorikaydet = $db->query("update kategoriler set kategori_TR = '".$kategoriadi."', renk = '".$renk."', kategorikodu = '".$url."', yayin = '1' where (id = '".$id."')");
	$_SESSION['kategoriduzenle'] = 'Kategoriniz başarıyla güncellenmiştir.';
	header('Location:kategoriduzenle.php?id='.$_REQUEST['id']);
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
function kategoriduzenle() {
return	confirm("Kategori güncellenecektir, onaylıyor musunuz?");
}
</script>
</body>
</html>