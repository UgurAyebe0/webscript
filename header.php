<?php
include_once('system/system.php'); 
ob_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'Exception.php';
require 'PHPMailer.php';
require 'SMTP.php';
date_default_timezone_set('Europe/Istanbul');
function piril($veri) {
  
 $veri=str_replace("/","",$veri);
 $veri=str_replace("&","",$veri);
 $veri=str_replace("=","",$veri);
 $veri=str_replace("<","",$veri);
 $veri=str_replace(">","",$veri);
 $veri=str_replace("!","",$veri);
 $veri=str_replace("\\","",$veri);
 $veri=str_replace("*","",$veri);
 $veri=str_replace("#","",$veri);
 $veri=str_replace("\'","",$veri);
 $veri=str_replace("?","",$veri);
 $veri=str_replace(";","",$veri);
 $veri=str_replace("\"","",$veri);
 $veri=str_replace("\'","",$veri);
 return ($veri);
}

$ipadresi = '';
$kadiniz = $_SESSION['username'];
$ipadresi = GetIP();
#echo $ipadresi.'<br>';  
$sorguu = $kpanel->prepare("SELECT * FROM GirisLog WHERE (KullaniciAdi = '".$kadiniz."') && (IpAdresi = '".$ipadresi."') && (Durum = 'Başarılı') order by GirisLogId desc");
$resultt = $sorguu->execute();
$sonucc   = $sorguu->fetch(PDO::FETCH_ASSOC);

if($sonucc['KullaniciAdi'] == ''){
	unset($_SESSION['username']);
	#session_destroy();

} 

#echo '<p>'.print_r($_SESSION).'</p>';
if(isset($_SESSION['hata'])){ 

echo '<div id="hata" class="modal show">';
  echo '<div class="modal-dialog">';
    echo '<div class="modal-content">';
	
      echo '<div class="modal-header">';
        echo '<button type="button" class="close" onclick="window.location.href = \'http://www.candycraft.net/\'">&times;</button>';
        echo '<h4 class="modal-title">Bilgilendirme</h4>';
      echo '</div>';
	  
      echo '<div class="modal-body">';
        echo '<p>'.$_SESSION['hata'].'</p>';
      echo '</div>';
	  
      echo '<div class="modal-footer">';
        echo '<button id="kapatbunu" type="button" class="btn btn-default"  onclick="window.location.href = \'http://www.candycraft.net/\'" >Tamam</button>';
      echo '</div>';
	  
    echo '</div>';
  echo '</div>';
echo '</div>';

unset($_SESSION['hata']);

echo '';
}
unset($_SESSION['hata']);
echo '
<style>
@media screen and (max-width:700px){
.gizle{
	display:none;
}}
.pad0{
	padding-right: 0px !important;
	padding-left: 0px !important;
}
.main-menu .main-menu-item-link {
    padding: 0 25px !important;
}
</style>

';
$kadi = '';
$kod = '';
if(isset($_POST['kullaniciadii'])){

	$ip_adresi = GetIP();
	$kadi=piril($_POST['kullaniciadii']);
	$sifre=$_POST['parola'];
	$kod=piril($_POST['kod']);
		
	if ($kod != $_SESSION['dogrulamakodu'] ){
		$_SESSION['hata'] = 'Doğrulama kodunu hatalı girdiniz';
		header('Location:'.$domain.'');
	}
	elseif ($kadi==null OR $sifre==null OR $kod==null)
	{
		$_SESSION['hata'] = 'Lütfen boş alan bırakmayınız';
	}

	else if (strlen($kadi)<3 OR strlen($kadi)>16)
	{
		$kpanel->query("INSERT INTO GirisLog (IpAdresi,KullaniciAdi) VALUES ('$ip_adresi','$kadi')");

		$_SESSION['hata'] = 'Kullanıcı adınız veya şifreniz yanlış';
		header('Location:'.$domain.'');			
	}
	else if (strlen($sifre)<6 OR strlen($sifre)>18)
	{
		$kaydet = $kpanel->query("INSERT INTO GirisLog (IpAdresi,KullaniciAdi) VALUES ('$ip_adresi','$kadi')");		
		$kaydet->execute();
		$_SESSION['hata'] = 'Kullanıcı adınız veya şifreniz yanlış';		
		header('Location:'.$domain.'');
	}
	else {
		$sifrehash=SifreleSite($sifre);
		$sorgu = $kpanel->prepare("SELECT * FROM Kullanicilar WHERE username = '$kadi' AND passwordsite = '$sifrehash' ");
		$result = $sorgu->execute();
		$sonuc   = $sorgu->fetch(PDO::FETCH_ASSOC);
		

		if($sonuc['username'] == $kadi and $_SESSION['dogrulamakodu'] == $kod){
			$kaydett = $kpanel->query("INSERT INTO GirisLog (IpAdresi,KullaniciAdi,Durum) VALUES ('$ip_adresi','$kadi','Başarılı')");			
			$kaydett->execute();
			$kid = $kpanel->prepare("SELECT * From Kullanicilar WHERE username = :username");
			$result = $kid->execute(array(":username" => $kadi));
			$kid   = $kid->fetch(PDO::FETCH_ASSOC);
			$_SESSION["login"] = "true";
			$_SESSION["kid"] = $kid['KullaniciId'];
			$_SESSION["uuid"] = $kid['uuid'];
			$_SESSION["username"] = $kid['username'];
			header('Location:'.$domain.'');
		}
		else {
			$kaydettt = $kpanel->query("INSERT INTO GirisLog (IpAdresi,KullaniciAdi) VALUES ('$ip_adresi','$kadi')");
			$kaydettt->execute();
			$_SESSION['hata'] = 'Kullanıcı adınız veya şifreniz yanlış';
			header('Location:'.$domain.'');
		}
	}
}



