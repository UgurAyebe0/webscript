<?php 
$urlsine= $_SERVER['REQUEST_URI']; 
if($urlsine=="/ozan/aktivite.php"){
	$activese="class='active'";
} 
if($urlsine=="/ozan/profil.php"){
	$activcee="class='active'";
} 
if($urlsine=="/ozan/arkadas_listesi.php"){
	$activeee="class='active'";
} 
if($urlsine=="/ozan/mesajlarim.php"){
	$activeaa="class='active'";
} 
if($urlsine=="/ozan/ayarlar.php"){
	$activezzz="class='active'";
}  
if($urlsine=="/ozan/forum.php"){
	$activezzz="class='active'";
}  
if($urlsine=="/ozan/siralama.php"){
	$activezzz="class='active'";
}  
 ?>
<section class="youplay-banner banner-top youplay-banner-parallax small">
    
        <div class="image"  >
            <img src="https://minecraft.net/static/pages/img/index-hero-og.088fb7996b03.jpg" alt=""  >
        </div>
    

    <div class="youplay-user-navigation">
        <div class="container" style="width: 1170px;">
            <ul>
                <li <?php echo $activcee; ?>><a href="profil.php?kullaniciadi=<?php echo $gelenkullaniciadidegeri; ?>">Profil</a></li>
                <li <?php echo $activeee; ?>><a href="arkadas_listesi.php?kullaniciadi=<?php echo $gelenkullaniciadidegeri; ?>">Arkadaş Listesi</a></li>
                <li <?php echo $activeaa; ?>><a href="mesajlarim.php?kullaniciadi=<?php echo $gelenkullaniciadidegeri; ?>">Mesajlar <span class="badge"><?php 
				$query = mysql_query("SELECT COUNT(*) FROM fr_messages where reciver=$player_id",$baglaniki);
$say = mysql_fetch_array($query);
	echo $say[0];
	?></span></a></li>
                <li <?php echo $activezzz; ?>><a href="user-settings.html">Ayarlar</a></li> 
                <li> <a href="gecmis.php?kullaniciadi=<?php echo $gelenkullaniciadidegeri; ?>"> Geçmiş </a></li>
				<li> <a href="destek_taleplerim.php?kullaniciadi=<?php echo $gelenkullaniciadidegeri; ?>"> Destek </a></li>
            </ul>
        </div>
    </div>

    <div class="info" style="width: 1120px;">
        <div>
            <div class="container youplay-user"> 
                <div class="angled-img image-popup">
                    <div class="img">
                        <img src="https://minepic.org/avatar/<?php echo $gelenkullaniciadidegeri; ?>" alt="">
                    </div>
                </div>
                <div class="user-data">
                    <h2><?php echo $gelenkullaniciadidegeri; ?></h2>
                    <div class="activity">
                        <div>
                            <div class="num">69</div>
                            <div class="title">Yorum</div>
                        </div>
                        <div>
                            <div class="num"><?php echo $player_id; ?></div>
                            <div class="title">Forum Gönderisi</div>
                        </div>
                        <div>
                            <div class="num"><?php $query = mysql_query("SELECT COUNT(*) FROM fr_friend_assignment where friend1_id=1",$baglaniki);
$say = mysql_fetch_array($query);
	echo $say[0];
  ?></div>
                            <div class="title">Arkadaş</div>
                        </div>
                    </div>
                </div>
            </div>
 
        </div>
    </div>
</section>
<!-- /Banner -->