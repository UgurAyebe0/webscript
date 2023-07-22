<?php 
include_once('header2.php');
$yeniurunm = '';
$anasayfam = '';
$urunlerm = '';
$yenikategorim = '';
$kategorilerm = '';
$sayfaeklem = '';
$sayfalarm = '';
$yoneticilerm = 'active';
if($_SESSION['grup'] != 'Admin'){
	header('Location:/webpanel');
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
							<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Yönetim <span> - Yönetici Listesi</h4>
						</div>


					</div>

					<div class="breadcrumb-line">
						<ul class="breadcrumb">
							<li><a href="/webpanel/"><i class="icon-home2 position-left"></i> Anasayfa</a></li>
							<li class="active">Yönetici Listesi</li>
						</ul>


					</div>
				</div>
				<!-- /page header -->
				<!-- Content area -->
				<div class="content">

					<!-- ürünler -->
					<div class="panel panel-flat">
						<div class="panel-heading">
							<h5 class="panel-title"><i class="fa fa-th-list"></i> Yönetici Listesi</h5>
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
									<th>Adı</th>
									<th>Soyadı</th>
									<th>Telefon</th>
									<th>Email</th>
									<th>Kullanıcı Adı</th>
									<th>Grup</th>
									<th>Durum</th>
									<th class="text-center">İşlemler</th>
								</tr>
							</thead>
							<tbody>
<?php 
$yoneticiler = $db->query("select * from yoneticiler");
foreach($yoneticiler as $yonetici){
		echo '<tr>';
			echo '<td>'.$yonetici['adi'].'</td>';
			echo '<td>'.$yonetici['soyadi'].'</td>';
			echo '<td>'.$yonetici['telefon'].'</td>';
			echo '<td>'.$yonetici['email'].'</td>';
			echo '<td>'.$yonetici['kullaniciadi'].'</td>';
			echo '<td>'.$yonetici['yetki'].'</td>';
		if($yonetici['durum'] == '1'){
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
							echo '<li><a href="/webpanel/yoneticiduzenle.php?id='.$yonetici['id'].'" class="btn btn-block btn-sm btn-primary"  style="border-radius:0px;">Düzenle</a>';
							echo '<li><input type="submit" class="btn btn-success btn-sm btn-block" value="Aktif / Pasif" name="'.$yonetici['id'].'aktifpasif" style="border-radius:0px;"></li>';
							echo '<li><input type="submit" class="btn btn-danger btn-sm btn-block" onclick="return urunsil()" value="Sil" name="'.$yonetici['id'].'sil" style="border-radius:0px;"></li>';
						echo '</ul>';
					echo '</li>';
				echo '</ul>';
			echo '</form>';
			echo '</td>';
		echo '</tr>';
	if($_POST[''.$yonetici['id'].'sil']){
		$db->query("delete from yoneticiler where (id = '".$yonetici['id']."')");
		header('Location:yoneticiler.php');
	}
	if($_POST[''.$yonetici['id'].'aktifpasif']){
		if($yonetici['durum'] == '1'){
			$db->query("update yoneticiler set durum = '0' where (id = '".$yonetici['id']."')");
		}else{
			$db->query("update yoneticiler set durum = '1' where (id = '".$yonetici['id']."')");
		}
		header('Location:yoneticiler.php');
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
return	confirm("Seçtiğiniz yönetici sistemden silinecektir, onaylıyor musunuz?");
}
</script>
</body>
</html>