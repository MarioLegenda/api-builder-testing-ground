<?php

namespace EbaySDK\SDK;

use FindingAPI\Core\Exception\FindingApiException;
use FindingAPI\Core\Options\Options;
use FindingAPI\Core\Request\Method\MethodParameters;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\Yaml\Yaml;
use FindingAPI\Core\Request\RequestParameters;
use EbaySDK\Exception\SDKException;
use FindingAPI\Finding;
use FindingAPI\Core\Request\Request;
use FindingAPI\Core\Request\Parameter;
use FindingAPI\Core\Options\Option;
use FindingAPI\Core\Listener\PreValidateItemFilters;
use FindingAPI\Core\Listener\PostValidateItemFilters;

class FindingFactory
{
    /**
     * @param string $securityAppname
     * @param RequestParameters $parameters
     * @return Finding
     * @throws SDKException
     */
    public static function create(RequestParameters $parameters = null)
    {
        $config = Yaml::parse(file_get_contents(__DIR__.'/../config/finding.yml'))['ebay_sdk']['finding'];

        $request = new Request(
            new RequestParameters($config['global_parameters']),
            new RequestParameters($config['special_parameters'])
        );

        $methodParameters = new MethodParameters($config['methods']);

        $options = new Options();

        $options->addOption(new Option(Options::GLOBAL_ITEM_FILTERS, true));
        $options->addOption(new Option(Options::INDIVIDUAL_ITEM_FILTERS, true));
        $options->addOption(new Option(Options::OFFLINE_MODE, false));

        $eventDispatcher = new EventDispatcher();

        $eventDispatcher->addListener('item_filter.pre_validate', array(new PreValidateItemFilters(), 'onPreValidate'));
        $eventDispatcher->addListener('item_filter.post_validate', array(new PostValidateItemFilters(), 'onPostValidate'));

        return new Finding($request, $options, $eventDispatcher, $methodParameters);
    }
}