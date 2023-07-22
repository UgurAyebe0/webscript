<?php
include_once('header.php');
$video = $db->prepare("select * from youtube where (urlkodu = '".$_REQUEST['p']."')");
$result = $video->execute();
$video  = $video->fetch(PDO::FETCH_ASSOC);
 
if(isset($_SESSION['ip'])){
	$id = $video['id'];
	if($_SESSION['video'] != $id){		
		$okunmaa = $video['izlenme'] + 1;
		$arttir = $db->query("update youtube set izlenme = '".$okunmaa."' where (id = '".$id."') ");
		$_SESSION['ip'] = GetIP();		
	}
}
  
$_SESSION['video'] = $id;
if(!isset($_SESSION['ip'])){
	$id = $video['id'];
	$_SESSION['ip'] = GetIP();
	
	$okunma = $video['izlenme'] + 1;
	
	$arttir = $db->query("update youtube set izlenme = '".$okunma."' where (id = '".$id."') ");
	
}
?>
<style>
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
      <h2 class="banner-title">Videolar</h2>
      <p class="banner-sections">
        <span class="banner-section">Anasayfa</span>
        <!-- ARROW ICON -->
        <svg class="arrow-icon">
          <use xlink:href="#svg-arrow"></use>
        </svg>
        <!-- /ARROW ICON -->
        <span class="banner-section"><?php echo $video['baslik']; ?></span>
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
<?php
$videolink = str_replace("watch?v=","embed/",$video['link']);

echo '<iframe width="100%" height="500" src="'.$videolink.'?rel=0" frameborder="0" allow="accelerometer; gyroscope;" allowfullscreen></iframe>';
?>


            </div>
  
          <!-- /POST PREVIEW IMG WRAP -->
    
         
    
          <!-- POST PREVIEW TITLE -->
          <a href="javascript:void();" class="post-preview-title"><?php echo $video['baslik']; ?></a>
          <!-- POST AUTHOR INFO -->
<?php if($video['yukleyen'] != 'CandyCraft'){ ?>
          <div class="post-author-info-wrap">
            <!-- USER AVATAR -->
            <a href="<?php echo ''.$domain2.'profil/'.$video['yukleyen'].''; ?>">
              <figure class="user-avatar tiny liquid">
                <img src="<?php echo 'https://cravatar.eu/avatar/'.$video['yukleyen'].''; ?>" alt="<?php echo $video['yukleyen']; ?>">
              </figure>
            </a>
            <!-- /USER AVATAR -->
            <p class="post-author-info small light">Yükleyen <a href="<?php echo ''.$domain2.'profil/'.$video['yukleyen'].''; ?>" class="post-author"><?php echo $video['yukleyen']; ?></a><span class="separator">|</span><?php echo date("d.m.y H:i",$video['stamp']); ?><span class="separator">|</span><a href="javascript:void();" class="post-comment-count"><?php echo $video['izlenme']; ?> Görüntülenme</a></p>
          </div>
<?php }else{
	echo '<div class="post-author-info-wrap">';

		echo '<a href="search-results.html">';
		  echo '<figure class="user-avatar tiny liquid">';
			echo '<img src="https://www.candycraft.net/img/candy-logo.png" alt="'.$video['yukleyen'].'">';
		  echo '</figure>';
		echo '</a>';

		echo '<p class="post-author-info small light">Yükleyen <a href="javascript:void();" class="post-author">'.$video['yukleyen'].'</a><span class="separator">|</span>'.date("d.m.y H:i",$video['stamp']).'<span class="separator">|</span><a href="javascript:void();" class="post-comment-count">'.$video['izlenme'].' Görüntülenme</a></p>';
	echo '</div>';
	
	
	
} ?>
          <!-- /POST AUTHOR INFO -->
          <!-- POST PREVIEW TEXT -->
		  <div class="col-md-12 pad0">
