<?php

	/*
	*
	*
	*
	*/

	class xml extends core{

		public  $db;
		public  $seo;
		public  $log;
		public  $calc;

		private $buffer;
		private $nonBind;
		private $table;
		private $table2;
		private $table3;
		private $table4;
		private $table5;
		private $table6;
		private $table7;
		private $table8;
		
		public function __construct(){
			$this->buffer  = array();
			$this->nonBind = array();
			$this->table   = "xml_import";
			$this->table2  = "xml_export";
			$this->table3  = "xml_buffer";
			$this->table4  = "cat_kategoriler";
			$this->table5  = "cat_urunler";
			$this->table6  = "cat_markalar";
			$this->table7  = "cat_modeller";
			$this->table8  = "cat_bedenler";
		}

		public function __destruct(){
			unset($this->db);
			unset($this->seo);
			unset($this->buffer);
			unset($this->nonBind);
			unset($this->table);
			unset($this->table2);
			unset($this->table3);
			unset($this->table4);
			unset($this->table5);
			unset($this->table6);
			unset($this->table7);
			unset($this->table8);
		}

		public function getCategoryTree($alt, $stat = true){
			foreach($this->db->query("select * from ".$this->table4." where (id = :id) && (yayin = 1);", array('id' => $alt)) as $key => $node){
				if(!empty($node)){
					if($stat == true){ $this->buffer = array(); $stat = false; };
					$this->buffer[] = $node['kategori_TR'];
					$this->getCategoryTree($node['alt_id'], $stat);
				};
			};
			return array_reverse($this->buffer);
		}

		public function tags($url, $sorgu = '//*'){
			$doc    = new DOMDocument();
			$doc->load($url);
			$xpath  = new DOMXpath($doc);
			$hash   = $xpath->query($sorgu);
			$buffer = array();
			foreach($hash as $node){
				if(!in_array($node->nodeName, $buffer)){
					$buffer[] = $node->nodeName;
				};
			};
			return $buffer;
		}

		private function entity_decode($input){
			$search  = array('&amp;', '&amp;', '&amp;', '&amp;', '&lt;', '&gt;', '&quot;', '&times;', '&Ouml;', '&ouml;', '&Uuml;', '&uuml;', '&ccedil;');
			$replace = array('&',     '&',     '&',     '&',     '<',    '>',    '"',      '×',       'Ö',      'ö',      'Ü',      'ü',      'ç');
			$output  = str_replace($search, $replace, $input);
			return $output;
		}

		private function iliskiler($param, $etiket, $xml){
			if(is_array($etiket)){
				if($this->secenekler($param, 'iliskiler')){
					switch($etiket[0]){
						case 'sys_sef_url':
							return $this->seo->url((string)$xml->{$etiket[1]});
						break;
						case 'sys_sef_url_plus':
							return $this->seo->url((string)$xml->{$etiket[1][0]}." ".(string)$xml->{$etiket[1][1]});
						break;
						case 'sys_multi_val':
							return (string)$xml->{$etiket[1][0]}." ".(string)$xml->{$etiket[1][1]};
						break;
						default:
							return (string)$xml->{$etiket};
						break;
					};
				} else {
					return (string)$xml->{$etiket[1]};
				};
			} else {
				if($this->secenekler($param, 'iliskiler')){
					switch($etiket){
						case 'sys_auto_increment':
							return $this->db->max($param['tablo']);
						break;
						case 'sys_time_stamp':
							return time();
						break;
						case 'sys_uniq_id':
							return uniqid();
						break;
						case 'sys_empty':
							return "";
						break;
						case 'sys_null':
							return "null";
						break;
						case 'sys_true':
							return "true";
						break;
						case 'sys_false':
							return "false";
						break;
						case 'sys_1':
							return 1;
						break;
						case 'sys_0':
							return 0;
						break;
						default:
							return (string)$xml->{$etiket};
						break;
					};
				} else {
					return (string)$xml->{$etiket};
				};
			};
		}

		private function donusumler($param, $etiket, $input){
			if($this->secenekler($param, 'donusumler') && !empty($param['donusumler'])){
				$donusumler = json_decode($param['donusumler'], true);
				if(is_array($donusumler[$etiket])){
					foreach($donusumler[$etiket] as $key => $degerler){
						if($input == $degerler[0]){
							return $degerler[1];
						} else {
							return $input;
						};
					};
				} else {
					return $input;
				};
			} else {
				return $input;
			};
		}

		private function kurallar($param){
			$kurallar = json_decode($param['kurallar'], true);
			return $kurallar;
		}

		private function secenekler($param, $modul){
			$secenekler = json_decode($param['secenekler'], true);
			return $secenekler[$modul];
		}

		private function prepareBind($param, $xml, $nonBind = null){
			$bind = array();
			foreach(json_decode($param['iliskiler'], true) as $sutun => $etiket){
				$iliskiler  = $this->iliskiler($param, $etiket, $xml);
				$donusumler = $this->donusumler($param, $etiket, $iliskiler);
				$donusumler = $this->entity_decode($donusumler);
				if(is_array($nonBind)){
					if(!in_array($sutun, $nonBind)){
						$bind[$sutun] = $donusumler;
					};
				} else {
					$bind[$sutun] = $donusumler;
				};

			};
			return $bind;
		}

		private function prepareSutunlar($param){
			$sutunlar = array();
			foreach(json_decode($param['iliskiler'], true) as $sutun => $etiket){
				$sutunlar[] = $sutun;
			};
			return $sutunlar;
		}

		private function prepareCountQuery($param){
			$query = "select count(id) as _count from ".$param['tablo']." where ";
			foreach($this->prepareSutunlar($param) as $key => $sutun){
				if(!in_array($sutun, $this->nonBind)){
					$query .= "(".$sutun." = :".$sutun.") && ";
				};
			};
			$query = substr($query, 0, strlen($query) - 4).";";
			return $query;
		}

		private function prepareInsertQuery($param){
			$sutun  = $this->prepareSutunlar($param);
			$query  = "insert into ".$param['tablo']." (";
			$query .= implode(', ', $sutun);
			$query .= ") values (:";
			$query .= implode(', :', $sutun).");";
			return $query;
		}

		private function prepareUpdateQuery($param){
			$query = "update ".$param['tablo']." set ";
			foreach($this->prepareSutunlar($param) as $key => $sutun){
				if($sutun != 'id'){
					$query .= $sutun." = :".$sutun.", ";
				};
			};
			$query = substr($query, 0, strlen($query) - 2)." where (id = :id);";
			return $query;
		}

		private function prepareBindBuffer($param, $xml){
			$bind = array();
			$bind['id']		= $this->db->max($this->table3);
			$bind['tablo']	= $param['tablo'];
			$etiket			= json_decode($param['iliskiler'], true)['id'];
			$iliski			= $this->iliskiler($param, $etiket, $xml);
			$bind['indis']	= $this->donusumler($param, $etiket, $iliski);
			foreach(json_decode($param['iliskiler'], true) as $sutun => $etiket){
				$iliskiler  = $this->iliskiler($param, $etiket, $xml);
				$donusumler	= $this->donusumler($param, $etiket, $iliskiler);
				$bind['data'][$sutun] = $donusumler;
			};
			$bind['data']	= json_encode($bind['data']);
			$bind['kural']	= null;
			return $bind;
		}

		private function prepareBufferQuery(){
			$query  = "insert into ";
			$query .= $this->table3." ";
			$query .= "(id, tablo, indis, data, kural) ";
			$query .= "values ";
			$query .= "(:id, :tablo, :indis, :data, :kural);";
			return $query;
		}

		private function prepareMarka($marka){
			if($marka != ''){
				$hash = $this->db->row("select * from ".$this->table6." where (marka_TR = :marka);", array('marka' => $marka));
				if($hash['id'] != ''){
					return $hash['id'];
				} else {
					$id   = $this->db->max($this->table6);
					$bind = array(
						'id'		=> $id,		
						'markakodu'	=> $this->seo->url($marka),
						'marka_TR'	=> $marka,
						'yayin'		=> 1,
					);
					$this->db->query("insert into ".$this->table6." (id, markakodu, marka_TR, yayin) values (:id, :markakodu, :marka_TR, :yayin);", $bind);
					return $id;
				};
			} else {
				return null;
			};
		}

		private function prepareModel($model){
			if($model != ''){
				$hash = $this->db->row("select * from ".$this->table7." where (model_TR = :model);", array('model' => $model));
				if($hash['id'] != ''){
					return $hash['id'];
				} else {
					$id   = $this->db->max($this->table7);
					$bind = array(
						'id'		=> $id,		
						'modelkodu'	=> $this->seo->url($model),
						'model_TR'	=> $model,
						'yayin'		=> 1,
					);
					$this->db->query("insert into ".$this->table7." (id, modelkodu, model_TR, yayin) values (:id, :modelkodu, :model_TR, :yayin);", $bind);
					return $id;
				};
			} else {
				return null;
			};
		}

		private function prepareKategori($xml){
			if($xml->CatalogId != ''){
				$hash = $this->db->row("select * from ".$this->table4." where (id = :id);", array('id' => $xml->CatalogId));
				if($hash['id'] != ''){
					$CatalogId = $hash['id'];
				} else {
					$bind = array(
						'id'			=> $xml->CatalogId,		
						'kategorikodu'	=> $this->seo->url($xml->CatalogName),
						'kategori_TR'	=> $xml->CatalogName,
						'alt_id'		=> 0,
						'taksit'		=> 1,
						'yayin'			=> 1,
					);
					$this->db->query("insert into ".$this->table4." (id, kategorikodu, kategori_TR, alt_id, taksit, yayin) values (:id, :kategorikodu, :kategori_TR, :alt_id, :taksit, :yayin);", $bind);
					$CatalogId = $xml->CatalogId;
				};
			};
			if($xml->CategoryId != ''){
				$hash = $this->db->row("select * from ".$this->table4." where (id = :id);", array('id' => $xml->CategoryId));
				if($hash){
					$CategoryId = $hash['id'];
				} else {
					$bind = array(
						'id'			=> $xml->CategoryId,		
						'kategorikodu'	=> $this->seo->url($xml->CategoryName),
						'kategori_TR'	=> $xml->CategoryName,
						'alt_id'		=> $CatalogId,
						'taksit'		=> 1,
						'yayin'			=> 1,
					);
					$this->db->query("insert into ".$this->table4." (id, kategorikodu, kategori_TR, alt_id, taksit, yayin) values (:id, :kategorikodu, :kategori_TR, :alt_id, :taksit, :yayin);", $bind);
					$CategoryId = $xml->CategoryId;
				};
			};
			if($xml->SubCategoryId != ''){
				$hash = $this->db->row("select * from ".$this->table4." where (id = :id);", array('id' => $xml->SubCategoryId));
				if($hash){
					$SubCategoryId = $hash['id'];
				} else {
					$bind = array(
						'id'			=> $xml->SubCategoryId,		
						'kategorikodu'	=> $this->seo->url($xml->SubCategoryName),
						'kategori_TR'	=> $xml->SubCategoryName,
						'alt_id'		=> $CategoryId,
						'taksit'		=> 1,
						'yayin'			=> 1,
					);
					$this->db->query("insert into ".$this->table4." (id, kategorikodu, kategori_TR, alt_id, taksit, yayin) values (:id, :kategorikodu, :kategori_TR, :alt_id, :taksit, :yayin);", $bind);
					$SubCategoryId = $xml->SubCategoryId;
				};
			};
			if($SubCategoryId != ''){
				return $SubCategoryId;
			} elseif($CategoryId != ''){
				return $CategoryId;
			} elseif($CatalogId != ''){
				return $CatalogId;
			} else {
				return null;
			};
		}

		private function prepareBeden($xml){
			$buffer = array();
			if($xml->{'Variant'}){
				foreach($xml->{'Variant'} as $key => $value){
					if(((string)$value->{'Name'} == 'Beden') && ((string)$value->{'Value'} != '')){
						$hash = $this->db->row("select * from ".$this->table8." where (bedenkodu = :bedenkodu);", array('bedenkodu' => $this->seo->url((string)$value->{'Value'})));
						if($hash){
							$id = $hash['id'];
						} else {
							$id   = $this->db->max($this->table8);
							$bind = array(
								'id'		=> $id,		
								'bedenkodu'	=> $this->seo->url((string)$value->{'Value'}),
								'beden_TR'	=> (string)$value->{'ValueDescription'},
								'yayin'		=> 1,
							);
							$this->db->query("insert into ".$this->table8." (id, bedenkodu, beden_TR, yayin) values (:id, :bedenkodu, :beden_TR, :yayin);", $bind);
						};
						$buffer[$id] = array('barkod' => (int)$value->{'Barcode'}, 'bedenkodu' => $id, 'stoksayisi' => (int)$value->{'Qty'});
					};
				};
				return json_encode($buffer);
			} else {
				return null;
			};
		}

		private function preparePrice($xml, $kategori, $urun){

			if(($urun['indirimfiyati'] != '') && ($urun['indirimfiyati'] != 0)){ /* indirim fiyatı var */
				
				if(($urun['kampanyafiyati'] != '') && ($urun['kampanyafiyati'] != 0)){ /* indirim fiyatı var, kampanya fiyatı var */
					
					return array(
						'listefiyati'	=> $xml->ListPrice,
						'eskifiyat'		=> $urun['kampanyafiyati'],
						'satisfiyatikd'	=> $urun['indirimfiyati']
					);

				} else { /* indirim fiyatı var, kampanya fiyatı yok */
					
					return array(
						'listefiyati'	=> $xml->ListPrice,
						'eskifiyat'		=> $xml->ListPrice,
						'satisfiyatikd'	=> $urun['indirimfiyati']
					);

				};

			} else { /* indirim fiyatı yok */
				
				if(($urun['kampanyafiyati'] != '') && ($urun['kampanyafiyati'] != 0)){ /* indirim fiyatı yok, kampanya fiyatı var */
					
					return array(
						'listefiyati'	=> $xml->ListPrice,
						'eskifiyat'		=> $urun['kampanyafiyati'],
						'satisfiyatikd'	=> $xml->ListPrice
					);

				} else { /* indirim fiyatı yok, kampanya fiyatı yok */

					if($urun['fiyataekle'] > 0){ /* üründe fiyata ekle var */
						
						$fiyat = $this->calc->fiyattan_kurus($xml->ListPrice);
						$fiyat = $fiyat + (($fiyat / 100) * $urun['fiyataekle']);
						$fiyat = round($fiyat, 0, PHP_ROUND_HALF_UP);
						$fiyat = $this->calc->kurusdan_fiyat($fiyat);
						$fiyat = $fiyat."00";
						
						return array(
							'listefiyati'	=> $xml->ListPrice,
							'eskifiyat'		=> 0,
							'satisfiyatikd'	=> $fiyat
						);

					};

					$kategori = $this->db->row("select * from ".$this->table4." where (id = :id);", array('id' => $kategori));

					if($kategori['fiyataekle'] > 0){ /* kategoride fiyata ekle var */
						
						$fiyat = $this->calc->fiyattan_kurus($xml->ListPrice);
						$fiyat = $fiyat + (($fiyat / 100) * $kategori['fiyataekle']);
						$fiyat = round($fiyat, 0, PHP_ROUND_HALF_UP);
						$fiyat = $this->calc->kurusdan_fiyat($fiyat);
						$fiyat = $fiyat."00";
						
						return array(
							'listefiyati'	=> $xml->ListPrice,
							'eskifiyat'		=> 0,
							'satisfiyatikd'	=> $fiyat
						);

					};

					return array( /* varsayılan değerler */
						'listefiyati'	=> $xml->ListPrice,
						'eskifiyat'		=> 0,
						'satisfiyatikd'	=> $xml->ListPrice
					);

				};
			};

		}

		public function import($indis){
			$log    = "XML İçeri aktarım işlemi başladı.\r\n";
			$param  = $this->db->row("select * from ".$this->table." where (id = :id);", array('id' => $indis));
			$this->db->query("update ".$this->table." set stamp = :stamp where (id = :id);", array('stamp' => time(), 'id' => $indis));
			$kaynak = simplexml_load_file($param['kaynak']);
			$sayac  = 0;
			foreach($kaynak as $key => $xml){
				$control = $this->db->row("select * from ".$this->table5." where (stokkodu = :stokkodu);", array('stokkodu' => $xml->ProductId));
				if($control){

					if(!in_array($xml->ProductId, array(501916, 501915, 501914, 501296, 505469, 434085, 434086))){

						$marka = $this->prepareMarka($xml->Brand);

						if($marka != 112){

							$beden    = $this->prepareBeden($xml->Variants);
							$kategori = $this->prepareKategori($xml);
							$price    = $this->preparePrice($xml, $kategori, $control);
							$bind     = array(
								'id'			=> $xml->ProductId,
								'beden'			=> $beden,
								'listefiyati'	=> $price['listefiyati'],
								'eskifiyat'		=> $price['eskifiyat'],
								'satisfiyatikd'	=> $price['satisfiyatikd'],
								'kdvorani'		=> $xml->Tax,
								'stoksayisi'	=> $xml->Qty,
								'desi'			=> $xml->PointRate
							);
							$this->db->query("update ".$this->table5." set beden = :beden, listefiyati = :listefiyati, eskifiyat = :eskifiyat, satisfiyatikd = :satisfiyatikd, kdvorani = :kdvorani, stoksayisi = :stoksayisi, desi = :desi where (id = :id);", $bind);
							if($control['beden']			!= $beden)					$log .= $control['urun_TR']." isimli ürünün beden seçenekleri güncellendi. ".$control['beden']." => ".$beden."\r\n";
							if($control['listefiyati']		!= $price['listefiyati'])	$log .= $control['urun_TR']." isimli ürünün liste fiyatı güncellendi. ".$control['listefiyati']." => ".$price['listefiyati']."\r\n";
							if($control['eskifiyat']		!= $price['eskifiyat'])		$log .= $control['urun_TR']." isimli ürünün eski fiyatı güncellendi. ".$control['eskifiyat']." => ".$price['eskifiyat']."\r\n";
							if($control['satisfiyatikd']	!= $price['satisfiyatikd'])	$log .= $control['urun_TR']." isimli ürünün satış fiyatı güncellendi. ".$control['satisfiyatikd']." => ".$price['satisfiyatikd']."\r\n";
							if($control['kdvorani']			!= $xml->Tax)				$log .= $control['urun_TR']." isimli ürünün kdv oranı güncellendi. ".$control['kdvorani']." => ".$xml->Tax."\r\n";
							if($control['stoksayisi']		!= $xml->Qty)				$log .= $control['urun_TR']." isimli ürünün stok sayısı güncellendi. ".$control['stoksayisi']." => ".$xml->Qty."\r\n";
							if($control['desi']				!= $xml->PointRate)			$log .= $control['urun_TR']." isimli ürünün desi bilgisi güncellendi. ".$control['desi']." => ".$xml->PointRate."\r\n";

						};

					};

				} else {

					if($xml->ColorName != ''){
						$urlkodu = trim($this->seo->url($xml->ItemDescription).'-'.$this->seo->url($xml->ColorName));
						$urun_TR = trim($xml->ItemDescription.' '.$xml->ColorName);
					} else {
						$urlkodu = trim($this->seo->url($xml->ItemDescription));
						$urun_TR = trim($xml->ItemDescription);
					};

					$dir    = "../../cdn/files/product/"; /* cronjob */

					#$dir    = "cdn/files/product/"; /* sandbox */

					$gorsel = array();
					if(!is_dir($dir)) break;
					if($xml->Image1 != ''){
						$Image1    = explode('/', $xml->Image1);
						$Image1    = $Image1[count($Image1) - 1];
						$gorsel[]  = $Image1;
						if(!file_exists($dir.$Image1)){
							$file1 = file_get_contents("http://www.minababykids.com".$xml->Image1);
							file_put_contents($dir.$Image1, $file1);
							$log .= $dir.$Image1." fotoğrafı eklendi.\r\n";
						};
					};
					if($xml->Image2 != ''){
						$Image2    = explode('/', $xml->Image2);
						$Image2    = $Image2[count($Image2) - 1];
						$gorsel[]  = $Image2;
						if(!file_exists($dir.$Image2)){
							$file2 = file_get_contents("http://www.minababykids.com".$xml->Image2);
							file_put_contents($dir.$Image2, $file2);
							$log .= $dir.$Image2." fotoğrafı eklendi.\r\n";
						};
					};
					if($xml->Image3 != ''){
						$Image3    = explode('/', $xml->Image3);
						$Image3    = $Image3[count($Image3) - 1];
						$gorsel[]  = $Image3;
						if(!file_exists($dir.$Image3)){
							$file3 = file_get_contents("http://www.minababykids.com".$xml->Image3);
							file_put_contents($dir.$Image3, $file3);
							$log .= $dir.$Image3." fotoğrafı eklendi.\r\n";
						};
					};
					$gorsel    = json_encode($gorsel);
					$doviztipi = strtolower($xml->CurrencyCode);
					$kategori  = $this->prepareKategori($xml);
					$price     = $this->preparePrice($xml, $kategori, $control);
					if($xml->SameDayShipping == 'True') $ht = 1; else $ht = 0;
					if($xml->FreeShipping    == 'True') $kb = 1; else $kb = 0;
					if($xml->LimitedEditon   == 'True') $ss = 1; else $ss = 0;
					$bind = array(
						'id'			=> $xml->ProductId,
						'stokkodu'		=> $xml->ProductId,
						'urunkodu'		=> $xml->ItemCode,
						'urlkodu'		=> $urlkodu,
						'urun_TR'		=> $urun_TR,
						'gorsel'		=> $gorsel,
						'video'			=> null,
						'marka'			=> $this->prepareMarka($xml->Brand),
						'model'			=> $this->prepareModel($xml->ColorName),
						'beden'			=> $this->prepareBeden($xml->Variants),
						'uretici'		=> null,
						'tedarikci'		=> 2,
						'kategori'		=> $kategori,
						'magaza'		=> 1,
						'doviztipi'		=> $doviztipi,
						'alisfiyati'	=> 0,
						'satisfiyatikh'	=> 0,
						'listefiyati'	=> $price['listefiyati'],
						'eskifiyat'		=> $price['eskifiyat'],
						'satisfiyatikd'	=> $price['satisfiyatikd'],
						'kdvorani'		=> $xml->Tax,
						'stoksayisi'	=> $xml->Qty,
						'barkod'		=> $xml->Barcode,
						'desi'			=> $xml->PointRate,
						'kargosuresi'	=> 1,
						'aciklama'		=> $this->entity_decode($xml->Description),
						'ht'			=> $ht,
						'kb'			=> $kb,
						'ss'			=> $ss,
						'stamp'			=> time(),
						'vitrin'		=> 0,
						'yayin'			=> 1,
					);
					$this->db->query("insert into ".$this->table5." (id, stokkodu, urunkodu, urlkodu, urun_TR, gorsel, video, marka, model, beden, uretici, tedarikci, kategori, magaza, doviztipi, listefiyati, eskifiyat, alisfiyati, satisfiyatikh, satisfiyatikd, kdvorani, stoksayisi, barkod, desi, kargosuresi, aciklama, ht, kb, ss, stamp, vitrin, yayin) values (:id, :stokkodu, :urunkodu, :urlkodu, :urun_TR, :gorsel, :video, :marka, :model, :beden, :uretici, :tedarikci, :kategori, :magaza, :doviztipi, :listefiyati, :eskifiyat, :alisfiyati, :satisfiyatikh, :satisfiyatikd, :kdvorani, :stoksayisi, :barkod, :desi, :kargosuresi, :aciklama, :ht, :kb, :ss, :stamp, :vitrin, :yayin);", $bind);
					$log .= $urun_TR." eklendi.\r\n";
				};
				$sayac++;
				#if($sayac == 1) break;
			};
			$log .= "XML İçeri aktarım işlemi tamamlandı.";
			$this->log->set($log, 'xml');
			return true;
		}

	};

?>