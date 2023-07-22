<?php
include_once('header.php');
if($_GET['token'] == ''){
	header('Location:/');
}
?>
<style>
.banner-wrap.forum-banner {
    background: url("<?php echo $domain; ?>images/home-slide/galeri_9854494.jpg") no-repeat center,linear-gradient(45deg, #f30a5c, #1c95f3);
    background-size: auto, auto;
    background-size: cover;
}
</style>
  <!-- BANNER WRAP -->
  <div class="banner-wrap forum-banner">
    <!-- BANNER -->
    <div class="banner grid-limit">
      <h2 class="banner-title"><?php echo $hakkimizda['baslik']; ?></h2>
      <p class="banner-sections">
        <span class="banner-section">Anasayfa</span>
        <!-- ARROW ICON -->
        <svg class="arrow-icon">
          <use xlink:href="#svg-arrow"></use>
        </svg>
        <!-- /ARROW ICON -->
        <span class="banner-section">Şifremi Yenile</span>
      </p>
    </div>
    <!-- /BANNER -->
  </div>
  <!-- /BANNER WRAP -->

<?php include_once('slidenews.php'); ?>
<!--faq-item-content accordion-open--> 
  <!-- LAYOUT CONTENT FULL -->
  <div class="layout-content-full grid-limit">

<form method="POST">
                    <h3>Şifre Güncelle:</h3>
                    <div class="form-horizontal mt-30 mb-40">
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="new_password">Yeni Şifreniz:</label>
                            <div class="col-sm-10">
                                <div class="youplay-input">
                                    <input type="password" id="new_password" name="yeni" placeholder="Yeni Şifreniz" required>
                                </div>
                            </div>
                        </div>
						<div class="form-group">
                            <label class="control-label col-sm-2" for="new_passwordd">Tekrar Girin:</label>
                            <div class="col-sm-10">
                                <div class="youplay-input">
                                    <input type="password" id="new_passwordd" name="yenikontrol" placeholder="Yeni Şifreniz (Tekrar)" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" onclick = "this.form.submit();" class="button blue">Şifre Güncelle
								<span class="button-ornament">
                      <svg class="arrow-icon medium">
                        <use xlink:href="#svg-arrow-medium"></use>
                      </svg>

                      <svg class="cross-icon small">
                        <use xlink:href="#svg-cross-small"></use>
                      </svg>
                    </span>
								</button>
                            </div>
                        </div>
                    </div>
				</form>

<?php
if($_POST['yeni'] != ''){
	if($_POST['yeni'] != $_POST['yenikontrol']){
		echo '<script> alert(\'Girdiğiniz şifreler uyuşmuyor. Lütfen tekrar deneyiniz.\'); </script>';
	}elseif($_POST['yeni'] == '' or $_POST['yenikontrol'] == ''){
		echo '<script> alert(\'Boş alan bırakmayınız. Lütfen tekrar deneyiniz.\'); </script>';
	}elseif(strlen($_POST['yeni'])<6 OR strlen($_POST['yeni'])>18){
		echo '<script> alert(\'Şifreniz en az 6 karakter, en fazla 18 karakter olabilir. Lütfen tekrar deneyiniz.\'); </script>';
	}else{
		$email = $_GET['email'];
		$token = $_GET['token'];
		$kontrolsifre = $kpanel->prepare("select * from Kullanicilar where (email = '".$email."') && (token = '".$token."')");
		$result = $kontrolsifre->execute();
		$kontrolsifre   = $kontrolsifre->fetch(PDO::FETCH_ASSOC);
		
		if($kontrolsifre['username'] != ''){
			
			$yenisifre2 = Sifrele($_POST['yeni']);	
			$yenisifre = SifreleSite($_POST['yeni']);
					
			
			$kpanel->query("update Kullanicilar set password = '".$yenisifre2."', passwordsite = '".$yenisifre."', token = '' where (email = '".$email."')");
			$_SESSION['kontrol'] = 'Şifreniz Başarıyla Güncellenmiştir.';
			header('Location:'.$domain.'');
		}else{
			echo '<script> alert(\'Hatalı işlem yaptınız. Lütfen tekrar deneyiniz.\'); </script>';
		}
		
	}
	
}
?>	


  </div>
  <!-- /LAYOUT CONTENT FULL -->
<?php include_once('footer.php'); ?>