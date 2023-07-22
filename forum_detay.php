<?php include_once('header.php'); ?>
<style>
.banner-wrap.forum-banner {
    background: url("<?php echo $domain; ?>images/home-slide/galeri_9854494.jpg") no-repeat center,linear-gradient(45deg, #f30a5c, #1c95f3);
    background-size: auto, auto;
    background-size: cover;
}
.forum-category-wrap {
    width: auto;
	padding: 40px 0 40px 10px;
}
.link-list {
    width: auto;
}
img{
	max-width:100%;
	height:auto !important;
}
@media screen and (min-width:700px){
	.burasi{
		min-width:400px;
	}
}
</style>
<?php
$forumkonu = $db->prepare("select * from forumkonular where (yayin = '1') && (forumkategori = '".$_REQUEST['p']."') && (id = '".$_REQUEST['konu']."')");
$result = $forumkonu->execute();
$forumkonu  = $forumkonu->fetch(PDO::FETCH_ASSOC);
  
if($forumkonu == NULL){
	header('Location:/');
}  
$forumkategori = $db->prepare("select * from forumkategoriler where (id = '".$_REQUEST['p']."')");
$result = $forumkategori->execute();
$forumkategori  = $forumkategori->fetch(PDO::FETCH_ASSOC);


$sayfada = 10;

$toplam_icerik = $db->prepare("select count(*) from forummesajlar where (konuid = '".$forumkonu['id']."') && (yayin = '1')");
$result = $toplam_icerik->execute();
$toplam_icerik   = $toplam_icerik->fetchColumn();

$toplam_sayfa = ceil($toplam_icerik / $sayfada);

$sayfa = isset($_GET['sayfa']) ? (int) $_GET['sayfa'] : 1;

if($sayfa < 1) $sayfa = 1; 
if($sayfa > $toplam_sayfa) $sayfa = $toplam_sayfa; 

$limit = ($sayfa - 1) * $sayfada;

$forummesajlar = $db->query("select * from forummesajlar where (konuid = '".$forumkonu['id']."') && (yayin = '1') && (gosterme = '0') order by stamp asc LIMIT ".$limit." , ".$sayfada."");


    function linkify($value, $protocols = array('http', 'mail'), array $attributes = array())
    {
        // Link attributes
        $attr = '';
        foreach ($attributes as $key => $val) {
            $attr .= ' ' . $key . '="' . htmlentities($val) . '"';
        }
        
        $links = array();
        
        // Extract existing links and tags
        $value = preg_replace_callback('~(<a .*?>.*?</a>|<.*?>)~i', function ($match) use (&$links) { return '<' . array_push($links, $match[1]) . '>'; }, $value);
        
        // Extract text links for each protocol
        foreach ((array)$protocols as $protocol) {
            switch ($protocol) {
                case 'http':
                case 'https':   $value = preg_replace_callback('~(?:(https?)://([^\s<]+)|(www\.[^\s<]+?\.[^\s<]+))(?<![\.,:])~i', function ($match) use ($protocol, &$links, $attr) { if ($match[1]) $protocol = $match[1]; $link = $match[2] ?: $match[3]; return '<' . array_push($links, "<a $attr href=\"$protocol://$link\" target=\"_blank\">$link</a>") . '>'; }, $value); break;
                case 'mail':    $value = preg_replace_callback('~([^\s<]+?@[^\s<]+?\.[^\s<]+)(?<![\.,:])~', function ($match) use (&$links, $attr) { return '<' . array_push($links, "<a $attr href=\"mailto:{$match[1]}\"  target=\"_blank\">{$match[1]}</a>") . '>'; }, $value); break;
                case 'twitter': $value = preg_replace_callback('~(?<!\w)[@#](\w++)~', function ($match) use (&$links, $attr) { return '<' . array_push($links, "<a $attr href=\"https://twitter.com/" . ($match[0][0] == '@' ? '' : 'search/%23') . $match[1]  . "\"  target=\"_blank\">{$match[0]}</a>") . '>'; }, $value); break;
                default:        $value = preg_replace_callback('~' . preg_quote($protocol, '~') . '://([^\s<]+?)(?<![\.,:])~i', function ($match) use ($protocol, &$links, $attr) { return '<' . array_push($links, "<a $attr href=\"$protocol://{$match[1]}\"  target=\"_blank\">{$match[1]}</a>") . '>'; }, $value); break;
            }
        }
        
        // Insert all link
        return preg_replace_callback('/<(\d+)>/', function ($match) use (&$links) { return $links[$match[1] - 1]; }, $value);
    }
?>

  <div class="banner-wrap forum-banner">

    <div class="banner grid-limit">
      <h2 class="banner-title">Forum</h2>
      <p class="banner-sections">
        <span class="banner-section">Anasayfa</span>
        <svg class="arrow-icon">
          <use xlink:href="#svg-arrow"></use>
        </svg>
        <span class="banner-section">Forum</span>
        <svg class="arrow-icon">
          <use xlink:href="#svg-arrow"></use>
        </svg>
        <span class="banner-section">Kategoriler</span>
        <svg class="arrow-icon">
          <use xlink:href="#svg-arrow"></use>
        </svg>
        <span class="banner-section"><?php echo $forumkategori['kategori_TR']; ?></span>
      </p>
    </div>
  </div>

<?php include_once('slidenews.php'); ?>

  <div class="layout-content-full grid-limit">
    <div class="filters-row">
      <div class="option-list">
        <a href="<?php echo $domain2.'forumlar'; ?>"><p class="option-list-item">Tüm Kategoriler</p></a>
        <a href="<?php echo $domain2.'forumkategori/'.$forumkategori['kategorikodu']; ?>"><p class="option-list-item"><?php echo $forumkategori['kategori_TR']; ?></p></a>
        <p class="option-list-item selected"><?php echo $forumkonu['baslik']; ?></p>
      </div>
      <div class="forum-actions">
        <div class="dropdown-simple-wrap">
          <div id="forums-search-dropdown-trigger" class="current-option">
            <p class="button small red">Forumlarda Ara</p>
          </div>
          <div id="forums-search-dropdown" class="dp-options medium">
            <form class="form-wrap" action="<?php echo $domain2; ?>sonuc">
              <div class="form-row">
                <div class="form-item">
                  <div class="submit-input red">
                    <input type="text" id="forum_search_input" name="ara" placeholder="Ne aramıştınız?...">
                    <button class="submit-input-button">
                      <svg class="arrow-icon medium">
                        <use xlink:href="#svg-arrow-medium"></use>
                      </svg>
                    </button>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

 <?php
$mesajyazan = $kpanel->prepare("select * from Kullanicilar where (username = '".$forumkonu['username']."')");
$result = $mesajyazan->execute();
$mesajyazan  = $mesajyazan->fetch(PDO::FETCH_ASSOC);

$grup = $yetkiler->prepare("select * from perm_playergroups where (playeruuid = '".$mesajyazan["uuid"]."') && (groupid != '16') && (groupid != '17') && (groupid != '18') order by groupid desc");
$result = $grup->execute();
$grup  = $grup->fetch(PDO::FETCH_ASSOC);

$grupadi = $yetkiler->prepare("select * from perm_groups where (id = '".$grup['groupid']."')");
$result = $grupadi->execute();
$grupadi  = $grupadi->fetch(PDO::FETCH_ASSOC);
if($grupadi['name'] == NULL){$grupadi['name'] = 'Oyuncu';}
if($grupadi['id'] == '6' or $grupadi['id'] == NULL){
	$renk = '#5555FF';

}elseif($grupadi['id'] == '15'){
	$renk = '#AA0000';
}elseif($grupadi['id'] == '7'){
	$renk = '#55FFFF';
}elseif($grupadi['id'] == '8'){
	$renk = '#00AAAA';
}elseif($grupadi['id'] == '9'){
	$renk = '#00AA00';
}elseif($grupadi['id'] == '10'){
	$renk = '#AA00AA';
}elseif($grupadi['id'] == '11'){
	$renk = '#55FF55';
}elseif($grupadi['id'] == '12'){
	$renk = '#FF55FF';
}elseif($grupadi['id'] == '13'){
	$renk = '#FFAA00';
}elseif($grupadi['id'] == '14'){
	$renk = '#AA0000';
}
echo '<style>
	.label-warning::before{
		background:rgba(255,255,255,0);
	}
	</style>';
if($_REQUEST['sayfa'] == '' or $_REQUEST['sayfa'] == '1'){
	
	echo '<div class="post-comment" style="border-top:0px;">';
		echo '<figure class="user-avatar medium liquid">';
		  echo '<img src="https://cravatar.eu/avatar/'.$forumkonu['username'].'" alt="user-09">';
		echo '</figure>';
		echo '<p class="post-comment-username" style="text-transform:none;"><a href="'.$domain2.'profil/'.$forumkonu['username'].'" style="color:'.$renk.'">'.$forumkonu['username'].' <span class="tag-ornament" style="vertical-align:middle;background:'.$renk.';">'.$grupadi['name'].'</span></a> </p>';
		echo '<p class="post-comment-timestamp">'.date("d.m.y H:i",$forumkonu['stamp']).'</p>';
		#echo '<a href="#" class="report-button">Report</a>';
		echo '<p class="post-comment-text">'.linkify($forumkonu['yorum']).'</p>';
	echo '</div>';
	
}

if($forummesajlar != NULL){
	foreach($forummesajlar as $mesaj){
		if($mesaj['username'] != ''){
$mesajyazan = $kpanel->prepare("select * from Kullanicilar where (username = '".$mesaj['username']."')");
$result = $mesajyazan->execute();
$mesajyazan  = $mesajyazan->fetch(PDO::FETCH_ASSOC);
$grup = $yetkiler->prepare("select * from perm_playergroups where (playeruuid = '".$mesajyazan["uuid"]."') && (groupid != '16') && (groupid != '17') && (groupid != '18') order by groupid desc");
$result = $grup->execute();
$grup  = $grup->fetch(PDO::FETCH_ASSOC);

$grupadi = $yetkiler->prepare("select * from perm_groups where (id = '".$grup['groupid']."')");
$result = $grupadi->execute();
$grupadi  = $grupadi->fetch(PDO::FETCH_ASSOC);
if($grupadi['name'] == NULL){$grupadi['name'] = 'Oyuncu';}
if($grupadi['id'] == '6' or $grupadi['id'] == NULL){
	$renk = '#5555FF';

}elseif($grupadi['id'] == '15'){
	$renk = '#AA0000';
}elseif($grupadi['id'] == '7'){
	$renk = '#55FFFF';
}elseif($grupadi['id'] == '8'){
	$renk = '#00AAAA';
}elseif($grupadi['id'] == '9'){
	$renk = '#00AA00';
}elseif($grupadi['id'] == '10'){
	$renk = '#AA00AA';
}elseif($grupadi['id'] == '11'){
	$renk = '#55FF55';
}elseif($grupadi['id'] == '12'){
	$renk = '#FF55FF';
}elseif($grupadi['id'] == '13'){
	$renk = '#FFAA00';
}elseif($grupadi['id'] == '14'){
	$renk = '#AA0000';
}
echo '<style>
	.label-warning::before{
		background:rgba(255,255,255,0);
	}
	</style>';
	
	
	echo '<div class="post-comment" style="border-top:0px;">';
		echo '<figure class="user-avatar medium liquid">';
		  echo '<img src="https://cravatar.eu/avatar/'.$mesaj['username'].'" alt="user-09">';
		echo '</figure>';
		echo '<p class="post-comment-username" style="text-transform:none;"><a href="'.$domain2.'profil/'.$mesaj['username'].'" style="color:'.$renk.'">'.$mesaj['username'].' <span class="tag-ornament" style="vertical-align:middle;background:'.$renk.';">'.$grupadi['name'].'</span></a> </p>';
		echo '<p class="post-comment-timestamp">'.date("d.m.y H:i",$mesaj['stamp']).'</p>';
		
		if($_SESSION['uuid'] == $mesaj['uuid']){				
			echo '<p class="post-comment-timestamp">';	
					echo '<button type="button" data-toggle="modal" data-target="#mesajiduzenle'.$mesaj['id'].'" style="border: 0px;background-color: #55f;border-radius: 2px;padding: 7px;
color: #fff;">Mesajı Düzenle</button>';
				echo '</p>';
			}

		echo '<p class="post-comment-text">'.$mesaj['mesaj'].'</p>';
		if($mesaj['guncelleme'] != ''){
			echo '<div class="col-md-12" style="bottom:5px;top:5px;">';
			echo '<p class="text-muted text-right"><small>Güncellendi: '.date("d.m.Y H:i", $mesaj['guncelleme']).'</small> <small> Nedeni: '.$mesaj['nedeni'].'</small></p>';
			echo '</div>';
		}
		
	echo '</div>';

		
echo '<div id="mesajiduzenle'.$mesaj['id'].'" class="modal fade" role="dialog" aria-labelledby="modalLabel" aria-hidden="true" style="z-index: 6667;">';
  echo '<div class="modal-dialog" style="width:80%;">';
    echo '<div class="modal-content">';
	
      echo '<div class="modal-header">';
        echo '<button type="button" class="close" data-dismiss="modal">&times;</button>';
        echo '<h5 class="modal-title">Mesajını Düzenle</h5>';
      echo '</div>';
	  
      echo '<div class="modal-body">';
        echo '<form method="POST" class="comment-form">';
			echo '<div class="comment-cont clearfix">';
				echo '<div class="youplay-input">';
					echo '<input type="text" placeholder="Düzenleme Nedeniniz" name="nedeni" required>';
				echo '</div>';
				echo '<div class="" style="margin-top:15px;">';
					echo '<textarea class="top ckeditor" name="forummesa" required>'.linkify($mesaj['mesaj']).'</textarea>';
				echo '</div>';
				
			echo '</div>';
		
      echo '</div>';
	  
      echo '<div class="modal-footer">';
        echo '<input type="submit" name="'.$_SESSION['uuid'].''.$mesaj['id'].'" class="button tiny blue log-button" value="Güncelle" style="margin-top:10px;">';
		echo '</form>';
      echo '</div>';
	  
    echo '</div>';
  echo '</div>';
echo '</div>';	
		
if($_POST[''.$_SESSION['uuid'].''.$mesaj['id'].'']){
	if($_POST['forummesa'] != ''){
		$gmesaj = $_POST['forummesa'];
	}else{
		$gmesaj = $mesaj['mesaj'];
	}
	
	$gzaman = time();
	$gneden = $_POST['nedeni'];
	$gid = $mesaj['id'];
	$guuid = $_SESSION['uuid'];
	
	$db->query("update forummesajlar set mesaj = '".$gmesaj."', guncelleme = '".$gzaman."', nedeni = '".$gneden."' where (id = '".$gid."') && (uuid = '".$guuid."')");
	header('Location:'.$domain.'forumdetay/'.$_REQUEST['p'].'/'.$_REQUEST['konu']);
}		
	

		}

	
	}
}
?>   
    <!-- /TABLE -->

    <!-- PAGE NAVIGATION -->
    <div class="page-navigation blue spaced right">
	
<?php
$sayfa_goster = 7;
$en_az_orta = ceil($sayfa_goster/2);
$en_fazla_orta = ($toplam_sayfa+1) - $en_az_orta;
$sayfa_orta = $sayfa;
if($sayfa_orta < $en_az_orta) $sayfa_orta = $en_az_orta;
if($sayfa_orta > $en_fazla_orta) $sayfa_orta = $en_fazla_orta;
$sol_sayfalar = round($sayfa_orta - (($sayfa_goster-1) / 2));
$sag_sayfalar = round((($sayfa_goster-1) / 2) + $sayfa_orta); 
if($sol_sayfalar < 1) $sol_sayfalar = 1;
if($sag_sayfalar > $toplam_sayfa) $sag_sayfalar = $toplam_sayfa;
if ($toplam_sayfa>1) {
if($sayfa != 1){
?>	
<a href="<?php echo $domain2.'forumdetay/'.$forumkategori['id'].'/'.$forumkonu['id']; ?>?sayfa=<?php echo $sayfa-1; ?>" aria-controls="bootstrap-data-table" data-dt-idx="0" tabindex="0" class="page-link">
      <div class="slider-control big control-previous">
        <svg class="arrow-icon medium">
          <use xlink:href="#svg-arrow-medium"></use>
        </svg>
      </div>
	  </a>
<?php
}
for($s = $sol_sayfalar; $s <= $sag_sayfalar; $s++) {
					if($sayfa == $s) {
						?>
						<a href="#" class="page-navigation-item active"><?php echo $s; ?></a>
						<?php
					} else {
					?>
						<a class="page-navigation-item" href="<?php echo $domain2.'forumdetay/'.$forumkategori['id'].'/'.$forumkonu['id']; ?>?sayfa=<?php echo $s; ?>" aria-controls="bootstrap-data-table" data-dt-idx="1" tabindex="0" class="page-link"><?php echo $s; ?></a>
					<?php
					}
				}
				
if($sayfa != $toplam_sayfa) {				
				
?>
<a href="<?php echo $domain2.'forumdetay/'.$forumkategori['id'].'/'.$forumkonu['id']; ?>?sayfa=<?php echo $sayfa+1; ?>" aria-controls="bootstrap-data-table" data-dt-idx="0" tabindex="0" class="page-link">
      <div class="slider-control big control-next">
        <svg class="arrow-icon medium">
          <use xlink:href="#svg-arrow-medium"></use>
        </svg>
      </div>
	  </a>
<?php
}
}
?>
    </div>
    <!-- /PAGE NAVIGATION -->
	
<?php
$kullanici = $kpanel->prepare("select * from Kullanicilar where (username = '".$_SESSION['username']."')");
$result = $kullanici->execute();
$kullanici  = $kullanici->fetch(PDO::FETCH_ASSOC);
		
if($_SESSION["login"] != "true"){
	echo '<p class="alert alert-warning text-center" style="margin-top:15px;">Mesaj yazmak için giriş yapınız.</p>';
}elseif($kullanici["yasakli"] == '1'){
	echo '<p class="alert alert-warning text-center" style="margin-top:15px;">Mesaj yazmak için yetkiniz bulunmamaktadır.</p>';
}else{
	echo '<h4>Cevapla</h4>';
	echo '<form method="POST" class="comment-form">';
		echo '<div class="comment-cont clearfix">';
			echo '<div class="">';
				echo '<textarea class="top ckeditor" name="forummesaj"></textarea>';
			echo '</div>';
			echo '<button onclick = this.form.submit(); class="button blue" name="mesajkaydet" style="margin-top:10px;">Yanıtı Gönder';
			echo '<span class="button-ornament">
                  <svg class="arrow-icon medium">
                    <use xlink:href="#svg-arrow-medium"></use>
                  </svg>
                  <svg class="cross-icon small">
                    <use xlink:href="#svg-cross-small"></use>
                  </svg>
                 </span>';
			
			echo '</button>';
		echo '</div>';
	echo '</form>';
}
?>	
	
<?php
if($_POST['forummesaj'] != ''){
		$usernamee = $_SESSION["username"];
		$konuu = $_REQUEST['konu'];
		$forummesajj = $_POST['forummesaj'];
		$zaman = time();
		$uuidd = $_SESSION['uuid'];
	

		$db->query("insert into forummesajlar (username, konuid, mesaj, yayin, stamp, uuid, gosterme) values ('$usernamee','$konuu','$forummesajj','1','$zaman','$uuidd','0')");
		
		$mesajkontrol = $db->prepare("select * from encokmesaj where (uuid = '".$uuidd."')");
		$result = $mesajkontrol->execute();
		$mesajkontrol  = $mesajkontrol->fetch(PDO::FETCH_ASSOC);
		
		if($mesajkontrol != NULL){
			$sayi = $mesajkontrol['mesajsayi'] + 1;
			$db->query("update encokmesaj set mesajsayi = '$sayi', stamp = '$zaman' where (uuid = '$uuidd')");

		}else{
			$db->query("insert into encokmesaj (username, uuid, mesajsayi, stamp) values ('$usernamee','$uuidd','1','$zaman')");
		}
		header('Location: '.$domain2.'forumdetay/'.$_REQUEST['p'].'/'.$_REQUEST['konu']);

}
?>	
	
  </div>
  <!-- LAYOUT CONTENT FULL -->
<?php include_once('footer.php'); ?>