if($_POST['kayitol']){
		
	
	$ip_adresi = GetIP();
	
	$kadi = piril($_POST['kadi']);
	$email = piril($_POST['email']);
	$sifre = $_POST['sifre'];
	$sifre2 = $_POST['sifre2'];
	
	$konay=Kontrol($kadi);
	
	$emailonay=$email;
	
	$sifreonay=KontrolSifre($sifre);
	
	$s1=$kpanel->prepare("SELECT count(*) FROM Kullanicilar WHERE username='$kadi' LIMIT 1");
	$result = $s1->execute();
	$s1   = $s1->fetchColumn();

	
	$s2=$kpanel->prepare("SELECT count(*) FROM Kullanicilar WHERE email='$email' LIMIT 1");
	$result = $s2->execute();
	$s2   = $s2->fetchColumn();

	$s3=$kpanel->prepare("SELECT count(kayitip) FROM Kullanicilar WHERE kayitip='$ip_adresi' AND kayittarihi >= NOW() - INTERVAL 6 hour");
	$result = $s3->execute();
	$s3   = $s3->fetchColumn();

	
	$data=Array();
	
	$uuid=Uuid($kadi);
	


if ($kadi==null OR $email==null OR $sifre==null)
	{
		$_SESSION['hata'] = 'Lütfen boş alan bırakmayınız';
		header('Location:'.$domain.'');
	}
	else if ($sifre != $sifre2)
	{
		$_SESSION['hata'] = 'Şifreleriniz uyuşmuyor';
		header('Location:'.$domain.'');
	}
	#else if (strtoupper($_POST['dk']) != $_SESSION['dogrulamakodu'])
	#{
		#$_SESSION['hata'] = 'Doğrulama kodunu hatalı girdiniz';
		#header('Location:/');
	#}
	else if ($konay)
	{
		$_SESSION['hata'] = 'Girdiğiniz kullanıcı adı uygun olmayan karakter içeriyor';
		header('Location:'.$domain.'');
			
		
	}
	else if (strlen($kadi)<3 OR strlen($kadi)>16)
	{
	
		$_SESSION['hata'] = 'Kullanıcı adınız en az 3 karakter en fazla 16 karakter olmalıdır.';
		header('Location:'.$domain.'');
			
		
	}
	else if ($emailonay == false)
	{
		$_SESSION['hata'] = 'Lütfen doğru email adresi giriniz';
		header('Location:'.$domain.'');
			
		
	}
	else if ($sifreonay)
	{
		$_SESSION['hata'] = 'Lütfen şifrenizde özel karakter ve türkçe karakter kullanmayınız.';
		header('Location:'.$domain.'');
			
		
	}
	else if (strlen($sifre)<6 OR strlen($sifre)>18)
	{
		$_SESSION['hata'] = 'Şifreniz en az 6 , en çok 18 karakter uzunluğunda olmalıdır.';
		header('Location:'.$domain.'');
			
		
	}
	else if (!isset($_POST['onay']))
	{
		$_SESSION['hata'] = 'Lütfen şartları ve polikaları onaylayınız.';
		header('Location:'.$domain.'');
			
		
	}
	else if ($s3>1)
	{
		$_SESSION['hata'] = 'Ip adresiniz ile kayıt olma limitiniz dolmuştur. Lütfen daha sonra tekrar deneyiniz.';
		header('Location:'.$domain.'');
			
		
	}

	else if ($s1>0)
	{
		$_SESSION['hata'] = 'Bu kullanıcı adıyla daha önceden kayıt olunmuş.';
		header('Location:'.$domain.'');
			
		
	}
	else if ($s2>0)
	{
		$_SESSION['hata'] = 'Bu eposta adresiyle daha önceden kayıt olunmuş.';
		header('Location:'.$domain.'');
			
		
	}
	else if ($uuid=='')
	{
		$_SESSION['hata'] = 'Uuid oluşturulamadı. Lütfen daha sonra tekrar deneyiniz.';
		header('Location:'.$domain.'');
			
		
	}
	
	else{
		
		$sifrehash=Sifrele($sifre);
		
		$sifrehash2=SifreleSite($sifre);
		
        $sorgu = $kpanel->query("INSERT INTO Kullanicilar SET username = '$kadi', realname = '$kadi', password = '$sifrehash', passwordsite = '$sifrehash2', email = '$email', uuid='$uuid', kayitip='$ip_adresi', x = '0', y = '0', z = '0', world = 'world', regdate = '0', isLogged = '0', hasSession = '0', Kredi = '0', skype = 'Belirtilmedi', discord = 'Belirtilmedi', steam = 'Belirtilmedi', youtube = 'Belirtilmedi', il = 'Belirtilmedi', hakkimda = 'Belirtilmedi'");		
		$kid = $kpanel->prepare("SELECT * From Kullanicilar WHERE username = :username");
		$result = $kid->execute(array(":username" => $kadi));
		$kid   = $kid->fetch(PDO::FETCH_ASSOC);
		
		if($kid['username'] != ''){
			$_SESSION['hata'] = 'Başarıyla kayıt oldunuz. Lütfen giriş yapınız.';

			
			#$_SESSION["login"] = "true";

			#$_SESSION["kid"] = $kid['KullaniciId'];

			#$_SESSION["uuid"] = $kid['uuid'];

			#$_SESSION["username"] = $kid['username'];
			
			header('Location:'.$domain.'');
		
		}
		else {
			$_SESSION['hata'] = 'Bir hata oluştu lütfen daha sonra tekrar deneyin.';
			header('Location:'.$domain.'');				
			
		}
	}
}


