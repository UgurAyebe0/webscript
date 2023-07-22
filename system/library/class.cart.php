<?php
	class cart extends core{
		public $config;
		public $db;
		public $calc;
		public $sepetkodu;
		public $urunSayisi;
		public $araToplam;
		public $kdvTutari;
		public $kargoBedeli;
		public $genelToplam;
		public $httpStatus;
		public $subStatus;		
		public function __construct(){
			$this->sepetkodu   = $_COOKIE['__pcrt'];
			$this->urunSayisi  = 0;
			$this->araToplam   = 0;
			$this->kdvTutari   = 0;
			$this->kargoBedeli = 0;
			$this->genelToplam = 0;
			if($_SERVER['HTTPS'] == "on"){
				$this->httpStatus = "https";
			} else {
				$this->httpStatus = "http";
			};
			$this->subStatus  = explode('.', $_SERVER['HTTP_HOST']);
			$this->subStatus  = $this->subStatus[0];
		}
		public function __destruct(){
		}
		public function count(){
			$this->urunSayisi  = 0;
			$this->araToplam   = 0;
			$this->kdvTutari   = 0;
			$this->genelToplam = 0;
			$this->kargoBedeli = 0;
			$sepet = $this->db->single("select sepet from sal_sepet where (sepetkodu = :sepetkodu);", array('sepetkodu' => $this->sepetkodu));
			$kbd = 0;
			foreach(json_decode($sepet, true) as $node){
				$urun = $this->db->row("select * from cat_urunler where (stokkodu = :stokkodu);", array("stokkodu" => $node['stk']));
				$this->genelToplam += $this->calc->fiyattan_kurus($urun['satisfiyatikd']) * $node['adt'];
				$this->araToplam   += round($this->calc->kdv_dahil_tutardan_kdv_haric_tutar($this->calc->fiyattan_kurus($urun['satisfiyatikd']), $urun['kdvorani']) * $node['adt']);
				$this->kdvTutari   += round($this->calc->kdv_dahil_tutardan_kdv_tutari($this->calc->fiyattan_kurus($urun['satisfiyatikd']), $urun['kdvorani']) * $node['adt']);
				$this->urunSayisi  += $node['adt'];
				$this->desi		   += ($urun['desi']*$node['adt']);
				$kbdeger = $urun['kb'];
				if($kbdeger == 0){
					$kbd++;
				}
			};
			$altlimit = $this->db->single("select kargobedava from car_firmalar where yayin = '1'");
			if($this->genelToplam < $this->calc->fiyattan_kurus($altlimit) and $kbd > 0){
				$kargofiyati = $this->db->row("select * from car_firmalar where yayin = '1'");
				if($this->desi >= $kargofiyati['desi1alt'] and $this->desi <= $kargofiyati['desi1ust']){
					$this->kargoBedeli  = $this->calc->fiyattan_kurus($kargofiyati['desi1fiyat']);
				}elseif($this->desi >= $kargofiyati['desi2alt'] and $this->desi <= $kargofiyati['desi2ust']){
					$this->kargoBedeli  = $this->calc->fiyattan_kurus($kargofiyati['desi2fiyat']);
				}elseif($this->desi >= $kargofiyati['desi3alt'] and $this->desi <= $kargofiyati['desi3ust']){
					$this->kargoBedeli  = $this->calc->fiyattan_kurus($kargofiyati['desi3fiyat']);
				}elseif($this->desi >= $kargofiyati['desi4alt'] and $this->desi <= $kargofiyati['desi4ust']){
					$this->kargoBedeli  = $this->calc->fiyattan_kurus($kargofiyati['desi4fiyat']);
				}
				else{
					$fazladesi = $this->desi - $kargofiyati['desi4ust'];
					$artan = $fazladesi * $this->calc->fiyattan_kurus($kargofiyati['artan']);
					$this->kargoBedeli  = $this->calc->fiyattan_kurus($kargofiyati['desi4fiyat']) + $artan;
				}			
				$this->genelToplam += $this->kargoBedeli;
				if($_SESSION['kuponkodu'] != NULL){
					$kupontutar = $this->db->single("select tutar from hediye_ceki where (user = :user) && (kod = :kod);",array('user' => $_SESSION['www']['user'], 'kod' => $_SESSION['kuponkodu']));
				}	
				if($kupontutar){
					$kupontutari = $kupontutar * 100;
					if($kupontutari <= $this->genelToplam){
						$this->genelToplam -= $kupontutari;
					}					
				}
				$this->araToplam   += round($this->calc->kdv_dahil_tutardan_kdv_haric_tutar($this->kargoBedeli, 18));
				$this->kdvTutari   += round($this->calc->kdv_dahil_tutardan_kdv_tutari($this->kargoBedeli, 18));
			};
			$this->genelToplam = $this->calc->kurusdan_fiyat($this->genelToplam);
			$this->araToplam   = $this->calc->kurusdan_fiyat($this->araToplam);
			$this->kdvTutari   = $this->calc->kurusdan_fiyat($this->kdvTutari);
			$this->kargoBedeli = $this->calc->kurusdan_fiyat($this->kargoBedeli);
			$_SESSION['www']['urunSayisi'] = $this->urunSayisi;
		}
		public function _select($stokkodu, $adet, $mode, $bedenkodu){
			$urun     = $this->db->row("select * from cat_urunler where (stokkodu = :stokkodu);", array('stokkodu' => $stokkodu));
			$kategori = $this->db->row("select * from cat_kategoriler where (id = :id);", array('id' => $urun['kategori']));
			if($this->subStatus != "m"){
				$data  = "<span id='sepetToplamfiyatkh' data-indis='".$urun['stokkodu']."' class='hidden'>".$urun['satisfiyatikh']."</span>";
				$data .= "<tr data-indis='".$urun['stokkodu']."'>";
					$data .= "<td width='65'>";
						$data .= "<a href='".$this->config['global']['domain'].$urun['urlkodu']."' class='thumbnail' style='margin-bottom:0px !important;'>";
							$gorsel = json_decode($urun['gorsel'])[0];
							if(!file_get_contents($this->config['global']['CDN'].'files/product/'.$gorsel)){
								$data .= "<div style='width:45px; height:45px; text-align:center;'>";
									$data .= "<i class='fa fa-photo' style='color:#DDD; line-height:47px; font-size:40px;'></i>";
								$data .= "</div>";
							} else {
								$data .= "<div style='width:45px; height:45px; overflow:hidden;'>";
									$data .= "<img src='".$this->config['global']['CDN']."files/product/".$gorsel."' id='sepetUrungorsel' data-indis='".$urun['stokkodu']."' width='100%' title='' alt='' />";
								$data .= "</div>";
							};
						$data .= "</a>";
					$data .= "</td>";
					$data .= "<td>";
						$data .= "<p>";
							$data .= "<a href='".$this->config['global']['domain'].$urun['urlkodu']."'>";
								$data .= "<small id='sepetUrunadi' data-indis='".$urun['stokkodu']."'>".$urun['urun_TR']."</small> ";
							$data .= "</a>";
							if($urun['ozellikler']){
								$data .= "<small class='label label-default' style='padding:2px 5px;' title='Ozellikler'>";
									$data .= $_SESSION['ozellikler'][$urun['stokkodu']]; #$this->db->single("select ozellikler from cat_urunler where (id = :id);", array('id' => $urun['id']));
								$data .= "</small>";
							};
						$data .= "</p>";
						/*
						if($urun['ht'] != 0){ # hızlı teslim
							$data .= "<div class='btn btn-xs btn-default btn-ht' disabled='disabled'>";
								$data .= "<i class='fa fa-fw fa-clock-o'></i>";
								$data .= "<span> 24 Saatte Kargo</span>";
							$data .= "</div> ";
						};
						*/
						if($urun['kb'] != 0 and $urun['ozellik'] != 'epin'){ # kargo bedava
							$data .= "<div class='btn btn-xs btn-default btn-kb' disabled='disabled'>";
								$data .= "<i class='fa fa-fw fa-gift'></i>";
								$data .= "<span> Kargo Bedava</span>";
							$data .= "</div> ";
						};
						if($urun['ss'] != 0){ # sınırlı stok
							$data .= "<div class='btn btn-xs btn-default btn-ss' disabled='disabled'>";
								$data .= "<i class='fa fa-fw fa-archive'></i>";
								$data .= "<span> Sınırlı Stok</span>";
							$data .= "</div> ";
						};
					$data .= "</td>";
					$data .= "<td>";
					if($urun['kargobilgi'] == 'Satıcı Öder'){
						$data .= '<font style="color:green">'.$urun['kargobilgi'].'</font>';
					}elseif($urun['kargobilgi'] == 'Alıcı Öder'){
						$data .= '<font style="color:red">'.$urun['kargobilgi'].'</font>';
					}elseif($urun['kargobilgi'] == 'Online Teslimat'){
						$data .= '<font style="color:green">Online Teslimat</font>';
					}elseif($urun['kargobilgi'] == 'Oyuniçi Teslimat'){
						$data .= '<font style="color:red">Oyuniçi Teslimat</font>';
					}elseif($urun['kargobilgi'] == 'Steam Gift'){
						$data .= '<font style="color:red">Steam Gift</font>';
					}
					
					$data .= "</td>";
					if($mode == "pulse"){
						$data .= "<td align='center' width='80'>";
							$data .= $adet;
						$data .= "</td>";
					} else {
						$data .= "<td width='80'>";
							$data .= "<div class='input-group input-group-number'>";
								$data .= "<span class='input-group-btn'>";
									$data .= "<button class='btn btn-default' type='button' data-indis='".$urun['stokkodu']."' data-bedenkodu='".$bedenkodu."' onclick=\"minusSepet($(this), '".$this->httpStatus."');\"><i class='fa fa-minus'></i></button>";
								$data .= "</span>";
								if($bedenkodu){
									$stoksayisi = json_decode($urun['beden'], true);
									$stoksayisi = $stoksayisi[$bedenkodu]['stoksayisi'];
								} else {
									$stoksayisi = $urun['stoksayisi'];
								};
								$data .= "<input type='text' id='sepetUrunadet' class='form-control' data-indis='".$urun['stokkodu']."' data-bedenkodu='".$bedenkodu."' data-max='".$stoksayisi."' value='".$adet."' readonly='readonly' style='cursor:text;' />";
								$data .= "<span class='input-group-btn'>";
									$data .= "<button class='btn btn-default' type='button' data-indis='".$urun['stokkodu']."' data-bedenkodu='".$bedenkodu."' onclick=\"plusSepet($(this), '".$this->httpStatus."');\"><i class='fa fa-plus'></i></button>";
								$data .= "</span>";
							$data .= "</div>";
						$data .= "</td>";
					};
					$data .= "<td width='90'>";
						$data .= "<span id='sepetBirimfiyat' data-indis='".$urun['stokkodu']."'>".$this->calc->tutar_format($urun['satisfiyatikd'])."</span> <i class='fa fa-".$urun['doviztipi']."'></i>";
						if(($mode != "pulse") && ($urun['eskifiyat'] != 0)){
							$data .= "<br />";
							$data .= "<small class='text-muted'><s id='sepetEskifiyat' data-indis='".$urun['stokkodu']."'>".$this->calc->tutar_format($urun['eskifiyat'])."</s> <i class='fa fa-".$urun['doviztipi']."'></i></small>";
						};
					$data .= "</td>";
					$data .= "<td width='90'>";
						$data .= "<strong>";
							$data .= "<span id='sepetToplamfiyat' data-indis='".$urun['stokkodu']."' data-bedenkodu='".$bedenkodu."'>";
								$data .= $this->calc->kurusdan_fiyat($this->calc->fiyattan_kurus($urun['satisfiyatikd']) * $adet);
							$data .= "</span>";
							$data .= " <i class='fa fa-".$urun['doviztipi']."'></i>";
						$data .= "</strong>";
					$data .= "</td>";
					if($mode != "pulse"){
						$data .= "<td width='1'>";
							$data .= "<button type='button' id='btnCartRemove' class='btn btn-xs btn-danger' data-indis='".$urun['stokkodu']."' data-bedenkodu='".$bedenkodu."' onclick='removeSepet($(this));'><i class='fa fa-remove'></i></button>";
						$data .= "</td>";
					};
				$data .= "</tr>";
				return $data;
			} else {
				$data  = "<span id='sepetToplamfiyatkh' data-indis='".$urun['stokkodu']."' class='hidden'>".$urun['satisfiyatikh']."</span>";
				$data .= "<tr data-indis='".$urun['stokkodu']."'>";
					$data .= "<td width='72'>";
						$data .= "<a href='".$this->config['global']['domain'].$urun['urlkodu']."' class='thumbnail' style='margin-bottom:5px !important;'>";
							$gorsel = json_decode($urun['gorsel'])[0];
							if(!file_get_contents($this->config['global']['CDN'].'files/product/'.$gorsel)){
								$data .= "<div style='width:52px; height:52px; text-align:center;'>";
									$data .= "<i class='fa fa-photo' style='color:#DDD; line-height:47px; font-size:40px;'></i>";
								$data .= "</div>";
							} else {
								$data .= "<div style='overflow:hidden;'>";
									$data .= "<img src='".$this->config['global']['CDN']."files/product/".$gorsel."' id='sepetUrungorsel' data-indis='".$urun['stokkodu']."' width='100%' title='' alt='' />";
								$data .= "</div>";
							};
						$data .= "</a>";
						$data .= "<div class='input-group input-group-number' style='width:52px;'>";
							$data .= "<span class='input-group-btn'>";
								$data .= "<button class='btn btn-xs btn-default' type='button' data-indis='".$urun['stokkodu']."' data-bedenkodu='".$bedenkodu."' onclick=\"minusSepet($(this), '".$this->httpStatus."');\"><i class='fa fa-minus'></i></button>";
							$data .= "</span>";
							if($bedenkodu){
								$stoksayisi = json_decode($urun['beden'], true);
								$stoksayisi = $stoksayisi[$bedenkodu]['stoksayisi'];
							} else {
								$stoksayisi = $urun['stoksayisi'];
							};
							$data .= "<input type='text' id='sepetUrunadet' class='form-control input-xs' data-indis='".$urun['stokkodu']."' data-bedenkodu='".$bedenkodu."' data-max='".$stoksayisi."' value='".$adet."' readonly='readonly' style='cursor:text; border-left:none;' />";
							$data .= "<span class='input-group-btn'>";
								$data .= "<button class='btn btn-xs btn-default' type='button' data-indis='".$urun['stokkodu']."' data-bedenkodu='".$bedenkodu."' onclick=\"plusSepet($(this), '".$this->httpStatus."');\"><i class='fa fa-plus'></i></button>";
							$data .= "</span>";
						$data .= "</div>";
					$data .= "</td>";
					$data .= "<td>";
						$data .= "<p>";
							$data .= "<a href='".$this->config['global']['domain'].$urun['urlkodu']."'>";
								$data .= "<small id='sepetUrunadi' data-indis='".$urun['stokkodu']."'>".$urun['urun_TR']."</small> ";
							$data .= "</a>";
							if($bedenkodu){
								$data .= "<small class='label label-default' style='padding:2px 5px;' title='Beden'>";
									$data .= $this->db->single("select beden_TR from cat_bedenler where (id = :id);", array('id' => $bedenkodu));
								$data .= "</small>";
							};
						$data .= "</p>";
						if($urun['kb'] != 0 and $urun['ozellik'] != 'epin'){ # kargo bedava
							$data .= "<div class='btn btn-xs btn-default btn-kb' disabled='disabled'>";
								$data .= "<i class='fa fa-fw fa-gift'></i>";
								$data .= "<span> Kargo Bedava</span>";
							$data .= "</div> ";
						};
						if($urun['ss'] != 0){ # sınırlı stok
							$data .= "<div class='btn btn-xs btn-default btn-ss' disabled='disabled'>";
								$data .= "<i class='fa fa-fw fa-archive'></i>";
								$data .= "<span> Sınırlı Stok</span>";
							$data .= "</div> ";
						};
						$data .= "Birim Fiyat: <span id='sepetBirimfiyat' data-indis='".$urun['stokkodu']."'>".$this->calc->tutar_format($urun['satisfiyatikd'])."</span> <i class='fa fa-".$urun['doviztipi']."'></i>";
						if($urun['eskifiyat'] != 0){
							$data .= "<br />";
							$data .= "<small class='text-muted'><s id='sepetEskifiyat' data-indis='".$urun['stokkodu']."'>".$this->calc->tutar_format($urun['eskifiyat'])."</s> <i class='fa fa-".$urun['doviztipi']."'></i></small>";
						};
						$data .= "<br />";
						$data .= "<strong>";
							$data .= "Toplam Fiyat: ";
							$data .= "<span id='sepetToplamfiyat' data-indis='".$urun['stokkodu']."' data-bedenkodu='".$bedenkodu."'>";
								$data .= $this->calc->kurusdan_fiyat($this->calc->fiyattan_kurus($urun['satisfiyatikd']) * $adet);
							$data .= "</span>";
							$data .= " <i class='fa fa-".$urun['doviztipi']."'></i>";
						$data .= "</strong>";
					$data .= "</td>";
					$data .= "<td width='1'>";
						$data .= "<button type='button' id='btnCartRemove' class='btn btn-xs btn-danger' data-indis='".$urun['stokkodu']."' data-bedenkodu='".$bedenkodu."' onclick='removeSepet($(this));'><i class='fa fa-remove'></i></button>";
					$data .= "</td>";
				$data .= "</tr>";
				return $data;
			};
		}
		public function select($stokkodu, $adet, $mode = "www"){
			if(!empty($stokkodu)){
				if(!empty($adet)){
					$data = $this->_select($stokkodu, $adet, $mode);
				} else {
					$data = $this->_select($stokkodu, 1, $mode);
				};
			} elseif(!empty($this->sepetkodu)){
				unset($data);
				$sepet = $this->db->single("select sepet from sal_sepet where (sepetkodu = :sepetkodu);", array('sepetkodu' => $this->sepetkodu));
				foreach(json_decode($sepet, true) as $urun){
					if($urun['bdn'] != ''){
						foreach($urun['bdn'] as $beden){
							$data .= $this->_select($urun['stk'], $beden['adt'], $mode, $beden['kod']);
						};
					} else {
						$data .= $this->_select($urun['stk'], $urun['adt'], $mode);
					};
				};
			};
			$this->count();
			return $data;
		}
		public function status($stokkodu = false, $bedenkodu = false, $mode = null){
			if($mode === true)  return true;
			if($mode === false) return false;
			$sepet = $this->db->row("select * from sal_sepet where (sepetkodu = :sepetkodu);", array('sepetkodu' => $this->sepetkodu));
			if($sepet){
				if($stokkodu != false){
					$sepet = json_decode($sepet['sepet'], true);
					if($bedenkodu != false){
						if($sepet[$stokkodu]['bdn'][$bedenkodu]) return true; else return false;
					} else {
						if($sepet[$stokkodu]) return true; else return false;
					};
				} else return true;
			} else return false;
		}
		/*
		public function status($stokkodu){
			$sepet = $this->db->single("select sepet from sal_sepet where (sepetkodu = :sepetkodu);", array('sepetkodu' => $this->sepetkodu));
			$sepet = json_decode($sepet, true);
			if(!empty($stokkodu) && isset($sepet[$stokkodu])){
				return true;
			};
			return false;
		}
		*/
	};
?>