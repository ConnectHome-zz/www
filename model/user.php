<?php

//file inclusion
require_once dirname(__FILE__) . '/action.php';
require_once dirname(__FILE__) . '/movement.php';
require_once dirname(__FILE__) . '/scenario.php';

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
     *
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
    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getAdult() {
        return $this->adult;
    }

    public function setAdultt($adult) {
        $this->adult = $adult;
    }

    public function getIsadmin() {
        return $this->isadmin;
    }

    public function setIsadmin($isadmin) {
        $this->isadmin = $isadmin;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function getScenarios() {
        return $this->scenarios;
    }

    public function setScenarios($scenarios) {
        $this->scenarios = $scenarios;
    }
    
    public function getMovements() {
        return $this->movements;
    }

    public function setMovements($movements) {
        $this->movments = $movments;
    }
}

?>
