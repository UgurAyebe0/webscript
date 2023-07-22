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
$gorevlilerm = 'active';
$yonetici = $db->prepare("select * from gorevliler where (id = '".$_REQUEST['id']."')");
$result = $yonetici->execute();
$yonetici = $yonetici->fetch(PDO::FETCH_ASSOC);
if($_SESSION['grup'] != 'Admin'){
	header('Location:/webpanel');
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
							<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Görevliler <span> - Görevli Düzenle</h4>
						</div>


					</div>

					<div class="breadcrumb-line">
						<ul class="breadcrumb">
							<li><a href="/webpanel/"><i class="icon-home2 position-left"></i> Anasayfa</a></li>
							<li class="active">Görevli Düzenle</li>
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
									<legend class="text-bold"><i class="fa fa-edit"></i> Görevli Düzenle</legend>

									<div class="form-group">
										<label class="control-label col-lg-2">Adı</label>
										<div class="col-lg-10">
											<input type="text" class="form-control" name="adi" value="<?php echo $yonetici['adi']; ?>" required>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-lg-2">Kullanıcı Adı</label>
										<div class="col-lg-10">
											<input type="text" class="form-control" name="username" value="<?php echo $yonetici['username']; ?>" required>
										</div>
									</div>
									
	
									<div class="form-group">
										<label class="control-label col-lg-2">Görevi</label>
										<div class="col-lg-10">
											<input type="text" class="form-control" name="gorev" value="<?php echo $yonetici['gorev']; ?>" required>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-lg-2">Sıra</label>
										<div class="col-lg-10">
											<input type="text" class="form-control" name="sira" value="<?php echo $yonetici['sira']; ?>" required>
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
	
	$kullaniciadi = $_POST['username'];
	$adi = $_POST['adi'];
	$sira = $_POST['sira'];
	$gorev = $_POST['gorev'];
	$yayin = $yonetici['yayin'];
	$id = $_REQUEST['id'];
	
	$yoneticikaydet = $db->query("update gorevliler set username = '".$kullaniciadi."', adi = '".$adi."', gorev = '".$gorev."', sira = '".$sira."', yayin = '".$yayin."' where (id = '".$id."')");
	$_SESSION['yenisayfa'] = 'Görevli başarıyla güncellenmiştir.';
	header('Location:gorevliduzenle.php?id='.$_REQUEST['id']);
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
return	confirm("Bilgiler güncellenecektir, onaylıyor musunuz?");
}
</script>
</body>
</html>