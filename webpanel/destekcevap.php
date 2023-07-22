<?php 
include_once('header2.php');
$yeniurunm = '';
$anasayfam = '';
$urunlerm = '';
$yenikategorim = '';
$kategorilerm = '';
$sayfaeklem = '';
$sayfalarm = '';
$destekmerkezim = 'active';
$talep = $db->prepare("select * from destekmerkezi where (destekid = '".$_REQUEST["id"]."') order by stamp desc limit 1");
$result = $talep->execute();
$talep  = $talep->fetch(PDO::FETCH_ASSOC);
$talepler = $db->query("select * from destekmerkezi where (destekid = '".$_REQUEST['id']."') order by stamp asc");


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
<style>
.deneme img{
	max-width:100%;
	height:auto !important;
}
img{
	max-width:100% !important;
}
</style>
<script>
	
$.fn.dataTable.ext.errMode = 'none';
</script>
	<!-- Page container -->
	<div class="page-container">
		<!-- Page content -->
		<div class="page-content">
			<?php include_once('aside.php'); ?>
			<!-- Main content -->
			<div class="content-wrapper">
				<!-- Page header -->
				<div class="page-header page-header-default">
					<div class="page-header-content">
						<div class="page-title">
							<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Destek Merkezi <span> - Destek Cevapla</h4>
						</div>


					</div>

					<div class="breadcrumb-line">
						<ul class="breadcrumb">
							<li><a href="/webpanel/"><i class="icon-home2 position-left"></i> Anasayfa</a></li>
							<li class="active">Destek Cevapla</li>
						</ul>

					</div>
				</div>
				<!-- /page header -->
				<!-- Content area -->
				<div class="content">

					<!-- ürünler -->
					<div class="panel panel-flat">
						<?php 
						if($_SESSION['gonderildii'] != ''){
							echo '<div class="alert alert-success" role="alert">'.$_SESSION['gonderildii'].'</div>';
							$_SESSION['gonderildii'] = '';
						}
						
						?>		
						<div class="panel-heading">
							<h5 class="panel-title"><i class="fa fa-th-list"></i> <?php echo $talep['konu']; ?> - <?php echo $_REQUEST['id']; ?> </h5><p><span class="label label-warning" style="font-size:12px;"> Durum: <?php echo $talep['durum']; ?></span></p>
							<div class="heading-elements">

		                	</div>
						</div>
<div class="col-md-12">
                 
<div class="col-md-12" style="padding-top:20px;padding-bottom:20px;border-bottom:1px solid #ddd;">


</div>
							
                            
                        
<?php

foreach($talepler as $tal){
echo '<div class="col-md-12" style="padding-bottom:20px;padding-top:20px;border-bottom:1px solid #ddd;">';
	echo '<div class="col-md-3" style="">';
if($tal['admin'] == '0'){
$mesajyazan = $kpanel->prepare("select * from Kullanicilar where (username = '".$tal['username']."')");
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

	echo '<a href="'.$domain.'profile.php?p='.$tal['username'].'" style="text-decoration:none;" target="_blank"> <img alt="" src="https://minepic.org/avatar/'.$tal['username'].'" height="15" width="15" style="margin-right: 5px;margin-top: -3px;"> '.$tal['username'].'</a>';
	echo '<span class="label" style="font-size:12px;vertical-align:middle;position: absolute;margin-top: 0px;margin-left: 5px;background:'.$renk.';transform: skew(-7deg);border-radius:0px;">'.$grupadi['name'].'</span>';
}else{
	
$oyuncu = $kpanel->prepare("select * from Kullanicilar where (username = :username)");
$result = $oyuncu->execute(array(":username" => $tal["yetkili"]));
$oyuncu  = $oyuncu->fetch(PDO::FETCH_ASSOC);
$grup = $yetkiler->prepare("select * from perm_playergroups where (playeruuid = :playeruuid) && (groupid != '16') && (groupid != '17') && (groupid != '18') order by groupid desc");
$result = $grup->execute(array(":playeruuid" => $oyuncu["uuid"]));
$grup  = $grup->fetch(PDO::FETCH_ASSOC);

$grupadi = $yetkiler->prepare("select * from perm_groups where (id = :id)");
$result = $grupadi->execute(array(":id" => $grup['groupid']));
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
	echo '<a href="'.$domain.'profile.php?p='.$tal['yetkili'].'" style="text-decoration:none;" target="_blank"> <img alt="" src="https://minepic.org/avatar/'.$tal['yetkili'].'" height="15" width="15" style="margin-right: 5px;margin-top: -3px;"> '.$tal['yetkili'].'</a>';
	echo '<span class="label" style="font-size:12px;vertical-align:middle;position: absolute;margin-top: 0px;margin-left: 5px;background:'.$renk.';transform: skew(-7deg);border-radius:0px;">'.$grupadi['name'].'</span>';
}		
	echo '</div>';
	echo '<div class="col-md-7 deneme" style="">';
$veri = $tal['icerik'];
#$veri = preg_replace(
 # '#((https?|ftp)://(\S*?\.\S*?))([\s)\[\]{},;"\':<]|\.com|$)#i',
 # "'<a href=\"$1\" target=\"_blank\"> $3 </a> $4'",
 # $talicerik
#);

#$veri = str_replace("<'br />","<br>",$veri);
#$veri = str_replace("'","",$veri);				
echo linkify($veri);			

		
	   
	echo '</div>';
	echo '<div class="col-md-2 text-right">';
	echo '<i class="fa fa-calendar"></i> '.date("d.m.y H:i", $tal['stamp']);
	echo '</div>';
	echo '</div>';
}

