<?php

	class log extends core{

		public  $db;
		public  $tool;
		public  $dispatcher;

		private $table;
		private $table2;
		private $table3;

		public function __construct(){
			$this->table  = "sys_log";
			$this->table2 = "xml_log";
			$this->table3 = "pay_log";
		}

		public function __destruct(){
			unset($this->table);
			unset($this->table2);
			unset($this->table3);
		}

		public function set($param, $type = null, $query = null){
			switch($type){
				case 'sys' : $table = $this->table;  break;
				case 'xml' : $table = $this->table2; break;
				case 'pay' : $table = $this->table3; break;
				default    : $table = $this->table;  break;
			};
			$bind = array(
				'id'		=> $this->db->max($table),
				'ipadresi'	=> $this->tool->whatIsMyIp(),
				'url'		=> $this->dispatcher->getURL($_SERVER),
				'mesaj'		=> $param,
				'query'		=> $query,
				'stamp'		=> time(),
				'yayin'		=> 0
			);
			return $this->db->query("insert into ".$table." (id, ipadresi, url, mesaj, query, stamp, yayin) values (:id, :ipadresi, :url, :mesaj, :query, :stamp, :yayin);", $bind);
		}
		
	};

?>