<style>
.link-list.small {
    width: 150px;
}
</style>
  <!-- FOOTER TOP WRAP -->
  <div class="footer-top-wrap">
    <!-- FOOTER TOP -->
    <div class="footer-top grid-limit">
      <!-- FOOTER TOP BRAND -->
      <div class="footer-top-brand">
        <!-- LOGO -->

		<div class="social-icons">
                        <div class="col-md-6" style="margin-top:17px;">
                            <a href="/indir/CandyCraft%20Launcher%20(Windows).zip">
                                <img src="<?php echo $domain; ?>images/windows.png" style="border-radius: 15px;width: 170px;">
                            </a>
                        </div>
                        <div class="col-md-6" style="margin-top:17px;">
                            <a href="/indir/CandyCraft%20Launcher%20(Apple).zip">
                                <img src="<?php echo $domain; ?>images/apple.png" style="border-radius: 15px;width: 170px;">
                            </a>
                        </div>
                        
                    </div>


<?php
$iletisim = $db->prepare("select * from iletisim where (id = '1')");
$result = $iletisim->execute();
$iletisim   = $iletisim->fetch(PDO::FETCH_ASSOC);
?>
<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
        <div class="social-links">
          <a href="<?php echo $iletisim['facebook']; ?>" class="bubble-ornament fb">
            <svg class="facebook-icon">
              <use xlink:href="#svg-facebook"></use>
            </svg>
          </a>
          <a href="<?php echo $iletisim['twitter']; ?>" class="bubble-ornament twt">
            <svg class="twitter-icon">
              <use xlink:href="#svg-twitter"></use>
            </svg>
          </a>
          <a href="<?php echo $iletisim['instagram']; ?>" class="bubble-ornament insta">
            <svg class="instagram-icon">
              <use xlink:href="#svg-instagram"></use>
            </svg>
          </a>
          <a href="<?php echo $iletisim['linkedin']; ?>" class="bubble-ornament twt">
             <svg aria-hidden="true" focusable="false" data-prefix="fab" data-icon="discord" class="svg-inline--fa fa-discord fa-w-14" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" style="width: 15px;margin-top: 7px;"><path fill="currentColor" d="M297.216 243.2c0 15.616-11.52 28.416-26.112 28.416-14.336 0-26.112-12.8-26.112-28.416s11.52-28.416 26.112-28.416c14.592 0 26.112 12.8 26.112 28.416zm-119.552-28.416c-14.592 0-26.112 12.8-26.112 28.416s11.776 28.416 26.112 28.416c14.592 0 26.112-12.8 26.112-28.416.256-15.616-11.52-28.416-26.112-28.416zM448 52.736V512c-64.494-56.994-43.868-38.128-118.784-107.776l13.568 47.36H52.48C23.552 451.584 0 428.032 0 398.848V52.736C0 23.552 23.552 0 52.48 0h343.04C424.448 0 448 23.552 448 52.736zm-72.96 242.688c0-82.432-36.864-149.248-36.864-149.248-36.864-27.648-71.936-26.88-71.936-26.88l-3.584 4.096c43.52 13.312 63.744 32.512 63.744 32.512-60.811-33.329-132.244-33.335-191.232-7.424-9.472 4.352-15.104 7.424-15.104 7.424s21.248-20.224 67.328-33.536l-2.56-3.072s-35.072-.768-71.936 26.88c0 0-36.864 66.816-36.864 149.248 0 0 21.504 37.12 78.08 38.912 0 0 9.472-11.52 17.152-21.248-32.512-9.728-44.8-30.208-44.8-30.208 3.766 2.636 9.976 6.053 10.496 6.4 43.21 24.198 104.588 32.126 159.744 8.96 8.96-3.328 18.944-8.192 29.44-15.104 0 0-12.8 20.992-46.336 30.464 7.68 9.728 16.896 20.736 16.896 20.736 56.576-1.792 78.336-38.912 78.336-38.912z"></path></svg>
          </a>
          <a href="<?php echo $iletisim['youtube']; ?>" class="bubble-ornament youtube">

            <svg class="youtube-icon">
              <use xlink:href="#svg-youtube"></use>
            </svg>

          </a>

        </div>

      </div>

      <div class="line-separator negative"></div>
      <div class="footer-top-widgets grid-4col centered gutter-big">

        <div class="footer-top-widget">

          <div class="section-title-wrap blue negative">
            <h2 class="section-title">Son Kayıt Olanlar</h2>
            <div class="section-title-separator"></div>
          </div>
 
          <div class="link-section">
            <ul class="link-list small v2 negative">
