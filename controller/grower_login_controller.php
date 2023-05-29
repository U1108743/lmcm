<?php
require_once('../library/config.php');
require_once('../model/database.php');
require_once('../model/user_db.php');
require_once('../library/session.php');

// create session
$user_session = new UserSession();

// Destroy session if expired and create new
$user_session = UserSessionHandler::check_session($user_session);

//restart lifetime
$user_session->setSessionLifetime(DEFAULT_LIFETIME);

// check what grower login page should do if page action is NOT set
$action = filter_input(INPUT_POST, 'action');
if ($action === NULL) {
    $action = filter_input(INPUT_GET, 'action');
    if ($action === NULL) {
        $action = 'grower_login';
    }
}

//check if session exists and redirect accordingly
if($user_session->hasSessionUser()) {
    $action = 'session_exists';
}

// List of actions for the grower login page
switch ($action) {

    case 'grower_login':

        //show grower login landing page
        include('../view/grower_login/grower_login.php');
        break;

    case 'grower_authenticate':

        // grower number and password from grower login form
        $grower_number = filter_input(INPUT_POST, 'grower_number');
        $input_password = strval(filter_input(INPUT_POST, 'password'));

        // get grower information
        $user = UserModel::get_user_by_number($grower_number);
        $password_hash = UserModel::get_user_password_hash($grower_number);
        // check grower username and password is correct, show error message if incorrect
        if($user != false && password_verify($input_password, $password_hash[0])) {

            //setting new user in session
            $user_session->setSessionUser($user);

            //Navigate to admin page or grower consignment page based on usertype
            $user = $user_session->getSessionUser();
            if($user->getUserType() == 'admin') {
                header('Location: admin_management_controller.php');
            }
            else {
                header('Location: grower_consignment_controller.php');
            }
        } else {
            header('Location: ?authentication=failed');
        }
        break;

    case 'session_exists':

        // redirect to grower landing page or admin landing page if session already exists

        // double security check: making sure session is definitely active with this second check
        if($user_session->hasSessionUser()) {
            $user = $user_session->getSessionUser();
            $usertype = $user->getUserType();
            switch($usertype) {
                case 'grower':
                    header('Location: grower_consignment_controller.php');
                    break;
                case 'admin':
                    header('Location: admin_management_controller.php');
                    break;
            }
        }
        else {
            header('Location: grower_login_controller.php');
        }
        break;

}
