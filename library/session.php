<?php
require_once('user.php');

/**
 * CLASS: UserSession
 * 
 * Class that stores the user session data. This is generally used at page loads and sign-in authentication.
 * 
 * You'll probably notice it the most at the start of the controllers.
 * 
 * Main features:
 * - setting session lifetime, this will generally be passed by a global parameter given in the config.php file
 * - getting how much time is left in the ssion
 * - checking whether a user session has expired
 * - closing the user session
 * - setting a user to a session variable
 * - getting the user session variable
 * 
 */

class UserSession {

    public function __construct() {
        session_start();
    }

    // Universal session functions
    public function setSessionLifetime($lifetime) {
        $_SESSION['session_lifetime'] = $lifetime;
        $_SESSION['session_start'] = time();
    }

    public function getSessionLifetimeLeft() {
        $start_time = $_SESSION['session_start'];
        $lifetime = $_SESSION['session_lifetime'];
        $end_time = $start_time + $lifetime;
        $time_left = $end_time - time();
        return $time_left;
    }

    public function hasSessionExpired() {
        if(!isset($_SESSION['session_lifetime'])) {
            return true;
        }
        if($this->getSessionLifetimeLeft() <= 0) {
            return true;
        }
        return false;
    }

    public function closeSession() {
        session_unset();
        session_destroy();
    }

    // User session functions
    public function setSessionUser(User $user) {
        $_SESSION['session_user'] = serialize($user);
    }

    public function getSessionUser() {
        return unserialize($_SESSION['session_user']);
    }

    public function hasSessionUser () {
        return isset($_SESSION['session_user']);
    }
}

/**
 * CLASS: UserSessionHandler
 * 
 * Session handler class can take a reference to a session and check whether it expired.
 * If it is it will close the session
 * 
 * It will also take a User object reference and check if the session user is an admin or not.
 * 
 */
class UserSessionHandler {

    public static function check_session(&$session) {
        if($session->hasSessionExpired()) {
            $session->closeSession();
            $session = new UserSession();
        
            return $session;
        }
        return $session;
    }

    public static function is_admin(User &$user) {
        if($user->getUserType() == 'admin') {
            return true;
        }
        return false;
    }

}

?>