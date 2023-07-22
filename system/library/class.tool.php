<?php

	/**
	* 
	*/

	class tool extends core{

		public  $db;
		public  $calc;
		private $buffer;
		private $table;
		
		public function __construct(){
			$this->table = "cat_kategoriler";
		}

		public function __destruct(){
			unset($this->db);
			unset($this->buffer);
			unset($this->table);
		}

		public function substr($string, $start, $stop){
			$string = mb_substr($string, $start, $stop, 'UTF-8');
			if(strlen($string) >= $stop) $string .= "...";
			return $string;
		}

		public function whatIsMyIp($type = 'global'){
			$ip = array();
			$ip['local'] = $_SERVER['REMOTE_ADDR'];
			if(getenv("HTTP_CLIENT_IP")){
				$ip['global'] = getenv("HTTP_CLIENT_IP");
			} elseif(getenv("HTTP_X_FORWARDED_FOR")){
				$ip['global'] = getenv("HTTP_X_FORWARDED_FOR");
				if(strstr($ip['global'], ',')){
					$tmp = explode(',', $ip['global']);
					$ip['global'] = trim($tmp[0]);
				};
			} else {
				$ip['global'] = getenv("REMOTE_ADDR");
			};
			return $ip[$type];
		}

		public function countZiyaretci($modul, $kod){
			$oturum   = $_COOKIE['__pcrt'];
			$ipadresi = $this->whatIsMyIp();
			$stamp    = time();
			$link     = substr($_SERVER['REQUEST_URI'], 1);
			if(!empty($oturum) && !empty($modul) && !empty($kod)){
				$bind     = array('modul' => $modul, 'kod' => $kod);
				$param    = $this->db->row("select count(rep_ziyaretci.id) as _count, rep_ziyaretci.* from rep_ziyaretci where (rep_ziyaretci.modul = :modul) && (rep_ziyaretci.kod = :kod);", $bind);
				if($param['_count'] > 0){
					$data = json_decode($param['data'], true);
					if(empty($data[$ipadresi][$oturum])){
						$kst = $param['kst'] + 1;
					} else {
						$kst = $param['kst'];
					};
					$ksg  = $param['ksg'] + 1;
					$data[$ipadresi][$oturum][] = $stamp;
					$data = json_encode($data);
					$bind = array(
						'modul'	=> $modul,
						'kod'	=> $kod,
						'link'	=> $link,
						'kst'	=> $kst,
						'ksg'	=> $ksg,
						'data'	=> $data
					);
					$this->db->query("update rep_ziyaretci set link = :link, kst = :kst, ksg = :ksg, data = :data where (modul = :modul) && (kod = :kod);", $bind);
				} else {
					$data = json_encode(array($ipadresi => array($oturum => array($stamp))));
					$bind = array(
						'id'	=> $this->db->max('rep_ziyaretci'),
						'modul'	=> $modul,
						'kod'	=> $kod,
						'link'	=> $link,
						'kst'	=> 1,
						'ksg'	=> 1,
						'data'	=> $data
					);
					$this->db->query("insert into rep_ziyaretci (id, modul, kod, link, kst, ksg, data) values (:id, :modul, :kod, :link, :kst, :ksg, :data);", $bind);
				};
			};
		}

		public function cURLPost($url, $params){
			unset($buffer);
			foreach($params as $key => $value){ 
				$buffer .= $key.'='.$value.'&'; 
			};
			$buffer = rtrim($buffer, '&');
			$ch = curl_init();  
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HEADER, false); 
			curl_setopt($ch, CURLOPT_POST, count($buffer));
			curl_setopt($ch, CURLOPT_POSTFIELDS, $buffer);    
			$output = curl_exec($ch);
			curl_close($ch);
			return $output;
		}

		public function prepareGetAltTable($alt_id, $space = 1){
			$bind = array('alt_id' => $alt_id);
			$hash = $this->db->query("select * from ".$this->table." where (alt_id = :alt_id) order by id asc;", $bind);
			foreach($hash as $key => $node){
				if(!empty($node['id'])){
					$this->buffer[$node['id']]['space']			= $space;
					$this->buffer[$node['id']]['kategorikodu']	= $node['kategorikodu'];
					$this->buffer[$node['id']]['kategori']		= $node['kategori_TR'];
					$this->buffer[$node['id']]['yayin']			= $node['yayin'];
					$this->prepareGetAltTable($node['id'], ($space + 3));
				};
			};
		}

		public function getAltTable($id){
			$buffer .= '<option value="0">Ana Kategori</option>';
			if(!empty($id)){
				$this->prepareGetAltTable($id);
				foreach($this->buffer as $key => $node){
					$buffer .= '<option value="'.$node['kategorikodu'].'">'.str_repeat(' - ', $node['space']).$node['kategori'].'</option>';
				};
			} else{
				$this->prepareGetAltTable(0);
				foreach($this->buffer as $key => $node){
					$buffer .= '<option value="'.$key.'">'.str_repeat(' - ', $node['space']).$node['kategori'].'</option>';
				};
			};
			return $buffer;
		}

		public function getCargoPeriods($urun){
			$zaman = $urun['kargosuresi'];
			foreach($this->db->query("select * from car_sureler where (durum = 1);") as $node){
				if($node['kategori'] == '"0"') $node['kategori'] = '';

				if((empty($node['marka']) && empty($node['stok']) && empty($node['kategori'])) && ($node['kargo'] > $zaman)){
					$zaman = $node['kargo'];
				};

				if((($node['marka'] == $urun['marka']) && empty($node['stok']) && empty($node['kategori'])) && ($node['kargo'] > $zaman)){
					$zaman = $node['kargo'];
				};

				if((empty($node['marka']) && ($urun['stoksayisi'] <= $node['stok']) && empty($node['kategori'])) && ($node['kargo'] > $zaman)){
					$zaman = $node['kargo'];
				};

				if((($node['marka'] == $urun['marka']) && ($urun['stoksayisi'] <= $node['stok']) && empty($node['kategori'])) && ($node['kargo'] > $zaman)){
					$zaman = $node['kargo'];
				};

				if((empty($node['marka']) && empty($node['stok']) && in_array($urun['kategori'], json_decode($node['kategori'], true))) && ($node['kargo'] > $zaman)){
					$zaman = $node['kargo'];
				};

				if((($node['marka'] == $urun['marka']) && empty($node['stok']) && in_array($urun['kategori'], json_decode($node['kategori'], true))) && ($node['kargo'] > $zaman)){
					$zaman = $node['kargo'];
				};

				if((empty($node['marka']) && ($urun['stoksayisi'] <= $node['stok']) && in_array($urun['kategori'], json_decode($node['kategori'], true))) && ($node['kargo'] > $zaman)){
					$zaman = $node['kargo'];
				};

				if((($node['marka'] == $urun['marka']) && ($urun['stoksayisi'] <= $node['stok']) && in_array($urun['kategori'], json_decode($node['kategori'], true))) && ($node['kargo'] > $zaman)){
					$zaman = $node['kargo'];
				};
			};
			return $zaman;
		}

		public function minuteToStamp($minute){
			return ($minute * 60);
		}

		public function hourToStamp($hour){
			return ($hour * $this->minuteToStamp(60));
		}

		public function dayToStamp($day){
			return ($day * $this->hourToStamp(24));
		}

		public function weekToStamp($week){
			return ($week * $this->dayToStamp(7));
		}

		public function stampToMinute($stamp){
			return ($stamp / $this->minuteToStamp(1));
		}

		public function stampToHour($stamp){
			return ($stamp / $this->hourToStamp(1));
		}

		public function stampToDay($stamp){
			return ($stamp / $this->dayToStamp(1));
		}

		public function stampToWeek($stamp){
			return ($stamp / $this->weekToStamp(1));
		}

		private function stampDiff_format($param){
			if(strlen($param) == 1){
				return "0".$param;
			} else {
				return $param;
			};
		}

		public function stampDiff($start, $stop){
			$gun_    = 1000 * 60 * 60 * 24;
			$saat_   = 1000 * 60 * 60;
			$dakika_ = 1000 * 60;
			$saniye_ = 1000;
			$stamp  = ($stop * 1000) - ($start * 1000);
			$gun    = "00";
			$saat   = "00";
			$dakika = "00";
			$saniye = "00";
			$kalan  = "00";
			if($stamp >= $gun_){
				$kalan = $stamp % $gun_;
				$gun   = $this->stampDiff_format(($stamp - $kalan) / $gun_);
				$stamp = $kalan;
			};
			if($stamp >= $saat_){
				$kalan = $stamp % $saat_;
				$saat  = $this->stampDiff_format(($stamp - $kalan) / $saat_);
				$stamp = $kalan;
			};
			if($stamp >= $dakika_){
				$kalan  = $stamp % $dakika_;
				$dakika = $this->stampDiff_format(($stamp - $kalan) / $dakika_);
				$stamp  = $kalan;
			};
			if($stamp >= $saniye_){
				$kalan  = $stamp % $saniye_;
				$saniye = $this->stampDiff_format(($stamp - $kalan) / $saniye_);
				$stamp  = $kalan;
			};
			return $gun.":".$saat.":".$dakika.":".$saniye;
		}

	};

?>