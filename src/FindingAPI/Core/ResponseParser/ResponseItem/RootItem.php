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
        if ($this->itemNamespace === null) {
            $docNamespace = $this->simpleXml->getDocNamespaces();

            $this->setNamespace($docNamespace[array_keys($docNamespace)[0]]);
        }

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
        if ($this->version === null) {
            $this->setVersion((string) $this->simpleXml->version);
        }

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
        if ($this->ack === null) {
            $this->setAck((string) $this->simpleXml->ack);
        }

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
        if ($this->timestamp === null) {
            $this->setTimestamp((string) $this->simpleXml->timestamp);
        }

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
     * @return int
     */
    public function getSearchResultsCount() : int
    {
        if ($this->searchResultsCount === null) {
            $this->searchResultsCount = (int) $this->simpleXml->searchResult['count'];
        }

        return $this->searchResultsCount;
    }
}