?>

                   

            </div>
			
<div class="col-md-12" style="margin-top:40px;">
<?php
if($talep['durum'] != 'Kapatıldı'){
?>

                 <form method="POST" class="comment-form">
                    <div class="comment-cont clearfix">
                        
                       <h5>Yanıt Gönder</h5>
                        <div style="margin-top:20px;">
							<textarea class="form-control ckeditor" placeholder="Yanıtınız" name="mesaj" rows="5" required></textarea>
						</div>
                        <button onclick = "this.form.submit();" class="btn btn-success btn-sm pull-right" style="min-width:150px;margin-top:10px;">Gönder</button>
                    </div>
                </form>
<?php
if($_POST['mesaj'] != NULL){
	$username = $talep['username'];
	$konu = $talep['konu'];
	$departman = $talep['departman'];
	$durum = 'Cevaplandı';
	$stamp = time();
	$icerik = $_POST['mesaj'];
	$destekid = $_REQUEST['id'];
	$yayin = '1';
	$admin = '1';
	$kapali = '0';
	$yetkili = $_SESSION['yonetici'];
	
	
	$db->query("insert into destekmerkezi (username, konu, departman, durum, stamp, icerik, destekid, yayin, admin, yetkili, kapali) values ('$username', '$konu', '$departman', '$durum', '$stamp', '$icerik', '$destekid', '$yayin', '$admin', '$yetkili', '$kapali') ");
	
	$db->query("update destekmerkezi set durum = 'Cevaplandı' where (destekid = '".$_REQUEST['id']."')");
	
	$_SESSION['gonderildii'] = 'Cevap Başarıyla Kaydedilmiştir.';
	
	header('Location:'.$domain.'webpanel/destekcevap.php?id='.$_REQUEST['id']);	
	
}
?>

<form method="POST" class="comment-form">
	<div class="comment-cont clearfix">		
	   <h5>Destek Talebini Kapat</h5><hr>
	   <input name="kapat" class="hidden" value="1">
		<button onclick = "this.form.submit();" class="btn btn-danger btn-sm pull-left" style="min-width:150px;margin-top:10px;">Kapat</button>
	</div><hr>
</form>

<?php
if($_POST['kapat'] == '1'){
	$db->query("update destekmerkezi set kapali = '1', durum = 'Kapatıldı' where (destekid = '".$_REQUEST['id']."')");
	$_SESSION['gonderildii'] = 'Destek Talebi Kapatılmıştır.';	
	header('Location:'.$domain.'webpanel/destekcevap.php?id='.$_REQUEST['id']);		
}
}else{
	echo '<form method="POST" class="comment-form">';
		echo '<div class="comment-cont clearfix">	';	
		   echo '<h5>Destek Talebini Kapat</h5><hr>';
		   echo '<input name="kapat" class="hidden" value="0">';
			echo '<button onclick = "this.form.submit();" class="btn btn-success btn-sm pull-left" style="min-width:150px;margin-top:10px;">Tekrar Aç</button>';
		echo '</div><hr>';
	echo '</form>';
	
	if($_POST['kapat'] == '0'){
	$db->query("update destekmerkezi set kapali = '0', durum = 'Cevaplandı' where (destekid = '".$_REQUEST['id']."')");
	$_SESSION['gonderildii'] = 'Destek Talebi Açılmıştır.';	
	header('Location:'.$domain.'webpanel/destekcevap.php?id='.$_REQUEST['id']);		
}
	
}
?>

            </div>

					</div>
					<!-- /urunler -->
					<?php include_once('footer.php'); ?>
				</div>
				<!-- /content area -->
			</div>
			<!-- /main content -->
		</div>
		<!-- /page content -->
	</div>
	<!-- /page container -->
<script>
function sayfasil() {
return	confirm("Seçtiğiniz destek talebi sistemden tamamen silinecektir, onaylıyor musunuz?");
}
</script>
</body>
</html>