<?php

namespace FindingAPI;

use FindingAPI\Core\Event\AddProcessorEvent;
use SDKBuilder\AbstractSDK;
use FindingAPI\Core\Event\ItemFilterEvent;
use FindingAPI\Core\Response\ResponseInterface;
use FindingAPI\Core\Response\ResponseProxy;

use FindingAPI\Core\Exception\ConnectException as FindingConnectException;
use SDKBuilder\Exception\RequestException;
use SDKBuilder\SDK\SDKInterface;
use FindingAPI\Core\Response\FakeGuzzleResponse;

class Finding extends AbstractSDK
{
    /**
     * @var ResponseInterface $response
     */
    private $response;

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
        $formats = array('xml', 'json');

        if (in_array($responseFormat, $formats) === false) {
            throw new RequestException('Invalid format \''.$responseFormat.'\'. Supported formats are '.implode(', ', $formats));
        }

        $this->getRequest()->getGlobalParameters()->getParameter('RESPONSE-DATA-FORMAT')->setValue($responseFormat);
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
                $this->getRequest()->getRequestParameters()->getParameter('response_data_format')->getValue()
            );

            return $response;
        }

        if ($this->response instanceof ResponseInterface) {
            return $this->response;
        }

        $response = new ResponseProxy(
            $this->responseToParse,
            $this->guzzleResponse,
            $this->getRequest()->getGlobalParameters()->getParameter('response_data_format')->getValue()
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

        $this->getEventDispatcher()->dispatch('finding.add_processor', new AddProcessorEvent($this->processorFactory, $this->getRequest()));
    }
}