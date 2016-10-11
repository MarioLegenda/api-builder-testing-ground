<?php

namespace FindingAPI\Core\ResponseParser;

use FindingAPI\Core\Response;
use FindingAPI\Core\ResponseParser\ResponseItem\AspectHistogramContainer;
use FindingAPI\Core\ResponseParser\ResponseItem\Child\Aspect;
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
        $name = $this->simpleXml->getName();
        $docNamespace = $this->simpleXml->getDocNamespaces();

        $rootItem = new RootItem($name);
        $rootItem->setNamespace($docNamespace[array_keys($docNamespace)[0]]);
        $rootItem->setAck((string) $this->simpleXml->ack);
        $rootItem->setTimestamp((string) $this->simpleXml->timestamp);
        $rootItem->setVersion((string) $this->simpleXml->version);

        if (isset($this->simpleXml->aspectHistogramContainer)) {
            $aspectItems = $this->simpleXml->aspectHistogramContainer->getChildren();

            $aspectHistogramContainer = new AspectHistogramContainer($this->simpleXml->aspectHistogramContainer->getName());

            foreach ($aspectItems as $aspectItem) {
                $aspect = new Aspect(
                    $aspectItem['name'],
                    $aspectItem->valueHistogram['valueName'],
                    $aspectItem->valueHistogram->count
                );

                $aspectHistogramContainer->addAspect($aspect);
            }

            $this->responseItems['aspectHistogram'] = $aspectHistogramContainer;
        }

        $this->responseItems['rootItem'] = $rootItem;

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
}