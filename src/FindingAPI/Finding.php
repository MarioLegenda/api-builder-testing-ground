<?php

namespace FindingAPI;

use FindingAPI\Core\Event\AddProcessorEvent;
use SDKBuilder\AbstractSDK;
use FindingAPI\Core\Event\ItemFilterEvent;
use FindingAPI\Core\Response\ResponseInterface;
use FindingAPI\Core\Response\ResponseProxy;

use FindingAPI\Core\Exception\ConnectException as FindingConnectException;
use SDKBuilder\Exception\RequestException;
use SDKBuilder\Exception\SDKException;
use SDKBuilder\SDK\SDKInterface;
use FindingAPI\Core\Response\FakeGuzzleResponse;

class Finding extends AbstractSDK
{
    /**
     * @var ResponseInterface $response
     */
    private $response;

    private $responseFormat;

    public function compile() : SDKInterface
    {
        parent::compile();

        $this->dispatchListeners();

        return $this;
    }
    /**
     * @param string $responseFormat
     * @throws RequestException
     */
    public function setResponseFormat(string $responseFormat)
    {
        $validFormats = array('xml', 'json');

        if (in_array($responseFormat, $validFormats) === false) {
            throw new SDKException('Invalid response format. Valid formats are '.implode(', ', $validFormats).'. \''.$responseFormat.'\' given');
        }

        $this->responseFormat = $responseFormat;
    }
    /**
     * @param string $inlineResponse
     * @return ResponseInterface
     */
    public function getResponse(string $inlineResponse = null) : ResponseInterface
    {
        if (is_string($inlineResponse)) {
            $response = new ResponseProxy(
                $inlineResponse,
                new FakeGuzzleResponse($inlineResponse),
                $this->responseFormat
            );

            return $response;
        }

        if ($this->response instanceof ResponseInterface) {
            return $this->response;
        }

        $response = new ResponseProxy(
            $this->responseToParse,
            $this->guzzleResponse,
            $this->responseFormat
        );

        unset($this->responseToParse);
        unset($this->guzzleResponse);

        $this->response = $response;

        return $this->response;
    }

    private function dispatchListeners()
    {
        $this->getEventDispatcher()->dispatch('item_filter.pre_validate', new ItemFilterEvent($this->getRequest()->getItemFilterStorage()));
        $this->getEventDispatcher()->dispatch('item_filter.post_validate', new ItemFilterEvent($this->getRequest()->getItemFilterStorage()));

        $this->getEventDispatcher()->dispatch('finding.add_processor', new AddProcessorEvent($this->getProcessorFactory(), $this->getRequest()));
    }
}