<?php 

/**
 * CLASS: Report
 * 
 * report class for holding report information.
 * 
 * An instance of this class will contain all the same report information from a row in the reports table of the database.
 * The only piece of data it does not hold is report data. Report data should be directly requested via
 * the report_db model.
 * 
 * This is a fairly simple class, it contains setters and getters for the member variables described in the top of the class.
 * 
 */

Class Report {
    private $report_id;
    private $report_filename ;
    private $report_file_type;
    private $upload_date;
    private $report_size;

    public function __construct($id, $fn, $ft, $ud, $rs) {
        $this->report_id = $id;
        $this->report_filename = $fn;
        $this->report_file_type = $ft;
        $this->upload_date = $ud;
        $this->report_size = $rs;
    }

    public function getReportID() {
        return $this->report_id;
    }

    public function getReportFilename() {
        return $this->report_filename;
    }

    public function getReportFileType() {
        return $this->report_file_type;
    }

    public function getUploadDate() {
        return $this->upload_date;
    }

    public function getReportSize() {
        return $this->report_size;
    }

    public function getFormattedReportSize() {
        $units = array('B', 'KiB', 'MiB', 'GiB', 'TiB'); 
        $bytes = $this->report_size;
        $bytes = max($bytes, 0); 
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024)); 
        $pow = min($pow, count($units) - 1); 
        $bytes /= pow(1024, $pow);
    
        return round($bytes, 2) . ' ' . $units[$pow]; 
    }

    public function getReportDetails() {
        $report_details = array();
        $report_details['report_id'] = $this->getReportID();
        $report_details['report_filename'] = $this->getReportFilename();
        $report_details['report_file_type'] = $this->getReportFileType();
        $report_details['upload_date'] = $this->getUploadDate();
        $report_details['report_size'] = $this->getReportSize();
        return $report_details;
    }

    public function setReportID($id) {
        $this->report_id = $id;
    }

    public function setReportFilename($fn) {
        $this->report_filename = $fn;        
    }

    public function setReportFileType($ft) {
        $this->report_file_type = $ft;
    }

    public function setUploadDate($ud) {
        $this->upload_date = $ud;
    }

    public function setReportSize($rs) {
        $this->report_size = $rs;        
    }

    public function setreportDetails($id, $fn, $ft, $ud, $rs) {
        $this->setReportID($id);
        $this->setReportFilename($fn);
        $this->setReportFileType($ft);
        $this->setUploadDate($ud);
        $this->setReportSize($rs);
    }

}

?>