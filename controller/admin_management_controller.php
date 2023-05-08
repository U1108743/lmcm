<?php
require_once('../library/config.php');
require_once('../model/database.php');
require_once('../model/user_db.php');
require_once('../model/report_db.php');
require_once('../model/report_access_db.php');
require_once('../library/session.php');
require_once('../library/user.php');
require_once('../library/report.php');

// create session
$user_session = new UserSession();

// Destroy session if expired and create new
$user_session = UserSessionHandler::check_session($user_session);

//restart lifetime
$user_session->setSessionLifetime(DEFAULT_LIFETIME);

$action = filter_input(INPUT_POST, 'action');
if ($action === NULL) {
    $action = filter_input(INPUT_GET, 'action');
    if ($action === NULL) {
        $action = 'admin_main';
    }
}

// checking if session exists and redirect accordingly
if ($user_session->hasSessionUser()) {
    $user = $user_session->getSessionUser();
    // checking if user is administrator
    if (!UserSessionHandler::is_admin($user)) {
        $action = 'admin_fail';
    }
} else {
    if ($action != 'logout') {
        $action = 'no_session';
    }
}

switch ($action) {

    case 'admin_main':

        // show admin landing page
        include('../view/admin_manager/admin_main.php');
        break;

    case 'add_user_form':

        // redirect to add new user form
        include('../view/admin_manager/add_user_form.php');
        break;

    case 'add_grower':

        // add new user to system

        //first pull of user form data
        $grower_id = filter_input(INPUT_POST, 'grower_id');
        $email = filter_input(INPUT_POST, 'email');

        $grower_check = UserModel::get_user_by_number($grower_id);
        $email_check = UserModel::get_user_by_email($email);

        //check if email or grower number already exists, redirect where required
        if ($grower_check == false) {
            unset($g_clash_msg);
        } else {
            $g_clash_msg = "Grower number " . $grower_id . " already exists, please use another number.";
        }

        if ($email_check == false) {
            unset($e_clash_msg);
        } else {
            $e_clash_msg = "Email address " . $email . " already exists, please use another email.";
        }

        if (isset($g_clash_msg) || isset($e_clash_msg)) {
            include('../view/admin_manager/add_user_form.php');
            die();
        }

        // pull remaining user data from form
        $first_name = filter_input(INPUT_POST, 'first_name');
        $surname = filter_input(INPUT_POST, 'surname');
        $business_name = filter_input(INPUT_POST, 'business_name');
        $mobile = filter_input(INPUT_POST, 'mobile');
        $user_password = filter_input(INPUT_POST, 'user_password');
        $user_type = filter_input(INPUT_POST, 'user_type');
        $user_status = filter_input(INPUT_POST, 'user_status');

        // add user to the system via data model
        UserModel::add_user(
            $grower_id,
            $first_name,
            $surname,
            $business_name,
            $email,
            $mobile,
            $user_password,
            $user_type,
            $user_status
        );

        // create user submission message and redirect
        $_SESSION['message_type'] = 'add_user';
        $_SESSION['add_user_submission_msg'] = "<h3>" . "New user " . $first_name . " with grower id " . $grower_id . " added." . "</h3>";
        header('Location: ?action=user_submitted');
        break;

    case 'modify_user_form':

        $users = UserModel::get_user_data();

        //unset admin user password fail message
        if (isset($_SESSION['admin_fail_msg'])) {
            unset($_SESSION['admin_fail_msg']);
        }

        // redirect to modify new user form
        include('../view/admin_manager/modify_user_select.php');
        break;

    case 'manage_reports_select':

        $reports = ReportModel::get_reports();

        //unset admin user password fail message
        if (isset($_SESSION['admin_fail_msg'])) {
            unset($_SESSION['admin_fail_msg']);
        }

        // redirect to manage access selection form
        include('../view/admin_manager/manage_reports_select.php');
        break;

    case 'manage_access_select':

        $report_id = filter_input(INPUT_POST, 'report_id');
        $users_with_access = UserModel::get_user_data_by_access($report_id);
        $report = ReportModel::get_report_by_number($report_id);

        //unset admin user password fail message
        if (isset($_SESSION['admin_fail_msg'])) {
            unset($_SESSION['admin_fail_msg']);
        }

        // redirect to manage access selection form
        include('../view/admin_manager/manage_access_select.php');

        break;

    case 'view_report':
        $report_id = filter_input(INPUT_POST, 'report_id');
        $pdf = ReportModel::get_report_data($report_id);
        header('Content-type: application/pdf');
        header("Cache-Control: no-cache");
        header("Pragma: no-cache");
        header("Content-length: " . strlen($pdf[0]));
        die($pdf[0]);

        break;

    case 'modify_user':

        // user id
        $user_id = filter_input(INPUT_POST, 'user_id');

        // if not being redirected from a failed modify user attempt then get the selected user information
        if (isset($user_id)) {
            // user information
            $selected_user = UserModel::get_user_by_number($user_id);
            $_SESSION['selected_user'] = serialize($selected_user);
        }

        include('../view/admin_manager/modify_user_form.php');
        break;

    case 'search_user':
        // searches user and returns list of users to be presented

        $search_input = filter_input(INPUT_POST, 'search_input');

        $users = array();
        if ($search_input == "") {
            $users = array();
        }

        if (strlen((string)$search_input) == 4) {
            $found_user = UserModel::get_user_by_number($search_input);
            if ($found_user != false) {
                array_push($users, $found_user);
            }
        } else {
            $users = UserModel::get_users_by_number_starts_with($search_input);
        }
        include('../view/admin_manager/modify_user_select.php');
        break;

    case 'search_report':
        // searches report_data and returns list of reports to be presented

        $search_input = filter_input(INPUT_POST, 'search_input');

        $reports = array();
        if ($search_input == "") {
            $reports = array();
        }

        $reports = ReportModel::get_reports_by_filename_contains($search_input);

        include('../view/admin_manager/manage_reports_select.php');
        break;

    case 'update_user':
        // update user in system

        $selected_user = unserialize($_SESSION['selected_user']);

        //first pull of user form data
        $grower_id = $selected_user->getUserID();
        $first_name = filter_input(INPUT_POST, 'first_name');
        $surname = filter_input(INPUT_POST, 'surname');
        $business_name = filter_input(INPUT_POST, 'business_name');
        $email = filter_input(INPUT_POST, 'email');
        $mobile = filter_input(INPUT_POST, 'mobile');
        $user_type = filter_input(INPUT_POST, 'user_type');
        $user_status = filter_input(INPUT_POST, 'user_status');

        //admin credentials
        $admin_entry_pw = filter_input(INPUT_POST, 'admin_password');
        $admin_id = $user->getUserID();
        $admin_session_pw = UserModel::get_user_password_hash($admin_id);

        if (password_verify($admin_entry_pw, $admin_session_pw[0])) {
            // clear the admin_fail_msg
            if (isset($_SESSION['admin_fail_msg'])) {
                unset($_SESSION['admin_fail_msg']);
            }

            // try adding user to the system via data model
            try {
                UserModel::update_user(
                    $grower_id,
                    $grower_id,
                    $first_name,
                    $surname,
                    $business_name,
                    $email,
                    $mobile,
                    $user_type,
                    $user_status
                );
            } catch (Exception $e) {
                // check why the update user model failed, possible userID/email duplicate entry
                // produce error message

                $grower_check = UserModel::get_user_by_number($grower_id);
                $email_check = UserModel::get_user_by_email($email);
                if ($grower_check == false || $grower_id == $selected_user->getUserID()) {
                    unset($g_clash_msg);
                } else {
                    $g_clash_msg = "Cannot update because grower number " . $grower_id . " already exists, please use another number.";
                }

                if ($email_check == false) {
                    unset($e_clash_msg);
                } else if ($selected_user->getUserID() != $email_check->getUserID()) {
                    $e_clash_msg = "Cannot update because email address " . $email . " already exists, please use another email.";
                }

                if (isset($g_clash_msg) || isset($e_clash_msg)) {
                    include('../view/admin_manager/modify_user_form.php');
                    die();
                } else {
                    $other_error = "The following error occured when attempting to update user: " . $e;
                    include('../view/admin_manager/modify_user_form.php');
                    die();
                }
            }

            // create user submission message and redirect
            $_SESSION['message_type'] = 'update_user';
            $_SESSION['add_user_submission_msg'] = "<h3>" . "Updated user " . $first_name . " with grower id " . $grower_id . "</h3>";
            header('Location: ?action=user_submitted');
        } else {
            $_SESSION['admin_fail_msg'] = "<h3>" . "Admin authentication failed when attempting update" . "</h3>";
            header('Location: ?action=modify_user');
        }

        break;


    case 'user_access_selection':
        // update access list in system

        // Get report_id
        $report_id = filter_input(INPUT_POST, 'report_id');

        // get list of users to change access for and their new access state
        $grower_id_list = filter_input(INPUT_POST, 'grower_id_list', FILTER_DEFAULT, FILTER_FORCE_ARRAY);
        $grower_ids = filter_input(INPUT_POST, 'grower_ids', FILTER_DEFAULT, FILTER_FORCE_ARRAY);

        //admin credentials
        $admin_entry_pw = filter_input(INPUT_POST, 'admin_password');
        $admin_id = $user->getUserID();
        $admin_session_pw = UserModel::get_user_password_hash($admin_id);

        if (password_verify($admin_entry_pw, $admin_session_pw[0])) {
            // clear the admin_fail_msg
            if (isset($_SESSION['admin_fail_msg'])) {
                unset($_SESSION['admin_fail_msg']);
            }

            // try adding user accesses to the system via data model
            try {
                ReportAccessModel::update_access($report_id, $grower_ids, $grower_id_list);
            } catch (Exception $e) {
                // get report and users with access to display
                $report = ReportModel::get_report_by_number($report_id);
                $users_with_access = UserModel::get_user_data_by_access($report_id);

                // produce error message
                $error = "The following error occured when attempting to change access: " . $e;
                include('../view/admin_manager/manage_access_select.php');
                die();
            }

            // create report access list change message and redirect
            $_SESSION['message_type'] = 'update_access';
            $_SESSION['change_access_msg'] = "<h3>" . "Changed Access for Individuals</h3>";
            header('Location: ?action=access_changed');
        } else {
            // password failed to verify get report and users with access to display
            $report = ReportModel::get_report_by_number($report_id);
            $users_with_access = UserModel::get_user_data_by_access($report_id);
            $_SESSION['admin_fail_msg'] = "<h3>" . "Admin authentication failed when attempting update" . "</h3>";
            include('../view/admin_manager/manage_access_select.php');
        }

        break;

    case 'user_pw_form':

        $user_id = filter_input(INPUT_POST, 'user_id');

        // if not being redirected from a failed reset password attempt then get the selected user information
        if (isset($user_id)) {
            // user information
            $selected_user = UserModel::get_user_by_number($user_id);
            $_SESSION['selected_user'] = serialize($selected_user);
        }

        include('../view/admin_manager/reset_user_pw_form.php');
        break;

    case 'reset_user_pw':

        $admin_entry_pw = filter_input(INPUT_POST, 'admin_password');
        $admin_id = $user->getUserID();
        $admin_session_pw = UserModel::get_user_password_hash($admin_id);

        if (password_verify($admin_entry_pw, $admin_session_pw[0])) {
            // clear the admin_fail_msg
            if (isset($_SESSION['admin_fail_msg'])) {
                unset($_SESSION['admin_fail_msg']);
            }

            // get selected user details
            $selected_user = unserialize($_SESSION['selected_user']);

            // get new user replacement password
            $new_pw = filter_input(INPUT_POST, 'user_password');
            $new_pw_hash = password_hash($new_pw, PASSWORD_DEFAULT);

            // set new password in database
            try {
                UserModel::set_user_password($selected_user, $new_pw_hash);
            } catch (Exception $e) {
                $_SESSION['admin_fail_msg'] = "<h3>" . "There was a database error and password could not be reset" . "</h3>";
                header('Location: ?action=user_pw_form');
            }

            // set submission message details
            $_SESSION['message_type'] = 'reset_user_pw';
            $_SESSION['add_user_submission_msg'] = "<h3>" . "Password reset for user " . $selected_user->getFirstName() . " with user id " . $selected_user->getUserID() . "</h3>";
            header('Location: ?action=user_submitted');
        } else {
            $_SESSION['admin_fail_msg'] = "<h3>" . "Admin authentication failed for password reset" . "</h3>";
            header('Location: ?action=user_pw_form');
        }

        break;

    case 'user_submitted':

        // redirected user submission so that user refresh does not resubmit add user form
        include('../view/admin_manager/admin_message.php');
        break;

    case 'access_changed':

        // redirected reports access list so that user refresh does not resubmit change access form
        // Supply reports for page
        $reports = ReportModel::get_reports();
        include('../view/admin_manager/manage_reports_select.php');
        break;

    case 'no_session':

        // session has expired, redirect to login page with expire message
        header('Location: grower_login_controller.php?session=expired');
        break;

    case 'admin_fail':

        // admin type check failed, redirect to login page
        header('Location: grower_login_controller.php');
        break;

    case 'logout':

        // destroy session and redirect to login page
        $user_session->closeSession();
        header('Location: grower_login_controller.php');
        break;
}
