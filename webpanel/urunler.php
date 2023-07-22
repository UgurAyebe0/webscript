<?php 
include_once('header2.php');
$yeniurunm = '';
$anasayfam = '';
$urunlerm = 'active';
$yenikategorim = '';
$kategorilerm = '';
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
							<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Ürünler <span> - Ürün Listesi</h4>
						</div>


					</div>

					<div class="breadcrumb-line">
						<ul class="breadcrumb">
							<li><a href="/webpanel/"><i class="icon-home2 position-left"></i> Anasayfa</a></li>
							<li class="active">Ürün Listesi</li>
						</ul>


					</div>
				</div>
				<!-- /page header -->
				<!-- Content area -->
				<div class="content">

					<!-- ürünler -->
					<div class="panel panel-flat">
						<div class="panel-heading">
							<h5 class="panel-title"><i class="fa fa-th-list"></i> Ürünler Listesi</h5>
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
									<th>Resim</th>
									<th>Ürün Adı</th>
									<th>Kategori</th>
									<th>Fiyat(Kredi)</th>
									<th>Durum</th>
									<th class="text-center">İşlemler</th>
								</tr>
							</thead>
							<tbody>
<?php 
$urunler = $kpanel->query("select * from Urunler");
foreach($urunler as $urun){
	if($urun['AltKategoriId'] == '0'){
		$kategoriid = $urun['UrunKategoriId'];
		
		$kategorikontrol = $kpanel->prepare("select * from UrunKategorileri where (UrunKategoriId = '".$kategoriid."')");
		$result = $kategorikontrol->execute();
		$kategorikontrol   = $kategorikontrol->fetch(PDO::FETCH_ASSOC);
		$kat = $kategorikontrol['KategoriAdi'];
	}else{
		$kategoriid = $urun['UrunKategoriId'];
		$altkatid =  $urun['AltKategoriId'];
		
		$kategorikontrol = $kpanel->prepare("select * from UrunKategorileri where (UrunKategoriId = '".$kategoriid."')");
		$result = $kategorikontrol->execute();
		$kategorikontrol   = $kategorikontrol->fetch(PDO::FETCH_ASSOC);
		
		$akategorikontrol = $kpanel->prepare("select * from UrunKategorileri where (UrunKategoriId = '".$altkatid."')");
		$result = $akategorikontrol->execute();
		$akategorikontrol   = $akategorikontrol->fetch(PDO::FETCH_ASSOC);
		
		$kat = $kategorikontrol['KategoriAdi'].' | '.$akategorikontrol['KategoriAdi'];
	}
	
	
	
	
		echo '<tr>';
			echo '<td><img src="'.$urun['Resim'].'" style="width:50px;"></td>';
			echo '<td>'.$urun['Adi'].'</td>';
			echo '<td>'.$kat.'</td>';
			echo '<td>'.$urun['Fiyat'].'</td>';
if($urun['yayin'] == '1'){
			echo '<td><span class="label label-success">Aktif</span></td>';
		}else{
			echo '<td><span class="label label-danger">Pasif</span></td>';
		}
			echo '<td class="text-center">';
			echo '<form method="POST">';
				echo '<ul class="icons-list">';
					echo '<li class="dropdown">';
						echo '<a href="#" class="dropdown-toggle" data-toggle="dropdown">';
							echo '<i class="icon-menu9"></i>';
						echo '</a>';
						echo '<ul class="dropdown-menu dropdown-menu-right">';
							echo '<li><input type="submit" class="btn btn-block btn-sm btn-primary" value="Düzenle" name="'.$urun['UrunId'].'duzenle" style="border-radius:0px;"></li>';
							echo '<li><input type="submit" class="btn btn-success btn-sm btn-block" value="Aktif / Pasif" name="'.$urun['UrunId'].'aktifpasif" style="border-radius:0px;"></li>';
							echo '<li><input type="submit" class="btn btn-danger btn-sm btn-block" onclick="return urunsil()" value="Sil" name="'.$urun['UrunId'].'sil" style="border-radius:0px;"></li>';

						echo '</ul>';
					echo '</li>';
				echo '</ul>';
			echo '</form>';
			echo '</td>';
		echo '</tr>';
	if($_POST[''.$urun['UrunId'].'sil']){
		$kpanel->query("delete from Urunler where (UrunId = '".$urun['UrunId']."')");
		header('Location:urunler.php');
	}
	if($_POST[''.$urun['UrunId'].'aktifpasif']){
		if($urun['yayin'] == '1'){
			$kpanel->query("update Urunler set yayin = '0' where (UrunId = '".$urun['UrunId']."')");
		}else{
			$kpanel->query("update Urunler set yayin = '1' where (UrunId = '".$urun['UrunId']."')");
		}
		header('Location:urunler.php');
	}
	if($_POST[''.$urun['UrunId'].'duzenle']){
		header('Location:duzenleurun.php?p='.$urun['UrunId'].'');
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
return	confirm("Seçtiğiniz ürün sistemden silinecektir, ürün silmeniz veritabanında hata oluşmasına neden olabilir, onaylıyor musunuz?");
}
</script>
</body>
</html>