<?php
if(isset($_SESSION['login'])){
	$oykontrol = $db->prepare("select * from oylama where (username = '".$_SESSION['username']."') && (video = '".$video['id']."')");
	$result = $oykontrol->execute();
	$oykontrol  = $oykontrol->fetch(PDO::FETCH_ASSOC);
	if($oykontrol['oylama'] == '0' or $oykontrol == NULL){
?>
		  <form method="POST" style="width:80px;float:left;">
			<input type="text" name="begen" value="1" class="hidden">
			<button onclick = "this.form.submit();" class="submit-button button green" style="padding: 6px;height: 32px; border-radius: 21px;">
			<svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="thumbs-up" class="svg-inline--fa fa-thumbs-up fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" style="width:20px;"><path fill="currentColor" d="M466.27 286.69C475.04 271.84 480 256 480 236.85c0-44.015-37.218-85.58-85.82-85.58H357.7c4.92-12.81 8.85-28.13 8.85-46.54C366.55 31.936 328.86 0 271.28 0c-61.607 0-58.093 94.933-71.76 108.6-22.747 22.747-49.615 66.447-68.76 83.4H32c-17.673 0-32 14.327-32 32v240c0 17.673 14.327 32 32 32h64c14.893 0 27.408-10.174 30.978-23.95 44.509 1.001 75.06 39.94 177.802 39.94 7.22 0 15.22.01 22.22.01 77.117 0 111.986-39.423 112.94-95.33 13.319-18.425 20.299-43.122 17.34-66.99 9.854-18.452 13.664-40.343 8.99-62.99zm-61.75 53.83c12.56 21.13 1.26 49.41-13.94 57.57 7.7 48.78-17.608 65.9-53.12 65.9h-37.82c-71.639 0-118.029-37.82-171.64-37.82V240h10.92c28.36 0 67.98-70.89 94.54-97.46 28.36-28.36 18.91-75.63 37.82-94.54 47.27 0 47.27 32.98 47.27 56.73 0 39.17-28.36 56.72-28.36 94.54h103.99c21.11 0 37.73 18.91 37.82 37.82.09 18.9-12.82 37.81-22.27 37.81 13.489 14.555 16.371 45.236-5.21 65.62zM88 432c0 13.255-10.745 24-24 24s-24-10.745-24-24 10.745-24 24-24 24 10.745 24 24z"></path></svg>
			</button> 
			<label class="rl-label" style="float: right;margin-top: 9px;text-align: left;margin-right: 14px;width:29px;"><?php echo $video['begen']; ?></label>
		  </form>
		  <form method="POST" style="width:80px;float:left;">
			<input type="text" name="begen" value="2" class="hidden">
			<button onclick = "this.form.submit();" class="submit-button button red" style="padding: 6px;height: 32px; border-radius: 21px;">
			<svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="thumbs-down" class="svg-inline--fa fa-thumbs-down fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" style="width:20px;"><path fill="currentColor" d="M466.27 225.31c4.674-22.647.864-44.538-8.99-62.99 2.958-23.868-4.021-48.565-17.34-66.99C438.986 39.423 404.117 0 327 0c-7 0-15 .01-22.22.01C201.195.01 168.997 40 128 40h-10.845c-5.64-4.975-13.042-8-21.155-8H32C14.327 32 0 46.327 0 64v240c0 17.673 14.327 32 32 32h64c11.842 0 22.175-6.438 27.708-16h7.052c19.146 16.953 46.013 60.653 68.76 83.4 13.667 13.667 10.153 108.6 71.76 108.6 57.58 0 95.27-31.936 95.27-104.73 0-18.41-3.93-33.73-8.85-46.54h36.48c48.602 0 85.82-41.565 85.82-85.58 0-19.15-4.96-34.99-13.73-49.84zM64 296c-13.255 0-24-10.745-24-24s10.745-24 24-24 24 10.745 24 24-10.745 24-24 24zm330.18 16.73H290.19c0 37.82 28.36 55.37 28.36 94.54 0 23.75 0 56.73-47.27 56.73-18.91-18.91-9.46-66.18-37.82-94.54C206.9 342.89 167.28 272 138.92 272H128V85.83c53.611 0 100.001-37.82 171.64-37.82h37.82c35.512 0 60.82 17.12 53.12 65.9 15.2 8.16 26.5 36.44 13.94 57.57 21.581 20.384 18.699 51.065 5.21 65.62 9.45 0 22.36 18.91 22.27 37.81-.09 18.91-16.71 37.82-37.82 37.82z"></path></svg>
			</button> 
			<label class="rl-label" style="float: right;margin-top: 9px;text-align: left;margin-right: 14px;width:29px;"><?php echo $video['begenme']; ?></label>
		  </form>
<?php
	}elseif($oykontrol['oylama'] == '1'){
?>
		  <form method="POST" style="width:80px;float:left;">
			<input type="text" name="begen" value="0" class="hidden">
			<button onclick = "this.form.submit();" class="submit-button button green" style="padding: 6px;height: 32px; border-radius: 21px;">
			<svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="thumbs-up" class="svg-inline--fa fa-thumbs-up fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" style="width:20px;"><path fill="currentColor" d="M104 224H24c-13.255 0-24 10.745-24 24v240c0 13.255 10.745 24 24 24h80c13.255 0 24-10.745 24-24V248c0-13.255-10.745-24-24-24zM64 472c-13.255 0-24-10.745-24-24s10.745-24 24-24 24 10.745 24 24-10.745 24-24 24zM384 81.452c0 42.416-25.97 66.208-33.277 94.548h101.723c33.397 0 59.397 27.746 59.553 58.098.084 17.938-7.546 37.249-19.439 49.197l-.11.11c9.836 23.337 8.237 56.037-9.308 79.469 8.681 25.895-.069 57.704-16.382 74.757 4.298 17.598 2.244 32.575-6.148 44.632C440.202 511.587 389.616 512 346.839 512l-2.845-.001c-48.287-.017-87.806-17.598-119.56-31.725-15.957-7.099-36.821-15.887-52.651-16.178-6.54-.12-11.783-5.457-11.783-11.998v-213.77c0-3.2 1.282-6.271 3.558-8.521 39.614-39.144 56.648-80.587 89.117-113.111 14.804-14.832 20.188-37.236 25.393-58.902C282.515 39.293 291.817 0 312 0c24 0 72 8 72 81.452z"></path></svg>
			</button> 
			<label class="rl-label" style="float: right;margin-top: 9px;text-align: left;margin-right: 14px;width:29px;"><?php echo $video['begen']; ?></label>
		  </form>
		  <form method="POST" style="width:80px;float:left;">
			<input type="text" name="begen" value="2" class="hidden">
			<button onclick = "this.form.submit();" class="submit-button button red" style="padding: 6px;height: 32px; border-radius: 21px;">
			<svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="thumbs-down" class="svg-inline--fa fa-thumbs-down fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" style="width:20px;"><path fill="currentColor" d="M466.27 225.31c4.674-22.647.864-44.538-8.99-62.99 2.958-23.868-4.021-48.565-17.34-66.99C438.986 39.423 404.117 0 327 0c-7 0-15 .01-22.22.01C201.195.01 168.997 40 128 40h-10.845c-5.64-4.975-13.042-8-21.155-8H32C14.327 32 0 46.327 0 64v240c0 17.673 14.327 32 32 32h64c11.842 0 22.175-6.438 27.708-16h7.052c19.146 16.953 46.013 60.653 68.76 83.4 13.667 13.667 10.153 108.6 71.76 108.6 57.58 0 95.27-31.936 95.27-104.73 0-18.41-3.93-33.73-8.85-46.54h36.48c48.602 0 85.82-41.565 85.82-85.58 0-19.15-4.96-34.99-13.73-49.84zM64 296c-13.255 0-24-10.745-24-24s10.745-24 24-24 24 10.745 24 24-10.745 24-24 24zm330.18 16.73H290.19c0 37.82 28.36 55.37 28.36 94.54 0 23.75 0 56.73-47.27 56.73-18.91-18.91-9.46-66.18-37.82-94.54C206.9 342.89 167.28 272 138.92 272H128V85.83c53.611 0 100.001-37.82 171.64-37.82h37.82c35.512 0 60.82 17.12 53.12 65.9 15.2 8.16 26.5 36.44 13.94 57.57 21.581 20.384 18.699 51.065 5.21 65.62 9.45 0 22.36 18.91 22.27 37.81-.09 18.91-16.71 37.82-37.82 37.82z"></path></svg>
			</button> 
			<label class="rl-label" style="float: right;margin-top: 9px;text-align: left;margin-right: 14px;width:29px;"><?php echo $video['begenme']; ?></label>
		  </form>
<?php
	}elseif($oykontrol['oylama'] == '2'){
?>
		  <form method="POST" style="width:80px;float:left;">
			<input type="text" name="begen" value="1" class="hidden">
			<button onclick = "this.form.submit();" class="submit-button button green" style="padding: 6px;height: 32px; border-radius: 21px;">
			<svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="thumbs-up" class="svg-inline--fa fa-thumbs-up fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" style="width:20px;"><path fill="currentColor" d="M466.27 286.69C475.04 271.84 480 256 480 236.85c0-44.015-37.218-85.58-85.82-85.58H357.7c4.92-12.81 8.85-28.13 8.85-46.54C366.55 31.936 328.86 0 271.28 0c-61.607 0-58.093 94.933-71.76 108.6-22.747 22.747-49.615 66.447-68.76 83.4H32c-17.673 0-32 14.327-32 32v240c0 17.673 14.327 32 32 32h64c14.893 0 27.408-10.174 30.978-23.95 44.509 1.001 75.06 39.94 177.802 39.94 7.22 0 15.22.01 22.22.01 77.117 0 111.986-39.423 112.94-95.33 13.319-18.425 20.299-43.122 17.34-66.99 9.854-18.452 13.664-40.343 8.99-62.99zm-61.75 53.83c12.56 21.13 1.26 49.41-13.94 57.57 7.7 48.78-17.608 65.9-53.12 65.9h-37.82c-71.639 0-118.029-37.82-171.64-37.82V240h10.92c28.36 0 67.98-70.89 94.54-97.46 28.36-28.36 18.91-75.63 37.82-94.54 47.27 0 47.27 32.98 47.27 56.73 0 39.17-28.36 56.72-28.36 94.54h103.99c21.11 0 37.73 18.91 37.82 37.82.09 18.9-12.82 37.81-22.27 37.81 13.489 14.555 16.371 45.236-5.21 65.62zM88 432c0 13.255-10.745 24-24 24s-24-10.745-24-24 10.745-24 24-24 24 10.745 24 24z"></path></svg>
			</button> 
			<label class="rl-label" style="float: right;margin-top: 9px;text-align: left;margin-right: 14px;width:29px;"><?php echo $video['begen']; ?></label>
		  </form>
		  <form method="POST" style="width:80px;float:left;">
			<input type="text" name="begen" value="0" class="hidden">
			<button onclick = "this.form.submit();" class="submit-button button red" style="padding: 6px;height: 32px; border-radius: 21px;">
			<svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="thumbs-down" class="svg-inline--fa fa-thumbs-down fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" style="width:20px;"><path fill="currentColor" d="M0 56v240c0 13.255 10.745 24 24 24h80c13.255 0 24-10.745 24-24V56c0-13.255-10.745-24-24-24H24C10.745 32 0 42.745 0 56zm40 200c0-13.255 10.745-24 24-24s24 10.745 24 24-10.745 24-24 24-24-10.745-24-24zm272 256c-20.183 0-29.485-39.293-33.931-57.795-5.206-21.666-10.589-44.07-25.393-58.902-32.469-32.524-49.503-73.967-89.117-113.111a11.98 11.98 0 0 1-3.558-8.521V59.901c0-6.541 5.243-11.878 11.783-11.998 15.831-.29 36.694-9.079 52.651-16.178C256.189 17.598 295.709.017 343.995 0h2.844c42.777 0 93.363.413 113.774 29.737 8.392 12.057 10.446 27.034 6.148 44.632 16.312 17.053 25.063 48.863 16.382 74.757 17.544 23.432 19.143 56.132 9.308 79.469l.11.11c11.893 11.949 19.523 31.259 19.439 49.197-.156 30.352-26.157 58.098-59.553 58.098H350.723C358.03 364.34 384 388.132 384 430.548 384 504 336 512 312 512z"></path></svg>
			</button> 
			<label class="rl-label" style="float: right;margin-top: 9px;text-align: left;margin-right: 14px;width:29px;"><?php echo $video['begenme']; ?></label>
		  </form>
<?php
	}else{
?>
		  <form method="POST" style="width:80px;float:left;">
			<input type="text" name="begen" value="1" class="hidden">
			<button onclick = "this.form.submit();" class="submit-button button green" style="padding: 6px;height: 32px; border-radius: 21px;">
			<svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="thumbs-up" class="svg-inline--fa fa-thumbs-up fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" style="width:20px;"><path fill="currentColor" d="M466.27 286.69C475.04 271.84 480 256 480 236.85c0-44.015-37.218-85.58-85.82-85.58H357.7c4.92-12.81 8.85-28.13 8.85-46.54C366.55 31.936 328.86 0 271.28 0c-61.607 0-58.093 94.933-71.76 108.6-22.747 22.747-49.615 66.447-68.76 83.4H32c-17.673 0-32 14.327-32 32v240c0 17.673 14.327 32 32 32h64c14.893 0 27.408-10.174 30.978-23.95 44.509 1.001 75.06 39.94 177.802 39.94 7.22 0 15.22.01 22.22.01 77.117 0 111.986-39.423 112.94-95.33 13.319-18.425 20.299-43.122 17.34-66.99 9.854-18.452 13.664-40.343 8.99-62.99zm-61.75 53.83c12.56 21.13 1.26 49.41-13.94 57.57 7.7 48.78-17.608 65.9-53.12 65.9h-37.82c-71.639 0-118.029-37.82-171.64-37.82V240h10.92c28.36 0 67.98-70.89 94.54-97.46 28.36-28.36 18.91-75.63 37.82-94.54 47.27 0 47.27 32.98 47.27 56.73 0 39.17-28.36 56.72-28.36 94.54h103.99c21.11 0 37.73 18.91 37.82 37.82.09 18.9-12.82 37.81-22.27 37.81 13.489 14.555 16.371 45.236-5.21 65.62zM88 432c0 13.255-10.745 24-24 24s-24-10.745-24-24 10.745-24 24-24 24 10.745 24 24z"></path></svg>
			</button> 
			<label class="rl-label" style="float: right;margin-top: 9px;text-align: left;margin-right: 14px;width:29px;"><?php echo $video['begen']; ?></label>
		  </form>
		  <form method="POST" style="width:80px;float:left;">
			<input type="text" name="begen" value="2" class="hidden">
			<button onclick = "this.form.submit();" class="submit-button button red" style="padding: 6px;height: 32px; border-radius: 21px;">
			<svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="thumbs-down" class="svg-inline--fa fa-thumbs-down fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" style="width:20px;"><path fill="currentColor" d="M466.27 225.31c4.674-22.647.864-44.538-8.99-62.99 2.958-23.868-4.021-48.565-17.34-66.99C438.986 39.423 404.117 0 327 0c-7 0-15 .01-22.22.01C201.195.01 168.997 40 128 40h-10.845c-5.64-4.975-13.042-8-21.155-8H32C14.327 32 0 46.327 0 64v240c0 17.673 14.327 32 32 32h64c11.842 0 22.175-6.438 27.708-16h7.052c19.146 16.953 46.013 60.653 68.76 83.4 13.667 13.667 10.153 108.6 71.76 108.6 57.58 0 95.27-31.936 95.27-104.73 0-18.41-3.93-33.73-8.85-46.54h36.48c48.602 0 85.82-41.565 85.82-85.58 0-19.15-4.96-34.99-13.73-49.84zM64 296c-13.255 0-24-10.745-24-24s10.745-24 24-24 24 10.745 24 24-10.745 24-24 24zm330.18 16.73H290.19c0 37.82 28.36 55.37 28.36 94.54 0 23.75 0 56.73-47.27 56.73-18.91-18.91-9.46-66.18-37.82-94.54C206.9 342.89 167.28 272 138.92 272H128V85.83c53.611 0 100.001-37.82 171.64-37.82h37.82c35.512 0 60.82 17.12 53.12 65.9 15.2 8.16 26.5 36.44 13.94 57.57 21.581 20.384 18.699 51.065 5.21 65.62 9.45 0 22.36 18.91 22.27 37.81-.09 18.91-16.71 37.82-37.82 37.82z"></path></svg>
			</button> 
			<label class="rl-label" style="float: right;margin-top: 9px;text-align: left;margin-right: 14px;width:29px;"><?php echo $video['begenme']; ?></label>
		  </form>

<?php
	}		
}else{
?>
		  <div style="width:80px;float:left;">
			
			<button class="submit-button button green" style="padding: 6px;height: 32px; border-radius: 21px;">
			<svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="thumbs-up" class="svg-inline--fa fa-thumbs-up fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" style="width:20px;"><path fill="currentColor" d="M466.27 286.69C475.04 271.84 480 256 480 236.85c0-44.015-37.218-85.58-85.82-85.58H357.7c4.92-12.81 8.85-28.13 8.85-46.54C366.55 31.936 328.86 0 271.28 0c-61.607 0-58.093 94.933-71.76 108.6-22.747 22.747-49.615 66.447-68.76 83.4H32c-17.673 0-32 14.327-32 32v240c0 17.673 14.327 32 32 32h64c14.893 0 27.408-10.174 30.978-23.95 44.509 1.001 75.06 39.94 177.802 39.94 7.22 0 15.22.01 22.22.01 77.117 0 111.986-39.423 112.94-95.33 13.319-18.425 20.299-43.122 17.34-66.99 9.854-18.452 13.664-40.343 8.99-62.99zm-61.75 53.83c12.56 21.13 1.26 49.41-13.94 57.57 7.7 48.78-17.608 65.9-53.12 65.9h-37.82c-71.639 0-118.029-37.82-171.64-37.82V240h10.92c28.36 0 67.98-70.89 94.54-97.46 28.36-28.36 18.91-75.63 37.82-94.54 47.27 0 47.27 32.98 47.27 56.73 0 39.17-28.36 56.72-28.36 94.54h103.99c21.11 0 37.73 18.91 37.82 37.82.09 18.9-12.82 37.81-22.27 37.81 13.489 14.555 16.371 45.236-5.21 65.62zM88 432c0 13.255-10.745 24-24 24s-24-10.745-24-24 10.745-24 24-24 24 10.745 24 24z"></path></svg>
			</button> 
			<label class="rl-label" style="float: right;margin-top: 9px;text-align: left;margin-right: 14px;width:29px;"><?php echo $video['begen']; ?></label>
		  </div>
		  <div style="width:80px;float:left;">

			<button class="submit-button button red" style="padding: 6px;height: 32px; border-radius: 21px;">
			<svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="thumbs-down" class="svg-inline--fa fa-thumbs-down fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" style="width:20px;"><path fill="currentColor" d="M466.27 225.31c4.674-22.647.864-44.538-8.99-62.99 2.958-23.868-4.021-48.565-17.34-66.99C438.986 39.423 404.117 0 327 0c-7 0-15 .01-22.22.01C201.195.01 168.997 40 128 40h-10.845c-5.64-4.975-13.042-8-21.155-8H32C14.327 32 0 46.327 0 64v240c0 17.673 14.327 32 32 32h64c11.842 0 22.175-6.438 27.708-16h7.052c19.146 16.953 46.013 60.653 68.76 83.4 13.667 13.667 10.153 108.6 71.76 108.6 57.58 0 95.27-31.936 95.27-104.73 0-18.41-3.93-33.73-8.85-46.54h36.48c48.602 0 85.82-41.565 85.82-85.58 0-19.15-4.96-34.99-13.73-49.84zM64 296c-13.255 0-24-10.745-24-24s10.745-24 24-24 24 10.745 24 24-10.745 24-24 24zm330.18 16.73H290.19c0 37.82 28.36 55.37 28.36 94.54 0 23.75 0 56.73-47.27 56.73-18.91-18.91-9.46-66.18-37.82-94.54C206.9 342.89 167.28 272 138.92 272H128V85.83c53.611 0 100.001-37.82 171.64-37.82h37.82c35.512 0 60.82 17.12 53.12 65.9 15.2 8.16 26.5 36.44 13.94 57.57 21.581 20.384 18.699 51.065 5.21 65.62 9.45 0 22.36 18.91 22.27 37.81-.09 18.91-16.71 37.82-37.82 37.82z"></path></svg>
			</button> 
			<label class="rl-label" style="float: right;margin-top: 9px;text-align: left;margin-right: 14px;width:29px;"><?php echo $video['begenme']; ?></label>
		  </div>
<?php
}


