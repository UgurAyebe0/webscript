<?php 
include_once('header2.php');
$yeniurunm = '';
$anasayfam = '';
$urunlerm = '';
$yenikategorim = '';
$kategorilerm = 'active';
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
							<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Kategoriler <span> - Kategori Listesi</h4>
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
									<th>Makale Sayısı</th>
									<th>Renk</th>
									<th>Durum</th>
									<th class="text-center">İşlemler</th>
								</tr>
							</thead>
							<tbody>
<?php 
$urunler = $db->query("select * from kategoriler");
foreach($urunler as $urun){
$urunsayisi = $db->prepare("select count(id) from makaleler where (kategori = '".$urun['id']."')");
$result = $urunsayisi->execute();
$urunsayisi   = $urunsayisi->fetchColumn();

		echo '<tr>';
			echo '<td>'.$urun['kategori_TR'].'</td>';
			echo '<td>'.$urunsayisi.'</td>';
			echo '<td><label style="background:'.$urun['renk'].';color:#000;padding:5px;">'.$urun['renk'].'</label></td>';
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
							echo '<li><a href="/webpanel/kategoriduzenle.php?id='.$urun['id'].'" class="btn btn-block btn-sm btn-primary"  style="border-radius:0px;">Düzenle</a>';
							echo '<li><input type="submit" class="btn btn-success btn-sm btn-block" value="Aktif / Pasif" name="'.$urun['id'].'aktifpasif" style="border-radius:0px;"></li>';
							echo '<li><input type="submit" class="btn btn-danger btn-sm btn-block" onclick="return urunsil()" value="Sil" name="'.$urun['id'].'sil" style="border-radius:0px;"></li>';
						echo '</ul>';
					echo '</li>';
				echo '</ul>';
			echo '</form>';
			echo '</td>';
		echo '</tr>';
	if($_POST[''.$urun['id'].'sil']){
		$db->query("delete from kategoriler where (id = '".$urun['id']."')");
		header('Location:kategoriler.php');
	}
	if($_POST[''.$urun['id'].'aktifpasif']){
		if($urun['yayin'] == '1'){
			$db->query("update kategoriler set yayin = '0' where (id = '".$urun['id']."')");
		}else{
			$db->query("update kategoriler set yayin = '1' where (id = '".$urun['id']."')");
		}
		header('Location:kategoriler.php');
	}
	if($_POST[''.$urun['id'].'duzenle']){
		header('Location:kategoriduzenle.php?p='.$urun['id'].'');
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