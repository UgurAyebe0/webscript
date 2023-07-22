<?php

	/*
	*
	*
	*
	*/

	class core{

		public  $config;
		public  $log;
		public  $sanitize;
		public  $db;
		public  $puan;
		public  $faction;
		public  $istatistikler;
		public  $crypt;
		public  $security;
		public  $tool;
		public  $dispatcher;
		public  $calc;
		public  $cart;
		public  $seo;
		public  $bootstrap;
		public  $xml;
		public  $xml_core;
		public  $cache;
		public  $payment;
		public  $order;
		public  $graph;

		private $exists;
			
		public function __construct(){

			ini_set('memory_limit', '1G');

			// server should keep session data for AT LEAST 1 hour
			ini_set('session.gc_maxlifetime', 14400);

			// each client should remember their session id for EXACTLY 1 hour
			session_set_cookie_params(14400);

			session_start();

			#error_reporting(E_ALL ^ E_NOTICE);
			  
			error_reporting(0);

			#$_SESSION['pulse']['lim']	= 0;
			#$_SESSION['pulse']['num']	= 10;
			#$_SESSION['pulse']['sort']	= "asc";

			$this->exists = array();

			$this->prepare();

			$this->create();

		}

		public function __destruct(){
			unset($this);	
		}

		private function prepare(){

			if(!defined('PDO::ATTR_DRIVER_NAME'))	$this->exists[] = ' - PDO';
			#if(!class_exists('memcache'))			$this->exists[] = ' - Memcache';
			#if(!class_exists('memcached'))			$this->exists[] = ' - Memcached';
			if(!function_exists('curl_version'))	$this->exists[] = ' - cURL';

			if(count($this->exists) > 0){
				$error  = "Asagida belirtilen eklentiler bulunamadi:";
				$error .= "<br />";
				foreach($this->exists as $msg){
					$error .= $msg;
					$error .= "<br />";
				};
				echo $error;
				exit();
			};

		}

		private function getIp($type = 'global'){
			$ip = array();
			$ip['local'] = $_SERVER['REMOTE_ADDR'];
			if(getenv("HTTP_CLIENT_IP")){
				$ip['global'] = getenv("HTTP_CLIENT_IP");
			} elseif(getenv("HTTP_X_FORWARDED_FOR")){
				$ip['global'] = getenv("HTTP_X_FORWARDED_FOR");
				if(strstr($ip['global'], ',')){
					$tmp = explode(',', $ip['global']);
					$ip['global'] = trim($tmp[0]);
				};
			} else {
				$ip['global'] = getenv("REMOTE_ADDR");
			};
			return $ip[$type];
		}

		private function create(){
			/* ------- config ------- */

				require_once('config/config.php');
				$this->config = new config();
				$this->config = $this->config->get();

			/* ------- config ------- */

			/* ------ sanitize ------ */

				require_once('library/class.sanitize.php');
				$this->sanitize	= new sanitize();

			/* ------ sanitize ------ */

			/* -------- calc -------- */

				require_once('library/class.calc.php');
				$this->calc = new calc();

			/* -------- calc -------- */

			/* ------ database ------ */

				switch($this->config['db']['driver']){
					case 'mysql':	require_once('library/class.db.mysql.php');	break;
					default:		require_once('library/class.db.pdo.php');	break;
				};
				
				$this->db 		= new db();
				$this->db->calc = $this->calc;
				$this->db->host = $this->config['db']['host'];
				$this->db->port = $this->config['db']['port'];
				$this->db->name = $this->config['db']['name'];

				

				$this->db->user = $this->config['db']['user'];
				$this->db->pass = $this->config['db']['pass'];
				$this->db->char = $this->config['db']['char'];
				$this->db->connect();
				
				#####
				switch($this->config['puan']['driver']){
					case 'mysql':	require_once('library/class.db.mysql.php');	break;
					default:		require_once('library/class.db.pdo.php');	break;
				};
				
				$this->puan 		= new puan();
				$this->puan->calc = $this->calc;
				$this->puan->host = $this->config['puan']['host'];
				$this->puan->port = $this->config['puan']['port'];
				$this->puan->name = $this->config['puan']['name'];


				$this->puan->user = $this->config['puan']['user'];
				$this->puan->pass = $this->config['puan']['pass'];
				$this->puan->char = $this->config['puan']['char'];
				$this->puan->connect();
				
				#####
				switch($this->config['faction']['driver']){
					case 'mysql':	require_once('library/class.db.mysql.php');	break;
					default:		require_once('library/class.db.pdo.php');	break;
				};
				
				$this->faction 		= new faction();
				$this->faction->calc = $this->calc;
				$this->faction->host = $this->config['faction']['host'];
				$this->faction->port = $this->config['faction']['port'];
				$this->faction->name = $this->config['faction']['name'];



				$this->faction->user = $this->config['faction']['user'];
				$this->faction->pass = $this->config['faction']['pass'];
				$this->faction->char = $this->config['faction']['char'];
				$this->faction->connect();
				
				#####
				switch($this->config['istatistikler']['driver']){
					case 'mysql':	require_once('library/class.db.mysql.php');	break;
					default:		require_once('library/class.db.pdo.php');	break;
				};
				
				$this->istatistikler 		= new istatistikler();
				$this->istatistikler->calc = $this->calc;
				$this->istatistikler->host = $this->config['istatistikler']['host'];
				$this->istatistikler->port = $this->config['istatistikler']['port'];
				$this->istatistikler->name = $this->config['istatistikler']['name'];



				$this->istatistikler->user = $this->config['istatistikler']['user'];
				$this->istatistikler->pass = $this->config['istatistikler']['pass'];
				$this->istatistikler->char = $this->config['istatistikler']['char'];
				$this->istatistikler->connect();
				
				#####
				switch($this->config['kpanel']['driver']){
					case 'mysql':	require_once('library/class.db.mysql.php');	break;
					default:		require_once('library/class.db.pdo.php');	break;
				};
				
				$this->kpanel 		= new kpanel();
				$this->kpanel->calc = $this->calc;
				$this->kpanel->host = $this->config['kpanel']['host'];
				$this->kpanel->port = $this->config['kpanel']['port'];
				$this->kpanel->name = $this->config['kpanel']['name'];



				$this->kpanel->user = $this->config['kpanel']['user'];
				$this->kpanel->pass = $this->config['kpanel']['pass'];
				$this->kpanel->char = $this->config['kpanel']['char'];
				$this->kpanel->connect();
				
				
				#####
				switch($this->config['yetkiler']['driver']){
					case 'mysql':	require_once('library/class.db.mysql.php');	break;
					default:		require_once('library/class.db.pdo.php');	break;
				};
				
				$this->yetkiler 		= new yetkiler();
				$this->yetkiler->calc = $this->calc;
				$this->yetkiler->host = $this->config['yetkiler']['host'];
				$this->yetkiler->port = $this->config['yetkiler']['port'];
				$this->yetkiler->name = $this->config['yetkiler']['name'];



				$this->yetkiler->user = $this->config['yetkiler']['user'];
				$this->yetkiler->pass = $this->config['yetkiler']['pass'];
				$this->yetkiler->char = $this->config['yetkiler']['char'];
				$this->yetkiler->connect();
				

			/* ------ database ------ */

			/* -------- crypt ------- */

				require_once('library/class.crypt.php');
				$this->crypt = new crypt();

			/* -------- crypt ------- */

			/* ------ security ------ */

				require_once('library/class.security.php');
				$this->security 	= new security();
				$this->security->db = $this->db;

			/* ------ security ------ */

			/* -------- tool -------- */

				require_once('library/class.tool.php');
				$this->tool 	  = new tool();
				$this->tool->db   = $this->db;
				$this->tool->calc = $this->calc;

			/* -------- tool -------- */

			/* ----- dispatcher ----- */

				require_once('library/class.dispatcher.php');
				$this->dispatcher = new dispatcher();

			/* ----- dispatcher ----- */

			/* --------- log -------- */

				require_once('library/class.log.php');
				$this->log             = new log();
				$this->log->db         = $this->db;
				$this->log->tool       = $this->tool;
				$this->log->dispatcher = $this->dispatcher;

			/* --------- log -------- */

			/* -------- cart -------- */

				require_once('library/class.cart.php');
				$this->cart         = new cart();
				$this->cart->config = $this->config;
				$this->cart->db     = $this->db;
				$this->cart->calc   = $this->calc;

			/* -------- cart -------- */

			/* --------- seo -------- */

				require_once('library/class.seo.php');
				$this->seo 			= new seo();
				$this->seo->config 	= $this->config;

			/* --------- seo -------- */

			/* ------ bootstrap ----- */

				require_once('library/class.bootstrap.php');
				$this->bootstrap 				= new bootstrap();
				$this->bootstrap->config 		= $this->config;
				$this->bootstrap->dispatcher 	= $this->dispatcher;
				$this->bootstrap->security 		= $this->security;
				$this->bootstrap->db 			= $this->db;
				$this->bootstrap->seo 			= $this->seo;
				$this->bootstrap->calc 			= $this->calc;
				$this->bootstrap->tool 			= $this->tool;

			/* ------ bootstrap ----- */

			/* --------- xml -------- */

				require_once('library/class.xml.php');
				$this->xml		 = new xml();
				$this->xml->db 	 = $this->db;
				$this->xml->seo  = $this->seo;
				$this->xml->log  = $this->log;
				$this->xml->calc = $this->calc;

			/* --------- xml -------- */

			/* ------ xml core ------ */

				require_once('library/class.xml.core.php');
				$this->xml_core		  = new xml_core();
				$this->xml_core->db   = $this->db;
				$this->xml_core->seo  = $this->seo;
				$this->xml_core->log  = $this->log;
				$this->xml_core->calc = $this->calc;

			/* ------ xml core ------ */

			/* -------- cache ------- */

				#require_once('library/class.cache.php');
				#$this->cache             = new cache();
				#$this->cache->memcache   = new memcache();
				#$this->cache->memcached  = new memcached();
				#$this->cache->config     = $this->config;
				#$this->cache->crypt      = $this->crypt;
				#$this->cache->dispatcher = $this->dispatcher;

			/* -------- cache ------- */

			/* -------- mail -------- */

				require_once('mailer/PHPMailerAutoload.php');
				$this->phpmailer = new PHPMailer;

				require_once('library/class.mail.php');
				$this->mail 		   = new mail();
				$this->mail->config    = $this->config;
				$this->mail->mailer    = $this->phpmailer;
				$this->mail->db        = $this->db;
				$this->mail->seo       = $this->seo;
				$this->mail->calc      = $this->calc;
				$this->mail->bootstrap = $this->bootstrap;

			/* -------- mail -------- */

			/* ------- payment ------ */

				require_once('library/class.payment.php');
				$this->payment		   = new payment();
				$this->payment->config = $this->config;
				$this->payment->db 	   = $this->db;
				$this->payment->tool   = $this->tool;
				$this->payment->cart   = $this->cart;
				$this->payment->calc   = $this->calc;
				$this->payment->mail   = $this->mail;
				$this->payment->log    = $this->log;

			/* ------- payment ------ */

			/* -------- order ------- */

				require_once('library/class.order.php');
				$this->order			= new order();
				$this->order->config	= $this->config;
				$this->order->db		= $this->db;
				$this->order->bootstrap	= $this->bootstrap;

			/* -------- order ------- */

			/* -------- graph ------- */

				require_once('library/class.graph.php');
				$this->graph = new graph();

			/* -------- graph ------- */
			
			
		}

	};

	$core = new core();
	
	