if(isset($_POST['begen'])){
	$kontroloy = $db->prepare("select * from oylama where (username = '".$_SESSION['username']."') && (video = '".$video['id']."')");
	$result = $kontroloy->execute();
	$kontroloy  = $kontroloy->fetch(PDO::FETCH_ASSOC);
	if($kontroloy['oylama'] != ''){
		$goylama = $_POST['begen'];
		if($kontroloy['oylama'] == '1'){
			$sayi = $video['begen'] - 1;
			$db->query("update youtube set begen = '".$sayi."' where (id = '".$video['id']."') ");
		}elseif($kontroloy['oylama'] == '2'){
			$sayi = $video['begenme'] - 1;
			$db->query("update youtube set begenme = '".$sayi."' where (id = '".$video['id']."') ");
		}
		if($goylama == '1'){
			$sayi = $video['begen'] + 1;
			$db->query("update youtube set begen = '".$sayi."' where (id = '".$video['id']."') ");
		}elseif($goylama == '2'){
			$sayi = $video['begenme'] + 1;
			$db->query("update youtube set begenme = '".$sayi."' where (id = '".$video['id']."') ");
		}  
		$db->query("update oylama set oylama = '".$goylama."' where (video = '".$video['id']."') && (username = '".$_SESSION['username']."')");
		
		
		header('Location:'.$domain2.'video/'.$_REQUEST['p']);
	}else{
		$usernamee = $_SESSION['username'];
		$videoo = $video['id'];  
		$oylamaa = $_POST['begen'];
		$zaman = time();
		$uuidd = $_SESSION['uuid'];
		
		if($oylamaa == '1'){
			$sayi = $video['begen'] + 1;
			$db->query("update youtube set begen = '".$sayi."' where (id = '".$video['id']."') ");
		}elseif($oylamaa == '2'){
			$sayi = $video['begenme'] + 1;
			$db->query("update youtube set begenme = '".$sayi."' where (id = '".$video['id']."') ");
		}
		
		$db->query("insert into oylama (username, video, oylama, stamp, uuid) values ('$usernamee','$videoo','$oylamaa','$zaman','$uuidd')");
		header('Location:'.$domain2.'video/'.$_REQUEST['p']);
	}
}
?>
		  </div>
		  <br>
          <p class="post-preview-text" style="width:100%;padding-top:20px;"><?php echo $video['aciklama']; ?></p>
        </div>
        <!-- /POST PREVIEW -->
