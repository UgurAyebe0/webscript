<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script>
<?php
$host="mysql.candycraft.net:10289";
$kullaniciadi="site";
$sifre="WQjirCAq";
$veritabaniadi="kpanel";
$baglanti = @mysql_connect($host, $kullaniciadi, $sifre);
$veritabani = @mysql_select_db($veritabaniadi);
echo '<meta name=viewport content="width=device-width, initial-scale=1">';

$sql = ("select * from Kullanicilar where (username like '%".$_GET['qrw']."%') limit 4");
echo'<style>
.aramahr {
    display: block;
    height: 1px;
    border: 0;
    border-top: 1px solid #e6e6e6;
    margin: 0;
    padding: 0; 
}
.aramadiv{
	font-family:Arial;
	font-size:12px;
}
.aramadiv:hover{
	background-color:#eeeeee;
	border-radius:10px;
}
</style>';
$qrw=$_GET["qrw"];

  $hint="";
if($query = mysql_query($sql))
{
	while ($row = mysql_fetch_assoc($query))
	{
	 $y = $row['username'];

echo "
	$('#".$y."').click(function(){
    $('#count').val('".$y."');
});

";		

		 if($hint == ''){
			$hint= "<div class='aramadiv' style='line-height:50px;color:#000;padding-left:20px;'><input type='button' id ='".$y."' value='".$y."'></div>";
		 }else{
			 $hint = $hint . "<hr class='aramahr'><div class='aramadiv' style='line-height:50px;color:#000;padding-left:20px;'><input type='button' id ='".$y."' value='".$y."'></div>";
		 }		 
	


  }
 }

if($hint != NULL){
	echo $hint;
}else{echo '<span style="line-height:50px;padding-left:15px;color:#000;padding-left:20px;">Aradığınız Kullanıcı Bulunamadı</span>';}


?>