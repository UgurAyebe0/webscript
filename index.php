<?php
include_once('header.php');
include_once('slider.php');
include_once('slidenews.php');
?> 
<div class="layout-content-1 layout-item-3-1 search-pad grid-limit">
    <div class="layout-body layout-item centered">
      <div class="layout-item centered">
        <div class="postslide-wrap">
          <div id="postslide-1" class="postslide">
            <div class="news-preview slider-items">
<?php
$k = '0';
foreach($haberler as $haber){
	$k++;
if($k == '1'){$hstyle = "background-color: #1c95f3;";}
if($k == '2'){$hstyle = "background-color: #f30a5c;";}
if($k == '3'){$hstyle = "background-color: #ffb400;";}
if($k == '4'){$hstyle = "background-color: #1c95f3;";}
if($k == '5'){$hstyle = "background-color: #58d819;";}

	$metin = mb_substr(strip_tags($haber['icerik']),0,'150','utf-8').'...' ;
	$secilikat = $db->prepare("select * from kategoriler where (id = '".$haber['kategori']."')");
	$result = $secilikat->execute();
	$secilikat  = $secilikat->fetch(PDO::FETCH_ASSOC);
	echo '<div class="post-preview picture big '.$haber['urlkodu'].'">';
		echo '<a href="'.$domain2.'haber/'.$haber['urlkodu'].'">';
		  echo '<div class="post-preview-img-wrap">';
			echo '<figure class="post-preview-img liquid">';
			  echo '<img src="'.$domain.'images/blog/'.$haber['gorsel'].'" alt="post-07">';
			echo '</figure>';
			echo '<div class="post-preview-overlay">';
			  echo '<span class="tag-ornament" style="background-color: '.$secilikat['renk'].';">'.$secilikat['kategori_TR'].'</span>';
			  echo '<p class="post-preview-text"><i class="fa fa-calendar"></i> '.date("d.m.Y H:i",$haber['stamp']).' <i class="fa fa-edit "></i> '.$haber['yazar'].'</p>';
			  echo '<p class="post-preview-title">'.$haber['baslik'].'</p>';
			  echo '<p class="post-preview-text">'.$metin.'</p>';
			echo '</div>';
			echo '<div class="loading-line"></div>';
		  echo '</div>';
		echo '</a>';
	 echo '</div>';
	
}
?>
              
 
            </div>
            <div class="news-roster slider-roster">
<?php
$k = '0';
foreach($haberler as $haber){
$k++;
if($k == '1'){$hstyle = "background-color: #1c95f3;";}
if($k == '2'){$hstyle = "background-color: #f30a5c;";}
if($k == '3'){$hstyle = "background-color: #ffb400;";}
if($k == '4'){$hstyle = "background-color: #1c95f3;";}
if($k == '5'){$hstyle = "background-color: #58d819;";}
	$secilikat = $db->prepare("select * from kategoriler where (id = '".$haber['kategori']."')");
	$result = $secilikat->execute();
	$secilikat  = $secilikat->fetch(PDO::FETCH_ASSOC);
	
	echo '<div class="post-preview picture short '.$haber['urlkodu'].'">';
		echo '<div class="post-preview-img-wrap">';
		  echo '<figure class="post-preview-img liquid">';
			echo '<img src="'.$domain.'images/blog/'.$haber['gorsel'].'" alt="post-07">';
		  echo '</figure>';
		  echo '<div class="post-preview-overlay">';
			echo '<p class="post-preview-title">'.$haber['baslik'].'</p>';
		  echo '</div>';
		  echo '<span class="tag-ornament" style="background-color: '.$secilikat['renk'].';">'.$secilikat['kategori_TR'].'</span>';
		echo '</div>';
		echo '<div class="loading-line"></div>';
		echo '<div class="overlay"></div>';
	echo '</div>';
}
?>
            </div>
          </div>
          <div id="postslide-1-controls" class="slider-controls blue">
            <div class="slider-control big control-previous">
                <svg class="arrow-icon medium">
                  <use xlink:href="#svg-arrow-medium"></use>
                </svg>
            </div>
            <div class="slider-control big control-next">
                <svg class="arrow-icon medium">
                  <use xlink:href="#svg-arrow-medium"></use>
                </svg>
            </div>
          </div>
        </div> 
      </div>

      <div class="layout-item">
