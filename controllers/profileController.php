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


class ProfileController extends ActionController {

    /**
     * Simple index page which links to the main available actions
     */
    public function controlkinectAction() {
        $_SESSION['controller'] = "kinect";
        if (isset($_SESSION['Connected'])) {
            //Connect to DB
            $connect = connection::getInstance();
            //We get the user ID
            $sql = "SELECT IDU FROM users WHERE nameU='" . $_SESSION['Name'] . "'";
            //Request sending
            $req = mysql_query($sql) or die('Erreur SQL !<br>' . $sql . '<br>' . mysql_error());
            while ($data = mysql_fetch_assoc($req)) {
                // get IDU creation
                $userID[] = $data['IDU'];
            }

            //We update the controllers table
            $sql = "UPDATE controllers SET IDU='" . $userID[0] . "' WHERE nameC='" . $_SESSION['controller'] . "'";
            //Request sending 
            $req = mysql_query($sql) or die('Erreur SQL !<br>' . $sql . '<br>' . mysql_error());
        }
        $this->redirect("/Profile/home");
    }

    public function controlmicroAction() {

        $_SESSION['controller'] = "microphone";

        if (isset($_SESSION['Connected'])) {
            //Connect to DB
            $connect = connection::getInstance();
            //We get the user ID
            $sql = "SELECT IDU FROM users WHERE nameU='" . $_SESSION['Name'] . "'";
            //Request sending
            $req = mysql_query($sql) or die('Erreur SQL !<br>' . $sql . '<br>' . mysql_error());
            while ($data = mysql_fetch_assoc($req)) {
                // get IDU creation
                $userID[] = $data['IDU'];
            }
            //We update the controllers table
            $sql = "UPDATE controllers SET IDU='" . $userID[0] . "' WHERE nameC='" . $_SESSION['controller'] . "'";
            //Request sending 
            $req = mysql_query($sql) or die('Erreur SQL !<br>' . $sql . '<br>' . mysql_error());
        }
        $this->redirect("/Profile/home");
    }
    
    public function controlbraceletAction() {
        
        $_SESSION['controller'] = "bracelet";
        
        if (isset($_SESSION['Connected'])) {
            //Connect to DB
            $connect = connection::getInstance();
            //We get the user ID
            $sql = "SELECT IDU FROM users WHERE nameU='" . $_SESSION['Name'] . "'";
            //Request sending
            $req = mysql_query($sql) or die('Erreur SQL !<br>' . $sql . '<br>' . mysql_error());
            while ($data = mysql_fetch_assoc($req)) {
                // get IDU creation
                $userID[] = $data['IDU'];
            }
            //We update the controllers table
            $sql = "UPDATE controllers SET IDU='" . $userID[0] . "' WHERE nameC='" . $_SESSION['controller'] . "'";
            //Request sending 
            $req = mysql_query($sql) or die('Erreur SQL !<br>' . $sql . '<br>' . mysql_error());
        }
        $this->redirect("/Profile/home");
    }

    public function HomeAction() {

        $_SESSION['current'] = 'management';
        if (!isset($_SESSION['Connected']))
            $this->redirect('/');

        $_SESSION['members'] = Users::Getuser(); //get the member up to date
        foreach ($_SESSION['members'] as $member) {
            if ($member->getId() == $_SESSION['id']) {
                //give data to view
                $this->member = $member;
            }
        }
    }

    public function HomePhoneAction() {

        $_SESSION['current'] = 'management';
        if (!isset($_SESSION['Connected']))
            $this->redirect('/');

        $_SESSION['members'] = Users::Getuser();    //get the membre up to date
        foreach ($_SESSION['members'] as $member) {

            if ($member->getId() == $_SESSION['id']) {
                //give data to view
                $this->member = $member;
            }
        }
    }

    public function editScenarioAction() {

        foreach ($_SESSION['members'] as $membres) {
            if ($membres->getName() == $_SESSION['Name']) {//find the right people
                $membre = $membres;
            }
        }

        foreach ($membre->getScenarios() as $scenards) {
            if ($scenards->getId() == $_GET['id']) {
                $scenar = $scenards;
            }
        }

        $this->scenar = $scenar;
        $count_act = 0;
        foreach ($scenar->getActions() as $act)
        {
            $count_act++;
            $actions[] = $act;
        }
        $this->count = $count_act;
        $this->actions_check = $actions;
        $this->actions = Users::getAction();
    }

