<?php
/**
* \file      controller.php
* \author    Connect Home
* \version   1.0
* \date      12/04/2013
* \brief     Model of the Controller class
*
* \details   This Model is the code representation of the controllers table 
*            in the database
*            
*/

//file inclusion
require_once dirname(__FILE__) . '/action.php';
require_once dirname(__FILE__) . '/user.php';
require_once dirname(__FILE__) . '/scenario.php';

 /** \class Controller */
class Controller {

    //statement of resources
    private $name;
    private $id;
    private $desc;
    private $user;
    ////
    /**
     * Class constructor
     * \param $_id The ID of the controller
     * \param $_name The name of the controller
     * \param $_desc The description of the controller
     * \param $_user The ID of the user controlling it
     */
    //Constructor
    public function __construct($_id, $_name, $_desc, $_user) {

        $this->name = $_name;
        $this->id = $_id;
        $this->desc = $_desc;
        $this->user = $_user;
    }

    //Getters and setters
    /** 
    * 
    *\return the name of the controller
    */
    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    /** 
    * 
    *\return the ID of the controller
    */
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    /** 
    * 
    *\return the decription of the controller
    */
    public function getDesc() {
        return $this->desc;
    }

    public function setDesc($desc) {
        $this->desc = $desc;
    }
    
    /** 
    * 
    *\return the ID of the user controlling it
    */
    public function getUser() {
        return $this->user;
    }

    public function setUser($user) {
        $this->user = $user;
    }
}

?>
