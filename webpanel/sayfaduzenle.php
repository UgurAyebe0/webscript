<?php 
include_once('header2.php'); 

$sayfalarm = 'active';

$sayfa = $db->prepare("select * from sayfalar where (id = '".$_REQUEST['p']."')");
$result = $sayfa->execute();
$sayfa   = $sayfa->fetch(PDO::FETCH_ASSOC);


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
							<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Sayfalar <span> - Sayfa Düzenleme</h4>
						</div>

						
					</div>

					<div class="breadcrumb-line">
						<ul class="breadcrumb">
							<li><a href="/webpanel/"><i class="icon-home2 position-left"></i> Anasayfa</a></li>
							<li class="active"><?php echo $sayfa['baslik']; ?> - Sayfa Düzenleme</li>
						</ul>


					</div>
				</div>
				<div class="content">
					<div class="panel panel-flat">
						<div class="panel-body">
						<?php 
		
						if($_SESSION['sayfaduzenleme'] != ''){
							echo '<div class="alert alert-success" role="alert">'.$_SESSION['sayfaduzenleme'].'</div>';
							$_SESSION['sayfaduzenleme'] = '';
						}
						?>
							<form class="form-horizontal" method="POST" enctype="multipart/form-data">
								<fieldset class="content-group">
									<legend class="text-bold"><i class="fa fa-edit"></i> Sayfa Düzenleme</legend>

									<div class="form-group">
										<label class="control-label col-lg-2">Başlık</label>
										<div class="col-lg-10">
											<input type="text" class="form-control" name="baslik" value="<?php echo $sayfa['baslik']; ?>" required>
										</div>
									</div>

									<div class="form-group">
										<label class="control-label col-lg-2">İçerik</label>
										<div class="col-lg-10">
											<textarea class="form-control ckeditor" name="icerik"><?php echo $sayfa['icerik']; ?></textarea>
										</div>
									</div>
								</fieldset>
								<div class="text-right">
									<input type="submit" class="btn btn-success" style="min-width:150px;" onclick="return sayfaduzenleme();" value="Güncelle" name="sayfaduzenleme">
								</div>
							</form>
						</div>
					</div>
<?php
if($_POST['sayfaduzenleme']){
	
	$url = seoUrl($_POST['baslik']);
	$time = time();
	$db->query("update sayfalar set baslik = '".$_POST['baslik']."', urlkodu = '".$url."', icerik = '".$_POST['icerik']."', stamp = '".$time."' where (id = '".$_REQUEST['p']."')");
	$_SESSION['sayfaduzenleme'] = 'Sayfanız başarıyla güncellenmiştir.';
	header('Location:sayfaduzenle.php?p='.$_REQUEST['p']);
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
function sayfaduzenleme() {
return	confirm("Sayfa güncellenecektir, onaylıyor musunuz?");
}
</script>
</body>
</html>