?>
<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="utf-8">
  <meta name="description" content="CandyCraft | Türkiyenin Minecraft Oyun Platformu">
  <meta name="keywords" content="candycraft,candy craft,minecraft server,minecraft,minecraft hub server">
  <meta name="author" content="Candy Craft">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- style -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  <link rel="stylesheet" href="<?php echo $domain2; ?>css/style.min.css">
  <!-- favicon -->
  <link rel="icon" href="https://www.candycraft.net/assets/images/dark/icon.png">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <style>
  a:hover{text-decoration:none !important;}
  a:active{text-decoration:none !important;}
  p {
		color: #777;
		font-family: "Roboto",sans-serif;
		font-size: .9125em;
		line-height: 1.6923076923em;
	}  
  .widget-options-wrap .widget-option-text {
		float: left;
		color: #fff;
		font-family: "Roboto",sans-serif;
		font-size: .7875em;
	}
  </style>
  <title>Candy Craft</title>
</head>
<body>
  <div class="search-popup">
    <svg class="cross-icon big close-button search-popup-close">
      <use xlink:href="#svg-cross-big"></use>
    </svg>
    <form method="GET" class="search-popup-form" action="<?php echo $domain2; ?>sonuc">
      <input type="text" id="search" class="input-line" name="ara" placeholder="Forumlarda Ara...?">
    </form>
    <p class="search-popup-text"></p>
  </div>
  <div class="mobile-menu-wrap">
    <svg class="cross-icon big mobile-menu-close">
      <use xlink:href="#svg-cross-big"></use>
    </svg>
    <svg class="search-popup-open search-icon">
      <use xlink:href="#svg-search"></use>
    </svg>
    <figure class="logo-img">
      <img src="<?php echo $domain2; ?>img/candy-logo.png" alt="Logo" style="width:100px;">
    </figure>
    <ul class="mobile-menu">
      <li class="mobile-menu-item">
        <a href="<?php echo $domain2; ?>" class="mobile-menu-item-link">ANASAYFA</a>
      </li>
	  <li class="mobile-menu-item">
          <a href="<?php echo $domain2.'haberler'; ?>" class="mobile-menu-item-link">HABERLER</a>
        </li>
        <li class="mobile-menu-item">
          <a href="<?php echo $domain2.'oyunlar'; ?>" class="mobile-menu-item-link">OYUNLAR</a>
        </li>
        <li class="mobile-menu-item">
          <a href="<?php echo $domain2.'siralama'; ?>" class="mobile-menu-item-link">SIRALAMA</a>
        </li>
		<li class="mobile-menu-item">
          <a href="<?php echo $domain2.'yardim_merkezi'; ?>" class="mobile-menu-item-link">YARDIM MERKEZİ</a>
        </li>
		<li class="mobile-menu-item">
          <a href="<?php echo $domain2.'kurallar'; ?>" class="mobile-menu-item-link">KURALLAR</a>
        </li>
        <li class="mobile-menu-item">
          <a href="<?php echo $domain2.'forumlar'; ?>" class="mobile-menu-item-link">FORUM</a>
        </li>
		<li class="mobile-menu-item">
          <a href="<?php echo $domain2.'tumvideolar'; ?>" class="mobile-menu-item-link">VİDEOLAR</a>
        </li>
        <li class="mobile-menu-item">
<?php
if($_SESSION['username'] != ''){
?>
          <a href="<?php echo $domain2.'market'; ?>" class="mobile-menu-item-link">MARKET</a>
<?php
}else{
	echo '<a class="mobile-menu-item-link" type="button" role="button" data-toggle="modal" data-target="#girisyapmalisin">';
	echo 'MARKET';
	echo '</a>';
}
?>
        </li>
    </ul>
  </div>
  <div class="header-wrap">
    <div class="header grid-limit">
      <div class="widget-selectables">

      </div>
      <div class="widget-selectables">
