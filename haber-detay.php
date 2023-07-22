<?php
include_once('header.php');
$haberr = $db->prepare("select * from makaleler where (yayin = '1') && (urlkodu = :urlkodu)");
$result = $haberr->execute(array(":urlkodu" => $_REQUEST['p']));
$haberr   = $haberr->fetch(PDO::FETCH_ASSOC);

$kategorii = $db->prepare("select * from kategoriler where (id = :id)");
$result = $kategorii->execute(array(":id" => $haberr['kategori']));
$kategori   = $kategorii->fetch(PDO::FETCH_ASSOC);

if($haberr == NULL){
	header('Location:/');
}
if($_SESSION['haberyorum'] != NULL){
	echo '<script>alert(\''.$_SESSION['haberyorum'].'\')</script>';
	$_SESSION['haberyorum'] = NULL;
}
if($_SESSION['ip'] != NULL){
	$id = $haberr['id'];
	if($_SESSION['haber'] != $id){		
		$okunmaa = $haberr['okunma'] + 1;
		$arttir = $db->query("update makaleler set okunma = '".$okunmaa."' where (id = '".$id."') ");
		$_SESSION['ip'] = GetIP();		
	}
}
$_SESSION['haber'] = $id;
if($_SESSION['ip'] == NULL){
	$id = $haberr['id'];
	$_SESSION['ip'] = GetIP();
	
	$okunma = $haberr['okunma'] + 1;
	
	$arttir = $db->query("update makaleler set okunma = '".$okunma."' where (id = '".$id."') ");
	
}

