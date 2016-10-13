<?php

namespace FindingAPI\Core\ResponseParser\ResponseItem\Child;

use FindingAPI\Core\ResponseParser\ResponseItem\AbstractItem;
use FindingAPI\Core\ResponseParser\ResponseItem\AbstractItemIterator;

class Item extends AbstractItemIterator
{
    /**
     * @var string $viewItemUrl
     */
    private $viewItemUrl;
    /**
     * @var string $galleryUrl
     */
    private $galleryUrl;
    /**
     * @var PrimaryCategory $primaryCategory
     */
    private $primaryCategory;
    /**
     * @var string $globalId
     */
    private $globalId;
    /**
     * @var string $title
     */
    private $title;
    /**
     * @var string $itemId
     */
    private $itemId;
    /**
     * @param string $itemId
     * @return Item
     */
    public function setItemId(string $itemId) : Item
    {
        $this->itemId = $itemId;

        return $this;
    }
    /**
     * @return string
     */
    public function getItemId()
    {
        if ($this->itemId === null) {
            $this->setItemId((string) $this->simpleXml->itemId);
        }

        return $this->itemId;
    }
    /**
     * @param string $title
     * @return Item
     */
    public function setTitle(string $title) : Item
    {
        $this->title = $title;

        return $this;
    }
    /**
     * @return string
     */
    public function getTitle() : string
    {
        if ($this->title === null) {
            $this->setTitle((string) $this->simpleXml->{'title'});
        }

        return $this->title;
    }
    /**
     * @param string $globalId
     * @return Item
     */
    public function setGlobalId(string $globalId) : Item
    {
        $this->globalId = $globalId;

        return $this;
    }
    /**
     * @return string
     */
    public function getGlobalId() : string
    {
        if ($this->globalId === null) {
            $this->setGlobalId((string) $this->simpleXml->globalId);
        }

        return $this->globalId;
    }
    /**
     * @param PrimaryCategory $primaryCategory
     * @return $item
     */
    public function setPrimaryCategory(PrimaryCategory $primaryCategory) : Item
    {
        $this->primaryCategory = $primaryCategory;

        return $this;
    }
    /**
     * @return string
     */
    public function getPrimaryCategoryId() : string
    {
        return $this->primaryCategory->getCategoryId();
    }
    /**
     * @return string
     */
    public function getPrimaryCategoryName() : string
    {
        return $this->primaryCategory->getCategoryName();
    }
    /**
     * @param string $galleryUrl
     * @return Item
     */
    public function setGalleryUrl(string $galleryUrl) : Item
    {
        $this->galleryUrl = $galleryUrl;

        return $this;
    }
    /**
     * @return string
     */
    public function getGalleryUrl() : string
    {
        if ($this->galleryUrl === null) {
            $this->setGalleryUrl((string) $this->simpleXml->galleryURL);
        }

        return $this->galleryUrl;
    }
    /**
     * @param string $url
     * @return Item
     */
    public function setViewItemUrl(string $url) : Item
    {
        $this->viewItemUrl = $url;

        return $this;
    }
    /**
     * @return string
     */
    public function getViewItemUrl() : string
    {
        if ($this->viewItemUrl === null) {
            $this->setViewItemUrl((string) $this->simpleXml->viewItemURL);
        }

        return $this->viewItemUrl;
    }
}