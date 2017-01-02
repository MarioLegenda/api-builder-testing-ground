<?php

namespace FindingAPI\Core\ResponseParser\ResponseItem\Child\Item;

use FindingAPI\Core\Response\ArrayConvertableInterface;
use FindingAPI\Core\ResponseParser\ResponseItem\AbstractItem;

class StoreInfo extends AbstractItem implements ArrayConvertableInterface
{
    /**
     * @var string $storeName
     */
    private $storeName;
    /**
     * @var string $storeUrl
     */
    private $storeUrl;
    /**
     * @param null $default
     * @return null|string
     */
    public function getStoreURL($default = null)
    {
        if ($this->storeUrl === null) {
            if (!empty($this->simpleXml->storeURL)) {
                $this->setStoreURL((string) $this->simpleXml->storeURL);
            }
        }

        if ($this->storeUrl === null and $default !== null) {
            return $default;
        }

        return $this->storeUrl;
    }
    /**
     * @param null $default
     * @return null|string
     */
    public function getStoreName($default = null)
    {
        if ($this->storeName === null) {
            if (!empty($this->simpleXml->storeName)) {
                $this->setStoreName((string) $this->simpleXml->storeName);
            }
        }

        if ($this->storeName === null and $default !== null) {
            return $default;
        }

        return $this->storeName;
    }
    /**
     * @return array
     */
    public function toArray(): array
    {
        return array(
            'storeName' => $this->getStoreName(),
            'storeUrl' => $this->getStoreURL(),
        );
    }

    private function setStoreURL(string $storeUrl) : StoreInfo
    {
        $this->storeUrl = $storeUrl;

        return $this;
    }

    private function setStoreName(string $storeName) : StoreInfo
    {
        $this->storeName = $storeName;

        return $this;
    }
}