<?php

namespace EbaySDK;

use EbaySDK\SDK\FindingFactory;
use FindingAPI\EbayApiInterface;

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
     * @return EbayApiInterface
     */
    public function createFindingApi(bool $singleton = true) : EbayApiInterface
    {
        if ($singleton === false) {
            $this->sdkRepository['finding'] = FindingFactory::create($this->securityAppname);
        }

        if (!$this->sdkRepository['finding'] instanceof EbayApiInterface) {
            $this->sdkRepository['finding'] = FindingFactory::create($this->securityAppname);
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