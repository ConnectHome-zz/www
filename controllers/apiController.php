<?php

require_once dirname(__FILE__) . '/../lightmvc/actionController.php';
require_once dirname(__FILE__) . '/../model/connect.php';
require_once dirname(__FILE__) . '/../model/action.php';
require_once dirname(__FILE__) . '/../model/movement.php';
require_once dirname(__FILE__) . '/../model/user.php';
require_once dirname(__FILE__) . '/../model/scenario.php';
require_once dirname(__FILE__) . '/../model/users.php';
require_once dirname(__FILE__) . '/../model/detectMobile.php';
require_once dirname(__FILE__) . '/../model/controller.php';

class APIController extends ActionController {

    public function zibaseAction() {

        if ($_GET['cmd'] == "ip") {//change the IP of the zibase
            $_SESSION["ip_zibase"] = $_POST["ip_zibase"];

            $connect = connection::getInstance();

            //erase table before 
            $sql = "UPDATE zibase SET Ip='" . $_POST["ip_zibase"] . "' WHERE Name='" . $_SESSION['id_zibase'] . "'";
            $req = mysql_query($sql) or die('Erreur SQL !<br>' . $sql . '<br>' . mysql_error());
        }

        if ($_GET['cmd'] == "mdp") {

            $a = "http://zibase.net/m/get_iphone.php?login=" . $_POST['name_zibase'] . "&password=" . $_POST['pswd_zibase'];
            $ch = curl_init($a);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $var = curl_exec($ch);

            curl_close($ch);

            //update database
            if ($var != "") {
                $value = explode(":", $var);

                $_SESSION["id_zibase"] = $value[0];
                $_SESSION["token_zibase"] = $value[1];
                $connect = connection::getInstance();

                //erase table before 
                $sql = "UPDATE zibase SET Name='" . $value[0] . "' WHERE Ip='" . $_SESSION['ip_zibase'] . "'";
                $req = mysql_query($sql) or die('Erreur SQL !<br>' . $sql . '<br>' . mysql_error());

                $sql = "UPDATE zibase SET Token='" . $value[1] . "' WHERE Ip='" . $_SESSION['ip_zibase'] . "'";
                $req = mysql_query($sql) or die('Erreur SQL !<br>' . $sql . '<br>' . mysql_error());
            }
        }

        $this->redirect("/api/settings");
    }

    public function actuatorAction() {

        $connect = connection::getInstance();


        $sql = "truncate table actions";
        //Request sending
        $req = mysql_query($sql) or die('Erreur SQL !<br>' . $sql . '<br>' . mysql_error());

        $sql = "DELETE from contains";
        //Request sending
        $req = mysql_query($sql) or die('Erreur SQL !<br>' . $sql . '<br>' . mysql_error());

        $sql = "DELETE from scenarios";
        //Request sending
        $req = mysql_query($sql) or die('Erreur SQL !<br>' . $sql . '<br>' . mysql_error());

        $add = "http://zibase.net/m/get_xml.php?device=" . $_SESSION["id_zibase"] . "&token=" . $_SESSION["token_zibase"];
        $ch = curl_init($add);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $var = curl_exec($ch);

        curl_close($ch);

        $myxml = simplexml_load_string($var);


        foreach ($myxml->e as $child) {



            if ($child->attributes()->t == 'receiverXDom') {
                $actuator = $child->attributes()->c;
                $name = $child->n;


                $sql = "INSERT INTO actions values('','" . $name . " on" . "','desc','" . $actuator . "','1','adult')";
                $req = mysql_query($sql) or die('Erreur SQL !<br>' . $sql . '<br>' . mysql_error());

                $sql = "INSERT INTO actions values('','" . $name . " off" . "','desc','" . $actuator . "','0','adult')";
                $req = mysql_query($sql) or die('Erreur SQL !<br>' . $sql . '<br>' . mysql_error());
            }
        }


        $this->redirect('/API/settings');
    }

    public function SettingsAction() {
        
    }

