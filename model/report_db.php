<?php
require_once('../library/user.php');
require_once('../library/report.php');

/**
 * CLASS: ReportModel
 * 
 * Use this class to access the reports table in the database.
 * 
 */
class ReportModel
{

    public static function get_reports()
    {
        $conn = Database::connection();
        $query = 'SELECT *
                  FROM reports_data';
        $statement = $conn->prepare($query);
        $statement->execute();
        $reports = $statement->fetchall();
        $statement->closeCursor();

        $reports_output = array();

        foreach ($reports as $report) {
            $report_id = $report['report_id'];
            $report_filename = $report['report_filename'];
            $report_file_type = $report['report_file_type'];
            $upload_date = $report['upload_date'];
            $report_size = $report['report_size'];
            $r = new Report(
                $report_id,
                $report_filename,
                $report_file_type,
                $upload_date,
                $report_size
            );
            array_push($reports_output, $r);
        }

        return $reports_output;
    }

    public static function get_report_by_number($report_number)
    {
        $conn = Database::connection();
        $query = 'SELECT *
                  FROM reports_data
                  WHERE report_id = :report_number';
        $statement = $conn->prepare($query);
        $statement->bindValue(':report_number', $report_number);
        $statement->execute();
        $report = $statement->fetch();
        $statement->closeCursor();

        if ($report != false) {
            $report = new Report(
                $report['report_id'],
                $report['report_filename'],
                $report['report_file_type'],
                $report['upload_date'],
                $report['report_size']
            );
        }

        return $report;
    }

    public static function get_reports_by_filename_contains($report_filename)
    {
        $conn = Database::connection();
        $query = 'SELECT *
                  FROM reports_data
                  WHERE report_filename LIKE :contains';

        $contains = '%' . $report_filename . '%';

        $statement = $conn->prepare($query);
        $statement->bindValue(':contains', $contains);
        $statement->execute();
        $reports = $statement->fetchall();
        $statement->closeCursor();

        $reports_output = array();

        foreach ($reports as $report) {
            $report_id = $report['report_id'];
            $report_filename = $report['report_filename'];
            $report_file_type = $report['report_file_type'];
            $upload_date = $report['upload_date'];
            $report_size = $report['report_size'];
            $r = new Report(
                $report_id,
                $report_filename,
                $report_file_type,
                $upload_date,
                $report_size
            );
            array_push($reports_output, $r);
        }

        return $reports_output;
    }

    public static function get_reports_by_access($grower_id)
    {
        $conn = Database::connection();
        $query = 'SELECT reports_data.report_id, report_filename, report_file_type, upload_date, report_size
                  FROM reports_data, reports_access
                  WHERE reports_access.grower_id = :grower_id';

        $statement = $conn->prepare($query);
        $statement->bindValue(':grower_id', $grower_id);
        $statement->execute();
        $reports = $statement->fetchall();
        $statement->closeCursor();

        $reports_output = array();

        foreach ($reports as $report) {
            $report_id = $report['report_id'];
            $report_filename = $report['report_filename'];
            $report_file_type = $report['report_file_type'];
            $upload_date = $report['upload_date'];
            $report_size = $report['report_size'];
            $r = new Report(
                $report_id,
                $report_filename,
                $report_file_type,
                $upload_date,
                $report_size
            );
            array_push($reports_output, $r);
        }

        return $reports_output;
    }

    public static function get_report_by_upload_date($upload_date)
    {
        $conn = Database::connection();
        $query = 'SELECT *
                  FROM reports_data
                  WHERE upload_date = :upload_date';
        $statement = $conn->prepare($query);
        $statement->bindValue(':upload_date', $upload_date);
        $statement->execute();
        $report = $statement->fetch();
        $statement->closeCursor();

        if ($report != false) {
            $report = new Report(
                $report['report_id'],
                $report['report_filename'],
                $report['report_file_type'],
                $report['upload_date'],
                $report['report_size']
            );
        }

        return $report;
    }

    public static function get_report_data($report_number)
    {
        $conn = Database::connection();
        $query = 'SELECT report_data
                  FROM reports_data
                  WHERE report_id = :report_number';
        $statement = $conn->prepare($query);
        $statement->bindValue(':report_number', $report_number);
        $statement->execute();
        $report_data = $statement->fetch();
        $statement->closeCursor();

        return $report_data;
    }

    public static function set_report_data($report, $new_report_data)
    {
        $conn = Database::connection();

        $report_id = $report->getReportID();

        $query = 'UPDATE reports_data
                SET report_data = :report_data
                WHERE report_id = :report_id';
        $statement = $conn->prepare($query);
        $statement->bindValue(':report_id', (int)$report_id);
        $statement->bindValue(':report_data', $new_report_data);
        $statement->execute();
        $statement->closeCursor();
    }

    public static function add_report($report_number, $report_filename, $report_file_type, $report_data, $upload_date, $report_size)
    {
        $conn = Database::connection();
        $query = 'INSERT INTO reports_data
                         (report_id
                        , report_filename
                        , report_file_type
                        , report_data
                        , upload_date
                        , report_size)
                   VALUES (:report_id
                        , :report_filename
                        , :report_file_type
                        , :report_data
                        , :upload_date
                        , :report_size)';

        $statement = $conn->prepare($query);
        $statement->bindValue(':report_id', (int)$report_number);
        $statement->bindValue(':report_filename', $report_filename);
        $statement->bindValue(':report_file_type', $report_file_type);
        $statement->bindValue(':report_data', $report_data);
        $statement->bindValue(':upload_date', $upload_date);
        $statement->bindValue(':report_size', $report_size);
        $statement->execute();
        $statement->closeCursor();
    }

    public static function update_report(
        $report_id_to_change,
        $report_id,
        $report_filename,
        $report_file_type,
        $report_data,
        $upload_date,
        $report_size,
    ) {
        $conn = Database::connection();
        $query = 'UPDATE reports_data
                SET report_id = :report_id
                , report_filename = :report_filename
                , report_file_type = :report_file_type
                , report_data = :report_data
                , upload_date = :upload_date
                , report_size = :report_size
                WHERE report_id = :report_id_to_change';
        $statement = $conn->prepare($query);
        $statement->bindValue(':report_id', (int)$report_id);
        $statement->bindValue(':report_filename', $report_filename);
        $statement->bindValue(':report_file_type', $report_file_type);
        $statement->bindValue(':report_data', $report_data);
        $statement->bindValue(':upload_date', $upload_date);
        $statement->bindValue(':report_size', $report_size);
        $statement->bindValue(':report_id_to_change', (int)$report_id_to_change);
        $statement->execute();
        $statement->closeCursor();
    }
}
