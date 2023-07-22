<?php

	class db extends core{

		public $calc;

		public $host;
		public $port;
		public $name;
		public $user;
		public $pass;
		public $char;
		
		private $pdo;
		private $sQuery;
		private $parameters;

		public function __construct(){
			$this->parameters = array();
		}

		public function __destruct(){
			unset($this->host);
			unset($this->port);
			unset($this->name);
			unset($this->user);
			unset($this->pass);
			unset($this->char);
			unset($this->sQuery);
			unset($this->parameters);
		}

		private function log($mesaj = null, $query = null){
			
			if(getenv("HTTP_CLIENT_IP")){
				$ip = getenv("HTTP_CLIENT_IP");
			} elseif(getenv("HTTP_X_FORWARDED_FOR")){
				$ip = getenv("HTTP_X_FORWARDED_FOR");
				if(strstr($ip, ',')){
					$tmp = explode(',', $ip);
					$ip = trim($tmp[0]);
				};
			} else {
				$ip = getenv("REMOTE_ADDR");
			};

			$use_forwarded_host = false;
			$ssl  = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ? true:false;
			$prot = strtolower($_SERVER['SERVER_PROTOCOL']);
			$prot = substr($prot, 0, strpos($prot, '/')).(($ssl) ? 's' : '');
			$port = $_SERVER['SERVER_PORT'];
			$port = ((!$ssl && $port=='80') || ($ssl && $port=='443')) ? '' : ':'.$port;
			$host = ($use_forwarded_host && isset($_SERVER['HTTP_X_FORWARDED_HOST'])) ? $_SERVER['HTTP_X_FORWARDED_HOST'] : (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : null);
			$host = isset($host) ? $host : $_SERVER['SERVER_NAME'].$port;
			$requ = $_SERVER['REQUEST_URI'];
			$reff = $_SERVER['HTTP_REFERER'];

			$bind = array(
				'id'		=> $this->max('sys_log'),
				'ipadresi'	=> $ip,
				'url'		=> $prot.'://'.$host.$requ,
				'mesaj'		=> $mesaj,
				'query'		=> $query,
				'stamp'		=> time(),
				'yayin'		=> 0
			);
			$this->query("insert into sys_log (id, ipadresi, url, mesaj, query, stamp, yayin) values (:id, :ipadresi, :url, :mesaj, :query, :stamp, :yayin);", $bind);
			return $mesaj;
		}

		public function connect(){
			$dsn = 'mysql:dbname='.$this->name.'; charset='.$this->char.'; host='.$this->host.';';
			try{
				$this->pdo = new PDO($dsn, $this->user, $this->pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES ".$this->char));
				$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
				$this->pdo->exec('SET NAMES '.$this->char.';');
			} catch(PDOException $e){
				return $this->log($e->getMessage());
			};
		}

		public function disconnect(){
			try{
				$this->pdo = null;
			} catch(PDOException $e){
				return $this->log($e->getMessage());
			};
		}
		
		private function Init($query, $parameters = ""){
			try{
				$this->sQuery = $this->pdo->prepare($query);
				$this->bindMore($parameters);
				if(!empty($this->parameters)){
					foreach($this->parameters as $param){
						$parameters = explode("\x7F",$param);
						$this->sQuery->bindParam($parameters[0],$parameters[1]);
					};		
				};
				$this->succes = $this->sQuery->execute();		
			} catch(PDOException $e){
				return $this->log($e->getMessage(), $query);
			};
			$this->parameters = array();
		}

		public function bind($para, $value){	
			$this->parameters[sizeof($this->parameters)] = ":".$para."\x7F".$value;
		}

		public function bindMore($parray){
			if(empty($this->parameters) && is_array($parray)){
				$columns = array_keys($parray);
				foreach($columns as $i => &$column){
					$this->bind($column, $parray[$column]);
				};
			};
		}

		public function query($query, $params = null, $fetchmode = PDO::FETCH_ASSOC){
			$query = trim($query);
			$this->Init($query,$params);
			$rawStatement = explode(" ", $query);
			$statement = strtolower($rawStatement[0]);
			if($statement === 'select' || $statement === 'show'){
				return $this->sQuery->fetchAll($fetchmode);
			} elseif($statement === 'insert' ||  $statement === 'update' || $statement === 'delete'){
				return $this->sQuery->rowCount();	
			} else {
				return NULL;
			};
		}

		public function row($query, $params = null, $fetchmode = PDO::FETCH_ASSOC){
			$this->Init($query,$params);
			return $this->sQuery->fetch($fetchmode);
		}

		public function column($query, $params = null){
			$this->Init($query,$params);
			$Columns = $this->sQuery->fetchAll(PDO::FETCH_NUM);		
			$column = null;
			foreach($Columns as $cells){
				$column[] = $cells[0];
			};
			return $column;
		}

		public function tables(){
			$hash   = $this->query("show tables from ".$this->name.";");
			$buffer = array();
			foreach($hash as $node){
				$buffer[] = $node['Tables_in_'.$this->name];
			};
			return $buffer;
		}

		public function columns($table){
			$hash   = $this->query("show columns from ".$table.";");
			$buffer = array();
			foreach($hash as $node){
				$buffer[] = $node['Field'];
			};
			return $buffer;
		}

		public function single($query, $params = null){
			$this->Init($query,$params);
			return $this->sQuery->fetchColumn();
		}

		public function max($table){
			return $this->single("select max(id) as _count from ".$table.";") + 1;
		}

		public function count($table){
			return $this->single("select count(id) as _count from ".$table.";");
		}

	};
	
	class puan extends core{

		public $calc;

		public $host;
		public $port;
		public $name;
		public $user;
		public $pass;
		public $char;
		
		private $pdo;
		private $sQuery;
		private $parameters;

		public function __construct(){
			$this->parameters = array();
		}

		public function __destruct(){
			unset($this->host);
			unset($this->port);
			unset($this->name);
			unset($this->user);
			unset($this->pass);
			unset($this->char);
			unset($this->sQuery);
			unset($this->parameters);
		}

		private function log($mesaj = null, $query = null){
			
			if(getenv("HTTP_CLIENT_IP")){
				$ip = getenv("HTTP_CLIENT_IP");
			} elseif(getenv("HTTP_X_FORWARDED_FOR")){
				$ip = getenv("HTTP_X_FORWARDED_FOR");
				if(strstr($ip, ',')){
					$tmp = explode(',', $ip);
					$ip = trim($tmp[0]);
				};
			} else {
				$ip = getenv("REMOTE_ADDR");
			};

			$use_forwarded_host = false;
			$ssl  = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ? true:false;
			$prot = strtolower($_SERVER['SERVER_PROTOCOL']);
			$prot = substr($prot, 0, strpos($prot, '/')).(($ssl) ? 's' : '');
			$port = $_SERVER['SERVER_PORT'];
			$port = ((!$ssl && $port=='80') || ($ssl && $port=='443')) ? '' : ':'.$port;
			$host = ($use_forwarded_host && isset($_SERVER['HTTP_X_FORWARDED_HOST'])) ? $_SERVER['HTTP_X_FORWARDED_HOST'] : (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : null);
			$host = isset($host) ? $host : $_SERVER['SERVER_NAME'].$port;
			$requ = $_SERVER['REQUEST_URI'];
			$reff = $_SERVER['HTTP_REFERER'];

			$bind = array(
				'id'		=> $this->max('sys_log'),
				'ipadresi'	=> $ip,
				'url'		=> $prot.'://'.$host.$requ,
				'mesaj'		=> $mesaj,
				'query'		=> $query,
				'stamp'		=> time(),
				'yayin'		=> 0
			);
			$this->query("insert into sys_log (id, ipadresi, url, mesaj, query, stamp, yayin) values (:id, :ipadresi, :url, :mesaj, :query, :stamp, :yayin);", $bind);
			return $mesaj;
		}

		public function connect(){
			$dsn = 'mysql:dbname='.$this->name.'; charset='.$this->char.'; host='.$this->host.';';
			try{
				$this->pdo = new PDO($dsn, $this->user, $this->pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES ".$this->char));
				$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
				$this->pdo->exec('SET NAMES '.$this->char.';');
			} catch(PDOException $e){
				return $this->log($e->getMessage());
			};
		}

		public function disconnect(){
			try{
				$this->pdo = null;
			} catch(PDOException $e){
				return $this->log($e->getMessage());
			};
		}
		
		private function Init($query, $parameters = ""){
			try{
				$this->sQuery = $this->pdo->prepare($query);
				$this->bindMore($parameters);
				if(!empty($this->parameters)){
					foreach($this->parameters as $param){
						$parameters = explode("\x7F",$param);
						$this->sQuery->bindParam($parameters[0],$parameters[1]);
					};		
				};
				$this->succes = $this->sQuery->execute();		
			} catch(PDOException $e){
				return $this->log($e->getMessage(), $query);
			};
			$this->parameters = array();
		}

		public function bind($para, $value){	
			$this->parameters[sizeof($this->parameters)] = ":".$para."\x7F".$value;
		}

		public function bindMore($parray){
			if(empty($this->parameters) && is_array($parray)){
				$columns = array_keys($parray);
				foreach($columns as $i => &$column){
					$this->bind($column, $parray[$column]);
				};
			};
		}

		public function query($query, $params = null, $fetchmode = PDO::FETCH_ASSOC){
			$query = trim($query);
			$this->Init($query,$params);
			$rawStatement = explode(" ", $query);
			$statement = strtolower($rawStatement[0]);
			if($statement === 'select' || $statement === 'show'){
				return $this->sQuery->fetchAll($fetchmode);
			} elseif($statement === 'insert' ||  $statement === 'update' || $statement === 'delete'){
				return $this->sQuery->rowCount();	
			} else {
				return NULL;
			};
		}

		public function row($query, $params = null, $fetchmode = PDO::FETCH_ASSOC){
			$this->Init($query,$params);
			return $this->sQuery->fetch($fetchmode);
		}

		public function column($query, $params = null){
			$this->Init($query,$params);
			$Columns = $this->sQuery->fetchAll(PDO::FETCH_NUM);		
			$column = null;
			foreach($Columns as $cells){
				$column[] = $cells[0];
			};
			return $column;
		}

		public function tables(){
			$hash   = $this->query("show tables from ".$this->name.";");
			$buffer = array();
			foreach($hash as $node){
				$buffer[] = $node['Tables_in_'.$this->name];
			};
			return $buffer;
		}

		public function columns($table){
			$hash   = $this->query("show columns from ".$table.";");
			$buffer = array();
			foreach($hash as $node){
				$buffer[] = $node['Field'];
			};
			return $buffer;
		}

		public function single($query, $params = null){
			$this->Init($query,$params);
			return $this->sQuery->fetchColumn();
		}

		public function max($table){
			return $this->single("select max(id) as _count from ".$table.";") + 1;
		}

		public function count($table){
			return $this->single("select count(id) as _count from ".$table.";");
		}

	};

	
	class faction extends core{

		public $calc;

		public $host;
		public $port;
		public $name;
		public $user;
		public $pass;
		public $char;
		
		private $pdo;
		private $sQuery;
		private $parameters;

		public function __construct(){
			$this->parameters = array();
		}

		public function __destruct(){
			unset($this->host);
			unset($this->port);
			unset($this->name);
			unset($this->user);
			unset($this->pass);
			unset($this->char);
			unset($this->sQuery);
			unset($this->parameters);
		}

		private function log($mesaj = null, $query = null){
			
			if(getenv("HTTP_CLIENT_IP")){
				$ip = getenv("HTTP_CLIENT_IP");
			} elseif(getenv("HTTP_X_FORWARDED_FOR")){
				$ip = getenv("HTTP_X_FORWARDED_FOR");
				if(strstr($ip, ',')){
					$tmp = explode(',', $ip);
					$ip = trim($tmp[0]);
				};
			} else {
				$ip = getenv("REMOTE_ADDR");
			};

			$use_forwarded_host = false;
			$ssl  = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ? true:false;
			$prot = strtolower($_SERVER['SERVER_PROTOCOL']);
			$prot = substr($prot, 0, strpos($prot, '/')).(($ssl) ? 's' : '');
			$port = $_SERVER['SERVER_PORT'];
			$port = ((!$ssl && $port=='80') || ($ssl && $port=='443')) ? '' : ':'.$port;
			$host = ($use_forwarded_host && isset($_SERVER['HTTP_X_FORWARDED_HOST'])) ? $_SERVER['HTTP_X_FORWARDED_HOST'] : (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : null);
			$host = isset($host) ? $host : $_SERVER['SERVER_NAME'].$port;
			$requ = $_SERVER['REQUEST_URI'];
			$reff = $_SERVER['HTTP_REFERER'];

			$bind = array(
				'id'		=> $this->max('sys_log'),
				'ipadresi'	=> $ip,
				'url'		=> $prot.'://'.$host.$requ,
				'mesaj'		=> $mesaj,
				'query'		=> $query,
				'stamp'		=> time(),
				'yayin'		=> 0
			);
			$this->query("insert into sys_log (id, ipadresi, url, mesaj, query, stamp, yayin) values (:id, :ipadresi, :url, :mesaj, :query, :stamp, :yayin);", $bind);
			return $mesaj;
		}

		public function connect(){
			$dsn = 'mysql:dbname='.$this->name.'; charset='.$this->char.'; host='.$this->host.';';
			try{
				$this->pdo = new PDO($dsn, $this->user, $this->pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES ".$this->char));
				$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
				$this->pdo->exec('SET NAMES '.$this->char.';');
			} catch(PDOException $e){
				return $this->log($e->getMessage());
			};
		}

		public function disconnect(){
			try{
				$this->pdo = null;
			} catch(PDOException $e){
				return $this->log($e->getMessage());
			};
		}
		
		private function Init($query, $parameters = ""){
			try{
				$this->sQuery = $this->pdo->prepare($query);
				$this->bindMore($parameters);
				if(!empty($this->parameters)){
					foreach($this->parameters as $param){
						$parameters = explode("\x7F",$param);
						$this->sQuery->bindParam($parameters[0],$parameters[1]);
					};		
				};
				$this->succes = $this->sQuery->execute();		
			} catch(PDOException $e){
				return $this->log($e->getMessage(), $query);
			};
			$this->parameters = array();
		}

		public function bind($para, $value){	
			$this->parameters[sizeof($this->parameters)] = ":".$para."\x7F".$value;
		}

		public function bindMore($parray){
			if(empty($this->parameters) && is_array($parray)){
				$columns = array_keys($parray);
				foreach($columns as $i => &$column){
					$this->bind($column, $parray[$column]);
				};
			};
		}

		public function query($query, $params = null, $fetchmode = PDO::FETCH_ASSOC){
			$query = trim($query);
			$this->Init($query,$params);
			$rawStatement = explode(" ", $query);
			$statement = strtolower($rawStatement[0]);
			if($statement === 'select' || $statement === 'show'){
				return $this->sQuery->fetchAll($fetchmode);
			} elseif($statement === 'insert' ||  $statement === 'update' || $statement === 'delete'){
				return $this->sQuery->rowCount();	
			} else {
				return NULL;
			};
		}

		public function row($query, $params = null, $fetchmode = PDO::FETCH_ASSOC){
			$this->Init($query,$params);
			return $this->sQuery->fetch($fetchmode);
		}

		public function column($query, $params = null){
			$this->Init($query,$params);
			$Columns = $this->sQuery->fetchAll(PDO::FETCH_NUM);		
			$column = null;
			foreach($Columns as $cells){
				$column[] = $cells[0];
			};
			return $column;
		}

		public function tables(){
			$hash   = $this->query("show tables from ".$this->name.";");
			$buffer = array();
			foreach($hash as $node){
				$buffer[] = $node['Tables_in_'.$this->name];
			};
			return $buffer;
		}

		public function columns($table){
			$hash   = $this->query("show columns from ".$table.";");
			$buffer = array();
			foreach($hash as $node){
				$buffer[] = $node['Field'];
			};
			return $buffer;
		}

		public function single($query, $params = null){
			$this->Init($query,$params);
			return $this->sQuery->fetchColumn();
		}

		public function max($table){
			return $this->single("select max(id) as _count from ".$table.";") + 1;
		}

		public function count($table){
			return $this->single("select count(id) as _count from ".$table.";");
		}

	};	
	
	
	class istatistikler extends core{

		public $calc;

		public $host;
		public $port;
		public $name;
		public $user;
		public $pass;
		public $char;
		
		private $pdo;
		private $sQuery;
		private $parameters;

		public function __construct(){
			$this->parameters = array();
		}

		public function __destruct(){
			unset($this->host);
			unset($this->port);
			unset($this->name);
			unset($this->user);
			unset($this->pass);
			unset($this->char);
			unset($this->sQuery);
			unset($this->parameters);
		}

		private function log($mesaj = null, $query = null){
			
			if(getenv("HTTP_CLIENT_IP")){
				$ip = getenv("HTTP_CLIENT_IP");
			} elseif(getenv("HTTP_X_FORWARDED_FOR")){
				$ip = getenv("HTTP_X_FORWARDED_FOR");
				if(strstr($ip, ',')){
					$tmp = explode(',', $ip);
					$ip = trim($tmp[0]);
				};
			} else {
				$ip = getenv("REMOTE_ADDR");
			};

			$use_forwarded_host = false;
			$ssl  = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ? true:false;
			$prot = strtolower($_SERVER['SERVER_PROTOCOL']);
			$prot = substr($prot, 0, strpos($prot, '/')).(($ssl) ? 's' : '');
			$port = $_SERVER['SERVER_PORT'];
			$port = ((!$ssl && $port=='80') || ($ssl && $port=='443')) ? '' : ':'.$port;
			$host = ($use_forwarded_host && isset($_SERVER['HTTP_X_FORWARDED_HOST'])) ? $_SERVER['HTTP_X_FORWARDED_HOST'] : (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : null);
			$host = isset($host) ? $host : $_SERVER['SERVER_NAME'].$port;
			$requ = $_SERVER['REQUEST_URI'];
			$reff = $_SERVER['HTTP_REFERER'];

			$bind = array(
				'id'		=> $this->max('sys_log'),
				'ipadresi'	=> $ip,
				'url'		=> $prot.'://'.$host.$requ,
				'mesaj'		=> $mesaj,
				'query'		=> $query,
				'stamp'		=> time(),
				'yayin'		=> 0
			);
			$this->query("insert into sys_log (id, ipadresi, url, mesaj, query, stamp, yayin) values (:id, :ipadresi, :url, :mesaj, :query, :stamp, :yayin);", $bind);
			return $mesaj;
		}

		public function connect(){
			$dsn = 'mysql:dbname='.$this->name.'; charset='.$this->char.'; host='.$this->host.';';
			try{
				$this->pdo = new PDO($dsn, $this->user, $this->pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES ".$this->char));
				$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
				$this->pdo->exec('SET NAMES '.$this->char.';');
			} catch(PDOException $e){
				return $this->log($e->getMessage());
			};
		}

		public function disconnect(){
			try{
				$this->pdo = null;
			} catch(PDOException $e){
				return $this->log($e->getMessage());
			};
		}
		
		private function Init($query, $parameters = ""){
			try{
				$this->sQuery = $this->pdo->prepare($query);
				$this->bindMore($parameters);
				if(!empty($this->parameters)){
					foreach($this->parameters as $param){
						$parameters = explode("\x7F",$param);
						$this->sQuery->bindParam($parameters[0],$parameters[1]);
					};		
				};
				$this->succes = $this->sQuery->execute();		
			} catch(PDOException $e){
				return $this->log($e->getMessage(), $query);
			};
			$this->parameters = array();
		}

		public function bind($para, $value){	
			$this->parameters[sizeof($this->parameters)] = ":".$para."\x7F".$value;
		}

		public function bindMore($parray){
			if(empty($this->parameters) && is_array($parray)){
				$columns = array_keys($parray);
				foreach($columns as $i => &$column){
					$this->bind($column, $parray[$column]);
				};
			};
		}

		public function query($query, $params = null, $fetchmode = PDO::FETCH_ASSOC){
			$query = trim($query);
			$this->Init($query,$params);
			$rawStatement = explode(" ", $query);
			$statement = strtolower($rawStatement[0]);
			if($statement === 'select' || $statement === 'show'){
				return $this->sQuery->fetchAll($fetchmode);
			} elseif($statement === 'insert' ||  $statement === 'update' || $statement === 'delete'){
				return $this->sQuery->rowCount();	
			} else {
				return NULL;
			};
		}

		public function row($query, $params = null, $fetchmode = PDO::FETCH_ASSOC){
			$this->Init($query,$params);
			return $this->sQuery->fetch($fetchmode);
		}

		public function column($query, $params = null){
			$this->Init($query,$params);
			$Columns = $this->sQuery->fetchAll(PDO::FETCH_NUM);		
			$column = null;
			foreach($Columns as $cells){
				$column[] = $cells[0];
			};
			return $column;
		}

		public function tables(){
			$hash   = $this->query("show tables from ".$this->name.";");
			$buffer = array();
			foreach($hash as $node){
				$buffer[] = $node['Tables_in_'.$this->name];
			};
			return $buffer;
		}

		public function columns($table){
			$hash   = $this->query("show columns from ".$table.";");
			$buffer = array();
			foreach($hash as $node){
				$buffer[] = $node['Field'];
			};
			return $buffer;
		}

		public function single($query, $params = null){
			$this->Init($query,$params);
			return $this->sQuery->fetchColumn();
		}

		public function max($table){
			return $this->single("select max(id) as _count from ".$table.";") + 1;
		}

		public function count($table){
			return $this->single("select count(id) as _count from ".$table.";");
		}

	};	

	
	class kpanel extends core{

		public $calc;

		public $host;
		public $port;
		public $name;
		public $user;
		public $pass;
		public $char;
		
		private $pdo;
		private $sQuery;
		private $parameters;

		public function __construct(){
			$this->parameters = array();
		}

		public function __destruct(){
			unset($this->host);
			unset($this->port);
			unset($this->name);
			unset($this->user);
			unset($this->pass);
			unset($this->char);
			unset($this->sQuery);
			unset($this->parameters);
		}

		private function log($mesaj = null, $query = null){
			
			if(getenv("HTTP_CLIENT_IP")){
				$ip = getenv("HTTP_CLIENT_IP");
			} elseif(getenv("HTTP_X_FORWARDED_FOR")){
				$ip = getenv("HTTP_X_FORWARDED_FOR");
				if(strstr($ip, ',')){
					$tmp = explode(',', $ip);
					$ip = trim($tmp[0]);
				};
			} else {
				$ip = getenv("REMOTE_ADDR");
			};

			$use_forwarded_host = false;
			$ssl  = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ? true:false;
			$prot = strtolower($_SERVER['SERVER_PROTOCOL']);
			$prot = substr($prot, 0, strpos($prot, '/')).(($ssl) ? 's' : '');
			$port = $_SERVER['SERVER_PORT'];
			$port = ((!$ssl && $port=='80') || ($ssl && $port=='443')) ? '' : ':'.$port;
			$host = ($use_forwarded_host && isset($_SERVER['HTTP_X_FORWARDED_HOST'])) ? $_SERVER['HTTP_X_FORWARDED_HOST'] : (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : null);
			$host = isset($host) ? $host : $_SERVER['SERVER_NAME'].$port;
			$requ = $_SERVER['REQUEST_URI'];
			$reff = $_SERVER['HTTP_REFERER'];

			$bind = array(
				'id'		=> $this->max('sys_log'),
				'ipadresi'	=> $ip,
				'url'		=> $prot.'://'.$host.$requ,
				'mesaj'		=> $mesaj,
				'query'		=> $query,
				'stamp'		=> time(),
				'yayin'		=> 0
			);
			$this->query("insert into sys_log (id, ipadresi, url, mesaj, query, stamp, yayin) values (:id, :ipadresi, :url, :mesaj, :query, :stamp, :yayin);", $bind);
			return $mesaj;
		}

		public function connect(){
			$dsn = 'mysql:dbname='.$this->name.'; charset='.$this->char.'; host='.$this->host.';';
			try{
				$this->pdo = new PDO($dsn, $this->user, $this->pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES ".$this->char));
				$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
				$this->pdo->exec('SET NAMES '.$this->char.';');
			} catch(PDOException $e){
				return $this->log($e->getMessage());
			};
		}

		public function disconnect(){
			try{
				$this->pdo = null;
			} catch(PDOException $e){
				return $this->log($e->getMessage());
			};
		}
		
		private function Init($query, $parameters = ""){
			try{
				$this->sQuery = $this->pdo->prepare($query);
				$this->bindMore($parameters);
				if(!empty($this->parameters)){
					foreach($this->parameters as $param){
						$parameters = explode("\x7F",$param);
						$this->sQuery->bindParam($parameters[0],$parameters[1]);
					};		
				};
				$this->succes = $this->sQuery->execute();		
			} catch(PDOException $e){
				return $this->log($e->getMessage(), $query);
			};
			$this->parameters = array();
		}

		public function bind($para, $value){	
			$this->parameters[sizeof($this->parameters)] = ":".$para."\x7F".$value;
		}

		public function bindMore($parray){
			if(empty($this->parameters) && is_array($parray)){
				$columns = array_keys($parray);
				foreach($columns as $i => &$column){
					$this->bind($column, $parray[$column]);
				};
			};
		}

		public function query($query, $params = null, $fetchmode = PDO::FETCH_ASSOC){
			$query = trim($query);
			$this->Init($query,$params);
			$rawStatement = explode(" ", $query);
			$statement = strtolower($rawStatement[0]);
			if($statement === 'select' || $statement === 'show'){
				return $this->sQuery->fetchAll($fetchmode);
			} elseif($statement === 'insert' ||  $statement === 'update' || $statement === 'delete'){
				return $this->sQuery->rowCount();	
			} else {
				return NULL;
			};
		}

		public function row($query, $params = null, $fetchmode = PDO::FETCH_ASSOC){
			$this->Init($query,$params);
			return $this->sQuery->fetch($fetchmode);
		}

		public function column($query, $params = null){
			$this->Init($query,$params);
			$Columns = $this->sQuery->fetchAll(PDO::FETCH_NUM);		
			$column = null;
			foreach($Columns as $cells){
				$column[] = $cells[0];
			};
			return $column;
		}

		public function tables(){
			$hash   = $this->query("show tables from ".$this->name.";");
			$buffer = array();
			foreach($hash as $node){
				$buffer[] = $node['Tables_in_'.$this->name];
			};
			return $buffer;
		}

		public function columns($table){
			$hash   = $this->query("show columns from ".$table.";");
			$buffer = array();
			foreach($hash as $node){
				$buffer[] = $node['Field'];
			};
			return $buffer;
		}

		public function single($query, $params = null){
			$this->Init($query,$params);
			return $this->sQuery->fetchColumn();
		}

		public function max($table){
			return $this->single("select max(id) as _count from ".$table.";") + 1;
		}

		public function count($table){
			return $this->single("select count(id) as _count from ".$table.";");
		}

	};	
	
	
	class yetkiler extends core{

		public $calc;

		public $host;
		public $port;
		public $name;
		public $user;
		public $pass;
		public $char;
		
		private $pdo;
		private $sQuery;
		private $parameters;

		public function __construct(){
			$this->parameters = array();
		}

		public function __destruct(){
			unset($this->host);
			unset($this->port);
			unset($this->name);
			unset($this->user);
			unset($this->pass);
			unset($this->char);
			unset($this->sQuery);
			unset($this->parameters);
		}

		private function log($mesaj = null, $query = null){
			
			if(getenv("HTTP_CLIENT_IP")){
				$ip = getenv("HTTP_CLIENT_IP");
			} elseif(getenv("HTTP_X_FORWARDED_FOR")){
				$ip = getenv("HTTP_X_FORWARDED_FOR");
				if(strstr($ip, ',')){
					$tmp = explode(',', $ip);
					$ip = trim($tmp[0]);
				};
			} else {
				$ip = getenv("REMOTE_ADDR");
			};

			$use_forwarded_host = false;
			$ssl  = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ? true:false;
			$prot = strtolower($_SERVER['SERVER_PROTOCOL']);
			$prot = substr($prot, 0, strpos($prot, '/')).(($ssl) ? 's' : '');
			$port = $_SERVER['SERVER_PORT'];
			$port = ((!$ssl && $port=='80') || ($ssl && $port=='443')) ? '' : ':'.$port;
			$host = ($use_forwarded_host && isset($_SERVER['HTTP_X_FORWARDED_HOST'])) ? $_SERVER['HTTP_X_FORWARDED_HOST'] : (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : null);
			$host = isset($host) ? $host : $_SERVER['SERVER_NAME'].$port;
			$requ = $_SERVER['REQUEST_URI'];
			$reff = $_SERVER['HTTP_REFERER'];

			$bind = array(
				'id'		=> $this->max('sys_log'),
				'ipadresi'	=> $ip,
				'url'		=> $prot.'://'.$host.$requ,
				'mesaj'		=> $mesaj,
				'query'		=> $query,
				'stamp'		=> time(),
				'yayin'		=> 0
			);
			$this->query("insert into sys_log (id, ipadresi, url, mesaj, query, stamp, yayin) values (:id, :ipadresi, :url, :mesaj, :query, :stamp, :yayin);", $bind);
			return $mesaj;
		}

		public function connect(){
			$dsn = 'mysql:dbname='.$this->name.'; charset='.$this->char.'; host='.$this->host.';';
			try{
				$this->pdo = new PDO($dsn, $this->user, $this->pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES ".$this->char));
				$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
				$this->pdo->exec('SET NAMES '.$this->char.';');
			} catch(PDOException $e){
				return $this->log($e->getMessage());
			};
		}

		public function disconnect(){
			try{
				$this->pdo = null;
			} catch(PDOException $e){
				return $this->log($e->getMessage());
			};
		}
		
		private function Init($query, $parameters = ""){
			try{
				$this->sQuery = $this->pdo->prepare($query);
				$this->bindMore($parameters);
				if(!empty($this->parameters)){
					foreach($this->parameters as $param){
						$parameters = explode("\x7F",$param);
						$this->sQuery->bindParam($parameters[0],$parameters[1]);
					};		
				};
				$this->succes = $this->sQuery->execute();		
			} catch(PDOException $e){
				return $this->log($e->getMessage(), $query);
			};
			$this->parameters = array();
		}

		public function bind($para, $value){	
			$this->parameters[sizeof($this->parameters)] = ":".$para."\x7F".$value;
		}

		public function bindMore($parray){
			if(empty($this->parameters) && is_array($parray)){
				$columns = array_keys($parray);
				foreach($columns as $i => &$column){
					$this->bind($column, $parray[$column]);
				};
			};
		}

		public function query($query, $params = null, $fetchmode = PDO::FETCH_ASSOC){
			$query = trim($query);
			$this->Init($query,$params);
			$rawStatement = explode(" ", $query);
			$statement = strtolower($rawStatement[0]);
			if($statement === 'select' || $statement === 'show'){
				return $this->sQuery->fetchAll($fetchmode);
			} elseif($statement === 'insert' ||  $statement === 'update' || $statement === 'delete'){
				return $this->sQuery->rowCount();	
			} else {
				return NULL;
			};
		}

		public function row($query, $params = null, $fetchmode = PDO::FETCH_ASSOC){
			$this->Init($query,$params);
			return $this->sQuery->fetch($fetchmode);
		}

		public function column($query, $params = null){
			$this->Init($query,$params);
			$Columns = $this->sQuery->fetchAll(PDO::FETCH_NUM);		
			$column = null;
			foreach($Columns as $cells){
				$column[] = $cells[0];
			};
			return $column;
		}

		public function tables(){
			$hash   = $this->query("show tables from ".$this->name.";");
			$buffer = array();
			foreach($hash as $node){
				$buffer[] = $node['Tables_in_'.$this->name];
			};
			return $buffer;
		}

		public function columns($table){
			$hash   = $this->query("show columns from ".$table.";");
			$buffer = array();
			foreach($hash as $node){
				$buffer[] = $node['Field'];
			};
			return $buffer;
		}

		public function single($query, $params = null){
			$this->Init($query,$params);
			return $this->sQuery->fetchColumn();
		}

		public function max($table){
			return $this->single("select max(id) as _count from ".$table.";") + 1;
		}

		public function count($table){
			return $this->single("select count(id) as _count from ".$table.";");
		}

	};		
	
	
?>