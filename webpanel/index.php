<?php 
include_once('header.php'); 
$yeniurunm = '';
$anasayfam = 'active';
$urunlerm = '';
$yenikategorim = '';
$kategorilerm = '';
$sayfaeklem = '';
$sayfalarm = '';
?>
<script src="https://cdn.rawgit.com/leonardosnt/mc-player-counter/1.1.0/dist/mc-player-counter.min.js"></script>

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
							<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Anasayfa</span> - Durum</h4>
						</div>

		
					</div>

					<div class="breadcrumb-line">
						<ul class="breadcrumb">
							<li><a href="index.php"><i class="icon-home2 position-left"></i> Anasayfa</a></li>
							<li class="active">Durum</li>
						</ul>

					</div>
				</div>
				<!-- /page header -->


				<!-- Content area -->
				<div class="content">

					<!-- Main charts -->
					<div class="row">
						<div class="col-lg-12">

							<!-- Traffic sources -->
							
						<!-- Quick stats boxes -->
						<?php 
						$gun = date("Y-m-d 23:59:59", time());
						$dun = date('Y-m-d 23:59:59',strtotime("-1 days"));
$makalesayisi = $kpanel->query("select * from UrunLog WHERE Tarih BETWEEN '".$dun."' AND '".$gun."' ");
$au = 0;
foreach($makalesayisi as $sayi){
	$au++;
}

$habersayisi = $db->prepare("select count(*) from makaleler");
$result = $habersayisi->execute();
$habersayisi   = $habersayisi->fetchColumn();

$desteksayisi = $db->query("select * from destekmerkezi where (durum = 'Bekliyor') && (username != '') group by destekid order by id desc");
	
$ac = 0;
foreach($desteksayisi as $sayi){
	$ac++;
}
						
						?>
							<div class="row">
								<div class="col-lg-4">
									<div class="panel bg-teal-400">
										<div class="panel-body">
											<div class="heading-elements">
												<span class="heading-text badge bg-teal-800">Ürün Satışı</span>
											</div>

											<h3 class="no-margin"><?php echo $au; ?></h3>
											Bugün Sipariş Sayısı
											<div class="text-muted text-size-small"><?php echo '<small></small>'; ?></div>
										</div>

										<div class="container-fluid">
											<div id="members-online"></div>
										</div>
									</div>
								</div>

								<div class="col-lg-4">
									<div class="panel bg-pink-400">
										<div class="panel-body">
											<div class="heading-elements">
												<span class="heading-text badge bg-pink-800">Haberler & Duyurular</span>
											</div>

											<h3 class="no-margin"><?php echo $habersayisi; ?></h3>
											Toplam Haber Sayısı
											<div class="text-muted text-size-small"><?php echo '<small></small>'; ?></div>
										</div>

										<div class="container-fluid">
											<div id="members-online"></div>
										</div>
									</div>
								</div>

								<div class="col-lg-4">
									<div class="panel bg-blue-400">
										<div class="panel-body">
											<div class="heading-elements">
												<span class="heading-text badge bg-blue-800">Destek Talepleri</span>
											</div>

											<h3 class="no-margin"><?php echo $ac; ?></h3>
											Cevap Bekleyen Sayısı
											<div class="text-muted text-size-small"><?php echo '<small></small>'; ?></div>
										</div>

										<div class="container-fluid">
											<div id="members-online"></div>
										</div>
									</div>
								</div>
							</div>
						</div>

						
					</div>
					<!-- /main charts -->

<?php 
$sonkrediler = $kpanel->query("SELECT * FROM KrediYuklemeLog ORDER BY Tarih DESC LIMIT 5");
?>
					<!-- Dashboard content -->
					<div class="row">
						<div class="col-lg-6">
							<div class="panel panel-flat">
								<div class="panel-heading">
									<h6 class="panel-title">Son Kredi Yükleyenler</h6>
									<div class="heading-elements">
										<ul class="icons-list">
					                		<li><a data-action="collapse"></a></li>
					                		<li><a data-action="reload"></a></li>
					                		<li><a data-action="close"></a></li>
					                	</ul>
				                	</div>
			                	</div>
								<div class="panel-body">
									<div class="row">
