<?php 
include_once('header2.php'); echo '<style>.close {    margin-top: -29px;}</style>';

$yeniurunm = '';
$anasayfam = '';
$urunlerm = '';
$yenikategorim = '';
$kategorilerm = '';
$sayfaeklem = '';
$sayfalarm = '';
$hizmetkategoriduzenlem = 'active';
$kategori = $core->db->row("select * from yenihizmetkategori where (id = :id);",array('id' => $_REQUEST['id']));

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
							<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Hizmet Kategorileri <span> - Kategori Düzenleme</h4>
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
							<li class="active"><?php echo $kategori['kategori_TR']; ?> - Kategori Düzenleme</li>
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
						if($_SESSION['kategoriduzenle'] != ''){
							echo $core->bootstrap->alertBS($_SESSION['kategoriduzenle'],"info",15,true);
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
										<label class="control-label col-lg-2">İçerik</label>
										<div class="col-lg-10">
											<textarea class="form-control ckeditor" name="icerik"><?php echo $kategori['icerik']; ?></textarea>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-lg-2">Sıra</label>
										<div class="col-lg-10">
											<input type="text" class="form-control" name="sira" value="<?php echo $kategori['sira']; ?>" required>
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
	$kategorikaydet = $core->db->query("update yenihizmetkategori set kategori_TR = :kategori_TR, kategorikodu = :kategorikodu, icerik = :icerik, sira = :sira, yayin = :yayin where (id = :id);",array('kategori_TR' => $_POST['kategoriadi'], 'kategorikodu' => $url, 'icerik' => $_POST['icerik'], 'sira' => $_POST['sira'], 'yayin' => '1', 'id' => $_REQUEST['id']));
	$_SESSION['kategoriduzenle'] = 'Kategoriniz başarıyla güncellenmiştir.';
	header('Location:hizmetkategoriduzenle.php?id='.$_REQUEST['id']);
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