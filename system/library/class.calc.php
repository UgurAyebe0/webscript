<?php

	class calc extends core{

		public function __construct(){

		}

		public function __destruct(){

		}

		private function tutar_format_yazi_birler($sayi){
			$param = array(
				1 => 'bir',
				2 => 'iki',
				3 => 'üç',
				4 => 'dört',
				5 => 'beş',
				6 => 'altı',
				7 => 'yedi',
				8 => 'sekiz',
				9 => 'dokuz'
			);
			return $param[$sayi];
		}

		private function tutar_format_yazi_onlar($sayi){
			$param = array(
				1 => 'on',
				2 => 'yirmi',
				3 => 'otuz',
				4 => 'kırk',
				5 => 'elli',
				6 => 'altmış',
				7 => 'yetmiş',
				8 => 'seksen',
				9 => 'doksan'
			);
			return $param[$sayi];
		}

		private function tutar_format_yazi_yuzler($sayi){
			switch($sayi){
				case 0  :	return null;											break;
				case 1  :	return 'yüz';											break;
				default :	return $this->tutar_format_yazi_birler($sayi).'yüz';	break;
			};
		}

		private function tutar_format_yazi_binler($sayi){
			switch(strlen($sayi)){
				case 1:
					if($sayi[0] == 1) return 'bin';
					return $this->tutar_format_yazi_birler($sayi[0]).'bin';
				break;
				case 2:
					return $this->tutar_format_yazi_onlar($sayi[0]).$this->tutar_format_yazi_birler($sayi[1]).'bin';
				break;
				case 3:
					return $this->tutar_format_yazi_yuzler($sayi[0]).$this->tutar_format_yazi_onlar($sayi[1]).$this->tutar_format_yazi_birler($sayi[2]).'bin';
				break;
			};
		}

		public function tutar_format_yazi($fiyat){
			$fiyat  = explode(',', $fiyat);
			$lira   = $fiyat[0];
			$kurus  = $fiyat[1];
			$sonuc  = array();
			switch(strlen($lira)){
				case 1:
					$sonuc['lira'] = $this->tutar_format_yazi_birler($lira[0]);
					if($lira[0] == 0) $sonuc['lira'] = 'sıfır';
				break;
				case 2:
					$sonuc['lira'] = $this->tutar_format_yazi_onlar($lira[0]).$this->tutar_format_yazi_birler($lira[1]);
				break;
				case 3:
					$sonuc['lira'] = $this->tutar_format_yazi_yuzler($lira[0]).$this->tutar_format_yazi_onlar($lira[1]).$this->tutar_format_yazi_birler($lira[2]);
				break;
				case 4:
					$sonuc['lira'] = $this->tutar_format_yazi_binler($lira[0]).$this->tutar_format_yazi_yuzler($lira[1]).$this->tutar_format_yazi_onlar($lira[2]).$this->tutar_format_yazi_birler($lira[3]);
				break;
				case 5:
					$sonuc['lira'] = $this->tutar_format_yazi_binler($lira[0].$lira[1]).$this->tutar_format_yazi_yuzler($lira[2]).$this->tutar_format_yazi_onlar($lira[3]).$this->tutar_format_yazi_birler($lira[4]);
				break;
				case 6:
					$sonuc['lira'] = $this->tutar_format_yazi_binler($lira[0].$lira[1].$lira[2]).$this->tutar_format_yazi_yuzler($lira[3]).$this->tutar_format_yazi_onlar($lira[4]).$this->tutar_format_yazi_birler($lira[5]);
				break;
			};

			switch(strlen($kurus)){
				case 2:
					if($kurus != '00')						$sonuc['kurus'] = $this->tutar_format_yazi_onlar($kurus[0]).$this->tutar_format_yazi_birler($kurus[1]).'kuruş';
					if($kurus[0] == 0 && $kurus[1] != 0)	$sonuc['kurus'] = $this->tutar_format_yazi_birler($kurus[1]).'kuruş';
				break;
			};

			if(strlen($sonuc['lira']) > 40){
				return $sonuc['lira'].'lira<br />'.$sonuc['kurus'];
			} else {
				return $sonuc['lira'].'lira'.$sonuc['kurus'];
			};

		}

		public function tutar_format($tutar){
			if($tutar == '') $tutar = 0;
			$tutar = str_replace('.', '', $tutar);
			if(strpos($tutar, ",")){
				$hash = explode(",", $tutar);
				if(strlen($hash[1]) > 2){
					return number_format($hash[0], 0, ',', '.').",".substr($hash[1], 0, 2);
				} else {
					return $tutar;
				};
			} else {
				return $tutar.",00";
			};
		}

		public function fiyattan_kurus($fiyat){
			
			$fiyat = str_replace('.', '', $fiyat);
			$fiyat = str_replace(',', '.', $fiyat);
			$kurus = floatval($fiyat) * 100;
						
				return $kurus;

		}

		public function kurusdan_fiyat($kurus){
		
			if($kurus == 0) return "0,00";
			
			$lira  = substr($kurus, 0, strlen($kurus) - 2);
			if($lira == '') $lira = 0;
			$kurus = substr($kurus, strlen($kurus) - 2);

			return $lira.",".$kurus;
		}

		public function kdv_dahil_tutardan_kdv_haric_tutar($kdvdahiltutar, $kdvorani){
			return round($kdvdahiltutar / (1 + ($kdvorani / 100)));
		}

		public function kdv_haric_tutardan_kdv_dahil_tutar($kdvharictutar, $kdvorani){
			return round($kdvharictutar * (1 + ($kdvorani / 100)));
		}

		public function kdv_haric_tutardan_kdv_tutari($kdvharictutar, $kdvorani){
			return round($kdvharictutar * ($kdvorani / 100));
		}

		public function kdv_dahil_tutardan_kdv_tutari($kdvdahiltutar, $kdvorani){
			return round(($kdvdahiltutar / (1 + ($kdvorani / 100))) * ($kdvorani / 100));
		}

		public function kdv_tutarindan_kdv_haric_tutar($kdvtutari, $kdvorani){
			return round($kdvtutari * (100 / $kdvorani));
		}

		public function kdv_tutarindan_kdv_dahil_tutar($kdvtutari, $kdvorani){
			return round(($kdvtutari * (100 / $kdvorani)) + $kdvtutari);
		}

		public function kar_orani($alisfiyati, $satisfiyati){
			if(($alisfiyati == 0) || ($alisfiyati == '')) return null;
			if(strpos($alisfiyati,  ',')) $alisfiyati  = $this->fiyattan_kurus($alisfiyati);
			if(strpos($satisfiyati, ',')) $satisfiyati = $this->fiyattan_kurus($satisfiyati);
			return (($satisfiyati - $alisfiyati) / $alisfiyati) * 100;
		}

		public function kar_marji($alisfiyati, $satisfiyati){
			if(($alisfiyati == 0) || ($alisfiyati == '')) return null;
			if(strpos($alisfiyati,  ',')) $alisfiyati  = $this->fiyattan_kurus($alisfiyati);
			if(strpos($satisfiyati, ',')) $satisfiyati = $this->fiyattan_kurus($satisfiyati);
			return (($satisfiyati - $alisfiyati) / $satisfiyati) * 100;
		}

		/* fiyat_duzenle fonksiyonu büyük bir ihtimalle atıl durumda. sistemde incele. eğer kullanılmıyorsa kütüphaneden sil. */

		public function fiyat_duzenle($dizi){
			if(is_array($dizi) && isset($dizi['indirimfiyati']) && isset($dizi['eskifiyat']) && isset($dizi['satisfiyatikd'])){
				$indirimfiyati = $dizi['indirimfiyati'];
				$eskifiyat     = $dizi['eskifiyat'];
				$satisfiyatikd = $dizi['satisfiyatikd'];
				if(($indirimfiyati != '') && ($indirimfiyati != 0)){
					if(($eskifiyat != '') && ($eskifiyat != 0)){ /* indirim fiyatı var, eski fiyat var */
						$dizi['satisfiyatikd'] = $indirimfiyati;
					} else { /* indirim fiyatı var, eski fiyat yok */
						$dizi['satisfiyatikd'] = $indirimfiyati;
						$dizi['eskifiyat']     = $satisfiyatikd;
					};
				};
			};
			return $dizi;			
		}
		
	};

?>