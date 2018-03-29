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

//    //what should I test if there is no return?
//    function testShould_Create_File(){
//        $test = new FileHandler();
//        $fileName = 'unitTest.csv';
//        $headers = array("id", "company", "name", "TotalHours");
//        $rows = array(array("300", "unitTestCo","unitT", "100"));
//        $test-> $this->assertEquals(null, $test->createCSVFile($headers, $rows, $fileName));
//    }

    function testStatus(){
        $test = new FileHandler();
        $this->assertEquals('ok', $test->status());
    }
}