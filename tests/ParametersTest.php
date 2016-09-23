<?php

require __DIR__.'/../vendor/autoload.php';

use FindingAPI\Core\Request;
use FindingAPI\Core\RequestParameters;
use Symfony\Component\Yaml\Yaml;
use FindingAPI\Core\Parameter;
use FindingAPI\Core\Exception\RequestException;

class ParametersTest extends PHPUnit_Framework_TestCase
{
    /**
     * @expectedException FindingAPI\Core\Exception\RequestException
     */
    public function testNameFailure()
    {
        $paramter = new Parameter();
        $paramter
            ->setName('')
            ->setType('required')
            ->setValue('budala')
            ->setValid(array('budala', 'idiot'))
            ->setSynonyms(array('other-name', 'by-name'));

        $paramter->validateParameter();
    }
    /**
     * @expectedException FindingAPI\Core\Exception\RequestException
     */
    public function testValueFailure()
    {
        $paramter = new Parameter();
        $paramter
            ->setName('test-name')
            ->setType('required')
            ->setValue('kreten')
            ->setValid(array('budala', 'idiot'))
            ->setSynonyms(array('other-name', 'by-name'));

        $paramter->validateParameter();
    }
    /**
     * @expectedException FindingAPI\Core\Exception\RequestException
     */
    public function testTypeFailure()
    {
        $paramter = new Parameter();
        $paramter
            ->setName('test-name')
            ->setType('required')
            ->setValue('')
            ->setValid(array('budala', 'idiot'))
            ->setSynonyms(array('other-name', 'by-name'));

        $paramter->validateParameter();
    }
    /**
     * @expectedException FindingAPI\Core\Exception\RequestException
     */
    public function testValidFailure()
    {
        $paramter = new Parameter();
        $paramter
            ->setName('test-name')
            ->setType('required')
            ->setValue('kretenčina')
            ->setValid(array('budala', 'idiot'))
            ->setSynonyms(array('other-name', 'by-name'));

        $paramter->validateParameter();
    }

    public function testParameterValidity()
    {
        $paramter = new Parameter();
        $paramter
            ->setName('test-name')
            ->setType('required')
            ->setValue('budala')
            ->setValid(array('budala', 'idiot'))
            ->setSynonyms(array('other-name', 'by-name'));

        $paramter->validateParameter();
    }
    /**
     * @expectedException FindingAPI\Core\Exception\RequestException
     */
    public function testRequestParameters()
    {
        $request = new Request();

        $requestParameters = $request->getRequestParameters();

        $requestParameters->markDeprecated('method');

        $this->assertTrue($requestParameters->isDeprecated('method'), '\'method should be deprecated\'');

        $requestParameters->unmarkDeprecated('method');

        $this->assertFalse($requestParameters->isDeprecated('method'), '\'method\' should not be deprecated');

        $requestParameters->setParameter('method', 'post');

        $this->assertEquals('post', $requestParameters->getParameter('method')->getValue(), '\'method\' parameter should be \'post\'');

        $paramter = new Parameter();
        $paramter
            ->setName('test-name')
            ->setType('required')
            ->setValue('budala')
            ->setValid(array('budala', 'idiot'))
            ->setSynonyms(array('other-name', 'by-name'));

        $requestParameters->addParameter($paramter);

        $this->assertTrue($requestParameters->hasParameter('test-name'), 'RequestParameters should contain \'test-name\' Parameter');

        $requestParameters->removeParameter($requestParameters->getParameter('test-name'));

        $this->assertFalse($requestParameters->hasParameter('test-name'), 'RequestParameters should not contain \'test-name\' Parameter');

        $requestParameters->addParameter($paramter);

        $paramter->setName('some-other-name');

        $requestParameters->replaceParameter($paramter);

        $this->assertTrue($requestParameters->hasParameter('some-other-name'), 'RequestParameters should contain \'some-other-name\' Parameter');

        $this->assertInstanceOf('FindingAPI\Core\Parameter', $requestParameters->getParameter('other-name'));
        $this->assertInstanceOf('FindingAPI\Core\Parameter', $requestParameters->getParameter('by-name'));

        $requestParameters->lock();

        $requestParameters->setParameter('method', 'get');

        $this->assertFalse($requestParameters->isLocked(), 'RequestParameters should not be locked');

        $requestParameters->unlock();

        return $requestParameters;
    }

    public function testRequestParametersValidity()
    {
        $request = new Request();

        $request->setOperationName('findItemsByKeywords');

        $requestParameters = $request->getRequestParameters();

        $paramter = new Parameter();
        $paramter
            ->setName('test-name')
            ->setType('required')
            ->setValue('budala')
            ->setValid(array('budala', 'idiot'))
            ->setSynonyms(array('other-name', 'by-name'));

        $requestParameters->addParameter($paramter);

        $requestParameters->valid();
    }
}