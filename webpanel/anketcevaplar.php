<?php 
include_once('header2.php');

$anketlerm = 'active';
$sayfalar = $db->query("select * from anketcevap");
?>
<script >
	
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
							<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Anketler <span> - Cevap Listesi</h4>
						</div>


					</div>

					<div class="breadcrumb-line">
						<ul class="breadcrumb">
							<li><a href="/webpanel/"><i class="icon-home2 position-left"></i> Anasayfa</a></li>
							<li class="active">Cevap Listesi</li>
						</ul>
						<div class="" style="float:right;padding-top:5px;padding-bottom:5px;">
							<a href="/webpanel/anketler.php" class="btn btn-primary btn-sm" style="margin-right:10px;"> Anketler <i class="fa fa-folder"></i></a>
							<a href="/webpanel/yenianket.php" class="btn btn-warning btn-sm" style="margin-right:10px;"> Yeni Anket <i class="fa fa-plus"></i></a>
							<a href="/webpanel/anketcevaplar.php" class="btn btn-primary btn-sm" style="margin-right:10px;"> Cevap Listesi <i class="fa fa-list-ul"></i></a>
							<a href="/webpanel/yenicevap.php" class="btn btn-primary btn-sm" style="margin-right:10px;"> Yeni Cevap <i class="fa fa-plus"></i></a>
							
						</div>

					</div>
				</div>
				<!-- /page header -->
				<!-- Content area -->
				<div class="content">

					<!-- ürünler -->
					<div class="panel panel-flat">
						<div class="panel-heading">
							<h5 class="panel-title"><i class="fa fa-th-list"></i> Cevap Listesi</h5>
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
									<th>Eklenme Tarihi</th>
									<th>Cevap</th>
									<th>Oy</th>
									<th>Anket</th>
									<th>Durum</th>
									<th class="text-center">İşlemler</th>
								</tr>
							</thead>
							<tbody>
<?php 

foreach($sayfalar as $sayfa){
$secili = $db->prepare("select * from anketsoru where (id = '".$sayfa['anketid']."')");
$result = $secili->execute();
$secili   = $secili->fetch(PDO::FETCH_ASSOC);
		echo '<tr>';
			echo '<td>'.date("d.m.Y H:i",$sayfa['stamp']).'</td>';
			echo '<td>'.$sayfa['cevap'].'</td>';
			echo '<td>'.$sayfa['oy'].'</td>';
			echo '<td>'.$secili['soru'].'</td>';
			
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
							echo '<li><a href="/webpanel/cevapduzenle.php?id='.$sayfa['id'].'" class="btn btn-block btn-sm btn-primary"  style="border-radius:0px;">Düzenle</a>';
							echo '<li><input type="submit" class="btn btn-success btn-sm btn-block" value="Aktif / Pasif" name="'.$sayfa['id'].'aktifpasif" style="border-radius:0px;"></li>';
							echo '<li><input type="submit" class="btn btn-danger btn-sm btn-block" onclick="return sayfasil()" value="Sil" name="'.$sayfa['id'].'sil" style="border-radius:0px;"></li>';
						echo '</ul>';
					echo '</li>';
				echo '</ul>';
			echo '</form>';
			echo '</td>';
		echo '</tr>';
	if($_POST[''.$sayfa['id'].'sil']){
		$db->query("delete from anketcevap where (id = '".$sayfa['id']."')");
		header('Location:anketcevaplar.php');
	}
	if($_POST[''.$sayfa['id'].'aktifpasif']){
		if($sayfa['yayin'] == '1'){
			$db->query("update anketcevap set yayin = '0' where (id = '".$sayfa['id']."')");
		}else{
			$db->query("update anketcevap set yayin = '1' where (id = '".$sayfa['id']."')");
		}
		header('Location:anketcevaplar.php');
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
return	confirm("Seçtiğiniz cevap sistemden silinecektir, onaylıyor musunuz?");
}
</script>
</body>
</html>