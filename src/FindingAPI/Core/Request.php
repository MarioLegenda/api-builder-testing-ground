<?php

namespace FindingAPI\Core;

use FindingAPI\Core\Cache\CacheProxy;
use FindingAPI\Core\Exception\RequestException;
use GuzzleHttp\Client;
use Symfony\Component\Yaml\Yaml;
use FindingAPI\Definition\SearchDefinitionInterface;
use FindingAPI\Definition\Exception\DefinitionException;
use FindingAPI\Definition\DefinitionValidator;
use FindingAPI\Definition\DefinitionFactory;
use FindingAPI\Core\Exception\FindingApiException;
use FindingAPI\Core\ItemFilter\ItemFilterStorage;

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
     * @param array|null $parameters
     */
    public function __construct()
    {
        if (CacheProxy::instance()->has('config.yml')) {
            $config = CacheProxy::instance()->get('config.yml');
            $this->parameters = new RequestParameters($config['parameters']);
        } else {
            $config = Yaml::parse(file_get_contents(__DIR__.'/config.yml'))['finding'];
            CacheProxy::instance()->put('config.yml', $config);
            $this->parameters = new RequestParameters($config['parameters']);
        }


        $this->itemFilterStorage = new ItemFilterStorage();

        $this->options = new Options();

        DefinitionFactory::initiate($this->options);
    }

    /**
     * @param string $url
     * @return Request
     * @throws RequestException
     */
    public function setEbayUrl(string $url) : Request
    {
        $this->parameters->setParameter('ebay_url', $url);

        return $this;
    }

    /**
     * @param string $serviceVersion
     * @return Request
     * @throws Exception\RequestException
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
        if (RequestParameters::REQUEST_METHOD_GET !== $method and RequestParameters::REQUEST_METHOD_POST !== $method) {
            throw new RequestException('Unknown request method '.$method.'. Only GET and POST are allowed');
        }

        $this->parameters->setParameter('method', strtolower($method));

        return $this;
    }

    /**
     * @param string $buyerPostalCode
     * @return Request
     * @throws RequestException
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
     * @throws Exception\ItemFilterException
     * @throws FindingApiException
     * @throws RequestException
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
     * @param string $securityId
     * @return Request
     * @throws RequestException
     */
    public function setSecurityAppId(string $securityId) : Request
    {
        $this->parameters->setParameter('SECURITY-APPNAME', $securityId);

        return $this;
    }


    /**
     * @param SearchDefinitionInterface $definition
     * @return Request
     */
    public function addSearch(SearchDefinitionInterface $definition) : Request
    {
        try {
            $definition->validateDefinition();
        } catch (DefinitionException $e) {
            if ($this->options->hasOption(Options::SMART_GUESS_SYSTEM)) {
                $definitionMethod = (new DefinitionValidator())->findDefinition($definition->getDefinition());

                if ($definitionMethod === false) {
                    throw new DefinitionException($e->getMessage());
                }

                $definition = DefinitionFactory::$definitionMethod($definition->getDefinition());

                $definition->validateDefinition();
            }
        }

        $this->definitions[] = $definition;

        return $this;
    }

    /**
     * @param $itemFilter
     * @param $value
     * @return Request
     */
    public function addItemFilter(string $itemFilterName, array $value, $validator = null) : Request
    {
        if (!$this->itemFilterStorage->hasItemFilter($itemFilterName)) {
            throw new FindingApiException('Item filter '.$itemFilterName.' does not exists. Check FinderSearch::getItemFilterStorage()->addItemFilter() method');
        }

        $this->itemFilterStorage->updateItemFilterValue($itemFilterName, $value);

        if ($validator !== null) {
            $this->itemFilterStorage->updateItemFilterValidator($itemFilterName, $validator);
        }

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
     * @param string $definitionType
     */
    public function sendRequest(string $request)
    {
        $client = new Client();

        $response = $client->request($this->getRequestParameters()->getParameter('method')->getValue(), $request);

        //var_dump((string) $response->getBody());
    }
}