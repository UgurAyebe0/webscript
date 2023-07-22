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

				$this->param['global']['host']				= "185.160.30.205";
				$this->param['global']['mobile']			= "185.160.30.205";

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

				$this->param['global']['timezone']	= "Europe/Istanbul";

				date_default_timezone_set($this->param['global']['timezone']);

				$date = new DateTime();

				$this->param['global']['date']		= $date->format('d.m.Y');
				$this->param['global']['time']		= $date->format('H:i');
				$this->param['global']['stamp']		= $date->getTimestamp();

			/* Log ayarları - Bu bilgileri sistem geliştiricisinden alabilirsiniz */

				$this->param['log']['type']			= "file";
				$this->param['log']['path']			= "../system/log/";
				$this->param['log']['table']		= "sys_logs";
				$this->param['log']['date']			= $this->param['global']['date'];
				$this->param['log']['time']			= $this->param['global']['time'];
				$this->param['log']['file']			= $this->param['log']['path'].$this->param['log']['date'].".log";

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

				$this->param['db']['driver']		= "PDO";
				$this->param['db']['host']			= "localhost";
				$this->param['db']['port']			= "3306";
				$this->param['db']['name']			= "candywebh_candy_db";
				$this->param['db']['user']			= "candywebh_site";
				$this->param['db']['pass']			= "9uofE7iq3x";
				$this->param['db']['char']			= "utf8"; 
				
			/* Veritabanı ayarları - Bu bilgileri hosting firmanızdan alabilirsiniz */

				$this->param['puan']['driver']		= "PDO";
				$this->param['puan']['host']		= "localhost";
				$this->param['puan']['port']		= "3306";
				$this->param['puan']['name']		= "candywebh_Puan";
				$this->param['puan']['user']		= "candywebh_server";
				$this->param['puan']['pass']		= "LIPF4axzKS";
				$this->param['puan']['char']		= "utf8";
				
			/* Veritabanı ayarları - Bu bilgileri hosting firmanızdan alabilirsiniz */

				$this->param['faction']['driver']	= "PDO";
				$this->param['faction']['host']		= "localhost";
				$this->param['faction']['port']		= "3306";
				$this->param['faction']['name']		= "candywebh_Faction";
				$this->param['faction']['user']		= "candywebh_server";
				$this->param['faction']['pass']		= "LIPF4axzKS"; 
				$this->param['faction']['char']		= "utf8";
				
			/* Veritabanı ayarları - Bu bilgileri hosting firmanızdan alabilirsiniz */
  
				$this->param['istatistikler']['driver']		= "PDO";
				$this->param['istatistikler']['host']		= "localhost";
				$this->param['istatistikler']['port']		= "3306";
				$this->param['istatistikler']['name']		= "candywebh_Istatikler";
				$this->param['istatistikler']['user']		= "candywebh_server";
				$this->param['istatistikler']['pass']		= "LIPF4axzKS";
				$this->param['istatistikler']['char']		= "utf8";
				
			/* Veritabanı ayarları - Bu bilgileri hosting firmanızdan alabilirsiniz */
  
				$this->param['kpanel']['driver']	= "PDO";
				$this->param['kpanel']['host']		= "localhost";
				$this->param['kpanel']['port']		= "3306";
				$this->param['kpanel']['name']		= "candywebh_kpanel";
				$this->param['kpanel']['user']		= "candywebh_site";
				$this->param['kpanel']['pass']		= "9uofE7iq3x";
				$this->param['kpanel']['char']		= "utf8";
				  
				
			/* Veritabanı ayarları - Bu bilgileri hosting firmanızdan alabilirsiniz */
  
				$this->param['yetkiler']['driver']		= "PDO";
				$this->param['yetkiler']['host']		= "localhost";
				$this->param['yetkiler']['port']		= "3306";
				$this->param['yetkiler']['name']		= "candywebh_Yetkiler";
				$this->param['yetkiler']['user']		= "candywebh_server";
				$this->param['yetkiler']['pass']		= "LIPF4axzKS";
				$this->param['yetkiler']['char']		= "utf8";	

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