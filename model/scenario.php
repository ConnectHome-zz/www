<?php
/**
* \file      scenario.php
* \author    Connect Home
* \version   1.0
* \date      12/04/2013
* \brief     Model of the Scenario class
*
* \details   This Model is the code representation of the scenarios table 
*            in the database
*            
*/

//file inclusion
require_once dirname(__FILE__) . '/action.php';
require_once dirname(__FILE__) . '/movement.php';
require_once dirname(__FILE__) . '/user.php';

 /** \class Movement */
class Scenario {

    //statement of resources
    private $name;
    private $id;
    //private $adulte;
    private $actions;
    private $movement;
    private $desc;
    private $controller;
    ////
    /**
     * Class constructor
     * \param $_id The ID of the scenario
     * \param $_name The name of the scenario
     * \param $_desc The description of the scenario
     * \param $_idmovement The ID of the movement launching this scenario
     * \param $_idcontroller The ID of the controller launching this scenario
     * \param $_iduser The ID of the user managing this scenario
     */
    //Constructor
    public function __construct($_id, $_name, $_desc, $_idmovement,$_idcontroller, $_iduser) {

        $this->name = $_name;
        $this->controller = $_idcontroller;
        $this->id = $_id;
        $this->desc = $_desc;
        $this->iduse = $_iduser;
        $this->actions = array();
        
        //SQL connection
        $connect = connection::getInstance();
        //SQL request
        $sql = "select * from actions left join contains on actions.IDA = contains.IDA where IDS = $this->id order by IDS"; //on recupere toutes les actions
        //Request sending
        $req = mysql_query($sql) or die('Erreur SQL !<br>' . $sql . '<br>' . mysql_error());

        while ($data = mysql_fetch_assoc($req)) {
            // actions creation
            $this->actions[] = new Action($data['IDA'], $data['nameA'], $data['descA'], $data['actuator'], $data['status'], $data['typeA']);
        }
       
        

        //SQL movement request
        $sql = "select * from movements where IDM  = $_idmovement and IDC = $_idcontroller";    //We get the movement
        //Request sending
        $req = mysql_query($sql) or die('Erreur SQL !<br>' . $sql . '<br>' . mysql_error());

        while ($data = mysql_fetch_assoc($req)) {
            //Movement creation
            $this->movement = new Movement($data['IDM'], $data['nameM'], $data['descM'], $data['IDC']);
        }
    }

    //Getters and setters
    /** 
    * 
    *\return the name of the scenario
    */
    public function getName() {
        return $this->name;
    }
    
    /**
     * 
     * set the name of the scenario
     */
    public function setName($name) {
        $this->name = $name;
    }

    /** 
    * 
    *\return the ID of the scenario
    */
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    /** 
    * 
    *\return the actions of the scenario
    */
    public function getActions() {
        return $this->actions;
    }

    public function setActions($actions) {
        $this->actions = $actions;
    }

    /** 
    * 
    *\return the movements of the scenario
    */
    public function getMovement() {
        return $this->movement;
    }

    public function setMovement($movement) {
        $this->movement = $movement;
    }

    /** 
    * 
    *\return the description of the scenario
    */
    public function getDesc() {
        return $this->desc;
    }

    public function setDesc($desc) {
        $this->desc = $desc;
    }
}

?>
