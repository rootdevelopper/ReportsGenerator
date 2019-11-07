<?php
/**
 * Created by PhpStorm.
 * User: hceudev
 * Date: 3/29/18
 * Time: 8:40 AM
 */

namespace AutomatedReports\Tests;

use AutomatedReports\FileHandler;
use PHPUnit\Framework\TestCase;

class FileHandlerTest extends Testcase
{
    function test_Should_Create_File(){
        $test = new FileHandler();
        $fileName = 'unitTest.csv';
        $headers = array("id", "company", "name", "TotalHours");
        $rows = array(array("300", "unitTestCo","unitT", "100"));
        $this->assertEquals(string, gettype($test->createCSVFile($headers, $rows, $fileName)));
    }

//    function test_files_Should_be_writable(){
//
//    }

}