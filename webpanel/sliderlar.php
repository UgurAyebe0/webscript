<?php 
include_once('header2.php');
$yeniurunm = '';
$anasayfam = '';
$urunlerm = '';
$yenikategorim = '';
$kategorilerm = '';
$sayfaeklem = '';
$sayfalarm = '';
$galerim = '';
$sliderlarm = 'active';
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
							<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Slider <span> - Slider Listesi</h4>
						</div>

					
					</div>

					<div class="breadcrumb-line">
						<ul class="breadcrumb">
							<li><a href="/webpanel/"><i class="icon-home2 position-left"></i> Anasayfa</a></li>
							<li class="active">Slider Listesi</li>
						</ul>

					</div>
				</div>
				<!-- /page header -->
				<!-- Content area -->
				<div class="content">

					<!-- ürünler -->
					<div class="panel panel-flat">
						<div class="panel-heading">
							<h5 class="panel-title"><i class="fa fa-th-list"></i> Slider Listesi</h5>
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
									<th>Görsel</th>
									<th>Başlık</th>
									<th>Buton Adı</th>
						
									<th>Yayın</th>
									<th class="text-center">İşlemler</th>
								</tr>
							</thead>
							<tbody>
<?php 
$resimler = $db->query("select * from slider");
foreach($resimler as $sayfa){
		echo '<tr>';
			echo '<td><img src="'.$domain.'images/home-slide/'.$sayfa['gorsel'].'" style="width:80px;height:40px;"></td>';			
			echo '<td>'.$sayfa['baslik'].'</td>';
			echo '<td>'.$sayfa['butonadi'].'</td>';

			
		if($sayfa['yayin'] == '1'){
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
							echo '<li><a href="/webpanel/slideduzenle.php?id='.$sayfa['id'].'" class="btn btn-block btn-sm btn-primary"  style="border-radius:0px;">Düzenle</a>';
							echo '<li><input type="submit" class="btn btn-success btn-sm btn-block" value="Aktif / Pasif" name="'.$sayfa['id'].'aktifpasif" style="border-radius:0px;"></li>';
							echo '<li><input type="submit" class="btn btn-danger btn-sm btn-block" onclick="return sayfasil()" value="Sil" name="'.$sayfa['id'].'sil" style="border-radius:0px;"></li>';
						echo '</ul>';
					echo '</li>';
				echo '</ul>';
			echo '</form>';
			echo '</td>';
		echo '</tr>';
	if($_POST[''.$sayfa['id'].'sil']){
		$db->query("delete from slider where (id = '".$sayfa['id']."')");
		header('Location:sliderlar.php');
	}
	if($_POST[''.$sayfa['id'].'aktifpasif']){
		if($sayfa['yayin'] == '1'){
			$db->query("update slider set yayin = '0' where (id = '".$sayfa['id']."')");
		}else{
			$db->query("update slider set yayin = '1' where (id = '".$sayfa['id']."')");
		}
		header('Location:sliderlar.php');
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
function sayfasil() {
return	confirm("Seçtiğiniz slide sistemden silinecektir, onaylıyor musunuz?");
}
</script>
</body>
</html>