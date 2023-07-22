<?php 
include_once('header2.php');

$kullanicilarm = 'active';
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
							<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Kullanıcılar <span> - Kullanıcı Listesi</h4>
						</div>


					</div>

					<div class="breadcrumb-line">
						<ul class="breadcrumb">
							<li><a href="/webpanel/"><i class="icon-home2 position-left"></i> Anasayfa</a></li>
							
						</ul>


					</div>
				</div>
				<!-- /page header -->
				<!-- Content area -->
				<div class="content">

					<!-- ürünler -->
					<div class="panel panel-flat">
						<div class="panel-heading">
							<h5 class="panel-title"><i class="fa fa-th-list"></i> "<?php echo $_REQUEST['sonuc']; ?>" Kullanıcı Listesi</h5>
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
									<th>Kullanıcı Adı</th>
									<th class="text-center">İşlemler</th>
								</tr>
							</thead>
							<tbody>
<?php 
$kullanicilar = $kpanel->query("select * from Kullanicilar where (username like '%".$_REQUEST['sonuc']."%')");
foreach($kullanicilar as $user){
		echo '<tr>';
			echo '<td>'.$user['username'].'</td>';

			echo '<td class="text-center">';

				echo '<ul class="icons-list">';
					echo '<li class="dropdown">';
						echo '<a href="#" class="dropdown-toggle" data-toggle="dropdown">';
							echo '<i class="icon-menu9"></i>';
						echo '</a>';
						echo '<ul class="dropdown-menu dropdown-menu-right">';
							echo '<li><a href="/webpanel/kullanicidetay.php?id='.$user['KullaniciId'].'" class="btn btn-block btn-sm btn-primary"  style="border-radius:0px;">Detay</a>';
						echo '</ul>';
					echo '</li>';
				echo '</ul>';
			echo '</td>';
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
function sayfasil() {
return	confirm("Seçtiğiniz soru sistemden silinecektir, onaylıyor musunuz?");
}
</script>
</body>
</html>