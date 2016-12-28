<?php

namespace SDKBuilder;

use SDKBuilder\Exception\SDKBuilderException;
use SDKBuilder\SDK\SDKInterface;

class SDKBuilder
{
    /**
     * @var static EbaySDK $instance
     */
    private static $instance;
    /**
     * @var array $sdkRepository
     */
    private $sdkRepository = array();
    /**
     * @return SDKBuilder
     */
    public static function inst()
    {
        self::$instance = (self::$instance instanceof self) ? self::$instance : new self();

        return self::$instance;
    }
    /**
     * @param string $apiKey
     * @param string $objectString
     * @return SDKBuilder
     * @throws SDKBuilderException
     */
    public function registerApi(string $apiKey, string $objectString) : SDKBuilder
    {
        if ($this->isRegisteredApi($apiKey)) {
            throw new SDKBuilderException('There is already a registered api with name \''.$apiKey.'\'');
        }

        if (!class_exists($objectString)) {
            throw new SDKBuilderException('Class \''.$objectString.'\' does not exist and cannot be instantiated');
        }

        $this->sdkRepository[$apiKey] = $objectString;

        return $this;
    }
    /**
     * @param string $apiKey
     * @return bool
     */
    public function isRegisteredApi(string $apiKey) : bool
    {
        return array_key_exists($apiKey, $this->sdkRepository);
    }
    /**
     * @param string $apiKey
     * @return SDKInterface
     */
    public function create(string $apiKey) : SDKInterface
    {
        if (!$this->isRegisteredApi($apiKey)) {
            throw new SDKBuilderException('SDK with name \''.$apiKey.'\' not found');
        }

        $api = $this->sdkRepository[$apiKey];

        if ($api instanceof SDKInterface) {
            return $api;
        }

        $this->sdkRepository[$apiKey] = (new $api())->create();

        return $this->sdkRepository[$apiKey];
    }
}