    public function creerscenarioAction() {

        $_SESSION['current'] = 'management';
        $this->actions = Users::getAction();    //get all actions
        $_SESSION['actions'] = $this->actions;
        $this->controllers = Users::getController();      //get all controllers
        $_SESSION['controllers'] = $this->controllers;
    }

    public function adMoveAction() {

        //inactivate template
        $this->_includeTemplate = false;

        $control = $_GET['control']; 
        
        //Connect to DB
        $connect = connection::getInstance();
        
        $sql = "SELECT IDC FROM controllers WHERE nameC='".$control."'";
        //Request sending
        $req = mysql_query($sql) or die('Erreur SQL !<br>' . $sql . '<br>' . mysql_error());
        while ($data = mysql_fetch_assoc($req)) {
            // scenario selection
            $controlID[]=$data['IDC'];
        }

        //SQL REQUEST
        $sql = "SELECT * FROM movements WHERE IDC in (SELECT IDC FROM controllers WHERE nameC='" . $control . "')";
        //Request sending
        $req = mysql_query($sql) or die('Erreur SQL !<br>' . $sql . '<br>' . mysql_error());
        $i = 0;
        
        $all_moves;
        while ($data = mysql_fetch_assoc($req)) {
            // scenario selection
            $all_moves[$i]['IDM'] = $data['IDM'];
            $all_moves[$i]['nameM'] = $data['nameM'];
            $all_moves[$i]['descM'] = $data['descM'];
            $all_moves[$i]['IDC'] = $data['IDC'];
            $i++;
        }
        $mov;     
        
        $sql = "SELECT * FROM scenarios WHERE IDU='". $_SESSION['id'] . "' and IDC in (SELECT IDC FROM controllers where nameC ='".$control."')";
        //Request sending
        $req = mysql_query($sql) or die('Erreur SQL !<br>' . $sql . '<br>' . mysql_error());
        $i = 0;
        
        while ($data = mysql_fetch_assoc($req)) {

           $scenar[$i]['IDS'] = $data['IDS'];
           $scenar[$i]['nameS'] = $data['nameS'];
           $scenar[$i]['descS'] = $data['descS'];
           $scenar[$i]['IDM'] = $data['IDM'];
           $scenar[$i]['IDC'] = $data['IDC'];
           $scenar[$i]['IDU'] = $data['IDU'];
           $i++;
        }
        //var_dump($scenar);
        
        $i=0;
        if(isset($scenar)) {
            echo"POUET1";
            foreach($scenar as $scen) {
                $sql = "SELECT * FROM movements WHERE IDM='".$scenar[$i]['IDM']."' and IDC='".$scenar[0]['IDC']."'";
                //Request sending
                $req = mysql_query($sql) or die('Erreur SQL !<br>' . $sql . '<br>' . mysql_error());
                while($data = mysql_fetch_assoc($req)) {
                    $used[$i]['IDM'] = $data['IDM'];
                    $used[$i]['nameM'] = $data['nameM'];
                    $used[$i]['descM'] = $data['descM'];
                    $used[$i]['IDC'] = $data['IDC'];
                    $i++;
                }
            }
        }
        $add = 0;
        
        if(isset($all_moves)) {
            foreach ($all_moves as $value) {
                $add = 0;
                foreach ($used as $val) {
                    
                    if ($value == $val) {//if movement already exists
                        $add = 1;
                    }
                }
                if ($add == 0) {//if movement disengaged
                    $movement[] = $value; //put it in list  
                }
            }
        }
        
        if(!isset($movement))
        {
            $movement[] = "";
        }

        //give data to view
        $this->movements = $movement;
        if($this->movements[0])
        {
            $_SESSION['button'] = 1;
        }
        else
        {
            $_SESSION['button'] = 0;
        }
    }
    