function GetIP(){
	if(getenv("HTTP_CLIENT_IP")) {
		$ip = getenv("HTTP_CLIENT_IP");
	}
	elseif(getenv("HTTP_X_FORWARDED_FOR"))
	{
		$ip = getenv("HTTP_X_FORWARDED_FOR");
		if (strstr($ip, ',')) {
			$tmp = explode (',', $ip);
			$ip = trim($tmp[0]);
		} 
	} 
	else { 
		$ip = getenv("REMOTE_ADDR");
	}
	return $ip; 
}

function Sifrele($veri) {
	$char=array_merge(range('0', '9'), range('a', 'f'));
	$maxCharIndex = count($char) - 1;
	$salt="";
	for ($i = 0; $i < 16; ++$i) {
		$salt .= $char[mt_rand(0, $maxCharIndex)];
	}
	$s1='$SHA$' . $salt . '$' . hash('sha256', hash('sha256', $veri). $salt);
	return $s1;
}

function SifreleSite($veri) {
	$s1 = md5($veri);
	$s2 = sha1($s1);
	$s3 = crc32($s2);
	return $s3;
}

function uuidFromString($string) {
    $val = md5($string, true);
    $byte = array_values(unpack('C16', $val));

    $tLo = ($byte[0] << 24) | ($byte[1] << 16) | ($byte[2] << 8) | $byte[3];
    $tMi = ($byte[4] << 8) | $byte[5];
    $tHi = ($byte[6] << 8) | $byte[7];
    $csLo = $byte[9];
    $csHi = $byte[8] & 0x3f | (1 << 7);

    if (pack('L', 0x6162797A) == pack('N', 0x6162797A)) {
        $tLo = (($tLo & 0x000000ff) << 24) | (($tLo & 0x0000ff00) << 8) | (($tLo & 0x00ff0000) >> 8) | (($tLo & 0xff000000) >> 24);
        $tMi = (($tMi & 0x00ff) << 8) | (($tMi & 0xff00) >> 8);
        $tHi = (($tHi & 0x00ff) << 8) | (($tHi & 0xff00) >> 8);
    }

    $tHi &= 0x0fff; 
    $tHi |= (3 << 12);
   
    $uuid = sprintf(
        '%08x-%04x-%04x-%02x%02x-%02x%02x%02x%02x%02x%02x',
        $tLo, $tMi, $tHi, $csHi, $csLo,
        $byte[10], $byte[11], $byte[12], $byte[13], $byte[14], $byte[15]
    );
    return $uuid;
}

