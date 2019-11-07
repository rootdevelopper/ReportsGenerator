<?php

namespace AutomatedReports;


class FileHandler
{
    private $googleDrive;
    private $filesPath = 'reports/';

    function __construct(){
        $this->googleDrive = new GoogleDriveFileUploader();
    }

    function createCSVFile($headers, $rows, $fileName )
    {
        $file = fopen($this->filesPath . $fileName, 'w');
        if (is_writable($this->filesPath)) {
            fputcsv($file, $headers);
            foreach ($rows as $row) {
                fputcsv($file, $row);
            }
            fclose($file);
            return $this->filesPath . $fileName;
        } else {
            print_r('The destination directory needs writable permissions');
        }
    }

     function uploadFileToGoogleDrive($toDestination, $reportName){
        $this->googleDrive->setFiles($toDestination, $reportName);
     }
}