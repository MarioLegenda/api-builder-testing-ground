<?php

namespace FindingAPI\Core\ResponseParser\ResponseItem\Child\Item;

use FindingAPI\Core\ResponseParser\ResponseItem\AbstractItem;

class Category extends AbstractItem
{
    /**
     * @var string $categoryId
     */
    private $categoryId;
    /**
     * @var string $categoryName
     */
    private $categoryName;
    /**
     * @return string
     */
    public function getCategoryId() : string
    {
        if ($this->categoryId === null) {
            $this->setCategoryId((string) $this->simpleXml->categoryId);
        }

        return $this->categoryId;
    }
    /**
     * @param string $categoryId
     * @return PrimaryCategory
     */
    public function setCategoryId(string $categoryId) : Category
    {
        $this->categoryId = $categoryId;

        return $this;
    }
    /**
     * @return string
     */
    public function getCategoryName() : string
    {
        if ($this->categoryName === null) {
            $this->setCategoryName((string) $this->simpleXml->categoryName);
        }

        return $this->categoryName;
    }
    /**
     * @param string $categoryName
     * @return PrimaryCategory
     */
    public function setCategoryName(string $categoryName) : Category
    {
        $this->categoryName = $categoryName;

        return $this;
    }
}