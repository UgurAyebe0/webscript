<?php
	class graph extends core{		
		public function __construct(){
			
		}
		public function __destruct(){

		}
		public function render($path, $sz = 0, $logo = false, $save = false, $quality = 100){
			if(!empty($path) && is_file($path)){
				$name = explode('/', $path);
				$name = $name[count($name) - 1];
				$ext  = mime_content_type($path);
				if(in_array($ext, array('image/jpeg', 'image/png', 'image/gif', 'image/bmp'))){
					switch($ext){
						case 'image/jpeg' :
							$bg = imagecreatefromjpeg($path);
						break;
						case 'image/png'  :
							$bg = imagecreatefrompng($path);
						break;
						case 'image/gif'  :
							$bg = imagecreatefromgif($path);
						break;
						case 'image/bmp'  :
							$bg = imagecreatefromwbmp($path);
						break;
						default           :
							$bg = imagecreatefromjpeg($path);
						break;
					};
					list($width, $height) = getimagesize($path);
					$height = ($sz * ($height / $width));
					$nl = imagecreatetruecolor($sz, $sz);
					imagefill($nl, 0, 0, imagecolorallocate($nl, 255, 255, 255));
					imagecopyresampled($nl, $bg, 0, (($sz - $height) / 2), 0, 0, $sz, $height, imagesx($bg), imagesy($bg));
					if($logo === true){
						$wm  = imagecreatefrompng('../cdn/img/watermark.png');
						$ofs = 10;
						$wmw = imagesx($wm);
						$wmh = imagesy($wm);
						$wml = (imagesx($nl) - $wmw) - $ofs;
						$wmt = (imagesy($nl) - $wmh) - $ofs;
						imagealphablending($wm, false);
						imagesavealpha($wm, true);
						imagecopy($nl, $wm, $wml, $wmt, 0, 0, $wmw, $wmh);
					};
					switch($ext){
						case 'image/jpeg' :
							header('Content-type: image/jpeg');
							if($save == true){
								imagejpeg($nl, '../cdn/files/product_'.$sz.'/'.$name, $quality);
								chmod('../cdn/files/product_'.$sz.'/'.$name, 0777);
							} else {
								imagejpeg($nl);
							};
						break;
						case 'image/png'  :
							header('Content-type: image/png');
							if($save == true){
								imagepng($nl, '../cdn/files/product_'.$sz.'/'.$name);
								chmod('../cdn/files/product_'.$sz.'/'.$name, 0777);
							} else {
								imagepng($nl);
							};
						break;
						case 'image/gif'  :
							header('Content-type: image/gif');
							if($save == true){
								imagegif($nl, '../cdn/files/product_'.$sz.'/'.$name);
								chmod('../cdn/files/product_'.$sz.'/'.$name, 0777);
							} else {
								imagegif($nl);
							};
						break;
						case 'image/bmp'  :
							header('Content-type: image/bmp');
							if($save == true){
								imagewbmp($nl, '../cdn/files/product_'.$sz.'/'.$name);
								chmod('../cdn/files/product_'.$sz.'/'.$name, 0777);
							} else {
								imagewbmp($nl);
							};
						break;
						default           :
							header('Content-type: image/jpeg');
							if($save == true){
								imagejpeg($nl, '../cdn/files/product_'.$sz.'/'.$name);
								chmod('../cdn/files/product_'.$sz.'/'.$name, 0777);
							} else {
								imagejpeg($nl);
							};
						break;
					};
					imagedestroy($nl);
				} else {
					if($save == true){
						copy('../cdn/files/product/'.$name, '../cdn/files/product_'.$sz.'/'.$name);
						chmod('../cdn/files/product_'.$sz.'/'.$name, 0777);
					} else {
						echo '<img src="../cdn/files/product/'.$name.'" />';
					};
				};
			};
		}
	};
?>