<?php
$k = '0';
foreach($haberler as $haber){
	$k++;
if($k == '1'){$hstyle = "background-color: #1c95f3;";}
if($k == '2'){$hstyle = "background-color: #f30a5c;";}
if($k == '3'){$hstyle = "background-color: #ffb400;";}
if($k == '4'){$hstyle = "background-color: #1c95f3;";}
if($k == '5'){$hstyle = "background-color: #58d819;";}

$hyorumsayi = $db->prepare("select count(*) from haberyorum where (haber = :haber) && (yayin = '1')");
$result = $hyorumsayi->execute(array(":haber" => $haber['id']));
$hyorumsayi   = $hyorumsayi->fetchColumn();


	$metin = mb_substr(strip_tags($haber['icerik']),0,'350','utf-8').'...' ;
	$secilikat = $db->prepare("select * from kategoriler where (id = '".$haber['kategori']."')");
	$result = $secilikat->execute();
	$secilikat  = $secilikat->fetch(PDO::FETCH_ASSOC);
	
	echo '<div class="post-preview landscape big '.$haber['urlkodu'].'">';
	  echo '<a href="'.$domain2.'haber/'.$haber['urlkodu'].'">';
		echo '<div class="post-preview-img-wrap">';
		  echo '<figure class="post-preview-img liquid">';
			echo '<img src="'.$domain.'images/blog/'.$haber['gorsel'].'" alt="post-01">';
		  echo '</figure>';
		echo '</div>';  
	  echo '</a>';
	  echo '<a href="'.$domain2.'kategori/'.$secilikat['kategorikodu'].'" class="tag-ornament"  style="background-color: '.$secilikat['renk'].';">'.$secilikat['kategori_TR'].'</a>';
	  echo '<a href="'.$domain2.'haber/'.$haber['urlkodu'].'" class="post-preview-title">'.$haber['baslik'].'</a>';
	  echo '<div class="post-author-info-wrap">';
		echo '<a href="'.$domain2.'profil/'.$haber['yazar'].'">';
		  echo '<figure class="user-avatar tiny liquid">';
			echo '<img src="https://cravatar.eu/avatar/'.$haber['yazar'].'" alt="'.$haber['yazar'].'">';
		  echo '</figure>';
		echo '</a>';
		echo '<p class="post-author-info small light">Yazar <a href="'.$domain2.'profil/'.$haber['yazar'].'" class="post-author">'.$haber['yazar'].'</a><span class="separator">|</span>'.date("d.m.Y H:i",$haber['stamp']).'<span class="separator">|</span> <i class="fa fa-book"></i> '.$haber['okunma'].' Okunma<span class="separator">|</span> <a href="'.$domain2.'haber/'.$haber['urlkodu'].'#yorumlar" class="post-comment-count"> <i class="fa fa-comments"></i> '.$hyorumsayi.' Yorum</a></p>';
	  echo '</div>';
	  echo '<p class="post-preview-text">'.$metin.'...</p>';
	echo '</div>';
}
	
?>

 


      </div>
<?php
$banner = $db->prepare("select * from banner where (id = '1')");
$result = $banner->execute();
$banner   = $banner->fetch(PDO::FETCH_ASSOC);	
if($banner['yayin'] == '1'){
echo '<div class="layout-item padded">';
	echo '<a href="'.$banner['link'].'" target="_blank">';
	  echo '<div class="">';
		echo '<img src="'.$domain.'images/'.$banner['gorsel'].'" alt="" style="width:100%;">';
	  echo '</div>';
	echo '</a>';
echo '</div>';
}
?>

      <div class="layout-item padded own-grid">
        <div class="section-title-wrap yellow">
          <h2 class="section-title medium">Son Yüklenen Videolar <span style="font-size:12px;color:#363636;font-weight:700;float:right;margin-right: 85px;"><a href="<?php echo $domain2.'tumvideolar'; ?>" style="color:#363636;">Tüm Videolar</a></span></h2>
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
        <div id="gknews-slider1" class="carousel" style="height: 240px;">
          <div class="carousel-items">
