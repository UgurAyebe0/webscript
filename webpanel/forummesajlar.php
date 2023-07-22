<?php 
include_once('header2.php');
$yeniurunm = '';
$anasayfam = '';
$urunlerm = '';
$yenikategorim = '';
$kategorilerm = '';
$sayfaeklem = '';
$sayfalarm = '';
$forummesajlarm = 'active';
$habereklem = '';

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
							<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Forum Yönetimi <span> - Mesaj Listesi</h4>
						</div>


					</div>

					<div class="breadcrumb-line">
						<ul class="breadcrumb">
							<li><a href="/webpanel/"><i class="icon-home2 position-left"></i> Anasayfa</a></li>
							<li class="active">Mesaj Listesi</li>
						</ul>

					</div>
				</div>
				<!-- /page header -->
				<!-- Content area -->
				<div class="content">

					<!-- ürünler -->
					<div class="panel panel-flat">
						<div class="panel-heading">
							<h5 class="panel-title"><i class="fa fa-th-list"></i> Mesaj Listesi</h5>
							<div class="heading-elements">
								<ul class="icons-list">
			                		<li><a data-action="collapse"></a></li>
			                		<li><a data-action="reload"></a></li>
			                	</ul>
		                	</div>
						</div>
						<table class="table table-asc0 datatable-basic">
							<thead>
								<tr>
									<th class="hidden">id</th>
									<th>Gönderen</th>
									<th>Kategori</th>
									<th>Konu</th>
									<!--<th>Mesaj</th>-->
									<th>Eklenme Tarihi</th>
									<th>Durum</th>
									<th class="text-center">İşlemler</th>
								</tr>
							</thead>
							<tbody>
<?php 
$sayfalar = $db->query("select * from forummesajlar order by stamp desc");
foreach($sayfalar as $sayfa){
		echo '<tr>';
			echo '<td class="hidden">'.$sayfa['id'].'</td>';
			echo '<td>'.$sayfa['username'].'</td>';
$konukontrol = $db->prepare("select * from forumkonular where (id = '".$sayfa['konuid']."')");
$result = $konukontrol->execute();
$konukontrol   = $konukontrol->fetch(PDO::FETCH_ASSOC);

$katkontrol = $db->prepare("select * from forumkategoriler where (id = '".$konukontrol['forumkategori']."')");
$result = $katkontrol->execute();
$katkontrol   = $katkontrol->fetch(PDO::FETCH_ASSOC);

$anakategori = '';
if($katkontrol['alt_id'] != '0'){
	$ana = $db->prepare("select * from forumkategoriler where (id = '".$katkontrol['alt_id']."')");
	$result = $ana->execute();
	$ana   = $ana->fetch(PDO::FETCH_ASSOC);
	
	$anakategori = $ana['kategori_TR'].' > ';
}

			echo '<td>'.$anakategori.''.$katkontrol['kategori_TR'].'</td>';
			echo '<td>'.$konukontrol['baslik'].'</td>';
			#echo '<td>'.mb_substr(strip_tags($sayfa['mesaj']),0,30,'UTF-8').'...</td>';
			
			echo '<td><span class="hidden">'.$sayfa['stamp'].'</span> '.date("d.m.Y H:i",$sayfa['stamp']).'</td>';
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
							echo '<li><input type="submit" class="btn btn-block btn-sm btn-primary" value="Düzenle" name="'.$sayfa['id'].'duzenle" style="border-radius:0px;"></li>';
							echo '<li><input type="submit" class="btn btn-success btn-sm btn-block" value="Aktif / Pasif" name="'.$sayfa['id'].'aktifpasif" style="border-radius:0px;"></li>';
							echo '<li><input type="submit" class="btn btn-danger btn-sm btn-block" onclick="return sayfasil()" value="Sil" name="'.$sayfa['id'].'sil" style="border-radius:0px;"></li>';
						echo '</ul>';
					echo '</li>';
				echo '</ul>';
			echo '</form>';
			echo '</td>';
		echo '</tr>';
	if($_POST[''.$sayfa['id'].'sil']){
		$db->query("delete from forummesajlar where (id = '".$sayfa['id']."')");
		header('Location:forummesajlar.php');
	}
	if($_POST[''.$sayfa['id'].'aktifpasif']){
		if($sayfa['yayin'] == '1'){
			$db->query("update forummesajlar set yayin = '0' where (id = '".$sayfa['id']."');");
		}else{
			$db->query("update forummesajlar set yayin = '1' where (id = '".$sayfa['id']."');");
		}
		header('Location:forummesajlar.php');
	}
	if($_POST[''.$sayfa['id'].'duzenle']){
		header('Location:forummesajduzenle.php?id='.$sayfa['id'].'');
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
  aaSorting: [[4, 'desc']]
});
</script>
<script>
function sayfasil() {
return	confirm("Seçtiğiniz mesaj sistemden silinecektir, onaylıyor musunuz?");
}
</script>
</body>
</html>