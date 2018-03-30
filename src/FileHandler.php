<?php

namespace AutomatedReports;


class FileHandler
{
    private $googleDrive;
    private $filesPath = 'reports/';

    function __construct(){
        $this->googleDrive = new GoogleDriveFileUploader();
    }

    function createCSVFile($headers, $rows, $fileName ){

        $file = fopen($this->filesPath . $fileName, 'w');
         fputcsv($file, $headers);
         foreach ($rows as $row) {
             fputcsv($file, $row);
         }
         fclose($file);

        return $this->filesPath . $fileName;
     }

     function uploadFileToGoogleDrive($toDestination, $reportName){
        $this->googleDrive->setFiles($toDestination, $reportName);
     }
}