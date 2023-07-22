<?php

	/*
	*
	*
	*
	*/

	class xml_core extends core{
		
		public  $db;
		public  $log;
		public  $seo;
		public  $calc;
		private $table;
		private $markalar;
		private $modeller;
		private $bedenler;
		
		public function __construct(){
			$this->table['kategoriler']	= "cat_kategoriler";
			$this->table['urunler']		= "cat_urunler";
			$this->table['markalar']	= "cat_markalar";
			$this->table['modeller']	= "cat_modeller";
			$this->table['bedenler']	= "cat_bedenler";
			$this->table['iliskiler']	= "xml_iliskiler";
			$this->markalar				= array();
			$this->modeller				= array();
			$this->bedenler				= array();
		}

		public function __destruct(){
			unset($this->table);
			unset($this->markalar);
			unset($this->modeller);
			unset($this->bedenler);
		}

		/* Format   Parameters */

			private function formatEntity($str = null){
				$search  = array('&amp;', '&amp;', '&amp;', '&amp;', '&lt;', '&gt;', '&quot;', '&times;', '&Ouml;', '&ouml;', '&Uuml;', '&uuml;', '&ccedil;');
				$replace = array('&',     '&',     '&',     '&',     '<',    '>',    '"',      '×',       'Ö',      'ö',      'Ü',      'ü',      'ç');
				return     str_replace($search, $replace, $str);
			}

			private function formatString($str = null){
				$buffer = array();
				foreach(explode(' ', $str) as $value){
					$buffer[] = ucfirst(mb_strtolower($value, 'UTF-8'));
				};
				return implode(' ', $buffer);
			}

			private function formatStringDeep($str = null){
				$str = $this->seo->url($str);
				$str = preg_replace("/[^a-zA-Z0-9]+/", null, $str);
				$str = strtolower($str);
				return $str;
			}

			private function formatPrice($listefiyati = 0, $indirimfiyati = 0, $kampanyafiyati = 0, $ufiyataekle = 0, $kfiyataekle = 0){
				if(($indirimfiyati != '') && ($indirimfiyati != 0)){ /* indirim fiyatı var */
					if(($kampanyafiyati != '') && ($kampanyafiyati != 0)){ /* indirim fiyatı var, kampanya fiyatı var */
						return array(
							'listefiyati'	=> $listefiyati,
							'eskifiyat'		=> $kampanyafiyati,
							'satisfiyatikd'	=> $indirimfiyati
						);
					} else { /* indirim fiyatı var, kampanya fiyatı yok */
						return array(
							'listefiyati'	=> $listefiyati,
							'eskifiyat'		=> $listefiyati,
							'satisfiyatikd'	=> $indirimfiyati
						);
					};
				} else { /* indirim fiyatı yok */
					if(($kampanyafiyati != '') && ($kampanyafiyati != 0)){ /* indirim fiyatı yok, kampanya fiyatı var */
						return array(
							'listefiyati'	=> $listefiyati,
							'eskifiyat'		=> $kampanyafiyati,
							'satisfiyatikd'	=> $listefiyati
						);
					} else { /* indirim fiyatı yok, kampanya fiyatı yok */
						if($ufiyataekle > 0){ /* üründe fiyata ekle var */
							$fiyat = $this->calc->fiyattan_kurus($listefiyati);
							$fiyat = $fiyat + (($fiyat / 100) * $ufiyataekle);
							$fiyat = round($fiyat, 0, PHP_ROUND_HALF_UP);
							$fiyat = $this->calc->kurusdan_fiyat($fiyat);
							$fiyat = $fiyat."00";
							return array(
								'listefiyati'	=> $listefiyati,
								'eskifiyat'		=> 0,
								'satisfiyatikd'	=> $fiyat
							);
						};
						if($kfiyataekle > 0){ /* kategoride fiyata ekle var */
							$fiyat = $this->calc->fiyattan_kurus($listefiyati);
							$fiyat = $fiyat + (($fiyat / 100) * $kfiyataekle);
							$fiyat = round($fiyat, 0, PHP_ROUND_HALF_UP);
							$fiyat = $this->calc->kurusdan_fiyat($fiyat);
							$fiyat = $fiyat."00";
							return array(
								'listefiyati'	=> $listefiyati,
								'eskifiyat'		=> 0,
								'satisfiyatikd'	=> $fiyat
							);
						};
						return array( /* varsayılan değerler */
							'listefiyati'	=> $listefiyati,
							'eskifiyat'		=> 0,
							'satisfiyatikd'	=> $listefiyati
						);
					};
				};
			}

		/* Format   Parameters */

		/* Control  Parameters */

			private function controlHttpCode($url = null){
				$ch = curl_init($url);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
				$data = curl_exec($ch);
				$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
				curl_close($ch);
				return $code;
			}

			private function controlMarkalar($marka = null){
				if(!empty($marka) && (strlen($marka) > 1)){
					$this->markalar = array();
					foreach($this->db->query("select * from ".$this->table['markalar'].";") as $key => $node){
						$this->markalar[$node['id']] = $node['marka_TR'];
					};
					$marka = $this->formatString($marka);
					$indis = array_search($this->formatStringDeep($marka), array_map(array($this, 'formatStringDeep'), $this->markalar));
					if($indis != false){
						return $indis;
					} else {
						$indis = $this->db->max($this->table['markalar']);
						$bind  = array(
							'id'		=> $indis,
							'markakodu'	=> $this->seo->url($marka),
							'marka_TR'	=> $marka,
							'yayin'		=> 1
						);
						$this->db->query("insert into ".$this->table['markalar']." (id, markakodu, marka_TR, yayin) values(:id, :markakodu, :marka_TR, :yayin);", $bind);
						return $indis;
					};
				} else {
					return false;
				};
			}

			private function controlModeller($model = null){
				if(!empty($model) && (strlen($model) > 1)){
					$this->modeller = array();
					foreach($this->db->query("select * from ".$this->table['modeller'].";") as $key => $node){
						$this->modeller[$node['id']] = $node['model_TR'];
					};
					$model = $this->formatString($model);
					$indis = array_search($this->formatStringDeep($model), array_map(array($this, 'formatStringDeep'), $this->modeller));
					if($indis != false){
						return $indis;
					} else {
						$indis = $this->db->max($this->table['modeller']);
						$bind  = array(
							'id'		=> $indis,
							'modelkodu'	=> $this->seo->url($model),
							'model_TR'	=> $model,
							'yayin'		=> 1
						);
						$this->db->query("insert into ".$this->table['modeller']." (id, modelkodu, model_TR, yayin) values(:id, :modelkodu, :model_TR, :yayin);", $bind);
						return $indis;
					};
				} else {
					return false;
				};
			}
			private function controlBedenler($beden = null){
				if(!empty($beden) && (strlen($beden) > 1)){
					$this->bedenler = array();
					foreach($this->db->query("select * from ".$this->table['bedenler'].";") as $key => $node){
						$this->bedenler[$node['id']] = $node['beden_TR'];
					};
					$beden = $this->formatString($beden);
					$indis = array_search($this->formatStringDeep($beden), array_map(array($this, 'formatStringDeep'), $this->bedenler));
					if($indis != false){
						return $indis;
					} else {
						$indis = $this->db->max($this->table['bedenler']);
						$bind  = array(
							'id'		=> $indis,
							'bedenkodu'	=> $this->seo->url($beden),
							'beden_TR'	=> $beden,
							'yayin'		=> 1
						);
						$this->db->query("insert into ".$this->table['bedenler']." (id, bedenkodu, beden_TR, yayin) values(:id, :bedenkodu, :beden_TR, :yayin);", $bind);
						return $indis;
					};
				} else {
					return false;
				};
			}

		/* Control  Parameters */

		public function import_xml(){

			$log = "XML İçeri aktarım işlemi başladı.\r\n";

			$this->db->query("update xml_import set stamp = :stamp where (id = :id);", array('stamp' => time(), 'id' => 4));

			/* veritabanları boşaltılıyor */

			#$this->db->query("truncate table ".$this->table['urunler'].";");
			#$this->db->query("truncate table ".$this->table['markalar'].";");
			#$this->db->query("truncate table ".$this->table['modeller'].";");
			#$this->db->query("truncate table ".$this->table['bedenler'].";");

			/* xml dosyaları okunup parçalanıyor */

			$minababykids	= simplexml_load_file("http://www.minababykids.com/UserFiles/ExportFile/XmlFiles/ayensoft.xml");
			$aktifurunler	= simplexml_load_file("http://www.aktifbebek.com/xml/urunler.asp?ip=37.247.104.218");
			$aktifstok		= simplexml_load_file("http://www.aktifbebek.com/xml/stok.asp?ip=37.247.104.218");
			$aktifsecenek	= simplexml_load_file("http://www.aktifbebek.com/xml/urunsecenekler.asp?ip=37.247.104.218");
			$toptaneticaret	= simplexml_load_file("http://toptaneticaret.com/xml.php?c=shopphp&kar=&x=gg");

			/* --- mina xml işleniyor */

			foreach($minababykids as $xml){
				$buffer = array();
				foreach($xml->{'Variants'}->{'Variant'} as $value){
					$indis = $this->controlBedenler((string)$value->{'ValueDescription'});
					$buffer[$indis] = array('barkod' => (int)$value->{'Barcode'}, 'bedenkodu' => $indis, 'stoksayisi' => (int)$value->{'Qty'});
				};
				if(count($buffer) > 0){
					$beden = json_encode($buffer);
				} else {
					$beden = null;
				};
				$control = $this->db->row("select * from ".$this->table['urunler']." where (stokkodu = :stokkodu);", array('stokkodu' => (int)$xml->{'ProductId'}));
				$fiyat   = $this->formatPrice((string)$xml->{'ListPrice'}, $control['indirimfiyati'], $control['kampanyafiyati'], $control['fiyataekle'], $this->db->single("select fiyataekle from ".$this->table['kategoriler']." where (id = :id);", array('id' => $control['kategori'])));
				if($control){
					if(!in_array((string)$xml->{'ProductId'}, array(503272, 501916, 501915, 501914, 501296, 505469, 434085, 434086))){
						$marka = $this->controlMarkalar((string)$xml->{'Brand'});
						if($marka != 112){
							$bind = array(
								'stokkodu'		=> (string)$xml->{'ProductId'},
								'beden'			=> $beden,
								'listefiyati'	=> $fiyat['listefiyati'],
								'eskifiyat'		=> $fiyat['eskifiyat'],
								'satisfiyatikd'	=> $fiyat['satisfiyatikd'],
								'kdvorani'		=> (int)$xml->{'Tax'},
								'stoksayisi'	=> (int)$xml->{'Qty'},
								'desi'			=> (int)$xml->{'PointRate'}
							);
							$this->db->query("update ".$this->table['urunler']." set beden = :beden, listefiyati = :listefiyati, eskifiyat = :eskifiyat, satisfiyatikd = :satisfiyatikd, kdvorani = :kdvorani, stoksayisi = :stoksayisi, desi = :desi where (stokkodu = :stokkodu);", $bind);
						};
					};
				} else {
					if((int)$xml->{'CatalogId'} != ''){
						$hash = $this->db->row("select * from ".$this->table['kategoriler']." where (id = :id);", array('id' => (int)$xml->{'CatalogId'}));
						if($hash['id'] != ''){
							$CatalogId = $hash['id'];
						} else {
							$bind = array(
								'id'			=> (int)$xml->{'CatalogId'},		
								'kategorikodu'	=> $this->seo->url((string)$xml->{'CatalogName'}),
								'kategori_TR'	=> (string)$xml->{'CatalogName'},
								'alt_id'		=> 0,
								'taksit'		=> 1,
								'yayin'			=> 1,
							);
							$this->db->query("insert into ".$this->table['kategoriler']." (id, kategorikodu, kategori_TR, alt_id, taksit, yayin) values (:id, :kategorikodu, :kategori_TR, :alt_id, :taksit, :yayin);", $bind);
							$CatalogId = (int)$xml->{'CatalogId'};
						};
					};
					if((int)$xml->{'CategoryId'} != ''){
						$hash = $this->db->row("select * from ".$this->table['kategoriler']." where (id = :id);", array('id' => (int)$xml->{'CategoryId'}));
						if($hash){
							$CategoryId = $hash['id'];
						} else {
							$bind = array(
								'id'			=> (int)$xml->{'CategoryId'},		
								'kategorikodu'	=> $this->seo->url((string)$xml->{'CategoryName'}),
								'kategori_TR'	=> (string)$xml->{'CategoryName'},
								'alt_id'		=> $CatalogId,
								'taksit'		=> 1,
								'yayin'			=> 1,
							);
							$this->db->query("insert into ".$this->table['kategoriler']." (id, kategorikodu, kategori_TR, alt_id, taksit, yayin) values (:id, :kategorikodu, :kategori_TR, :alt_id, :taksit, :yayin);", $bind);
							$CategoryId = (int)$xml->{'CategoryId'};
						};
					};
					if((int)$xml->{'SubCategoryId'} != ''){
						$hash = $this->db->row("select * from ".$this->table['kategoriler']." where (id = :id);", array('id' => (int)$xml->{'SubCategoryId'}));
						if($hash){
							$SubCategoryId = $hash['id'];
						} else {
							$bind = array(
								'id'			=> (int)$xml->{'SubCategoryId'},		
								'kategorikodu'	=> $this->seo->url((string)$xml->{'SubCategoryName'}),
								'kategori_TR'	=> (string)$xml->{'SubCategoryName'},
								'alt_id'		=> $CategoryId,
								'taksit'		=> 1,
								'yayin'			=> 1,
							);
							$this->db->query("insert into ".$this->table['kategoriler']." (id, kategorikodu, kategori_TR, alt_id, taksit, yayin) values (:id, :kategorikodu, :kategori_TR, :alt_id, :taksit, :yayin);", $bind);
							$SubCategoryId = (int)$xml->{'SubCategoryId'};
						};
					};
					if($SubCategoryId != ''){
						$kategori = $SubCategoryId;
					} elseif($CategoryId != ''){
						$kategori = $CategoryId;
					} elseif($CatalogId != ''){
						$kategori = $CatalogId;
					} else {
						$kategori = null;
					};
					if((string)$xml->{'ColorName'} != ''){
						$urlkodu = trim($this->seo->url((string)$xml->{'ItemDescription'}).'-'.$this->seo->url((string)$xml->{'ColorName'}));
						$urun_TR = trim((string)$xml->{'ItemDescription'}.' '.(string)$xml->{'ColorName'});
					} else {
						$urlkodu = trim($this->seo->url((string)$xml->{'ItemDescription'}));
						$urun_TR = trim((string)$xml->{'ItemDescription'});
					};
					$gorsel = array();
					if((string)$xml->{'Image1'} != ''){
						$Image1    = explode('/', (string)$xml->{'Image1'});
						$Image1    = $Image1[count($Image1) - 1];
						$gorsel[]  = $Image1;
					};
					if((string)$xml->{'Image2'} != ''){
						$Image2    = explode('/', (string)$xml->{'Image2'});
						$Image2    = $Image2[count($Image2) - 1];
						$gorsel[]  = $Image2;
					};
					if((string)$xml->{'Image3'} != ''){
						$Image3    = explode('/', (string)$xml->{'Image3'});
						$Image3    = $Image3[count($Image3) - 1];
						$gorsel[]  = $Image3;
					};
					if((string)$xml->{'SameDayShipping'} == 'True') $ht = 1; else $ht = 0;
					if((string)$xml->{'FreeShipping'}    == 'True') $kb = 1; else $kb = 0;
					if((string)$xml->{'LimitedEditon'}   == 'True') $ss = 1; else $ss = 0;
					$bind = array(
						'id'			=> $this->db->max($this->table['urunler']),
						'stokkodu'		=> (string)$xml->{'ProductId'},
						'urunkodu'		=> (string)$xml->{'ItemCode'},
						'urlkodu'		=> $urlkodu,
						'urun_TR'		=> $urun_TR,
						'gorsel'		=> json_encode($gorsel),
						'marka'			=> $this->controlMarkalar((string)$xml->{'Brand'}),
						'model'			=> $this->controlModeller((string)$xml->{'ColorName'}),
						'beden'			=> $beden,
						'tedarikci'		=> 2,
						'kategori'		=> $kategori,
						'magaza'		=> 1,
						'doviztipi'		=> strtolower((string)$xml->{'CurrencyCode'}),
						'alisfiyati'	=> 0,
						'satisfiyatikh'	=> 0,
						'listefiyati'	=> $fiyat['listefiyati'],
						'eskifiyat'		=> $fiyat['eskifiyat'],
						'satisfiyatikd'	=> $fiyat['satisfiyatikd'],
						'kdvorani'		=> (int)$xml->{'Tax'},
						'stoksayisi'	=> (int)$xml->{'Qty'},
						'barkod'		=> (int)$xml->{'Barcode'},
						'desi'			=> (int)$xml->{'PointRate'},
						'kargosuresi'	=> 1,
						'aciklama'		=> $this->formatEntity((string)$xml->{'Description'}),
						'ht'			=> $ht,
						'kb'			=> $kb,
						'ss'			=> $ss,
						'stamp'			=> time(),
						'yayin'			=> 1
					);
					$this->db->query("insert into ".$this->table['urunler']." (id, stokkodu, urunkodu, urlkodu, urun_TR, gorsel, marka, model, beden, tedarikci, kategori, magaza, doviztipi, listefiyati, eskifiyat, alisfiyati, satisfiyatikh, satisfiyatikd, kdvorani, stoksayisi, barkod, desi, kargosuresi, aciklama, ht, kb, ss, stamp, yayin) values (:id, :stokkodu, :urunkodu, :urlkodu, :urun_TR, :gorsel, :marka, :model, :beden, :tedarikci, :kategori, :magaza, :doviztipi, :listefiyati, :eskifiyat, :alisfiyati, :satisfiyatikh, :satisfiyatikd, :kdvorani, :stoksayisi, :barkod, :desi, :kargosuresi, :aciklama, :ht, :kb, :ss, :stamp, :yayin);", $bind);
				};
			};

			/* --- aktif markalar işleniyor */

			foreach(simplexml_load_file("http://www.aktifbebek.com/xml/markalar.asp?ip=37.247.104.218") as $xml){
				$this->controlMarkalar((string)$xml->{'markaadi'});
			};

			/* --- aktif kategori ilişkileri kuruluyor */

			$iliskiler = json_decode($this->db->single("select iliskiler from ".$this->table['iliskiler'].";"), true);

			/* --- aktif ürünler işleniyor */

			foreach($aktifurunler as $xml){
				if(in_array((int)$xml->{'kategoriid'}, array_keys($iliskiler))){
					$control = $this->db->row("select * from ".$this->table['urunler']." where (stokkodu = :stokkodu);", array('stokkodu' => '30'.(int)$xml->{'urunid'}));
					if($control){
						$bind = array(
							'stokkodu'		=> '30'.(int)$xml->{'urunid'},
							'kdvorani'		=> (int)$xml->{'kdv'},
							'desi'			=> (int)$xml->{'desi'},
							'yayin'			=> (int)$xml->{'active'}
						);
						$this->db->query("update ".$this->table['urunler']." set kdvorani = :kdvorani, desi = :desi, yayin = :yayin where (stokkodu = :stokkodu);", $bind);
					} else {
						$gorsel = array();
						if((string)$xml->{'resim'} != ''){
							$Image1    = explode('/', (string)$xml->{'resim'});
							$Image1    = $Image1[count($Image1) - 1];
							$gorsel[]  = $Image1;
						};
						$bind = array(
							'id'			=> $this->db->max($this->table['urunler']),
							'stokkodu'		=> '30'.(int)$xml->{'urunid'},
							'urunkodu'		=> '30'.(int)$xml->{'urunid'},
							'urlkodu'		=> $this->seo->url((string)$xml->{'urunadi'}),
							'urun_TR'		=> (string)$xml->{'urunadi'},
							'gorsel'		=> json_encode($gorsel),
							'marka'			=> $this->controlMarkalar((string)$xml->{'marka'}),
							'tedarikci'		=> 3,
							'kategori'		=> $iliskiler[(int)$xml->{'kategoriid'}],
							'magaza'		=> 1,
							'doviztipi'		=> 'try',
							'kdvorani'		=> (int)$xml->{'kdv'},
							'barkod'		=> (int)$xml->{'urunkod'},
							'desi'			=> (int)$xml->{'desi'},
							'kargosuresi'	=> 1,
							'aciklama'		=> $this->formatEntity((string)$xml->{'bilgi'}),
							'stamp'			=> time(),
							'yayin'			=> (int)$xml->{'active'}
						);
						$this->db->query("insert into ".$this->table['urunler']." (id, stokkodu, urunkodu, urlkodu, urun_TR, gorsel, marka, tedarikci, kategori, magaza, doviztipi, kdvorani, barkod, desi, kargosuresi, aciklama, stamp, yayin) values (:id, :stokkodu, :urunkodu, :urlkodu, :urun_TR, :gorsel, :marka, :tedarikci, :kategori, :magaza, :doviztipi, :kdvorani, :barkod, :desi, :kargosuresi, :aciklama, :stamp, :yayin);", $bind);
					};
				};
			};

			/* --- aktif stok bilgileri güncelleniyor */

			foreach($aktifstok as $xml){
				$control = $this->db->row("select * from ".$this->table['urunler']." where (stokkodu = :stokkodu);", array('stokkodu' => '30'.(int)$xml->{'urunid'}));
				if($control){
					$alisfiyati    = $this->calc->fiyattan_kurus((string)$xml->{'byfiyat'});
					$alisfiyati    = $this->calc->kdv_haric_tutardan_kdv_dahil_tutar($alisfiyati, $control['kdvorani']);
					$alisfiyati    = $this->calc->kurusdan_fiyat($alisfiyati);
					$listefiyati   = $this->calc->fiyattan_kurus((string)$xml->{'skfiyat'});
					$listefiyati   = $this->calc->kdv_haric_tutardan_kdv_dahil_tutar($listefiyati, $control['kdvorani']);
					$listefiyati   = $this->calc->kurusdan_fiyat($listefiyati);
					$satisfiyatikh = $this->calc->fiyattan_kurus((string)$xml->{'skfiyat'});
					$satisfiyatikh = $this->calc->kurusdan_fiyat($satisfiyatikh);
					$satisfiyatikd = $this->calc->fiyattan_kurus((string)$xml->{'skfiyat'});
					$satisfiyatikd = $this->calc->kdv_haric_tutardan_kdv_dahil_tutar($satisfiyatikd, $control['kdvorani']);
					$satisfiyatikd = $this->calc->kurusdan_fiyat($satisfiyatikd);
					$fiyat = $this->formatPrice($listefiyati, $control['indirimfiyati'], $control['kampanyafiyati'], $control['fiyataekle'], $this->db->single("select fiyataekle from ".$this->table['kategoriler']." where (id = :id);", array('id' => $control['kategori'])));
					$bind  = array(
						'stokkodu'		=> '30'.(int)$xml->{'urunid'},
						'alisfiyati'	=> $alisfiyati,
						'listefiyati'	=> $fiyat['listefiyati'],
						'eskifiyat'		=> $fiyat['eskifiyat'],
						'satisfiyatikh'	=> $satisfiyatikh,
						'satisfiyatikd'	=> $fiyat['satisfiyatikd'],
						'stoksayisi'	=> (int)$xml->{'stok'}
					);
					$this->db->query("update ".$this->table['urunler']." set alisfiyati = :alisfiyati, listefiyati = :listefiyati, eskifiyat = :eskifiyat, satisfiyatikh = :satisfiyatikh, satisfiyatikd = :satisfiyatikd, stoksayisi = :stoksayisi where (stokkodu = :stokkodu);", $bind);
				};
			};

			/* --- aktif model ve beden parametreleri işleniyor */

			$buffer = array();
			foreach($aktifsecenek as $xml){
				$control = $this->db->row("select * from ".$this->table['urunler']." where (stokkodu = :stokkodu);", array('stokkodu' => '30'.(int)$xml['id']));
				if($control){
					if($this->formatStringDeep((string)$xml['grup']) == 'renk'){
						/*
						$urlkodu = trim($this->seo->url($control['urun_TR']).'-'.$this->seo->url($xml['ozellik']));
						if(!$this->db->row("select * from ".$this->table['urunler']." where (urlkodu = :urlkodu);", array('urlkodu' => $urlkodu))){
							$urun_TR = trim($control['urun_TR'].' '.$xml['ozellik']);
							$model   = $this->controlModeller((string)$xml['ozellik']);
							$bind    = array(
								'id'			=> $this->db->max($this->table['urunler']),
								'stokkodu'		=> $control['stokkodu'].rand(0, 99999999),
								'urunkodu'		=> $control['urunkodu'],
								'urlkodu'		=> $urlkodu,
								'urun_TR'		=> $urun_TR,
								'gorsel'		=> $control['gorsel'],
								'video'			=> $control['video'],
								'marka'			=> $control['marka'],
								'model'			=> $model,
								'beden'			=> $control['beden'],
								'uretici'		=> $control['uretici'],
								'tedarikci'		=> $control['tedarikci'],
								'kategori'		=> $control['kategori'],
								'magaza'		=> $control['magaza'],
								'doviztipi'		=> $control['doviztipi'],
								'alisfiyati'	=> $control['alisfiyati'],
								'satisfiyatikh'	=> $control['satisfiyatikh'],
								'listefiyati'	=> $control['listefiyati'],
								'eskifiyat'		=> $control['eskifiyat'],
								'satisfiyatikd'	=> $control['satisfiyatikd'],
								'kdvorani'		=> $control['kdvorani'],
								'stoksayisi'	=> $control['stoksayisi'],
								'barkod'		=> $control['barkod'],
								'desi'			=> $control['desi'],
								'kargosuresi'	=> $control['kargosuresi'],
								'aciklama'		=> $control['aciklama'],
								'ht'			=> $control['ht'],
								'kb'			=> $control['kb'],
								'ss'			=> $control['ss'],
								'stamp'			=> time(),
								'vitrin'		=> $control['vitrin'],
								'yayin'			=> $control['yayin'],
							);
							$this->db->query("insert into ".$this->table['urunler']." (id, stokkodu, urunkodu, urlkodu, urun_TR, gorsel, video, marka, model, beden, uretici, tedarikci, kategori, magaza, doviztipi, listefiyati, eskifiyat, alisfiyati, satisfiyatikh, satisfiyatikd, kdvorani, stoksayisi, barkod, desi, kargosuresi, aciklama, ht, kb, ss, stamp, vitrin, yayin) values (:id, :stokkodu, :urunkodu, :urlkodu, :urun_TR, :gorsel, :video, :marka, :model, :beden, :uretici, :tedarikci, :kategori, :magaza, :doviztipi, :listefiyati, :eskifiyat, :alisfiyati, :satisfiyatikh, :satisfiyatikd, :kdvorani, :stoksayisi, :barkod, :desi, :kargosuresi, :aciklama, :ht, :kb, :ss, :stamp, :vitrin, :yayin);", $bind);
						};
						*/
					} elseif($this->formatStringDeep((string)$xml['grup']) == 'beden'){
						$indis = $this->controlBedenler((string)$xml['ozellik']);
						$buffer[(int)$xml['id']][$indis] = array('barkod' => $control['barkod'], 'bedenkodu' => $indis, 'stoksayisi' => $control['stoksayisi']);
					};
				};
			};

			/* --- aktif beden parametleri veritabanına kaydediliyor */

			foreach($buffer as $urunkodu => $beden){
				$bind = array(
					'beden'		=> json_encode($beden),
					'urunkodu'	=> $urunkodu
				);
				$this->db->query("update ".$this->table['urunler']." set beden = :beden where (urunkodu = :urunkodu) && (tedarikci = 3);", $bind);
			};

			/* --- toptaneticaret ürünler ve markalar işleniyor */

			$iliskiler = array(104 => 2256, 106 => 2255);

			foreach($toptaneticaret as $xml){
				if(in_array((int)$xml->{'urun_kategori_kod'}, array_keys($iliskiler))){
					$control = $this->db->row("select * from ".$this->table['urunler']." where (stokkodu = :stokkodu);", array('stokkodu' => '80'.(int)$xml->{'urun_ID'}));
					if($control){

						if(!stristr((string)$xml->{'urun_fiyat'}, '.')){
							$alisfiyati = (string)$xml->{'urun_fiyat'}.',0000';
						} else {
							$alisfiyati = str_replace('.', ',', (string)$xml->{'urun_fiyat'}).str_repeat('0', (4 - strlen(explode('.', (string)$xml->{'urun_fiyat'})[1])));
						};
						
						$listefiyati = $this->calc->fiyattan_kurus($alisfiyati);
						$listefiyati = $listefiyati + (($listefiyati / 100) * 10);
						$listefiyati = round($listefiyati, 0, PHP_ROUND_HALF_UP);
						$listefiyati = $this->calc->kurusdan_fiyat($listefiyati).'00';
						$fiyat       = $this->formatPrice($listefiyati, 0, 0, 0, 0);
						$bind        = array(
							'stokkodu'		=> '80'.(string)$xml->{'urun_ID'},
							'listefiyati'	=> $fiyat['listefiyati'],
							'eskifiyat'		=> $fiyat['eskifiyat'],
							'satisfiyatikd'	=> $fiyat['satisfiyatikd'],
							'kdvorani'		=> (int)str_replace('.', null, (string)$xml->{'urun_kdv'}),
							'stoksayisi'	=> (int)$xml->{'urun_stok'}
						);
						$this->db->query("update ".$this->table['urunler']." set listefiyati = :listefiyati, eskifiyat = :eskifiyat, satisfiyatikd = :satisfiyatikd, kdvorani = :kdvorani, stoksayisi = :stoksayisi where (stokkodu = :stokkodu);", $bind);
					
					} else {
						
						$gorsel = array();
						if((string)$xml->{'urun_resim1'} != ''){
							$Image1    = explode('/', (string)$xml->{'urun_resim1'});
							$Image1    = $Image1[count($Image1) - 1];
							$gorsel[]  = $Image1;
						};
						
						if(!stristr((string)$xml->{'urun_fiyat'}, '.')){
							$alisfiyati = (string)$xml->{'urun_fiyat'}.',0000';
						} else {
							$alisfiyati = str_replace('.', ',', (string)$xml->{'urun_fiyat'}).str_repeat('0', (4 - strlen(explode('.', (string)$xml->{'urun_fiyat'})[1])));
						};
						
						$listefiyati = $this->calc->fiyattan_kurus($alisfiyati);
						$listefiyati = $listefiyati + (($listefiyati / 100) * 10);
						$listefiyati = round($listefiyati, 0, PHP_ROUND_HALF_UP);
						$listefiyati = $this->calc->kurusdan_fiyat($listefiyati).'00';
						$fiyat       = $this->formatPrice($listefiyati, 0, 0, 0, 0);
						$bind        = array(
							'id'			=> $this->db->max($this->table['urunler']),
							'stokkodu'		=> '80'.(string)$xml->{'urun_ID'},
							'urunkodu'		=> '80'.(string)$xml->{'urun_kod'},
							'urlkodu'		=> $this->seo->url((string)$xml->{'urun_ad'}),
							'urun_TR'		=> (string)$xml->{'urun_ad'},
							'gorsel'		=> json_encode($gorsel),
							'marka'			=> $this->controlMarkalar((string)$xml->{'urun_marka_ad'}),
							'tedarikci'		=> 8,
							'kategori'		=> $iliskiler[(int)$xml->{'urun_kategori_kod'}],
							'magaza'		=> 1,
							'doviztipi'		=> 'try',
							'alisfiyati'	=> $alisfiyati,
							'satisfiyatikh'	=> 0,
							'listefiyati'	=> $fiyat['listefiyati'],
							'eskifiyat'		=> $fiyat['eskifiyat'],
							'satisfiyatikd'	=> $fiyat['satisfiyatikd'],
							'kdvorani'		=> (int)str_replace('.', null, (string)$xml->{'urun_kdv'}),
							'stoksayisi'	=> (int)$xml->{'urun_stok'},
							'barkod'		=> null,
							'kargosuresi'	=> 1,
							'aciklama'		=> $this->formatEntity((string)$xml->{'urun_aciklama'}),
							'stamp'			=> time(),
							'yayin'			=> (int)$xml->{'urun_aktif'}
						);
						$this->db->query("insert into ".$this->table['urunler']." (id, stokkodu, urunkodu, urlkodu, urun_TR, gorsel, marka, tedarikci, kategori, magaza, doviztipi, listefiyati, eskifiyat, alisfiyati, satisfiyatikh, satisfiyatikd, kdvorani, stoksayisi, barkod, kargosuresi, aciklama, stamp, yayin) values (:id, :stokkodu, :urunkodu, :urlkodu, :urun_TR, :gorsel, :marka, :tedarikci, :kategori, :magaza, :doviztipi, :listefiyati, :eskifiyat, :alisfiyati, :satisfiyatikh, :satisfiyatikd, :kdvorani, :stoksayisi, :barkod, :kargosuresi, :aciklama, :stamp, :yayin);", $bind);
					};
				};
			};

			/* --- veritabanında bulunan ürünler barkodlar ile birbirine bağlanıyor */

			/*
			foreach($this->db->query("select * from ".$this->table['urunler']." where (tedarikci = 2);") as $urun){
				$bind = array(
					'urun_TR'	=> $urun['urun_TR'],
					'urlkodu'	=> $urun['urlkodu'],
					'gorsel'	=> $urun['gorsel'],
					'kategori'	=> $urun['kategori'],
					'marka'		=> $urun['marka'],
					'model'		=> $urun['model'],
					'aciklama'	=> $urun['aciklama'],
					'barkod'	=> $urun['barkod'],
					'yayin'		=> 0
				);
				$this->db->single("update ".$this->table['urunler']." set urun_TR = :urun_TR, urlkodu = :urlkodu, kategori = :kategori, gorsel = :gorsel, marka = :marka, model = :model, aciklama = :aciklama, yayin = :yayin where (barkod = :barkod) && (tedarikci = 3);", $bind);
			};
			*/

			/* --- kategori ilişkisi olmayan ürünler veritabanından siliniyor */

			$this->db->query("delete from ".$this->table['urunler']." where (kategori = '');");

			$log .= "XML İçeri aktarım işlemi tamamlandı.";
			$this->log->set($log, 'xml');

		}

		public function import_image(){

			$minababykids	= simplexml_load_file("http://www.minababykids.com/UserFiles/ExportFile/XmlFiles/ayensoft.xml");
			$aktifurunler	= simplexml_load_file("http://www.aktifbebek.com/xml/urunler.asp?ip=37.247.104.218");
			$toptaneticaret	= simplexml_load_file("http://toptaneticaret.com/xml.php?c=shopphp&amp;kar=&amp;x=gg");

			$dir = "../../cdn/files/product/";

			/*

			foreach($minababykids as $xml){

				if((string)$xml->{'Image1'} != ''){
					$Image1    = explode('/', (string)$xml->{'Image1'});
					$Image1    = $Image1[count($Image1) - 1];
					#if(!file_exists($dir.$Image1)){
						$file1 = file_get_contents("http://www.minababykids.com".(string)$xml->{'Image1'});
						file_put_contents($dir.$Image1, $file1);
					#};
				};

				if((string)$xml->{'Image2'} != ''){
					$Image2    = explode('/', (string)$xml->{'Image2'});
					$Image2    = $Image2[count($Image2) - 1];
					#if(!file_exists($dir.$Image2)){
						$file2 = file_get_contents("http://www.minababykids.com".(string)$xml->{'Image2'});
						file_put_contents($dir.$Image2, $file2);
					#};
				};

				if((string)$xml->{'Image3'} != ''){
					$Image3    = explode('/', (string)$xml->{'Image3'});
					$Image3    = $Image3[count($Image3) - 1];
					#if(!file_exists($dir.$Image3)){
						$file3 = file_get_contents("http://www.minababykids.com".(string)$xml->{'Image3'});
						file_put_contents($dir.$Image3, $file3);
					#};
				};
				
			};

			*/

			foreach($aktifurunler as $xml){
				if((string)$xml->{'resim'} != ''){
					$name = explode('/', (string)$xml->{'resim'});
					$name = $name[count($name) - 1];
					#if(!file_exists($dir.$name)){
						$url = str_replace('_buyuk.', '_buyuk_zoom.', (string)$xml->{'resim'});
						if($this->controlHttpCode($url) == '404') $url = (string)$xml->{'resim'};
						$file = file_get_contents($url);
						file_put_contents($dir.$name, $file);
					#};
				};
			};

			foreach($toptaneticaret as $xml){
				if((string)$xml->{'urun_resim1'} != ''){
					$name = explode('/', (string)$xml->{'urun_resim1'});
					$name = $name[count($name) - 1];
					#if(!file_exists($dir.$name)){
						$file = file_get_contents((string)$xml->{'urun_resim1'});
						file_put_contents($dir.$name, $file);
					#};
				};
			};

		}

	};

	#$xml_core = new xml_core($core);
	#$xml_core->import_xml();

?>