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
$yenigorevlim = 'active';
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
							<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Görevliler <span> - Görevli Ekle</h4>
						</div>


					</div>

					<div class="breadcrumb-line">
						<ul class="breadcrumb">
							<li><a href="/webpanel/"><i class="icon-home2 position-left"></i> Anasayfa</a></li>
							<li class="active">Görevli Ekle</li>
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
									<legend class="text-bold"><i class="fa fa-plus"></i> Görevli Ekle</legend>

									<div class="form-group">
										<label class="control-label col-lg-2">Adı</label>
										<div class="col-lg-10">
											<input type="text" class="form-control" name="adi" required>
										</div>
									</div>

									<div class="form-group">
										<label class="control-label col-lg-2">Kullanıcı Adı</label>
										<div class="col-lg-10">
											<input type="text" class="form-control" name="username" required>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-lg-2">Görevi</label>
										<div class="col-lg-10">
											<input type="text" class="form-control" name="gorev" required>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-lg-2">Sira</label>
										<div class="col-lg-10">
											<input type="text" class="form-control" name="sira" required>
										</div>
									</div>
								</fieldset>
								<div class="text-right">
									<input type="submit" class="btn btn-success" style="min-width:150px;" onclick="return yenisayfa();" value="Kaydet" name="yenisayfaekle">
								</div>
							</form>
						</div>
					</div>
<?php
if($_POST['yenisayfaekle']){
	 
	$adi = $_POST['adi'];
	$sira = $_POST['sira'];
	$gorev = $_POST['gorev'];
	$kullaniciadi = $_POST['username'];
	
	$yoneticikaydet = $db->query("insert into gorevliler (username, adi, gorev, sira, yayin) values ('$kullaniciadi', '$adi', '$gorev', '$sira', '1')");
	$_SESSION['yenisayfa'] = 'Görevli başarıyla sisteme eklenmiştir.';
	header('Location:yenigorevli.php');
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
return	confirm("Görevli sisteme eklenecektir, onaylıyor musunuz?");
}
</script>
</body>
</html>