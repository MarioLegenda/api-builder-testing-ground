<?php

namespace FindingAPI;

use SDKBuilder\AbstractApiFactory;
use SDKBuilder\APIFactoryInterface;
use SDKBuilder\Configuration\FindingConfiguration;
use FindingAPI\Core\Options\Options;
use SDKBuilder\Request\Method\MethodParameters;
use SDKBuilder\SDK\SDKInterface;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\Yaml\Yaml;
use SDKBuilder\Exception\SDKException;
use FindingAPI\Core\Request\Request;
use FindingAPI\Core\Options\Option;
use FindingAPI\Core\Listener\PreValidateItemFilters;
use FindingAPI\Core\Listener\PostValidateItemFilters;

use SDKBuilder\Request\RequestParameters;

class FindingFactory implements APIFactoryInterface
{
    /**
     * @return Finding
     * @throws SDKException
     */
    public function create() : SDKInterface
    {
        $config = Yaml::parse(file_get_contents(__DIR__ . '/config/finding.yml'));

        $processor = new Processor();

        $processor->processConfiguration(new FindingConfiguration(), $config);

        $request = new Request(
            new RequestParameters($config['sdk']['finding']['global_parameters']),
            new RequestParameters($config['sdk']['finding']['special_parameters'])
        );

        $methodParameters = new MethodParameters($config['sdk']['finding']['methods']);

        $options = new Options();

        $options->addOption(new Option(Options::GLOBAL_ITEM_FILTERS, true));
        $options->addOption(new Option(Options::INDIVIDUAL_ITEM_FILTERS, true));
        $options->addOption(new Option(Options::OFFLINE_MODE, false));

        $eventDispatcher = new EventDispatcher();

        $eventDispatcher->addListener('item_filter.pre_validate', array(new PreValidateItemFilters(), 'onPreValidate'));
        $eventDispatcher->addListener('item_filter.post_validate', array(new PostValidateItemFilters(), 'onPostValidate'));

        return new Finding($request, $methodParameters, $options, $eventDispatcher);
    }
}