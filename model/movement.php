<?php
/**
* \file      movement.php
* \author    Connect Home
* \version   1.0
* \date      12/04/2013
* \brief     Model of the Movement class
*
* \details   This Model is the code representation of the movements table 
*            in the database
*            
*/

//file inclusion
require_once dirname(__FILE__) . '/action.php';
require_once dirname(__FILE__) . '/user.php';
require_once dirname(__FILE__) . '/scenario.php';

 /** \class Movement */
class Movement {

    //statement of resources
    private $name;
    private $id;
    private $desc;
    private $idc;
    ////
    /**
     * Class constructor
     * \param $_id The ID of the movement
     * \param $_name The name of the movement
     * \param $_desc The description of the movement
     * \param $_idc The ID of the controller enabling this movement
     */
    //Constructor
    public function __construct($_id, $_name, $_desc, $_idc) {

        $this->name = $_name;
        $this->id = $_id;
        $this->desc = $_desc;
        $this->idc = $_idc;
    }

    //Getters and setters
    /** 
    * 
    *\return the name of the movement
    */
    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    /** 
    * 
    *\return the ID of the movement
    */
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    /** 
    * 
    *\return the description of the movement
    */
    public function getDesc() {
        return $this->desc;
    }

    public function setDesc($desc) {
        $this->desc = $desc;
    }
    
    /** 
    * 
    *\return the ID of the controller enabling this movement
    */
    public function getIdc() {
        return $this->idc;
    }

    public function setIdc($idc) {
        $this->idc = $idc;
    }
}

?>