    public function adMoveEditAction() {
        
        foreach ($_SESSION['members'] as $membres) {
            if ($membres->getName() == $_SESSION['Name']) {//find the right people
                $membre = $membres;
            }
        }

        foreach ($membre->getScenarios() as $scenards) {
            if ($scenards->getId() == $_GET['scenario_id']) {
                $scenar = $scenards;
            }
        }

        $this->scenar = $scenar;
        $count_act = 0;
        foreach ($scenar->getActions() as $act)
        {
            $count_act++;
            $actions[] = $act;
        }
        $this->count = $count_act;
        $this->actions_check = $actions;
        $this->actions = Users::getAction();
        
        $scenId = $_GET['scenario_id'];
        
        //Connect to DB
        $connect = connection::getInstance();

        //SQL REQUEST
        $sql = "SELECT IDC FROM controllers WHERE IDC in(SELECT IDC FROM scenarios WHERE IDS='" . $scenId . "')";
        //Request sending
        $req = mysql_query($sql) or die('Erreur SQL !<br>' . $sql . '<br>' . mysql_error());
        while ($data = mysql_fetch_assoc($req)) {
            // scenario creation
            $IDC[] = $data['IDC'];
        }
        
        //GET CURRENT MOVEMENT
        $sql = "SELECT* FROM movements WHERE IDM in(SELECT IDM FROM scenarios WHERE IDS='".$scenId."')";
        //Request sending
        $req = mysql_query($sql) or die('Erreur SQL !<br>' . $sql . '<br>' . mysql_error());
        $i=0;
        $myMove;
        while ($data = mysql_fetch_assoc($req)) {
            // scenario creation
            $myMove[$i]['IDM'] = $data['IDM'];
            $myMove[$i]['nameM'] = $data['nameM'];
            $myMove[$i]['descM'] = $data['descM'];
            $myMove[$i]['IDC'] = $data['IDC'];
        }
        
        //var_dump($myMove);
        //exit;
        
        //SQL REQUEST
        $sql = "SELECT* FROM movements WHERE IDC='" . $IDC[0] . "'";
        //Request sending
        $req = mysql_query($sql) or die('Erreur SQL !<br>' . $sql . '<br>' . mysql_error());
        $i = 0;
        
        
        while ($data = mysql_fetch_assoc($req)) {
            // scenario selection
            $all_moves[$i]['IDM'] = $data['IDM'];
            $all_moves[$i]['nameM'] = $data['nameM'];
            $all_moves[$i]['descM'] = $data['descM'];
            $all_moves[$i]['IDC'] = $data['IDC'];
            $i++;
        }
    
            
        $mov;
        $scenar = $_SESSION['members'][$_SESSION['id']]->getScenarios(); //user scenario
        $i=0;
        foreach ($scenar as $scen) {
            $mov[$i] = $scen->getMovement(); //get mouvement
            $used[$i]['IDM'] = $mov[$i]->getId();
            $used[$i]['nameM'] = $mov[$i]->getName();
            $used[$i]['descM'] = $mov[$i]->getDesc();
            $used[$i]['nameM'] = $mov[$i]->getName();
            $used[$i]['IDC'] = $mov[$i]->getIdc();
            $i++;
        }
        $add = 0;
        
        if(isset($all_moves)) {
           
            foreach ($all_moves as $value) {
                $add = 0;
                foreach ($used as $val) {
                    if ($value == $val) {//if movement already exists
                        $add = 1;
                    }
                }
                if ($add == 0) {//if movement disengaged
                    $movement[] = $value; //put it in list  
                }
            }
        }
        
        if(!isset($movement))
        {
            $movement[] = $myMove[0];
        }

        //give data to view
        $this->movements = $movement;
        if($this->movements[0])
        {
            $_SESSION['button'] = 1;
        }
        else
        {
            $_SESSION['button'] = 0;
        }
        //var_dump($this->movements);
    }
    
    public function adButtonsAction() {
        //inactivate template
        $this->_includeTemplate = false;
        $this->button = $_SESSION['button'];
    }

    public function ajActionAction() {

        //inactivate template
        $this->_includeTemplate = false;
        //give data to view
        $this->actions = $_SESSION['actions'];
    }

    public function adMovementAction() {
        $this->_includeTemplate = false;
    }

