<?php

/**
 * CLASS: ConsignmentModel
 * 
 * This class is used to access the consignment_data and entry_data tables in the database.
 * 
 * Primarily it will be used for consignment submissions which is performed in the grower consignment views.
 * 
 * Main features:
 * - submit a consignment to consignment_data table
 * - submit entry data to the entry_data table
 * - get consignmentid by consignment id
 * - get entryid by entry id
 * 
 * The last two function are for checking if there already exists a consignmentID or entryID in the database.
 * They are both used in the helper class IDGeneator below.
 * Essentially they are helper functions to make sure there are no duplicate consignmentid and entryids being submitted
 * to the database. The database would not allow submissions with duplicate ids because of database key constraints,
 * so these function checks avoids submission failure at the database level.
 * 
 */

class ConsignmentModel {

    public static function submit_consignment_data($grower_number, $consignment_date, $market_location, $comment) {
        $conn = Database::connection();
        $query = 'INSERT INTO consignment_data (
                          consignment_id
                        , grower_id
                        , week_number
                        , week_commencing
                        , consignment_date
                        , market_location
                        , comment
                        )
                   VALUES (
                          :consignment_id
                        , :grower_id
                        , :week_number
                        , :week_commencing
                        , :consignment_date
                        , :market_location
                        , :comment
                        )';
    
        //Get week number and week commencing date
        $date = new DateTime($consignment_date);
        $week_number = $date->format('W');
        $week_commencing = ($date->format('w') != 1) ? $date->modify('last monday')->format('Y-m-d') : $consignment_date;

        //Generate consignment id
        $consignment_id = IDGenerator::create_consignment_id();
    
        $statement = $conn->prepare($query);
        $statement->bindValue(':consignment_id', $consignment_id);
        $statement->bindValue(':grower_id', (int)$grower_number);
        $statement->bindValue(':week_number', (int)$week_number);
        $statement->bindValue(':week_commencing', $week_commencing);
        $statement->bindValue(':consignment_date', $consignment_date);
        $statement->bindValue(':market_location', $market_location);
        $statement->bindValue(':comment', $comment);
        $statement->execute();
        $statement->closeCursor();
        return $consignment_id;
    }

    public static function submit_entry_data($consignment_id, $fruit_variety, $fruit_size, $package_type, $quantity, $price) {
        $conn = Database::connection();
        $query = 'INSERT INTO entry_data (
                          entry_id
                        , consignment_id
                        , variety
                        , fruit_size
                        , package_type
                        , sale_quantity
                        , price
                        )
                   VALUES (
                          :entry_id
                        , :consignment_id
                        , :variety
                        , :fruit_size
                        , :package_type
                        , :sale_quantity
                        , :price
                        )';

        //Generate entry id  
        $entry_id = IDGenerator::create_entry_id();
    
        $statement = $conn->prepare($query);
        $statement->bindValue(':entry_id', $entry_id);
        $statement->bindValue(':consignment_id', $consignment_id);
        $statement->bindValue(':variety', $fruit_variety);
        $statement->bindValue(':fruit_size', (int)$fruit_size);
        $statement->bindValue(':package_type', $package_type);
        $statement->bindValue(':sale_quantity', (int)$quantity);
        $statement->bindValue(':price', (float)$price);
        $statement->execute();
        $statement->closeCursor();
    }

    public static function get_consignment_by_id($consignment_id) {
        $conn = Database::connection();
        $query = 'SELECT *
                    FROM consignment_data
                    WHERE consignment_id = :consignment_id';
        $statement = $conn->prepare($query);
        $statement->bindValue(':consignment_id', $consignment_id);
        $statement->execute();
        $consignment_id = $statement->fetch();
        $statement->closeCursor();
        return $consignment_id;
    }

    public static function get_entry_by_id($entry_id) {
        $conn = Database::connection();
        $query = 'SELECT *
                    FROM entry_data
                    WHERE entry_id = :entry_id';
        $statement = $conn->prepare($query);
        $statement->bindValue(':entry_id', $entry_id);
        $statement->execute();
        $entry_id = $statement->fetch();
        $statement->closeCursor();
        return $entry_id;
    }

}

/**
 * CLASS: IDGenerator
 * 
 * Helper class to generate unique consignmentids and entryids for consignment submissions
 * 
 * These functions will generator a unique hex and check if the ids exist in the consignment and entry tables.
 * If they do exists they will generate a new number and check again until it is unique.
 * 
 */

class IDGenerator {

    public static function generate_id($bytes) {
        return bin2hex(random_bytes($bytes));
    }
    
    public static function create_consignment_id() {
        $consignment_unique = false;
        $consignment_id = 0;
        while(!$consignment_unique) {
            $consignment_id = self::generate_id(4);
            $check = ConsignmentModel::get_consignment_by_id($consignment_id);
            $consignment_unique = is_array($check) ? false : true;
        }
        return 'c-' . $consignment_id;
    }
    
    public static function create_entry_id() {
        $entry_unique = false;
        $entry_id = 0;
        while(!$entry_unique) {
            $entry_id = self::generate_id(4);
            $check = ConsignmentModel::get_entry_by_id($entry_id);
            $entry_unique = is_array($check) ? false : true;
        }
        return 'e-' . $entry_id;
    }
}
