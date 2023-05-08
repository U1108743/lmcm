<?php
require_once('library/session.php');

$user_session = new UserSession();
if(!isset($_SESSION['session_lifetime'])) {
    $user_session->setSessionLifetime(0);
}

header('Location: controller/grower_login_controller.php');

?>


