<?php

	/*
	*
	*
	*
	*/

	class db extends core{

		public $dbDriver;
		public $dbHost;
		public $dbPort;
		public $dbName;
		public $dbUser;
		public $dbPass;
		public $dbChar;
		private $mysql;
		private $mysqli;
		private $pdo;
		
		public function __construct(){
			$this->dbDriver	= $this->config['db']['driver'];
			$this->dbHost 	= $this->config['db']['host'];
			$this->dbPort 	= $this->config['db']['port'];
			$this->dbName 	= $this->config['db']['name'];
			$this->dbUser 	= $this->config['db']['user'];
			$this->dbPass 	= $this->config['db']['pass'];
			$this->dbChar 	= $this->config['db']['char'];
		}

		public function __destruct(){
			unset($this->dbDriver);
			unset($this->dbHost);
			unset($this->dbPort);
			unset($this->dbName);
			unset($this->dbUser);
			unset($this->dbPass);
			unset($this->dbChar);		
			unset($this->mysql);
			unset($this->mysqli);
			unset($this->pdo);
		}

		/* database connect driver */

			private function _mysql(){
				mysql_connect($this->dbHost.':'.$this->dbPort, $this->dbUser, $this->dbPass);
				mysql_select_db($this->dbName, $mysql);
				mysql_query("SET NAMES '".$this->dbChar."';");
				#$this->error(mysql_error());
			}

			private function _pdo(){
				$dsn = 'mysql:dbname='.$this->dbName.'; charset='.$this->dbChar.'; host='.$this->dbHost.';';
				try{
					$this->pdo = new PDO($dsn, $this->dbUser, $this->dbPass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES ".$this->dbChar));
					$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					$this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
					$this->pdo->exec('SET NAMES '.$this->dbChar.';');
				} catch(PDOException $e){
					$this->error($e->getMessage());
				};
			}

		/* database connect driver */

		/* common functions */
			public function max($table){
				return $this->single("select max(id) as _max from ".$table.";") + 1;
			}
			public function count($table){
				return $this->single("select count(id) as _count from ".$table.";");
			}
			public function tables(){
				$hash   = $this->query("show tables from ".$this->dbName.";");
				$buffer = array();
				foreach($hash as $node){
					$buffer[] = $node['Tables_in_'.$this->dbName];
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
			private function error($message){
				return $message;
			}
		/* common functions */
	};
	
	
	class puan extends core{

		public $dbDriver;
		public $dbHost;
		public $dbPort;
		public $dbName;
		public $dbUser;
		public $dbPass;
		public $dbChar;
		private $mysql;
		private $mysqli;
		private $pdo;
		
		public function __construct(){
			$this->dbDriver	= $this->config['db']['driver'];
			$this->dbHost 	= $this->config['db']['host'];
			$this->dbPort 	= $this->config['db']['port'];
			$this->dbName 	= $this->config['db']['name'];
			$this->dbUser 	= $this->config['db']['user'];
			$this->dbPass 	= $this->config['db']['pass'];
			$this->dbChar 	= $this->config['db']['char'];
		}

		public function __destruct(){
			unset($this->dbDriver);
			unset($this->dbHost);
			unset($this->dbPort);
			unset($this->dbName);
			unset($this->dbUser);
			unset($this->dbPass);
			unset($this->dbChar);		
			unset($this->mysql);
			unset($this->mysqli);
			unset($this->pdo);
		}

		/* database connect driver */

			private function _mysql(){
				mysql_connect($this->dbHost.':'.$this->dbPort, $this->dbUser, $this->dbPass);
				mysql_select_db($this->dbName, $mysql);
				mysql_query("SET NAMES '".$this->dbChar."';");
				#$this->error(mysql_error());
			}

			private function _pdo(){
				$dsn = 'mysql:dbname='.$this->dbName.'; charset='.$this->dbChar.'; host='.$this->dbHost.';';
				try{
					$this->pdo = new PDO($dsn, $this->dbUser, $this->dbPass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES ".$this->dbChar));
					$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					$this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
					$this->pdo->exec('SET NAMES '.$this->dbChar.';');
				} catch(PDOException $e){
					$this->error($e->getMessage());
				};
			}

		/* database connect driver */

		/* common functions */
			public function max($table){
				return $this->single("select max(id) as _max from ".$table.";") + 1;
			}
			public function count($table){
				return $this->single("select count(id) as _count from ".$table.";");
			}
			public function tables(){
				$hash   = $this->query("show tables from ".$this->dbName.";");
				$buffer = array();
				foreach($hash as $node){
					$buffer[] = $node['Tables_in_'.$this->dbName];
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
			private function error($message){
				return $message;
			}
		/* common functions */
	};

	
	class faction extends core{

		public $dbDriver;
		public $dbHost;
		public $dbPort;
		public $dbName;
		public $dbUser;
		public $dbPass;
		public $dbChar;
		private $mysql;
		private $mysqli;
		private $pdo;
		
		public function __construct(){
			$this->dbDriver	= $this->config['db']['driver'];
			$this->dbHost 	= $this->config['db']['host'];
			$this->dbPort 	= $this->config['db']['port'];
			$this->dbName 	= $this->config['db']['name'];
			$this->dbUser 	= $this->config['db']['user'];
			$this->dbPass 	= $this->config['db']['pass'];
			$this->dbChar 	= $this->config['db']['char'];
		}

		public function __destruct(){
			unset($this->dbDriver);
			unset($this->dbHost);
			unset($this->dbPort);
			unset($this->dbName);
			unset($this->dbUser);
			unset($this->dbPass);
			unset($this->dbChar);		
			unset($this->mysql);
			unset($this->mysqli);
			unset($this->pdo);
		}

		/* database connect driver */

			private function _mysql(){
				mysql_connect($this->dbHost.':'.$this->dbPort, $this->dbUser, $this->dbPass);
				mysql_select_db($this->dbName, $mysql);
				mysql_query("SET NAMES '".$this->dbChar."';");
				#$this->error(mysql_error());
			}

			private function _pdo(){
				$dsn = 'mysql:dbname='.$this->dbName.'; charset='.$this->dbChar.'; host='.$this->dbHost.';';
				try{
					$this->pdo = new PDO($dsn, $this->dbUser, $this->dbPass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES ".$this->dbChar));
					$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					$this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
					$this->pdo->exec('SET NAMES '.$this->dbChar.';');
				} catch(PDOException $e){
					$this->error($e->getMessage());
				};
			}

		/* database connect driver */

		/* common functions */
			public function max($table){
				return $this->single("select max(id) as _max from ".$table.";") + 1;
			}
			public function count($table){
				return $this->single("select count(id) as _count from ".$table.";");
			}
			public function tables(){
				$hash   = $this->query("show tables from ".$this->dbName.";");
				$buffer = array();
				foreach($hash as $node){
					$buffer[] = $node['Tables_in_'.$this->dbName];
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
			private function error($message){
				return $message;
			}
		/* common functions */
	};	

	
	
	class istatistikler extends core{

		public $dbDriver;
		public $dbHost;
		public $dbPort;
		public $dbName;
		public $dbUser;
		public $dbPass;
		public $dbChar;
		private $mysql;
		private $mysqli;
		private $pdo;
		
		public function __construct(){
			$this->dbDriver	= $this->config['db']['driver'];
			$this->dbHost 	= $this->config['db']['host'];
			$this->dbPort 	= $this->config['db']['port'];
			$this->dbName 	= $this->config['db']['name'];
			$this->dbUser 	= $this->config['db']['user'];
			$this->dbPass 	= $this->config['db']['pass'];
			$this->dbChar 	= $this->config['db']['char'];
		}

		public function __destruct(){
			unset($this->dbDriver);
			unset($this->dbHost);
			unset($this->dbPort);
			unset($this->dbName);
			unset($this->dbUser);
			unset($this->dbPass);
			unset($this->dbChar);		
			unset($this->mysql);
			unset($this->mysqli);
			unset($this->pdo);
		}

		/* database connect driver */

			private function _mysql(){
				mysql_connect($this->dbHost.':'.$this->dbPort, $this->dbUser, $this->dbPass);
				mysql_select_db($this->dbName, $mysql);
				mysql_query("SET NAMES '".$this->dbChar."';");
				#$this->error(mysql_error());
			}

			private function _pdo(){
				$dsn = 'mysql:dbname='.$this->dbName.'; charset='.$this->dbChar.'; host='.$this->dbHost.';';
				try{
					$this->pdo = new PDO($dsn, $this->dbUser, $this->dbPass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES ".$this->dbChar));
					$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					$this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
					$this->pdo->exec('SET NAMES '.$this->dbChar.';');
				} catch(PDOException $e){
					$this->error($e->getMessage());
				};
			}

		/* database connect driver */

		/* common functions */
			public function max($table){
				return $this->single("select max(id) as _max from ".$table.";") + 1;
			}
			public function count($table){
				return $this->single("select count(id) as _count from ".$table.";");
			}
			public function tables(){
				$hash   = $this->query("show tables from ".$this->dbName.";");
				$buffer = array();
				foreach($hash as $node){
					$buffer[] = $node['Tables_in_'.$this->dbName];
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
			private function error($message){
				return $message;
			}
		/* common functions */
	};	
	
	
	class kpanel extends core{

		public $dbDriver;
		public $dbHost;
		public $dbPort;
		public $dbName;
		public $dbUser;
		public $dbPass;
		public $dbChar;
		private $mysql;
		private $mysqli;
		private $pdo;
		
		public function __construct(){
			$this->dbDriver	= $this->config['db']['driver'];
			$this->dbHost 	= $this->config['db']['host'];
			$this->dbPort 	= $this->config['db']['port'];
			$this->dbName 	= $this->config['db']['name'];
			$this->dbUser 	= $this->config['db']['user'];
			$this->dbPass 	= $this->config['db']['pass'];
			$this->dbChar 	= $this->config['db']['char'];
		}

		public function __destruct(){
			unset($this->dbDriver);
			unset($this->dbHost);
			unset($this->dbPort);
			unset($this->dbName);
			unset($this->dbUser);
			unset($this->dbPass);
			unset($this->dbChar);		
			unset($this->mysql);
			unset($this->mysqli);
			unset($this->pdo);
		}

		/* database connect driver */

			private function _mysql(){
				mysql_connect($this->dbHost.':'.$this->dbPort, $this->dbUser, $this->dbPass);
				mysql_select_db($this->dbName, $mysql);
				mysql_query("SET NAMES '".$this->dbChar."';");
				#$this->error(mysql_error());
			}

			private function _pdo(){
				$dsn = 'mysql:dbname='.$this->dbName.'; charset='.$this->dbChar.'; host='.$this->dbHost.';';
				try{
					$this->pdo = new PDO($dsn, $this->dbUser, $this->dbPass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES ".$this->dbChar));
					$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					$this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
					$this->pdo->exec('SET NAMES '.$this->dbChar.';');
				} catch(PDOException $e){
					$this->error($e->getMessage());
				};
			}

		/* database connect driver */

		/* common functions */
			public function max($table){
				return $this->single("select max(id) as _max from ".$table.";") + 1;
			}
			public function count($table){
				return $this->single("select count(id) as _count from ".$table.";");
			}
			public function tables(){
				$hash   = $this->query("show tables from ".$this->dbName.";");
				$buffer = array();
				foreach($hash as $node){
					$buffer[] = $node['Tables_in_'.$this->dbName];
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
			private function error($message){
				return $message;
			}
		/* common functions */
	};
	
	
	
	class yetkiler extends core{

		public $dbDriver;
		public $dbHost;
		public $dbPort;
		public $dbName;
		public $dbUser;
		public $dbPass;
		public $dbChar;
		private $mysql;
		private $mysqli;
		private $pdo;
		
		public function __construct(){
			$this->dbDriver	= $this->config['db']['driver'];
			$this->dbHost 	= $this->config['db']['host'];
			$this->dbPort 	= $this->config['db']['port'];
			$this->dbName 	= $this->config['db']['name'];
			$this->dbUser 	= $this->config['db']['user'];
			$this->dbPass 	= $this->config['db']['pass'];
			$this->dbChar 	= $this->config['db']['char'];
		}

		public function __destruct(){
			unset($this->dbDriver);
			unset($this->dbHost);
			unset($this->dbPort);
			unset($this->dbName);
			unset($this->dbUser);
			unset($this->dbPass);
			unset($this->dbChar);		
			unset($this->mysql);
			unset($this->mysqli);
			unset($this->pdo);
		}

		/* database connect driver */

			private function _mysql(){
				mysql_connect($this->dbHost.':'.$this->dbPort, $this->dbUser, $this->dbPass);
				mysql_select_db($this->dbName, $mysql);
				mysql_query("SET NAMES '".$this->dbChar."';");
				#$this->error(mysql_error());
			}

			private function _pdo(){
				$dsn = 'mysql:dbname='.$this->dbName.'; charset='.$this->dbChar.'; host='.$this->dbHost.';';
				try{
					$this->pdo = new PDO($dsn, $this->dbUser, $this->dbPass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES ".$this->dbChar));
					$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					$this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
					$this->pdo->exec('SET NAMES '.$this->dbChar.';');
				} catch(PDOException $e){
					$this->error($e->getMessage());
				};
			}

		/* database connect driver */

		/* common functions */
			public function max($table){
				return $this->single("select max(id) as _max from ".$table.";") + 1;
			}
			public function count($table){
				return $this->single("select count(id) as _count from ".$table.";");
			}
			public function tables(){
				$hash   = $this->query("show tables from ".$this->dbName.";");
				$buffer = array();
				foreach($hash as $node){
					$buffer[] = $node['Tables_in_'.$this->dbName];
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
			private function error($message){
				return $message;
			}
		/* common functions */
	};
?>