<?php 
if($_SESSION['login'] != NULL or $_SESSION['login'] != ''){
	
$mesajsayisii = $db->query("select * from uyemesajlar where (alankisi = '".$_SESSION['username']."') && (okunma = '0') && (gonderenkisi != '".$_SESSION['username']."')");
	$mesajsayisii->execute();
	$mesajsayisii = $mesajsayisii->fetchAll();
 $o = 0;
 foreach($mesajsayisii as $messayi){
	 $o++;
 }	
$kredi = $kpanel->prepare("select * from Kullanicilar where (uuid = :uuid)");
$result = $kredi->execute(array(":uuid" => $_SESSION["uuid"]));
$kredi  = $kredi->fetch(PDO::FETCH_ASSOC);
	
	echo '<div class="widget-options-wrap" style="display:block">';
	  echo '<div id="account-dropdown-trigger" class="current-option">';
		echo '<div class="current-option-value">';
		  echo '<img class="widget-option-img user-avatar micro" src="https://cravatar.eu/avatar/'.$_SESSION['username'].'" alt="avatar-01" style="display:block">';
		  echo '<p class="widget-option-text">'.$_SESSION['username'].'</p>';
		echo '</div>';
		echo '<svg class="arrow-icon">';
		  echo '<use xlink:href="#svg-arrow"></use>';
		echo '</svg>';
	  echo '</div>';
	  echo '<div id="account-dropdown" class="widget-options short linkable">';
		echo '<div class="widget-option-heading blue">';
		  echo '<p class="widget-option-text">Hesabım</p>';
		echo '</div>';
		echo '<a href="'.$domain2.'durumum" class="widget-option">';
		  echo '<p class="widget-option-text">İstatistikler</p>';
		echo '</a>';
		echo '<a href="'.$domain2.'panel" class="widget-option">';
		  echo '<p class="widget-option-text">Son Aktiviteler</p>';
		echo '</a>';
		echo '<a href="'.$domain2.'gecmis" class="widget-option">';
		  echo '<p class="widget-option-text">Geçmiş</p>';
		echo '</a>';
		echo '<a href="'.$domain2.'profil_ayarlarim" class="widget-option">';
		  echo '<p class="widget-option-text">Ayarlarım</p>';
		echo '</a>';
		echo '<a href="'.$domain2.'destekmerkezi" class="widget-option">';
		  echo '<p class="widget-option-text">Destek Merkezi</p>';
		echo '</a>';
		echo '<a href="'.$domain2.'videolarim" class="widget-option">';
		  echo '<p class="widget-option-text">Videolarım</p>';
		echo '</a>';
		echo '<a href="'.$domain.'krediyukle" class="widget-option">';
		  echo '<p class="widget-option-text">Kredi Yükle</p>';
		echo '</a>';
	  echo '</div>';
	echo '</div>';
		echo '<div class="widget-options-wrap" style="display:block">';
          echo '<div class="current-option">';
            echo '<div class="current-option-value">';
			echo '<a href="'.$domain.'krediyukle">';
              echo '<p class="widget-option-text"><i class="fa fa-money"></i> <span class="gizle">Kredi</span> <span class="quantity"> ('.$kredi['Kredi'].')</span></p>';
			echo '</a>';
            echo '</div>';
          echo '</div>';
       echo '</div>';
	   echo '<div class="widget-options-wrap" style="display:block">';
          echo '<div class="current-option">';
            echo '<div class="current-option-value">';
			
              echo '<a href="'.$domain2.'mesajlarim" style="text-decoration:none;">';
              echo '<p class="widget-option-text"><i class="fa fa-envelope"></i> <span class="gizle">Mesaj </span><span class="quantity"> ('.$o.')</span></p>';
			  echo '</a>';
            echo '</div>';
          echo '</div>';
       echo '</div>';
	echo '<a href="'.$domain2.'cikis.php" class="button tiny red log-button">';
		echo '<span class="gizle">Güvenli </span>Çıkış';
		echo '<div class="button-ornament">';
		  echo '<svg class="arrow-icon">';
			echo '<use xlink:href="#svg-arrow"></use>';
		  echo '</svg>';
		echo '</div>';
	echo '</a>';
	
	echo '<a href="#" class="button tiny green popup-login-trigger log-button hide" style="margin-right:15px;">';
		
	echo '</a>';

	echo '<a href="#" class="button tiny blue popup-register-trigger log-button hide">';
		
	echo '</a>';
}else{
	
	echo '<a href="#" class="button tiny green popup-login-trigger log-button" style="margin-right:15px;">';
		echo 'Giriş';
		echo '<div class="button-ornament">';
		  echo '<svg class="arrow-icon">';
			echo '<use xlink:href="#svg-arrow"></use>';
		  echo '</svg>';
		echo '</div>';
	echo '</a>';

	echo '<a href="#" class="button tiny blue popup-register-trigger log-button">';
		echo 'Kayıt Ol';
		echo '<div class="button-ornament">';
		  echo '<svg class="arrow-icon">';
			echo '<use xlink:href="#svg-arrow"></use>';
		  echo '</svg>';
		echo '</div>';
	echo '</a>';
}
?>
	
        
      </div>
    </div>
  </div>
  <nav class="navigation-wrap">
    <div class="navigation grid-limit">
      <div class="logo" style="margin-top:0px;">
        <figure class="logo-img">
          <a href="<?php echo $domain2; ?>"><img src="<?php echo $domain2; ?>img/candy-logo.png" alt="Logo" style="max-width:130px;"></a>
        </figure>
      </div>
      <div class="search-button search-popup-open">
        <svg class="search-icon">
          <use xlink:href="#svg-search"></use>
        </svg>
      </div>
      <ul class="main-menu">
        <li class="main-menu-item">
          <a href="<?php echo $domain2; ?>" class="main-menu-item-link">ANASAYFA</a>
        </li>
        <li class="main-menu-item">
          <a href="<?php echo $domain2.'haberler'; ?>" class="main-menu-item-link">HABERLER</a>
        </li>
        <li class="main-menu-item">
          <a href="<?php echo $domain2.'oyunlar'; ?>" class="main-menu-item-link">OYUNLAR</a>
        </li>
        <li class="main-menu-item">
          <a href="<?php echo $domain2.'siralama'; ?>" class="main-menu-item-link">SIRALAMA</a>
        </li>
		<li class="main-menu-item">
          <a href="<?php echo $domain2.'yardim_merkezi'; ?>" class="main-menu-item-link">YARDIM MERKEZİ</a>
        </li>
		<li class="main-menu-item">
          <a href="<?php echo $domain2.'kurallar'; ?>" class="main-menu-item-link">KURALLAR</a>
        </li>
        <li class="main-menu-item">
          <a href="<?php echo $domain2.'forumlar'; ?>" class="main-menu-item-link">FORUM</a>
        </li>
		<li class="main-menu-item">
          <a href="<?php echo $domain2.'tumvideolar'; ?>" class="main-menu-item-link">VİDEOLAR</a>
        </li>
        <li class="main-menu-item">
