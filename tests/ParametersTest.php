<?php

namespace Test;

use FindingAPI\Core\Request\Parameter;
use FindingAPI\Core\Request\RequestParameters;
use Symfony\Component\Yaml\Yaml;

require __DIR__.'/../vendor/autoload.php';

class ParametersTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var array $config
     */
    private $config = array();
    /**
     * @var RequestParameters $globalParameters
     */
    private $globalParameters;
    /**
     * @var RequestParameters $specialParameters
     */
    private $specialParameters;

    public function initiate()
    {
        $this->config = Yaml::parse(file_get_contents(__DIR__.'/finding.yml'))['ebay_sdk']['finding'];
        $globalConfig = $this->config['global_parameters'];
        $specialConfig = $this->config['special_parameters'];

        $this->globalParameters = new RequestParameters($globalConfig);
        $this->specialParameters = new RequestParameters($specialConfig);
    }

    public function testUsability()
    {
        $this->initiate();

        $this->globalParameters->getParameter('operation_name')->setValue('findItemsByKeywords');

        $this->globalParameters->valid();
        $this->specialParameters->valid();

        $parameter = $this->globalParameters->getParameter('security_appname');

        $this->assertInstanceOf(Parameter::class, $parameter);

        $parameter = $this->globalParameters->getParameter('SECURITY-APPNAME');

        $this->assertInstanceOf(Parameter::class, $parameter);

        $parameter->validateParameter();
    }
}