<?php
require_once('../library/user.php');

/**
 * CLASS: UserModel
 * 
 * Use this class to access the users table in the database.
 * 
 */
class UserModel
{

    public static function get_user_data()
    {
        $conn = Database::connection();
        $query = 'SELECT *
                  FROM users';
        $statement = $conn->prepare($query);
        $statement->execute();
        $users = $statement->fetchall();
        $statement->closeCursor();

        $users_output = array();

        foreach ($users as $user) {
            $grower_id = $user['grower_id'];
            $first_name = $user['first_name'];
            $surname = $user['surname'];
            $business_name = $user['business_name'];
            $email = $user['email'];
            $mobile = $user['mobile'];
            $user_type = $user['user_type'];
            $user_status = $user['user_status'];
            $u = new User(
                $grower_id,
                $first_name,
                $surname,
                $business_name,
                $email,
                $mobile,
                $user_type,
                $user_status
            );
            array_push($users_output, $u);
        }

        return $users_output;
    }

    public static function get_user_data_by_access($report_id)
    {
        $conn = Database::connection();
        $query = 'SELECT users.grower_id, first_name, surname, business_name, email, mobile, user_type, user_status,
            CASE WHEN (report_id IS NOT NULL AND report_id = :report_id) THEN \'has_access\' ELSE \'no_access\'
                END access
                FROM
                    users
                LEFT JOIN reports_access ON users.grower_id = reports_access.grower_id
                ORDER BY
                    user_status
                DESC
                    ,
                    users.grower_id';
        $statement = $conn->prepare($query);
        $statement->bindValue(':report_id', $report_id);
        $statement->execute();
        $users = $statement->fetchall();
        $statement->closeCursor();

        $output = array();

        foreach ($users as $user) {
            $grower_id = $user['grower_id'];
            $first_name = $user['first_name'];
            $surname = $user['surname'];
            $business_name = $user['business_name'];
            $email = $user['email'];
            $mobile = $user['mobile'];
            $user_type = $user['user_type'];
            $user_status = $user['user_status'];
            $user_access = $user['access'];
            $u = new User(
                $grower_id,
                $first_name,
                $surname,
                $business_name,
                $email,
                $mobile,
                $user_type,
                $user_status
            );
            $output_users = array($u, $user_access);
            array_push($output, $output_users);
        }

        return $output;
    }

    public static function get_user_by_number($user_number)
    {
        $conn = Database::connection();
        $query = 'SELECT *
                  FROM users
                  WHERE grower_id = :grower_number';
        $statement = $conn->prepare($query);
        $statement->bindValue(':grower_number', $user_number);
        $statement->execute();
        $user = $statement->fetch();
        $statement->closeCursor();

        if ($user != false) {
            $user = new User(
                $user['grower_id'],
                $user['first_name'],
                $user['surname'],
                $user['business_name'],
                $user['email'],
                $user['mobile'],
                $user['user_type'],
                $user['user_status']
            );
        }

        return $user;
    }

    public static function get_users_by_number_starts_with($user_number)
    {
        $conn = Database::connection();
        $query = 'SELECT *
                  FROM users
                  WHERE grower_id LIKE :startwith';

        $startwith = $user_number . '%';

        $statement = $conn->prepare($query);
        $statement->bindValue(':startwith', $startwith);
        $statement->execute();
        $users = $statement->fetchall();
        $statement->closeCursor();

        $users_output = array();

        foreach ($users as $user) {
            $grower_id = $user['grower_id'];
            $first_name = $user['first_name'];
            $surname = $user['surname'];
            $business_name = $user['business_name'];
            $email = $user['email'];
            $mobile = $user['mobile'];
            $user_type = $user['user_type'];
            $user_status = $user['user_status'];
            $u = new User(
                $grower_id,
                $first_name,
                $surname,
                $business_name,
                $email,
                $mobile,
                $user_type,
                $user_status
            );
            array_push($users_output, $u);
        }

        return $users_output;
    }

    public static function get_user_by_email($email)
    {
        $conn = Database::connection();
        $query = 'SELECT *
                  FROM users
                  WHERE email = :email';
        $statement = $conn->prepare($query);
        $statement->bindValue(':email', $email);
        $statement->execute();
        $user = $statement->fetch();
        $statement->closeCursor();

        if ($user != false) {
            $user = new User(
                $user['grower_id'],
                $user['first_name'],
                $user['surname'],
                $user['business_name'],
                $user['email'],
                $user['mobile'],
                $user['user_type'],
                $user['user_status']
            );
        }

        return $user;
    }

    public static function get_user_password_hash($user_number)
    {
        $conn = Database::connection();
        $query = 'SELECT user_password
                  FROM users
                  WHERE grower_id = :grower_number';
        $statement = $conn->prepare($query);
        $statement->bindValue(':grower_number', $user_number);
        $statement->execute();
        $password = $statement->fetch();
        $statement->closeCursor();

        return $password;
    }

    public static function set_user_password($user, $new_password)
    {
        $conn = Database::connection();

        $user_id = $user->getUserID();

        $query = 'UPDATE users
                SET user_password = :user_password
                WHERE grower_id = :user_id';
        $statement = $conn->prepare($query);
        $statement->bindValue(':user_id', (int)$user_id);
        $statement->bindValue(':user_password', $new_password);
        $statement->execute();
        $statement->closeCursor();
    }

    public static function add_user($grower_number, $first_name, $surname, $business_name, $email, $mobile, $user_password, $user_type, $user_status)
    {
        $conn = Database::connection();
        $query = 'INSERT INTO users
                         (grower_id
                        , first_name
                        , surname
                        , business_name
                        , email
                        , mobile
                        , user_password
                        , user_type
                        , user_status)
                   VALUES (:grower_id
                        , :first_name
                        , :surname
                        , :business_name
                        , :email
                        , :mobile
                        , :user_password
                        , :user_type
                        , :user_status)';

        //hash password
        $user_password = password_hash($user_password, PASSWORD_DEFAULT);

        $statement = $conn->prepare($query);
        $statement->bindValue(':grower_id', (int)$grower_number);
        $statement->bindValue(':first_name', $first_name);
        $statement->bindValue(':surname', $surname);
        $statement->bindValue(':business_name', $business_name);
        $statement->bindValue(':email', $email);
        $statement->bindValue(':mobile', $mobile);
        $statement->bindValue(':user_password', $user_password);
        $statement->bindValue(':user_type', $user_type);
        $statement->bindValue(':user_status', (int)$user_status);
        $statement->execute();
        $statement->closeCursor();
    }

    public static function update_user(
        $user_id_to_change,
        $user_id,
        $first_name,
        $surname,
        $business_name,
        $email,
        $phone,
        $user_type,
        $user_status
    ) {
        $conn = Database::connection();
        $query = 'UPDATE users
                SET grower_id = :user_id
                , first_name = :first_name
                , surname = :surname
                , business_name = :business_name
                , email = :email
                , mobile = :phone
                , user_type = :user_type
                , user_status = :user_status
                WHERE grower_id = :user_id_to_change';
        $statement = $conn->prepare($query);
        $statement->bindValue(':user_id', (int)$user_id);
        $statement->bindValue(':first_name', $first_name);
        $statement->bindValue(':surname', $surname);
        $statement->bindValue(':business_name', $business_name);
        $statement->bindValue(':email', $email);
        $statement->bindValue(':phone', $phone);
        $statement->bindValue(':user_type', $user_type);
        $statement->bindValue(':user_status', (int)$user_status);
        $statement->bindValue(':user_id_to_change', (int)$user_id_to_change);
        $statement->execute();
        $statement->closeCursor();
    }
}