    public function ParseXMLAction() {

        $this->_includeTemplate = false;

        $connect = connection::getInstance();

        $date = date("Y-m-d G:i:s");

        /////

        $exp;
        $dest;
        $messtype;
        $IDP;
        $nameP;
        $descP;
        $movID;
        $nameM;
        $descM;




//        if (file_exists('message1.xml')) {
//            $myxml = simplexml_load_file('message1.xml');
//        }
        $msg = '<?xml version="1.0" encoding="iso-8859-1"?>' . $_POST['xml'];
        

        
        print_r($msg);
        $myxml = simplexml_load_string($msg);


        foreach ($myxml->children() as $child) {
            switch ((string) $child->getName()) {
                case 'exp' :
                    $exp = $child;
                    break;
                case 'dest' :
                    $dest = $child;
                    break;
                case 'msgtype' :
                    $messtype = $child;
                    break;
                case 'msg' :
                    if ($messtype == 1) {
                        $ok = 0;
                        $i = 0;
                        foreach ($child->children() as $child2) {
                            switch ($child2->getName()) {
                                case 'ID' :
                                    $IDP = $child2;
                                    break;
                                case 'nameP' :
                                    $nameP = $child2;

                                    //SEARCH IN DB IF CONTROLLER ALREADY EXISTS
                                    $connect = connection::getInstance();
                                    //SQL REQUEST FOR CONTROLLERS

                                    $sql = "SELECT IDC FROM controllers WHERE nameC='" . $nameP . "'";
                                    //sending request
                                    $req = mysql_query($sql) or die('ERROR_SQL');
                                    while ($data = mysql_fetch_assoc($req)) {
                                        // scenario selection
                                        $res[] = $data['IDC']; 
                                        if ($res[0] != 0) {
                                            $ok = 1;
                                        }
                                    }
                                    break;
                                case 'descP' :
                                    if ($ok == 0) {
                                        $descP = $child2;
                                        //INSERT INTO BDD
                                        $connect = connection::getInstance();
                                        //SQL REQUEST FOR CONTROLLERS
                                        $sql = "INSERT INTO controllers VALUES('" . $IDP . "','" . $nameP . "','" . $descP . "','0')";
                                        //sending request
                                        $req = mysql_query($sql) or die('ERROR_SQL');
                                    }
                                    break;
                                case 'mov' :
                                    $i++;
                                    if ($ok == 0) {
                                        foreach ($child2->children() as $child3) {
                                            switch ($child3->getName()) {
                                                case 'movID' :
                                                    $movID[$i] = $child3;
                                                    break;
                                                case 'nameM' :
                                                    $nameM[$i] = $child3;
                                                    break;
                                                case 'descM' :
                                                    $descM[$i] = $child3;
                                                    break;
                                            }
                                        }

                                        //INSERT INTO BDD
                                        $connect = connection::getInstance();
                                        //SQL REQUEST FOR MOVEMENTS
                                        $sql = "INSERT INTO movements VALUES('" . $movID[$i] . "','" . $nameM[$i] . "','" . $descM[$i] . "','" . $IDP . "')";
                                        //sending request
                                        $req = mysql_query($sql) or die('ERROR_SQL');
                                    }
                                    break;
                            }
                        }
                    } else if ($messtype == 2) {
                        //SELECT BDD & GO TO JAJA
                        foreach ($child->children() as $child2) {
                            switch ($child2->getName()) {
                                case 'ID' :
                                    $IDP = $child2;
                                    break;
                                case 'movID' :
                                    $movID = $child2;
                                    //SELECT INTO BDD
                                    $connect = connection::getInstance();

                                    //SQL REQUEST FOR SCENARIOS
                                    $sql = "SELECT IDS FROM scenarios WHERE IDU in(SELECT IDU FROM controllers WHERE IDC ='" . $IDP . "') and IDM='" . $movID . "' and IDC='" . $IDP . "'";
                                    //sending request
                                    $req = mysql_query($sql) or die('Erreur SQL !<br>' . $sql . '<br>' . mysql_error());
                                    while ($data = mysql_fetch_assoc($req)) {
                                        // scenario selection
                                        $res1[] = $data['IDS'];
                                    }

                                    if (isset($res1)) {

                                        $sql = "SELECT nameU from users where IDU in (SELECT IDU FROM controllers WHERE IDC ='" . $IDP . "')";
                                        $req = mysql_query($sql) or die('ERROR_SQL');
                                        while ($data = mysql_fetch_assoc($req)) {
                                            // scenario selection
                                            $name = $data['nameU'];
                                        }

                                        $sql = "INSERT INTO api VALUES('.$movID.','" . $name . "')"; //Add the action to the log
                                        //sending request
                                        $req = mysql_query($sql) or die('ERROR_SQL');

                                        $sql = "INSERT INTO history VALUES('','" . $name . "','" . $date . "')"; //Add the action to the log
                                        //sending request
                                        $req = mysql_query($sql) or die('ERROR_SQL');

                                        //SQL REQUEST FOR MOVEMENTS
                                        $sql = "SELECT * FROM actions JOIN contains on actions.IDA = contains.IDA WHERE IDS = $res1[0] order by IDS";
                                        //sending request
                                        $req = mysql_query($sql) or die('Erreur SQL !<br>' . $sql . '<br>' . mysql_error());
                                        $i = 0;


                                        while ($data = mysql_fetch_assoc($req)) {
                                            // scenario selection
                                            $res[$i]['IDA'] = $data['IDA'];
                                            $res[$i]['nameA'] = $data['nameA'];
                                            $res[$i]['descA'] = $data['descA'];
                                            $res[$i]['actuator'] = $data['actuator'];
                                            $res[$i]['status'] = $data['status'];
                                            $res[$i]['typeA'] = $data['typeA'];
                                            $i++;
                                        }

                                        break;
                                    }
                            }
                        }


                       
                            foreach ($res as $s) {
                               

                                if ($s['status'] == 1)
                                    $on = "ON";
                                else
                                    $on = "OFF";
                                $sql = "SELECT * FROM zibase";
                                $req = mysql_query($sql) or die('Erreur SQL !<br>' . $sql . '<br>' . mysql_error());


                                while ($data = mysql_fetch_assoc($req)) {
                                    // scenario selection
                                    $ip_zibase = $data['Ip'];
                                }
                                $text = "http://" . $ip_zibase . "/cgi-bin/domo.cgi?cmd=" . $on . "%20" . $s['actuator'];


                                $ch = curl_init($text);

                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);


                                $var = curl_exec($ch);


                                curl_close($ch);
                            }

                        break;
                    }
            }
        }
    }

    public function MovementAction() {
        
    }

}

?>
