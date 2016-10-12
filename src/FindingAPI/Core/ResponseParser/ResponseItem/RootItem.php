<?php

namespace FindingAPI\Core\ResponseParser\ResponseItem;

class RootItem extends AbstractItem implements ResponseItemInterface
{
    /**
     * @var string $searchResultsCount
     */
    private $searchResultsCount;
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
     * @var string $itemNamespace
     */
    private $itemNamespace;
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
    /**
     * @param string $count
     * @return RootItem
     */
    public function setSearchResultsCount(string $count) : RootItem
    {
        $this->searchResultsCount = $count;

        return $this;
    }
    /**
     * @return string
     */
    public function getSearchResultsCount() : string
    {
        return $this->searchResultsCount;
    }
}