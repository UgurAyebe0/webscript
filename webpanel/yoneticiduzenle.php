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
$yoneticilerm = 'active';
$yonetici = $db->prepare("select * from yoneticiler where (id = '".$_REQUEST['id']."')");
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
							<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Yönetim <span> - Yönetici Düzenle</h4>
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
							<li class="active">Yönetici Düzenle</li>
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
						if($_SESSION['yenisayfa'] != ''){
							echo '<div class="alert alert-success" role="alert">'.$_SESSION['yenisayfa'].'</div>';
							$_SESSION['yenisayfa'] = '';
						}
						
						?>
							<form class="form-horizontal" method="POST" enctype="multipart/form-data">
								<fieldset class="content-group">
									<legend class="text-bold"><i class="fa fa-edit"></i> Yönetici Düzenle</legend>

									<div class="form-group">
										<label class="control-label col-lg-2">Adı</label>
										<div class="col-lg-10">
											<input type="text" class="form-control" name="adi" value="<?php echo $yonetici['adi']; ?>" required>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-lg-2">Soyadı</label>
										<div class="col-lg-10">
											<input type="text" class="form-control" name="soyadi" value="<?php echo $yonetici['soyadi']; ?>" required>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-lg-2">Telefon</label>
										<div class="col-lg-10">
											<input type="text" class="form-control" name="telefon" value="<?php echo $yonetici['telefon']; ?>" required>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-lg-2">Email</label>
										<div class="col-lg-10">
											<input type="text" class="form-control" name="email" value="<?php echo $yonetici['email']; ?>" required>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-lg-2">Kullanıcı Adı</label>
										<div class="col-lg-10">
											<input type="text" class="form-control" name="kullaniciadi" value="<?php echo $yonetici['kullaniciadi']; ?>" required>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-lg-2">Parola</label>
										<div class="col-lg-10">
											<input type="password" class="form-control" name="parola" value="<?php echo $yonetici['parola']; ?>" required>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-lg-2">Üye Grubu</label>
										<div class="col-lg-10">
											<select class="form-control" name="grup">
<?php echo '<option value="'.$yonetici['yetki'].'">'.$yonetici['yetki'].'</option>'; ?>
											<option value="Admin">Lütfen Seçiniz</option>
											<option value="Admin">Admin</option>
											<option value="Editor">Editör</option>
											</select>
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
	
	$kullaniciadi = $_POST['kullaniciadi'];
	$parola = $_POST['parola'];
	$adi = $_POST['adi'];
	$soyadi = $_POST['soyadi'];
	$telefon = $_POST['telefon'];
	$email = $_POST['email'];
	$grup = $_POST['grup'];
	$id = $_REQUEST['id'];
	
	$yoneticikaydet = $db->query("update yoneticiler set kullaniciadi = '".$kullaniciadi."', parola = '".$parola."', adi = '".$adi."', soyadi = '".$soyadi."', telefon = '".$telefon."', email = '".$email."', yetki = '".$grup."', durum = '1' where (id = '".$id."')");
	$_SESSION['yenisayfa'] = 'Yönetici başarıyla güncellenmiştir.';
	header('Location:yoneticiduzenle.php?id='.$_REQUEST['id']);
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