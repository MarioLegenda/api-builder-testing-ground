<?php

namespace FindingAPI;

use FindingAPI\Core\Listener\AddProcessorListener;
use SDKBuilder\AbstractApiFactory;
use FindingAPI\Core\Configuration\FindingConfiguration;
use FindingAPI\Core\Options\Options;
use SDKBuilder\Event\CompileTimeEvent;
use SDKBuilder\SDK\SDKInterface;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\Yaml\Yaml;
use SDKBuilder\Exception\SDKException;
use FindingAPI\Core\Options\Option;
use FindingAPI\Core\Listener\PreValidateItemFilters;
use FindingAPI\Core\Listener\PostValidateItemFilters;

class FindingFactory extends AbstractApiFactory
{
    /**
     * @return Finding
     * @throws SDKException
     */
    public function create() : SDKInterface
    {
        $config = Yaml::parse(file_get_contents(__DIR__ . '/config/finding.yml'));

        $api = $this->createApi($config);

        $this->eventDispatcher->addListener('item_filter.pre_validate', array(new PreValidateItemFilters(), 'onPreValidate'));
        $this->eventDispatcher->addListener('item_filter.post_validate', array(new PostValidateItemFilters(), 'onPostValidate'));
        $this->eventDispatcher->addListener('sdk.pre_compile', array(new AddProcessorListener(), 'onAddProcessor'));

        return $api;
    }
}