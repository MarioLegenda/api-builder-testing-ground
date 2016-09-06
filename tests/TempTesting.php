<?php

require __DIR__.'/../vendor/autoload.php';

use FindingAPI\FinderSearch;
use FindingAPI\Definition\Definition;
use FindingAPI\Request;

class TempTesting extends PHPUnit_Framework_TestCase
{
    public function testMain()
    {
        $request = new Request();
        
        $finderSearch->search(Definition::andOperator('baseball card'));
    }
}