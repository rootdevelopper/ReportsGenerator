<?php
/**
 * Created by PhpStorm.
 * User: hceudev
 * Date: 3/29/18
 * Time: 8:39 AM
 */

namespace AutomatedReports;


class FileHandler
{
    function status(){
        return 'ok';
    }

     function createCSVFile($headers, $rows, $fileName ){

         $file = fopen('reports/' . $fileName, 'w');
         fputcsv($file, $headers);
         foreach ($rows as $row) {
             fputcsv($file, $row);
         }
         fclose($file);
     }

     function uploadFile($source, $destination){


     }

}