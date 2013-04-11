<?php

//file inclusion
require_once dirname(__FILE__) . '/../lightmvc/actionController.php';
require_once dirname(__FILE__) . '/../model/connect.php';
require_once dirname(__FILE__) . '/../model/action.php';
require_once dirname(__FILE__) . '/../model/movement.php';
require_once dirname(__FILE__) . '/../model/user.php';
require_once dirname(__FILE__) . '/../model/scenario.php'; 
require_once dirname(__FILE__) . '/../model/users.php';
require_once dirname(__FILE__) . '/../model/detectMobile.php';
require_once dirname(__FILE__) . '/../model/controller.php';


class IndexController extends ActionController {

    /**
     * Simple index page which links to the main available actions
     */
    public function indexAction() {

        $connect = connection::getInstance();

        // erase table before 
        $sql = "SELECT * FROM zibase";
        $req = mysql_query($sql) or die('Erreur SQL !<br>' . $sql . '<br>' . mysql_error());


        while ($data = mysql_fetch_assoc($req)) {
            // scenario selection
            $_SESSION["ip_zibase"] = $data['Ip'];
            $_SESSION["id_zibase"] = $data['Name'];
            $_SESSION["token_zibase"] = $data['Token'];
        }


        //captors
        
        $_SESSION['current'] = 'home';
        //give data to view
        $this->members = Users::Getuser();
        $_SESSION['members'] = $this->members;



        // Initialisation Mobile Detect
        $detect = new Mobile_Detect();

        //isComputer
        $_SESSION['computer'] = 1;

        // mobile or tablet    
        if (($detect->isMobile())) {
            $_SESSION['computer'] = 0;
            $this->redirect('/Index/indexPhone');
        }

        $add = "http://zibase.net/m/get_xml.php?device=" . $_SESSION["id_zibase"] . "&token=" . $_SESSION["token_zibase"];
        $ch = curl_init($add);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $var = curl_exec($ch);

        curl_close($ch);
        
        
        $myxml = simplexml_load_string($var);


        foreach ($myxml->e as $child) { 
            if ($child->attributes()->t == 'receiverXDom') {
                $actuator[] = $child->attributes()->c;
                $name[] = $child->n;
            }
        }

        if(isset($name))
            $this->name = $name;
        if(isset($actuator))
            $this->actuator = $actuator;
    }

    public function indexPhoneAction() {
        // members : getFrontProfiles
        $_SESSION['current'] = 'home';
        //give data to view
        $this->members = Users::Getuser();
        $_SESSION['members'] = $this->members;
    }

    public function get_elements() {
        //call to the ZIBASE

        $connect = connection::getInstance();

        $sql = "SELECT * FROM zibase";
        $req = mysql_query($sql) or die('Erreur SQL !<br>' . $sql . '<br>' . mysql_error());


        while ($data = mysql_fetch_assoc($req)) {
            // scenario selection
            $ip_zibase = $data['Ip'];
        }
        $_SESSION["ip_zibase"] = $ip_zibase;
        
        $ch = curl_init("http://zibase.net/m/get_xml_sensors.php?device=ZiBASE0052eb&token=e396697d9c");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $var = curl_exec($ch);
        curl_close($ch);

        $dom = new DomDocument();
        //$dom->load('reponse.xml');

        $dom->loadXML($var);


        $tab[] = "";
        $vars = $dom->getElementsByTagName('ev');

        foreach ($vars as $var) {

            if ($var->getAttribute("type") == 7) {
                $var->getAttribute("vl");
                $tab[] = $var->getAttribute("v1");
            }
        }
        $this->tableau = $tab;
      
    }

}
