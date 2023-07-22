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
$bloklarm = 'active';
$sayfa = $core->db->row("select * from bloklar where (id = :id);",array('id' => $_REQUEST['p']));
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
							<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Bloklar <span> - Blok Düzenleme</h4>
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
							<li class="active"><?php echo $sayfa['baslik']; ?> - Blok Düzenleme</li>
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
									<legend class="text-bold"><i class="fa fa-edit"></i> Blok Düzenleme</legend>
									
									<div class="form-group">
										<label class="control-label col-lg-2">İkon</label>
										<div class="col-lg-10">
											<textarea class="form-control" name="icon" rows="1" ><?php echo $sayfa['icon']; ?></textarea>
										</div>
									</div>
									
									<div class="form-group">
										<label class="control-label col-lg-2">Başlık</label>
										<div class="col-lg-10">
											<input type="text" class="form-control" name="baslik" value="<?php echo $sayfa['baslik']; ?>" required>
										</div>
									</div>

									<div class="form-group">
										<label class="control-label col-lg-2">İçerik</label>
										<div class="col-lg-10">
											<textarea class="form-control" rows="5" name="icerik" required><?php echo $sayfa['icerik']; ?></textarea>
											
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
	
	$urunkaydet = $core->db->query("update bloklar set baslik = :baslik, icon = :icon, icerik = :icerik, yayin = :yayin, stamp = :stamp where (id = :id);",array('baslik' => $_POST['baslik'], 'icon' => $_POST['icon'], 'icerik' => $_POST['icerik'], 'yayin' => '1', 'stamp' => time(), 'id' => $_REQUEST['p']));
	$_SESSION['sayfaduzenleme'] = 'Blok başarıyla güncellenmiştir.';
	header('Location:blokduzenle.php?p='.$_REQUEST['p']);
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
return	confirm("Blok güncellenecektir, onaylıyor musunuz?");
}
</script>
</body>
</html>