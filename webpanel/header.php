<?php 
require_once('../system/system.php'); 
ob_start();
if($_SESSION['yonetici'] == ''){
	header('Location:login.php');
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Candy Craft Admin Paneli</title>

	<!-- Global stylesheets -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
	<link href="assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
	<link href="assets/css/bootstrap.css" rel="stylesheet" type="text/css">
	<link href="assets/css/core.css" rel="stylesheet" type="text/css">
	<link href="assets/css/components.css" rel="stylesheet" type="text/css">
	<link href="assets/css/colors.css" rel="stylesheet" type="text/css">
	<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	

	<!-- /global stylesheets -->

	<!-- Core JS files -->
	<script type="text/javascript" src="assets/js/plugins/loaders/pace.min.js"></script>
	<script type="text/javascript" src="assets/js/core/libraries/jquery.min.js"></script>
	<script type="text/javascript" src="assets/js/core/libraries/bootstrap.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/loaders/blockui.min.js"></script>
	<!-- /core JS files -->
	<!-- Theme JS files -->
	<script type="text/javascript" src="assets/js/plugins/visualization/d3/d3.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/visualization/d3/d3_tooltip.js"></script>
	<script type="text/javascript" src="assets/js/plugins/forms/styling/switchery.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/forms/styling/uniform.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/forms/selects/bootstrap_multiselect.js"></script>
	<script type="text/javascript" src="assets/js/plugins/ui/moment/moment.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/pickers/daterangepicker.js"></script>
	<script type="text/javascript" src="assets/js/core/app.js"></script>
	<script type="text/javascript" src="assets/js/pages/dashboard.js"></script>
	<!-- /theme JS files -->
</head>
<body>
	<!-- Main navbar -->
	<div class="navbar navbar-inverse">
		<div class="navbar-header">
			<a class="navbar-brand" href="index.php">Yönetim Paneli</a>
			<ul class="nav navbar-nav visible-xs-block">
				<li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-tree5"></i></a></li>
				<li><a class="sidebar-mobile-main-toggle"><i class="icon-paragraph-justify3"></i></a></li>
			</ul>
		</div>
		<div class="navbar-collapse collapse" id="navbar-mobile">
			<p class="navbar-text"><span class="label bg-success">Online</span></p>
			<ul class="nav navbar-nav navbar-right">
				<li class="dropdown language-switch">
					<a class="dropdown-toggle" data-toggle="dropdown">
						<img src="assets/images/flags/tr.png" class="position-left" alt="">
						Türkçe
					</a>
				</li>
<?php #$okunmayanlarsayi = $db->single("select count(*) from mesajlar where (durum = '0')");?>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<i class="icon-bubbles4"></i>
						<span class="visible-xs-inline-block position-right">Mesajlar</span>
						<span class="badge bg-warning-400">0</span>
					</a>
					
					<div class="dropdown-menu dropdown-content width-350">
						<div class="dropdown-content-heading">
							Okunmayan Mesajlar
							<ul class="icons-list">
								<li><a href="/webpanel/mesajlar.php"><i class="icon-compose"></i></a></li>
							</ul>
						</div>

						<ul class="media-list dropdown-content-body"><?php #$okunmayanlar = $core->db->query("select * from mesajlar where (durum = '0')");foreach($okunmayanlar as $okunmayan){		echo '<li class="media">';			echo '<div class="media-body">';				echo '<a href="/webpanel/mesajlar.php" class="media-heading">';					echo '<span class="text-semibold">'.$okunmayan['adsoyad'].'</span>';					echo '<span class="media-annotation pull-right">'.date("d.m.Y H:i",$okunmayan['stamp']).'</span>';				echo '</a>';				echo '<span class="text-muted">'.mb_substr($okunmayan['mesaj'], 0, 30, 'UTF-8').'...</span>';			echo '</div>';		echo '</li>';}?>
							

						</ul>

						<div class="dropdown-content-footer">
							<a href="#" data-popup="tooltip" title="All messages"><i class="icon-menu display-block"></i></a>
						</div>
					</div>
				</li>

				<li class="dropdown dropdown-user">
					<a class="dropdown-toggle" data-toggle="dropdown">
						<img src="assets/images/placeholder.jpg" alt="">
						<span><?php echo $_SESSION['yonetici']; ?></span>
						<i class="caret"></i>
					</a>

					<ul class="dropdown-menu dropdown-menu-right">
					<?php if($_SESSION['grup'] == 'Admin'){ ?>
						<li><a href="/webpanel/yoneticiler.php"><i class="icon-user-plus"></i> Profil</a></li>
					<?php } ?>
						<li class="divider"></li>
						<li><a href="/webpanel/logout.php"><i class="icon-switch2"></i> Çıkış</a></li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
	<!-- /main navbar -->