<?php

//file inclusion
require_once dirname(__FILE__) . '/action.php';
require_once dirname(__FILE__) . '/user.php';
require_once dirname(__FILE__) . '/scenario.php';

class Movement {

    //statement of resources
    private $name;
    private $id;
    private $desc;
    private $idc;
    ////
    /**
     * Class constructor
     *
     */
    //Constructor
    public function __construct($_id, $_name, $_desc, $_idc) {

        $this->name = $_name;
        $this->id = $_id;
        $this->desc = $_desc;
        $this->idc = $_idc;
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

    public function getDesc() {
        return $this->desc;
    }

    public function setDesc($desc) {
        $this->desc = $desc;
    }
    
    public function getIdc() {
        return $this->idc;
    }

    public function setIdc($idc) {
        $this->idc = $idc;
    }
}

?>
