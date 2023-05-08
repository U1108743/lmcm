<?php
require_once('../library/user.php');
require_once('../library/report.php');

/**
 * CLASS: ReportAccessModel
 * 
 * Use this class to access the reports_access table in the database.
 * 
 */
class ReportAccessModel
{

    public static function get_user_access_by_report_id($user_id, $report_id)
    {
        $conn = Database::connection();
        $query = 'SELECT COUNT(1)
                  FROM reports_access
                  WHERE grower_id = :grower_id AND report_id = :report_id';
        $statement = $conn->prepare($query);
        $statement->bindValue(':grower_id', $user_id);
        $statement->bindValue(':report_id', $report_id);
        $statement->execute();
        $output = $statement->fetch();
        $statement->closeCursor();

        return $output[0];
    }

    public static function update_access($report_id, $grower_ids, $grower_id_list)
    {
        // For all growers who could have access
        foreach ($grower_id_list as $grower_id_list_item) {
            // Check current access
            $user_already_has_access = ReportAccessModel::get_user_access_by_report_id($grower_id_list_item, $report_id);

            // Check if $grower_ids is empty
            if (empty($grower_ids)) {
                // If it is empty only worry about removing
                // Only remove those with access
                if ($user_already_has_access == 1) {
                    // Remove user from table
                    $conn = Database::connection();
                    $query = 'DELETE
                               FROM reports_access
                               WHERE grower_id = :grower_id';
                    $statement = $conn->prepare($query);
                    $statement->bindValue(':grower_id', (int)$grower_id_list_item);
                    $statement->execute();
                    $statement->closeCursor();
                }
            }
            // Check if in list for gaining access
            foreach ($grower_ids as $grower_id) {
                $new_access = $grower_id_list_item == $grower_id;

                if ($new_access) {
                    // Only add if they don't have access already
                    if ($user_already_has_access == 0) {
                        // Add user into table
                        $conn = Database::connection();
                        $query = 'INSERT INTO reports_access (grower_id, report_id)
                   VALUES (:grower_id, :report_id)';
                        $statement = $conn->prepare($query);
                        $statement->bindValue(':grower_id', (int)$grower_id);
                        $statement->bindValue(':report_id', $report_id);
                        $statement->execute();
                        $statement->closeCursor();
                    }
                    break;
                }
                // If not in the list to add, remove if present
                // Case that the user already has access
                if ($user_already_has_access == 1) {
                    // Remove user from table
                    $conn = Database::connection();
                    $query = 'DELETE
                               FROM reports_access
                               WHERE grower_id = :grower_id';
                    $statement = $conn->prepare($query);
                    $statement->bindValue(':grower_id', (int)$grower_id_list_item);
                    $statement->execute();
                    $statement->closeCursor();
                }
                // If user doesn't have access and isn't getting access try next user in $grower_ids
            }
        }
    }
}
