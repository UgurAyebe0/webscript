<?php
	class config extends core{

		public  $param;
		public  $subStatus;
		private $httpStatus;
		private $sslStatus;
		
		public function __construct(){
			$this->httpStatus = $_SERVER['HTTPS'];
			$this->sslStatus  = false;
			$this->subStatus  = explode('.', $_SERVER['HTTP_HOST']);
			$this->subStatus  = $this->subStatus[0];
		}

		public function __destruct(){
			unset($this->param);
		}
		
		

		public function get(){
			/* Genel ayarlar - Bu bilgileri sistem geliştiricisinden alabilirsiniz */

				$this->param['global']['host']				= "www.candycraft.net";
				$this->param['global']['mobile']			= "www.candycraft.net";

				if($this->sslStatus == true){
					if($this->subStatus != "m"){
						$this->param['global']['domain']	= "https://".$this->param['global']['host']."/";
					} else {
						$this->param['global']['domain']	= "https://".$this->param['global']['mobile']."/";
					};
					$this->param['global']['plugin']		= "https://".$this->param['global']['host']."/plugin/";
					$this->param['global']['pulse']			= "https://".$this->param['global']['host']."/pulse/";
					$this->param['global']['CDN']			= "https://".$this->param['global']['host']."/cdn/";
				} else {
					if($this->subStatus != "m"){
						$this->param['global']['domain']	= "http://".$this->param['global']['host']."/";
					} else {
						$this->param['global']['domain']	= "http://".$this->param['global']['mobile']."/";
					};
					$this->param['global']['plugin']		= "http://".$this->param['global']['host']."/plugin/";
					$this->param['global']['pulse']			= "http://".$this->param['global']['host']."/pulse/";
					$this->param['global']['CDN']			= "http://".$this->param['global']['host']."/cdn/";
				}; 

				if(($this->httpStatus != "on") && ($this->sslStatus == true)){
					if($this->subStatus != "m"){
						header('Location: https://'.$this->param['global']['host'].$_SERVER['REQUEST_URI']);
					} else {
						header('Location: https://'.$this->param['global']['mobile'].$_SERVER['REQUEST_URI']);
					};
				} elseif(($this->httpStatus == "on") && ($this->sslStatus == false)){
					if($this->subStatus != "m"){
						header('Location: http://'.$this->param['global']['host'].$_SERVER['REQUEST_URI']);
					} else {
						header('Location: http://'.$this->param['global']['mobile'].$_SERVER['REQUEST_URI']);
					};
				};

			/* Tarih, Saat ayarları - Bu bilgileri sistem geliştiricisinden alabilirsiniz */

				#$this->param['global']['timezone']	= "Europe/Istanbul";

				#date_default_timezone_set($this->param['global']['timezone']);

				#$date = new DateTime();

				#$this->param['global']['date']		= $date->format('d.m.Y');
				#$this->param['global']['time']		= $date->format('H:i');
				#$this->param['global']['stamp']		= $date->getTimestamp();



			/* Cache ayarları - Bu bilgileri sistem geliştiricisinden alabilirsiniz 

				$this->param['cache']['driver']		= "memcache";
				$this->param['cache']['host']		= "127.0.0.1";
				$this->param['cache']['port']		= "11911"; /* 11211 default */
				/* saniye cinsinden 
				$this->param['cache']['time']		= 3600;
				/* free - active 
				$this->param['cache']['mode']		= "active";

			/* Sepet ayarları - Bu bilgileri sistem geliştiricisinden alabilirsiniz 

				$this->param['cart']['mode']		= "cookie";

			/* Veritabanı ayarları - Bu bilgileri hosting firmanızdan alabilirsiniz */


				
			
			/* FTP ayarları - Bu bilgileri hosting firmanızdan alabilirsiniz */

				$this->param['ftp']['host']			= "ftp.candy.com";  
				$this->param['ftp']['port']			= "21";
				$this->param['ftp']['user']			= "candy";
				$this->param['ftp']['pass']			= "";

			/* Mail ayarları - Bu bilgileri hosting firmanızdan alabilirsiniz */

				
			return $this->param;
		}
	};	
?>