<?php 
require_once('../system/system.php'); 
ob_start();

if($_SESSION['yonetici'] != ''){
	header('Location: /webpanel');
}
?>
<?php 
if($_POST['girisyap']){
	$kullanicilar = $db->query("select * from yoneticiler");
	foreach($kullanicilar as $kullanici){
		if($kullanici['kullaniciadi'] == $_POST['kullaniciadi'] and $kullanici['parola'] == $_POST['parola']){
			$_SESSION['yonetici'] = $kullanici['kullaniciadi'];
			if($kullanici['yetki'] == 'Admin'){
				$_SESSION['grup'] = 'Admin';
			}else{
				$_SESSION['grup'] = 'Editor';
			}
		}
	}
	if($_SESSION['yonetici'] != ''){
		
		header('Refresh:0');
	}else{
		echo '<script>alert(\'Hatalı bilgiler, Lütfen tekrar deneyiniz\')</script>';
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Camdy Craft Yönetim Paneli</title>

	<!-- Global stylesheets -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
	<link href="assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
	<link href="assets/css/bootstrap.css" rel="stylesheet" type="text/css">
	<link href="assets/css/core.css" rel="stylesheet" type="text/css">
	<link href="assets/css/components.css" rel="stylesheet" type="text/css">
	<link href="assets/css/colors.css" rel="stylesheet" type="text/css">
	<!-- /global stylesheets -->

	<!-- Core JS files -->
	<script type="text/javascript" src="assets/js/plugins/loaders/pace.min.js"></script>
	<script type="text/javascript" src="assets/js/core/libraries/jquery.min.js"></script>
	<script type="text/javascript" src="assets/js/core/libraries/bootstrap.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/loaders/blockui.min.js"></script>
	<!-- /core JS files -->


	<!-- Theme JS files -->
	<script type="text/javascript" src="assets/js/core/app.js"></script>
	<!-- /theme JS files -->

</head>

<body class="login-container">

	<!-- Main navbar -->
	<div class="navbar navbar-inverse">
		<div class="navbar-header">
			<a class="navbar-brand" href="index.html">Yönetim Paneli</a>

			<ul class="nav navbar-nav pull-right visible-xs-block">
				<li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-tree5"></i></a></li>
			</ul>
		</div>

		<div class="navbar-collapse collapse" id="navbar-mobile">
			<ul class="nav navbar-nav navbar-right">
				<li>
					<a href="/">
						<i class="icon-display4"></i> <span class="visible-xs-inline-block position-right"> Siteye Git</span>
					</a>
				</li>

				<li>
					<a href="#">
						<i class="icon-user-tie"></i> <span class="visible-xs-inline-block position-right"> Yöneticiye mesaj gönder</span>
					</a>
				</li>

				
			</ul>
		</div>
	</div>
	<!-- /main navbar -->


	<!-- Page container -->
	<div class="page-container">

		<!-- Page content -->
		<div class="page-content">

			<!-- Main content -->
			<div class="content-wrapper">

				<!-- Content area -->
				<div class="content">

					<!-- Simple login form -->
					<form method="POST">
						<div class="panel panel-body login-form">
							<div class="text-center">
								<div class="icon-object border-slate-300 text-slate-300"><i class="icon-reading"></i></div>
								<h5 class="content-group">Yönetim Paneline Giriş <small class="display-block">Bilgilerinizi Giriniz</small></h5>
							</div>

							<div class="form-group has-feedback has-feedback-left">
								<input type="text" class="form-control" name="kullaniciadi" placeholder="Kullanıcı Adı" required>
								<div class="form-control-feedback">
									<i class="icon-user text-muted"></i>
								</div>
							</div>

							<div class="form-group has-feedback has-feedback-left">
								<input type="password" class="form-control" name="parola" placeholder="Parola" required>
								<div class="form-control-feedback">
									<i class="icon-lock2 text-muted"></i>
								</div>
							</div>

							<div class="form-group">
								<input type="submit" class="btn btn-primary btn-block" value="Giriş" name="girisyap">
							</div>

							<div class="text-center">
								<a href="#">Parolamı Unuttum?</a>
							</div>
						</div>
					</form>
					<!-- /simple login form -->


					<!-- Footer -->
					<div class="footer text-muted text-center">
						&copy; 2021 <a href="http://www.candycraft.net" target="_blank">CC-Network</a>
					</div>
					<!-- /footer -->

				</div>
				<!-- /content area -->

			</div>
			<!-- /main content -->

		</div>
		<!-- /page content -->

	</div>
	<!-- /page container -->

</body>
</html>
