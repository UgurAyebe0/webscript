<?php
$haberler = $db->query("select * from makaleler where (yayin = '1') order by stamp desc limit 5");
$haberler->execute();
$haberler = $haberler->fetchAll();

$haberlere = $db->query("select * from makaleler where (yayin = '1') order by stamp desc limit 15");
$haberlere->execute();
$haberlere = $haberlere->fetchAll();

?>
  <div class="live-news-widget-wrap">
    <div class="live-news-widget grid-limit">
      <div class="live-news-widget-stairs left red">
        <div class="live-news-widget-stair"></div>
        <div class="live-news-widget-stair"></div>
        <div class="live-news-widget-stair"></div>
        <div class="live-news-widget-stair"></div>
        <div class="live-news-widget-stair"></div>
        <div class="live-news-widget-stair"></div>
        <div class="live-news-widget-stair"></div>
        <div class="live-news-widget-stair"></div>
      </div>
      <div class="live-news-widget-stairs right blue">
        <div class="live-news-widget-stair"></div>
        <div class="live-news-widget-stair"></div>
        <div class="live-news-widget-stair"></div>
        <div class="live-news-widget-stair"></div>
        <div class="live-news-widget-stair"></div>
        <div class="live-news-widget-stair"></div>
        <div class="live-news-widget-stair"></div>
        <div class="live-news-widget-stair"></div>
      </div>
      <div class="live-news-widget-title-wrap">
        <img class="live-news-widget-icon" src="https://www.candycraft.net/assets/images/dark/icon.png" style="width:24px;" alt="live-news-icon">
        <p class="live-news-widget-title">Son Haberler</p>
      </div>
      <div id="lineslide-wrap1" class="live-news-widget-text-wrap">
        <p class="live-news-widget-text">
		
<?php
foreach($haberlere as $haber){
	$metin = substr(strip_tags($haber['icerik']),0,'200') ;
	echo '<span class="xm-line-item" style="white-space: nowrap;"><a href="'.$domain2.'haber/'.$haber['urlkodu'].'" class="link">'.$haber['baslik'].': </a>'.$metin.'...<span class="separator"><span class="separator-bar">/</span><span class="separator-bar">/</span></span>
</span>';
}
?>		
		
		
		
		</p>
      </div>
    </div>
  </div>