<?php
$sonkayitlar = $kpanel->query("select * from Kullanicilar order by KullaniciId desc limit 5");
$sonkayitlar->execute();
$sonkayitlar = $sonkayitlar->fetchAll();
foreach($sonkayitlar as $son){
	
	echo '<li class="link-list-item">';
		echo '<a href="'.$domain2.'profil/'.$son['username'].'" style="font-size: .95em;">';
		  echo '<img alt="" src="https://minepic.org/avatar/'.$son['username'].'" height="15" width="15" style="margin-right: 10px;margin-top: -3px;">';
			
		  echo ''.$son['username'].'';
		echo '</a>';
	echo '</li>';
	
}
?>
              
              
            </ul>

          </div>
          <!-- /LINK SECTION -->
        </div>
        <!-- FOOTER TOP WIDGET -->

        <div class="footer-top-widget">

          <div class="section-title-wrap blue negative">
            <h2 class="section-title">Son Yasaklananlar</h2>
            <div class="section-title-separator"></div>
          </div>
 
          <div class="link-section">
            <ul class="link-list small v2 negative">
<?php
$sonbanlar = $bungeecord->query("select * from litebans_bans order by id desc limit 5");
$sonbanlar->execute();
$sonbanlar = $sonbanlar->fetchAll();
foreach($sonbanlar as $ban){
	$kul = $kpanel->prepare("select * from Kullanicilar where (uuid = '".$ban['uuid']."')");
	$result = $kul->execute();
	$kul   = $kul->fetch(PDO::FETCH_ASSOC);
if($kul['username'] != ''){
	echo '<li class="link-list-item">';
		echo '<a href="'.$domain2.'profil/'.$kul['username'].'" style="font-size: .95em;">';
		  echo '<img alt="" src="https://minepic.org/avatar/'.$kul['username'].'" height="15" width="15" style="margin-right: 10px;margin-top: -3px;">';
			
		  echo ''.$kul['username'].'';
		echo '</a>';
	echo '</li>';
}
}
	
	
	

?>
              
              
            </ul>

          </div>
          <!-- /LINK SECTION -->
        </div>
        <!-- FOOTER TOP WIDGET -->

        <!-- FOOTER TOP WIDGET -->
        <div class="footer-top-widget">
          <!-- SECTION TITLE WRAP -->
          <div class="section-title-wrap blue negative">
            <h2 class="section-title">Bizi Takip Edin</h2>
            <div class="section-title-separator"></div>
          </div>
          <div class="post-preview-showcase grid-1col gutter-small">
            <!-- POST PREVIEW -->
            
              <iframe src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2Fcandycraftnet%2F&tabs&width=270&height=180&small_header=false&adapt_container_width=true&hide_cover=false&show_facepile=true&appId=1374938632787640" width="100%" height="180" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true" allow="encrypted-media"></iframe>
            
            <!-- /POST PREVIEW -->

            
          </div>
          <!-- POST PREVIEW SHOWCASE -->
        </div>
        <!-- FOOTER TOP WIDGET -->

        <!-- FOOTER TOP WIDGET -->
        <div class="footer-top-widget">
          <!-- SECTION TITLE WRAP -->
          <div class="section-title-wrap blue negative">
            <h2 class="section-title">Hakkımızda</h2>
            <div class="section-title-separator"></div>
          </div>
          <!-- /SECTION TITLE WRAP -->

          <!-- POST PREVIEW SHOWCASE -->
          <div class="post-preview-showcase grid-1col gutter-small">
            <?php
$kurumsal = $db->prepare("select * from hakkimizda where (id = '1')");
$result = $kurumsal->execute();
$kurumsal   = $kurumsal->fetch(PDO::FETCH_ASSOC);


?>

                            <p style="text-align:justify;font-weight:400;">
                             <?php echo substr(strip_tags($kurumsal['icerik']),0,'250').'...<a href="'.$domain2.'hakkimizda" style="text-decoration:none;font-weight:400;"> Devamı</a>'; ?>  
                            </p>

          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="footer-bottom-wrap">
  
    <!-- FOOTER BOTTOM -->
    <div class="footer-bottom grid-limit">
      <p class="footer-bottom-text"><span class="brand"><span class="highlighted">candycraft</span>.net</span><span class="separator">|</span>Copyright © 2021  Tüm Hakları Saklıdır .</p>
      <p class="footer-bottom-text">
<?php
$sayfalar = $db->query("select * from sayfalar where (yayin = '1') order by id asc");
$ia = 0;
foreach($sayfalar as $sayfa){
$ia++;
if($ia != '1'){
	echo '<span class="separator">|</span>';
}
	echo '<a  href="'.$domain2.'sayfa/'.$sayfa['urlkodu'].'">'.$sayfa['baslik'].'</a>';
	
}
echo '<span class="separator">|</span>';
echo '<a  href="'.$domain.'cezalar" target="_blank">Cezalar</a>';
?>
	  
	  </p>
	  	
    </div>

    <!-- /FOOTER BOTTOM -->
  </div>
  <!-- /FOOTER BOTTOM WRAP -->
<script src="<?php echo $domain; ?>plugin/ckeditor/ckeditor.js"></script>


<!-- app bundle --><script src="<?php echo $domain2; ?>app.bundle.js"></script>



<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>



</body>
</html>