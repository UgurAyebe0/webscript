<div class="layout-sidebar layout-item gutter-medium">

      <div class="widget-sidebar">

        <form method="GET" class="sidebar-search-form" action="<?php echo $domain2; ?>habersonuc">

          <div class="submit-input full blue">

		  

            <input type="text" id="sidebar-search1" name="ara" placeholder="Haberlerde Ara...">

            <button class="submit-input-button">

              <svg class="search-icon small">

                <use xlink:href="#svg-search"></use>

              </svg>

            </button>

          </div>

        </form>

      </div>





      <div class="widget-sidebar">

        <div class="section-title-wrap violet small-space">

          <h2 class="section-title medium" style="margin-top: 0px;">Kategoriler</h2>

          <div class="section-title-separator"></div>

        </div>

<?php

$haberkategoriler = $db->query("select * from kategoriler");

foreach($haberkategoriler as $haberkat){

	if($kategori['kategorikodu'] == $haberkat['kategorikodu'] and $_REQUEST['p'] != ''){

		$ystyle = ' color: #fff;font-weight: 700;background-color: #1c95f3;border-color: #1c95f3;';

	}else{

		$ystyle= '';

	}

	echo '<a href="'.$domain2.'kategori/'.$haberkat['kategorikodu'].'" class="tag-item active" style="width:100%;height: 39px;line-height: 39px;margin-bottom: 10px;'.$ystyle.'">'.$haberkat['kategori_TR'].'</a>';

}

?>    

		



      </div>

      <div class="widget-sidebar">



        <div class="section-title-wrap violet small-space">

          <h2 class="section-title medium" style="margin-top: 0px;">Çok Okunanlar</h2>

          <div class="section-title-separator"></div>

        </div>

<div class="post-preview-showcase grid-1col centered gutter-medium">

		

<?php

$cokokunanlar = $db->query("select * from makaleler where (yayin = '1') order by okunma desc limit 5");

$ii = '0';

foreach($cokokunanlar as $cok){

	$ii++;

	echo '<div class="post-preview tiny padded gaming-news">';

		echo '<a href="'.$domain2.'haber/'.$cok['urlkodu'].'">';

		  echo '<div class="post-preview-img-wrap">';

			echo '<figure class="post-preview-img liquid">';

			  echo '<img src="'.$domain.'images/blog/'.$cok['gorsel'].'" alt="post-01">';

			echo '</figure>';

		  echo '</div>';

		echo '</a>';

		echo '<div class="bubble-ornament small black no-link">';

		  echo '<p class="bubble-ornament-info">0'.$ii.'</p>';

		echo '</div>';

		echo '<a href="'.$domain2.'haber/'.$cok['urlkodu'].'" class="post-preview-title">'.$cok['baslik'].'</a>';

		echo '<div class="post-author-info-wrap">';

		  echo '<p class="post-author-info small light">Yazar <a href="'.$domain2.'profil/'.$cok['yazar'].'" class="post-author">'.$cok['yazar'].'</a><span class="separator">|</span>'.date("d.m.y H:i",$cok['stamp']).'</p>';

		echo '</div>';

	echo '</div>';



}



?>



      </div>

      </div>



      <div class="widget-sidebar">

        <div class="section-title-wrap violet small-space">

          <h2 class="section-title medium" style="margin-top: 0px;">Son Kredi Yükleyenler</h2>

          <div class="section-title-separator"></div>

        </div>

        <div class="table standings" style="margin-bottom: 0px;">

          <div class="table-row-header">

            <div class="table-row-header-item position">

              <p class="table-row-header-title">Kullanıcı Adı</p>

            </div>

            <div class="table-row-header-item position">

              <p class="table-row-header-title">Miktar</p>

            </div>

            <div class="table-row-header-item">

              <p class="table-row-header-title">Ödeme</p>

            </div>



          </div>

          <div class="table-rows">

<?php

$krediloglar = $kpanel->query("select * from KrediYuklemeLog order by Tarih desc limit 5");

$krediloglar->execute();

$krediloglar = $krediloglar->fetchAll();



