<?php
/**
* \file      user.php
* \author    Connect Home
* \version   1.0
* \date      12/04/2013
* \brief     Model of the User class
*
* \details   This Model is the code representation of the users table 
*            in the database
*            
*/

//file inclusion
require_once dirname(__FILE__) . '/action.php';
require_once dirname(__FILE__) . '/movement.php';
require_once dirname(__FILE__) . '/scenario.php';

 /** \class Movement */
class User {

    //statement of resources
    private $name;
    private $id;
    private $adult;
    private $isadmin;
    private $password;
    private $scenarios;
    private $movements;
    ////
    /**
     * Class constructor
     * \param $_name The name of the user
     * \param $_id The ID of the user
     * \param $_adult The age of the user
     * \param $_isadmin The type of the user
     * \param $_password The password of the user
     */
    //Constructor
    public function __construct($_name, $_id, $_adult, $_isadmin, $_password) {

        $this->name = $_name;
        $this->id = $_id;
        $this->adult = $_adult;
        $this->isadmin = $_isadmin;
        $this->password = $_password;
        $this->scenarios = array();
        $this->movements = array();

        //SQL connection
        $connect = connection::getInstance();
        //Scenario SQL request
        $sql = "select* from scenarios where IDU = $this->id "; //We get all the scenarios
        //Request sending
        $req = mysql_query($sql) or die('Erreur SQL !<br>' . $sql . '<br>' . mysql_error());
        while ($data = mysql_fetch_assoc($req)) {
            //Scenarios creation
            $this->scenarios[] = new Scenario($data['IDS'], $data['nameS'], $data['descS'], $data['IDM'],$data['IDC'], $data['IDU']);
        }
        
        //Movements SQL request
        $sql = "select* from movements"; //We get all the movements
        //Request sending
        $req = mysql_query($sql) or die('Erreur SQL !<br>' . $sql . '<br>' . mysql_error());
        
        while ($data = mysql_fetch_assoc($req)) {
            //Movement creation
            $this->movements[] = new Movement($data['IDM'], $data['nameM'], $data['descM'], $data['IDC']);
        }
    }

    //Getters and setters
    /** 
    * 
    *\return the name of the user
    */
    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    /** 
    * 
    *\return the ID of the user
    */
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    /** 
    * 
    *\return the age of the user
    */
    public function getAdult() {
        return $this->adult;
    }

    public function setAdultt($adult) {
        $this->adult = $adult;
    }

    /** 
    * 
    *\return the type of the user
    */
    public function getIsadmin() {
        return $this->isadmin;
    }

    public function setIsadmin($isadmin) {
        $this->isadmin = $isadmin;
    }

    /** 
    * 
    *\return the password of the user
    */
    public function getPassword() {
        return $this->password;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    /** 
    * 
    *\return the scenarios of the user
    */
    public function getScenarios() {
        return $this->scenarios;
    }

    public function setScenarios($scenarios) {
        $this->scenarios = $scenarios;
    }
    
    /** 
    * 
    *\return the movements of the user
    */
    public function getMovements() {
        return $this->movements;
    }

    public function setMovements($movements) {
        $this->movments = $movments;
    }
}

?>
