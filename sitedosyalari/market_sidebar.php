<!-- Right Side -->
        <div class="col-md-3" style=" margin-top: 40px; ">
             
<!-- Side Categories -->
<div class="side-block">
    <h4 class="block-title">Kategoriler</h4>
    <ul class="block-content">
	<?php $kategorigetirsql = mysql_query("SELECT * FROM UrunKategorileri WHERE AltKategori=0",$baglan); 
									while($ihqqsankategorigetirsql=mysql_fetch_assoc($kategorigetirsql)) 
									{   
									$KategoriAdi=$ihqqsankategorigetirsql["KategoriAdi"];
									$UrunKategoriId=$ihqqsankategorigetirsql["UrunKategoriId"];
									?>
        <li><a href="kategori_getir.php?kategori_id=<?php echo $UrunKategoriId; ?>"><?php echo $KategoriAdi; ?></a></li>
									<?php } ?> 
    </ul>
</div>
<!-- /Side Categories -->



<!-- Son Marketi Kullananlar -->
<div class="side-block">
    <h4 class="block-title">Son Marketi Kullananlar</h4>
    <div class="block-content p-0"> 
               <?php 
	  
								$eee = mysql_query("SELECT * FROM UrunLog limit 5",$baglan); 
									while($ihqqsan=mysql_fetch_assoc($eee)) 
									{   
									$UrunId=$ihqqsan["UrunId"];
									$KullaniciId=$ihqqsan["KullaniciId"];
$kbilgilerisql = mysql_fetch_array(mysql_query("SELECT * FROM Kullanicilar WHERE KullaniciId='$KullaniciId'",$baglan));
$username=$kbilgilerisql["username"];
$ugeticcr = mysql_fetch_array(mysql_query("SELECT * FROM Urunler WHERE UrunId='$UrunId'",$baglan));
$Adi=$ugeticcr["Adi"];
$GecerliYerler=$ugeticcr["GecerliYerler"];
$Fiyat=$ugeticcr["Fiyat"];
$Resim=$ugeticcr["Resim"]; 
  
 
									?>
									
        <div class="col-xs-3 col-md-4" style="margin-bottom: 10px;">
                <a href="profil.php?kullaniciadi=<?php echo $username; ?>" class="angled-img">
                    <div class="img">
                        <img src="https://minepic.org/avatar/<?php echo $username; ?>" alt="<?php echo $username; ?>">
                    </div>
                </a>
            </div>
			
			<div class="col-xs-9 col-md-8" style="margin-bottom: 10px;">
                <h5 class="ellipsis"><a class="siralamaKullanici" href="profil.php?kullaniciadi=<?php echo $username; ?>"><?php echo $username; ?></a></h5>
                <span style="font-size: 1.1rem;" class="price">Sunucu:   <?php echo $GecerliYerler; ?></span>
				<span style="font-size: 1.1rem;" class="price">Ürün adı: <?php echo $Adi; ?></span>
            </div>

																<?php $i++; } ?>
 
    </div>
</div>
<!-- /Son Marketi Kullananlar -->
 
        </div>