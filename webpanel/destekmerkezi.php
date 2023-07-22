<?php 
include_once('header2.php');
$yeniurunm = '';
$anasayfam = '';
$urunlerm = '';
$yenikategorim = '';
$kategorilerm = '';
$sayfaeklem = '';
$sayfalarm = '';
$destekmermezim = 'active';

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
							<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Destek Merkezi <span> - Talep Listesi</h4>
						</div>


					</div>

					<div class="breadcrumb-line">
						<ul class="breadcrumb">
							<li><a href="/webpanel/"><i class="icon-home2 position-left"></i> Anasayfa</a></li>
							<li class="active">Talep Listesi</li>
						</ul>

					</div>
				</div>
				<!-- /page header -->
				<!-- Content area -->
				<div class="content">

					<!-- ürünler -->
					<div class="panel panel-flat">
						<div class="panel-heading">
							<h5 class="panel-title"><i class="fa fa-th-list"></i> Destek Talep Listesi</h5>
							<div class="heading-elements">
								<ul class="icons-list">
			                		<li><a data-action="collapse"></a></li>
			                		<li><a data-action="reload"></a></li>
			                	</ul>
		                	</div>
						</div>

						<table id="example" class="table table-asc0 datatable-basic">
							<thead>
								<tr>
									<th>Tarih</th>
									<th>Kullanıcı</th>
									<th>Başlık</th>
									<th>Departman</th>									
									<th>Durum</th>
									<th class="text-center">İşlemler</th>
								</tr>
							</thead>
							<tbody>
<?php 
$sayfalar = $db->query("select * from destekmerkezi group by destekid");
foreach($sayfalar as $sayfa){
if($sayfa['username'] != ''){
		echo '<tr>';
			echo '<td style="width: 135px;"><span class="hidden">'.$sayfa['stamp'].'</span>'.date("d.m.y H:i",$sayfa['stamp']).'</td>';
			echo '<td>'.$sayfa['username'].'</td>';
			echo '<td>'.$sayfa['konu'].'</td>';
			echo '<td>'.$sayfa['departman'].'</td>';
if($sayfa['durum'] == 'Cevaplandı'){
	echo '<td class="text-success">'.$sayfa['durum'].'</td>';
}elseif($sayfa['durum'] == 'Bekliyor'){
	echo '<td class="text-danger">'.$sayfa['durum'].'</td>';
}elseif($sayfa['durum'] == 'Kapatıldı'){
	echo '<td class="text-primary">'.$sayfa['durum'].'</td>';
}			
			

			echo '<td class="text-center">';
			echo '<form method="POST">';
				echo '<ul class="icons-list">';
					echo '<li class="dropdown">';
						echo '<a href="#" class="dropdown-toggle" data-toggle="dropdown">';
							echo '<i class="icon-menu9"></i>';
						echo '</a>';
						echo '<ul class="dropdown-menu dropdown-menu-right">';
							echo '<li><a href="/webpanel/destekcevap.php?id='.$sayfa['destekid'].'" class="btn btn-block btn-sm btn-success"  style="border-radius:0px;">Cevapla</a>';
							echo '<li><input type="submit" class="btn btn-primary btn-sm btn-block"  value="Kapat" name="'.$sayfa['destekid'].'kapat" style="border-radius:0px;"></li>';
							echo '<li><input type="submit" class="btn btn-danger btn-sm btn-block" onclick="return sayfasil()" value="Sil" name="'.$sayfa['destekid'].'sil" style="border-radius:0px;"></li>';
						echo '</ul>';
					echo '</li>';
				echo '</ul>';
			echo '</form>';
			echo '</td>';
		echo '</tr>';
	if($_POST[''.$sayfa['destekid'].'sil']){
		$db->query("delete from destekmerkezi where (destekid = '".$sayfa['destekid']."')");
		header('Location:destekmerkezi.php');
	}
	if($_POST[''.$sayfa['destekid'].'kapat']){
		$db->query("update destekmerkezi set kapali = '1', durum = 'Kapatıldı' where (destekid = '".$sayfa['destekid']."')");
		header('Location:destekmerkezi.php');
	}
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
$('.table-asc0').dataTable({
  aaSorting: [[0, 'desc']]
});
</script>
<script>
function sayfasil() {
return	confirm("Seçtiğiniz destek talebi sistemden tamamen silinecektir, onaylıyor musunuz?");
}
</script>
</body>
</html>