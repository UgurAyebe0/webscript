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
$tekliflerm = 'active';
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
							<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Teklifler <span> - Teklif İstekleri</h4>
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
							<li class="active">Teklif İstekleri</li>
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
							<h5 class="panel-title"><i class="fa fa-th-list"></i> Teklif İstekleri</h5>
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
									<th>Tarih</th>
									<th>Adı Soyadı</th>
									<th>Firma Ünvanı</th>
									<th>Firma Adresi</th>
									<th>Telefon</th>
									<th>Email</th>
									<th>Talep</th>
									<th>Durum</th>
									<th class="text-center">İşlemler</th>
								</tr>
							</thead>
							<tbody>
<?php 
$mesajlar = $core->db->query("select * from teklifformu order by stamp desc");
foreach($mesajlar as $mesaj){
		echo '<tr>';
			echo '<td><span class="hide">'.$mesaj['stamp'].'</span>'.date("d.m.Y H:i", $mesaj['stamp']).'</td>';
			echo '<td>'.$mesaj['adsoyad'].'</td>';
			echo '<td>'.$mesaj['firmaunvani'].'</td>';
			echo '<td>'.$mesaj['firmaadresi'].'</td>';
			echo '<td>'.$mesaj['firmatelefonu'].'</td>';
			echo '<td>'.$mesaj['firmaemail'].'</td>';
			echo '<td>'.$mesaj['talebiniz'].'</td>';
		if($mesaj['yayin'] == '1'){
			echo '<td><span class="label label-success">Arandı</span></td>';
		}else{
			echo '<td><span class="label label-danger">Aranmadı</span></td>';
		}
			echo '<td class="text-center">';
			echo '<form method="POST">';
				echo '<ul class="icons-list">';
					echo '<li class="dropdown">';
						echo '<a href="#" class="dropdown-toggle" data-toggle="dropdown">';
							echo '<i class="icon-menu9"></i>';
						echo '</a>';
						echo '<ul class="dropdown-menu dropdown-menu-right">';
							echo '<li><input type="submit" class="btn btn-success btn-sm btn-block" value="Arandı / Aranmadı" name="'.$mesaj['id'].'aktifpasif" style="border-radius:0px;"></li>';
							echo '<li><input type="submit" class="btn btn-danger btn-sm btn-block" onclick="return sayfasil()" value="Mesajı Sil" name="'.$mesaj['id'].'sil" style="border-radius:0px;"></li>';
						echo '</ul>';
					echo '</li>';
				echo '</ul>';
			echo '</form>';
			echo '</td>';
		echo '</tr>';
	if($_POST[''.$mesaj['id'].'sil']){
		$core->db->query("delete from teklifformu where (id = :id);",array('id' => $mesaj['id']));
		header('Location:teklifler.php');
	}
	if($_POST[''.$mesaj['id'].'aktifpasif']){
		if($mesaj['yayin'] == '1'){
			$core->db->query("update teklifformu set yayin = '0' where (id = :id);",array('id' => $mesaj['id']));
		}else{
			$core->db->query("update teklifformu set yayin = '1' where (id = :id);",array('id' => $mesaj['id']));
		}
		header('Location:teklifler.php');
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
return	confirm("Seçtiğiniz teklif isteği sistemden silinecektir, onaylıyor musunuz?");
}
</script>
</body>
</html>