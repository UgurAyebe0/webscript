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
$yeniyoneticim = 'active';
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
							<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Yönetim <span> - Yönetici Ekle</h4>
						</div>


					</div>

					<div class="breadcrumb-line">
						<ul class="breadcrumb">
							<li><a href="/webpanel/"><i class="icon-home2 position-left"></i> Anasayfa</a></li>
							<li class="active">Yönetici Ekle</li>
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
									<legend class="text-bold"><i class="fa fa-plus"></i> Yönetici Ekle</legend>

									<div class="form-group">
										<label class="control-label col-lg-2">Adı</label>
										<div class="col-lg-10">
											<input type="text" class="form-control" name="adi" required>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-lg-2">Soyadı</label>
										<div class="col-lg-10">
											<input type="text" class="form-control" name="soyadi" required>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-lg-2">Telefon</label>
										<div class="col-lg-10">
											<input type="text" class="form-control" name="telefon" required>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-lg-2">Email</label>
										<div class="col-lg-10">
											<input type="text" class="form-control" name="email" required>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-lg-2">Kullanıcı Adı</label>
										<div class="col-lg-10">
											<input type="text" class="form-control" name="kullaniciadi" required>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-lg-2">Parola</label>
										<div class="col-lg-10">
											<input type="text" class="form-control" name="parola" required>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-lg-2">Üye Grubu</label>
										<div class="col-lg-10">
											<select class="form-control" name="grup" required>
											<option value="Admin">Lütfen Seçiniz</option>
											<option value="Admin">Admin</option>
											<option value="Editor">Editör</option>
											</select>
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
	 
	$parola = $_POST['parola'];
	$adi = $_POST['adi'];
	$soyadi = $_POST['soyadi'];
	$telefon = $_POST['telefon'];
	$email = $_POST['email'];
	$grup = $_POST['grup'];
	$kullaniciadi = $_POST['kullaniciadi'];
	
	$yoneticikaydet = $db->query("insert into yoneticiler (kullaniciadi, parola, adi, soyadi, telefon, email, yetki, durum) values ('$kullaniciadi', '$parola', '$adi', '$soyadi', '$telefon', '$email', '$grup', '1')");
	$_SESSION['yenisayfa'] = 'Yönetici başarıyla sisteme eklenmiştir.';
	header('Location:yeniyonetici.php');
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
return	confirm("Yönetici sisteme eklenecektir, onaylıyor musunuz?");
}
</script>
</body>
</html>