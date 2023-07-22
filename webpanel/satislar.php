<?php 
include_once('header2.php');
$yeniurunm = '';
$anasayfam = '';
$urunlerm = '';
$yenikategorim = '';
$kategorilerm = '';
$sayfaeklem = '';
$sayfalarm = '';
$satislarm = 'active';
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
							<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Satışlar <span> - Satış Listesi</h4>
						</div>


					</div>

					<div class="breadcrumb-line">
						<ul class="breadcrumb">
							<li><a href="/webpanel/"><i class="icon-home2 position-left"></i> Anasayfa</a></li>
							<li class="active">Satış Listesi</li>
						</ul>

					</div>
				</div>
				<!-- /page header -->
				<!-- Content area -->
				<div class="content">

					<!-- ürünler -->
					<div class="panel panel-flat">
						<div class="panel-heading">
							<h5 class="panel-title"><i class="fa fa-th-list"></i> Satış Listesi</h5>
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
									<th class="hidden"></th>
									<th>Kullanıcı</th>
									<th>Ürün</th>
									<th>Fiyat</th>
									<th>Tarih</th>
									<th>Geçerli Yer</th>
									
								</tr>
							</thead>
							<tbody>
<?php 
$sayfalar = $kpanel->query("select * from UrunLog order by UrunLogId desc");
foreach($sayfalar as $sayfa){ 
		echo '<tr>';
$userbilgi = $kpanel->prepare("select * from Kullanicilar where (KullaniciId = '".$sayfa['KullaniciId']."')");
$result = $userbilgi->execute();
$userbilgi   = $userbilgi->fetch(PDO::FETCH_ASSOC);

$urunbilgi = $kpanel->prepare("select * from Urunler where (UrunId = '".$sayfa['UrunId']."')");
$result = $urunbilgi->execute();
$urunbilgi   = $urunbilgi->fetch(PDO::FETCH_ASSOC);
			echo '<td class="hidden">'.$sayfa['UrunLogId'].'</td>';
			echo '<td>'.$userbilgi['username'].'</td>';
			echo '<td>'.$urunbilgi['Adi'].'</td>';
			echo '<td>'.$sayfa['UrunFiyati'].'</td>';
			
			
			echo '<td><span class="hidden">'.strtotime($sayfa['Tarih']).'</span>'.date("d.m.Y H:i",strtotime($sayfa['Tarih'])).'</td>';
			echo '<td>'.$urunbilgi['GecerliYerler'].'</td>';

		echo '</tr>';
	
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
</body>
</html>