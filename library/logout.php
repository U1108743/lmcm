<?php
require_once('../library/session.php');
require_once('../library/config.php');

$user_session = new UserSession();
$user_session->closeSession();
header('Location: grower_login_controller.php');