<?php
$sonvideolar = $db->query("select * from youtube where (yayin = '1') order by stamp desc limit 12");
$sonvideolar->execute();
$sonvideolar = $sonvideolar->fetchAll();
foreach($sonvideolar as $svideo){
	echo '<div class="post-preview geeky-news">';
	  echo '<a href="'.$domain2.'video/'.$svideo['urlkodu'].'">';
		echo '<div class="post-preview-img-wrap">';
		  echo '<figure class="post-preview-img liquid">';
			echo '<img src="'.$domain.'images/blog/'.$svideo['kapak'].'" alt="post-02">';
		  echo '</figure>';
		    echo '<div class="post-preview-overlay">';
                echo '<div class="play-button">';
                  echo '<svg class="play-button-icon">';
                    echo '<use xlink:href="#svg-play"></use>';
                  echo '</svg>';
                echo '</div>';
            echo '</div>';
		echo '</div>';
	  echo '</a>';
	  echo '<a href="'.$domain2.'video/'.$svideo['urlkodu'].'" class="tag-ornament" style="text-transform:none;">'.$svideo['yukleyen'].'</a>';
	  echo '<a href="'.$domain2.'video/'.$svideo['urlkodu'].'" class="post-preview-title" style="min-height:35px;">'.$svideo['baslik'].'</a>';
	  echo '<div class="post-author-info-wrap">';
	if($svideo['yukleyen'] == 'CandyCraft'){
		echo '<p class="post-author-info small light">Yükleyen <a href="'.$domain.'" class="post-author">'.$svideo['yukleyen'].'</a><span class="separator">|</span>'.date("d.m.y H:i",$svideo['stamp']).'</p>';
	}else{
		echo '<p class="post-author-info small light">Yükleyen <a href="'.$domain2.'profil/'.$svideo['yukleyen'].'" class="post-author">'.$svideo['yukleyen'].'</a><span class="separator">|</span>'.date("d.m.y H:i",$svideo['stamp']).'</p>';
	}  
	echo '<p class="post-author-info small light"><i class="fa fa-eye"></i> '.$svideo['izlenme'].' Görüntülenme <span class="separator">|</span> <i class="fa fa-thumbs-up"></i> '.$svideo['begen'].' Beðeni</p>';	
	  echo '</div>';
	echo '</div>';
}
?>
 
          </div>
        </div>
      </div>
      <div class="layout-item padded own-grid">
 
        <div class="section-title-wrap violet">
          <h2 class="section-title medium">Popüler Videolar <span style="font-size:12px;color:#363636;font-weight:700;float:right;margin-right: 85px;"><a href="<?php echo $domain2.'tumvideolar'; ?>" style="color:#363636;">Tüm Videolar</a></span></h2>
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

        <div id="esnews-slider1" class="carousel" style="height: 240px;">

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
		  
			echo '<div class="post-preview-overlay">';
                echo '<div class="play-button">';
                  echo '<svg class="play-button-icon">';
                    echo '<use xlink:href="#svg-play"></use>';
                  echo '</svg>';
                echo '</div>';
            echo '</div>';
		  
		echo '</div>';
	  echo '</a>';
	  echo '<a href="'.$domain2.'video/'.$pvideo['urlkodu'].'" class="tag-ornament" style="text-transform:none;">'.$pvideo['yukleyen'].'</a>';
	  echo '<a href="'.$domain2.'video/'.$pvideo['urlkodu'].'" class="post-preview-title" style="min-height:35px;">'.$pvideo['baslik'].'</a>';
	  echo '<div class="post-author-info-wrap">';
	if($pvideo['yukleyen'] == 'CandyCraft'){
		echo '<p class="post-author-info small light">Yükleyen <a href="'.$domain.'" class="post-author">'.$pvideo['yukleyen'].'</a><span class="separator">|</span>'.date("d.m.y H:i",$pvideo['stamp']).'</p>';
	}else{
		echo '<p class="post-author-info small light">Yükleyen <a href="'.$domain2.'profil/'.$pvideo['yukleyen'].'" class="post-author">'.$pvideo['yukleyen'].'</a><span class="separator">|</span>'.date("d.m.y H:i",$pvideo['stamp']).'</p>';
	}  
	echo '<p class="post-author-info small light"><i class="fa fa-eye"></i> '.$pvideo['izlenme'].' Görüntülenme <span class="separator">|</span> <i class="fa fa-thumbs-up"></i> '.$pvideo['begen'].' Beğeni</p>';	
	  echo '</div>';
	echo '</div>';
}
?>
          </div>
        </div>
      </div>
    </div>

<?php include_once('sidebar.php'); ?>
  </div>

<?php
include_once('footer.php');
?>