foreach($krediloglar as $log){



if($log['OdemeKanali'] == '1'){

	$odemeturu = '<i class="fa fa-mobile"></i>';

}elseif($log['OdemeKanali'] == '2'){

	$odemeturu = '<i class="fa fa-credit-card"></i>';

}elseif($log['OdemeKanali'] == '3'){

	$odemeturu = '<i class="fa fa-university"></i>';

}elseif($log['OdemeKanali'] == '6'){

	$odemeturu = 'Oxoyun Elektonik Kod';

}elseif($log['OdemeKanali'] == '9'){

	$odemeturu = 'Gpay E-Cüzdan';

}elseif($log['OdemeKanali'] == '11'){

	$odemeturu = '<i class="fa fa-credit-card"></i>';

}elseif($log['OdemeKanali'] == '12'){

	$odemeturu = '<i class="fa fa-credit-card"></i>';

}





 $sql = $kpanel->prepare("select * from Kullanicilar where (KullaniciId = :KullaniciId) limit 1;");

 $result = $sql->execute(array(":KullaniciId" => $log['KullaniciId']));

 $user   = $sql->fetch(PDO::FETCH_ASSOC);

 

 

$grup = $yetkiler->prepare("select * from perm_playergroups where (playeruuid = '".$user["uuid"]."') && (groupid != '16') && (groupid != '17') && (groupid != '18') order by groupid desc");

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





	echo '<div class="table-row">';

	  echo '<div class="table-row-item position">';

	   echo '<a href="'.$domain2.'profil/'.$user['username'].'" style="color:'.$renk.'">';

		echo '<div class="team-info-wrap">';

		  echo '<img class="team-logo small" src="https://cravatar.eu/avatar/'.$user['username'].'" alt="'.$user['username'].'">';

		  echo '<div class="team-info">';

			echo '<p class="team-name" style="text-transform:none;color:'.$renk.'">'.$user['username'].'</p>';

			echo '<p class="team-country">'.$grupadi['name'].'</p>';

		  echo '</div>';

		echo '</div>';

	  echo '</div>';  

	  echo '<div class="table-row-item">';

		echo '<p class="table-text bold">'.$log['VerilenTutar'].'</p>';

		

	  echo '</div>';

	  echo '<div class="table-row-item">';

		echo '<p class="table-text bold" style="font-size:0.8em;">'.$odemeturu.'</p>';

		

	  echo '</div>';

	  echo '</a>';

	echo '</div>';

	

	}



?>

          </div>

        </div>

      </div>



      <div class="widget-sidebar">

        <div class="section-title-wrap violet small-space">

          <h2 class="section-title medium" style="margin-top: 0px;">En Çok Kredi Yükleyenler</h2>

          <div class="section-title-separator"></div>

        </div>

        <div class="table standings" style="margin-bottom: 0px;">

          <div class="table-row-header">

            <div class="table-row-header-item position">

              <p class="table-row-header-title">Kullanıcı Adı</p>

            </div>

            <div class="table-row-header-item">

              <p class="table-row-header-title">Yüklenen</p>

            </div>

          </div>

          <div class="table-rows">

<?php

$host="87.248.157.101";

$kullaniciadi="candycra_site";

$sifre="pw9ND4pZXY4o@!";

$veritabaniadi="candycra_kpanel";



$baglanti = @mysql_connect($host, $kullaniciadi, $sifre);

$veritabani = @mysql_select_db($veritabaniadi);

$gun = date("Y-m-d 23:59:59", time());

$aybasi = date('Y-m-01 00:00:00',time());

$sql = "select KullaniciId, count(*)  as kredisayisi from KrediYuklemeLog where Tarih between '".$aybasi."' AND '".$gun."' group by KullaniciId order by sum(VerilenTutar) desc limit 5";



if($query = mysql_query($sql))

{

	while ($row = mysql_fetch_assoc($query))

	{

$oyuncu = $kpanel->prepare("select * from Kullanicilar where (KullaniciId = :KullaniciId)");

$result = $oyuncu->execute(array(":KullaniciId" => $row['KullaniciId']));

$oyuncu  = $oyuncu->fetch(PDO::FETCH_ASSOC);		



$krediler = $kpanel->query("select * from KrediYuklemeLog where (KullaniciId = '".$oyuncu['KullaniciId']."') && (Tarih between '".$aybasi."' AND '".$gun."')");	

$krediler->execute();

$krediler = $krediler->fetchAll();

$toplam = 0;	

foreach($krediler as $kre){

	$toplam += $kre['VerilenTutar'];

}

$grup = $yetkiler->prepare("select * from perm_playergroups where (playeruuid = '".$oyuncu["uuid"]."') && (groupid != '16') && (groupid != '17') && (groupid != '18') order by groupid desc");

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





	echo '<div class="table-row">';

	  echo '<div class="table-row-item position">';

	   echo '<a href="'.$domain2.'profil/'.$oyuncu['username'].'" style="color:'.$renk.'">';

		echo '<div class="team-info-wrap">';

		  echo '<img class="team-logo small" src="https://cravatar.eu/avatar/'.$oyuncu['username'].'" alt="'.$oyuncu['username'].'">';

		  echo '<div class="team-info">';

			echo '<p class="team-name" style="text-transform:none;color:'.$renk.'">'.$oyuncu['username'].'</p>';

			echo '<p class="team-country">'.$grupadi['name'].'</p>';

		  echo '</div>';

		echo '</div>';

	  echo '</div>';

	  echo '<div class="table-row-item">';

		echo '<p class="table-text bold">'.$toplam.'</p>';

		echo '</a>';

	  echo '</div>';

	echo '</div>';

	

	}

	echo '<div class="table-row">';

	  echo '<div class="table-row-item position">';

	echo '<div class="team-info-wrap">';

	echo '<p class="team-name" >Not: Tablo her ay sonunda sıfırlanır.<br>

1. ye 50 kredi, 2. ye 25 kredi, 3. ye 10 kredi ödülü verilir.</p>';

	echo '</div>';

	echo '</div>';

	echo '</div>';

}

?>

          </div>

        </div>

      </div>

    </div>