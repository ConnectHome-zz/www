<?php

//file inclusion
require_once dirname(__FILE__) . '/movement.php';
require_once dirname(__FILE__) . '/user.php';
require_once dirname(__FILE__) . '/scenario.php';

class Action {

    //statement of resources
    private $name;
    private $id;
    private $desc;
    private $actuator;
    private $action;
    //private $temps;
    private $adult;
    ////

    /**
     * Class constructor
     *
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
    public function getName() {
        return $this->name;
    }

    public function setName($nom) {
        $this->name = $nom;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getDesc() {
        return $this->desc;
    }

    public function setDesc($desc) {
        $this->desc = $desc;
    }

    public function getActuator() {
        return $this->actuator;
    }

    public function setActuator($actuator) {
        $this->actuator = $actuator;
    }

    public function getAction() {
        return $this->action;
    }

    public function setAction($action) {
        $this->action = $action;
    }

    public function getAdult() {
        return $this->adult;
    }

    public function setAdultt($adult) {
        $this->adult = $adult;
    }

}

?>
