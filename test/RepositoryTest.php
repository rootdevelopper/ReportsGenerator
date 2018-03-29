<?php

namespace AutomatedReports\Tests;

use AutomatedReports\Repository;
use PHPUnit\Framework\TestCase;

class RepositoryTest extends TestCase
{
  function testStatus(){
      $test = new Repository();
      $this->assertEquals('ok', $test->status());
  }

}