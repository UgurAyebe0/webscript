<?php include_once('header.php'); ?>
<style>
  .banner-wrap.forum-banner {
    background: url("<?php echo $domain; ?>images/home-slide/galeri_9854494.jpg") no-repeat center,linear-gradient(45deg, #f30a5c, #1c95f3);
    background-size: auto, auto;
    background-size: cover;
  }
  @media screen and (max-width:700px){
   body{
    overflow-x:auto;
  }
}
</style>
<?php
if($_SESSION['username'] == NULL){
	header('Location:'.$domain2);
}
$kredi = $kpanel->prepare("select * from Kullanicilar where (uuid = :uuid)");
$result = $kredi->execute(array(":uuid" => $_SESSION["uuid"]));
$kredi  = $kredi->fetch(PDO::FETCH_ASSOC);

$alinanurun = $kpanel->prepare("select count(*) from UrunLog where (KullaniciId = :KullaniciId)");
$result = $alinanurun->execute(array(":KullaniciId" => $_SESSION["kid"]));
$alinanurun  = $alinanurun->fetchColumn();

$benn = $bungeecord->prepare("select * from fr_players where (player_uuid = :player_uuid)");
$result = $benn->execute(array(":player_uuid" => $_SESSION['uuid']));
$benn  = $benn->fetch(PDO::FETCH_ASSOC);

$arksayi = $bungeecord->prepare("select count(*) from fr_friend_assignment where (friend1_id = :friend1_id)");
$result = $arksayi->execute(array(":friend1_id" => $benn['player_id']));
$arksayi  = $arksayi->fetchColumn();

$arksayi2 = $bungeecord->prepare("select count(*) from fr_friend_assignment where (friend2_id = :friend1_id)");
$result = $arksayi2->execute(array(":friend1_id" => $benn['player_id']));
$arksayi2  = $arksayi2->fetchColumn();

$arkadassayi = $arksayi + $arksayi2;

$grup = $yetkiler->prepare("select * from perm_playergroups where (playeruuid = :playeruuid) && (groupid != '16') && (groupid != '17') && (groupid != '18') order by groupid desc");
$result = $grup->execute(array(":playeruuid" => $_SESSION["uuid"]));
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

?>
<!-- BANNER WRAP -->
<div class="banner-wrap forum-banner">
  <!-- BANNER -->
  <div class="banner grid-limit">
    <h2 class="banner-title">Hesabım</h2>
    <p class="banner-sections">
      <span class="banner-section">Anasayfa</span>
      <!-- ARROW ICON -->
      <svg class="arrow-icon">
        <use xlink:href="#svg-arrow"></use>
      </svg>
      <!-- /ARROW ICON -->
      <span class="banner-section">Destek Merkezi</span>
    </p>
  </div>
  <!-- /BANNER -->
</div>
<?php
if($_SESSION['gonderildi'] != NULL){
	echo '<script>alert(\''.$_SESSION['gonderildi'].'\')</script>';
	$_SESSION['gonderildi'] = NULL;
}
?>
<!-- /BANNER WRAP -->
<?php include_once('slidenews.php'); ?>

<div class="layout-content-4 layout-item-1-3 grid-limit">
  <div class="layout-sidebar">
    <div class="account-info-wrap">
      <img class="user-avatar big" src="https://cravatar.eu/avatar/<?php echo $_SESSION['username']; ?>" alt="<?php echo $_SESSION['username']; ?>">
      <p class="account-info-username" style="text-transform:none;"><?php echo $_SESSION['username']; ?></p>
      <p class="account-info-name"><span class="tag-ornament" style="vertical-align:middle;margin-top: 0px;margin-left: 5px;background:<?php echo $renk; ?>;"><?php echo $grupadi['name']; ?></span></p>
      <div class="account-info-stats">
        <?php 
        if($kredi['Kredi'] != NULL){
          $kredim = $kredi['Kredi']; 
        }else{
          $kredim = '0'; 
        }
        
        $timebilgi = strtotime($kredi['kayittarihi']);
        $songorulme = $bungeecord->prepare("select * from fr_players where (player_uuid = '".$_SESSION['uuid']."')");
        $result = $songorulme->execute();
        $songorulme   = $songorulme->fetch(PDO::FETCH_ASSOC);
        $song = strtotime($songorulme['last_online']);	
        ?>
        <div class="account-info-stat">
          <p class="account-info-stat-value"><?php echo $kredim.' <a href="'.$domain.'krediyukle" title="Kredi Yükle"><img src="'.$domain.'images/plus.png" width="10px" style="margin-bottom:3px;"></a>'; ?></p>
          <p class="account-info-stat-title">Toplam Kredin</p>
        </div>
        <div class="account-info-stat">
          <p class="account-info-stat-value"><?php echo $alinanurun; ?></p>
          <p class="account-info-stat-title">ALINAN ÜRÜN</p>
        </div>
        <div class="account-info-stat">
          <p class="account-info-stat-value"><?php echo $arkadassayi; ?></p>
          <p class="account-info-stat-title">ARKADAŞ SAYISI</p>
        </div>
      </div>
      
      <div class="account-info-stats">
        <div class="account-info-stat">
          <p class="account-info-stat-title"><b>Kayıt:</b> <?php echo date("d.m.Y ",$timebilgi).' '; ?></p>
        </div>
        <div class="account-info-stat">
          <p class="account-info-stat-title"><b>Son Görülme:</b> <?php echo date("d.m.Y ",$song); ?></p>
        </div>
      </div>

      <ul class="dropdown-list void">
        <li class="dropdown-list-item">
          <a href="<?php echo $domain2; ?>durumum" class="dropdown-list-item-link">Durumum</a>
        </li>
        <li class="dropdown-list-item">
          <a href="<?php echo $domain2; ?>panel" class="dropdown-list-item-link">Son Aktiviteler</a>
        </li>
        <li class="dropdown-list-item">
          <a href="<?php echo $domain2; ?>gecmis" class="dropdown-list-item-link">Geçmiş</a>
        </li>
        <li class="dropdown-list-item">
          <a href="<?php echo $domain2; ?>profil_ayarlarim" class="dropdown-list-item-link">Profil Ayarlarım</a>
        </li>
        <li class="dropdown-list-item">
          <a href="<?php echo $domain2; ?>arkadaslarim" class="dropdown-list-item-link">Arkadaşlarım</a>
        </li>
        <li class="dropdown-list-item">
          <a href="<?php echo $domain2; ?>mesajlarim" class="dropdown-list-item-link">Mesajlarım</a>
        </li>
        <li class="dropdown-list-item active">
          <a href="<?php echo $domain2; ?>destekmerkezi" class="dropdown-list-item-link">Destek Taleplerim</a>
        </li>
        <li class="dropdown-list-item">
          <a href="<?php echo $domain2; ?>videolarim" class="dropdown-list-item-link">Videolarım</a>
        </li>
      </ul>
    </div>
  </div>

  <div class="layout-body">
    <!-- SECTION TITLE WRAP -->
    <div class="section-title-wrap blue">
      <h2 class="section-title medium">Destek Merkezi</h2>
      <div class="section-title-separator"></div>
    </div>
    <!-- /SECTION TITLE WRAP -->
    <div class="col-md-12">
      <div class="filters-row">
        <div class="option-list">
          <a href="<?php echo $domain2.'destekmerkezi'; ?>"><p class="option-list-item">Tüm Taleplerim</p></a>
          <a href="<?php echo $domain2.'talepolustur'; ?>"><p class="option-list-item selected">Yeni Talep</p></a>
        </div>
      </div>
      <?php
      $departmanlar = $db->query("select * from ticketkategori order by sira asc");
      ?>
      <form method="POST">
        <div class="form-row">
          <div class="form-item blue">
           <label for="eski" class="rl-label">Konu Belirtiniz</label>
           <input type="text" placeholder="Konu Belirtiniz" name="konu" required>
         </div> 
       </div>
       <div class="form-row">
        <div class="form-item blue">
         <label for="eski" class="rl-label">Departman</label>
         <select name="departman">
          <option value="Genel">Lütfen Departman Seçiniz</option>
          <?php 
          foreach($departmanlar as $depart){
            echo '<option value="'.$depart['departman'].'">'.$depart['departman'].'</option>';
          }

          ?>

        </select>
      </div> 
    </div>
    <div class="form-row">
      <div class="form-item blue">
       <label for="eski" class="rl-label">Mesajınız</label>
       <textarea class="top ckeditor" placeholder="Mesajınız" name="mesaj" rows="5" required></textarea>
     </div> 
   </div>

   <button onclick = "this.form.submit();" class="button blue" name="mesajikaydet" style="margin-top:10px;">Talep Oluştur
     <span class="button-ornament">
       <svg class="arrow-icon medium">
        <use xlink:href="#svg-arrow-medium"></use>
      </svg>

      <svg class="cross-icon small">
        <use xlink:href="#svg-cross-small"></use>
      </svg>
    </span>
  </button>
</form>
<?php
if($_POST['konu'] != ''){
	
  $kontroll = $db->prepare("select * from destekmerkezi where (username = :username) order by stamp desc limit 1");
  $result = $kontroll->execute(array(":username" => $_SESSION['username']));
  $kontrol   = $kontroll->fetch(PDO::FETCH_ASSOC);
  
  $zamankontrol = time() - $kontrol['stamp'];  
  if($zamankontrol >= 90 ){
   $destekid = uniqid();
   $username = $kredi['username'];
   $departman = $_POST['departman'];
   $icerik = $_POST['mesaj'];
   $stamp = time();
   $durum = 'Bekliyor';
   $yayin = '1'; 
   $konu = $_POST['konu']; 
   $admin = '0';
   $kapali = '0';
   
   $db->query("insert into destekmerkezi (username, konu, departman, durum, stamp, icerik, destekid, yayin, admin, kapali) values ('$username', '$konu', '$departman', '$durum', '$stamp', '$icerik', '$destekid', '$yayin', '$admin', '$kapali') ");
   $_SESSION['gonderildi'] = 'Talebiniz başarıyla gönderilmiştir.En kısa sürede yanıtlanacaktır.';




// =============Discord Uyarı Sistemi==================
// Discord WebHook URL ilerde Başka Kanal için Değiştirilebilir
   $webhookurl = "https://discord.com/api/webhooks/785159888749199380/FuGP-2vKO2NglS9vgmFT8oceEKu9soHrgJqekLXpWML0W28Bvk6sEeOFmeJzC9M93C16";
//=====================================================


   $timestamp = date("c", strtotime("now"));
   $json_data = json_encode([
    "content" => "Merhaba, Yeni Bir Destek Talebi Mevcut İlgilenir misiniz? @everyone",
    "username" => "$username",
    "avatar_url" => "https://minotar.net/avatar/".$username,
    "tts" => false,
    "embeds" => [
      [
        "title" => "$konu",
        "type" => "rich",
        "description" => "",
        "url" => "https://www.candycraft.net/webpanel/destekcevap.php?id=".$destekid,
        "timestamp" => $timestamp,
        "color" => hexdec( "D400CA" ),
        "footer" => [
          "text" => "www.candycraft.net tarafından",
          "icon_url" => "https://i.hizliresim.com/GRiOga.png"
        ],
        "image" => [
          "url" => ""
        ],
        "author" => [
          "name" => "",
          "url" => ""
        ],
        "fields" => [
          [
            "name" => "Departman",
            "value" => "$departman",
            "inline" => true
          ]
        ]
      ]
    ]
  ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
   $ch = curl_init( $webhookurl );
   curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
   curl_setopt( $ch, CURLOPT_POST, 1);
   curl_setopt( $ch, CURLOPT_POSTFIELDS, $json_data);
   curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
   curl_setopt( $ch, CURLOPT_HEADER, 0);
   curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);
   $response = curl_exec( $ch );
   curl_close( $ch );
// ====================================================





   header('Location:'.$domain2.'talepolustur');	
 }else{
  echo '<script>alert(\'Yeni mesaj göndermeden önce 90sn beklemelisiniz\')</script>';
}
}
?>





</div>


</div>

</div>

<?php include_once('footer.php'); ?>