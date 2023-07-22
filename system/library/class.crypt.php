<?php

	/*
	*
	*
	*
	*/

	class crypt extends core{

		public $aes_iv;
		public $aes_key;
		
		public function __construct(){

		}

		public function __destruct(){
			unset($this->aes_iv);
			unset($this->aes_key);
		}

		public function aes_create_iv(){
			return mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC), MCRYPT_RAND);
		}

		public function aes_encode($data){
			return rtrim($this->hex_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $this->aes_key, $data, MCRYPT_MODE_CBC, $this->aes_iv)), "\0\3");
		}

		public function aes_decode($data){
			return rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $this->aes_key, $this->hex_decode($data), MCRYPT_MODE_CBC, $this->aes_iv), "\0\3");
		}

		public function hex_encode($str){
			unset($hex);
			for($i = 0; $i < strlen($str); $i++){
				$ord  = ord($str[$i]);
				$code = dechex($ord);
				$hex .= substr('0'.$code, -2);
			};
			return strtoupper($hex);
		}

		public function hex_decode($hex){
			unset($str);
			for($i = 0; $i < strlen($hex) - 1; $i += 2){
				$str .= chr(hexdec($hex[$i].$hex[$i + 1]));
			};
			return $str;
		}

		public function cine5($buffer){
			return md5(sha1(md5($buffer)));
		}

	};

?>