<?php

namespace Test;

use SDKBuilder\Request\Parameter;
use SDKBuilder\Request\RequestParameters;
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

        $this->globalParameters->validate();
        $this->specialParameters->validate();

        $parameter = $this->globalParameters->getParameter('security_appname');

        $this->assertInstanceOf(Parameter::class, $parameter);

        $parameter = $this->globalParameters->getParameter('SECURITY-APPNAME');

        $this->assertInstanceOf(Parameter::class, $parameter);

        $parameter->validateParameter();

        $newParameter = new Parameter('new_parameter', array(
            'representation' => 'newParameter',
            'value' => 6,
            'type' => array('required', 'optional'),
            'valid' => null,
            'deprecated' => false,
            'obsolete' => false,
            'throws_exception_if_deprecated' => false,
            'error_message' => 'Invalid value for %s and represented as %s',
        ));

        $newParameter->validateParameter();

        $this->specialParameters->addParameter($newParameter);

        $this->assertTrue($this->specialParameters->hasParameter('new_parameter'), 'new_parameter should have been added but it is not');
        $this->assertTrue($this->specialParameters->hasParameter('newParameter'), 'new_parameter should also be found as a representation of newParameter');

        $this->specialParameters->removeParameter('new_parameter');

        $this->assertFalse($this->specialParameters->hasParameter('new_parameter'), 'new_parameter should have been removed');
    }
}