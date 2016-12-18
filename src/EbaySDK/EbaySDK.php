<?php

namespace EbaySDK;

use EbaySDK\SDK\FindingFactory;
use FindingAPI\Core\Request\RequestParameters;
use FindingAPI\EbayApiInterface;
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
     * @var RequestParameters $injectableRequestParameters
     */
    private $injectableRequestParameters;
    /**
     * @return EbaySDK
     */
    public static function inst()
    {
        self::$instance = (self::$instance instanceof self) ? self::$instance : new self();

        return self::$instance;
    }
    /**
     * @param RequestParameters $parameters
     * @return EbaySDK
     */
    public function setParameters(RequestParameters $parameters) : EbaySDK
    {
        $this->injectableRequestParameters = $parameters;

        return $this;
    }
    /**
     * @param bool $singleton
     * @param RequestParameters|null $parameters
     * @return Finding
     */
    public function createFindingApi(bool $singleton = true, RequestParameters $parameters = null) : Finding
    {
        if ($singleton === false) {
            $this->sdkRepository['finding'] = FindingFactory::create($parameters);
        }

        if (!$this->sdkRepository['finding'] instanceof Finding) {
            $this->sdkRepository['finding'] = FindingFactory::create($parameters);
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