    public function scenariovalideAction() {

        //SQL connection
        $connect = connection::getInstance();

        //Statement of resources
        $test = array();
        $i = 1;

        //Data storage
        $scenario_name = $_POST['name'];
        $desc = $_POST['desc'];
        $movement = $_POST['formMouvement'];
        var_dump($movement);

        $scenario_name = Users::secure($scenario_name);
        $desc = Users::secure($desc);
        $movement = Users::secure($movement);



        //We get the movement ID
        $sql = "SELECT * FROM movements WHERE nameM='" . $movement . "'";
        //Request sending
        $req = mysql_query($sql) or die('Erreur SQL !<br>' . $sql . '<br>' . mysql_error());
        while ($data = mysql_fetch_assoc($req)) {
            // scenario creation
            $tabIDM[] = $data['IDM'];
            $tabIDM[] = $data['IDC'];
        }

        //SCENARIO UPDATING
        //Scenario sql request
        $sql = "INSERT INTO scenarios VALUES('','" . $scenario_name . "','" . $desc . "','" . $tabIDM[0] . "','" . $tabIDM[1] . "','" . $_SESSION['id'] . "' )";
        //Request sending
        $req = mysql_query($sql) or die('Erreur SQL !<br>' . $sql . '<br>' . mysql_error());

        //ID scenario sql request
        $sql = "SELECT IDS FROM scenarios WHERE nameS = '" . $scenario_name . "'";
        //Request sending
        $req = mysql_query($sql) or die('Erreur SQL !<br>' . $sql . '<br>' . mysql_error());
        while ($data = mysql_fetch_assoc($req)) {
            //Creation of scenarios
            $tabIDS[] = $data['IDS'];
        }

        while (isset($_POST['form' . $i . 'Action'])) {//Loop on the number of actions
            $action[$i] = $_POST['form' . $i . 'Action'];

            $action[$i] = Users::secure($action[$i]);
            $sql = "SELECT IDA FROM actions WHERE nameA='" . $action[$i] . "'";
            //Request sending
            $req = mysql_query($sql) or die('Erreur SQL !<br>' . $sql . '<br>' . mysql_error());
            while ($data = mysql_fetch_assoc($req)) {
                // Creation of scenarios
                $tabIDA[] = $data['IDA'];
            }
            
            $tabIDA[0] = Users::secure($tabIDA[0]);

            //Insert into table "contains"
            $sql = "INSERT INTO contains VALUES('" . $tabIDS[0] . "','" . $tabIDA[0] . "')";
            //Request sending
            $req = mysql_query($sql) or die('Erreur SQL !<br>' . $sql . '<br>' . mysql_error());
            $i++;
            unset($tabIDA);
        }
        $this->redirect("/Management/index/");
    }
    
    public function scenarioEditValidAction() {
        
        //Data storage
        $scenId = $_GET['scenId'];
        $scenario_name = $_POST['name'];
        $desc = $_POST['desc'];
        $movement = $_POST['formMouvement'];

        $scenario_name = Users::secure($scenario_name);
        $desc = Users::secure($desc);
        $movement = Users::secure($movement);
        
        //SQL connection
        $connect = connection::getInstance();

        //Statement of resources
        $test = array();
        $i = 1;
        
        //We get the movement ID
        $sql = "SELECT * FROM movements WHERE nameM='" . $movement . "'";
        //Request sending
        $req = mysql_query($sql) or die('Erreur SQL !<br>' . $sql . '<br>' . mysql_error());
        while ($data = mysql_fetch_assoc($req)) {
            // scenario creation
            $tabIDM[] = $data['IDM'];
            $tabIDM[] = $data['IDC'];
        }
        
        //SCENARIO UPDATE
        $sql = "UPDATE scenarios SET nameS='" . $_POST['name'] . "', descS='" . $_POST['desc'] . "', IDM='" . $tabIDM[0] . "', IDC='" . $tabIDM[1] . "' WHERE IDS='".$scenId."'";    
        //Request sending 
        $req = mysql_query($sql) or die('Erreur SQL !<br>' . $sql . '<br>' . mysql_error());
        
        //ACTIONS UPDATE
        $sql = "DELETE FROM contains where IDS ='" . $scenId ."'";
        //Request sending 
        $req = mysql_query($sql) or die('Erreur SQL !<br>' . $sql . '<br>' . mysql_error());
        
        while (isset($_POST['form' . $i . 'Action'])) {//Loop on the number of actions
            $action[$i] = $_POST['form' . $i . 'Action'];

            $action[$i] = Users::secure($action[$i]);
            $sql = "SELECT IDA FROM actions WHERE nameA='" . $action[$i] . "'";
            //Request sending
            $req = mysql_query($sql) or die('Erreur SQL !<br>' . $sql . '<br>' . mysql_error());
            while ($data = mysql_fetch_assoc($req)) {
                // Creation of scenarios
                $tabIDA[] = $data['IDA'];
            }

            $tabIDA[0] = Users::secure($tabIDA[0]);

            //Insert into table "contains"
            $sql = "INSERT INTO contains VALUES('" . $scenId . "','" . $tabIDA[0] . "')";
            //Request sending
            $req = mysql_query($sql) or die('Erreur SQL !<br>' . $sql . '<br>' . mysql_error());
            $i++;
            unset($tabIDA);
        }
        
        $this->redirect("/Management/index/");
    }

