<?php

namespace FindingAPI\Core\Request\Method;

use FindingAPI\Core\Request\Request;
use FindingAPI\Core\Request\RequestParameters;

class FindItemsIneBayStores extends Request
{
    /**
     * FindItemsIneBayStores constructor.
     * @param RequestParameters $globalParameters
     * @param RequestParameters $specialParameters
     */
    public function __construct(RequestParameters $globalParameters, RequestParameters $specialParameters)
    {
        parent::__construct($globalParameters, $specialParameters);

        $this->getGlobalParameters()->getParameter('operation_name')->setValue('findItemsIneBayStores');
    }
    /**
     * @param string $storeName
     * @return Request
     */
    public function setStoreName(string $storeName) : Request
    {
        $this->getSpecialParameters()->getParameter('store_name')->setValue($storeName);

        return $this;
    }
}