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
							<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Referanslar <span> - Referans Listesi</h4>
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
							<li class="active">Referans Listesi</li>
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
				<!-- /page header -->
				<!-- Content area -->
				<div class="content">

					<!-- ürünler -->
					<div class="panel panel-flat">
						<div class="panel-heading">
							<h5 class="panel-title"><i class="fa fa-th-list"></i> Referans Listesi</h5>
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
									<th>Başlık TR</th>
									<th>Başlık EN</th>
									<th>Durum</th>
									<th>Tarih</th>
									<th class="text-center">İşlemler</th>
								</tr>
							</thead>
							<tbody>
<?php 
$referanslar = $core->db->query("select * from referanslar");
foreach($referanslar as $ref){
		echo '<tr>';
			echo '<td><img src="../images/referanslar/'.$ref['gorsel'].'" width="60px"></td>';
			echo '<td>'.$ref['baslik'].'</td>';
			echo '<td>'.$ref['baslik_EN'].'</td>';
		if($ref['yayin'] == '1'){
			echo '<td><span class="label label-success">Aktif</span></td>';
		}else{
			echo '<td><span class="label label-danger">Pasif</span></td>';
		}
			echo '<td>'.date("d.m.Y",$ref['stamp']).'</td>';
			echo '<td class="text-center">';
			echo '<form method="POST">';
				echo '<ul class="icons-list">';
					echo '<li class="dropdown">';
						echo '<a href="#" class="dropdown-toggle" data-toggle="dropdown">';
							echo '<i class="icon-menu9"></i>';
						echo '</a>';
						echo '<ul class="dropdown-menu dropdown-menu-right">';
							echo '<li><a href="/webpanel/refduzenle.php?id='.$ref['id'].'" class="btn btn-block btn-sm btn-primary"  style="border-radius:0px;">Düzenle</a>';
							echo '<li><input type="submit" class="btn btn-success btn-sm btn-block" value="Aktif / Pasif" name="'.$ref['id'].'aktifpasif" style="border-radius:0px;"></li>';
							echo '<li><input type="submit" class="btn btn-danger btn-sm btn-block" onclick="return refsil()" value="Sil" name="'.$ref['id'].'sil" style="border-radius:0px;"></li>';
						echo '</ul>';
					echo '</li>';
				echo '</ul>';
			echo '</form>';
			echo '</td>';
		echo '</tr>';
	if($_POST[''.$ref['id'].'sil']){
		$core->db->query("delete from referanslar where (id = :id);",array('id' => $ref['id']));
		header('Location:referanslar.php');
	}
	if($_POST[''.$ref['id'].'aktifpasif']){
		if($ref['yayin'] == '1'){
			$core->db->query("update referanslar set yayin = '0' where (id = :id);",array('id' => $ref['id']));
		}else{
			$core->db->query("update referanslar set yayin = '1' where (id = :id);",array('id' => $ref['id']));
		}
		header('Location:referanslar.php');
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
function refsil() {
return	confirm("Seçtiğiniz referans sistemden silinecektir, onaylıyor musunuz?");
}
</script>
</body>
</html>