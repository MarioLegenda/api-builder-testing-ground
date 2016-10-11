<?php

namespace FindingAPI\Core\ResponseParser\ResponseItem;

abstract class AbstractItem
{
    /**
     * @var string $itemName
     */
    protected $itemName;
    /**
     * RootItem constructor.
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->itemName = $name;
    }
    /**
     * @return string
     */
    public function getName() : string
    {
        return $this->itemName;
    }
}