<?php
if($_SESSION['username'] != ''){
?>
          <a href="<?php echo $domain2.'market'; ?>" class="main-menu-item-link">MARKET</a>
<?php
}else{
	echo '<a class="main-menu-item-link" type="button" role="button" data-toggle="modal" data-target="#girisyapmalisin">';
	echo 'MARKET';
	echo '</a>';
}
?>
        </li>
      </ul>
    </div>
  </nav>
  <div class="mobile-menu-pull mobile-menu-open">
    <svg class="menu-pull-icon">
      <use xlink:href="#svg-menu-pull"></use>
    </svg>
  </div>
  <div id="popup-login" class="popup-wrap medium">
    <div class="form-box-wrap">
      <div class="form-box-heading login" style="background: url('https://www.candycraft.net/images/home-slide/minecraft.jpg') no-repeat center,linear-gradient(45deg, #1c59f3, #00d8ff);background-size: cover;">
        <div class="form-box-heading-title-wrap">
          <p class="form-box-heading-title" style="font-size: 2.275em;">Maceraya Katıl!</p>
          <p class="form-box-heading-subtitle"></p>
        </div>
      </div>
      <div class="form-box-body">
        <div class="form-box">
          <div class="section-title-wrap blue">
            <h2 class="section-title medium">Hesabına Giriş Yap</h2>
            <div class="section-title-separator"></div>
          </div>
          <form method="POST" class="form-wrap">
            <div class="form-row">
              <div class="form-item blue">
                <label for="login_email_03" class="rl-label">Kullanıcı Adı</label>
                <input type="text" id="login_email_03" name="kullaniciadii" placeholder="Kullanıcı Adınızı Girin..." required>
              </div>
            </div>
            <div class="form-row">
              <div class="form-item blue">
                <label for="login_pwd_03" class="rl-label">Parola</label>
                <input type="password" id="login_pwd_03" name="parola" placeholder="Parolanız..." required>
              </div>
            </div>
			<div class="form-row" style="text-align:center;">
			<?php echo '<img alt="'.$_SESSION['dogrulamakodu'].'" src="'.$domain2.'guvenlik.php" style="margin-bottom:10px;"/>'; ?>
			<input type="text" id="login_email_03" name="kod" placeholder="Doğrulama Kodunu Girin..." size="15" required>
			
			</div>
            <div class="form-confirm-row">
              <a href="#" class="link-text-form blue" data-toggle="modal" data-target="#sifreyenileme">Şifremi Unuttum?</a>
            </div>
            <div class="form-actions full">
              <button class="button blue full" name="submit">Giriş Yap</button>
            </div>
          </form>
        </div>
        <div class="tab-form-buttons">
          <p class="tab-form-button selected">Üyelik Girişi</p>
        </div>
      </div>
    </div>
  </div>

  <div id="popup-register" class="popup-wrap medium">
    <div class="form-box-wrap">
      <div class="form-box-heading register" style="background: url('https://www.candycraft.net/images/home-slide/minecraft.jpg') no-repeat center,linear-gradient(45deg, #1c59f3, #00d8ff);background-size: cover;">
        <div class="form-box-heading-title-wrap">
          <p class="form-box-heading-title" style="font-size: 2.275em;">Hoşgeldin!</p>
          <p class="form-box-heading-subtitle">Maceraya Katıl!</p>
        </div>
        <!--<p class="form-box-heading-text">After registering, you’ll receive a confirmation email in your inbox with a link to activate your account!</p>-->
      </div>
      <div class="form-box-body">
        <div class="form-box">
          <div class="section-title-wrap red">
            <h2 class="section-title medium">Kayıt Ol!</h2>
            <div class="section-title-separator"></div>
          </div>
          <form method="post" id="kayit" class="form-wrap">
			<div class="form-row">  
			
              <div class="form-item red">
                <label for="register_email_04" class="rl-label">Kullanıcı Adı</label>
                <input type="text" id="register_email_04" name="kadi" placeholder="Kullanıcı Adınız...">
              </div>
            </div>
            <div class="form-row">
              <div class="form-item red">
                <label for="register_email_04" class="rl-label">Email Adresi</label>
                <input type="email" id="register_email_04" name="email" title="Geçerli bir eposta belirtiniz" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" placeholder="E-mail Adresiniz...">
              </div>
            </div>
            <div class="form-row">
              <div class="form-item red">
                <label for="register_pwd_04" class="rl-label">Şifre</label>
                <input type="password" id="register_pwd_04" name="sifre" placeholder="Şifreniz...">
              </div>
            </div>
            <div class="form-row">
              <div class="form-item red">
                <label for="register_pwd_repeat_04" class="rl-label">Tekrar Şifre</label>
                <input type="password" id="register_pwd_repeat_04" name="sifre2" placeholder="Tekrar Şifreniz...">
              </div>
            </div>
			<div class="form-row">
              <div class="form-item red">				
				<div class="radio-item">
                  <input type="radio" id="sc_radio_2" name="onay" required>
                  <div class="radio-circle blue"></div>
                  <label for="sc_radio_2" class="rl-label">Kuralları okudum ve kabul ediyorum.</label>
                </div>
              </div>
            </div>
            <div class="form-actions full">

			  <input type="submit" class="button red full" name="kayitol" style="border: 1px solid #ddd;" value="Kayıt Ol">
              <p class="form-info-text">Lütfen kullanıcı adınızda büyük küçük karakterlere dikkat ediniz.</p>
            </div>
          </form>
        </div>
        <div class="tab-form-buttons">
          <p class="tab-form-button selected">Kayıt Formu</p>
        </div>
      </div>
    </div>
  </div>
