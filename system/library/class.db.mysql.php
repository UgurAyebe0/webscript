<?php

	/**
	*
	*/

	class db extends core{

		public $host;
		public $port;
		public $name;
		public $user;
		public $pass;
		public $char;
		
		public function __construct(){

		}

		public function __destruct(){
			unset($this->host);
			unset($this->port);
			unset($this->name);
			unset($this->user);
			unset($this->pass);
			unset($this->char);
		}

		public function connect(){
			$conn = mysql_connect($this->host.':'.$this->port, $this->user, $this->pass);
			if(!$conn){
				die('Connection Error: '.mysql_error());
			};
			mysql_select_db($this->name, $conn);
			mysql_query("SET NAMES '".$this->char."';");
		}

		public function bind($query, $bind){
			$query = trim($query);
			if(is_array($bind)){
				foreach($bind as $key => $value){
					$query = str_replace(":".$key, "'".$value."'", $query);
				};
			};
			return $query;
		}

		public function query($query, $bind){
			$sql = mysql_query($this->bind($query, $bind));
			while($row = mysql_fetch_assoc($sql)){
				$buffer[] = $row;
			};
			return $buffer;
		}

		public function row($query, $bind){			
			$sql = mysql_query($this->bind($query, $bind));
			return mysql_fetch_assoc($sql);		
		}

		public function single($query, $bind){
			$sql = mysql_query($this->bind($query, $bind));
			if(stristr($query, " as ")){
				$param = " as ";
			} else {
				$param = "select";
			};
			$start = strpos($query, $param) + strlen($param);
			$stop  = strpos($query, "from") - $start;
			$column = trim(substr($query, $start, $stop));
			$row = mysql_fetch_assoc($sql);
			return $row[$column];
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

		public function max($table){
			return $this->single("select max(id) as _max from ".$table.";") + 1;
		}

		public function count($table){
			return $this->single("select count(id) as _count from ".$table.";");
		}

	};
	
	class puan extends core{

		public $host;
		public $port;
		public $name;
		public $user;
		public $pass;
		public $char;
		
		public function __construct(){

		}

		public function __destruct(){
			unset($this->host);
			unset($this->port);
			unset($this->name);
			unset($this->user);
			unset($this->pass);
			unset($this->char);
		}

		public function connect(){
			$conn = mysql_connect($this->host.':'.$this->port, $this->user, $this->pass);
			if(!$conn){
				die('Connection Error: '.mysql_error());
			};
			mysql_select_db($this->name, $conn);
			mysql_query("SET NAMES '".$this->char."';");
		}

		public function bind($query, $bind){
			$query = trim($query);
			if(is_array($bind)){
				foreach($bind as $key => $value){
					$query = str_replace(":".$key, "'".$value."'", $query);
				};
			};
			return $query;
		}

		public function query($query, $bind){
			$sql = mysql_query($this->bind($query, $bind));
			while($row = mysql_fetch_assoc($sql)){
				$buffer[] = $row;
			};
			return $buffer;
		}

		public function row($query, $bind){			
			$sql = mysql_query($this->bind($query, $bind));
			return mysql_fetch_assoc($sql);		
		}

		public function single($query, $bind){
			$sql = mysql_query($this->bind($query, $bind));
			if(stristr($query, " as ")){
				$param = " as ";
			} else {
				$param = "select";
			};
			$start = strpos($query, $param) + strlen($param);
			$stop  = strpos($query, "from") - $start;
			$column = trim(substr($query, $start, $stop));
			$row = mysql_fetch_assoc($sql);
			return $row[$column];
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

		public function max($table){
			return $this->single("select max(id) as _max from ".$table.";") + 1;
		}

		public function count($table){
			return $this->single("select count(id) as _count from ".$table.";");
		}

	};

	
	class faction extends core{

		public $host;
		public $port;
		public $name;
		public $user;
		public $pass;
		public $char;
		
		public function __construct(){

		}

		public function __destruct(){
			unset($this->host);
			unset($this->port);
			unset($this->name);
			unset($this->user);
			unset($this->pass);
			unset($this->char);
		}

		public function connect(){
			$conn = mysql_connect($this->host.':'.$this->port, $this->user, $this->pass);
			if(!$conn){
				die('Connection Error: '.mysql_error());
			};
			mysql_select_db($this->name, $conn);
			mysql_query("SET NAMES '".$this->char."';");
		}

		public function bind($query, $bind){
			$query = trim($query);
			if(is_array($bind)){
				foreach($bind as $key => $value){
					$query = str_replace(":".$key, "'".$value."'", $query);
				};
			};
			return $query;
		}

		public function query($query, $bind){
			$sql = mysql_query($this->bind($query, $bind));
			while($row = mysql_fetch_assoc($sql)){
				$buffer[] = $row;
			};
			return $buffer;
		}

		public function row($query, $bind){			
			$sql = mysql_query($this->bind($query, $bind));
			return mysql_fetch_assoc($sql);		
		}

		public function single($query, $bind){
			$sql = mysql_query($this->bind($query, $bind));
			if(stristr($query, " as ")){
				$param = " as ";
			} else {
				$param = "select";
			};
			$start = strpos($query, $param) + strlen($param);
			$stop  = strpos($query, "from") - $start;
			$column = trim(substr($query, $start, $stop));
			$row = mysql_fetch_assoc($sql);
			return $row[$column];
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

		public function max($table){
			return $this->single("select max(id) as _max from ".$table.";") + 1;
		}

		public function count($table){
			return $this->single("select count(id) as _count from ".$table.";");
		}

	};
	




	class istatistikler extends core{

		public $host;
		public $port;
		public $name;
		public $user;
		public $pass;
		public $char;
		
		public function __construct(){

		}

		public function __destruct(){
			unset($this->host);
			unset($this->port);
			unset($this->name);
			unset($this->user);
			unset($this->pass);
			unset($this->char);
		}

		public function connect(){
			$conn = mysql_connect($this->host.':'.$this->port, $this->user, $this->pass);
			if(!$conn){
				die('Connection Error: '.mysql_error());
			};
			mysql_select_db($this->name, $conn);
			mysql_query("SET NAMES '".$this->char."';");
		}

		public function bind($query, $bind){
			$query = trim($query);
			if(is_array($bind)){
				foreach($bind as $key => $value){
					$query = str_replace(":".$key, "'".$value."'", $query);
				};
			};
			return $query;
		}

		public function query($query, $bind){
			$sql = mysql_query($this->bind($query, $bind));
			while($row = mysql_fetch_assoc($sql)){
				$buffer[] = $row;
			};
			return $buffer;
		}

		public function row($query, $bind){			
			$sql = mysql_query($this->bind($query, $bind));
			return mysql_fetch_assoc($sql);		
		}

		public function single($query, $bind){
			$sql = mysql_query($this->bind($query, $bind));
			if(stristr($query, " as ")){
				$param = " as ";
			} else {
				$param = "select";
			};
			$start = strpos($query, $param) + strlen($param);
			$stop  = strpos($query, "from") - $start;
			$column = trim(substr($query, $start, $stop));
			$row = mysql_fetch_assoc($sql);
			return $row[$column];
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

		public function max($table){
			return $this->single("select max(id) as _max from ".$table.";") + 1;
		}

		public function count($table){
			return $this->single("select count(id) as _count from ".$table.";");
		}

	};	
	
	
	
	class kpanel extends core{

		public $host;
		public $port;
		public $name;
		public $user;
		public $pass;
		public $char;
		
		public function __construct(){

		}

		public function __destruct(){
			unset($this->host);
			unset($this->port);
			unset($this->name);
			unset($this->user);
			unset($this->pass);
			unset($this->char);
		}

		public function connect(){
			$conn = mysql_connect($this->host.':'.$this->port, $this->user, $this->pass);
			if(!$conn){
				die('Connection Error: '.mysql_error());
			};
			mysql_select_db($this->name, $conn);
			mysql_query("SET NAMES '".$this->char."';");
		}

		public function bind($query, $bind){
			$query = trim($query);
			if(is_array($bind)){
				foreach($bind as $key => $value){
					$query = str_replace(":".$key, "'".$value."'", $query);
				};
			};
			return $query;
		}

		public function query($query, $bind){
			$sql = mysql_query($this->bind($query, $bind));
			while($row = mysql_fetch_assoc($sql)){
				$buffer[] = $row;
			};
			return $buffer;
		}

		public function row($query, $bind){			
			$sql = mysql_query($this->bind($query, $bind));
			return mysql_fetch_assoc($sql);		
		}

		public function single($query, $bind){
			$sql = mysql_query($this->bind($query, $bind));
			if(stristr($query, " as ")){
				$param = " as ";
			} else {
				$param = "select";
			};
			$start = strpos($query, $param) + strlen($param);
			$stop  = strpos($query, "from") - $start;
			$column = trim(substr($query, $start, $stop));
			$row = mysql_fetch_assoc($sql);
			return $row[$column];
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

		public function max($table){
			return $this->single("select max(id) as _max from ".$table.";") + 1;
		}

		public function count($table){
			return $this->single("select count(id) as _count from ".$table.";");
		}

	};	
	
	
	
	class yetkiler extends core{

		public $host;
		public $port;
		public $name;
		public $user;
		public $pass;
		public $char;
		
		public function __construct(){

		}

		public function __destruct(){
			unset($this->host);
			unset($this->port);
			unset($this->name);
			unset($this->user);
			unset($this->pass);
			unset($this->char);
		}

		public function connect(){
			$conn = mysql_connect($this->host.':'.$this->port, $this->user, $this->pass);
			if(!$conn){
				die('Connection Error: '.mysql_error());
			};
			mysql_select_db($this->name, $conn);
			mysql_query("SET NAMES '".$this->char."';");
		}

		public function bind($query, $bind){
			$query = trim($query);
			if(is_array($bind)){
				foreach($bind as $key => $value){
					$query = str_replace(":".$key, "'".$value."'", $query);
				};
			};
			return $query;
		}

		public function query($query, $bind){
			$sql = mysql_query($this->bind($query, $bind));
			while($row = mysql_fetch_assoc($sql)){
				$buffer[] = $row;
			};
			return $buffer;
		}

		public function row($query, $bind){			
			$sql = mysql_query($this->bind($query, $bind));
			return mysql_fetch_assoc($sql);		
		}

		public function single($query, $bind){
			$sql = mysql_query($this->bind($query, $bind));
			if(stristr($query, " as ")){
				$param = " as ";
			} else {
				$param = "select";
			};
			$start = strpos($query, $param) + strlen($param);
			$stop  = strpos($query, "from") - $start;
			$column = trim(substr($query, $start, $stop));
			$row = mysql_fetch_assoc($sql);
			return $row[$column];
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

		public function max($table){
			return $this->single("select max(id) as _max from ".$table.";") + 1;
		}

		public function count($table){
			return $this->single("select count(id) as _count from ".$table.";");
		}

	};	
?>