<div class="table-responsive">
	<table class="table">
		<thead>
			<tr>
				<th>#</th>
				<th>Isim</th>
				<th>Kredi</th>
				<th>Tutar</th>
				<th>Tarih</th>
				<th>Ödeme</th>
			</tr>
		</thead>
		<tbody> 
		<?php
foreach($sonkrediler as $son){
	$kullanici = $kpanel->prepare("SELECT * From Kullanicilar WHERE (KullaniciId = '".$son['KullaniciId']."')");
	$result = $kullanici->execute();
	$kullanici   = $kullanici->fetch(PDO::FETCH_ASSOC);	
	
if($son['OdemeKanali'] == '1'){
	$odemeturu = 'Mobil Ödeme';
}elseif($son['OdemeKanali'] == '2'){
	$odemeturu = 'Kredi Kartı (Gpay)';
}elseif($son['OdemeKanali'] == '3'){
	$odemeturu = 'Banka Havalesi';
}elseif($son['OdemeKanali'] == '6'){
	$odemeturu = 'Oxoyun Elektonik Kod';
}elseif($son['OdemeKanali'] == '9'){
	$odemeturu = 'Gpay E-Cüzdan';
}elseif($son['OdemeKanali'] == '11'){
	$odemeturu = 'Kredi Kartı (Wirecard)';
}elseif($son['OdemeKanali'] == '12'){
	$odemeturu = 'ininal (Gpay)';
}elseif($son['OdemeKanali'] == '13'){
	$odemeturu = 'Para';
}

	echo '<tr>';
		echo '<td>';
			echo '<div class="round-img">';
				echo '<a href=""><img src="https://minepic.org/avatar/'.$kullanici['username'].'" alt="" width="30px"></a>';
			echo '</div>';
		echo '</td>';
		echo '<td>'.$kullanici['username'].'</td>';
		echo '<td>'.$son['VerilenTutar'].'</td>';
		echo '<td><span>'.$son['OdemeTutari'].' <i class="fa fa-try"></i></span></td>';
		echo '<td>'.$son['Tarih'].'</td>';
		echo '<td class="text-left">'.$odemeturu.'</td>';
	echo '</tr>';
}			
				
		?>
			

		</tbody>
	</table>
</div>
									</div>
								</div>
							</div>
						</div>
<?php 
$sonsatilanlar = $kpanel->query("SELECT * FROM UrunLog ORDER BY Tarih DESC LIMIT 5");
?>
						<div class="col-lg-6">
							<div class="panel panel-flat">
								<div class="panel-heading">
									<h6 class="panel-title">Son Alınan Ürünler</h6>
									<div class="heading-elements">
										<ul class="icons-list">
					                		<li><a data-action="collapse"></a></li>
					                		<li><a data-action="reload"></a></li>
					                		<li><a data-action="close"></a></li>
					                	</ul>
				                	</div>
			                	</div>
								<div class="panel-body">
									<div class="row">
<div class="table-responsive">
	<table class="table">
		<thead>
			<tr>
				<th>#</th>
				<th>Isim</th>
				<th>Ürün Adı</th>
				<th>Ödenen</th>
				<th>Tarih</th>
			</tr>
		</thead>  
		<tbody>									
<?php
foreach($sonsatilanlar as $son){
	$kullanici = $kpanel->prepare("SELECT * From Kullanicilar WHERE (KullaniciId = '".$son['KullaniciId']."')");
	$result = $kullanici->execute();
	$kullanici   = $kullanici->fetch(PDO::FETCH_ASSOC);
	
	$urunid=$son['UrunId'];
	$urunisim = $kpanel->prepare("SELECT * From Urunler WHERE (UrunId = '".$urunid."')");
	$result = $urunisim->execute();
	$urunisim   = $urunisim->fetch(PDO::FETCH_ASSOC);
	echo '<tr>';
		echo '<td>';
			echo '<div class="round-img">';
				echo '<a href=""><img src="https://minepic.org/avatar/'.$kullanici['username'].'" alt="" width="30px"></a>';
			echo '</div>';
		echo '</td>';
		echo '<td>'.$kullanici['username'].'</td>';
		echo '<td>'.$urunisim['Adi'].'</td>';
		echo '<td><span>'.$son['UrunFiyati'].'</span></td>';
		echo '<td>'.$son['Tarih'].'</td>';
	echo '</tr>';
}			  
				
		?>
		</tbody>
	</table>									
</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<?php include_once('footer.php'); ?>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
