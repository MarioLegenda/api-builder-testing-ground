<?php

namespace EbaySDK\SDK;

use FindingAPI\Core\Options\Options;
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
    public static function create(string $securityAppname)
    {
        $config = Yaml::parse(file_get_contents(__DIR__.'/../config/finding.yml'))['finding'];

        $requestParameters = new RequestParameters($config['parameters']);

        if ($securityAppname === null) {
            throw new SDKException('When using EbaySDK for the first time, you have to provide SECURITY-APPNAME. Go to https://go.developer.ebay.com/ to sign up');
        }

        $requestParameters->addParameter(new Parameter(array(
            'name' => 'SECURITY-APPNAME',
            'value' => $securityAppname,
            'valid' => array(),
            'type' => 'required',
            'deprecated' => false,
        )));

        $request = new Request($requestParameters);

        $options = new Options();

        $options->addOption(new Option(Options::GLOBAL_ITEM_FILTERS, true));
        $options->addOption(new Option(Options::INDIVIDUAL_ITEM_FILTERS, true));
        $options->addOption(new Option(Options::OFFLINE_MODE, false));

        $eventDispatcher = new EventDispatcher();

        $eventDispatcher->addListener('item_filter.pre_validate', array(new PreValidateItemFilters(), 'onPreValidate'));
        $eventDispatcher->addListener('item_filter.post_validate', array(new PostValidateItemFilters(), 'onPostValidate'));

        return new Finding($request, $options, $eventDispatcher);
    }
}