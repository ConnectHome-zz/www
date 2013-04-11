<?php

//file inclusion
require_once dirname(__FILE__) . '/action.php';
require_once dirname(__FILE__) . '/movement.php';
require_once dirname(__FILE__) . '/user.php';

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
     *
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

    public function getActions() {
        return $this->actions;
    }

    public function setActions($actions) {
        $this->actions = $actions;
    }

    public function getMovement() {
        return $this->movement;
    }

    public function setMovement($movement) {
        $this->movement = $movement;
    }

    public function getDesc() {
        return $this->desc;
    }

    public function setDesc($desc) {
        $this->desc = $desc;
    }
}

?>
