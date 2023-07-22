<?php 
include_once('header2.php');
$yeniurunm = '';
$anasayfam = '';
$oyunlarmm = 'active';
$yenikategorim = '';
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
							<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Oyunlar <span> - Yorum Listesi</h4>
						</div>

						
					</div>

					<div class="breadcrumb-line">
						<ul class="breadcrumb">
							<li><a href="/webpanel/"><i class="icon-home2 position-left"></i> Anasayfa</a></li>
							<li class="active">Yorum Listesi</li>
						</ul>

					</div>
				</div>
				<!-- /page header -->
				<!-- Content area -->
				<div class="content">

					<!-- ürünler -->
					<div class="panel panel-flat">
						<div class="panel-heading">
							<h5 class="panel-title"><i class="fa fa-th-list"></i> Yorum Listesi</h5>
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
									<th>Oyun Başlık</th>
									<th>username</th>
									<th>Yorum</th>
									<th>Tarih</th>
									<th>Durum</th>
									<th class="text-center">İşlemler</th>
								</tr>
							</thead>
							<tbody>
<?php 
$urunler = $db->query("select * from oyunyorum order by stamp desc");
foreach($urunler as $urun){
	$secilioyun = $db->prepare("select * from oyunlar where (id = '".$urun['haber']."')");
	$result = $secilioyun->execute();
	$secilioyun   = $secilioyun->fetch(PDO::FETCH_ASSOC);
	
	
		echo '<tr>';
			echo '<td>'.$secilioyun['baslik'].'</td>';
			echo '<td>'.$urun['username'].'</td>';
			echo '<td>'.$urun['yorum'].'</td>';
			echo '<td>'.date("d.m.Y H:i",$urun['stamp']).'</td>';
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
							echo '<li><input type="submit" class="btn btn-success btn-sm btn-block" value="Aktif / Pasif" name="'.$urun['id'].'aktifpasif" style="border-radius:0px;"></li>';
							echo '<li><input type="submit" class="btn btn-danger btn-sm btn-block" onclick="return urunsil()" value="Sil" name="'.$urun['id'].'sil" style="border-radius:0px;"></li>';
						echo '</ul>';
					echo '</li>';
				echo '</ul>';
			echo '</form>';
			echo '</td>';
		echo '</tr>';
	if($_POST[''.$urun['id'].'sil']){
		$db->query("delete from oyunyorum where (id = '".$urun['id']."')");
		header('Location:oyunyorum.php');
	}
	if($_POST[''.$urun['id'].'aktifpasif']){
		if($urun['yayin'] == '1'){
			$db->query("update oyunyorum set yayin = '0' where (id = '".$urun['id']."')");
		}else{
			$db->query("update oyunyorum set yayin = '1' where (id = '".$urun['id']."')");
		}
		header('Location:oyunyorum.php');
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
return	confirm("Seçtiğiniz yorum sistemden silinecektir, onaylıyor musunuz?");
}
</script>
</body>
</html>