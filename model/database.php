<?php

/**
 * CLASS: Database
 * 
 * This is used to connect to the MySql database either local or remote.
 * 
 * Just change the dsn, username, and password to access different databases.
 * 
 * Some of the remote databases will require a certificate authority certificate.
 * This is provided in the model/CA/ folder, generally the ones we used were provided
 * by the Azure service when we created a database on the platform.
 * 
 * The credentials you see below will most likely be for the dev database. I would
 * avoid putting the producation database crendentials directly into version control.
 * 
 */

class Database {
    
    static $dsn = 'sqlsrv:server = tcp:lmcm-pai.database.windows.net,1433; Database = lmcm-pai-db';
    static $username = 'CloudSA695e5a66';
    static $password = 'QS8mPs.*.m._w>m';

    public static function connection() {
        
        try {
            $db = new PDO(
            self::$dsn,
            self::$username,
            self::$password);
           // array(PDO::MYSQL_ATTR_SSL_CA => '../model/CA/DigiCertGlobalRootCA.crt.pem'));
            return $db;
        } catch (PDOException $e) {
            $error_message = $e->getMessage();
            include('../errors/database_error.php');
            exit();
        }
    }

}

?>
