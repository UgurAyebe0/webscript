<?php 
include_once('header2.php');
$yeniurunm = '';
$anasayfam = '';
$urunlerm = '';
$yenikategorim = '';
$kategorilerm = '';
$sayfaeklem = '';
$sayfalarm = '';
$krediyuklemem = 'active';
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
							<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Krediler <span> - Yükleme Listesi</h4>
						</div>


					</div>

					<div class="breadcrumb-line">
						<ul class="breadcrumb">
							<li><a href="/webpanel/"><i class="icon-home2 position-left"></i> Anasayfa</a></li>
							<li class="active">Yükleme Listesi</li>
						</ul>

					</div>
				</div>
				<!-- /page header -->
				<!-- Content area -->
				<div class="content">

					<!-- ürünler -->
					<div class="panel panel-flat">
						<div class="panel-heading">
							<h5 class="panel-title"><i class="fa fa-th-list"></i> Yükleme Listesi</h5>
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
									<th style="width:20%;">Kullanıcı</th>
													
									
									<th style="width:20%;">Ödenen</th>
									<th style="width:20%;">Kredi</th>
									<th style="width:20%;">Tarih</th>
									<th style="width:20%;">Ödeme Kanalı</th>
								</tr>
							</thead>
							<tbody>
<?php 
$sayfalar = $kpanel->query("select * from KrediYuklemeLog ");
foreach($sayfalar as $sayfa){ 
if($sayfa['OdemeKanali'] == '1'){
	$odemekanali = 'Mobil Ödeme';
}elseif($sayfa['OdemeKanali'] == '2'){
	$odemekanali = 'Kredi Kartı (Gpay)';
}elseif($sayfa['OdemeKanali'] == '3'){
	$odemekanali = 'Banka Havalesi';
}elseif($sayfa['OdemeKanali'] == '6'){
	$odemekanali = 'Oxoyun Elektonik Kod';
}elseif($sayfa['OdemeKanali'] == '9'){
	$odemekanali = 'Gpay E-Cüzdan';
}elseif($sayfa['OdemeKanali'] == '11'){
	$odemekanali = 'Kredi Kartı (Wirecard)';
}elseif($sayfa['OdemeKanali'] == '12'){
	$odemekanali = 'ininal (Gpay)';
}
		echo '<tr>';
$userbilgi = $kpanel->prepare("select * from Kullanicilar where (KullaniciId = '".$sayfa['KullaniciId']."')");
$result = $userbilgi->execute();
$userbilgi   = $userbilgi->fetch(PDO::FETCH_ASSOC);




			echo '<td class="hidden">'.$sayfa['KrediLogId'].'</td>';
			
			echo '<td>'.$userbilgi['username'].'</td>';
	
			
			echo '<td>'.$sayfa['OdemeTutari'].'</td>';
			echo '<td>'.$sayfa['VerilenTutar'].'</td>';
			echo '<td><span class="hidden">'.strtotime($sayfa['Tarih']).'</span>'.date("d.m.Y H:i",strtotime($sayfa['Tarih'])).'</td>';
			echo '<td>'.$odemekanali.' </td>';
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