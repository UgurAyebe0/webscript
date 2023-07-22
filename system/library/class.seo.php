<?php

	/*
	*
	*
	*
	*/

	class seo extends core{

		public $config;

		public function __construct(){

		}

		public function __destruct(){

		}

		public function htmlParse($buffer){
			$buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer);
			$buffer = str_replace(array("\r\n", "\r", "\n", "\t", '   ', '    ','     '), '', $buffer);
			return $buffer;
		}

		public function url($url){
			if($url){
				$url     = trim($url);
				$search  = array('Ğ','Ü','Ş','İ','Ö','Ç','ğ','ü','ş','ı','ö','ç','é','&'   ,'||');
				$replace = array('g','u','s','i','o','c','g','u','s','i','o','c','e',' ve ',' veya ');
				$url     = str_replace($search, $replace, $url);
				$url     = strtolower($url);
				$url     = str_split($url);
				foreach($url as $letter){
					if(preg_match('/[a-z0-9]/', $letter)){
						$buffer .= $letter;
					} elseif(substr($buffer, (strlen($buffer) -1), strlen($buffer)) != '-'){
						$buffer .= '-';
					};
				};
				return $buffer;
			};
			return;
		}

		private function prepareHref($param, $attr, $regex){
			if(isset($param[$attr])){
				if($param[$attr] != false){
					return $attr."=".$param[$attr];
				};
			} elseif(!empty($_REQUEST[$attr])){
				if(!empty($regex)){
					if(preg_match($regex, $_REQUEST[$attr])){
						return $attr."=".$_REQUEST[$attr];
					};
				} else {
					return $attr."=".$_REQUEST[$attr];
				};
			};
		}

		public function href($param = array()){
			
			$attrs  = array();
			$buffer = array();

			if($param['domain'] != ''){
				$domain = $param['domain'];
			} elseif(!empty($this->config['global']['domain'])){
				$domain = $this->config['global']['domain'];
			};

			if(substr($domain, strlen($domain) - 1) != "/"){
				$domain = $domain."/";
			};

			if(isset($param['base'])){
				$base = $param['base'];
			} elseif(!empty($_REQUEST['p'])){
				$base = $_REQUEST['p'];
			} elseif(!empty($_REQUEST['m'])){
				$base = $_REQUEST['m'];
			};

			$attrs['ara']      = $this->prepareHref($param, 'ara');
			$attrs['show']     = $this->prepareHref($param, 'show',     '/^([a-zA-Z]+)$/');
			$attrs['sort']     = $this->prepareHref($param, 'sort',     '/^([a-zA-Z]+)$/');
			$attrs['limit']    = $this->prepareHref($param, 'limit',    '/^([0-9]+)$/');
			$attrs['page']     = $this->prepareHref($param, 'page',     '/^([0-9]+)$/');
			$attrs['kategori'] = $this->prepareHref($param, 'kategori', '/^([0-9-,]+)$/');
			$attrs['marka']    = $this->prepareHref($param, 'marka',    '/^([0-9-,]+)$/');
			$attrs['magaza']   = $this->prepareHref($param, 'magaza',    '/^([0-9-,]+)$/');
			$attrs['model']    = $this->prepareHref($param, 'model',    '/^([0-9-,]+)$/');
			$attrs['beden']    = $this->prepareHref($param, 'beden',    '/^([0-9-,]+)$/');
			$attrs['fiyat']    = $this->prepareHref($param, 'fiyat',    '/^([0-9-,]+)$/');
			$attrs['diger']    = $this->prepareHref($param, 'diger',    '/^([a-zA-Z0-9-,]+)$/');

			foreach($attrs as $key => $attr){
				if(!empty($attr)){
					$buffer[] = $attr;
				};
			};

			if(count($buffer) > 0){
				$attrs = "?".implode('&', $buffer);
			} else {
				unset($attrs);
			};

			return $domain.$base.$attrs;

		}

	};

?>