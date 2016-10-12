<?php

namespace FindingAPI\Core\ResponseParser\ResponseItem\Child;

use FindingAPI\Core\ResponseParser\ResponseItem\AbstractItem;

class PrimaryCategory extends AbstractItem
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
     * PrimaryCategory constructor.
     * @param string $name
     * @param string $categoryId
     * @param string $categoryName
     */
    public function __construct(string $name, string $categoryId, string $categoryName)
    {
        parent::__construct($name);

        $this->categoryId = $categoryId;
        $this->categoryName = $categoryName;
    }
    /**
     * @return string
     */
    public function getCategoryId() : string
    {
        return $this->categoryId;
    }
    /**
     * @return string
     */
    public function getCategoryName() : string
    {
        return $this->categoryName;
    }
}