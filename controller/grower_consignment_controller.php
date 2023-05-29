<?php
require_once('../library/config.php');
require_once('../model/database.php');
require_once('../model/user_db.php');
require_once('../model/report_db.php');
require_once('../model/report_access_db.php');
require_once('../library/session.php');
require_once('../library/user.php');
require_once('../library/report.php');
require_once('../model/consignment_db.php');



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
        $action = 'grower_main';
    }
}

// checking if session exists and redirect accordingly
if ($user_session->hasSessionUser()) {
    $user = $user_session->getSessionUser();
} else {
    if ($action != 'logout') {
        $action = 'no_session';
    }
}

// List of actions for the grower when logged in
switch ($action) {
    case 'grower_main':
        // Shows the grower landing page
        include('../view/grower_consignment/grower_main.php');

        break;

    case 'grower_account':

        //goto the grower account page which shows grower account details

        // checks if a grower fail message for the password reset is set, unsets if it does
        // Used as a way of removing the fail message after navigating away from password reset page upon reset failure
        if (isset($_SESSION['grower_fail_msg'])) {
            unset($_SESSION['grower_fail_msg']);
        }

        include('../view/grower_consignment/grower_account.php');

        break;

    case 'change_password_form':

        // show change password pass for grower
        include('../view/grower_consignment/grower_change_password.php');
        break;

    case 'change_password':

        $current_pw = filter_input(INPUT_POST, 'current_password');
        $grower_id = $user->getUserID();
        $grower_session_pw = UserModel::get_user_password_hash($grower_id);

        if (password_verify($current_pw, $grower_session_pw[0])) {
            // clear the grower_fail_msg
            if (isset($_SESSION['grower_fail_msg'])) {
                unset($_SESSION['grower_fail_msg']);
            }

            // get  replacement password
            $new_pw = filter_input(INPUT_POST, 'user_password');
            $new_pw_hash = password_hash($new_pw, PASSWORD_DEFAULT);

            // set new password in database
            try {
                UserModel::set_user_password($user, $new_pw_hash);
            } catch (Exception $e) {
                $_SESSION['grower_fail_msg'] = "<h3>" . "There was a database error and password could not be changed" . "</h3>";
                header('Location: ?action=change_password_form');
            }

            // set submission message details
            $_SESSION['message_type'] = 'grower_pw_change';
            $_SESSION['add_grower_submission_msg'] = "<h3>" . "Password changed for grower " . $user->getFirstName() . " with user id " . $user->getUserID() . "</h3>";
            header('Location: ?action=grower_submitted');
        } else {
            $_SESSION['grower_fail_msg'] = "<h3>" . "Grower authentication failed for password reset" . "</h3>";
            header('Location: ?action=change_password_form');
        }
        break;

    case 'goto_grower_consignment':

        // navigate to the consignment form page
        include('../view/grower_consignment/grower_consignment_form.php');
        break;
        
    case 'submit_consignment':

        try {
        
        // Gather consignment data from consignment form
        $grower_number = $user->getUserID();
        $entry_number = filter_input(INPUT_POST, 'entry_number');
        $consignment_date = filter_input(INPUT_POST, 'consignment_date');
        $market_location = filter_input(INPUT_POST, 'market_location');
        $radio_choice = filter_input(INPUT_POST, 'comment_choice');
        $grower_comment = filter_input(INPUT_POST, 'comment_text');
    
        
        
        // if no comment was chosen grower comment set to null
        if ($radio_choice == "no") {
            $grower_comment = NULL;
        }

        // Submit the consignment data
        $consignment_id = ConsignmentModel::submit_consignment_data($grower_number, $consignment_date, $market_location, $grower_comment);

        // Gather entry data from consignment form
        for ($i = 1; $i <= $entry_number; $i++) {
            $fruit_variety = filter_input(INPUT_POST, 'fruit_variety' . $i);
            $fruit_size = filter_input(INPUT_POST, 'fruit_size' . $i);
            $package_type = filter_input(INPUT_POST, 'package_type' . $i);
            $quantity = filter_input(INPUT_POST, 'quantity' . $i);
            $price = filter_input(INPUT_POST, 'price' . $i);

            // Submit the entry data
            ConsignmentModel::submit_entry_data(
                $consignment_id,
                $fruit_variety,
                $fruit_size,
                $package_type,
                $quantity,
                $price
            );
        }
        }
        catch (Exception $e) {
            echo $e;
            include('../errors/database_error.php');
            die();
        }
        
        $_SESSION['consignment_id'] = $consignment_id;
        header('Location: ?action=consignment_submitted');
        break;

    case 'consignment_submitted':

        // redirect for action 'submit_consignment' so that user refresh does not resubmit form
        include('../view/grower_consignment/consignment_submission_message.php');
        break;

    case 'grower_submitted':

        // generic redirect message for action so that user refresh does not resubmit forms/changes
        include('../view/grower_consignment/grower_submission_message.php');
        break;

    case 'grower_view_reports':

        // Get grower id and reports viewable by them
        $grower_number = $user->getUserID();
        $reports = ReportModel::get_reports_by_access($grower_number);

        // redirect to grower view reports
        include('../view/grower_consignment/grower_view_reports.php');
        break;


    case 'search_report':
        // searches report_data and returns list of reports to be presented

        $search_input = filter_input(INPUT_POST, 'search_input');
        
        $grower_id = $user->getUserID();

        $reports = array();
        if ($search_input == "") {
            $reports = array();
        }

        $reports = ReportModel::get_reports_by_filename_contains_and_has_access($search_input, $grower_id);

        include('../view/grower_consignment/grower_view_reports.php');
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

    case 'no_session':

        // session has expired, redirect to login page with expire message
        header('Location: grower_login_controller.php?session=expired');
        break;

    case 'logout':

        // destroy session and redirect to login page
        $user_session->closeSession();
        header('Location: grower_login_controller.php');
        break;
}