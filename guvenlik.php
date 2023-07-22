<?php
header("Content-Type: image/jpeg");  
session_start();
//doğrulama kodunun boyutunu giriyoruz
$width = 100;
$height = 25;  
 
//resimi oluşturuyoruz
$image = ImageCreate($width, $height);  
 
//kullanacağımız renkleri oluşturuyoruz
$siyah = ImageColorAllocate($image, 0, 0, 0);
$gri = imagecolorallocate($image, 128, 128, 128);
$beyaz = ImageColorAllocate($image, 255, 255, 255);
 
//arkapalanı yapıyoruz
ImageFill($image, 0, 0, $siyah); 
 
//resmin uzerine yazacağımız kodu yapıyoruz
$dk = Sha1(rand(0,1000000));
$dk = substr($dk, Rand(0,35), 6); 
$_SESSION['dogrulamakodu'] = $dk;
//rastgele değerimizi resmin üzerine koyuyoruz
ImageString($image, 3, 30, 3, $dk, $beyaz); 
 
//resme çizgi atarak kırılmasını zorlaştırıyoruz
ImageRectangle($image,0,0,$width-1,$height-1,$gri);

imageline($image, 0, $height/2, $width, $height/2, $beyaz);
 
 
//resmi oluşturuyoruz
ImageJpeg($image); 
 
//kaynağımızı temizliyoruz
ImageDestroy($image);
?>