function Uuid($string)
{
    $string = uuidFromString("OfflinePlayer:".$string);
    return $string;
}
function Kontrol($nick){
	return preg_match('/[^a-zA-Z0-9_]/', $nick);
}
function KontrolSifre($sifre) {
	if (preg_match('/[^a-zA-Z0-9_]/', $sifre)) {
		return true;
    }
    else {
        return false;
    }
} 

function EmailKontrol($email){
      $pattern = "^[_a-z0-9-]+(.[_a-z0-9-]+)*@[a-z0-9-]+(.[a-z0-9-]+)*(.[a-z]{2,3})$";
      if (eregi($pattern, $email)){
         return true;
      }
      else {
         return false;
      }
}
function TemizVeri($mVar){
	if(is_array($mVar)){ 
	foreach($mVar as $gVal => $gVar){
	if(!is_array($gVar)){
	$mVar[$gVal] = htmlspecialchars(strip_tags(urldecode(mysql_real_escape_string(addslashes(stripslashes(stripslashes(trim(htmlspecialchars_decode($gVar)))))))));
	}else{ 
	$mVar[$gVal] = TemizVeri($gVar);
	}
	}
	}else{
	$mVar = htmlspecialchars(strip_tags(urldecode(mysql_real_escape_string(addslashes(stripslashes(stripslashes(trim(htmlspecialchars_decode($mVar)))))))));
	}
	return $mVar; 
}

	$db = new PDO("mysql:host=localhost;port=3306;dbname=candycra_candy_db;charset=utf8;", "candycra_sitee", "B6KrBxbDPR9z");
	$kpanel = new PDO("mysql:host=localhost;port=3306;dbname=candycra_kpanel;charset=utf8;", "candycra_sitee", "B6KrBxbDPR9z");
	$faction = new PDO("mysql:host=localhost;port=3306;dbname=candycra_Faction;charset=utf8;", "candycra_serverver", "F7k6dRbqyG6F");
	$istatistikler = new PDO("mysql:host=localhost;port=3306;dbname=candycra_Istatikler;charset=utf8;", "candycra_serverver", "F7k6dRbqyG6F");
	$lobi = new PDO("mysql:host=localhost;port=3306;dbname=candycra_Lobi;charset=utf8;", "candycra_serverver", "F7k6dRbqyG6F");
	$oyunlar = new PDO("mysql:host=localhost;port=3306;dbname=candycra_Oyunlar;charset=utf8;", "candycra_serverver", "F7k6dRbqyG6F");
	$puan = new PDO("mysql:host=localhost;port=3306;dbname=candycra_Puan;charset=utf8;", "candycra_serverver", "F7k6dRbqyG6F");
	$skyblock = new PDO("mysql:host=localhost;port=3306;dbname=candycra_SkyBlock;charset=utf8;", "candycra_serverver", "F7k6dRbqyG6F");
	$skypvp = new PDO("mysql:host=localhost;port=3306;dbname=candycra_SkyPvP;charset=utf8;", "candycra_serverver", "F7k6dRbqyG6F");
	$yetkiler = new PDO("mysql:host=localhost;port=3306;dbname=candycra_Yetkiler;charset=utf8;", "candycra_serverver", "F7k6dRbqyG6F");
	$bungeecord = new PDO("mysql:host=localhost;port=3306;dbname=candycra_BungeeCord;charset=utf8;", "candycra_serverver", "F7k6dRbqyG6F");
	
	$domain = 'http://185.160.30.205/';


?>