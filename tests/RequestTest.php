<?php

require __DIR__.'/../vendor/autoload.php';

use FindingAPI\Core\Request;
use FindingAPI\Core\RequestParameters;
use Symfony\Component\Yaml\Yaml;

class RequestTest extends PHPUnit_Framework_TestCase
{
    public function testRequest()
    {
        $request = new Request();

        $requestParametes = $request->getRequestParameters();

        $config = Yaml::parse(file_get_contents(__DIR__.'/../src/FindingAPI/Core/config.yml'))['finding'];

        $requestParametes->setParameter('method', 'post');

        $this->assertEquals('post', $requestParametes->getParameter('method')->getValue());
        
        
    }
}