<?php
/**
* \file      connect.php
* \author    Connect Home
* \version   1.0
* \date      12/04/2013
* \brief     Model of the Connect class
*
* \details   This Model is the code of the Connect class (link to Database)
*            
*/

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
 /** \class Connection */
class connection {

    private static $_instance = null;
    ////
    /**
     * Class constructor
     *
     * @param void
     * @return void
     */
    //Constructor
    private function __construct() {


        $db = mysql_connect('localhost', 'root', '');
        mysql_query("SET NAMES UTF8");
        mysql_select_db('connect_home', $db);
    }

    /**
     * Method which creates a unique instance of the class if doesn't exist
     * and return it
     *
     * @param void
     * @return Singleton
     *\return the instance of the connection
     */
    //Getter
    public static function getInstance() {
        if (is_null(self::$_instance)) {
            self::$_instance = new connection();
        }
        return self::$_instance;
    }
}

?>
