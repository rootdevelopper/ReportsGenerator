<?php

namespace AutomatedReports\Tests;

use AutomatedReports\Reports;
use PHPUnit\Framework\TestCase;

class ReportsTest extends TestCase {

    function test_Should_Return_ids_for_Queries(){
        $test = new Reports();
        $mockIds = "1,2";
        $this->assertEquals('array', gettype($test->fetchStoredQueries($mockIds)));
    }
    /*How do you test if there is nothing to  return?*/
    function test_Should_FetchData(){
        $test = new Reports();
        $this->assertEquals('NULL', gettype($test->fetchData()));
    }
    /*How do you test if there is nothing to  return?*/
    function test_Should_ProcessData(){
        $test = new Reports();
        $testData = '[{"id":"1"}]';
        $this->assertEquals(null, $test->processData($testData));
    }

    function testUploadData(){
        $test = new Reports();
        $this->assertEquals('ok', $test->uploadData());
    }

    function test_Should_CreateFile(){
        $test = new Reports();
        $fileName = 'unitTest.csv';
        $headers = array("id", "company", "name", "TotalHours");
        $rows = array(array("300", "unitTestCo","unitT", "100"));
        $this->assertEquals(null, $test->createFile($headers, $rows, $fileName));
    }
}

