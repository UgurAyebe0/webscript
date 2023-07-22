<?php 
include_once('header2.php');
$yeniurunm = '';
$anasayfam = '';
$urunlerm = '';
$yenikategorim = '';
$kategorilerm = '';
$sayfaeklem = '';
$sayfalarm = '';
$kullanicilarm = 'active';
$habereklem = '';

$kullanici = $kpanel->prepare("select * from Kullanicilar where (KullaniciId = '".$_REQUEST['id']."')");
$result = $kullanici->execute();
$kullanici   = $kullanici->fetch(PDO::FETCH_ASSOC);

$grup = $yetkiler->prepare("select * from perm_playergroups where (playeruuid = '".$kullanici["uuid"]."') && (groupid != '16') && (groupid != '17') && (groupid != '18')  order by groupid desc");
$result = $grup->execute();
$grup  = $grup->fetch(PDO::FETCH_ASSOC);

$grupadi = $yetkiler->prepare("select * from perm_groups where (id = '".$grup['groupid']."')");
$result = $grupadi->execute();
$grupadi  = $grupadi->fetch(PDO::FETCH_ASSOC);
if($grupadi['name'] == NULL){$grupadi['name'] = 'Oyuncu';}
if($grupadi['id'] == '6' or $grupadi['id'] == NULL){
	$renk = '#5555FF';

}elseif($grupadi['id'] == '15'){
	$renk = '#AA0000';
}elseif($grupadi['id'] == '7'){
	$renk = '#55FFFF';
}elseif($grupadi['id'] == '8'){
	$renk = '#00AAAA';
}elseif($grupadi['id'] == '9'){
	$renk = '#00AA00';
}elseif($grupadi['id'] == '10'){
	$renk = '#AA00AA';
}elseif($grupadi['id'] == '11'){
	$renk = '#55FF55';
}elseif($grupadi['id'] == '12'){
	$renk = '#FF55FF';
}elseif($grupadi['id'] == '13'){
	$renk = '#FFAA00';
}elseif($grupadi['id'] == '14'){
	$renk = '#AA0000';
}

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
							<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Kullanıcı Yönetimi <span> - Satınalma Geçmişi</h4>
						</div>


					</div>

					<div class="breadcrumb-line">
						<ul class="breadcrumb">
							<li><a href="/webpanel/"><i class="icon-home2 position-left"></i> Anasayfa</a></li>
							<li class="active">Kullanıcı Yönetimi</li>
						</ul>
						<div class="" style="float:right;padding-top:5px;padding-bottom:5px;">
							<a href="/webpanel/kullanicidetay.php?id=<?php echo $kullanici['KullaniciId']; ?>" class="btn btn-primary btn-sm" style="margin-right:10px;"> Genel Yönetim </a>
							<a href="/webpanel/kullanicisatislar.php?id=<?php echo $kullanici['KullaniciId']; ?>" class="btn btn-primary btn-sm" style="margin-right:10px;"> Satınalma Geçmişi </a>
							<a href="/webpanel/kullaniciyuklemeler.php?id=<?php echo $kullanici['KullaniciId']; ?>" class="btn btn-primary btn-sm" style="margin-right:10px;"> Kredi Geçmişi </a>
						</div>
					</div>
				</div>
				<!-- /page header -->
				<!-- Content area -->
				<div class="content">

					<!-- ürünler -->
					<div class="panel panel-flat">
						<div class="panel-heading">
							<span class="panel-title"> 
							<?php								
	echo '<a href="'.$domain.'profile.php?p='.$kullanici['username'].'" style="text-decoration:none;text-transform: none;" target="_blank"> <img alt="" src="https://minepic.org/avatar/'.$kullanici['username'].'" height="15" width="15" style="margin-right: 5px;margin-top: 0px;"> '.$kullanici['username'].'</a>';
	echo '<span class="label" style="font-size:12px;vertical-align:middle;position: absolute;margin-top: -3px;margin-left: 5px;background:'.$renk.';transform: skew(-7deg);border-radius:0px;">'.$grupadi['name'].'</span>';
	?></span>
							<div class="heading-elements">
								<ul class="icons-list">
			                		<li><a data-action="collapse"></a></li>
			                		<li><a data-action="reload"></a></li>
			                	</ul>
		                	</div>
						</div>
						<table id="example" class="table table-asc0 datatable-basic ">
							<thead>
								<tr>
									<th class="hidden"></th>
									<th>Tarih</th>
									<th>Kullanıcı</th>
									<th>Ürün</th>
									<th>Fiyat</th>
									
									<th>Geçerli Yer</th>
									
								</tr>
							</thead>
							<tbody>
<?php 
$sayfalar = $kpanel->query("select * from UrunLog where (KullaniciId = '".$kullanici['KullaniciId']."') order by UrunLogId desc");
foreach($sayfalar as $sayfa){ 
		echo '<tr>';


$urunbilgi = $kpanel->prepare("select * from Urunler where (UrunId = '".$sayfa['UrunId']."')");
$result = $urunbilgi->execute();
$urunbilgi   = $urunbilgi->fetch(PDO::FETCH_ASSOC);

			echo '<td><span class="hidden">'.strtotime($sayfa['Tarih']).'</span>'.date("d.m.Y H:i",strtotime($sayfa['Tarih'])).'</td>';
			echo '<td class="hidden">'.$sayfa['UrunLogId'].'</td>';
			echo '<td>'.$kullanici['username'].'</td>';
			echo '<td>'.$urunbilgi['Adi'].'</td>';
			echo '<td>'.$sayfa['UrunFiyati'].'</td>';
			
			
			
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
  aaSorting: [[0, 'desc']]
});
</script>
</body>
</html>