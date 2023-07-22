<?php
	class mail extends core{

		public $config;
		public $mailer;
		public $db;
		public $seo;
		public $calc;
		public $bootstrap;

		private $araToplam;
		private $kdvTutari;
		private $kargoBedeli;
		private $genelToplam;
		
		public function __construct(){
			$this->araToplam   = 0;
			$this->kdvTutari   = 0;
			$this->kargoBedeli = 0;
			$this->genelToplam = 0;
		}

		public function __destruct(){
			unset($this->araToplam);
			unset($this->kdvTutari);
			unset($this->kargoBedeli);
			unset($this->genelToplam);
		}

		private function engine($params){
			$this->mailer->isSMTP();
			$this->mailer->Host 		= $this->config['mail']['host'];
			$this->mailer->SMTPAuth 	= true;
			$this->mailer->Username 	= $this->config['mail']['account'];
			$this->mailer->Password 	= $this->config['mail']['pass'];
			$this->mailer->SMTPSecure 	= 'tls';
			$this->mailer->Port 		= '587';
			$this->mailer->From 		= $params['From'];
			$this->mailer->FromName		= $params['FromName'];
			$this->mailer->AddReplyTo($params['Reply'], $params['ReplyName']);
			$this->mailer->addAddress($params['To'], $params['ToName']);
			$this->mailer->isHTML(true);
			$this->mailer->Subject 		= $params['Subject'];
			$this->mailer->Body 		= $params['Body'];
			$this->mailer->CharSet 		= 'UTF-8';
			if($this->mailer->send()){
				$this->mailer->ClearAllRecipients();
				return true;
			} else {
				return false;
			};
		}

		/**/

			private function contentOrderSepet($sepet){
				$sepet  = json_decode($sepet, true);
				$buffer = '<table cellpadding="5" width="100%">';
					$buffer .= '<thead>';
						$buffer .= '<tr>';
							$buffer .= '<th style="background:#000000; color:#FFFFFF;">Görsel</th>';
							$buffer .= '<th style="background:#000000; color:#FFFFFF;">Alış</th>';
							$buffer .= '<th style="background:#000000; color:#FFFFFF;">Adet</th>';
							$buffer .= '<th style="background:#000000; color:#FFFFFF;">KDV</th>';
							$buffer .= '<th style="background:#000000; color:#FFFFFF;">Fiyat</th>';
							$buffer .= '<th style="background:#000000; color:#FFFFFF;">Toplam</th>';
						$buffer .= '</tr>';
					$buffer .= '</thead>';
					$buffer .= '<tbody>';
						foreach($sepet as $stokkodu => $node){
							$gorsel = $this->db->single("select gorsel from cat_urunler where (stokkodu = :stokkodu);", array('stokkodu' => $stokkodu));
							$gorsel = json_decode($gorsel, true)[0];
							if($node['beden'] != ''){
								foreach($node['beden'] as $beden){
									$buffer .= '<tr>';
										$buffer .= '<td rowspan="2" align="center" width="50" style="border-bottom:solid 1px #CCC;">';
											$buffer .= '<img src="'.$this->config['global']['CDN'].'files/product/'.$gorsel.'" width="50" />';
										$buffer .= '</td>';
										$buffer .= '<td colspan="5">';
											$buffer .= '<a href="'.$this->config['global']['domain'].$node['urlkodu'].'" style="text-decoration:none; font-size:14px;">';
												$buffer .= $node['urun_TR'].' -> '.$this->db->single("select beden_TR from cat_bedenler where (id = :id);", array('id' => $beden['kod'])).'</small> ';
											$buffer .= '</a>';
										$buffer .= '</td>';
									$buffer .= '</tr>';
									$buffer .= '<tr>';
										$buffer .= '<td align="center" style="border-bottom:solid 1px #CCC;">'.$this->calc->tutar_format($node['alisfiyati']).' TL</td>';
										$buffer .= '<td align="center" style="border-bottom:solid 1px #CCC;">'.$beden['adt'].'</td>';
										$buffer .= '<td align="center" style="border-bottom:solid 1px #CCC;">%'.$node['kdvorani'].'</td>';
										$buffer .= '<td align="center" style="border-bottom:solid 1px #CCC;">'.$this->calc->tutar_format($node['satisfiyatikd']).' TL</td>';
										$buffer .= '<td align="center" style="border-bottom:solid 1px #CCC;">'.$this->calc->tutar_format($this->calc->kurusdan_fiyat($this->calc->fiyattan_kurus($node['satisfiyatikd']) * $beden['adt'])).' TL</td>';
									$buffer .= '</tr>';
								};
							} else {
								$buffer .= '<tr>';
									$buffer .= '<td rowspan="2" align="center" width="50" style="border-bottom:solid 1px #CCC;">';
										$buffer .= '<img src="'.$this->config['global']['CDN'].'files/product/'.$gorsel.'" width="50" />';
									$buffer .= '</td>';
									$buffer .= '<td colspan="5">';
										$buffer .= '<a href="'.$this->config['global']['domain'].$node['urlkodu'].'" style="text-decoration:none; font-size:14px;">';
											$buffer .= $node['urun_TR'];
										$buffer .= '</a>';
									$buffer .= '</td>';
								$buffer .= '</tr>';
								$buffer .= '<tr>';
									$buffer .= '<td align="center" style="border-bottom:solid 1px #CCC;">'.$this->calc->tutar_format($node['alisfiyati']).' TL</td>';
									$buffer .= '<td align="center" style="border-bottom:solid 1px #CCC;">'.$node['adet'].'</td>';
									$buffer .= '<td align="center" style="border-bottom:solid 1px #CCC;">%'.$node['kdvorani'].'</td>';
									$buffer .= '<td align="center" style="border-bottom:solid 1px #CCC;">'.$this->calc->tutar_format($node['satisfiyatikd']).' TL</td>';
									$buffer .= '<td align="center" style="border-bottom:solid 1px #CCC;">'.$this->calc->tutar_format($this->calc->kurusdan_fiyat($this->calc->fiyattan_kurus($node['satisfiyatikd']) * $node['adet'])).' TL</td>';
								$buffer .= '</tr>';
							};
							$this->genelToplam += $this->calc->fiyattan_kurus($node['satisfiyatikd']) * $node['adet'];
							$this->araToplam   += round($this->calc->kdv_dahil_tutardan_kdv_haric_tutar($this->calc->fiyattan_kurus($node['satisfiyatikd']), $node['kdvorani']) * $node['adet']);
							$this->kdvTutari   += round($this->calc->kdv_dahil_tutardan_kdv_tutari($this->calc->fiyattan_kurus($node['satisfiyatikd']), $node['kdvorani']) * $node['adet']);
						};

						if($this->genelToplam < 10000){
							
							$stamp = '1477381622';
							if(time() > $stamp){
							$this->kargoBedeli  = 0;	
							}else{$this->kargoBedeli  = 0;};
							
							
							
							$this->genelToplam += $this->kargoBedeli;
							$this->araToplam   += round($this->calc->kdv_dahil_tutardan_kdv_haric_tutar($this->kargoBedeli, 18));
							$this->kdvTutari   += round($this->calc->kdv_dahil_tutardan_kdv_tutari($this->kargoBedeli, 18));
						};

						$this->genelToplam = $this->calc->kurusdan_fiyat($this->genelToplam);
						$this->araToplam   = $this->calc->kurusdan_fiyat($this->araToplam);
						$this->kdvTutari   = $this->calc->kurusdan_fiyat($this->kdvTutari);
						$this->kargoBedeli = $this->calc->kurusdan_fiyat($this->kargoBedeli);
					$buffer .= '</tbody>';
				$buffer .= '</table>';
				$buffer .= '<table width="100%">';
					$buffer .= '<tbody>';
						$buffer .= '<tr>';
							$buffer .= '<td width="25%"></td>';
							$buffer .= '<td width="75%">';
								$buffer .= '<table cellpadding="5" width="100%">';
									$buffer .= '<tbody>';
										$buffer .= '<tr>';
											$buffer .= '<td align="right" width="50%"><strong>Ara Toplam</strong></td>';
											$buffer .= '<td><strong>:</strong></td>';
											$buffer .= '<td align="center" width="50%"><strong>'.$this->araToplam.' TL</strong></td>';
										$buffer .= '</tr>';
										$buffer .= '<tr>';
											$buffer .= '<td align="right"><strong>KDV Tutarı</strong></td>';
											$buffer .= '<td><strong>:</strong></td>';
											$buffer .= '<td align="center"><strong>'.$this->kdvTutari.' TL</strong></td>';
										$buffer .= '</tr>';
										$buffer .= '<tr>';
											$buffer .= '<td align="right"><strong>Kargo Bedeli</strong></td>';
											$buffer .= '<td><strong>:</strong></td>';
											$buffer .= '<td align="center"><strong>'.$this->kargoBedeli.' TL</strong></td>';
										$buffer .= '</tr>';
										$buffer .= '<tr>';
											$buffer .= '<td align="right"><strong>Genel Toplam</strong></td>';
											$buffer .= '<td><strong>:</strong></td>';
											$buffer .= '<td align="center"><strong>'.$this->genelToplam.' TL</strong></td>';
										$buffer .= '</tr>';
									$buffer .= '</tbody>';
								$buffer .= '</table>';
							$buffer .= '</td>';
						$buffer .= '</tr>';
					$buffer .= '</tbody>';
				$buffer .= '</table>';
				return $buffer;
			}

			private function contentOrderAdres($adres){
				$adres   = json_decode($adres, true);
				$alanlar = array(
					'adi'				=> 'Adı',
					'soyadi'			=> 'Soyadı',
					'kimlikno'			=> 'Kimlik No',
					'adres'				=> 'Adres',
					'postakodu'			=> 'Posta Kodu',
					'il'				=> 'İl',
					'ilce'				=> 'İlçe',
					'semt'				=> 'Semt',
					'ceptel'			=> 'Cep Telefonu',
					'faturatipi'		=> 'Fatura Tipi',
					'firmaadi'			=> 'Firma Adı',
					'vergidairesi'		=> 'Vergi Dairesi',
					'vergino'			=> 'Vergi No',
					'f_adi'				=> 'Adı',
					'f_soyadi'			=> 'Soyadı',
					'f_kimlikno'		=> 'Kimlik No',
					'f_adres'			=> 'Adres',
					'f_postakodu'		=> 'Posta Kodu',
					'f_il'				=> 'İl',
					'f_ilce'			=> 'İlçe',
					'f_semt'			=> 'Semt'
				);
				$buffer  = '<table cellpadding="5" width="100%">';
					$buffer .= '<thead>';
						$buffer .= '<tr>';
							$buffer .= '<th colspan="3" style="background:#000000; color:#FFFFFF;">Teslimat Bilgileri</th>';
						$buffer .= '</tr>';
						$buffer .= '<tr><th>&nbsp;</th></tr>';
					$buffer .= '</thead>';
					$buffer .= '<tbody>';
						$key = 0;
						foreach($adres as $alan => $deger){
							if(!in_array($alan, array('adreslerimTeslimat', 'adresadi')) && ($key < 11)){
								if($alan == "il") $deger = $this->db->single("select il_TR from loc_iller where (id = :id);", array('id' => $deger));
								$buffer .= '<tr>';
									$buffer .= '<td width="50%"><strong>'.$alanlar[$alan].'</strong></td>';
									$buffer .= '<td><strong>:</strong></td>';
									$buffer .= '<td width="50%">'.$deger.'</td>';
								$buffer .= '</tr>';
							};
							$key++;
						};
					$buffer .= '</tbody>';
				$buffer .= '</table>';
				$buffer .= '<br />';
				$buffer .= '<table cellpadding="5" width="100%">';
					$buffer .= '<thead>';
						$buffer .= '<tr>';
							$buffer .= '<th colspan="3" style="background:#000000; color:#FFFFFF;">Fatura Bilgileri</th>';
						$buffer .= '</tr>';
						$buffer .= '<tr><th>&nbsp;</th></tr>';
					$buffer .= '</thead>';
					$buffer .= '<tbody>';
						$key = 0;
						foreach($adres as $alan => $deger){
							if(!in_array($alan, array('adreslerimFatura', 'teslimat')) && ($key > 10)){
								if(($alan == "faturatipi") && ($deger == "kurumsal")){
									$deger = "Kurumsal";
								} elseif(($alan == "faturatipi") && ($deger == "kurumsal")){
									$deger = "Bireysel";
								};
								if($alan == "f_il") $deger = $this->db->single("select il_TR from loc_iller where (id = :id);", array('id' => $deger));
								$buffer .= '<tr>';
									$buffer .= '<td width="50%"><strong>'.$alanlar[$alan].'</strong></td>';
									$buffer .= '<td><strong>:</strong></td>';
									$buffer .= '<td width="50%">'.$deger.'</td>';
								$buffer .= '</tr>';
							};
							$key++;
						};
					$buffer .= '</tbody>';
				$buffer .= '</table>';
				return $buffer;
			}

			private function contentOrderUye($uye){
				$alanlar = array(
					'adi'		=> 'Adı',
					'soyadi'	=> 'Soyadı',
					'email'		=> 'E-Posta Adresi'
				);
				$buffer  = '<table cellpadding="5" width="100%">';
					$buffer .= '<thead>';
						$buffer .= '<tr>';
							$buffer .= '<th colspan="3" style="background:#000000; color:#FFFFFF;">Üye Bilgileri</th>';
						$buffer .= '</tr>';
						$buffer .= '<tr><th>&nbsp;</th></tr>';
					$buffer .= '</thead>';
					$buffer .= '<tbody>';
						foreach($uye as $alan => $deger){
							if(isset($alanlar[$alan])){
								$buffer .= '<tr>';
									$buffer .= '<td width="50%"><strong>'.$alanlar[$alan].'</strong></td>';
									$buffer .= '<td><strong>:</strong></td>';
									$buffer .= '<td width="50%">'.$deger.'</td>';
								$buffer .= '</tr>';
							};
						};
					$buffer .= '</tbody>';
				$buffer .= '</table>';
				return $buffer;
			}

			private function contentOrderOdeme($odeme){
				$odeme  = json_decode($odeme, true);
				$buffer = '<table cellpadding="5" width="100%">';
					$buffer .= '<thead>';
						$buffer .= '<tr>';
							$buffer .= '<th style="background:#000000; color:#FFFFFF;">Tür</th>';
							$buffer .= '<th style="background:#000000; color:#FFFFFF;">Banka</th>';
							$buffer .= '<th style="background:#000000; color:#FFFFFF;">Pos</th>';
							$buffer .= '<th style="background:#000000; color:#FFFFFF;">Taksit</th>';
						$buffer .= '</tr>';
					$buffer .= '</thead>';
					$buffer .= '<tbody>';
						$buffer .= '<tr>';
							$buffer .= '<td align="center">'.$odeme['odemeturu'].'</td>';
							$buffer .= '<td align="center">';
								if($odeme['odemeturu'] == 'Banka Kartı'){
									$buffer .= $this->db->single("select banka_TR from pay_bankalar where (bankakodu = :bankakodu);", array('bankakodu' => $odeme['kartbankasi']));
								} elseif($odeme['odemeturu'] == 'Havale / EFT') {
									$buffer .= $this->db->single("select banka_TR from pay_bankalar where (bankakodu = :bankakodu);", array('bankakodu' => $odeme['havalebankasi']));
								}else{
									$buffer .= '';
								};
							$buffer .= '</td>';
							$buffer .= '<td align="center">'.$odeme['sanalposmodulu'].'</td>';
							$buffer .= '<td align="center">'.$odeme['taksitsayisi'].'</td>';
						$buffer .= '</tr>';
					$buffer .= '</tbody>';
				$buffer .= '</table>';
				return $buffer;
			}

			private function contentOrderHata($id){
				$log    = $this->db->row("select * from pay_log where (id = :id);", array('id' => $id));
				$uye    = $this->db->row("select * from cus_uyeler where (user = :user);", array('user' => $log['query']));
				$mesaj  = json_decode($log['mesaj'], true);
				if(strstr($log['url'], 'garanti')){
					$sipariskodu = $mesaj['oid'];
					$hatamesaji  = $mesaj['errmsg'];
				} elseif(strstr($log['url'], 'provizyon')){
					$sipariskodu = $mesaj['GetXid'];
					$hatamesaji  = $mesaj['ErrMsg'];
				} else {
					$sipariskodu = $mesaj['oid'];
					$hatamesaji  = $mesaj['ErrMsg'];
				};
				$buffer = '<table cellpadding="5" width="100%">';
					$buffer .= '<tr>';
						$buffer .= '<td align="center">Üye Adı</td>';
						$buffer .= '<td align="center" width="1">:</td>';
						$buffer .= '<td align="center">'.$uye['adi'].' '.$uye['soyadi'].'</td>';
					$buffer .= '</tr>';
					$buffer .= '<tr>';
						$buffer .= '<td align="center">Sipariş Kodu</td>';
						$buffer .= '<td align="center" width="1">:</td>';
						$buffer .= '<td align="center">'.$sipariskodu.'</td>';
					$buffer .= '</tr>';
					$buffer .= '<tr>';
						$buffer .= '<td align="center">Hata Mesajı</td>';
						$buffer .= '<td align="center" width="1">:</td>';
						$buffer .= '<td align="center">'.$hatamesaji.'</td>';
					$buffer .= '</tr>';
				$buffer .= '</table>';
				return $buffer;
			}

			private function contentOrderNew($user){
				$uye     = $this->db->row("select * from cus_uyeler where (user = :user);", array('user' => $user));
				$buffer  = $this->contentOrderUye($uye);
				$buffer .= '<br />';
				$meta    = '<meta charset="UTF-8">';
				$title   = '<br /><div style="text-align:center;">'.$uye['adi'].' '.$uye['soyadi'].' ( '.$uye['email'].' ) yeni üye kaydı oluşturdu. '.date('d.m.Y H:i:s', time()).'</div><br />';
				return $meta.$title.$buffer;
			}

			private function contentOrderBegin($sipariskodu){
				$siparis = $this->db->row("select * from sal_siparisler where (sipariskodu = :sipariskodu);", array('sipariskodu' => $sipariskodu));
				$urunler = $this->contentOrderSepet($siparis['sepet']);
				$uye     = json_decode($siparis['uye'], true);
				$meta    = '<meta charset="UTF-8">';
				$title   = '<br /><div style="text-align:center;">'.$uye['adi'].' '.$uye['soyadi'].' ( '.$uye['email'].' ) <strong>'.$sipariskodu.'</strong> sipariş numaralı,  <strong>'.$this->genelToplam.' TL</strong> tutarındaki alışverişe başladı. <br />'.date('d.m.Y H:i:s', time()).'</div><br />';
				return $meta.$title.$urunler;
			}

			private function contentOrderUpdate($sipariskodu){
				$siparis = $this->db->row("select * from sal_siparisler where (sipariskodu = :sipariskodu);", array('sipariskodu' => $sipariskodu));
				$urunler = $this->contentOrderSepet($siparis['sepet']);
				$uye     = json_decode($siparis['uye'], true);
				$meta    = '<meta charset="UTF-8">';
				$title   = '<br /><div style="text-align:center;">'.$uye['adi'].' '.$uye['soyadi'].' ( '.$uye['email'].' ) <strong>'.$sipariskodu.'</strong> sipariş numaralı,  <strong>'.$this->genelToplam.' TL</strong> tutarındaki sipariş bilgilerini güncelledi. <br />'.date('d.m.Y H:i:s', time()).'</div><br />';
				return $meta.$title.$urunler;
			}

			private function contentOrderEnd($sipariskodu){
				$siparis = $this->db->row("select * from sal_siparisler where (sipariskodu = :sipariskodu);", array('sipariskodu' => $sipariskodu));
				$uye     = json_decode($siparis['uye'], true);
				$buffer  = $this->contentOrderSepet($siparis['sepet']);
				$buffer .= '<br />';
				$buffer .= $this->contentOrderAdres($siparis['adres']);
				$buffer .= '<br />';
				$buffer .= $this->contentOrderOdeme($siparis['odeme']);
				$buffer .= '<br />';
				$meta    = '<meta charset="UTF-8">';
				$title   = '<br /><div style="text-align:center;">'.$uye['adi'].' '.$uye['soyadi'].' ( '.$uye['email'].' ) <strong>'.$sipariskodu.'</strong> sipariş numaralı,  <strong>'.$this->genelToplam.' TL</strong> tutarındaki siparişini tamamladı. '.date('d.m.Y H:i:s', time()).'</div><br />';
				return $meta.$title.$buffer;
			}

			private function contentOrderError($id){
				$buffer  = $this->contentOrderHata($id);
				$buffer .= '<br />';
				$meta    = '<meta charset="UTF-8">';
				$title   = '<br /><div style="text-align:center;">Sanal Pos Hatası! '.date('d.m.Y H:i:s', time()).'</div><br />';
				return $meta.$title.$buffer;
			}

			public function sendOrderNew($user){
				$params['From']			= $this->config['mail']['account'];
				$params['FromName']		= "oyunalisveris.com";

				$params['Reply']		= $this->config['mail']['account'];
				$params['ReplyName']	= $user." yeni üye profili oluşturdu";

				$params['To']			= "iletisim@petbakimi.com";
				$params['ToName']		= "Oyunalisveris";

				$params['Subject']		= $user." yeni üye profili oluşturdu";

				$params['Body']			= $this->contentOrderNew($user);

				return $this->engine($params);
			}

			public function sendOrderBegin($sipariskodu){
				$params['From']			= $this->config['mail']['account'];
				$params['FromName']		= "oyunalisveris.com";

				$params['Reply']		= $this->config['mail']['account'];
				$params['ReplyName']	= $sipariskodu." numaralı sipariş süreci başladı";

				$params['To']			= "iletisim@petbakimi.com";
				$params['ToName']		= "Oyunalisveris";

				$params['Subject']		= $sipariskodu." numaralı sipariş süreci başladı";

				$params['Body']			= $this->contentOrderBegin($sipariskodu);

				return $this->engine($params);
			}

			public function sendOrderUpdate($sipariskodu){
				$params['From']			= $this->config['mail']['account'];
				$params['FromName']		= "oyunalisveris.com";

				$params['Reply']		= $this->config['mail']['account'];
				$params['ReplyName']	= $sipariskodu." numaralı sipariş güncellemesi";

				$params['To']			= "iletisim@petbakimi.com";
				$params['ToName']		= "Oyunalisveris";

				$params['Subject']		= $sipariskodu." numaralı sipariş güncellemesi";

				$params['Body']			= $this->contentOrderUpdate($sipariskodu);

				return $this->engine($params);
			}

			public function sendOrderEnd($sipariskodu){
				$params['From']			= $this->config['mail']['account'];
				$params['FromName']		= "oyunalisveris.com";

				$params['Reply']		= $this->config['mail']['account'];
				$params['ReplyName']	= $sipariskodu." numaralı sipariş tamamlandı";

				$params['To']			= "iletisim@petbakimi.com";
				$params['ToName']		= "Oyunalisveris";

				$params['Subject']		= $sipariskodu." numaralı sipariş tamamlandı";

				$params['Body']			= $this->contentOrderEnd($sipariskodu);

				return $this->engine($params);
			}

			public function sendOrderError($id){
				$params['From']			= $this->config['mail']['account'];
				$params['FromName']		= "oyunalisveris.com";

				$params['Reply']		= $this->config['mail']['account'];
				$params['ReplyName']	= "Sanal Pos hatası";

				$params['To']			= "iletisim@petbakimi.com";
				$params['ToName']		= "Oyunalisveris";

				$params['Subject']		= "Sanal Pos hatası";

				$params['Body']			= $this->contentOrderError($id);

				return $this->engine($params);
			}

		/**/


		public function sendPulseContentTemplateTest($user, $sablon){
			$domain   = $this->config['global']['domain'];
			$cdn      = $this->config['global']['CDN'];
			$time     = date('d.m.Y - H:i:s', time());
			$isim     = $user['adi'].' '.$user['soyadi'];
			$iletisim = $domain.'iletisim';
			$pattern  = array('/{domain}/', '/{cdn}/', '/{time}/', '/{isim}/', '/{iletisim}/');
			$replace  = array(  $domain,      $cdn,      $time,      $isim,      $iletisim);
			$content  = preg_replace($pattern, $replace, $sablon['sablon_TR']);
			$params['From']			= $this->config['mail']['account'];
			$params['FromName']		= "oyunalisveris.com";
			$params['Reply']		= $this->config['mail']['account'];
			$params['ReplyName']	= $sablon['baslik_TR'];
			$params['To']			= $user['email'];
			$params['ToName']		= $isim;
			$params['Subject']		= $sablon['baslik_TR'];
			$params['Body']			= $this->seo->htmlParse($content);
			return $this->engine($params);
		}


		public function sendContentTemplate($sablonkodu, $user, $siparis = null, $hash = null, $emailNew = null){

			$template            = $this->db->row("select * from con_email where (sablonkodu = :sablonkodu);", array('sablonkodu' => $sablonkodu));

			$domain              = $this->config['global']['domain'];
			$cdn                 = $this->config['global']['CDN'];

			$time                = date('d.m.Y - H:i:s', time());
			$isim                = $user['adi'].' '.$user['soyadi'];
			$magazaadi			 = $user['kullaniciadi'];
			$link                = $domain.'sifremi-unuttum/'.$hash;
			$email               = $domain.'profil/eposta/'.$hash;
			$iletisim            = $domain.'iletisim';
			$mesajkonu			 = $_POST['mkonu'];
			$mesajicerik		 = $_POST['mmesaj'];
			$gonderenkisi		 = $_SESSION['www']['magaza'];
			$talepedilen 		 = $_POST['talepedilen'];
			$magaza				 = $teslimsurec['magaza'];
			$kullanici			 = $userbilgi['kullaniciadi'];
			$bakiyetoplam		 = $_POST['tutar'];
			$odemeturu			 = $_POST['pay_label'];

			if($sablonkodu == 'sepette-kalan-urun'){
				$sepet = '<table width="100%" cellpadding="5">';
					$json = $this->db->single("select sepet from sal_sepet where (sepetkodu = :sepetkodu);", array('sepetkodu' => $user['user']));
					$json = json_decode($json, true);
					foreach($json as $key => $node){
						$urun = $this->db->row("select * from cat_urunler where (stokkodu = :stokkodu);", array('stokkodu' => $node['stk']));
						$sepet .= '<tr>';
							$sepet .= '<td width="1">';
								$sepet .= '<a href="'.$domain.$urun['urlkodu'].'">';
									$gorsel = json_decode($urun['gorsel'], true);
									$sepet .= '<img src="'.$cdn.'files/product/'.$gorsel[0].'" width="50" />';
								$sepet .= '</a>';
							$sepet .= '</td>';
							$sepet .= '<td>';
								$sepet .= '<a href="'.$domain.$urun['urlkodu'].'" style="text-decoration:none; font-size:14px; color:#333;">';
									$sepet .= $urun['urun_TR'];
								$sepet .= '</a>';
							$sepet .= '</td>';
						$sepet .= '</tr>';
					};
				$sepet .= '</table>';
			};

			$geneltoplam         = 0;
			foreach(json_decode($siparis['sepet'], true) as $key => $node){
				$geneltoplam += $this->calc->fiyattan_kurus($node['satisfiyatikd']) * $node['adet'];
				if($geneltoplam >= 10000) {$kargobedeli = 0;} else{ 
				$stamp = '1477381622';
				if(time() > $stamp){
				$kargobedeli  = 0;	
				}else{$kargobedeli  = 0;};
				};
			};
			$geneltoplam         = $this->calc->kurusdan_fiyat($geneltoplam + $kargobedeli);

			$sipariskodu         = $siparis['sipariskodu'];
			$siparistarihi       = date('d.m.Y - H:i', $siparis['stamp']);

			$kargo               = json_decode($siparis['takipkodu'], true);

			$kargofirmasi        = $this->db->single("select firma_TR from car_firmalar where (firmakodu = :firmakodu);", array('firmakodu' => $kargo[count($kargo) - 1]['firma']));
			$kargotakipno        = $kargo[count($kargo) - 1]['kod'];

			$adres               = json_decode($siparis['adres'], true);

			$t_adi               = $adres['adi'];
			$t_soyadi            = $adres['soyadi'];
			$il                  = $this->db->single("select il_TR from loc_iller where (id = :id);", array('id' => $adres['il']));
			$t_adres             = $adres['adres'].' '.$adres['postakodu'].' '.$il.' '.$adres['ilce'].' '.$adres['semt'];

			$f_adi               = $adres['f_adi'];
			$f_soyadi            = $adres['f_soyadi'];
			$il                  = $this->db->single("select il_TR from loc_iller where (id = :id);", array('id' => $adres['f_il']));
			$f_adres             = $adres['f_adres'].' '.$adres['f_postakodu'].' '.$il.' '.$adres['f_ilce'].' '.$adres['f_semt'];
			$f_firmaadi          = $adres['firmaadi'];
			$f_vergidairesi      = $adres['vergidairesi'];
			$f_vergino           = $adres['vergino'];


			$pattern             = array('/{domain}/', '/{cdn}/', '/{time}/', '/{isim}/', '/{link}/', '/{email}/', '/{iletisim}/', '/{sepet}/', '/{geneltoplam}/', '/{sipariskodu}/', '/{siparistarihi}/', '/{kargofirmasi}/', '/{kargotakipno}/', '/{t_adi}/', '/{t_soyadi}/', '/{t_adres}/', '/{f_adi}/', '/{f_soyadi}/', '/{f_adres}/', '/{f_firmaadi}/', '/{f_vergidairesi}/', '/{f_vergino}/', '/{mesajkonu}/', '/{mesajicerik}/', '/{gonderenkisi}/', '/{talepedilen}/', '/{magaza}/', '/{kullanici}/', '/{bakiyetoplam}/', '/{odemeturu}/', '/{magazaadi}/');
			$replace             = array(  $domain,      $cdn,      $time,      $isim,      $link,      $email,      $iletisim,      $sepet,      $geneltoplam,      $sipariskodu,      $siparistarihi,      $kargofirmasi,      $kargotakipno,      $t_adi,      $t_soyadi,      $t_adres,      $f_adi,      $f_soyadi,      $f_adres,      $f_firmaadi,      $f_vergidairesi,      $f_vergino,	$mesajkonu, $mesajicerik,	$gonderenkisi,	$talepedilen, $magaza, $kullanici, $bakiyetoplam, $odemeturu, $magazaadi);

			$content             = preg_replace($pattern, $replace, $template['sablon_TR']);

			if($emailNew == null) $emailNew = $user['email'];

			$params['From']      = $this->config['mail']['account'];
			$params['FromName']  = "oyunalisveris.com";
			$params['Reply']     = $this->config['mail']['account'];
			$params['ReplyName'] = $template['baslik_TR'];
			$params['To']        = $emailNew;
			$params['ToName']    = $isim;
			$params['Subject']   = $template['baslik_TR'];
			$params['Body']      = $this->seo->htmlParse($content);
			return $this->engine($params);
		}
	};
?>