<?php  
#şifremi unuttum
echo '<div id="sifreyenileme" class="modal" style="z-index:999999;">';
  echo '<div class="modal-dialog">';
    echo '<div class="modal-content">';
	
      echo '<div class="modal-header">';
        echo '<button type="button" class="close" data-dismiss="modal">&times;</button>';
        echo '<h4 class="modal-title">Şifremi Unuttum !</h4>';
      echo '</div>';
	  
      echo '<div class="modal-body" style="min-height:130px;">';
	  echo '<form method="POST">';
		echo '<div class="form-group">';
			echo '<label class="control-label col-sm-4" for="email">Email Adresiniz:</label>';
			echo '<div class="col-sm-8">';
				echo '<div class="youplay-input">';
					echo '<input type="email" id="email" name="sifremihatirlat" placeholder="Email Adresinizi Yazınız" required>';
				echo '</div>';
			echo '</div>';
		echo '</div>';
	  
      echo '</div>';
	  
      echo '<div class="modal-footer">';
        echo '<input type="submit" class="btn btn-default" name="sifremisifirla" value="Gönder">';
      echo '</div>';
	  echo '</form>';
    echo '</div>';
  echo '</div>';
echo '</div>';

if($_POST['sifremisifirla']){
	$emailk = piril($_POST['sifremihatirlat']);
	$emailkontrol = $kpanel->prepare("select * from Kullanicilar where (email = '".$emailk."')");
	$result = $emailkontrol->execute();
	$emailkontrol  = $emailkontrol->fetch(PDO::FETCH_ASSOC);
	if($emailkontrol['username'] != ''){
		$token = uniqid();
		$kpanel->query("update Kullanicilar set token = '".$token."' where (email = '".$emailk."')");
		$_SESSION['sifremisifirla'] = 'Şifre güncellemeniz için gerekli bilgiler mail adresinize gönderilmiştir. Eğer mail ulaşmadıysa spam klasörünüzü kontrol etmeyi unutmayınız.';
		
$mail = new PHPMailer();
$mail->IsSMTP();
$mail->SMTPDebug = 0;
$mail->SMTPAuth = true;
$mail->SMTPSecure = 'ssl'; // Normal bağlantı için boş bırakın veya tls yazın, güvenli bağlantı kullanmak için ssl yazın
$mail->Host = "smtp.yandex.ru"; // Mail sunucusunun adresi (IP de olabilir)
$mail->Port = 465; // Normal bağlantı için 587, güvenli bağlantı için 465 yazın
$mail->IsHTML(true);
$mail->SetLanguage("tr", "phpmailer/language");
$mail->CharSet  ="utf-8";
$mail->Username = "kullanici@candycraft.net"; // Gönderici adresiniz (e-posta adresiniz)
$mail->Password = "jAURQ2KAsj5SCKEn@!!"; // Mail adresimizin sifresi
$mail->SetFrom("kullanici@candycraft.net", "Candy Craft"); // Mail atıldığında gorulecek isim ve email
$mail->AddAddress($emailk); // Mailin gönderileceği alıcı adres
$mail->Subject = "Candy Craft Şifre Yenileme İsteği"; // Email konu başlığı
#$mail->Body = "<a href='http://www.candycraft.net/sifremiyenile.php?email=".$emailk."&token=".$token."'>Parolamı Sıfırla</a>";
$mail->Body = '
<!doctype html>
			<html lang="tr">
			  <head>
				<meta name="viewport" content="width=device-width" />
				<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
				<title>Candy Craft Kullanıcı İşlemleri</title>
				<style>
				  /* -------------------------------------
					  GLOBAL RESETS
				  ------------------------------------- */
				  .img-responsive {
					  display: block;
					  max-width: 50%;
					  height: auto;
					}
				  img {
					border: none;
					-ms-interpolation-mode: bicubic;
					max-width: 100%; }
				  body {
					background-color: #f6f6f6;
					font-family: sans-serif;
					-webkit-font-smoothing: antialiased;
					font-size: 14px;
					line-height: 1.4;
					margin: 0;
					padding: 0;
					-ms-text-size-adjust: 100%;
					-webkit-text-size-adjust: 100%; }
				  table {
					border-collapse: separate;
					mso-table-lspace: 0pt;
					mso-table-rspace: 0pt;
					width: 100%; }
					table td {
					  font-family: sans-serif;
					  font-size: 14px;
					  vertical-align: top; }
				  /* -------------------------------------
					  BODY & CONTAINER
				  ------------------------------------- */
				  .body {
					background-color: #f6f6f6;
					width: 100%; }
				  /* Set a max-width, and make it display as block so it will automatically stretch to that width, but will also shrink down on a phone or something */
				  .container {
					display: block;
					Margin: 0 auto !important;
					/* makes it centered */
					max-width: 580px;
					padding: 10px;
					width: 580px; }
				  /* This should also be a block element, so that it will fill 100% of the .container */
				  .content {
					box-sizing: border-box;
					display: block;
					Margin: 0 auto;
					max-width: 580px;
					padding: 10px; }
				  /* -------------------------------------
					  HEADER, FOOTER, MAIN
				  ------------------------------------- */
				  .main {
					background: #ffffff;
					border-radius: 3px;
					width: 100%; }
				  .wrapper {
					box-sizing: border-box;
					padding: 20px; }
				  .content-block {
					padding-bottom: 10px;
					padding-top: 10px;
				  }
				  .footer {
					clear: both;
					Margin-top: 10px;
					text-align: center;
					width: 100%; }
					.footer td,
					.footer p,
					.footer span,
					.footer a {
					  color: #999999;
					  font-size: 12px;
					  text-align: center; }
				  /* -------------------------------------
					  TYPOGRAPHY
				  ------------------------------------- */
				  h1,
				  h2,
				  h3,
				  h4 {
					color: #000000;
					font-family: sans-serif;
					font-weight: 400;
					line-height: 1.4;
					margin: 0;
					Margin-bottom: 30px; }
				  h1 {
					font-size: 35px;
					font-weight: 300;
					text-align: center;
					text-transform: capitalize; }
				  p,
				  ul,
				  ol {
					font-family: sans-serif;
					font-size: 14px;
					font-weight: normal;
					margin: 0;
					Margin-bottom: 15px; }
					p li,
					ul li,
					ol li {
					  list-style-position: inside;
					  margin-left: 5px; }
				  a {
					color: #3498db;
					text-decoration: underline; }
				  /* -------------------------------------
					  BUTTONS
				  ------------------------------------- */
				  .btn {
					box-sizing: border-box;
					width: 100%; }
					.btn > tbody > tr > td {
					  padding-bottom: 15px; }
					.btn table {
					  width: auto; }
					.btn table td {
					  background-color: #ffffff;
					  border-radius: 5px;
					  text-align: center; }
					.btn a {
					  background-color: #ffffff;
					  border: solid 1px #3498db;
					  border-radius: 5px;
					  box-sizing: border-box;
					  color: #3498db;
					  cursor: pointer;
					  display: inline-block;
					  font-size: 14px;
					  font-weight: bold;
					  margin: 0;
					  padding: 12px 25px;
					  text-decoration: none;
					  text-transform: capitalize; }
				  .btn-primary table td {
					background-color: #3498db; }
				  .btn-primary a {
					background-color: #3498db;
					border-color: #3498db;
					color: #ffffff; }
				  /* -------------------------------------
					  OTHER STYLES THAT MIGHT BE USEFUL
				  ------------------------------------- */
				  .last {
					margin-bottom: 0; }
				  .first {
					margin-top: 0; }
				  .align-center {
					text-align: center; }
				  .align-right {
					text-align: right; }
				  .align-left {
					text-align: left; }
				  .clear {
					clear: both; }
				  .mt0 {
					margin-top: 0; }
				  .mb0 {
					margin-bottom: 0; }
				  .preheader {
					color: transparent;
					display: none;
					height: 0;
					max-height: 0;
					max-width: 0;
					opacity: 0;
					overflow: hidden;
					mso-hide: all;
					visibility: hidden;
					width: 0; }
				  .powered-by a {
					text-decoration: none; }
				  hr {
					border: 0;
					border-bottom: 1px solid #f6f6f6;
					Margin: 20px 0; }
				  /* -------------------------------------
					  RESPONSIVE AND MOBILE FRIENDLY STYLES
				  ------------------------------------- */
				  @media only screen and (max-width: 620px) {
					table[class=body] h1 {
					  font-size: 28px !important;
					  margin-bottom: 10px !important; }
					table[class=body] p,
					table[class=body] ul,
					table[class=body] ol,
					table[class=body] td,
					table[class=body] span,
					table[class=body] a {
					  font-size: 16px !important; }
					table[class=body] .wrapper,
					table[class=body] .article {
					  padding: 10px !important; }
					table[class=body] .content {
					  padding: 0 !important; }
					table[class=body] .container {
					  padding: 0 !important;
					  width: 100% !important; }
					table[class=body] .main {
					  border-left-width: 0 !important;
					  border-radius: 0 !important;
					  border-right-width: 0 !important; }
					table[class=body] .btn table {
					  width: 100% !important; }
					table[class=body] .btn a {
					  width: 100% !important; }
					table[class=body] .img-responsive {
					  height: auto !important;
					  max-width: 100% !important;
					  width: auto !important; }}
				  /* -------------------------------------
					  PRESERVE THESE STYLES IN THE HEAD
				  ------------------------------------- */
				  @media all {
					.ExternalClass {
					  width: 100%; }
					.ExternalClass,
					.ExternalClass p,
					.ExternalClass span,
					.ExternalClass font,
					.ExternalClass td,
					.ExternalClass div {
					  line-height: 100%; }
					.apple-link a {
					  color: inherit !important;
					  font-family: inherit !important;
					  font-size: inherit !important;
					  font-weight: inherit !important;
					  line-height: inherit !important;
					  text-decoration: none !important; }
					.btn-primary table td:hover {
					  background-color: #34495e !important; }
					.btn-primary a:hover {
					  background-color: #34495e !important;
					  border-color: #34495e !important; } }
				</style>
			  </head>
			  <body class="">
				<table border="0" cellpadding="0" cellspacing="0" class="body">
				  <tr>
					<td>&nbsp;</td>
					<td class="container">
					  <div class="content">

						<!-- START CENTERED WHITE CONTAINER -->
						<span class="preheader">Candy Craft Kullanıcı İşlemleri.</span>
						<table class="main">

						  <!-- START MAIN CONTENT AREA -->
						  <tr>
							<td class="wrapper">
							  <table border="0" cellpadding="0" cellspacing="0">
								<tr>
								  <td>
<center>									
<img src="http://www.candycraft.net/assets/images/candy-logo.png" class="img-responsive">
									<br>
									<h2 style="text-align: center;"><strong>Şifre Değiştirme Bildirimi </strong></h2>
									<p>Şifre sıfırlama isteğinde bulundunuz. <br>Aşağıdaki linke tıklayarak işleminize devam edebilirsiniz. <br><font color="red">UYARI: Bu işlemi siz yapmadıysanız lütfen dikkate almayın!</font></p>
									 <a style="text-align: center;" href="https://www.candycraft.net/sifremiyenile.php?email='.$emailk.'&token='.$token.'" target="_blank">Doğrulama Linki</a>
										
									
									<p style="text-align: center;">Bu bir otomatik mesajdır lütfen cevaplamayınız.</p>
									<p style="text-align: center;">CC-Network</p>
									</center>
								  </td>
								</tr>
							  </table>
							</td>
						  </tr>

					
						</table>

					
						<div class="footer">
						  <table border="0" cellpadding="0" cellspacing="0">
							<tr>
							  <td class="content-block powered-by">
								© 2021 <a href="http://candycraft.net">Candy Craft</a> Tüm Hakları Saklıdır.
							  </td>
							</tr>
						  </table>
						</div>
						
					  </div>
					</td>
					<td>&nbsp;</td>
				  </tr>
				</table>
			  </body>
			</html>



';


 // Mailin içeriği
	if(!$mail->Send()){
	  #echo '<script> alert(\''.$mail->ErrorInfo.'\'); </script>';
	} else {
		echo '<script> alert(\''.$_SESSION['sifremisifirla'].'\'); </script>';
		$_SESSION['sifremisifirla'] = '';
	}	
		
	}else{
		echo '<script> alert(\'Girdiğiniz mail adresi kayıtlı değildir.\'); </script>';
	}
}

echo '<div id="girisyapmalisin" class="modal" style="z-index:99999;">';
  echo '<div class="modal-dialog">';
    echo '<div class="modal-content">';
	
      echo '<div class="modal-header">';
        echo '<button type="button" class="close" data-dismiss="modal">&times;</button>';
        echo '<h4 class="modal-title">Bilgilendirme</h4>';
      echo '</div>';
	  
      echo '<div class="modal-body">';
        echo '<p>Marketi Kullanmak için Giriş Yapmalısınız.</p>';
      echo '</div>';
	  
      echo '<div class="modal-footer">';
        echo '<button type="button" class="btn btn-default" data-dismiss="modal">Tamam</button>';
      echo '</div>';
	  
    echo '</div>';
  echo '</div>';
echo '</div>';

?>  
  
  
  <style>
  p {
		margin: 0 0 0px;
	}
  </style>
