<?php
/*
 * Librairie PHP ZiBase
 * Permet de contrôler la zibase depuis un site PHP
 * Compatible avec la ZAPI 1.13 ZODIANET
 * Auteur : Benjamin GAREL
 * Juin 2011
 * Màj Nov. 2012 - Nicolas Wälti
 * @version 1.9.3
 * @package ZiBase
 */
 
 /**
  * Enum des protocoles Zibase
  */
  final class ZbProtocol {  	
  	const PRESET = 0;
 	const VISONIC433 = 1;
  	const VISONIC868 = 2;
  	const CHACON = 3;
  	const DOMIA = 4;
  	const X10 = 5;
  	const ZWAVE = 6;
  	const RFS10 = 7;
  	const X2D433 = 8;
  	const X2D433ALRM = 8;  	
  	const X2D868 = 9;
  	const X2D868ALRM = 9;
  	const X2D868INSH = 10;
  	const X2D868PIWI = 11;
  	const X2D868BOAC = 12;
  }
 
 /**
  * Enum des sondes virtuelles
  */
 final class ZbVirtualProbe {
 	const OREGON = 17;
 	const OWL = 20; 	
 } 
 
 /**
  * Enum des actions possibles par la Zibase
  */
  final class ZbAction {
  	const OFF = 0;
  	const ON = 1;
  	const DIM_BRIGHT = 2;
  	const ALL_LIGHTS_ON = 4;
  	const ALL_LIGHTS_OFF = 5;
  	const ALL_OFF = 6;
  	const ASSOC = 7;
  }
 
 /**
  * Représente une variable calendrier de la Zibase
  */
 final class ZbCalendar {
 	/**
 	 * Tableau représentant de 0h à 23h:
 	 * 0 => inactif
 	 * 1 => actif
 	 */
 	public $hour = array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
 	
 	/**
 	 * Tableau représentant chaque jour de la semaine :
 	 * 0 => inactif
 	 * 1 => actif
 	 */
 	public $day = array("lundi" => 0, "mardi" => 0, "mercredi" => 0, "jeudi" => 0, "vendredi" => 0, "samedi" => 0, "dimanche" => 0);
 	
 	/**
 	 * Créer un objet Zbcalendar à partir d'un entier long (32bits)
 	 * @param int entier provenant de la zibase
 	 * @return ZbCalendar Variable calendrier
 	 */
 	public static function createFromInteger($data) { 		
 		$calendar = new ZbCalendar();
 		for ($i = 0; $i < 24; $i++) {
 			$calendar->hour[$i] = ($data & pow(2,$i)) >> $i;
 		}
 		$calendar->day["lundi"] = ($data & pow(2,24)) >> 24;
 		$calendar->day["mardi"] = ($data & pow(2,25)) >> 25;
 		$calendar->day["mercredi"] = ($data & pow(2,26)) >> 26;
 		$calendar->day["jeudi"] = ($data & pow(2,27)) >> 27;
 		$calendar->day["vendredi"] = ($data & pow(2,28)) >> 28;
 		$calendar->day["samedi"] = ($data & pow(2,29)) >> 29;
 		$calendar->day["dimanche"] = ($data & pow(2,30)) >> 30;
 		return $calendar; 		
 	}
 	
 	/**
 	 * Retourne l'entier 32bits représentant ce calendrier
 	 * @return int l'entier formaté pour la zibase
 	 */
 	public function toInteger() {
 		$data = 0x00000000;
 		for ($i = 0; $i < 24; $i++) { 			
 			$data |= $this->hour[$i] << $i;
 		}
 		$data |= $this->day["lundi"] << 24;
 		$data |= $this->day["mardi"] << 25;
 		$data |= $this->day["mercredi"] << 26;
 		$data |= $this->day["jeudi"] << 27;
 		$data |= $this->day["vendredi"] << 28;
 		$data |= $this->day["samedi"] << 29;
 		$data |= $this->day["dimanche"] << 30;
 		return $data;
 	}
 }
 
 /**
  * Requête spécifique pour la Zibase
  */
 final class ZbRequest {
 	
 	public $header = "ZSIG";
 	public $command = 0;
 	public $reserved1 = null;
 	public $zibaseId = null;
 	public $reserved2 = null;
 	public $param1 = 0;
 	public $param2 = 0;
 	public $param3 = 0;
 	public $param4 = 0;
 	public $myCount = 0;
 	public $yourCount = 0;
 	public $message = null;
 	
 	/**
 	 * Formate la requête en chaîne binaire compatible Zibase
 	 * @return la chaîne binaire
 	 */
 	public function toBinaryArray()	{ 		
    
	    $data = $this->header;
	    	    
	    $ltemp = $this->command;	    
	    $data .= pack("n", $ltemp);
	   	    	    
	    $strTemp = $this->reserved1;
	    $data .= str_pad($strTemp, 16, chr(0));
	    
	    $strTemp = $this->zibaseId;
	    $data .= str_pad($strTemp, 16, chr(0));
	    
	    $strTemp = $this->reserved2;
	    $data .= str_pad($strTemp, 12, chr(0));
	    	   
	    $ltemp = $this->param1;
	    $data .= pack("N", $ltemp);
	    
	    $ltemp = $this->param2;
	    $data .= pack("N", $ltemp);
	    
	    $ltemp = $this->param3;
	    $data .= pack("N", $ltemp);
	    
	    $ltemp = $this->param4;
	    $data .= pack("N", $ltemp);
	    
	    $ltemp = $this->myCount;
	    $data .= pack("n", $ltemp);
	    
	    $ltemp = $this->yourCount;
	    $data .= pack("n", $ltemp);
	    
	    if ($this->message != null) {
	    	$strTemp .= $this->message;
	    	$data .= str_pad($strTemp, 96, chr(0));	    	
	    }
	    	    
	    return $data;
 	}	
 }
 
 /**
  * Réponse spécifique de la Zibase
  */
 final class ZbResponse {
 	public $header = null;
 	public $command = 0;
 	public $reserved1 = null;
 	public $zibaseId = null;
 	public $reserved2 = null;
 	public $param1 = 0;
 	public $param2 = 0;
 	public $param3 = 0;
 	public $param4 = 0;
 	public $myCount = 0;
 	public $yourCount = 0;
 	public $message = null;
 	
 	/**
 	 * Construit la réponse à partir des données binaires envoyées par la Zibase 	
 	 */
 	public function __construct($buffer) { 		
    
	    $data = unpack("c4header/ncommand/c16reserved1/c16zibaseId/c12reserved2/Nparam1/Nparam2/Nparam3/Nparam4/nmyCount/nyourCount/c*message", $buffer);
	    
	    $this->header = substr($buffer, 0, 4);	    
	    $this->command = $data["command"];
	    $this->reserved1 = substr($buffer, 6, 16);
	    $this->zibaseId = substr($buffer, 22, 16);
	    $this->reserved2 = substr($buffer, 38, 12);
	    $this->param1 = $data["param1"];
	    $this->param2 = $data["param2"];
	    $this->param3 = $data["param3"];
	    $this->param4 = $data["param4"];
	    $this->myCount = $data["myCount"];
	    $this->yourCount = $data["yourCount"];
	    $this->message = substr($buffer, 70);	    
 	}	
 }
 
 
 /**
  * Permet de manipuler la ZiBase.
  * Il est nécessaire de connaître l'adresse IP de sa zibase pour l'utiliser.
  */
 final class ZiBase {
 	
 	public $ip; 	
 	private $port = 49999;
 	public $timeZone = "Europe/Paris";
 	
 	/**
 	 * @param string $ipAddr Adresse IP de la zibase
 	 */
 	public function __construct($ipAddr) {
 		$this->ip = $ipAddr;
 	}
 	
 	/**
 	 * Envoie la requête à la Zibase sur le réseau
 	 * @param ZbRequest requête au format Zibase
 	 * @return ZbResponse réponse de la zibase
 	 */
 	private function sendRequest($request, $withResponse = true) { 	
 		$buffer = $request->toBinaryArray();
 		$socket = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
 		$ack = "";
 		$response = null;
 		socket_sendto($socket, $buffer, strlen($buffer), 0, $this->ip, $this->port);
 		if ($withResponse) {
 			socket_recvfrom($socket, $ack, 512, 0, $this->ip, $this->port);
 			if (strlen($ack) > 0) { 	
 				$response = new ZbResponse($ack);
 			}
 		}	
 		socket_close($socket);
 		return $response;
 	}
 	
 	/**
 	 * Lance la commande RF de l'actionneur spécifié par son adresse et son protocol 
 	 * @param string $address Adresse au format X10 de l'actionneur (ex: B5)
 	 * @param int $action Action à réaliser (Utiliser l'enum ZbAction) 
 	 * @param int $protocol Protocole RF (Utiliser l'enum ZbProtocol)
 	 * @param int $dimLevel Non supporté par la zibase pour l'instant
 	 * @param int $nbBurst Nombre d'émissions RF
 	 */
 	public function sendCommand($address, $action, $protocol = ZbProtocol::PRESET, $dimLevel = 0, $nbBurst = 1) { 		  
		if (strlen($address) > 1) {
		  $address = strtoupper($address);
		  $request = new ZbRequest();
		  $request->command = 11;
		  
		  if ($action == ZbAction::DIM_BRIGHT && $dimLevel == 0)
		  	$action = 0;
		  
		  $request->param2 = $action;
		  $request->param2 |= ($protocol & 0xFF) << 0x08;
		  if ($action == ZbAction::DIM_BRIGHT)
		  	$request->param2 |= (dimLevel & 0xFF) << 0x10;
		  if ($nbBurst > 1)
		  	$request->param2 |= ($nbBurst & 0xFF) << 0x18;
	        
	      $request->param3 = intval(substr($address, 1)) - 1;
	      $request->param4 = ord($address[0]) - 0x41;
	      
	      $this->sendRequest($request);
 		}
 	}
 	
 	/**
 	 * Lance le scenario spécifié par son numéro.
 	 * Le numéro du scenario est indiqué entre parenthèse
 	 * dans le suivi d'activité de la console de configuration.
 	 * @param int $numScenario Le numéro du scenario
 	 */
 	public function runScenario($numScenario) {
	  $request = new ZbRequest();
	  $request->command = 11;
	  $request->param1 = 1;
	  $request->param2 = $numScenario;
      $this->sendRequest($request);	
 	}
	
 	/**
 	 * Enregistre une machine en tant qu'écouteur
 	 * @param string $ip l'adresse IP de l'écouteur
	 * @param int $port le port sur lequel écouter, par défaut 49999
 	 */	
	public function registerListener($ip,$port=49999) {
 		$request = new ZbRequest();
		$request->command = 13;
		$request->param1 = ip2long($ip);
		$request->param2 = $port;
		$request->param3 = 0;
		$request->param4 = 0;
    	$this->sendRequest($request,false);
 	}
	
 	/**
 	 * Désenregistre une machine en tant qu'écouteur
 	 * @param string $ip l'adresse IP de l'écouteur
	 * @param int $port le port sur lequel écouter, par défaut 49999
 	 */	
	public function deregisterListener($ip,$port=49999) {
 		$request = new ZbRequest();
		$request->command = 22;
		$request->param1 = ip2long($ip);
		$request->param2 = $port;
		$request->param3 = 0;
		$request->param4 = 0;
    	$this->sendRequest($request,false);
 	}	
 	
 	/**
 	 * Récupère la valeur d'une variable Vx de la Zibase
 	 * @param int $numVar le numéro de la variable (0 à 19)
 	 * @return int la valeur de la variable demandée
 	 */
 	public function getVariable($numVar) {
 		$request = new ZbRequest();
		$request->command = 11;
		$request->param1 = 5;
		$request->param3 = 0;
		$request->param4 = $numVar;
    	$response = $this->sendRequest($request);
 		if ($response != null)
 			return $response->param1;
 		else
 			return null;
 	}
 	
 	/**
 	 * Récupère la valeur d'un calendrier dynamique de la Zibase
 	 * @param int $numCal le numéro du calendrier (1 à 16)
 	 * @return ZbCalendar le calendrier demandé
 	 */
 	public function getCalendar($numCal) {
 		$request = new ZbRequest();
		$request->command = 11;
		$request->param1 = 5;
		$request->param3 = 2;
		$request->param4 = $numCal - 1;
    	$response = $this->sendRequest($request);    	
 		if ($response != null)
 			return ZbCalendar::createFromInteger($response->param1);
 		else
 			return null;
 	}
 	
 	/**
 	 * Récupère l'état d'un actionneur.
 	 * La zibase ne recoit que les ordres RF et non les ordres CPL X10,
 	 * donc l'état d'un actionneur X10 connu par la zibase peut être erronné.
 	 * @param string adresse au format X10 de l'actionneur
	 * @param boolean indique si c'est un actionneur ZWave (car le message envoyé à la zibase est différent)
 	 * @return int l'état : 0=OFF, 1=ON
 	 */
 	public function getState($address, $isZWave = false) {
 		if (strlen($address) > 1) { 		
	 		$address = strtoupper($address);
	 		$request = new ZbRequest();
			$request->command = 11;
			$request->param1 = 5;
			$request->param3 = 4;
			
			$houseCode = ord($address[0]) - 0x41;
			$device = intval(substr($address, 1)) - 1;
		    $request->param4 = $device;
		    $request->param4 |= ($houseCode & 0x0F) << 0x04;		
			
			// Pour le zwave, il faut mettre le 9e bit à 1
			if ($isZWave)
				$request->param4 |= 0x0100;
			
	    	$response = $this->sendRequest($request);
	 		if ($response != null)
	 			return $response->param1;
	 		else
	 			return null;
 		}
 	}
 	
 	/**
 	 * Met à jour une variable Zibase avec la valeur spécifiée
 	 * @param int numéro de la variable (0 à 19)
 	 * @param int valeur à écrire 	 
 	 */
 	public function setVariable($numVar, $value) {
 		
 		$request = new ZbRequest();
		$request->command = 11;
		$request->param1 = 5;
		$request->param3 = 1;		
		$request->param4 = $numVar;	
	    $request->param2 = $value & 0xFFFF;
	    
    	$this->sendRequest($request); 		
 	}
 	
 	/**
 	 * Met à jour le contenu d'un calendrier dynamique de la Zibase
 	 * @param int $numCal le numéro du calendrier (1 à 16)
 	 * @param ZbCalendar le calendrier à écrire
 	 */
 	public function setCalendar($numCal, $calendar) {
 		$request = new ZbRequest();
		$request->command = 11;
		$request->param1 = 5;
		$request->param3 = 3;
		$request->param4 = $numCal - 1;
		$request->param2 = $calendar->toInteger();
    	$this->sendRequest($request); 		
 	}
 	
 	/**
 	 * Retourne les valeurs v1 et v2 du capteur spécifié
 	 * ainsi que la date heure du relevé.
 	 * Pour les sondes Oregon et TS10, il faut diviser v1 par 10.
 	 * Ex: pour le THGR228N : v1 = température x 10 et v2 = % d'humidité
 	 * ***
 	 * Peut aussi être utilisé pour récupérer la dernier état d'un capteur de présence
 	 * X10Secure, Chacon.
 	 * Pour les capteurs X10 : Utiliser la méthode getX10SensorInfo()
 	 * Ex: pour le MS18 : $idSensor = XS15425145 pour triggered et = XS15425144 pour reset
 	 * @param string Identifiant de la sonde
 	 * @return array de la forme [0 => date du relevé (de type DateTime), 1 => V1, 2 => V2] 
 	 */
 	public function getSensorInfo($idSensor) {
 		$url = "http://" . $this->ip . "/sensors.xml";
 		$handle = fopen($url, "rb");
 		$xmlContent = stream_get_contents($handle);
 		fclose($handle);
 		
 		$type = substr($idSensor, 0, 2);
 		$number = substr($idSensor, 2);
 		$xmlDoc = simplexml_load_string($xmlContent);
 		$node = $xmlDoc->xpath("//ev[@id='".$number."' and @pro='".$type."']"); 		
 		if ($node != null && $node[0]) { 			
 			$info = array();
 			date_default_timezone_set($this->timeZone);
 			$dateSensor = new DateTime();
 			$attributes = $node[0]->attributes();
 			//date_timestamp_set($dateSensor, intval($attributes["gmt"]));
 			$dateSensor->setTime(date("H", intval($attributes["gmt"])), date("i", intval($attributes["gmt"])), date("s", intval($attributes["gmt"])));
 			$info[0] = $dateSensor;
 			$info[1] = intval($attributes["v1"]);
 			$info[2] = intval($attributes["v2"]); 			
 			return $info;
 		}
 		else
 			return null; 		
 	} 	
 	
 	/**
 	 * Lance l'exécution d'un script.
 	 * Ex : lm [mon scenario] (= lance le scenarion "mon scenario")
 	 * Ex : lm 2 aft 3600 (= lance le scenario 2 dans une heure)
 	 * Ex : lm [test1].lm [test2] (= lance test1 puis test2)
 	 * @param string Script à exécuter par la zibase  
 	 */
 	public function execScript($script) {
	 	if (strlen($script) > 0) {
			$request = new ZbRequest();
			$request->command = 16;		  
			$request->message = "cmd: ".$script;
		    $this->sendRequest($request, false);
		}	
 	}
 	
 	/**
 	 * Envoi à la zibase des valeurs v1 et v2 d'une sonde virtuelle
 	 * @param int l'identifiant de la sonde virtuelle
 	 * @param int Valeur 1
 	 * @param int Valeur 2
 	 * @param int indicateur de batterie (OK = 0, faible = 1)
 	 * @param ZbVirtualProbe Type de sonde (Oregon par défaut)
 	 */
 	public function sendVirtualProbeValues($idProbe, $value1, $value2, $lowBattery = 0, $probeType = ZbVirtualProbe::OREGON) {
 		$request = new ZbRequest();
		$request->command = 11;		  
		$request->param1 = 6;
		$request->param2 = $idProbe;
		$request->param3 = $value1;
		$request->param3 |= ($value2 & 0xFF) << 0x10;
		$request->param3 |= ($lowBattery & 0xFF) << 0x1A;
		$request->param4 = $probeType;		
		$this->sendRequest($request); 		
 	}
 	
 	/**
 	 * Retourne la date du relevé d'un capteur X10 (comme le MS13)
 	 * @param string Identifiant de la sonde
 	 * @param string "ON" = Dernier relevé de la valeur ON
 	 * 				 "OFF" = Dernier relevé de la valeur OFF
 	 * @return date du relevé (de type DateTime) 
 	 */
 	public function getX10SensorInfo($sensorAddress, $OnOff) {
 		$url = "http://" . $this->ip . "/sensors.xml";
 		$handle = fopen($url, "rb");
 		$xmlContent = stream_get_contents($handle);
 		fclose($handle);
 		
 		$number = ((ord($sensorAddress[0]) - 0x41)*16) + (intval(substr($sensorAddress, 1)) - 1);
 		$type = "X10_" . strtoupper($OnOff);
 		
 		$xmlDoc = simplexml_load_string($xmlContent);
 		$node = $xmlDoc->xpath("//ev[@id='".$number."' and @pro='".$type."']"); 		
 		if ($node != null && $node[0]) { 			
 			$info = array();
 			date_default_timezone_set($this->timeZone);
 			$dateSensor = new DateTime();
 			$attributes = $node[0]->attributes();
 			//date_timestamp_set($dateSensor, intval($attributes["gmt"]));
 			$dateSensor->setTime(date("H", intval($attributes["gmt"])), date("i", intval($attributes["gmt"])), date("s", intval($attributes["gmt"]))); 						
 			return $dateSensor;
 		}
 		else
 			return null; 		
 	} 	
 	
 	/**
 	 * Retourne les valeurs v1 et v2 du capteur spécifié
 	 * ainsi que la date heure du relevé depuis un site zibase sur internet.
 	 * Pour les sondes Oregon et TS10, il faut diviser v1 par 10.
 	 * Ex: pour le THGR228N : v1 = température x 10 et v2 = % d'humidité
 	 * @param string URL de la page internet où se trouve les infos
 	 * Ex: http://zibase.net/m/get_xml_sensors.php?device=ZiBASExxx&token=yyyyyyyy
 	 * @param string Identifiant de la sonde
 	 * @return array de la forme [0 => date du relevé (de type DateTime), 1 => V1, 2 => V2] 
 	 */
 	public function getSensorInfoFromInternet($url, $idSensor) { 		
 		$handle = fopen($url, "rb");
 		$xmlContent = stream_get_contents($handle);
 		fclose($handle);
 		
 		$type = substr($idSensor, 0, 2);
 		$number = substr($idSensor, 2); 		
 		$xmlDoc = simplexml_load_string($xmlContent);
 		$node = $xmlDoc->xpath("//ev[@id='".$number."']"); 		
 		if ($node != null && $node[0]) { 			
 			$info = array();
 			date_default_timezone_set($this->timeZone);
 			$dateSensor = new DateTime();
 			$attributes = $node[0]->attributes();
 			//date_timestamp_set($dateSensor, intval($attributes["gmt"]));
 			$dateSensor->setTime(date("H", intval($attributes["gmt"])), date("i", intval($attributes["gmt"])), date("s", intval($attributes["gmt"])));
 			$info[0] = $dateSensor;
 			$info[1] = intval($attributes["v1"]);
 			$info[2] = intval($attributes["v2"]); 			
 			return $info;
 		}
 		else
 			return null; 		
 	} 	
 	
 }
 
?>

