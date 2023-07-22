<?php
	class sanitize extends core{		
		public function __construct(){		
		}
		public function __destruct(){
		}
		public function clear($buffer){
			return htmlspecialchars(strip_tags(trim($buffer)));
		}
		public function data($param){
			if(is_array($param)){
				$buffer = array();
				foreach($param as $key => $value){
					$buffer[$key] = $this->clear($value);
				};
				return $buffer;
			} else {
				return $this->clear($param);
			};
		}
	};
?>