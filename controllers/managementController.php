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


class ManagementController extends ActionController {

    /**
     * Simple index page which links to the main available actions
     */
    public function indexAction() {
        $_SESSION['current'] = 'management';
        if (isset($_SESSION['Connected'])) {
            $this->redirect('/Profile/Home');
        }
    }

    public function indexPhoneAction() {
        $_SESSION['current'] = 'management';
        if (isset($_SESSION['Connected'])) {
            $this->redirect('/Profile/HomePhone');
        }
    }

    public function SigninAction() {

        //sql connection
        $connect = connection::getInstance();

        //statement of resources
        $name = $_POST['name'];
        $pass = $_POST['pass'];

        $name = Users::secure($name);
        $pass = Users::secure($pass);

        //user sql request
        $sql = "SELECT * FROM  users where nameU = '$name' and password= '$pass' ";

        //sending request
        $req = mysql_query($sql) or die('Erreur SQL !<br>' . $sql . '<br>' . mysql_error());

        $i = 0;
        while ($data = mysql_fetch_assoc($req)) {
            //scenarios creation
            $data2 = $data;
            $i++;
        }

        if ($i == 1) {
            $_SESSION['Name'] = $data2['nameU'];

            $_SESSION['Connected'] = 1;
            $_SESSION['id'] = $data2['IDU'];
            $_SESSION['admin'] = $data2['admin'];
            $this->redirect("/Profile/Home");
        }
    }

    public function SigninPhoneAction() {

        //sql connection
        $connect = connection::getInstance();

        //statement of resources
        $name = $_POST['name'];
        $pass = $_POST['pass'];

        $name = Users::secure($name);
        $pass = Users::secure($pass);

        //user sql request
        $sql = "SELECT * FROM  users where nameU = '$name' and password= '$pass' ";

        //sending request
        $req = mysql_query($sql) or die('Erreur SQL !<br>' . $sql . '<br>' . mysql_error());

        $i = 0;
        while ($data = mysql_fetch_assoc($req)) {
            //scenarios creation
            $data2 = $data;
            $i++;
        }

        if ($i == 1) {
            $_SESSION['Name'] = $data2['nameU'];
            $_SESSION['Connected'] = 1;
            $_SESSION['id'] = $data2['IDU'];
            $_SESSION['admin'] = $data2['admin'];
            $this->redirect("/Profile/homePhone");
        }
    }

    public function logoutAction() {

        unset($_SESSION['Connected']);
        unset($_SESSION['admin']);
        unset($_SESSION['Name']);
        $this->redirect("/");
    }

}
