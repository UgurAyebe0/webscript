
<nav class="navbar-youplay navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="off-canvas" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            
                <a class="navbar-brand" href="index.php">
                    <img style=" width: 94px; " src="assets/images/logo-light.png" alt="">
                </a>
            
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            
                
						
						
						<ul class="nav navbar-nav">
                    
        <li><a href="index.php"  >Ana Sayfa</a></li>
        <li><a href="forum.php">Forum</a></li> 
        <li><a href="market.php">Market</a></li> 
        <li><a href="siralama.php">İstatistikler</a></li> 
		<li><a href="destek_taleplerim.php?kullaniciadi=<?php echo $sitekullaniciadi; ?>">Destek</a></li> 
		<?php 
							$eee = mysql_query("SELECT * FROM Sayfalar  limit 5"); 
							while($ihqqsan=mysql_fetch_assoc($eee)) 
							{  
							$sayfa_baslik=$ihqqsan["sayfa_baslik"];
							$sayfa_seo=$ihqqsan["sayfa_seo"]; 
							?>
        <li><a href="/<?php echo $sayfa_seo; ?>"><?php echo $sayfa_baslik; ?></a></li>
							<?php } ?>
                </ul>
            

            
            <ul class="nav navbar-nav navbar-right">
                
                    <?php if($sitekullaniciadi!=""){?>
        <li class=" dropdown dropdown-hover">
            <a href="http://kullanici.candycraft.net/ozan/profil.php?kullaniciadi=<?php echo $sitekullaniciadi; ?>" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
               <img src="https://minepic.org/avatar/<?php echo $sitekullaniciadi; ?>" width="25" height="25" alt=""> <?php echo $sitekullaniciadi; ?> 
                <span class="caret"></span> 
            </a><div class="dropdown-menu">
			
			
			<ul role="menu">                            
					<div class="row youplay-side-news" style="padding: 0px 0px; margin: 0px 10px;">
                                <div class="col-xs-3 col-md-4">
                                    <a href="http://kullanici.candycraft.net/ozan/profil.php?kullaniciadi=<?php echo $sitekullaniciadi; ?>" class="angled-img">
                                        <div class="img">
                                            
                                                <img src="https://minepic.org/avatar/<?php echo $sitekullaniciadi; ?>" alt="">
                                                
                                        </div>
                                    </a>
                                </div>
                                <div class="col-xs-9 col-md-8">
                                        <h4 class="ellipsis"><?php echo $sitekullaniciadi; ?></h4>
										<span><a href="http://kullanici.candycraft.net/ozan/profil.php?kullaniciadi=<?php echo $sitekullaniciadi; ?>">sayfana git</a></span>
                                </div>
                    </div>
					
					<div style="height: 1px; background: #6f717f; margin: 10px;"></div>
					<li> <a href="http://kullanici.candycraft.net/ozan/profil.php?kullaniciadi=<?php echo $sitekullaniciadi; ?>">Profil</a> </li>
					<li> <a href="arkadas_listesi.php">Arkadaş Listesi</a> </li>
					<li> <a href="user-settings.html">Ayarlar</a> </li>
					<li> <a href="forum.php">Forum</a> </li>
					<li> <a href="cikis_yap.php">Çıkış Yap </a> </li>
				</ul>
			
			
			</div>
				  <li class="dropdown dropdown-hover dropdown-cart"  >
                  <a href="krediyukle.php"> Kredin : 	<span ><?php echo $KrediKrediKrediKredi; ?> &nbsp;&nbsp;&nbsp;<img title="Kredi Yükle" src="http://pngimg.com/uploads/plus/plus_PNG87.png" style="width:15px;"></span></a>
                    </li>	
        </li>
				
                
                    
                  
                
	<?php } ?>

                
                    <?php if($sitekullaniciadi==""){?>
                    <li class="dropdown dropdown-hover dropdown-user">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="true">
                            <i class="fa fa-user"></i>
                            <span class="caret"></span>
                        </a>
                        <div class="dropdown-menu">
<form class="navbar-login-form" action="index.php" method="POST">
<p>Kullanıcı Adı:</p>
<div class="youplay-input">
<input name="kadi" type="username" placeholder="Kullanıcı Adı" size="16" maxlength="16" required>
</div>

<p>Şifre:</p>
<div class="youplay-input">
<input name="sifre" type="password" placeholder="Şifre" required>
</div>
								
								<img style="text-align: center;" src="dogrulama.php" />
								<div class="youplay-input" style="margin-top: 1rem;">
								<input type="text" name="dk" placeholder="Doğrulama Kodu" required>
								</div>
								

                                <div class="youplay-checkbox mb-15 ml-5">
                                    <input type="checkbox" name="rememberme" value="forever" id="nav-rememberme">
                                    <label for="nav-rememberme">Beni Hatırla</label>
                                </div>

                                <input name="girisyap" type="submit" class="btn btn-sm ml-0 mr-0" value="Giriş Yap" style="border: 1px solid #fff;"/>
                                <br>

                                <p>
                                    <a class="no-fade" href="sifremiunuttum.php">Şifremi Unuttum?</a> | <a class="no-fade" data-toggle="modal" data-target="#nav-registration" href="#">Kayıt Ol</a>
                                </p>
                            </form>
                        </div>
                    </li>
					<?php } ?>
                
            </ul>
            
        </div>
    </div>
</nav>
<!-- /Navbar -->