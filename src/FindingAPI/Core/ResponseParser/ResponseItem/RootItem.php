<?php

namespace FindingAPI\Core\ResponseParser\ResponseItem;

class RootItem implements ResponseItemInterface
{
    /**
     * @var string $itemName
     */
    private $itemName;
    /**
     * @var string $itemNamespace
     */
    private $itemNamespace;
    /**
     * RootItem constructor.
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->itemName = $name;
    }
    /**
     * @param string $namespace
     * @return $this
     */
    public function setNamespace(string $namespace) : RootItem
    {
        $this->itemNamespace = $namespace;

        return $this;
    }
    /**
     * @return string
     */
    public function getNamespace() : string
    {
        return $this->itemNamespace;
    }
    /**
     * @return string
     */
    public function getName() : string
    {
        return $this->itemName;
    }
}