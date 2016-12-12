<?php

namespace FindingAPI\Core\Request;

use FindingAPI\Core\Exception\RequestException;
use GuzzleHttp\Client;
use FindingAPI\Definition\SearchDefinitionInterface;
use FindingAPI\Definition\DefinitionValidator;
use FindingAPI\Definition\Definition;
use FindingAPI\Core\Exception\FindingApiException;
use FindingAPI\Core\ItemFilter\ItemFilterStorage;
use FindingAPI\Core\Exception\ItemFilterException;
use FindingAPI\Core\Exception\DefinitionException;

use GuzzleHttp\Psr7\Response as GuzzleResponse;

class Request
{
    /**
     * @var ItemFilterStorage
     */
    private $itemFilterStorage;
    /**
     * @var Options $options
     */
    private $options;
    /**
     * @var array $definitions
     */
    private $definitions = array();
    /**
     * @var RequestParameters $parameters
     */
    private $parameters;

    /**
     * Request constructor.
     * @param RequestParameters $requestParameters
     */
    public function __construct(RequestParameters $requestParameters)
    {
        $this->parameters = $requestParameters;

        $this->itemFilterStorage = new ItemFilterStorage();

        $this->options = new Options();

        Definition::initiate($this->options);
    }
    /**
     * @param string $serviceVersion
     * @return Request
     */
    public function setServiceVersion(string $serviceVersion) : Request
    {
        $this->parameters->setParameter('SERVICE-VERSION', $serviceVersion);

        return $this;
    }
    /**
     * @param string $method
     * @return Request
     * @throws RequestException
     */
    public function setMethod(string $method) : Request
    {
        if (RequestParameters::REQUEST_METHOD_GET !== strtolower($method) and RequestParameters::REQUEST_METHOD_POST !== strtolower($method)) {
            throw new RequestException('Unknown request method '.$method.'. Only GET and POST are allowed');
        }

        $this->parameters->setParameter('method', strtolower($method));

        return $this;
    }
    /**
     * @param string $buyerPostalCode
     * @return Request
     * @throws FindingApiException
     */
    public function setBuyerPostalCode(string $buyerPostalCode) : Request
    {
        $this->parameters->setParameter('buyerPostalCode', $buyerPostalCode);

        if (!$this->itemFilterStorage->hasItemFilter('BuyerPostalCode')) {
            throw new FindingApiException('Item filter BuyerPostalCode does not exists. Check FinderSearch::getItemFilterStorage()->addItemFilter() method');
        }

        $this->itemFilterStorage->updateItemFilterValue('BuyerPostalCode', array($buyerPostalCode));

        return $this;
    }
    /**
     * @param string $sortOrder
     * @return Request
     * @throws FindingApiException
     */
    public function setSortOrder(string $sortOrder) : Request
    {
        $this->parameters->setParameter('sortOrder', $sortOrder);

        if (!$this->itemFilterStorage->hasItemFilter('SortOrder')) {
            throw new FindingApiException('Item filter SortOrder does not exists. Check FinderSearch::getItemFilterStorage()->addItemFilter() method');
        }

        $this->itemFilterStorage->updateItemFilterValue('SortOrder', array($sortOrder));

        return $this;
    }
    /**
     * @param int $pagination
     * @param string $paginationType
     * @return Request
     * @throws FindingApiException
     */
    public function setPaginationInput(int $pagination, string $paginationType) : Request
    {
        $this->parameters->setParameter('paginationInput', $pagination);

        if (!$this->itemFilterStorage->hasItemFilter('PaginationInput')) {
            throw new FindingApiException('Item filter PaginationInput does not exists. Check FinderSearch::getItemFilterStorage()->addItemFilter() method');
        }

        $this->itemFilterStorage->updateItemFilterValue('PaginationInput', array($paginationType));

        return $this;
    }
    /**
     * @param string $operationName
     * @return Request
     * @throws RequestException
     */
    public function setOperationName(string $operationName) : Request
    {
        $this->parameters->setParameter('OPERATION-NAME', $operationName);

        return $this;
    }
    /**
     * @param string $format
     * @return Request
     * @throws RequestException
     */
    public function setResponseDataFormat(string $format) : Request
    {
        $allowedFormat = array('xml', 'json');
        $format = strtolower($format);

        if (RequestParameters::RESPONSE_DATA_FORMAT_XML !== $format and RequestParameters::RESPONSE_DATA_FORMAT_JSON !== $format) {
            throw new RequestException('Response format can only be '.implode(', ', $allowedFormat));
        }

        $this->parameters->setParameter('RESPONSE-DATA-FORMAT', $format);

        return $this;
    }
    /**
     * @param array $outputSelector
     * @return Request
     * @throws ItemFilterException
     */
    public function setOutputSelector(array $outputSelector) : Request
    {
        if (!$this->itemFilterStorage->hasItemFilter('OutputSelector')) {
            throw new ItemFilterException('Item filter OutputSelector does not exists. Check FinderSearch::getItemFilterStorage()->addItemFilter() method');
        }

        $this->itemFilterStorage->updateItemFilterValue('OutputSelector', $outputSelector);

        return $this;
    }
    /**
     * @param string $searchString
     * @return Request
     */
    public function addSearch(string $searchString) : Request
    {
        $definition = Definition::customDefinition($searchString);

        $definition->validateDefinition();

        $this->definitions[] = $definition;

        return $this;
    }
    /**
     * @param string $itemFilter
     * @param array $value
     * @return Request
     * @throws ItemFilterException
     */
    public function addItemFilter(string $itemFilterName, array $value) : Request
    {
        if (!$this->itemFilterStorage->hasItemFilter($itemFilterName)) {
            throw new ItemFilterException('Item filter '.$itemFilterName.' does not exists. Check FinderSearch::getItemFilterStorage()->addItemFilter() method');
        }

        $this->itemFilterStorage->updateItemFilterValue($itemFilterName, $value);

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
     * @return ItemFilterStorage
     */
    public function getItemFilterStorage() : ItemFilterStorage
    {
        return $this->itemFilterStorage;
    }
    /**
     * @return bool
     */
    public function isRequestValid() : bool
    {
        return $this->parameters->valid();
    }
    /**
     * @return RequestParameters
     */
    public function getRequestParameters() : RequestParameters
    {
        return $this->parameters;
    }
    /**
     * @return array
     */
    public function getDefinitions()
    {
        return $this->definitions;
    }
    /**
     * @param string $request
     */
    public function sendRequest(string $request) : GuzzleResponse
    {
        $client = new Client();

        return $client->request($this->getRequestParameters()->getParameter('method')->getValue(), $request);
    }
}