<?php

namespace FindingAPI;

use FindingAPI\Core\Listener\AddProcessorListener;
use FindingAPI\Core\Listener\PreSendRequestListener;
use FindingAPI\Core\Listener\ValidateItemFiltersListener;
use SDKBuilder\AbstractApiFactory;
use SDKBuilder\Event\SDKEvent;
use SDKBuilder\SDK\SDKInterface;
use Symfony\Component\Yaml\Yaml;
use SDKBuilder\Exception\SDKException;

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
        
        return $api;
    }
}