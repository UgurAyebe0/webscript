<?php 
include_once('header2.php');
$yeniurunm = '';
$anasayfam = '';
$urunlerm = '';
$yenikategorim = '';
$urunkategorilerm = 'active';
$sayfaeklem = '';
$sayfalarm = '';
?>
<script>
	
$.fn.dataTable.ext.errMode = 'none';
</script>

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
							<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Ürün Kategorileri <span> - Kategori Listesi</h4>
						</div>

	
					</div>

					<div class="breadcrumb-line">
						<ul class="breadcrumb">
							<li><a href="/webpanel/"><i class="icon-home2 position-left"></i> Anasayfa</a></li>
							<li class="active">Kategori Listesi</li>
						</ul>


					</div>
				</div>
				<!-- /page header -->
				<!-- Content area -->
				<div class="content">

					<!-- ürünler -->
					<div class="panel panel-flat">
						<div class="panel-heading">
							<h5 class="panel-title"><i class="fa fa-th-list"></i> Kategori Listesi</h5>
							<div class="heading-elements">
								<ul class="icons-list">
			                		<li><a data-action="collapse"></a></li>
			                		<li><a data-action="reload"></a></li>
			                	</ul>
		                	</div>
						</div>

						<table class="table datatable-basic">
							<thead>
								<tr>
									<th>Kategori Adı</th>
									<th>Üst Kategori</th>
									<th class="text-center">İşlemler</th>
								</tr>
							</thead>
							<tbody>
<?php 
$urunler = $kpanel->query("select * from UrunKategorileri");
foreach($urunler as $urun){
if($urun['AltKategori'] != '0'){
	$ustkategori = $kpanel->prepare("select * from UrunKategorileri where (KategoriAdi = '".$urun['UstKategori']."')");
	$result = $ustkategori->execute();
	$ustkategori   = $ustkategori->fetch(PDO::FETCH_ASSOC);
	$ustkat = $ustkategori['KategoriAdi'];
}else{
	$ustkat = 'Ana Kategori';
}

		echo '<tr>';
			echo '<td>'.$urun['KategoriAdi'].'</td>';
			echo '<td>'.$ustkat.'</td>';
			echo '<td class="text-center">';
			echo '<form method="POST">';
				echo '<ul class="icons-list">';
					echo '<li class="dropdown">';
						echo '<a href="#" class="dropdown-toggle" data-toggle="dropdown">';
							echo '<i class="icon-menu9"></i>';
						echo '</a>';
						echo '<ul class="dropdown-menu dropdown-menu-right">';
							echo '<li><a href="/webpanel/urunkategoriduzenle.php?id='.$urun['UrunKategoriId'].'" class="btn btn-block btn-sm btn-primary"  style="border-radius:0px;">Düzenle</a>';
							echo '<li><input type="submit" class="btn btn-danger btn-sm btn-block" onclick="return urunsil()" value="Sil" name="'.$urun['UrunKategoriId'].'sil" style="border-radius:0px;"></li>';
						echo '</ul>';
					echo '</li>';
				echo '</ul>';
			echo '</form>';
			echo '</td>';
		echo '</tr>';
	if($_POST[''.$urun['UrunKategoriId'].'sil']){
		$db->query("delete from UrunKategorileri where (UrunKategoriId = '".$urun['UrunKategoriId']."')");
		header('Location:urunkategoriler.php');
	}

	if($_POST[''.$urun['UrunKategoriId'].'duzenle']){
		header('Location:urunkategoriduzenle.php?p='.$urun['UrunKategoriId'].'');
	}
}
?>
								
							</tbody>
						</table>
					</div>
					<!-- /urunler -->
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
function urunsil() {
return	confirm("Seçtiğiniz kategori sistemden silinecektir, eğer bu kategori altında ürün varsa kategorisiz olacaktır, onaylıyor musunuz?");
}
</script>
</body>
</html>