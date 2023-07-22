
<head> 
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Candy Craft</title>

    <meta name="description" content="Candy Craft">
    <meta name="keywords" content="Candy Craft">
    <meta name="author" content="İhsan CUNEDİOĞLU">

    <link rel="icon" type="image/png" href="assets/images/dark/icon.png">

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- START: Styles -->

    <!-- Google Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:300,400,700">

    <!-- Bootstrap -->
    <link rel="stylesheet" href="http://kullanici.candycraft.net/ozan/assets/vendor/bootstrap/dist/css/bootstrap.min.css" />

    <!-- Flickity -->
    <link rel="stylesheet" href="http://kullanici.candycraft.net/ozan/assets/vendor/flickity/dist/flickity.min.css" />

    <!-- Magnific Popup -->
    <link rel="stylesheet" href="http://kullanici.candycraft.net/ozan/assets/vendor/magnific-popup/dist/magnific-popup.css" />

    <!-- Revolution Slider -->
    <link rel="stylesheet" href="http://kullanici.candycraft.net/ozan/assets/vendor/slider-revolution/css/settings.css">
    <link rel="stylesheet" href="http://kullanici.candycraft.net/ozan/assets/vendor/slider-revolution/css/layers.css">
    <link rel="stylesheet" href="http://kullanici.candycraft.net/ozan/assets/vendor/slider-revolution/css/navigation.css">

    <!-- Bootstrap Sweetalert -->
    <link rel="stylesheet" href="http://kullanici.candycraft.net/ozan/assets/vendor/bootstrap-sweetalert/dist/sweetalert.css" />

    <!-- Social Likes -->
    <link rel="stylesheet" href="http://kullanici.candycraft.net/ozan/assets/vendor/social-likes/dist/social-likes_flat.css" />

    <!-- FontAwesome -->
    <script defer src="http://kullanici.candycraft.net/ozan/assets/vendor/font-awesome/svg-with-js/js/fontawesome-all.min.js"></script>
    <script defer src="http://kullanici.candycraft.net/ozan/assets/vendor/font-awesome/svg-with-js/js/fa-v4-shims.min.js"></script>

    <!-- Youplay -->
    <link rel="stylesheet" href="http://kullanici.candycraft.net/ozan/assets/css/youplay.css">

    <!-- RTL (uncomment this to enable RTL support) -->
    <!-- <link rel="stylesheet" href="assets/css/youplay-rtl.min.css" /> -->

    <!-- Custom Styles -->
    <link rel="stylesheet" href="http://kullanici.candycraft.net/ozan/assets/css/custom.css">
    
    <!-- END: Styles -->

    <!-- jQuery -->
    <script src="http://kullanici.candycraft.net/ozan/assets/vendor/jquery/dist/jquery.min.js"></script>
     
</head>
<?php 
    $sitekullaniciadi = $_SESSION["sitekullaniciadi"];
$ugetir = mysql_fetch_array(mysql_query("SELECT * FROM Kullanicilar WHERE username='$sitekullaniciadi'",$baglan));
$KrediKrediKrediKredi=$ugetir["Kredi"];
?>