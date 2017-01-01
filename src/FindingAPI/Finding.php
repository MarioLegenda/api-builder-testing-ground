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
    /**
     * @return SDKInterface
     * @throws FindingConnectException
     */
    public function send() : SDKInterface
    {
        $this->dispatchListeners();

        parent::send();

        return $this;
    }

    public function setResponseFormat(string $responseFormat)
    {
        $formats = array('xml', 'json');

        if (in_array($responseFormat, $formats) === false) {
            throw new RequestException('Invalid format \''.$responseFormat.'\'. Supported formats are '.implode(', ', $formats));
        }

        $this->request->getGlobalParameters()->getParameter('RESPONSE-DATA-FORMAT')->setValue($responseFormat);
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
                $this->request->getRequestParameters()->getParameter('response_data_format')->getValue()
            );

            return $response;
        }

        if ($this->response instanceof ResponseInterface) {
            return $this->response;
        }

        $response = new ResponseProxy(
            $this->responseToParse,
            $this->guzzleResponse,
            $this->request->getGlobalParameters()->getParameter('response_data_format')->getValue()
        );

        unset($this->responseToParse);
        unset($this->guzzleResponse);

        $this->response = $response;

        return $this->response;
    }

    private function dispatchListeners()
    {
        $this->eventDispatcher->dispatch('item_filter.pre_validate', new ItemFilterEvent($this->request->getItemFilterStorage()));
        $this->eventDispatcher->dispatch('item_filter.post_validate', new ItemFilterEvent($this->request->getItemFilterStorage()));

        $this->eventDispatcher->dispatch('finding.add_processor', new AddProcessorEvent($this->processorFactory, $this->request));
    }
}