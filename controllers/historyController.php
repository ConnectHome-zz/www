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

class HistoryController extends ActionController {

    public function resetAction() {
        //SQL connection
        $connect = connection::getInstance();

        //User SQL request
        $sql = "truncate table history";
        //
        //Request sending
        $req = mysql_query($sql) or die('Erreur SQL !<br>' . $sql . '<br>' . mysql_error());
        $this->_includeTemplate = false;
    }

    public function indexAction() {
        $toto;
        $_SESSION['current'] = "history";

        //
        //SQL connection
        $connect = connection::getInstance();
        //User SQL request
        $sql = "SELECT * FROM history ";
        //
        //Request sending
        $req = mysql_query($sql) or die('Erreur SQL !<br>' . $sql . '<br>' . mysql_error());
        $hist = "";
        while ($data = mysql_fetch_assoc($req)) {
            $hist[] = $data;
        }
        $this->history = $hist;
    }

    public function NotificationAction() {

        //check if notif

        $connect = connection::getInstance();

        $sql = "SELECT * FROM api ";
        //Request sending
        $req = mysql_query($sql) or die('Erreur SQL !<br>' . $sql . '<br>' . mysql_error());

        $i = 0;
        while ($data = mysql_fetch_assoc($req)) {
            $hist[] = $data;
            $i++;
        }
        if ($i == 0) {//si rien
            exit();
        } else {
            $sql = "truncate table api";
            $req = mysql_query($sql) or die('Erreur SQL !<br>' . $sql . '<br>' . mysql_error());

            $sql = "SELECT * from movements where IDM=" . $hist[0]['idAP'];
            $req = mysql_query($sql) or die('Erreur SQL !<br>' . $sql . '<br>' . mysql_error());

            while ($data = mysql_fetch_assoc($req)) {
                $this->move = $data['nameM'];
            }
            $this->name = $hist[0]['NameAP'];
        }
        $this->_includeTemplate = false;
    }

}

?>
