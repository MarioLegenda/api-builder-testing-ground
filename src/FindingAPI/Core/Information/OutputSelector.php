<?php

namespace FindingAPI\Core\Information;

class OutputSelector
{
    const ASPECT_HISTOGRAM = 'AspectHistogram';
    const CATEGORY_HISTOGRAM = 'CategoryHistogram';
    const CONDITION_HISTOGRAM = 'ConditionHistogram';
    const GALLERY_INFO = 'GalleryInfo';
    const PICTURE_URL_LARGE = 'PictureURLLarge';
    const PICTURE_URL_SUPER_SIZE = 'PictureURLSuperSize';
    const SELLER_INFO = 'SellerInfo';
    const STORE_INFO = 'StoreInfo';
    const UNIT_PRICE_INFO = 'UnitPriceInfo';

    /**
     * @var array $outputSelectors
     */
    private $outputSelectors = array(
        'AspectHistogram',
        'CategoryHistogram',
        'ConditionHistogram',
        'GalleryInfo',
        'PictureURLLarge',
        'PictureURLSuperSize',
        'SellerInfo',
        'StoreInfo',
        'UnitPriceInfo',
    );
    /**
     * @var PaymentMethod $instance
     */
    private static $instance;
    /**
     * @return PaymentMethod
     */
    public static function instance()
    {
        self::$instance = (self::$instance instanceof self) ? self::$instance : new self();

        return self::$instance;
    }
    /**
     * @param string $method
     * @return mixed
     */
    public function has(string $method) : bool
    {
        return in_array($method, $this->outputSelectors) !== false;
    }
    /**
     * @param string $method
     * @return OutputSelector
     */
    public function add(string $method)
    {
        if ($this->has($method)) {
            return null;
        }

        $this->outputSelectors[] = $method;

        return $this;
    }
    /**
     * @return array
     */
    public function getAll()
    {
        return $this->outputSelectors;
    }
}