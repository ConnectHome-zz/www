<?php
/**
* \file      users.php
* \author    Connect Home
* \version   1.0
* \date      12/04/2013
* \brief     Model of the Users class
*
* \details   This Model is the representation of the users in the system 
*            
*            
*/

//file inclusion
require_once dirname(__FILE__) . '/action.php';
require_once dirname(__FILE__) . '/movement.php';
require_once dirname(__FILE__) . '/user.php';
require_once dirname(__FILE__) . '/scenario.php';
require_once dirname(__FILE__) . '/controller.php';

 /** \class Users */
class Users {

//We declare the function
    /** 
    * 
    *\param $var The variable from the form to secure
    */
    public static function secure($var) {

        //Clean the variable

        $foo = htmlentities(strip_tags($var));

        return $foo;
    }

    /** 
    * 
    *\return the list of users
    */
    public static function Getuser() {
        ////
        //statement of resources
        $user = array();

        //SQL connection
        $connect = connection::getInstance();

        //User SQL request
        $sql = "select * from users"; //We get all the users
        //
        //Request sending
        $req = mysql_query($sql) or die('Erreur SQL !<br>' . $sql . '<br>' . mysql_error());

        while ($data = mysql_fetch_assoc($req)) {
            //user creation
            $users[$data['IDU']] = new User($data['nameU'], $data['IDU'], $data['typeU'], $data['admin'], $data['password']);
        }
        $_SESSION['members'] = $users;

        return $users;
    }

    /** 
    * 
    *\return the list of movements
    */
    public static function getMovement() {

        //SQL connection
        $connect = connection::getInstance();
        $sql = "select* from movements"; //We get all the movements
        //Request sending
        $req = mysql_query($sql) or die('Erreur SQL !<br>' . $sql . '<br>' . mysql_error());

        $movements[] = "";
        while ($data = mysql_fetch_assoc($req)) {
            //Scenario creation
            $movements [] = new Movement($data['IDM'], $data['nameM'], $data['descM'], $data['IDC']);
        }
        $_SESSION['movement'] = $movements;

        return $movements;
    }

    /** 
    * 
    *\return the list of controllers
    */
    public static function getController() {

        //SQL connection
        $connect = connection::getInstance();
        $sql = "select* from controllers"; //We get all the movements
        //Request sending
        $req = mysql_query($sql) or die('Erreur SQL !<br>' . $sql . '<br>' . mysql_error());

        while ($data = mysql_fetch_assoc($req)) {
            //Scenario creation
            $controllers [] = new Controller($data['IDC'], $data['nameC'], $data['descC'], $data['IDU']);
        }
        if (isset($controllers)) {
            $_SESSION['controllers'] = $controllers;

            return $controllers;
        }
        else
            return null;
    }

    /** 
    * 
    *\return the list of actions
    */
    public static function getAction() {

        //statement of resources
        $actions = array();

        //SQL connection
        $connect = connection::getInstance();

        //Action SQL request
        $sql = "select* from actions";
        //Request sending
        $req = mysql_query($sql) or die('Erreur SQL !<br>' . $sql . '<br>' . mysql_error());

        while ($data = mysql_fetch_assoc($req)) {
            //Action creation
            $actions[] = new Action($data['IDA'], $data['nameA'], $data['descA'], $data['actuator'], $data['status'], $data['typeA']);
        }

        return $actions;
    }

    /** 
    * 
    *\param $id The ID of the user
    */
    public static function deleteMember($id = -1) {     //Delete a member
        $result = Users::secure($id);     //Get the id
        //SQL connection
        $connect = connection::getInstance();
        //SQL request DELETE
        $sql = "Delete FROM users where IDU = '$result'";
        //Request sending
        $req = mysql_query($sql) or die('Erreur SQL !<br>' . $sql . '<br>' . mysql_error());
    }

    /** 
    * 
    *\param $id The ID of the scenario
    */
    public static function deleteScenario($id = -1) {   //Delete a scenario
        $result = Users::secure($id);     //Get the id
        //SQL connection
        $connect = connection::getInstance();
        //SQL request DELETE
        $sql = "Delete FROM scenarios where IDS = '$result'";     //Delete scenario
        //Request sending
        $req = mysql_query($sql) or die('Erreur SQL !<br>' . $sql . '<br>' . mysql_error());
    }

}

?>
