<?php

namespace AutomatedReports;


class FileHandler
{
    private $googleDrive;
    private $filesPath = 'reports/';

    function status(){
        return 'ok';
    }

    function __construct()
    {
        $this->googleDrive = new GoogleDriveFileUploader();
    }

    function createCSVFile($headers, $rows, $fileName ){
         $file = fopen($this->filesPath . $fileName, 'w');
         //$file = fopen('reports/' . $fileName, 'w');
         fputcsv($file, $headers);
         foreach ($rows as $row) {
             fputcsv($file, $row);
         }
         fclose($file);
     }

     function uploadFileToGoogleDrive(){
        $this->googleDrive->setFiles($this->filesPath);
     }
}