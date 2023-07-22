<?php
include_once('header.php');
$oyun = $db->prepare("select * from oyunlar where (url = :url)");
$result = $oyun->execute(array(":url" => $_REQUEST["p"]));
$oyun  = $oyun->fetch(PDO::FETCH_ASSOC);

if($_SESSION['haberyorum'] != NULL){
	echo '<script>alert(\''.$_SESSION['haberyorum'].'\')</script>';
	$_SESSION['haberyorum'] = NULL;
}
?>
<style>

.banner-wrap.gaming-news {
    background: url("<?php echo $domain; ?>images/blog/<?php echo $oyun['arkaplan']; ?>") no-repeat center,linear-gradient(45deg, #f30a5c, #1c95f3);
    background-size: auto, auto;
    background-size: cover;
}
</style>
  <!-- BANNER WRAP -->
  <div class="banner-wrap gaming-news">
    <!-- BANNER -->
    <div class="banner grid-limit">
      <h2 class="banner-title"><?php echo $oyun['baslik']; ?></h2>
      <p class="banner-sections">
        <span class="banner-section">Anasayfa</span>
        <!-- ARROW ICON -->
        <svg class="arrow-icon">
          <use xlink:href="#svg-arrow"></use>
        </svg>
        <!-- /ARROW ICON -->
		<span class="banner-section">Oyunlar</span>
        <!-- ARROW ICON -->
        <svg class="arrow-icon">
          <use xlink:href="#svg-arrow"></use>
        </svg>
        <!-- /ARROW ICON -->
        <span class="banner-section"><?php echo $oyun['baslik']; ?></span>
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

          <p class="post-preview-text" style="width:100%;"><?php echo $oyun['kisa_aciklama']; ?></p>
          <p class="post-preview-text" style="width:100%;"><?php echo $oyun['aciklama']; ?></p>
        </div>
        <!-- /POST PREVIEW -->
<?php
$yorumsayi = $db->prepare("select count(*) from oyunyorum where (haber = :haber) && (yayin = '1')");
$result = $yorumsayi->execute(array(":haber" => $oyun['id']));
$yorumsayi   = $yorumsayi->fetchColumn();
$yorumlar = $db->query("select * from oyunyorum where (haber = ".$oyun['id'].") && (yayin = '1') order by stamp desc");
?>
        <!--<div class="post-comment-form-wrap">
          <div class="section-title-wrap blue">
            <h2 class="section-title medium">Yorumlar</h2>
            <div class="section-title-separator"></div>
          </div>

        </div>-->

        <div id="op-comments" class="post-comment-thread">
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
		echo '<p class="post-comment-text">'.strip_tags($yorum['yorum']).'</p>';
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
if($_POST['message'] != ''){
	$kontroll = $db->prepare("select * from oyunyorum where (username = :username) order by stamp desc limit 1");
	$result = $kontroll->execute(array(":username" => $_SESSION['username']));
	$kontrol   = $kontroll->fetch(PDO::FETCH_ASSOC);
	
	$zamankontrol = time() - $kontrol['stamp'];  
	if($zamankontrol >= 180 ){
		$time = time();
		$message = $_POST['message'];
		$haberid = $oyun['id'];
		$uuid = $_SESSION['uuid'];
		$username =  $_SESSION['username'];
		
		$db->query("insert into oyunyorum (username, haber, yorum, yayin, stamp, uuid) values ('$username', '$haberid', '$message', '1', '$time', '$uuid')");
		

		
		$_SESSION['haberyorum'] = 'Yorumunuz başarıyla alınmıştır. Editör onayından sonra yayına alınacaktır. Teşekkür ederiz';
		header('Location: '.$domain2.'oyundetay/'.$_REQUEST['p']);
	}else{
		echo '<script>alert(\'Yeni yorum yapmadan önce 180sn beklemelisiniz\')</script>';
	}
}
?>

		
		
      </div>
	  

     	  
	  
	  
    </div>
<?php include_once('oyunsidebar.php'); ?>
  </div>
<?php include_once('footer.php'); ?>