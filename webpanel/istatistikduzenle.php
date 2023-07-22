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
$sayfaduzenlem = '';
$istatistikm = 'active';
$sayfa = $core->db->row("select * from istatistikler where (id = :id);",array('id' => $_REQUEST['id']));
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
							<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">İstatistik <span> - İstatistik Düzenleme</h4>
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
							<li class="active">İstatistik Düzenleme</li>
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
						if($_SESSION['sayfaduzenleme'] != ''){
							echo $core->bootstrap->alertBS($_SESSION['sayfaduzenleme'],"info",15,true);
							$_SESSION['sayfaduzenleme'] = '';
						}
						
						?>
							<form class="form-horizontal" method="POST" enctype="multipart/form-data">
								<fieldset class="content-group">
									<legend class="text-bold"><i class="fa fa-edit"></i> İstatistik Düzenleme</legend>
									
									<div class="form-group">
										<label class="control-label col-lg-2">Yazı</label>
										<div class="col-lg-10">
											<textarea class="form-control" name="yazi" rows="5" ><?php echo $sayfa['yazi']; ?></textarea>
										</div>
									</div>
									
									<div class="form-group">
										<label class="control-label col-lg-2">Toplam Proje</label>
										<div class="col-lg-10">
											<input type="text" class="form-control" name="proje" value="<?php echo $sayfa['proje']; ?>" required>
										</div>
									</div>

									<div class="form-group">
										<label class="control-label col-lg-2">Toplam Ödev</label>
										<div class="col-lg-10">
											<input type="text" class="form-control" name="odev" value="<?php echo $sayfa['odev']; ?>" required>
										</div>
									</div>
									
									<div class="form-group">
										<label class="control-label col-lg-2">Toplam Tez</label>
										<div class="col-lg-10">
											<input type="text" class="form-control" name="tez" value="<?php echo $sayfa['tez']; ?>" required>
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
	
	$urunkaydet = $core->db->query("update istatistikler set yazi = :yazi, proje = :proje, odev = :odev, tez = :tez, stamp = :stamp where (id = :id);",array('yazi' => $_POST['yazi'], 'proje' => $_POST['proje'], 'odev' => $_POST['odev'], 'tez' => $_POST['tez'], 'stamp' => time(), 'id' => $_REQUEST['id']));
	$_SESSION['sayfaduzenleme'] = 'İstatistikler başarıyla güncellenmiştir.';
	header('Location:istatistikduzenle.php?id='.$_REQUEST['id']);
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
return	confirm("İstatistik güncellenecektir, onaylıyor musunuz?");
}
</script>
</body>
</html>