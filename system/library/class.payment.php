<?php
	class payment extends core{
		public $config;
		public $db;
		public $tool;
		public $cart;
		public $calc;
		public $mail;
		public $log;	
		public function __construct(){
		}
		public function __destruct(){
		}
		private function prepareIl($id){
			if($id != ''){
				return $this->db->single("select il_TR from loc_iller where (id = :id);", array('id' => $id));
			} else {
				return '';
			};
		}
		private function prepareEST($post, $poskodu, $modulkodu){
			$siparis = $this->db->row("select * from sal_siparisler where (sipariskodu = :sipariskodu);", array('sipariskodu' => $post['sipariskodu']));
			$adres   = json_decode($siparis['adres'], true);
			$sepet   = json_decode($siparis['sepet'], true);
			$bind    = array('poskodu' => $poskodu, 'modulkodu' => $modulkodu);
			$pos     = $this->db->row("select * from pay_3dpos where (poskodu = :poskodu) && (modulkodu = :modulkodu);", $bind);
			$detay   = json_decode($pos['detay'], true);
			$prm['api']								= $detay[$modulkodu]['api'];
			$prm['pan']								= $post['cartNumber1'].$post['cartNumber2'].$post['cartNumber3'].$post['cartNumber4'];
			$prm['cv2']								= $post['cartCVC2'];
			$prm['Ecom_Payment_Card_ExpDate_Year']	= $post['cartYear'];
			$prm['Ecom_Payment_Card_ExpDate_Month']	= $post['cartMonth'];
			$prm['cardType']						= $post['cartType'];
			$prm['clientid']						= $detay[$modulkodu]['clientid'];
			$prm['storekey']						= $detay[$modulkodu]['storekey'];
			$prm['islemtipi']						= $detay[$modulkodu]['islemtipi'];
			$prm['amount']							= $post['genelToplam'];
			$prm['oid']								= $post['sipariskodu'];
			$prm['rnd']								= microtime();
			$prm['okUrl']							= $this->config['global']['domain'].'siparis/onay';
			$prm['failUrl']							= $this->config['global']['domain'].'siparis/hata';
			if(($post['cartInstallment'] == 1) || ($post['cartInstallment'] == '')){
				$prm['hash']						= base64_encode(pack('H*',sha1($prm['clientid'].$prm['oid'].$prm['amount'].$prm['okUrl'].$prm['failUrl'].$prm['islemtipi'].$prm['rnd'].$prm['storekey'])));
			} else {
				$prm['taksit']						= $post['cartInstallment'];
				$prm['hash']						= base64_encode(pack('H*',sha1($prm['clientid'].$prm['oid'].$prm['amount'].$prm['okUrl'].$prm['failUrl'].$prm['islemtipi'].$prm['taksit'].$prm['rnd'].$prm['storekey'])));
			};
			$prm['storetype']						= $detay[$modulkodu]['storetype'];
			$prm['lang']							= $detay[$modulkodu]['lang'];
			$prm['currency']						= $detay[$modulkodu]['currency'];
			$prm['firmaadi']						= "Heg Bilgisayar Yazılım Reklamcılık Bilişim Hizmetleri San. Tic. Ltd. Şti.";
			/* Teslimat Adresi */
				$prm['tismi']						= $adres['adi']." ".$adres['soyadi'];
				$prm['nakliyeFirma']				= $adres['firmaadi'];
				$prm['tadres']						= $adres['adres'];
				$prm['til']							= $this->prepareIl($adres['il']);
				$prm['tulkekod']					= "tr";
				$prm['tpostakodu']					= $adres['postakodu'];
				$prm['tilce']						= $adres['ilce'];
			/* Teslimat Adresi */
			/* Fatura Adresi */
				$prm['fismi']						= $adres['f_adi']." ".$adres['f_soyadi'];
				$prm['faturaFirma']					= $adres['firmaadi'];
				$prm['tel']							= $adres['ceptel'];
				$prm['fadres']						= $adres['f_adres'];
				$prm['fil']							= $this->prepareIl($adres['f_il']);
				$prm['fulkekod']					= "tr";
				$prm['fpostakodu']					= $adres['f_postakodu'];
				$prm['filce']						= $adres['f_ilce'];
			/* Fatura Adresi */
			/* Siparişe Ait Ürünler */
				$indis = 1;
				foreach($sepet as $stokkodu => $urun){
					$prm['itemnumber'.$indis]		= $urun['urunkodu'];
					$prm['productcode'.$indis]		= $stokkodu;
					$prm['desc'.$indis]				= $urun['urun_TR'];
					$prm['id'.$indis]				= $urun['urun_TR'];
					$prm['qty'.$indis]				= $urun['adet'];
					$prm['price'.$indis]			= $this->calc->tutar_format($urun['satisfiyatikd']);
					$prm['total'.$indis]			= $this->calc->kurusdan_fiyat($this->calc->fiyattan_kurus($urun['satisfiyatikd']) * $urun['adet']);
					$indis++;
				};
			/* Siparişe Ait Ürünler */
			return json_encode($prm);
		}
		private function prepareGVP($post, $poskodu, $modulkodu){
			$bind  = array('poskodu' => $poskodu, 'modulkodu' => $modulkodu);
			$pos   = $this->db->row("select * from pay_3dpos where (poskodu = :poskodu) && (modulkodu = :modulkodu);", $bind);
			$detay = json_decode($pos['detay'], true);
			if($post['cartInstallment'] == 1) $post['cartInstallment'] = '';
			$prm['api']						= $detay[$modulkodu]['api'];
			$prm['cardnumber']				= $post['cartNumber1'].$post['cartNumber2'].$post['cartNumber3'].$post['cartNumber4'];
			$prm['cardcvv2']				= $post['cartCVC2'];
			$prm['cardexpiredateyear']		= $post['cartYear'];
			$prm['cardexpiredatemonth']		= $post['cartMonth'];
			$prm['apiversion'] 				= $detay[$modulkodu]['apiversion'];
			$prm['terminalid'] 				= $detay[$modulkodu]['terminalid'];
			$prm['terminaluserid'] 			= $detay[$modulkodu]['terminaluserid'];
			$prm['terminalmerchantid'] 		= $detay[$modulkodu]['terminalmerchantid'];
			$prm['terminalprovuserid'] 		= $detay[$modulkodu]['terminalprovuserid'];
			$strTerminalID_ 				= str_repeat(0, (9 - strlen($detay[$modulkodu]['terminalid']))).$detay[$modulkodu]['terminalid'];
			$strProvisionPassword 			= $detay[$modulkodu]['provisionpassword'];
			$strStoreKey 					= $detay[$modulkodu]['storekey'];
			$prm['mode'] 					= $detay[$modulkodu]['mode'];
			$prm['txntype'] 				= $detay[$modulkodu]['txntype'];
			$prm['txncurrencycode'] 		= $detay[$modulkodu]['txncurrencycode'];
			$prm['txnamount'] 				= $post['genelToplam'];
			$prm['txninstallmentcount'] 	= $post['cartInstallment'];
			$prm['orderid'] 				= $post['sipariskodu'];
			$prm['customeripaddress'] 		= $this->tool->whatIsMyIp();
			$prm['customeremailaddress']	= "iletisim@oyunalisveris.com";
			$prm['successurl'] 				= $this->config['global']['domain'].'siparis/onay';
			$prm['errorurl'] 				= $this->config['global']['domain'].'siparis/hata';
			$prm['secure3dsecuritylevel'] 	= $detay[$modulkodu]['secure3dsecuritylevel'];
			$prm['secure3dhash'] 			= strtoupper(sha1($prm['terminalid'].$prm['orderid'].$prm['txnamount'].$prm['successurl'].$prm['errorurl'].$prm['txntype'].$prm['txninstallmentcount'].$strStoreKey.strtoupper(sha1($strProvisionPassword.$strTerminalID_))));
			return json_encode($prm);
		}
		private function preparePosnet($post, $poskodu, $modulkodu){
			$bind  = array('poskodu' => $poskodu, 'modulkodu' => $modulkodu);
			$pos   = $this->db->row("select * from pay_3dpos where (poskodu = :poskodu) && (modulkodu = :modulkodu);", $bind);
			$detay = json_decode($pos['detay'], true);
			$path = '../../../system/payment/posnet/';
			require_once($path.'posnet_oos_struct.php');
			require_once($path.'xml.php');
			require_once($path.'posnet_oos_xml.php');
			require_once($path.'http.php');
			require_once($path.'posnet_http.php');
			require_once($path.'posnet_enc.php');
			require_once($path.'posnet_oos.php');
			$posnetOOS = new PosnetOOS;
			#$posnetOOS->SetDebugLevel(1);
			$posnetOOS->SetPosnetID($detay[$modulkodu]['POSNETID']);
			$posnetOOS->SetMid($detay[$modulkodu]['MID']);
			$posnetOOS->SetTid($detay[$modulkodu]['TID']);
			$posnetOOS->SetURL($detay[$modulkodu]['XML_SERVICE_URL']);
			$posnetOOS->SetUsername($detay[$modulkodu]['USERNAME']);
			$posnetOOS->SetPassword($detay[$modulkodu]['PASSWORD']);
			switch($post['cartInstallment']){
				case 2:		$post['cartInstallment'] = '02';	break;
				case 3:		$post['cartInstallment'] = '03';	break;
				case 4:		$post['cartInstallment'] = '04';	break;
				case 5:		$post['cartInstallment'] = '05';	break;
				case 6:		$post['cartInstallment'] = '06';	break;
				case 7:		$post['cartInstallment'] = '07';	break;
				case 8:		$post['cartInstallment'] = '08';	break;
				case 9:		$post['cartInstallment'] = '09';	break;
				case 10:	$post['cartInstallment'] = '10';	break;
				case 11:	$post['cartInstallment'] = '11';	break;
				case 12:	$post['cartInstallment'] = '12';	break;
				default:	$post['cartInstallment'] = '00';	break;
			};
			$xid          = $post['sipariskodu'].str_repeat(0, (20 - strlen($post['sipariskodu'])));
			$amount       = $post['genelToplam'];																	#tutar (kurus cinsinden)
			$instnumber   = $post['cartInstallment'];																#taksit sayisi (tek haneli rakamlarda basa sifir konularak iki haneye tamamlanmali)
			$currencycode = $detay[$modulkodu]['CURRENCY'];															#para birimi (949 yerine TL kullanilmali)
			$trantype     = $detay[$modulkodu]['TRANTYPE'];															#islem tipi (Sale)
			$custName     = $post['cartName'];																		#Kart uzerindeki isim soyisim
			$ccno         = $post['cartNumber1'].$post['cartNumber2'].$post['cartNumber3'].$post['cartNumber4'];	#Pan, Kart numarasi
			$expdate      = $post['cartYear'].$post['cartMonth'];													#Son kullanma tarihi (YYAA)
			$cvc          = $post['cartCVC2'];																		#Guvenlik kodu
			$posnetOOS->CreateTranRequestDatas($custName, $amount, $currencycode, $instnumber, $xid, $trantype, $ccno, $expdate, $cvc);
			$prm['api']					= $detay[$modulkodu]['OOS_TDS_SERVICE_URL'];
			$prm['lang']				= $detay[$modulkodu]['LANG'];
			$prm['mid']					= $detay[$modulkodu]['MID'];
			$prm['posnetID']			= $detay[$modulkodu]['POSNETID'];
			$prm['merchantReturnURL']	= $this->config['global']['domain'].'siparis/provizyon';
			$prm['posnetData'] 			= $posnetOOS->GetData1();
			$prm['posnetData2'] 		= $posnetOOS->GetData2();
			$prm['digest'] 				= $posnetOOS->GetSign();
			#$prm['koiCode'] 			= 2;	#joker vadaa (bankaya gönderme hata alırsın)
			$prm['vftCode'] 			= null;
			$prm['url'] 				= null;
			return json_encode($prm);
		}
		public function payComplete($post){
			$user    = $_SESSION['www']['user'];
			$uye     = $this->db->row("select * from cus_uyeler where (user = :user);", array('user' => $user));
			$siparis = $this->db->row("select * from sal_siparisler where (user = :user) && (sipariskodu = :sipariskodu);", array('user' => $user, 'sipariskodu' => $uye['sipariskodu']));

			$aratoplam     = 0;
			$kdvtutari     = 0;
			$kargobedeli   = 0;
			$toplammaliyet = 0;
			$geneltoplam   = 0;

			foreach(json_decode($siparis['sepet'], true) as $key => $urun){
				$geneltoplam += $this->calc->fiyattan_kurus($urun['satisfiyatikd']) * $urun['adet'];
				$aratoplam   += round($this->calc->kdv_dahil_tutardan_kdv_haric_tutar($this->calc->fiyattan_kurus($urun['satisfiyatikd']), $urun['kdvorani']) * $urun['adet']);
				$kdvtutari   += round($this->calc->kdv_dahil_tutardan_kdv_tutari($this->calc->fiyattan_kurus($urun['satisfiyatikd']), $urun['kdvorani']) * $urun['adet']);
				$desi 		 += $urun['desi'] * $urun['adet'];
			};
			$altlimit = $this->db->single("select kargobedava from car_firmalar where yayin = '1'");
			if($geneltoplam < $this->calc->fiyattan_kurus($altlimit) and $urun['kb'] == '0'){

				$kargofiyati = $this->db->row("select * from car_firmalar where yayin = '1'");
				
				if($desi >= $kargofiyati['desi1alt'] and $desi <= $kargofiyati['desi1ust']){
					$kargobedeli  = $this->calc->fiyattan_kurus($kargofiyati['desi1fiyat']);
				}elseif($desi >= $kargofiyati['desi2alt'] and $desi <= $kargofiyati['desi2ust']){
					$kargobedeli   = $this->calc->fiyattan_kurus($kargofiyati['desi2fiyat']);
				}elseif($desi >= $kargofiyati['desi3alt'] and $desi <= $kargofiyati['desi3ust']){
					$kargobedeli   = $this->calc->fiyattan_kurus($kargofiyati['desi3fiyat']);
				}elseif($desi >= $kargofiyati['desi4alt'] and $desi <= $kargofiyati['desi4ust']){
					$kargobedeli   = $this->calc->fiyattan_kurus($kargofiyati['desi4fiyat']);
				}
				else{
					$fazladesi = $desi - $kargofiyati['desi4ust'];
					$artan = $fazladesi * $this->calc->fiyattan_kurus($kargofiyati['artan']);
					$kargobedeli   = $this->calc->fiyattan_kurus($kargofiyati['desi4fiyat']) + $artan;
				}
				$geneltoplam += $kargobedeli;
				$aratoplam   += round($this->calc->kdv_dahil_tutardan_kdv_haric_tutar($kargobedeli, 18));
				$kdvtutari   += round($this->calc->kdv_dahil_tutardan_kdv_tutari($kargobedeli, 18));
			};
			$geneltoplam = $this->calc->kurusdan_fiyat($geneltoplam);
			$aratoplam   = $this->calc->kurusdan_fiyat($aratoplam);
			$kdvtutari   = $this->calc->kurusdan_fiyat($kdvtutari);
			$kargobedeli = $this->calc->kurusdan_fiyat($kargobedeli);
			$json = array(
				'aratoplam'			=> $aratoplam,
				'kdvtutari'			=> $kdvtutari,
				'kargobedeli'		=> $kargobedeli,
				'toplammaliyet'		=> $toplammaliyet,
				'geneltoplam'		=> $geneltoplam,
				'odemeturu'			=> 'Banka Kartı',
				'havalebankasi'		=> null,	
				'taksitsayisi'		=> $_SESSION['www']['odeme']['taksitsayisi'],
				'tekcekimindirimi'	=> $_SESSION['www']['odeme']['tekcekimindirimi'],
				'kartbankasi'		=> $_SESSION['www']['odeme']['kartbankasi'],
				'sanalposmodulu'	=> $_SESSION['www']['odeme']['sanalposmodulu'],
				'bankavadefarki'	=> $_SESSION['www']['odeme']['bankavadefarki'],
				'musterivadefarki'	=> $_SESSION['www']['odeme']['musterivadefarki']
			);
			unset($_SESSION['www']['odeme']);
			$bind = array(
				'odeme'			=> json_encode($json),
				'user'			=> $user,
				'sipariskodu'	=> $uye['sipariskodu']
			);
			$this->db->query("update sal_siparisler set asama = 'odeme', surec = 'Sipariş Hazırlanıyor', odeme = :odeme where (user = :user) && (sipariskodu = :sipariskodu);", $bind);

			/* siparis edilen ürünler ürün adetleri kadar stoktan düşülüyor */
			$hash = $this->db->single("select sepet from sal_sepet where (sepetkodu = :sepetkodu);", array('sepetkodu' => $user));
			foreach(json_decode($hash, true) as $key => $node){
				if($node['bdn'] != ''){
					$buffer = array();
					$beden  = $this->db->single("select beden from cat_urunler where (stokkodu = :stokkodu);", array('stokkodu' => $node['stk']));
					foreach(json_decode($beden, true) as $bedenkodu => $value){
						if(is_array($node['bdn'][$bedenkodu])){
							if($value['stoksayisi'] >= $node['bdn'][$bedenkodu]['adt']){
								$stoksayisi = $value['stoksayisi'] - $node['bdn'][$bedenkodu]['adt'];
							} else {
								$stoksayisi = 0;
								$this->log->set($node['stk'].' Kritik Hata: Giyim kategorisinde bulunan bir üründe sepete stok sayısından fazla ürün eklenmiş.', 'sys');
							};
						} else {
							$stoksayisi = $value['stoksayisi'];
						};
						$buffer[$bedenkodu] = array(
							'barkod'		=> $value['barkod'],
							'bedenkodu'		=> $value['bedenkodu'],
							'stoksayisi'	=> $stoksayisi
						);
					};
					$this->db->query("update cat_urunler set beden = :beden where (stokkodu = :stokkodu);", array('beden' => json_encode($buffer), 'stokkodu' => $node['stk']));
				};
				$this->db->query("update cat_urunler set stoksayisi = (stoksayisi - :adet) where (stokkodu = :stokkodu);", array('stokkodu' => $node['stk'], 'adet' => $node['adt']));
				#$this->db->query("update epinler set durum = '0' where (kodid = :kodid) and (durum = '1') LIMIT 1;", array('kodid' => $node['stk']));

			};
			/* üyeye ait olan sepet boşaltılıyor */
			$this->db->query("delete from sal_sepet where (sepetkodu = :sepetkodu);", array('sepetkodu' => $user));
			$this->db->query("update epinler set durum = '0' where (kodid = :kodid) and (durum = '1') LIMIT 1;", array('kodid' => $node['stk']));

			/* üyeler tablosundan sipariskodu alanı temizleniyor */
			$this->db->query("update cus_uyeler set sipariskodu = '' where (user = :user);", array('user' => $user));

			/* siparis ve sepet bilgilerini taşıyan cookie temizlenip uniqid ataması yapılıyor */
			setcookie('__pcrt', uniqid(), time() + (10 * 365 * 24 * 60 * 60), "/");

			$this->mail->sendContentTemplate('siparis-kredi-karti', $uye, $siparis);
			$this->mail->sendOrderEnd($uye['sipariskodu']);
		}
		public function pay3DPos($post){

			$uye     = $this->db->row("select * from cus_uyeler where (user = :user);", array('user' => $_SESSION['www']['user']));

			$bin     = substr($post['cartNumber1'].$post['cartNumber2'], 0, 6);
			$bin     = $this->db->row("select * from pay_bin where (bin = :bin) && (yayin = 1);", array('bin' => $bin));

			$kart    = $this->db->row("select * from pay_kartlar where (kartkodu = :kartkodu) && (yayin = 1);", array('kartkodu' => $bin['kartkodu']));
			$taksit  = json_decode($kart['taksit'], true);
			$genelToplam = $this->cart->count();
			$genelToplam = $this->cart->genelToplam;
			if($bin){				
				if(!empty($bin['kartkodu'])){
					$bankakodu = $kart['bankakodu'];
				} else {
					$bankakodu = $bin['bankakodu'];
				};
				$banka = $this->db->row("select * from pay_bankalar where (bankakodu = :bankakodu) && (yayin = 1);", array('bankakodu' => $bankakodu));
				$marka = $this->db->row("select * from pay_markalar where (markakodu = :markakodu) && (yayin = 1);", array('markakodu' => $bin['markakodu']));
				$post['cartType'] = $marka['deger'];
				if($bin['taksit'] == 1){
					if($post['cartInstallment'] == 1){
						if($marka['markakodu'] == 'amex'){
							$poskodu = $marka['tekcekim'];
						} else {
							$poskodu = $banka['tekcekim'];
						};
						$indirim = floor(($this->calc->fiyattan_kurus($genelToplam) / 100) * floatval($kart['indirim']));
					} else {
						$poskodu = $banka['poskodu'];
					};
				} else {
					if($marka['markakodu'] == 'amex'){
						$poskodu = $marka['tekcekim'];
					} else {
						$poskodu = $banka['tekcekim'];
					};
				};
				$pos = $this->db->row("select * from pay_3dpos where (poskodu = :poskodu) && (yayin = 1);", array('poskodu' => $poskodu));	
				if($bin['ticari'] == 1){
					$tip = 'ticari';
				} else {
					$tip = 'standart';
				};
				$genelToplam = $this->calc->fiyattan_kurus($genelToplam);
				$_SESSION['www']['odeme']['musterivadefarki'] = floor(($genelToplam / 100) * floatval($taksit[$tip]['mvade'][$post['cartInstallment']]));
				$_SESSION['www']['odeme']['bankavadefarki']   = floor(($genelToplam / 100) * floatval($taksit[$tip]['bvade'][$post['cartInstallment']]));
				$genelToplam = $genelToplam + floor(($genelToplam / 100) * floatval($taksit[$tip]['mvade'][$post['cartInstallment']]));
				$genelToplam = $genelToplam - $indirim;	
				if($pos['modulkodu'] == 'est'){
					$genelToplam = $this->calc->kurusdan_fiyat($genelToplam);
				};			
			} else {

				$pos     = $this->db->row("select * from pay_3dpos where (varsayilan = 1) && (yayin = 1);");
				$poskodu = $pos['poskodu'];
			};
			$post['genelToplam'] = $genelToplam;
			$post['sipariskodu'] = $uye['sipariskodu'];

			$_SESSION['www']['odeme']['taksitsayisi']		= $post['cartInstallment'];
			$_SESSION['www']['odeme']['tekcekimindirimi']	= $indirim;
			$_SESSION['www']['odeme']['kartbankasi']		= $bankakodu;
			$_SESSION['www']['odeme']['sanalposmodulu']		= $pos['pos_TR'].' ('.$pos['modulkodu'].')';

			if($pos['modulkodu'] == 'est'){

				return $this->prepareEST($post, $poskodu, $pos['modulkodu']);

			} elseif($pos['modulkodu'] == 'gvp'){

				return $this->prepareGVP($post, $poskodu, $pos['modulkodu']);

			} elseif($pos['modulkodu'] == 'posnet'){

				return $this->preparePosnet($post, $poskodu, $pos['modulkodu']);

			} else {
				return false;
			};

		}
		public function payHavale($post){
			$user    = $_SESSION['www']['user'];
			$uye     = $this->db->row("select * from cus_uyeler where (user = :user);", array('user' => $user));
			$siparis = $this->db->row("select * from sal_siparisler where (user = :user) && (sipariskodu = :sipariskodu);", array('user' => $user, 'sipariskodu' => $uye['sipariskodu']));

			$aratoplam     = 0;
			$kdvtutari     = 0;
			$kargobedeli   = 0;
			$toplammaliyet = 0;
			$geneltoplam   = 0;
			$k = 0;
			foreach(json_decode($siparis['sepet'], true) as $key => $urun){
				$geneltoplam += $this->calc->fiyattan_kurus($urun['satisfiyatikd']) * $urun['adet'];
				$aratoplam   += round($this->calc->kdv_dahil_tutardan_kdv_haric_tutar($this->calc->fiyattan_kurus($urun['satisfiyatikd']), $urun['kdvorani']) * $urun['adet']);
				$kdvtutari   += round($this->calc->kdv_dahil_tutardan_kdv_tutari($this->calc->fiyattan_kurus($urun['satisfiyatikd']), $urun['kdvorani']) * $urun['adet']);
				$desi 		 += $urun['desi'] * $urun['adet'];
				$urunkb = $this->db->single("select kb from cat_urunler where (urlkodu = :urlkodu);",array('urlkodu' => $urun['urlkodu']));
				if($urunkb == '0'){
					$k++;
				}
			};
			if($_SESSION['kuponkodu'] != NULL){
				$kupontutar = $this->db->single("select tutar from hediye_ceki where (user = :user) && (kod = :kod);",array('user' => $_SESSION['www']['user'], 'kod' => $_SESSION['kuponkodu']));
				$kupontutarr = $kupontutar * 100;
				$geneltoplam -= $kupontutarr; 
			}
			$altlimit = $this->db->single("select kargobedava from car_firmalar where yayin = '1'");			
			if($geneltoplam < $this->calc->fiyattan_kurus($altlimit) and $k != 0){
				$kargofiyati = $this->db->row("select * from car_firmalar where yayin = '1'");
				
				if($desi >= $kargofiyati['desi1alt'] and $desi <= $kargofiyati['desi1ust']){
					$kargobedeli  = $this->calc->fiyattan_kurus($kargofiyati['desi1fiyat']);
				}elseif($desi >= $kargofiyati['desi2alt'] and $desi <= $kargofiyati['desi2ust']){
					$kargobedeli   = $this->calc->fiyattan_kurus($kargofiyati['desi2fiyat']);
				}elseif($desi >= $kargofiyati['desi3alt'] and $desi <= $kargofiyati['desi3ust']){
					$kargobedeli   = $this->calc->fiyattan_kurus($kargofiyati['desi3fiyat']);
				}elseif($desi >= $kargofiyati['desi4alt'] and $desi <= $kargofiyati['desi4ust']){
					$kargobedeli   = $this->calc->fiyattan_kurus($kargofiyati['desi4fiyat']);
				}
				else{
					$fazladesi = $desi - $kargofiyati['desi4ust'];
					$artan = $fazladesi * $this->calc->fiyattan_kurus($kargofiyati['artan']);
					$kargobedeli   = $this->calc->fiyattan_kurus($kargofiyati['desi4fiyat']) + $artan;
				}
				$geneltoplam += $kargobedeli;
				$aratoplam   += round($this->calc->kdv_dahil_tutardan_kdv_haric_tutar($kargobedeli, 18));
				$kdvtutari   += round($this->calc->kdv_dahil_tutardan_kdv_tutari($kargobedeli, 18));
			};
			$puan = $geneltoplam / 100;
			$geneltoplam = $this->calc->kurusdan_fiyat($geneltoplam);
			$aratoplam   = $this->calc->kurusdan_fiyat($aratoplam);
			$kdvtutari   = $this->calc->kurusdan_fiyat($kdvtutari);
			$kargobedeli = $this->calc->kurusdan_fiyat($kargobedeli);
			if($_SESSION['kuponkodu'] != NULL){
				$kupontutar  = $this->calc->kurusdan_fiyat($kupontutarr);
				$kuponkodu   = $_SESSION['kuponkodu'];
			}else{
				$kupontutar  = null;
				$kuponkodu   = null;
			}
			
			$json = array(
				'aratoplam'			=> $aratoplam,
				'kdvtutari'			=> $kdvtutari,
				'kargobedeli'		=> $kargobedeli,
				'toplammaliyet'		=> $toplammaliyet,
				'geneltoplam'		=> $geneltoplam,
				'kuponkodu'			=> $kuponkodu,
				'kupontutari'		=> $kupontutar,
				'puan'				=> $puan,
				'odemeturu'			=> 'EFT / Havale',
				'havalebankasi'		=> $post['banka'],	
				'taksitsayisi'		=> null,
				'tekcekimindirimi'	=> null,
				'kartbankasi'		=> null,
				'sanalposmodulu'	=> null,
				'bankavadefarki'	=> null,
				'musterivadefarki'	=> null
			);
			unset($_SESSION['www']['odeme']);
			$bind = array(
				'odeme'			=> json_encode($json),
				'user'			=> $user,
				'sipariskodu'	=> $uye['sipariskodu']
			);
			$this->db->query("update sal_siparisler set asama = 'odeme', surec = 'Ödeme Bekleniyor', odeme = :odeme where (user = :user) && (sipariskodu = :sipariskodu);", $bind);

			/* siparis edilen ürünler ürün adetleri kadar stoktan düşülüyor */
			$hash = $this->db->single("select sepet from sal_sepet where (sepetkodu = :sepetkodu);", array('sepetkodu' => $user));
			$kod = array();
			$idkod = array();
			function singleSms($phoneNumber, $message)
				{			
					
					$message = str_replace(" ", "%20", $message);								
						$url = "http://api.netgsm.com.tr/bulkhttppost.asp?usercode=8508403226&password=Q7ARCL&gsmno=".$phoneNumber."&message=".$message."&msgheader=OYUNALSVRSC&startdate=&stopdate=&dil=TR";
					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL, $url);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					curl_exec($ch);
					curl_close($ch);
				}
				
			foreach(json_decode($hash, true) as $key => $node){
				if($node['bdn'] != ''){
					$buffer = array();
					$beden  = $this->db->single("select beden from cat_urunler where (stokkodu = :stokkodu);", array('stokkodu' => $node['stk']));
					foreach(json_decode($beden, true) as $bedenkodu => $value){
						if(is_array($node['bdn'][$bedenkodu])){
							if($value['stoksayisi'] >= $node['bdn'][$bedenkodu]['adt']){
								$stoksayisi = $value['stoksayisi'] - $node['bdn'][$bedenkodu]['adt'];
							} else {
								$stoksayisi = 0;
								$this->log->set($node['stk'].' Kritik Hata: Giyim kategorisinde bulunan bir üründe sepete stok sayısından fazla ürün eklenmiş.', 'sys');
							};
						} else {
							$stoksayisi = $value['stoksayisi'];
						};
						$buffer[$bedenkodu] = array(
							'barkod'		=> $value['barkod'],
							'bedenkodu'		=> $value['bedenkodu'],
							'stoksayisi'	=> $stoksayisi
						);
					};
					$this->db->query("update cat_urunler set beden = :beden where (stokkodu = :stokkodu);", array('beden' => json_encode($buffer), 'stokkodu' => $node['stk']));
				};
				$this->db->query("update cat_urunler set stoksayisi = (stoksayisi - :adet) where (stokkodu = :stokkodu);", array('stokkodu' => $node['stk'], 'adet' => $node['adt']));
				
				#magaza sms
				$magazaurunu = $this->db->row("select * from cat_urunler where (stokkodu = :stokkodu);",array('stokkodu' => $node['stk']));
				$magazabilgi = $this->db->row("select * from cat_magazalar where (id = :id);",array('id' => $magazaurunu['magaza']));
				
				$telno = $magazabilgi['Telefon'];
				$msg   = 'Merhaba, '.$magazaurunu['urun_TR'].' ürününüz '.$uye['kullaniciadi'].' tarafından Havale/EFT ile satın alındı.';

				echo singleSms($telno,$msg);
				
				#magaza mail gönderme
				$this->mail->sendContentTemplate('magaza-satis-mail-havale', $magazabilgi, $siparis);
				
				#satılan epin sistemden seçiliyor
				$refkod = $this->db->row("select * from cat_urunler where (stokkodu = :stokkodu);",array('stokkodu' => $node['stk']));
				if($refkod['referans_id'] == ''){
					$kodlar = $this->db->query("select * from epinler where (kodid = :kodid) && (durum = '1') LIMIT ".$node['adt'].";",array('kodid' => $node['stk']));
				}else{
					$kodlar = $this->db->query("select * from epinler where (kodid = :kodid) && (durum = '1') LIMIT ".$node['adt'].";",array('kodid' => $refkod['referans_id']));
					$this->db->single("update cat_urunler set stoksayisi = (stoksayisi - :adet) where (id = :id);",array('adet' => $node['adt'], 'id' => $refkod['referans_id']));
				}
				
					foreach($kodlar as $deger){
						$kod[$deger['kod']] = '\''.$deger['kod'].'\'';
						$idkod[$deger['id']] = '\''.$deger['id'].'\'';
					};
			};		
			$kod = implode(',', $kod);
			$idkod = implode(',', $idkod);
			if($kod != NULL and $idkod != NULL){
			#satılan epin stoktan düşülüyor ve bilgilerine müşteri ve sipariş kodu yazılıyor.
			$kullanici = $this->db->single("select kullaniciadi from cus_uyeler where (user = :user);",array('user' => $user));
				$this->db->query("update epinler set durum = '0', alankisi = :alankisi, sipariskodu = :sipariskodu, stamp = :stamp where id in (".$idkod.");", array('alankisi' => $user, 'sipariskodu' => $uye['sipariskodu'], 'stamp' => time()));
				
			#epin satışı sonrası mesaj gönderme
				$date=new DateTime();		
				$mesajid = rand(10000000,$date->getTimestamp());
				$baslik = 'Satın Aldığınız Epin Bilgisi';
				$mesaj = 'Merhaba<br>Satın aldığınız epin detaylarına <a href="/profil/epin">Satın Aldığım Epin Listesi</a> bölümünden ulaşabilirsiniz.<br>Epin ile ilgili bilgi almak istediğinizde satın aldığınız mağazaya mesaj atabilir veya bize <a href="/profil/destekmerkezi">Destek Merkezi</a> üzerinden ulaşabilirsiniz.<br>Bizi tercih ettiğiniz için teşekkür ederiz.<br> Oyunalisveris.com';
				$this->db->query("insert mag_mesaj (id, user, magaza, baslik, icerik, stamp, klasor, durum) values (:id, :user, :magaza, :baslik, :icerik, :stamp, :klasor, :durum);",array('id' => $mesajid, 'user' => 'oyunalisveris', 'magaza' => $kullanici, 'baslik' => $baslik, 'icerik' => $mesaj, 'stamp' => time(), 'klasor' => 'gelen', 'durum' => 'Okunmadı'));	
				
				
				#sipariş tablosuna epin kaydediliyor.
				$this->db->query("update sal_siparisler set epin = :epin where (sipariskodu = :sipariskodu) && (user = :user);",array('epin' =>$kod, 'sipariskodu' => $uye['sipariskodu'], 'user' => $user)); 
				#müşteriye kod otomatik gönderilmez, ödeme onayı beklenir.				
			unset ($kod);	
			}
			/* üyeye ait olan sepet boşaltılıyor */
			if($_SESSION['kuponkodu'] != NULL){
				$this->db->query("update hediye_ceki set durum = :durum, sipariskodu = :sipariskodu, stamp = :stamp where (kod = :kod);",array('durum' => '0', 'sipariskodu' => $uye['sipariskodu'], 'stamp' => time(), 'kod' => $_SESSION['kuponkodu']));
				$_SESSION['kuponkodu'] = '';
			}
			$this->db->query("delete from sal_sepet where (sepetkodu = :sepetkodu);", array('sepetkodu' => $user));

			/* üyeler tablosundan sipariskodu alanı temizleniyor */
			$this->db->query("update cus_uyeler set sipariskodu = '' where (user = :user);", array('user' => $user));

			/* siparis ve sepet bilgilerini taşıyan cookie temizlenip uniqid ataması yapılıyor */
			setcookie('__pcrt', uniqid(), time() + (10 * 365 * 24 * 60 * 60), "/");

			$this->mail->sendContentTemplate('siparis-havale-eft', $uye, $siparis);
			$this->mail->sendOrderEnd($uye['sipariskodu']);

		}
		public function payKapida($post){			
			$user    = $_SESSION['www']['user'];
			$uye     = $this->db->row("select * from cus_uyeler where (user = :user);", array('user' => $user));
			$siparis = $this->db->row("select * from sal_siparisler where (user = :user) && (sipariskodu = :sipariskodu);", array('user' => $user, 'sipariskodu' => $uye['sipariskodu']));
			$aratoplam     = 0;
			$kdvtutari     = 0;
			$kargobedeli   = 0;
			$toplammaliyet = 0;
			$geneltoplam   = 0;
			$k = 0;
			foreach(json_decode($siparis['sepet'], true) as $key => $urun){
				
				$geneltoplam += $this->calc->fiyattan_kurus($urun['satisfiyatikd']) * $urun['adet'];
				$aratoplam   += round($this->calc->kdv_dahil_tutardan_kdv_haric_tutar($this->calc->fiyattan_kurus($urun['satisfiyatikd']), $urun['kdvorani']) * $urun['adet']);
				$kdvtutari   += round($this->calc->kdv_dahil_tutardan_kdv_tutari($this->calc->fiyattan_kurus($urun['satisfiyatikd']), $urun['kdvorani']) * $urun['adet']);
				$desi 		 += $urun['desi'] * $urun['adet'];
				$urunkb = $this->db->single("select kb from cat_urunler where (urlkodu = :urlkodu);",array('urlkodu' => $urun['urlkodu']));
				if($urunkb == '0'){
					$k++;
				}
			};
			$altlimit = $this->db->single("select kargobedava from car_firmalar where yayin = '1'");
			if($geneltoplam < $this->calc->fiyattan_kurus($altlimit) and $k != 0){

				$kapidafiyati = $this->db->single("select kapidaodeme from car_firmalar where yayin = '1'");				
				$kargofiyati = $this->db->row("select * from car_firmalar where yayin = '1'");
				
				if($desi >= $kargofiyati['desi1alt'] and $desi <= $kargofiyati['desi1ust']){
					$kargobedeli  = $this->calc->fiyattan_kurus($kargofiyati['desi1fiyat']);
				}elseif($desi >= $kargofiyati['desi2alt'] and $desi <= $kargofiyati['desi2ust']){
					$kargobedeli   = $this->calc->fiyattan_kurus($kargofiyati['desi2fiyat']);
				}elseif($desi >= $kargofiyati['desi3alt'] and $desi <= $kargofiyati['desi3ust']){
					$kargobedeli   = $this->calc->fiyattan_kurus($kargofiyati['desi3fiyat']);
				}elseif($desi >= $kargofiyati['desi4alt'] and $desi <= $kargofiyati['desi4ust']){
					$kargobedeli   = $this->calc->fiyattan_kurus($kargofiyati['desi4fiyat']);
				}
				else{
					$fazladesi = $desi - $kargofiyati['desi4ust'];
					$artan = $fazladesi * $this->calc->fiyattan_kurus($kargofiyati['artan']);
					$kargobedeli   = $this->calc->fiyattan_kurus($kargofiyati['desi4fiyat']) + $artan;
				}

				$kapidabedeli = $this->calc->fiyattan_kurus($kapidafiyati);
				$toplamkargo = $kargobedeli + $kapidabedeli;
				$geneltoplam += $toplamkargo;
				$aratoplam   += round($this->calc->kdv_dahil_tutardan_kdv_haric_tutar($kargobedeli, 18));
				$kdvtutari   += round($this->calc->kdv_dahil_tutardan_kdv_tutari($kargobedeli, 18));
			};
			if($geneltoplam > $this->calc->fiyattan_kurus($altlimit)){
				$kargofiyati = $this->db->single("select hizmetbedeli from car_firmalar where yayin = '1'");
				$kapidafiyati = $this->db->single("select kapidaodeme from car_firmalar where yayin = '1'");
				$kargobedeli  = $this->calc->fiyattan_kurus($kargofiyati);
				$kapidabedeli = $this->calc->fiyattan_kurus($kapidafiyati);
				$toplamkargo = $kapidabedeli;
				$geneltoplam += $toplamkargo;
				$aratoplam   += round($this->calc->kdv_dahil_tutardan_kdv_haric_tutar($kargobedeli, 18));
				$kdvtutari   += round($this->calc->kdv_dahil_tutardan_kdv_tutari($kargobedeli, 18));
			};
			$geneltoplam = $this->calc->kurusdan_fiyat($geneltoplam);
			$aratoplam   = $this->calc->kurusdan_fiyat($aratoplam);
			$kdvtutari   = $this->calc->kurusdan_fiyat($kdvtutari);
			$toplamkargo = $this->calc->kurusdan_fiyat($toplamkargo);
			$json = array(
				'aratoplam'			=> $aratoplam,
				'kdvtutari'			=> $kdvtutari,
				'kargobedeli'		=> $toplamkargo,
				'toplammaliyet'		=> $toplammaliyet,
				'geneltoplam'		=> $geneltoplam,
				'odemeturu'			=> 'Kapıda Ödeme',
				'havalebankasi'		=> null,	
				'taksitsayisi'		=> null,
				'tekcekimindirimi'	=> null,
				'kartbankasi'		=> null,
				'sanalposmodulu'	=> null,
				'bankavadefarki'	=> null,
				'musterivadefarki'	=> null
			);
			unset($_SESSION['www']['odeme']);
			$bind = array(
				'odeme'			=> json_encode($json),
				'user'			=> $user,
				'sipariskodu'	=> $uye['sipariskodu']
			);
			$this->db->query("update sal_siparisler set asama = 'odeme', surec = 'Kapıda Ödeme', odeme = :odeme where (user = :user) && (sipariskodu = :sipariskodu);", $bind);
			/* siparis edilen ürünler ürün adetleri kadar stoktan düşülüyor */
			$hash = $this->db->single("select sepet from sal_sepet where (sepetkodu = :sepetkodu);", array('sepetkodu' => $user));
			$kod = array();
			foreach(json_decode($hash, true) as $key => $node){
				if($node['bdn'] != ''){
					$buffer = array();
					$beden  = $this->db->single("select beden from cat_urunler where (stokkodu = :stokkodu);", array('stokkodu' => $node['stk']));
					foreach(json_decode($beden, true) as $bedenkodu => $value){
						if(is_array($node['bdn'][$bedenkodu])){
							if($value['stoksayisi'] >= $node['bdn'][$bedenkodu]['adt']){
								$stoksayisi = $value['stoksayisi'] - $node['bdn'][$bedenkodu]['adt'];
							} else {
								$stoksayisi = 0;
								$this->log->set($node['stk'].' Kritik Hata: Giyim kategorisinde bulunan bir üründe sepete stok sayısından fazla ürün eklenmiş.', 'sys');
							};
						} else {
							$stoksayisi = $value['stoksayisi'];
						};
						$buffer[$bedenkodu] = array(
							'barkod'		=> $value['barkod'],
							'bedenkodu'		=> $value['bedenkodu'],
							'stoksayisi'	=> $stoksayisi
						);
					};
					$this->db->query("update cat_urunler set beden = :beden where (stokkodu = :stokkodu);", array('beden' => json_encode($buffer), 'stokkodu' => $node['stk']));
				};
				$this->db->query("update cat_urunler set stoksayisi = (stoksayisi - :adet) where (stokkodu = :stokkodu);", array('stokkodu' => $node['stk'], 'adet' => $node['adt']));
				#satılan epin sistemden seçiliyor
				
				$kodlar = $this->db->query("select * from epinler where (kodid = :kodid) && (durum = '1') LIMIT ".$node['adt'].";",array('kodid' => $node['stk']));
				
					foreach($kodlar as $deger){
						$kod[$deger['kod']] = '\''.$deger['kod'].'\'';
					};
			};
			#epinler diziye yükleniyor
			$kod = implode(',', $kod);
			#satılan epin stoktan düşülüyor ve bilgilerine müşteri, sipariş kodu ve alış tarihi yazılıyor.
				$this->db->query("update epinler set durum = '0', alankisi = :alankisi, sipariskodu = :sipariskodu, stamp = :stamp where kod in (".$kod.");", array('alankisi' => $user, 'sipariskodu' => $uye['sipariskodu'], 'stamp' => time()));
				#sipariş tablosuna epinler kaydediliyor.
				$this->db->query("update sal_siparisler set epin = :epin where (sipariskodu = :sipariskodu) && (user = :user);",array('epin' =>$kod, 'sipariskodu' => $uye['sipariskodu'], 'user' => $user)); 
				#havale/eft olduğu için müşteriye kod otomatik gönderilmez, ödeme onayı beklenir.
				
			unset ($kod);	

			/* üyeye ait olan sepet boşaltılıyor */
			$this->db->query("delete from sal_sepet where (sepetkodu = :sepetkodu);", array('sepetkodu' => $user));
			
			/* üyeler tablosundan sipariskodu alanı temizleniyor */
			$this->db->query("update cus_uyeler set sipariskodu = '' where (user = :user);", array('user' => $user));

			/* siparis ve sepet bilgilerini taşıyan cookie temizlenip uniqid ataması yapılıyor */
			setcookie('__pcrt', uniqid(), time() + (10 * 365 * 24 * 60 * 60), "/");			
		}
		public function iyzipay($post){
			$user    = $_SESSION['www']['user'];
			$uye     = $this->db->row("select * from cus_uyeler where (user = :user);", array('user' => $user));
			$siparis = $this->db->row("select * from sal_siparisler where (user = :user) && (sipariskodu = :sipariskodu);", array('user' => $user, 'sipariskodu' => $uye['sipariskodu']));

			$aratoplam     = 0;
			$kdvtutari     = 0;
			$kargobedeli   = 0;
			$toplammaliyet = 0;
			$geneltoplam   = 0;

			foreach(json_decode($siparis['sepet'], true) as $key => $urun){
				$geneltoplam += $this->calc->fiyattan_kurus($urun['satisfiyatikd']) * $urun['adet'];
				$aratoplam   += round($this->calc->kdv_dahil_tutardan_kdv_haric_tutar($this->calc->fiyattan_kurus($urun['satisfiyatikd']), $urun['kdvorani']) * $urun['adet']);
				$kdvtutari   += round($this->calc->kdv_dahil_tutardan_kdv_tutari($this->calc->fiyattan_kurus($urun['satisfiyatikd']), $urun['kdvorani']) * $urun['adet']);
				$desi 		 += $urun['desi'] * $urun['adet'];
			};

			$altlimit = $this->db->single("select kargobedava from car_firmalar where yayin = '1'");
			if($geneltoplam < $this->calc->fiyattan_kurus($altlimit)){
				
				$kargofiyati = $this->db->row("select * from car_firmalar where yayin = '1'");
				
				if($desi >= $kargofiyati['desi1alt'] and $desi <= $kargofiyati['desi1ust']){
					$kargobedeli  = $this->calc->fiyattan_kurus($kargofiyati['desi1fiyat']);
				}elseif($desi >= $kargofiyati['desi2alt'] and $desi <= $kargofiyati['desi2ust']){
					$kargobedeli   = $this->calc->fiyattan_kurus($kargofiyati['desi2fiyat']);
				}elseif($desi >= $kargofiyati['desi3alt'] and $desi <= $kargofiyati['desi3ust']){
					$kargobedeli   = $this->calc->fiyattan_kurus($kargofiyati['desi3fiyat']);
				}elseif($desi >= $kargofiyati['desi4alt'] and $desi <= $kargofiyati['desi4ust']){
					$kargobedeli   = $this->calc->fiyattan_kurus($kargofiyati['desi4fiyat']);
				}
				else{
					$fazladesi = $desi - $kargofiyati['desi4ust'];
					$artan = $fazladesi * $this->calc->fiyattan_kurus($kargofiyati['artan']);
					$kargobedeli   = $this->calc->fiyattan_kurus($kargofiyati['desi4fiyat']) + $artan;
				}
				$geneltoplam += $kargobedeli;
				$aratoplam   += round($this->calc->kdv_dahil_tutardan_kdv_haric_tutar($kargobedeli, 18));
				$kdvtutari   += round($this->calc->kdv_dahil_tutardan_kdv_tutari($kargobedeli, 18));
			};
			$puan = $geneltoplam / 100;
			$geneltoplam = $this->calc->kurusdan_fiyat($geneltoplam);
			$aratoplam   = $this->calc->kurusdan_fiyat($aratoplam);
			$kdvtutari   = $this->calc->kurusdan_fiyat($kdvtutari);
			$kargobedeli = $this->calc->kurusdan_fiyat($kargobedeli);

			$json = array(
				'aratoplam'			=> $aratoplam,
				'kdvtutari'			=> $kdvtutari,
				'kargobedeli'		=> $kargobedeli,
				'toplammaliyet'		=> $toplammaliyet,
				'geneltoplam'		=> $geneltoplam,
				'puan'				=> $puan,
				'odemeturu'			=> 'Kartla Ödeme',
				'havalebankasi'		=> null,	
				'taksitsayisi'		=> null,
				'tekcekimindirimi'	=> null,
				'kartbankasi'		=> null,
				'sanalposmodulu'	=> null,
				'bankavadefarki'	=> null,
				'musterivadefarki'	=> null
			);
			unset($_SESSION['www']['odeme']);
			$bind = array(
				'odeme'			=> json_encode($json),
				'user'			=> $user,
				'sipariskodu'	=> $uye['sipariskodu']
			);
			$eskipuan = $this->db->single("select puan from cus_uyeler where (user = :user);",array('user' => $user));
			$puans = $eskipuan + $puan;
			$this->db->query("update sal_siparisler set asama = 'odeme', surec = 'Onaylandı', odeme = :odeme where (user = :user) && (sipariskodu = :sipariskodu);", $bind);
			$this->db->query("update cus_uyeler set puan = :puan where (user = :user);",array('puan' => $puans, 'user' => $user));
			/* siparis edilen ürünler ürün adetleri kadar stoktan düşülüyor */
			$hash = $this->db->single("select sepet from sal_sepet where (sepetkodu = :sepetkodu);", array('sepetkodu' => $user));
			$kod = array();
			$idkod = array();
			function singleSms($phoneNumber, $message)
				{								
					$message = str_replace(" ", "%20", $message);								
						$url = "http://api.netgsm.com.tr/bulkhttppost.asp?usercode=8508403226&password=Q7ARCL&gsmno=".$phoneNumber."&message=".$message."&msgheader=OYUNALSVRSC&startdate=&stopdate=&dil=TR";
					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL, $url);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					curl_exec($ch);
					curl_close($ch);
				}
			foreach(json_decode($hash, true) as $key => $node){
				if($node['bdn'] != ''){
					$buffer = array();
					$beden  = $this->db->single("select beden from cat_urunler where (stokkodu = :stokkodu);", array('stokkodu' => $node['stk']));
					foreach(json_decode($beden, true) as $bedenkodu => $value){
						if(is_array($node['bdn'][$bedenkodu])){
							if($value['stoksayisi'] >= $node['bdn'][$bedenkodu]['adt']){
								$stoksayisi = $value['stoksayisi'] - $node['bdn'][$bedenkodu]['adt'];
							} else {
								$stoksayisi = 0;
								$this->log->set($node['stk'].' Kritik Hata: Giyim kategorisinde bulunan bir üründe sepete stok sayısından fazla ürün eklenmiş.', 'sys');
							};
						} else {
							$stoksayisi = $value['stoksayisi'];
						};
						$buffer[$bedenkodu] = array(
							'barkod'		=> $value['barkod'],
							'bedenkodu'		=> $value['bedenkodu'],
							'stoksayisi'	=> $stoksayisi
						);
					};
					$this->db->query("update cat_urunler set beden = :beden where (stokkodu = :stokkodu);", array('beden' => json_encode($buffer), 'stokkodu' => $node['stk']));
				};
				$this->db->query("update cat_urunler set stoksayisi = (stoksayisi - :adet) where (stokkodu = :stokkodu);", array('stokkodu' => $node['stk'], 'adet' => $node['adt']));
				
				#magaza sms başlangıç //
				$magazaurunu = $this->db->row("select * from cat_urunler where (stokkodu = :stokkodu);",array('stokkodu' => $node['stk']));
				$magazabilgi = $this->db->row("select * from cat_magazalar where (id = :id);",array('id' => $magazaurunu['magaza']));
				
				$telno = $magazabilgi['Telefon'];
				$msg = 'Merhaba, '.$magazaurunu['urun_TR'].' ürününüz '.$uye['kullaniciadi'].' tarafından satın alındı.';
				
				echo singleSms($telno,$msg);
				#magaza sms bitiş //
				
				#magaza mail gönderme
				$this->mail->sendContentTemplate('magaza-satis-mail', $magazabilgi, $siparis);
					
				#satılan epin sistemden seçiliyor
				
				$kodlar = $this->db->query("select * from epinler where (kodid = :kodid) && (durum = '1') LIMIT ".$node['adt'].";",array('kodid' => $node['stk']));
				
					foreach($kodlar as $deger){
						$kod[$deger['kod']] = '\''.$deger['kod'].'\'';
						$idkod[$deger['id']] = '\''.$deger['id'].'\'';
					};
			};		
			$kod = implode(',', $kod);
			$idkod = implode(',', $idkod);
			if($kod != NULL and $idkod != NULL){
			#satılan epin stoktan düşülüyor ve bilgilerine müşteri ve sipariş kodu yazılıyor.
			$kullanici = $this->db->single("select kullaniciadi from cus_uyeler where (user = :user);",array('user' => $user));
				$this->db->query("update epinler set durum = '0', alankisi = :alankisi, sipariskodu = :sipariskodu, stamp = :stamp where id in (".$idkod.");", array('alankisi' => $user, 'sipariskodu' => $uye['sipariskodu'], 'stamp' => time()));
			
			#epin satışı sonrası mesaj gönderme
				$date=new DateTime();		
				$mesajid = rand(10000000,$date->getTimestamp());
				$baslik = 'Satın Aldığınız Epin Bilgisi';
				$mesaj = 'Merhaba<br>Satın aldığınız epin detaylarına <a href="/profil/epin">Satın Aldığım Epin Listesi</a> bölümünden ulaşabilirsiniz.<br>Epin ile ilgili bilgi almak istediğinizde satın aldığınız mağazaya mesaj atabilir veya bize <a href="/profil/destekmerkezi">Destek Merkezi</a> üzerinden ulaşabilirsiniz.<br>Bizi tercih ettiğiniz için teşekkür ederiz.<br> Oyunalisveris.com';
				$this->db->query("insert mag_mesaj (id, user, magaza, baslik, icerik, stamp, klasor, durum) values (:id, :user, :magaza, :baslik, :icerik, :stamp, :klasor, :durum);",array('id' => $mesajid, 'user' => 'oyunalisveris', 'magaza' => $kullanici, 'baslik' => $baslik, 'icerik' => $mesaj, 'stamp' => time(), 'klasor' => 'gelen', 'durum' => 'Okunmadı'));
				
				#sipariş tablosuna epin kaydediliyor.
				$this->db->query("update sal_siparisler set epin = :epin where (sipariskodu = :sipariskodu) && (user = :user);",array('epin' =>$kod, 'sipariskodu' => $uye['sipariskodu'], 'user' => $user)); 
				#müşteriye kod otomatik gönderilir.				
			unset ($kod);
			}
			/* üyeye ait olan sepet boşaltılıyor */
			$this->db->query("delete from sal_sepet where (sepetkodu = :sepetkodu);", array('sepetkodu' => $user));

			/* üyeler tablosundan sipariskodu alanı temizleniyor */
			$this->db->query("update cus_uyeler set sipariskodu = '' where (user = :user);", array('user' => $user));

			/* siparis ve sepet bilgilerini taşıyan cookie temizlenip uniqid ataması yapılıyor */
			setcookie('__pcrt', uniqid(), time() + (10 * 365 * 24 * 60 * 60), "/");

			$this->mail->sendContentTemplate('siparis-kredi-karti', $uye, $siparis);
			$this->mail->sendOrderEnd($uye['sipariskodu']);
		}
		public function payBakiye($post){
			$user    = $_SESSION['www']['user'];
			$uye     = $this->db->row("select * from cus_uyeler where (user = :user);", array('user' => $user));
			$siparis = $this->db->row("select * from sal_siparisler where (user = :user) && (sipariskodu = :sipariskodu);", array('user' => $user, 'sipariskodu' => $uye['sipariskodu']));

			$aratoplam     = 0;
			$kdvtutari     = 0;
			$kargobedeli   = 0;
			$toplammaliyet = 0;
			$geneltoplam   = 0;
			$k = 0;
			foreach(json_decode($siparis['sepet'], true) as $key => $urun){
				$geneltoplam += $this->calc->fiyattan_kurus($urun['satisfiyatikd']) * $urun['adet'];
				$aratoplam   += round($this->calc->kdv_dahil_tutardan_kdv_haric_tutar($this->calc->fiyattan_kurus($urun['satisfiyatikd']), $urun['kdvorani']) * $urun['adet']);
				$kdvtutari   += round($this->calc->kdv_dahil_tutardan_kdv_tutari($this->calc->fiyattan_kurus($urun['satisfiyatikd']), $urun['kdvorani']) * $urun['adet']);
				$desi 		 += $urun['desi'] * $urun['adet'];
				$urunkb = $this->db->single("select kb from cat_urunler where (urlkodu = :urlkodu);",array('urlkodu' => $urun['urlkodu']));
				$urunmagaza = $this->db->row("select * from cat_magazalar where (id = :id);",array('id' => $urun['magaza']));
				$this->db->query("insert satisbilgi (magaza, sipariskodu, siparisid, urun, adet, durum, stamp) values (:magaza, :sipariskodu, :siparisid, :urun, :adet, :durum, :stamp);",array('magaza' => $urunmagaza['magazakodu'], 'sipariskodu' => $siparis['sipariskodu'], 'siparisid' => $siparis['id'], 'urun' => $urun['urun_TR'], 'adet' => $urun['adet'], 'durum' => '1', 'stamp' => time()));
				if($urunkb == '0'){
					$k++;
				}
			};
			if($_SESSION['kuponkodu'] != NULL){
				$kupontutar = $this->db->single("select tutar from hediye_ceki where (user = :user) && (kod = :kod);",array('user' => $_SESSION['www']['user'], 'kod' => $_SESSION['kuponkodu']));
				$kupontutarr = $kupontutar * 100;
				$geneltoplam -= $kupontutarr; 
			}
			$altlimit = $this->db->single("select kargobedava from car_firmalar where yayin = '1'");			
			if($geneltoplam < $this->calc->fiyattan_kurus($altlimit) and $k != 0){
				$kargofiyati = $this->db->row("select * from car_firmalar where yayin = '1'");
				
				if($desi >= $kargofiyati['desi1alt'] and $desi <= $kargofiyati['desi1ust']){
					$kargobedeli  = $this->calc->fiyattan_kurus($kargofiyati['desi1fiyat']);
				}elseif($desi >= $kargofiyati['desi2alt'] and $desi <= $kargofiyati['desi2ust']){
					$kargobedeli   = $this->calc->fiyattan_kurus($kargofiyati['desi2fiyat']);
				}elseif($desi >= $kargofiyati['desi3alt'] and $desi <= $kargofiyati['desi3ust']){
					$kargobedeli   = $this->calc->fiyattan_kurus($kargofiyati['desi3fiyat']);
				}elseif($desi >= $kargofiyati['desi4alt'] and $desi <= $kargofiyati['desi4ust']){
					$kargobedeli   = $this->calc->fiyattan_kurus($kargofiyati['desi4fiyat']);
				}
				else{
					$fazladesi = $desi - $kargofiyati['desi4ust'];
					$artan = $fazladesi * $this->calc->fiyattan_kurus($kargofiyati['artan']);
					$kargobedeli   = $this->calc->fiyattan_kurus($kargofiyati['desi4fiyat']) + $artan;
				}
				$geneltoplam += $kargobedeli;
				$aratoplam   += round($this->calc->kdv_dahil_tutardan_kdv_haric_tutar($kargobedeli, 18));
				$kdvtutari   += round($this->calc->kdv_dahil_tutardan_kdv_tutari($kargobedeli, 18));
			};
			$puan = $geneltoplam / 100;
			$geneltoplam = $this->calc->kurusdan_fiyat($geneltoplam);
			$aratoplam   = $this->calc->kurusdan_fiyat($aratoplam);
			$kdvtutari   = $this->calc->kurusdan_fiyat($kdvtutari);
			$kargobedeli = $this->calc->kurusdan_fiyat($kargobedeli);
			if($_SESSION['kuponkodu'] != NULL){
				$kupontutar  = $this->calc->kurusdan_fiyat($kupontutarr);
				$kuponkodu   = $_SESSION['kuponkodu'];
			}else{
				$kupontutar  = null;
				$kuponkodu   = null;
			}
			$bakiyebilgi = $this->db->row("select * from mag_bakiye where (magaza = :magaza);",array('magaza' => $_SESSION['www']['magaza']));
			$siparistutari = $this->calc->fiyattan_kurus($geneltoplam) / 100;
			$mobilbakiye = $bakiyebilgi['mobilbakiye'] - $siparistutari;
			if($mobilbakiye < 0){
				$cekilebilirbakiye = $bakiyebilgi['cekilebilirbakiye'] + $mobilbakiye;
				$mobilbakiye = '0';
			}
			$kalanbakiye = $bakiyebilgi['kalanbakiye'] - $siparistutari;
			$this->db->query("update mag_bakiye set cekilebilirbakiye = :cekilebilirbakiye, kalanbakiye = :kalanbakiye, mobilbakiye = :mobilbakiye where (magaza = :magaza);",array('cekilebilirbakiye' => $cekilebilirbakiye, 'kalanbakiye' => $kalanbakiye, 'mobilbakiye' => $mobilbakiye, 'magaza' => $_SESSION['www']['magaza']));
			$json = array(
				'aratoplam'			=> $aratoplam,
				'kdvtutari'			=> $kdvtutari,
				'kargobedeli'		=> $kargobedeli,
				'toplammaliyet'		=> $toplammaliyet,
				'geneltoplam'		=> $geneltoplam,
				'kuponkodu'			=> $kuponkodu,
				'kupontutari'		=> $kupontutar,
				'puan'				=> $puan,
				'odemeturu'			=> 'Bakiye ile Ödeme',
				'havalebankasi'		=> null,	
				'taksitsayisi'		=> null,
				'tekcekimindirimi'	=> null,
				'kartbankasi'		=> null,
				'sanalposmodulu'	=> null,
				'bankavadefarki'	=> null,
				'musterivadefarki'	=> null
			);
			unset($_SESSION['www']['odeme']);
			$bind = array(
				'odeme'			=> json_encode($json),
				'user'			=> $user,
				'sipariskodu'	=> $uye['sipariskodu']
			);
			$eskipuan = $this->db->single("select puan from cus_uyeler where (user = :user);",array('user' => $user));
			$puans = $eskipuan + $puan;
			$this->db->query("update sal_siparisler set asama = 'odeme', surec = 'Onaylandı', odeme = :odeme where (user = :user) && (sipariskodu = :sipariskodu);", $bind);
			$this->db->query("update cus_uyeler set puan = :puan where (user = :user);",array('puan' => $puans, 'user' => $user));
			/* siparis edilen ürünler ürün adetleri kadar stoktan düşülüyor */
			$hash = $this->db->single("select sepet from sal_sepet where (sepetkodu = :sepetkodu);", array('sepetkodu' => $user));
			$kod = array();		
			$idkod = array();
			function singleSms($phoneNumber, $message)
				{								
					$message = str_replace(" ", "%20", $message);								
						$url = "http://api.netgsm.com.tr/bulkhttppost.asp?usercode=8508403226&password=Q7ARCL&gsmno=".$phoneNumber."&message=".$message."&msgheader=OYUNALSVRSC&startdate=&stopdate=&dil=TR";
					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL, $url);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					curl_exec($ch);
					curl_close($ch);
				}				
			foreach(json_decode($hash, true) as $key => $node){
				if($node['bdn'] != ''){
					$buffer = array();
					$beden  = $this->db->single("select beden from cat_urunler where (stokkodu = :stokkodu);", array('stokkodu' => $node['stk']));
					foreach(json_decode($beden, true) as $bedenkodu => $value){
						if(is_array($node['bdn'][$bedenkodu])){
							if($value['stoksayisi'] >= $node['bdn'][$bedenkodu]['adt']){
								$stoksayisi = $value['stoksayisi'] - $node['bdn'][$bedenkodu]['adt'];
							} else {
								$stoksayisi = 0;
								$this->log->set($node['stk'].' Kritik Hata: Giyim kategorisinde bulunan bir üründe sepete stok sayısından fazla ürün eklenmiş.', 'sys');
							};
						} else {
							$stoksayisi = $value['stoksayisi'];
						};
						$buffer[$bedenkodu] = array(
							'barkod'		=> $value['barkod'],
							'bedenkodu'		=> $value['bedenkodu'],
							'stoksayisi'	=> $stoksayisi
						);
					};
					$this->db->query("update cat_urunler set beden = :beden where (stokkodu = :stokkodu);", array('beden' => json_encode($buffer), 'stokkodu' => $node['stk']));
				};
				$this->db->query("update cat_urunler set stoksayisi = (stoksayisi - :adet) where (stokkodu = :stokkodu);", array('stokkodu' => $node['stk'], 'adet' => $node['adt']));
				
				#magaza sms
				$magazaurunu = $this->db->row("select * from cat_urunler where (stokkodu = :stokkodu);",array('stokkodu' => $node['stk']));
				$magazabilgi = $this->db->row("select * from cat_magazalar where (id = :id);",array('id' => $magazaurunu['magaza']));
				
				$telno = $magazabilgi['Telefon'];
				$msg   = 'Merhaba, '.$magazaurunu['urun_TR'].' ürününüz '.$uye['kullaniciadi'].' tarafından satın alındı.';
				
				echo singleSms($telno,$msg);				 
				#magaza mail gönderme
				$this->mail->sendContentTemplate('magaza-satis-mail', $magazabilgi, $siparis);

				#satılan epin sistemden seçiliyor
				$refkod = $this->db->row("select * from cat_urunler where (stokkodu = :stokkodu);",array('stokkodu' => $node['stk']));
				if($refkod['referans_id'] == ''){
					$kodlar = $this->db->query("select * from epinler where (kodid = :kodid) && (durum = '1') LIMIT ".$node['adt'].";",array('kodid' => $node['stk']));
				}else{
					$kodlar = $this->db->query("select * from epinler where (kodid = :kodid) && (durum = '1') LIMIT ".$node['adt'].";",array('kodid' => $refkod['referans_id']));
					$this->db->single("update cat_urunler set stoksayisi = (stoksayisi - :adet) where (id = :id);",array('adet' => $node['adt'], 'id' => $refkod['referans_id']));
				}
				
				
					foreach($kodlar as $deger){
						$kod[$deger['kod']] = '\''.$deger['kod'].'\'';
						$idkod[$deger['id']] = '\''.$deger['id'].'\'';
					};
			};		
			$kod = implode(',', $kod);
			$idkod = implode(',', $idkod);
			if($kod != NULL and $idkod != NULL){
			#satılan epin stoktan düşülüyor ve bilgilerine müşteri ve sipariş kodu yazılıyor.
			$kullanici = $this->db->single("select kullaniciadi from cus_uyeler where (user = :user);",array('user' => $user));
				$this->db->query("update epinler set durum = '0', alankisi = :alankisi, sipariskodu = :sipariskodu, stamp = :stamp where id in (".$idkod.");", array('alankisi' => $user, 'sipariskodu' => $uye['sipariskodu'], 'stamp' => time()));
				
			#epin satışı sonrası mesaj gönderme
				$date=new DateTime();		
				$mesajid = rand(10000000,$date->getTimestamp());
				$baslik = 'Satın Aldığınız Epin Bilgisi';
				$mesaj = 'Merhaba<br>Satın aldığınız epin detaylarına <a href="/profil/epin">Satın Aldığım Epin Listesi</a> bölümünden ulaşabilirsiniz.<br>Epin ile ilgili bilgi almak istediğinizde satın aldığınız mağazaya mesaj atabilir veya bize <a href="/profil/destekmerkezi">Destek Merkezi</a> üzerinden ulaşabilirsiniz.<br>Bizi tercih ettiğiniz için teşekkür ederiz.<br> Oyunalisveris.com';
				$this->db->query("insert mag_mesaj (id, user, magaza, baslik, icerik, stamp, klasor, durum, yayin) values (:id, :user, :magaza, :baslik, :icerik, :stamp, :klasor, :durum, :yayin);",array('id' => $mesajid, 'user' => 'oyunalisveris', 'magaza' => $kullanici, 'baslik' => $baslik, 'icerik' => $mesaj, 'stamp' => time(), 'klasor' => 'gelen', 'durum' => 'Okunmadı', 'yayin' => '1'));	
				
				#sipariş tablosuna epin kaydediliyor.
				$kodd = array();	
				$kodlarr = $this->db->query("select * from epinler where id in (".$idkod.")");
				foreach($kodlarr as $degerr){
						$kodd[$degerr['kod']] = '\''.$degerr['kod'].'\'';
					};
				$kodd = implode(',', $kodd);
				$this->db->query("update sal_siparisler set epin = :epin where (sipariskodu = :sipariskodu) && (user = :user);",array('epin' => $kodd, 'sipariskodu' => $uye['sipariskodu'], 'user' => $user)); 			
			unset ($kod);
			unset ($kodd);
			}
			/* üyeye ait olan sepet boşaltılıyor */
			if($_SESSION['kuponkodu'] != NULL){
				$this->db->query("update hediye_ceki set durum = :durum, sipariskodu = :sipariskodu, stamp = :stamp where (kod = :kod);",array('durum' => '0', 'sipariskodu' => $uye['sipariskodu'], 'stamp' => time(), 'kod' => $_SESSION['kuponkodu']));
				$_SESSION['kuponkodu'] = '';
			}
			$this->db->query("delete from sal_sepet where (sepetkodu = :sepetkodu);", array('sepetkodu' => $user));

			/* üyeler tablosundan sipariskodu alanı temizleniyor */
			$this->db->query("update cus_uyeler set sipariskodu = '' where (user = :user);", array('user' => $user));

			/* siparis ve sepet bilgilerini taşıyan cookie temizlenip uniqid ataması yapılıyor */
			setcookie('__pcrt', uniqid(), time() + (10 * 365 * 24 * 60 * 60), "/");

			#$this->mail->sendContentTemplate('siparis-havale-eft', $uye, $siparis);
			$this->mail->sendOrderEnd($uye['sipariskodu']);
		}
	};
?>