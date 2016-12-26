<?php

namespace EbaySDK;

use EbaySDK\SDK\FindingFactory;
use FindingAPI\Core\Request\Method\MethodParameters;
use FindingAPI\Core\Request\RequestParameters;
use FindingAPI\Finding;

class EbaySDK
{
    /**
     * @var static EbaySDK $instance
     */
    private static $instance;
    /**
     * @var string $securityAppname
     */
    private $securityAppname;
    /**
     * @var array $sdkRepository
     */
    private $sdkRepository = array(
        'finding' => null,
    );
    /**
     * @return EbaySDK
     */
    public static function inst()
    {
        self::$instance = (self::$instance instanceof self) ? self::$instance : new self();

        return self::$instance;
    }
    /**
     * @param bool $singleton
     * @param RequestParameters|null $parameters
     * @param MethodParameters|null $methodParameters
     * @return Finding
     */
    public function createFindingApi(bool $singleton = true, RequestParameters $parameters = null, MethodParameters $methodParameters = null) : Finding
    {
        if ($singleton === false) {
            $this->sdkRepository['finding'] = FindingFactory::create($parameters, $methodParameters);
        }

        if (!$this->sdkRepository['finding'] instanceof Finding) {
            $this->sdkRepository['finding'] = FindingFactory::create($parameters, $methodParameters);
        }

        return $this->sdkRepository['finding'];
    }
    /**
     * @param string $securityAppname
     * @return EbaySDK
     */
    public function setSecurityAppName(string $securityAppname) : EbaySDK
    {
        $this->securityAppname = $securityAppname;

        return $this;
    }
}