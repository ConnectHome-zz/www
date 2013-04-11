<?php

//file inclusion
require_once dirname(__FILE__) . '/../lightmvc/actionController.php';
require_once dirname(__FILE__) . '/../model/connect.php';
require_once dirname(__FILE__) . '/../model/action.php';
require_once dirname(__FILE__) . '/../model/movement.php';
require_once dirname(__FILE__) . '/../model/user.php';
require_once dirname(__FILE__) . '/../model/scenario.php';
require_once dirname(__FILE__) . '/../model/users.php';
require_once dirname(__FILE__) . '/../model/detectMobile.php';
require_once dirname(__FILE__) . '/../model/controller.php';


class MembersController extends ActionController {

    /**
     * Simple index page which links to the main available actions
     */
    public function indexAction() {
        // members : getFrontProfiles
        $_SESSION['current'] = 'members';
        $this->members = $this->getMembers(); //give data to view
        $_SESSION['members'] = $this->members;
    }

    public function getMembers() {

        //statement of resources
        $user = array();

        //sql connection
        $connect = connection::getInstance();

        //user sql request
        $sql = "SELECT* FROM users";
        //sending request



        $req = mysql_query($sql) or die('Erreur SQL !<br>' . $sql . '<br>' . mysql_error());

        while ($data = mysql_fetch_assoc($req)) {
            //scenario creation
            $data['nameU'] = Users::secure($data['nameU']);
            $data['IDU'] = Users::secure($data['IDU']);
            $data['typeU'] = Users::secure($data['typeU']);
            $data['admin'] = Users::secure($data['admin']);
            $data['password'] = Users::secure($data['password']);

            $users[] = new User($data['nameU'], $data['IDU'], $data['typeU'], $data['admin'], $data['password']);
        }

        return $users;
    }

    public function deleteAction() {
        if (isset($_SESSION['Connected']))
            if (($_SESSION['Connected'] == 1) and ($_SESSION['admin'] == 1))//secure
                Users::deleteMember($_GET['id']);

        $this->redirect("/Members/index");
    }

    public function editionAction() {//ajax for edit member
       
        //inactivate header/footer
        $this->_includeTemplate = false;

        if ($_GET['checkboxAd'] == 'false') {
            $typeU = "child";
        } else {
            $typeU = "adult";
        }
        
        if ($_GET['checkboxAdmin'] == 'false') {
            $admin = "0";
        } else {
            $admin = "1";
        }

        //test to know if the user already exists
        $cpt = true;
        foreach ($_SESSION['members'] as $member) {

            if (($_GET['Name'] == $member->getName()) && ($_GET['CurrName'] != $member->getName() )) {
                $cpt = false;
                
            }
        }

        //if user doesn't exist
        if ($cpt) {
            //sql connection
            
            if ($_SESSION['Name'] == $_GET['CurrName'])//Current edit current
                $_SESSION['Name'] = $_GET['Name'];

            $connect = connection::getInstance();
            $_GET['Name'] = Users::secure($_GET['Name']);
            $_GET['Pass'] = Users::secure($_GET['Pass']);
            $_GET['Id'] = Users::secure($_GET['Id']);
            
            $sql = "UPDATE users SET nameU='" . $_GET['Name'] . "', typeU='" . $typeU . "',password='" . $_GET['Pass'] . "', admin='" . $admin . "' where IDU ='" . $_GET['Id'] . "'"; //on recupere tout les utilisateurs
            //sending request
            $req = mysql_query($sql) or die('Erreur SQL !<br>' . $sql . '<br>' . mysql_error());

            //appel
            $_SESSION['admin'] = $admin;
            $_SESSION['current'] = 'members';
            $this->members = Users::Getuser(); //give data to view
        } else {
            $this->members = $_SESSION['members']; //give data to view
        }
    }

    public function editAction() {// edit a member
        if (isset($_SESSION['Connected'])) {
            if (($_SESSION['Connected'] == 1) and ($_SESSION['admin'] == 1)) {//blindage de l'adresse
                //give data to view
                $this->selected = $_GET['id'];
            }
            else
                $this->redirect("/Members/index"); //forwarding address
        }
        else
            $this->redirect("/Members/index"); //forwarding address
    }
}
