<?php

namespace FindingAPI\Core\Request;

use FindingAPI\Definition\Definition;

use FindingAPI\Core\Exception\{ FindingApiException, ItemFilterException };

use SDKBuilder\Dynamic\DynamicStorage;
use SDKBuilder\Exception\RequestException;

use SDKBuilder\Request\ { AbstractRequest, RequestInterface, RequestParameters };

class Request extends AbstractRequest
{
    /**
     * @var Options $options
     */
    private $options;
    /**
     * @var string $responseFormat
     */
    private $responseFormat = 'xml';
    /**
     * @var array $definitions
     */
    protected $definitions = array();
    /**
     * Request constructor.
     * @param RequestParameters $globalParameters
     * @param RequestParameters $specialParameters
     * @param DynamicStorage $dynamicStorage
     */
    public function __construct(
        RequestParameters $globalParameters,
        RequestParameters $specialParameters,
        DynamicStorage $dynamicStorage
    )
    {
        parent::__construct($globalParameters, $specialParameters, $dynamicStorage);

        $this->options = new Options();

        Definition::initiate($this->options);
    }
    /**
     * @param string $method
     * @return RequestInterface
     * @throws RequestException
     */
    public function setMethod(string $method) : RequestInterface
    {
        parent::setMethod($method);

        if ($this->getMethod() === 'post') {
            throw new RequestException('For FindingAPI, method can only be \'get\' because no other is needed');
        }

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
            throw new RequestException('Invalid response format. Valid formats are '.implode(', ', $validFormats).'. \''.$responseFormat.'\' given');
        }

        $this->responseFormat = $responseFormat;
    }
    /**
     * @return string
     */
    public function getResponseFormat() : string
    {
        return $this->responseFormat;
    }
    /**
     * @param string $serviceVersion
     * @return Request
     * @throws RequestException
     */
    public function setServiceVersion(string $serviceVersion) : Request
    {
        $globalParameters = $this->getGlobalParameters();

        if (!$globalParameters->hasParameter('service_version')) {
            throw new RequestException('\'service_version\' parameter not found');
        }

        $globalParameters->getParameter('service_version')->setValue($serviceVersion);

        return $this;
    }

    public function getServiceVersion() : string
    {
        if (!$this->getGlobalParameters()->getParameter('service_version')->getValue()) {
            throw new RequestException('\'service_version\' global_parameter not found');
        }

        return $this->getGlobalParameters()->getParameter('service_version')->getValue();
    }
    /**
     * @param string $buyerPostalCode
     * @return Request
     * @throws FindingApiException
     */
    public function setBuyerPostalCode(string $buyerPostalCode) : Request
    {
        if (!$this->dynamicsStorage->hasDynamic('BuyerPostalCode')) {
            throw new FindingApiException('Item filter BuyerPostalCode does not exists. Check FinderSearch::getItemFilterStorage()->addItemFilter() method');
        }

        $this->dynamicsStorage->updateDynamicValue('BuyerPostalCode', array($buyerPostalCode));

        return $this;
    }
    /**
     * @param string $sortOrder
     * @return Request
     * @throws FindingApiException
     */
    public function setSortOrder(string $sortOrder) : Request
    {
        if (!$this->dynamicsStorage->hasDynamic('SortOrder')) {
            throw new FindingApiException('Item filter SortOrder does not exists. Check FinderSearch::getItemFilterStorage()->addItemFilter() method');
        }

        $this->dynamicsStorage->updateDynamicValue('SortOrder', array($sortOrder));

        return $this;
    }
    /**
     * @param array $pagination
     * @return Request
     * @throws FindingApiException
     */
    public function setPaginationInput(array $pagination) : Request
    {
        if (!$this->dynamicsStorage->hasDynamic('PaginationInput')) {
            throw new FindingApiException('Item filter PaginationInput does not exists. Use FindingAPI::addDynamic() to add it');
        }

        $this->dynamicsStorage->updateDynamicValue('PaginationInput', array($pagination));

        return $this;
    }
    /**
     * @param array $outputSelector
     * @return Request
     * @throws ItemFilterException
     */
    public function setOutputSelector(array $outputSelector) : Request
    {
        if (!$this->dynamicsStorage->hasDynamic('OutputSelector')) {
            throw new ItemFilterException('Item filter OutputSelector does not exists. Check FinderSearch::getItemFilterStorage()->addItemFilter() method');
        }

        $this->dynamicsStorage->updateDynamicValue('OutputSelector', $outputSelector);

        return $this;
    }
    /**
     * @param int $option
     * @return Request
     */
    public function addOption(int $option) : Request
    {
        $this->options->addOption($option);

        return $this;
    }
    /**
     * @return array
     */
    public function getDefinitions()
    {
        return $this->definitions;
    }
}