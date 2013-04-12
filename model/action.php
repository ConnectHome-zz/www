<?php
/**
* \file      action.php
* \author    Connect Home
* \version   1.0
* \date      12/04/2013
* \brief     Model of the Action class
*
* \details   This Model is the code representation of the actions table 
*            in the database
*/

//file inclusion
require_once dirname(__FILE__) . '/movement.php';
require_once dirname(__FILE__) . '/user.php';
require_once dirname(__FILE__) . '/scenario.php';

 /** \class Action */
class Action {

    //statement of resources
    private $name;
    private $id;
    private $desc;
    private $actuator;
    private $action;
    private $adult;
    ////

    /**
     * Class constructor
     *
     *\param $_id The ID of the action
     *\param $_name The name of the action
     *\param $_desc The description of the action
     *\param $_actuator The actuator related to this action
     *\param $_action The status of the action
     *\param $_adult The action type
     */
    //Constructor
    public function __construct($_id, $_name, $_desc, $_actuator, $_action, $_adult) {

        $this->name = $_name;
        $this->id = $_id;
        $this->desc = $_desc;
        $this->actuator = $_actuator;
        $this->action = $_action;
        $this->adult = $_adult;
    }

    //Getters and setters
    /** 
    * 
    *\return the name of the action
    */
    public function getName() {
        return $this->name;
    }
    
    public function setName($nom) {
        $this->name = $nom;
    }

    /** 
    * 
    *\return the ID of the action
    */
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    /** 
    * 
    *\return the description of the action
    */
    public function getDesc() {
        return $this->desc;
    }

    public function setDesc($desc) {
        $this->desc = $desc;
    }

    /** 
    * 
    *\return the actuator of the action
    */
    public function getActuator() {
        return $this->actuator;
    }

    public function setActuator($actuator) {
        $this->actuator = $actuator;
    }

    /** 
    * 
    *\return the status of the action
    */
    public function getAction() {
        return $this->action;
    }

    public function setAction($action) {
        $this->action = $action;
    }

    /** 
    * 
    *\return the type allowed (age) for this action 
    */
    public function getAdult() {
        return $this->adult;
    }

    public function setAdultt($adult) {
        $this->adult = $adult;
    }
}

?>
