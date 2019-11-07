<?php

namespace AutomatedReports;

class Reports {

    private $database;
    private $fileHandler;

    function __construct(){
        $this->database = new Repository();
        $this->fileHandler = new FileHandler();
    }

    function fetchData(){
        $queueReports = $this->findPendingReports();
        $queries = $this->fetchStoredQueries(implode(",", $queueReports));
       // var_dump($queries);
        foreach ($queries as $run){

            //$this->database->query($run->query);
            $this->database->query($run->task);
            $result = $this->database->resultSet();
            var_dump($result);
            $this->processData(json_encode($result, true));
        }
    }

    function findPendingReports(){
        $sql = 'select distinct  queryid from Reports.ReportsQueue where status = "pending"';
        $this->database->query($sql);
        $result = $this->database->resultSet();
        $results = array();
        //var_dump($result);
        foreach($result as $key => $value){
            $results[] = $value->queryid;
        }
        return $results;

    }

    function fetchStoredQueries($pendingReports){
        //$sql = 'select distinct query from Reports.Reports where id in (' . $pendingReports . ')';
        $sql = 'select distinct task from reporting.tasks';
        $this->database->query($sql);
        $results = $this->database->resultSet();
        return $results;
    }

    function processData($data){
        //will assign valid report name once tables are ready
        $fileName = rand(1,10).'test.csv';

        $formatData = json_decode($data, true);
        $headers = $this->formatHeaders($formatData);
        $rows = $this->formatRows($formatData);
        $this->createFile(array_unique($headers), $rows, $fileName);
    }

    function createFile($headers, $rows, $fileName){
        $this->uploadData($this->fileHandler->createCSVFile($headers, $rows, $fileName), $fileName);
    }

    function uploadData($toDestination, $reportName){
        $this->fileHandler->uploadFileToGoogleDrive($toDestination, $reportName);
        return 'ok';
    }


    public function formatRows($formatData): array
    {
        $rows = array();
        for ($i = 0; $i < count($formatData); $i++) {
            $firstRow = $formatData[$i];
            $row = array();
            foreach ($firstRow as $key => $value) {
                $row[] = $value;
            }
            $rows[] = $row;
        }
        return $rows;
    }

    public function formatHeaders($formatData): array
    {
        $headers = array();
        for($i = 0; $i < count($formatData); $i++){
            $firstRow = $formatData[$i];
            foreach($firstRow as $key => $value){
                $headers[] = $key;
            }
        }
        return $headers;
    }


}

