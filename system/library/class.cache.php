<?php
	class cache extends core{
		public $memcache;
		public $memcached;
		public $config;
		public $crypt;
		public $dispatcher;		
		public function __construct(){
		}
		public function __destruct(){
			unset($this->memcache);
			unset($this->memcached);
			unset($this->config);
			unset($this->crypt);
			unset($this->dispatcher);
		}
		private function open(){
			try{
				return $this->memcache->connect($this->config['cache']['host'], $this->config['cache']['port']);
			} catch (Exception $e){
				echo $e;
			};
		}
		private function close(){
			return $this->memcache->close();
		}
		public function key($param){
			$param = preg_replace('/[^a-zA-Z0-9]+/', null, $param);
			$param = substr($param, 0, 250);
			$ref   = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
			if($this->keychain()){
				$keychain = $this->keychain();
				array_push($keychain, array('key' => $param, 'ref' => $ref, 'stamp' => time()));
				$this->set('keychain', $keychain);
			} else {
				$this->set('keychain', array(array('key' => $param, 'ref' => $ref, 'stamp' => time())));
			};
			return $param;
		}
		public function keychain(){
			return $this->get('keychain');
		}
		public function set($key, $data, $zip = false, $time = 0){
			if(empty($time)) $time = $this->config['cache']['time'];
			if(!empty($key) && !empty($data)){
				if($this->open()){
					$stat = $this->memcache->set($key, $data, $zip, $time);
					$this->close();
					return $stat;
				} else {
					return false;
				};
			} else {
				return false;
			};
		}
		public function cnt($key){
			if(!empty($key)){
				if($this->open()){
					$buffer = $this->memcache->get($key);
					$this->close();
					if(is_array($buffer)){
						return count($buffer);
					} elseif(is_string($buffer)){
						return 1;
					};
				} else {
					return false;
				};
			} else {
				return false;
			};
		}
		public function get($key){
			if(!empty($key)){
				if($this->open()){
					$buffer = $this->memcache->get($key);
					$this->close();
					return $buffer;
				} else {
					return false;
				};
			} else {
				return false;
			};
		}
		public function del($key){
			if(!empty($key)){
				if($this->open()){
					$stat = $this->memcache->delete($key);
					$this->close();
					return $stat;
				} else {
					return false;
				};
			} else {
				return false;
			};
		}
		public function flush(){
			if($this->open()){
				$stat = $this->memcache->flush();
				$this->close();
				return $stat;
			} else {
				return false;
			};
		}
		public function version(){
			if($this->open()){
				$version = $this->memcache->getVersion();
				$this->close();
				return $version;
			} else {
				return false;
			};
		}
		public function stats(){
			if($this->open()){
				$buffer = $this->memcache->getStats();
				$this->close();
				return $buffer;
			} else {
				return false;
			};
		}
	};
?>