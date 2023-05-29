<?php 

/**
 * CLASS: User
 * 
 * User class for holding user information.
 * 
 * An instance of this class will contain all the same user information from a row in the users table of the database.
 * The only piece of data it does not hold is password data. Password data should be directly requested via
 * the user_db model.
 * 
 * This is a fairly simple class, it contains setters and getters for the member variables described in the top of the class.
 * 
 */

Class User {
    private $user_id;
    private $first_name;
    private $surname;
    private $business_name;
    private $email;
    private $phone;
    private $user_type;
    private $user_status;

    public function __construct($id, $fn, $sn, $bn, $em, $ph, $utype, $ustatus) {
        $this->user_id = $id;
        $this->first_name = $fn;
        $this->surname = $sn;
        $this->business_name = $bn;
        $this->email = $em;
        $this->phone = $ph;
        $this->user_type = $utype;
        $this->user_status = $ustatus;
    }

    public function getUserID() {
        return $this->user_id;
    }

    public function getFirstName() {
        return $this->first_name;
    }

    public function getSurname() {
        return $this->surname;
    }

    public function getBusinessName() {
        return $this->business_name;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getPhoneNo() {
        return $this->phone;
    }

    public function getUserType() {
        return $this->user_type;
    }

    public function getUserStatus() {
        return $this->user_status;
    }

    public function getUserDetails() {
        $user_details = array();
        $user_details['user_id'] = $this->getUserID();
        $user_details['first_name'] = $this->getFirstName();
        $user_details['surname'] = $this->getSurname();
        $user_details['business_name'] = $this->getBusinessName();
        $user_details['email'] = $this->getEmail();
        $user_details['phone'] = $this->getPhoneNo();
        $user_details['user_type'] = $this->getUserType();
        $user_details['user_status'] = $this->getUserStatus();
        return $user_details;
    }

    public function setUserID($id) {
        $this->user_id = $id;
    }

    public function setFirstName($fn) {
        $this->first_name = $fn;        
    }

    public function setSurname($sn) {
        $this->surname = $sn;
    }

    public function setBusinessName($bn) {
        $this->business_name = $bn;        
    }

    public function setEmail($em) {
        $this->email = $em;
    }

    public function setPhone($ph) {
        $this->phone = $ph;        
    }

    public function setUserType($utype) {
        $this->user_type = $utype;
    }

    public function setUserStatus($ustatus) {
        $this->user_status = $ustatus;
    }

    public function setUserDetails($id, $fn, $sn, $bn, $em, $ph, $utype, $ustatus) {
        $this->setUserID($id);
        $this->setFirstName($fn);
        $this->setSurname($sn);
        $this->setBusinessName($bn);
        $this->setEmail($em);
        $this->setPhone($ph);
        $this->setUserType($utype);
        $this->setUserStatus($ustatus);
    }

}

?>