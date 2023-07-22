<?php

	class order extends core{

		public $config;
		public $db;
		public $bootstrap;
		private $user;
		
		public function __construct(){
			$this->user = $_SESSION['www']['user'];		
		}
		public function __destruct(){
			unset($this->user);
		}
		public function sipariskodu(){
			return $this->db->single("select sipariskodu from cus_uyeler where (user = :user);", array('user' => $this->user));
		}
		public function status(){		
			$stat     = true;
			$temp     = array();
			$sptFnl   = array();
			$sepet    = $this->db->single("select sepet from sal_sepet where (sepetkodu = :sepetkodu);", array('sepetkodu' => $this->user));
			$sepet    = json_decode($sepet, true);
			foreach($sepet as $stokkodu => $detail){
				$urun = $this->db->row("select * from cat_urunler where (stokkodu = :stokkodu);", array('stokkodu' => $stokkodu));
				if($detail['bdn'] == ''){ /* beden seçeneği yok */
					if($urun['stoksayisi'] < $detail['adt']){ /* sepetteki ürün sayısı stok sayısından fazla */
						$temp[$stokkodu][] = array('beden' => null, 'stoksayisi' => $urun['stoksayisi']);
					};
					$sptFnl[$stokkodu] = $detail['adt'];
				} else { /* beden seçeneği var */
					$hash = json_decode($urun['beden'], true);
					foreach($detail['bdn'] as $bedenkodu => $beden){
						if($hash[$bedenkodu]['stoksayisi'] < $beden['adt']){ /* sepetteki ürün sayısı stok sayısından fazla */
							$temp[$stokkodu][] = array('beden' => $bedenkodu, 'stoksayisi' => $hash[$bedenkodu]['stoksayisi']);
						};
						$sptFnl[$stokkodu.'_'.$bedenkodu] = $beden['adt'];
					};
				};
			};
			if(count($temp) > 0){
				foreach($temp as $stokkodu => $hash){
					foreach($hash as $key => $node){
						if($node['beden'] == ''){ /* beden seçeneği yok */
							$sepet[$stokkodu]['adt'] = $node['stoksayisi'];
						} else { /* beden seçeneği var */
							$sepet[$stokkodu]['bdn'][$node['beden']]['adt'] = $node['stoksayisi'];
							$adet = 0;
							foreach($sepet[$stokkodu]['bdn'] as $bedenkodu => $beden){
								$adet += $beden['adt'];
							};
							$sepet[$stokkodu]['adt'] = $adet;
						};
					};
				};
				$this->db->query("update sal_sepet set sepet = :sepet where (sepetkodu = :sepetkodu);", array('sepet' =>json_encode($sepet), 'sepetkodu' => $this->user));
				$_SESSION['www']['sepet']['alert'] = true;
				$stat = false;
			};			
			$temp     = array();
			$sprsFnl  = array();
			$siparis  = $this->db->single("select sepet from sal_siparisler where (user = :user) && (sipariskodu = :sipariskodu);", array('user' => $this->user, 'sipariskodu' => $this->sipariskodu()));
			$siparis  = json_decode($siparis, true);
			foreach($siparis as $stokkodu => $detail){
				$urun = $this->db->row("select * from cat_urunler where (stokkodu = :stokkodu);", array('stokkodu' => $stokkodu));
				if($detail['beden'] == ''){ /* beden seçeneği yok */
					if(($urun['stoksayisi'] < $detail['adet']) || ($urun['satisfiyatikd'] != $detail['satisfiyatikd'])){ /* sepetteki ürün sayısı stok sayısından fazla */
						$temp[$stokkodu][] = array('beden' => null, 'stoksayisi' => $urun['stoksayisi'], 'satisfiyatikd' => $urun['satisfiyatikd']);
					};
					$sprsFnl[$stokkodu] = $detail['adet'];
				} else { /* beden seçeneği var */
					$hash = json_decode($urun['beden'], true);
					foreach($detail['beden'] as $bedenkodu => $beden){
						if(($hash[$bedenkodu]['stoksayisi'] < $beden['adt']) || ($urun['satisfiyatikd'] != $detail['satisfiyatikd'])){ /* sepetteki ürün sayısı stok sayısından fazla */
							$temp[$stokkodu][] = array('beden' => $bedenkodu, 'stoksayisi' => $hash[$bedenkodu]['stoksayisi'], 'satisfiyatikd' => $urun['satisfiyatikd']);
						};
						$sprsFnl[$stokkodu.'_'.$bedenkodu] = $beden['adt'];
					};
				};
			};
			if(count($temp) > 0){
				foreach($temp as $stokkodu => $hash){
					foreach($hash as $key => $node){
						if($node['beden'] == ''){ /* beden seçeneği yok */
							$siparis[$stokkodu]['adet']          = $node['stoksayisi'];
							$siparis[$stokkodu]['satisfiyatikd'] = $node['satisfiyatikd'];
						} else { /* beden seçeneği var */
							$siparis[$stokkodu]['beden'][$node['beden']]['adt'] = $node['stoksayisi'];
							$siparis[$stokkodu]['satisfiyatikd']                = $node['satisfiyatikd'];
							$adet = 0;
							foreach($siparis[$stokkodu]['beden'] as $bedenkodu => $beden){
								$adet += $beden['adt'];
							};
							$siparis[$stokkodu]['adet'] = $adet;
						};
					};
				};
				$this->db->query("update sal_siparisler set sepet = :sepet where (user = :user) && (sipariskodu = :sipariskodu);", array('sepet' =>json_encode($siparis), 'user' => $this->user, 'sipariskodu' => $this->sipariskodu()));
				$_SESSION['www']['sepet']['alert'] = true;
				$stat = false;
			};

			if((array_intersect_assoc($sptFnl, $sprsFnl) == $sptFnl) && ($stat == true)){
				return true;
			} else {
				return false;
			};
		}
		public function siparis(){
			if(!empty($this->user) && ($this->db->single("select sipariskodu from cus_uyeler where (user = :user);", array('user' => $this->user)) == '')){
				$sipariskodu = uniqid();
				$bind = array(
					'sipariskodu'	=> $sipariskodu,
					'user'			=> $this->user
				);
				$this->db->query("update cus_uyeler set sipariskodu = :sipariskodu where (user = :user);", $bind);
				$date=new DateTime();
				$orderid = rand(10000000,$date->getTimestamp());
				$bind = array(
					'id'			=> $this->db->max('sal_siparisler'),
					'user'			=> $this->user,
					'sipariskodu'	=> $sipariskodu,
					'order_id'		=> $orderid,
					'stamp'			=> time(),
					'asama'			=> 'sipariskodu'
				);
				$this->db->query("insert into sal_siparisler (id, user, sipariskodu, order_id, stamp, asama) values (:id, :user, :sipariskodu, :order_id, :stamp, :asama);", $bind);
			};
		}
		public function uye(){
			$uye = $this->db->row("select * from cus_uyeler where (user = :user);", array('user' => $this->user));
			$this->db->query("update sal_siparisler set asama = 'uye', stamp = :stamp, uye = :uye where (user = :user) && (sipariskodu = :sipariskodu);", array('stamp' => time(), 'uye' => json_encode($uye), 'user' => $this->user, 'sipariskodu' => $uye['sipariskodu']));
		}
		public function sepet(){
			$sepet  = $this->db->single("select sepet from sal_sepet where (sepetkodu = :sepetkodu);", array('sepetkodu' => $this->user));
			$buffer = array();
			$sepet  = json_decode($sepet, true);
			foreach($sepet as $key => $node){
				$urun     = $this->db->row("select * from cat_urunler     where (stokkodu = :stokkodu);", array('stokkodu' => $node['stk']));
				$marka    = $this->db->row("select * from cat_markalar    where (id = :id);",             array('id' => $urun['marka']));
				$model    = $this->db->row("select * from cat_modeller    where (id = :id);",             array('id' => $urun['model']));
				$kategori = $this->db->row("select * from cat_kategoriler where (id = :id);",             array('id' => $urun['kategori']));
				$komisyon = $this->db->row("select * from cat_magazalar   where (id = :id);",             array('id' => $urun['magaza']));
				$buffer[$urun['stokkodu']] = array(
					'adet'			=> $node['adt'],
					'urunkodu'		=> $urun['urunkodu'],
					'urlkodu'		=> $urun['urlkodu'],
					'urun_TR'		=> $urun['urun_TR'],
					'marka_id'		=> $urun['marka'],
					'marka'			=> $marka['marka_TR'],
					'model_id'		=> $urun['model'],
					'model'			=> $model['model_TR'],
					'beden'			=> $node['bdn'],
					'uretici'		=> $urun['uretici'],
					'tedarikci'		=> $urun['tedarikci'],
					'kategori_id'	=> $urun['kategori'],
					'kategori'		=> $kategori['kategori_TR'],
					'magaza'		=> $urun['magaza'],
					'komisyon'		=> $komisyon['komisyon'],
					'doviztipi'		=> $urun['doviztipi'],
					'eskifiyat'		=> $urun['eskifiyat'],
					'alisfiyati'	=> $urun['alisfiyati'],
					'satisfiyatikh'	=> $urun['satisfiyatikh'],
					'satisfiyatikd'	=> $urun['satisfiyatikd'],
					'kdvorani'		=> $urun['kdvorani'],
					'barkod'		=> $urun['barkod'],
					'desi'			=> $urun['desi'],
					'kargosuresi'	=> $urun['kargosuresi'],
					'guncelleme'	=> $urun['stamp']
				);
			};
			if(count($sepet) > 0){
				$this->db->query("update sal_siparisler set asama = 'sepet', stamp = :stamp, sepet = :sepet where (user = :user) && (sipariskodu = :sipariskodu);", array('stamp' => time(), 'sepet' => json_encode($buffer), 'user' => $this->user, 'sipariskodu' => $this->sipariskodu()));
			} else {
				$this->db->query("update sal_siparisler set asama = 'uye', stamp = :stamp, sepet = '', adres = '' where (user = :user) && (sipariskodu = :sipariskodu);", array('stamp' => time(), 'user' => $this->user, 'sipariskodu' => $this->sipariskodu()));
			};
		}
		public function _adres(){
			return $this->db->single("select adres from sal_siparisler where (user = :user) && (sipariskodu = :sipariskodu);", array('user' => $this->user, 'sipariskodu' => $this->sipariskodu()));
		}
		public function adres($post){
			$adreslerimTeslimat	= $post['adreslerimTeslimat'];
			$adresadi			= $post['adresadi'];
			$adi				= $post['adi'];
			$soyadi				= $post['soyadi'];
			$kimlikno			= $post['kimlikno'];
			$tcuyrukludegilim	= $post['tcuyrukludegilim'];
			$adres				= $post['adres'];
			$postakodu			= $post['postakodu'];
			$il					= $post['il'];
			$ilce				= $post['ilce'];
			$semt				= $post['semt'];
			$ceptel				= $post['ceptel'];
			$faturatipi			= $post['faturatipi'];
			$firmaadi			= $post['firmaadi'];
			$vergidairesi		= $post['vergidairesi'];
			$vergino			= $post['vergino'];
			$teslimat			= $post['teslimat'];
			if($teslimat == 'on'){
				$adreslerimFatura	= $post['adreslerimTeslimat'];
				$f_adi				= $post['adi'];
				$f_soyadi			= $post['soyadi'];
				$f_kimlikno			= $post['kimlikno'];
				$f_adres			= $post['adres'];
				$f_postakodu		= $post['postakodu'];
				$f_il				= $post['il'];
				$f_ilce				= $post['ilce'];
				$f_semt				= $post['semt'];
				$post['adreslerimFatura']	= $post['adreslerimTeslimat'];
				$post['f_adi']				= $post['adi'];
				$post['f_soyadi']			= $post['soyadi'];
				$post['f_kimlikno']			= $post['kimlikno'];
				$post['f_adres']			= $post['adres'];
				$post['f_postakodu']		= $post['postakodu'];
				$post['f_il']				= $post['il'];
				$post['f_ilce']				= $post['ilce'];
				$post['f_semt']				= $post['semt'];
			} else {
				$adreslerimFatura	= $post['adreslerimFatura'];
				$f_adi				= $post['f_adi'];
				$f_soyadi			= $post['f_soyadi'];
				$f_kimlikno			= $post['f_kimlikno'];
				$f_adres			= $post['f_adres'];
				$f_postakodu		= $post['f_postakodu'];
				$f_il				= $post['f_il'];
				$f_ilce				= $post['f_ilce'];
				$f_semt				= $post['f_semt'];
			};
			/*if(($adreslerimTeslimat == 'null') && empty($adresadi)){
				return json_encode(array('alert' => $this->bootstrap->alertBS('Yeni adres oluşturabilmek için \'Fatura Adresi\' kısmındaki \'Adres Adı\' alanını doldurmalısınız.', 'info')));
			};
			if(empty($adi) || empty($soyadi) || empty($adres) || empty($il) || empty($ilce) || empty($semt) || empty($ceptel)){
				return json_encode(array('alert' => $this->bootstrap->alertBS('Lütfen tüm alanları eksiksiz doldurunuz.', 'danger')));
			};
			if(($faturatipi == 'kurumsal') && (empty($firmaadi) || empty($vergidairesi) || empty($vergino))){
				return json_encode(array('alert' => $this->bootstrap->alertBS('Lütfen tüm alanları eksiksiz doldurunuz.', 'danger')));
			};
			if(($teslimat != 'on') && (empty($f_adi) || empty($f_soyadi) || empty($f_adres) || empty($f_il) || empty($f_ilce) || empty($f_semt))){
				return json_encode(array('alert' => $this->bootstrap->alertBS('Lütfen tüm alanları eksiksiz doldurunuz.', 'danger')));
			};*/
			if($adreslerimTeslimat == 'null'){
				$data = array(
					'adresadi'		=> $adresadi,
					'faturatipi'	=> $faturatipi,
					'adi'			=> $adi,
					'soyadi'		=> $soyadi,
					'adres'			=> $adres,
					'postakodu'		=> $postakodu,
					'il'			=> $il,
					'ilce'			=> $ilce,
					'semt'			=> $semt,
					'ceptel'		=> $ceptel,
					'firmaadi'		=> $firmaadi,
					'vergidairesi'	=> $vergidairesi,
					'vergino'		=> $vergino
				);
				$hash = $this->db->single("select adres from cus_uyeler where (user = :user);", array('user' => $this->user));
				if(!empty($hash)){
					$buffer   = json_decode($hash, true);
					$buffer[] = $data;
					$buffer   = json_encode($buffer);
				} else {
					$buffer   = json_encode(array($data));
				};
				$this->db->query("update cus_uyeler set adres = :adres where (user = :user);", array('adres' => $buffer, 'user' => $this->user));
			};
			$buffer = array();
			foreach($post as $key => $value){
				if(!in_array($key, array('sipariskodu', 'status'))){
					$buffer[$key] = $value;
				};
			};
			$adres = json_encode($buffer);
			$this->db->query("update sal_siparisler set asama = 'adres', adres = :adres where (user = :user) && (sipariskodu = :sipariskodu);", array('adres' => $adres, 'user' => $this->user, 'sipariskodu' => $this->sipariskodu()));
			$json['alert']    = $this->bootstrap->alertBS('Adres bilgileriniz başarılı bir şekilde kaydedildi. Lütfen bekleyiniz...', 'success');
			$json['location'] = $this->config['global']['domain']."siparis/odeme";
			return json_encode($json);
		}
	};
?>