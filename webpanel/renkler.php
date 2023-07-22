<?php 
include_once('header2.php'); 

$yeniurunm = '';
$anasayfam = '';
$urunlerm = '';
$yenikategorim = 'active';
$kategorilerm = '';
$sayfaeklem = '';
$sayfalarm = '';
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
							<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Renkler <span> - Yeni Renk Ekle</h4>
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
							<li class="active">Yeni Renk Ekle</li>
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
						if($_SESSION['yenirenk'] != ''){
							echo $core->bootstrap->alertBS($_SESSION['yenirenk'],"info",15,true);
							$_SESSION['yenirenk'] = '';
						}
						
						?>
							<form class="form-horizontal" method="POST" enctype="multipart/form-data">
								<fieldset class="content-group">
									<legend class="text-bold"><i class="fa fa-plus"></i> Yeni Renk Ekle</legend>
									<div class="form-group">
										<div class="input-group">
											<span class="input-group-addon" style="min-width:100px;">Renk Adı</span>
											<input type="text" name="renkadi" class="form-control" placeholder="Renk adını yazınız" value="" required>
										</div>
									</div>
									<div class="form-group">
										<div class="input-group">
											<span class="input-group-addon" style="min-width:100px;">Renk Kodu</span>
											<input type="text" name="renkkodu" class="jscolor form-control" placeholder="Renk kodunu yazınız" value="" required>
										</div>
									</div>
								</fieldset>
								<div class="text-right">
									<input type="submit" class="btn btn-success" style="min-width:150px;" onclick="return yenirenk();" value="Kaydet" name="yenirenkekle">
								</div>
							</form>
						</div>
					</div>
<?php
if($_POST['yenirenkekle']){
	$renkkaydet = $core->db->query("insert into renkler (renkadi, renkkodu, durum) values (:renkadi, :renkkodu, :durum);",array('renkadi' => $_POST['renkadi'], 'renkkodu' => $_POST['renkkodu'], 'durum' => '1'));
	$_SESSION['yenirenk'] = 'Renk başarıyla sisteme eklenmiştir.';
	header('Location:renkler.php');
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
<script type="text/javascript" src="assets/js/jscolor.js"></script>
<script>
function yenirenk() {
return	confirm("Girdiğiniz renk sisteme eklenecektir, onaylıyor musunuz?");
}
</script>
</body>
</html>