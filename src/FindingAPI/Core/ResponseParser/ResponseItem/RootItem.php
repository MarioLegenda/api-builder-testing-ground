<?php

namespace FindingAPI\Core\ResponseParser\ResponseItem;

class RootItem implements ResponseItemInterface
{
    /**
     * @var string $timestamp
     */
    private $timestamp;
    /**
     * @var string $ack
     */
    private $ack;
    /**
     * @var string $version
     */
    private $version;
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
    /**
     * @param string $version
     * @return RootItem
     */
    public function setVersion(string $version) : RootItem
    {
        $this->version = $version;

        return $this;
    }
    /**
     * @return string
     */
    public function getVersion() : string
    {
        return $this->version;
    }
    /**
     * @param string $ack
     * @return RootItem
     */
    public function setAck(string $ack) : RootItem
    {
        $this->ack = $ack;

        return $this;
    }
    /**
     * @return string
     */
    public function getAck() : string
    {
        return $this->ack;
    }
    /**
     * @param string $timestamp
     * @return RootItem
     */
    public function setTimestamp(string $timestamp) : RootItem
    {
        $this->timestamp = $timestamp;

        return $this;
    }
    /**
     * @return string
     */
    public function getTimestamp() : string
    {
        return $this->timestamp;
    }
}