<?php
$yorumlar = $db->query("select * from videoyorum where (yayin = '1') && (video = '".$video['id']."') order by stamp asc");
$yorumlar->execute();
$yorumlar = $yorumlar->fetchAll();

$yorumsayi = $db->prepare("select count(*) from videoyorum where (video = :video) && (yayin = '1')");
$result = $yorumsayi->execute(array(":video" => $video['id']));
$yorumsayi   = $yorumsayi->fetchColumn();
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
	echo '<p class="alert alert-warning text-center" style="margin-top:50px;">Yorum yapmak ve oylamak için giriş yapınız.</p>';
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
	$kontroll = $db->prepare("select * from videoyorum where (username = :username) order by stamp desc limit 1");
	$result = $kontroll->execute(array(":username" => $_SESSION['username']));
	$kontrol   = $kontroll->fetch(PDO::FETCH_ASSOC);
	
	$zamankontrol = time() - $kontrol['stamp'];  
	if($zamankontrol >= 180 ){
		$time = time();
		$message = piril($_POST['message']);
		$videoid = $video['id'];
		$uuid = $_SESSION['uuid'];
		$username =  $_SESSION['username'];
		
		$db->query("insert into videoyorum (username, video, yorum, yayin, stamp, uuid) values ('$username', '$videoid', '$message', '1', '$time', '$uuid')");
		

		
		#$_SESSION['haberyorum'] = 'Yorumunuz başarıyla alınmıştır. Editör onayından sonra yayına alınacaktır. Teşekkür ederiz';
		header('Location: '.$domain2.'video/'.$_REQUEST['p'].'#op-comments');
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
        <div id="gknews-slider1" class="carousel" style="height:220px;">
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

        <div id="esnews-slider1" class="carousel" style="height:220px;">

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
<style>
@media screen and (max-width:1260px){

	.bunugizle{
		display:none;
	}
}
</style>
<?php include_once('sidebar.php'); ?>
  </div>
<?php include_once('footer.php'); ?>