    public function ajUserAction() {
        $this->_includeTemplate = false;

        if ($_GET['checkboxAd'] == 'false') {
            $typeU = "child";
        } else {
            $typeU = "adult";
        }

        //Test to know if the user already exists
        $cpt = true;
        foreach ($_SESSION['members'] as $member) {

            if ($_GET['Name'] == $member->getName()) {
                $cpt = false;
            }
        }

        //If user doesn't exist
        if ($cpt) {

            //Connection to the BDD
            $connect = connection::getInstance();
            $_GET['Name'] = Users::secure($_GET['Name']);
            $_GET['Pass'] = Users::secure($_GET['Pass']);
            $typeU = Users::secure($typeU);

            $sql = "INSERT INTO users VALUES('','" . $_GET['Name'] . "','" . $typeU . "','" . $_GET['Pass'] . "','0')"; //on recupere tout les utilisateurs
            // Request sending
            $req = mysql_query($sql) or die('Erreur SQL !<br>' . $sql . '<br>' . mysql_error());

            $_SESSION['current'] = 'members';
            $this->members = Users::Getuser();
        } else {
            $this->members = $_SESSION['members'];
        }
    }

    public function deleteScenarioAction() {

        Users::deleteScenario($_GET['id']);
        $this->redirect("/Profile/Home");
    }

    public function connect_kinectAction() {
        
    }

    public function ajInfoAction() {

        $this->_includeTemplate = false;

        //Test to know if the user already exists
        $cpt = true;
        foreach ($_SESSION['members'] as $member) {

            if ($_POST['Name'] == $member->getName()) {
                $cpt = false;
            }
        }
        $cpt = true;

        //SQL Requests for the DB updates
        if ($cpt) {

            $_SESSION['Name'] = $_POST['Name'];
            //connexion bdd
            $connect = connection::getInstance();
            $_POST['formAge'] = Users::secure($_POST['formAge']);
            $_POST['Name'] = Users::secure($_POST['Name']);
            $_POST['Pswd1'] = Users::secure($_POST['Pswd1']);
            //test
            //modification name, password, age
            if ($_POST['Name'] == "") {
                $sql = "UPDATE users SET typeU='" . $_POST['formAge'] . "', password='" . $_POST['Pswd1'] . "' WHERE IDU='" . $_SESSION['id'] . "'"; //on recupere tout les utilisateurs
            } else if ($_POST['Pswd1'] == '') {
                $sql = "UPDATE users SET nameU='" . $_POST['Name'] . "', typeU='" . $_POST['formAge'] . "' WHERE IDU='" . $_SESSION['id'] . "'"; //on recupere tout les utilisateurs
            } else if (($_POST['Name'] == "") || ($_POST['Pswd1'] == '')) {
                $sql = "UPDATE users SET typeU='" . $_POST['formAge'] . "' WHERE IDU='" . $_SESSION['id'] . "'"; //on recupere tout les utilisateurs
            } else {
                $sql = "UPDATE users SET  nameU='" . $_POST['Name'] . "', password='" . $_POST['Pswd1'] . "', typeU='" . $_POST['formAge'] . "' WHERE IDU='" . $_SESSION['id'] . "'"; //on recupere tout les utilisateurs
            }

            //Request sending 
            $req = mysql_query($sql) or die('Erreur SQL !<br>' . $sql . '<br>' . mysql_error());

            $_SESSION['current'] = 'members';
            $this->members = Users::Getuser();
        } else {
            $this->members = $_SESSION['members'];
        }
    }

}

?>
