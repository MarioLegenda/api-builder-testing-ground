<?php

namespace FindingAPI;

use FindingAPI\Core\Event\AddProcessorEvent;
use SDKBuilder\AbstractSDK;
use FindingAPI\Core\Event\ItemFilterEvent;
use SDKBuilder\Exception\MethodParametersException;
use FindingAPI\Core\Options\Options;
use FindingAPI\Core\Request\RequestValidator;
use FindingAPI\Core\Request\Request;
use FindingAPI\Core\Response\ResponseInterface;
use FindingAPI\Core\Response\ResponseProxy;
use SDKBuilder\Processor\Factory\ProcessorFactory;
use SDKBuilder\Request\Method\MethodParameters;
use SDKBuilder\Request\Method\Method;

use FindingAPI\Core\Exception\ConnectException as FindingConnectException;
use SDKBuilder\SDK\SDKInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;
use FindingAPI\Core\Response\FakeGuzzleResponse;

class Finding extends AbstractSDK
{
    /**
     * @var ResponseInterface $response
     */
    private $response;
    /**
     * @var array $errors
     */
    private $errors = array();
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
                $this->request->getRequestParameters()->getParameter('RESPONSE-DATA-FORMAT')->getValue()
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