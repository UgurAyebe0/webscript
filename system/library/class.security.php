<?php

	/**
	* 
	*/

	class security extends core{

		public  $db;
		public  $puan;
		private $user;
		private $mode;
		private $table;
		private $table2;

		public $alert;
		
		public function __construct(){
			$this->user   = $_SESSION['pulse']['user'];
			$this->mode   = $_SESSION['pulse']['mode'];
			$this->table  = "sys_yoneticiler";
			$this->table2 = "sys_yetkiler";
		}

		public function __destruct(){
			unset($this->db);
			unset($this->puan);
			unset($this->user);
			unset($this->mode);
			unset($this->table);
			unset($this->table2);
		}

		public function mode($param){
			$_SESSION['pulse']['mode'] = $param;
		}

		public function get($area){
			$yetkikodu = $this->db->single("select yetkikodu from ".$this->table." where (user = :user);", array('user' => $this->user));
			if(($yetkikodu == 'developer') && !empty($this->mode)){
				$yetkikodu = $this->mode;
			};
			$authr = $this->db->single("select parametreler from ".$this->table2." where (yetkikodu = :yetkikodu);", array('yetkikodu' => $yetkikodu));
			$yetki = json_decode($authr, true);
			$param = explode("/", $area);
			switch(count($param)){
				case 1 :	$yetki = $yetki[$param[0]];							break;
				case 2 :	$yetki = $yetki[$param[0]][$param[1]];				break;
				case 3 :	$yetki = $yetki[$param[0]][$param[1]][$param[2]];	break;
				default:	$yetki = false;										break;
			};
			if($yetki){
				return true;
			} else {
				switch($param[2]){
					case 'select' :
						$this->alert = '<strong>Dikkat: </strong><hr />Bu alanda listeleme yetkiniz bulunmamaktadır. Lütfen yöneticinizle irtibata geçiniz.';
						return false;
					break;
					case 'import' :
						$this->alert = '<strong>Dikkat: </strong><hr />Bu alanda içe aktarma yetkiniz bulunmamaktadır. Lütfen yöneticinizle irtibata geçiniz.';
						return false;
					break;
					case 'export' :
						$this->alert = '<strong>Dikkat: </strong><hr />Bu alanda dışa aktarma yetkiniz bulunmamaktadır. Lütfen yöneticinizle irtibata geçiniz.';
						return false;
					break;
					case 'search' :
						$this->alert = '<strong>Dikkat: </strong><hr />Bu alanda arama yapma yetkiniz bulunmamaktadır. Lütfen yöneticinizle irtibata geçiniz.';
						return false;
					break;
					case 'sort' :
						return false;
					break;
					case 'insert' :
						$this->alert = '<strong>Dikkat: </strong><hr />Bu alanda ekleme yetkiniz bulunmamaktadır. Lütfen yöneticinizle irtibata geçiniz.';
						return false;
					break;
					case 'update' :
						$this->alert = '<strong>Dikkat: </strong><hr />Bu alanda düzenleme yetkiniz bulunmamaktadır. Lütfen yöneticinizle irtibata geçiniz.';
						return false;
					break;
					case 'view' :
						$this->alert = '<strong>Dikkat: </strong><hr />Bu alanda düzenleme yetkiniz bulunmamaktadır. Lütfen yöneticinizle irtibata geçiniz.';
						return false;
					break;
					case 'delete' :
						$this->alert = '<h2>Silmek işlemi gerçekleştirilemiyor!</h2><p class="text-danger">Bu alanda silme yetkiniz bulunmamaktadır. Lütfen yöneticinizle irtibata geçiniz.</p>';
						return false;
					break;
					default : return false; break;
				};
			};
		}

	};

?>