<?php

namespace FindingAPI\Core\Request;

use FindingAPI\Definition\Definition;
use FindingAPI\Core\ItemFilter\ItemFilterStorage;

use FindingAPI\Core\Exception\{ FindingApiException, ItemFilterException };

use SDKBuilder\Exception\RequestException;
use SDKBuilder\Request\AbstractRequest;
use SDKBuilder\Request\RequestParameters;

class Request extends AbstractRequest
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
     */
    public function __construct(RequestParameters $globalParameters, RequestParameters $specialParameters)
    {
        parent::__construct($globalParameters, $specialParameters);

        $this->itemFilterStorage = new ItemFilterStorage();

        $this->options = new Options();

        Definition::initiate($this->options);
    }
    /**
     * @param string $method
     * @return AbstractRequest
     * @throws RequestException
     */
    public function setMethod(string $method) : AbstractRequest
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
     * @return AbstractRequest
     * @throws RequestException
     */
    public function setServiceVersion(string $serviceVersion) : AbstractRequest
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
        if (!$this->itemFilterStorage->hasItemFilter('PaginationInput')) {
            throw new FindingApiException('Item filter PaginationInput does not exists. Check FinderSearch::getItemFilterStorage()->addItemFilter() method');
        }

        $this->itemFilterStorage->updateItemFilterValue('PaginationInput', array($paginationType));

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
     * @return array
     */
    public function getDefinitions()
    {
        return $this->definitions;
    }
}