?>
<style>
iframe{
	max-width:98% !important; 
}
.banner-wrap.gaming-news {
    background: url("<?php echo $domain; ?>images/home-slide/galeri_9854494.jpg") no-repeat center,linear-gradient(45deg, #f30a5c, #1c95f3);
    background-size: auto, auto;
    background-size: cover;
}
</style>
  <!-- BANNER WRAP -->
  <div class="banner-wrap gaming-news">
    <!-- BANNER -->
    <div class="banner grid-limit">
      <h2 class="banner-title"><?php echo $haberr['baslik']; ?></h2>
      <p class="banner-sections">
        <span class="banner-section">Anasayfa</span>
        <!-- ARROW ICON -->
        <svg class="arrow-icon">
          <use xlink:href="#svg-arrow"></use>
        </svg>
        <!-- /ARROW ICON -->
        <span class="banner-section"><?php echo $haberr['baslik']; ?></span>
      </p>
    </div>
    <!-- /BANNER -->
  </div>
  <!-- /BANNER WRAP -->

  <!-- LIVE NEWS WIDGET WRAP -->
<?php include_once('slidenews.php'); ?>
  <!-- /LIVE NEWS WIDGET WRAP -->

  <!-- LAYOUT CONTENT 1 -->
  <div class="layout-content-1 layout-item-3-1 grid-limit">
    <!-- LAYOUT BODY -->
    <div class="layout-body">
      <!-- LAYOUT ITEM -->
      <div class="layout-item gutter-big">
        <!-- POST PREVIEW -->
        <div class="post-preview large gaming-news">
          <!-- POST PREVIEW IMG WRAP -->
  
            <div class="post-preview-img-wrap">
<?php echo $haberr['icerik']; ?>


            </div>
  
          <!-- /POST PREVIEW IMG WRAP -->
    
         
    
          <!-- POST PREVIEW TITLE -->
          
          <!-- POST AUTHOR INFO -->
<?php 

	echo '<div class="post-author-info-wrap">';

		echo '<a href="'.$domain2.'profil/'.$haberr['yazar'].'">';
		  echo '<figure class="user-avatar tiny liquid">';
			echo '<img src="https://cravatar.eu/avatar/'.$haberr['yazar'].'" alt="'.$haberr['yazar'].'">';
		  echo '</figure>';
		echo '</a>';

		echo '<p class="post-author-info small light">Yazar <a href="javascript:void();" class="post-author">'.$haberr['yazar'].'</a><span class="separator">|</span>'.date("d.m.y H:i",$haberr['stamp']).'<span class="separator">|</span><a href="javascript:void();" class="post-comment-count">'.$haberr['okunma'].' Görüntülenme</a></p>';
	echo '</div>';
	
	
	
?>

        </div>
        <!-- /POST PREVIEW -->
<?php
$yorumsayi = $db->prepare("select count(*) from haberyorum where (haber = :haber) && (yayin = '1')");
$result = $yorumsayi->execute(array(":haber" => $haberr['id']));
$yorumsayi   = $yorumsayi->fetchColumn();
$yorumlar = $db->query("select * from haberyorum where (haber = ".$haberr['id'].") && (yayin = '1') order by stamp desc");
?>
        <!--<div class="post-comment-form-wrap">
          <div class="section-title-wrap blue">
            <h2 class="section-title medium">Yorumlar</h2>
            <div class="section-title-separator"></div>
          </div>

        </div>-->

        <div id="yorumlar" class="post-comment-thread">
          <div class="section-title-wrap blue">
            <h2 class="section-title medium">(<?php echo $yorumsayi; ?>) Yorum</h2>
            <div class="section-title-separator"></div>
          </div>
<?php
foreach($yorumlar as $yorum){
$mesajyazannn = $kpanel->prepare("select * from Kullanicilar where (username = '".$yorum['username']."')");
$result = $mesajyazannn->execute();
$mesajyazannn  = $mesajyazannn->fetch(PDO::FETCH_ASSOC);

$gruppp = $yetkiler->prepare("select * from perm_playergroups where (playeruuid = '".$mesajyazannn["uuid"]."') && (groupid != '16') && (groupid != '17') && (groupid != '18') order by groupid desc");
$result = $gruppp->execute();
$gruppp  = $gruppp->fetch(PDO::FETCH_ASSOC);

$grupadiii = $yetkiler->prepare("select * from perm_groups where (id = '".$gruppp['groupid']."')");
$result = $grupadiii->execute();
$grupadiii  = $grupadiii->fetch(PDO::FETCH_ASSOC);
if($grupadiii['name'] == NULL){$grupadiii['name'] = 'Oyuncu';}
if($grupadiii['id'] == '6' or $grupadiii['id'] == NULL){
	$renkkk = '#5555FF';

}elseif($grupadiii['id'] == '15'){
	$renkkk = '#AA0000';
}elseif($grupadiii['id'] == '7'){
	$renkkk = '#55FFFF';
}elseif($grupadiii['id'] == '8'){
	$renkkk = '#00AAAA';
}elseif($grupadiii['id'] == '9'){
	$renkkk = '#00AA00';
}elseif($grupadiii['id'] == '10'){
	$renkkk = '#AA00AA';
}elseif($grupadiii['id'] == '11'){
	$renkkk = '#55FF55';
}elseif($grupadiii['id'] == '12'){
	$renkkk = '#FF55FF';
}elseif($grupadiii['id'] == '13'){
	$renkkk = '#FFAA00';
}elseif($grupadiii['id'] == '14'){
	$renkkk = '#AA0000';
}		

	echo '<div class="post-comment">';
		echo '<figure class="user-avatar medium liquid">';
		  echo '<img src="https://cravatar.eu/avatar/'.$yorum['username'].'" alt="user-09">';
		echo '</figure>';
		echo '<p class="post-comment-username" style="text-transform:none;"><a href="'.$domain2.'profil/'.$yorum['username'].'" style="color:'.$renkkk.'">'.$yorum['username'].' <span class="tag-ornament" style="vertical-align:middle;background:'.$renkkk.';">'.$grupadiii['name'].'</span></a> </p>';
		echo '<p class="post-comment-timestamp">'.date("d.m.y H:i",$yorum['stamp']).'</p>';
		#echo '<a href="#" class="report-button">Report</a>';
		echo '<p class="post-comment-text">'.$yorum['yorum'].'</p>';
	echo '</div>';
}
?>
          
        </div>
		
<?php
$kullanici = $kpanel->prepare("select * from Kullanicilar where (username = '".$_SESSION['username']."')");
$result = $kullanici->execute();
$kullanici  = $kullanici->fetch(PDO::FETCH_ASSOC);
if($_SESSION["login"] != "true"){
	echo '<p class="alert alert-warning text-center" style="margin-top:50px;">Yorum yapmak için giriş yapınız.</p>';
?>
          
<?php 
}elseif($kullanici['yasakli'] == '1'){
	echo '<p class="alert alert-warning text-center" style="margin-top:50px;">Yorum yapmak için yetkiniz bulunmamaktadır.</p>';
}else{
?>
<form method="POST" class="post-comment-form">
            <div class="form-row">
              <div class="form-item blue">
                <label for="pcf_comment" class="rl-label">Yorum Ekle</label>
                <textarea name="message" id="pcf_comment" class="violet" placeholder="Yorumunuzu buraya yazınız..."></textarea>
              </div>
            </div>
            <div class="submit-button-wrap right">
              <button class="submit-button button blue">
                Gönder
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
          </form>
<?php	
}
?>		
<?php
if(isset($_POST['message'])){
	$kontroll = $db->prepare("select * from haberyorum where (username = :username) order by stamp desc limit 1");
	$result = $kontroll->execute(array(":username" => $_SESSION['username']));
	$kontrol   = $kontroll->fetch(PDO::FETCH_ASSOC);
	
	$zamankontrol = time() - $kontrol['stamp'];  
	if($zamankontrol >= 180 ){
		$time = time();
		$message = piril($_POST['message']);
		$videoid = $haberr['id'];
		$uuid = $_SESSION['uuid'];
		$username =  $_SESSION['username'];
		
		$db->query("insert into haberyorum (username, haber, yorum, yayin, stamp, uuid) values ('$username', '$videoid', '$message', '1', '$time', '$uuid')");
		

		
		#$_SESSION['haberyorum'] = 'Yorumunuz başarıyla alınmıştır. Editör onayından sonra yayına alınacaktır. Teşekkür ederiz';
		header('Location: '.$domain2.'haber/'.$_REQUEST['p'].'#yorumlar');
	}else{
		echo '<script>alert(\'Yeni yorum yapmadan önce 180sn beklemelisiniz\')</script>';
	}
}
?>		
      </div>
	  
<div class="layout-item padded own-grid">
        <div class="section-title-wrap yellow">
          <h2 class="section-title medium">Son Yüklenen Videolar</h2>
          <div class="section-title-separator"></div>
          <div id="gknews-slider1-controls" class="carousel-controls slider-controls yellow">
            <div class="slider-control control-previous">
              <svg class="arrow-icon medium">
                <use xlink:href="#svg-arrow-medium"></use>
              </svg>
            </div>
            <div class="slider-control control-next">
              <svg class="arrow-icon medium">
                <use xlink:href="#svg-arrow-medium"></use>
              </svg>
            </div>
          </div>
        </div>
        <div id="gknews-slider1" class="carousel">
          <div class="carousel-items">
<?php
$sonvideolar = $db->query("select * from youtube where (yayin = '1') && (vitrin = '1') order by stamp desc limit 12");
$sonvideolar->execute();
$sonvideolar = $sonvideolar->fetchAll();
foreach($sonvideolar as $svideo){
	echo '<div class="post-preview geeky-news">';
	  echo '<a href="'.$domain2.'video/'.$svideo['urlkodu'].'">';
		echo '<div class="post-preview-img-wrap">';
		  echo '<figure class="post-preview-img liquid">';
			echo '<img src="'.$domain.'images/blog/'.$svideo['kapak'].'" alt="post-02">';
		  echo '</figure>';
		echo '</div>';
	  echo '</a>';
	  echo '<a href="'.$domain2.'video/'.$svideo['urlkodu'].'" class="tag-ornament" style="text-transform:none;">'.$svideo['yukleyen'].'</a>';
	  echo '<a href="'.$domain2.'video/'.$svideo['urlkodu'].'" class="post-preview-title">'.$svideo['baslik'].'</a>';
	  echo '<div class="post-author-info-wrap">';
	if($svideo['yukleyen'] == 'CandyCraft'){
		echo '<p class="post-author-info small light">Yükleyen <a href="'.$domain.'" class="post-author">'.$svideo['yukleyen'].'</a><span class="separator">|</span>'.date("d.m.y H:i",$svideo['stamp']).'</p>';
	}else{
		echo '<p class="post-author-info small light">Yükleyen <a href="'.$domain2.'profil/'.$svideo['yukleyen'].'" class="post-author">'.$svideo['yukleyen'].'</a><span class="separator">|</span>'.date("d.m.y H:i",$svideo['stamp']).'</p>';
	}  
		
	  echo '</div>';
	echo '</div>';
}
?>
 
          </div>
        </div>
      </div>
      <div class="layout-item padded own-grid">
 
        <div class="section-title-wrap violet">
          <h2 class="section-title medium">Popüler Videolar</h2>
          <div class="section-title-separator"></div>

          <div id="esnews-slider1-controls" class="carousel-controls slider-controls violet">
            <div class="slider-control control-previous">

              <svg class="arrow-icon medium">
                <use xlink:href="#svg-arrow-medium"></use>
              </svg>
    
            </div>
            <div class="slider-control control-next">

              <svg class="arrow-icon medium">
                <use xlink:href="#svg-arrow-medium"></use>
              </svg>
  
            </div>
          </div>

        </div>

        <div id="esnews-slider1" class="carousel">

          <div class="carousel-items">

<?php
$populervideolar = $db->query("select * from youtube where (yayin = '1') && (vitrin = '1') order by izlenme desc limit 12");
$populervideolar->execute();
$populervideolar = $populervideolar->fetchAll();
foreach($populervideolar as $pvideo){
	echo '<div class="post-preview geeky-news">';
	  echo '<a href="'.$domain2.'video/'.$pvideo['urlkodu'].'">';
		echo '<div class="post-preview-img-wrap">';
		  echo '<figure class="post-preview-img liquid">';
			echo '<img src="'.$domain.'images/blog/'.$pvideo['kapak'].'" alt="post-02">';
		  echo '</figure>';
		echo '</div>';
	  echo '</a>';
	  echo '<a href="'.$domain2.'video/'.$pvideo['urlkodu'].'" class="tag-ornament" style="text-transform:none;">'.$pvideo['yukleyen'].'</a>';
	  echo '<a href="'.$domain2.'video/'.$pvideo['urlkodu'].'" class="post-preview-title">'.$pvideo['baslik'].'</a>';
	  echo '<div class="post-author-info-wrap">';
	if($pvideo['yukleyen'] == 'CandyCraft'){
		echo '<p class="post-author-info small light">Yükleyen <a href="'.$domain.'" class="post-author">'.$pvideo['yukleyen'].'</a><span class="separator">|</span>'.date("d.m.y H:i",$pvideo['stamp']).'</p>';
	}else{
		echo '<p class="post-author-info small light">Yükleyen <a href="'.$domain2.'profil/'.$pvideo['yukleyen'].'" class="post-author">'.$pvideo['yukleyen'].'</a><span class="separator">|</span>'.date("d.m.y H:i",$pvideo['stamp']).'</p>';
	}  
		
	  echo '</div>';
	echo '</div>';
}
?>
          </div>
        </div>
      </div>	  
	  
	  
    </div>
<?php include_once('sidebarhaber.php'); ?>
  </div>
<?php include_once('footer.php'); ?>