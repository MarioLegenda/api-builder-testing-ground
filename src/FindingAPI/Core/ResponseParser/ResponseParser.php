<?php

namespace FindingAPI\Core\ResponseParser;

use FindingAPI\Core\Response;
use FindingAPI\Core\ResponseParser\ResponseItem\AspectHistogramContainer;
use FindingAPI\Core\ResponseParser\ResponseItem\Child\Aspect;
use FindingAPI\Core\ResponseParser\ResponseItem\Child\Item;
use FindingAPI\Core\ResponseParser\ResponseItem\Child\PrimaryCategory;
use FindingAPI\Core\ResponseParser\ResponseItem\RootItem;
use GuzzleHttp\Psr7\Response as GuzzleResponse;

class ResponseParser
{
    /**
     * @var GuzzleResponse
     */
    private $guzzleResponse;
    /**
     * @var \SimpleXMLElement
     */
    private $simpleXml;
    /**
     * @var array $responseItems
     */
    private $responseItems = array(
        'rootItem' => null,
        'aspectHistogram' => null,
    );
    /**
     * ResponseParser constructor.
     * @param string $xmlString
     * @param GuzzleResponse $guzzleResponse
     */
    public function __construct(string $xmlString, GuzzleResponse $guzzleResponse)
    {
        $this->simpleXml = simplexml_load_string($xmlString);
        $this->guzzleResponse = $guzzleResponse;
    }
    /**
     * @return ResponseParser
     */
    public function parse() : ResponseParser
    {
        $this->createRootItem($this->simpleXml);
        $this->createAspectHistogramContainer($this->simpleXml);
        $this->createItemsContainer($this->simpleXml);

        return $this;
    }
    /**
     * @return ResponseParser
     */
    public function createResponse() : ResponseParser
    {
        return $this;
    }
    /**
     * @return Response
     */
    public function getResponse() : Response
    {
        return new Response($this->guzzleResponse, $this->responseItems);
    }

    private function createRootItem(\SimpleXMLElement $simpleXml)
    {
        $name = $simpleXml->getName();
        $docNamespace = $simpleXml->getDocNamespaces();

        $rootItem = new RootItem($name);
        $rootItem
            ->setNamespace($docNamespace[array_keys($docNamespace)[0]])
            ->setAck((string) $this->simpleXml->ack)
            ->setTimestamp((string) $this->simpleXml->timestamp)
            ->setVersion((string) $this->simpleXml->version)
            ->setSearchResultsCount((string) $this->simpleXml->searchResult['count']);

        $this->responseItems['rootItem'] = $rootItem;
    }

    private function createAspectHistogramContainer(\SimpleXMLElement $simpleXml)
    {
        if (isset($simpleXml->aspectHistogramContainer)) {
            $aspectItems = $simpleXml->aspectHistogramContainer->getChildren();

            $aspectHistogramContainer = new AspectHistogramContainer($simpleXml->aspectHistogramContainer->getName());

            foreach ($aspectItems as $aspectItem) {
                $aspect = new Aspect(
                    $aspectItem['name'],
                    $aspectItem->valueHistogram['valueName'],
                    $aspectItem->valueHistogram->count
                );

                $aspectHistogramContainer->addItem($aspect);
            }

            $this->responseItems['aspectHistogram'] = $aspectHistogramContainer;
        }
    }
    /**
     * @param \SimpleXMLElement $simpleXml
     */
    private function createItemsContainer(\SimpleXMLElement $simpleXml)
    {
        $items = $simpleXml->searchResult->children();

        foreach ($items as $item) {
            $productItem = new Item($item->getName());

            $productItem->setTitle((string) $item->{'title'});
            $productItem->setGlobalId((string) $item->globalId);
            $productItem->setItemId((string) $item->itemId);

            $primaryCategory = new PrimaryCategory(
                $simpleXml->primaryCategory->getName(),
                (string) $simpleXml->primaryCategory->categoryId,
                (string) $simpleXml->primaryCategory->categoryName
            );

            $productItem->setPrimaryCategory($primaryCategory);
        }
    }
}