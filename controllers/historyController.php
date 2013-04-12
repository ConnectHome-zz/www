<?php

/**
 * \file      historyController.php
 * \author    Connect Home
 * \version   1.0
 * \date      12/04/2013
 * \brief     Control the history pages
 *
 * \details   This controller is used to display the notification
 *            and manage the history pages
 */
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


/**
 * \class HistoryController
 * 
 */
class HistoryController extends ActionController {

    /**
     * A simple function to delete the historic of the actions launched
     */
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

    /**
     *  controller of the page which display the history
     */
    public function indexAction() {
        $toto;
        $_SESSION['current'] = "history";


        //SQL connection
        $connect = connection::getInstance();
        //User SQL request
        $sql = "SELECT * FROM history ";

        //Request sending
        $req = mysql_query($sql) or die('Erreur SQL !<br>' . $sql . '<br>' . mysql_error());
        $hist = "";
        while ($data = mysql_fetch_assoc($req)) {
            $hist[] = $data;
        }
        $this->history = $hist;
    }

    /**
     * Check in database if there is a action launched and throw a pop up
     */
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
        if ($i == 0) {//if nothing
            exit();
        } else {
            //vider la database 
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
