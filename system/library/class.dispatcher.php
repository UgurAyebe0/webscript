<?php
	class dispatcher extends core{
		public $status;
		public $route;
		public function __construct(){
			$this->status = 'requ';
			#$this->route = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		}
		public function __destruct(){
			unset($this->status);
			unset($this->route);
		}
		public function getURL($s, $use_forwarded_host = false){
			$ssl  = (!empty($s['HTTPS']) && $s['HTTPS'] == 'on') ? true:false;
			$prot = strtolower($s['SERVER_PROTOCOL']);
			$prot = substr($prot, 0, strpos($prot, '/')).(($ssl) ? 's' : '');
			$port = $s['SERVER_PORT'];
			$port = ((!$ssl && $port=='80') || ($ssl && $port=='443')) ? '' : ':'.$port;
			$host = ($use_forwarded_host && isset($s['HTTP_X_FORWARDED_HOST'])) ? $s['HTTP_X_FORWARDED_HOST'] : (isset($s['HTTP_HOST']) ? $s['HTTP_HOST'] : null);
			$host = isset($host) ? $host : $s['SERVER_NAME'].$port;
			$requ = $_SERVER['REQUEST_URI'];
			$reff = $_SERVER['HTTP_REFERER'];
			if($this->status == "requ"){
				return $prot.'://'.$host.$requ;
			} else {
				return $reff;
			};
		}
		public function get($status){
			$this->status = $status;
			$this->route  = $this->getURL($_SERVER);
			$hash = explode('?r=', $this->route);
			if(count($hash) > 1){
				$hash = explode('&', $hash[1]);
				$hash = explode('/', $hash[0]);
				if(!empty($hash[2])){
					return $hash[0].'/'.$hash[1].'.'.$hash[2];
				} else {
					return $hash[0].'/'.$hash[1];
				};
			} else {
				return 'control/control';
			};
		}
	};
?>