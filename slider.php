<?php 

$slidelarr = $db->query("select * from slider where (yayin = '1') order by id desc");
$slidelarr->execute();
$slidelarr = $slidelarr->fetchAll();
 

 ?>
  <div id="banner-slider-2" class="banner-slider v2">
    <div class="slider-items">
<?php

	$i = '0';
	foreach($slidelarr as $slide){

		$i++;

		echo '<div class="slider-item slider-item-'.$i.'" style="background: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.4)),url(\''.$domain.'images/home-slide/'.$slide['gorsel'].'\') no-repeat center;
    background-size: cover;">';
			echo '<div class="slider-item-wrap">';
			  echo '<div class="post-preview huge centered '.$i.'">';
				#echo '<a href="news-v1.html" class="tag-ornament">'.$slide['baslik'].'</a>';
				echo '<a href="'.$slide['link'].'" class="post-preview-title">'.$slide['baslik'].'</a>';
				echo '<div class="post-author-info-wrap">';
				  /*echo '<a href="'.$slide['link'].'">';
					echo '<figure class="user-avatar tiny liquid">';
					  echo '<img src="images/home-slide/'.$slide['gorsel'].'" alt="user-01">';
					echo '</figure>';
				  echo '</a>';*/
				  echo '<p class="post-author-info light">'.$slide['aciklama'].'</p>';
				echo '</div>';
				echo '<div class="break"></div>';
				echo '<a href="'.$slide['link'].'" class="button blue">';
				  echo ''.$slide['butonadi'].'';
				  echo '<div class="button-ornament">';
					echo '<svg class="arrow-icon medium">';
					  echo '<use xlink:href="#svg-arrow-medium"></use>';
					echo '</svg>';
					echo '<svg class="cross-icon small">';
					  echo '<use xlink:href="#svg-cross-small"></use>';
					echo '</svg>';
				  echo '</div>';
				echo '</a>';
			  echo '</div>';
			echo '</div>';
		echo '</div>';
	}

?>	

    </div>

    <div class="banner-slider-preview-wrap">
      <div id="sliderb2-controls" class="banner-slider-controls">
        <div class="control-previous">
          <svg class="arrow-icon medium">
            <use xlink:href="#svg-arrow-medium"></use>
          </svg>
        </div>
        <div class="control-next"> 
          <svg class="arrow-icon medium">
            <use xlink:href="#svg-arrow-medium"></use>
          </svg>
        </div>
      </div>

      <div id="banner-slider-2-thumbs" class="banner-slider-preview">
        <div class="banner-slider-preview-roster">

<?php

	$ii = '0';
	foreach($slidelarr as $slide){
		$ii++;
		echo '<div class="post-preview tiny negative no-img '.$ii.'">';
			
			echo '<div class="post-author-info-wrap">';
			  #echo '<p class="post-author-info small light">By <span class="post-author">Dexter</span><span class="separator">|</span>Dec 15th, 2018</p>';
			  echo '<figure class="user-avatar tiny liquid">';
					  echo '<img src="'.$domain.'images/home-slide/'.$slide['gorsel'].'" alt="">';
					echo '</figure>';
					echo '<p class="post-preview-title">'.$slide['baslik'].'</p>';
			echo '</div>';
		echo '</div>';
	}

?>  

        </div>
      </div>
    </div>
  </div>