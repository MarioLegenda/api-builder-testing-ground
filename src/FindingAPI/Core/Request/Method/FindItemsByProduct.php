<?php

namespace FindingAPI\Core\Request\Method;

use FindingAPI\Core\Request\Request;
use SDKBuilder\Dynamic\DynamicStorage;
use SDKBuilder\Request\RequestParameters;

class FindItemsByProduct extends Request
{
    /**
     * FindItemsByProduct constructor.
     * @param RequestParameters $globalParameters
     * @param RequestParameters $specialParameters
     */
    public function __construct(
        RequestParameters $globalParameters,
        RequestParameters $specialParameters,
        DynamicStorage $dynamicStorage
    )
    {
        parent::__construct($globalParameters, $specialParameters, $dynamicStorage);

        $this->getGlobalParameters()->getParameter('operation_name')->setValue('findItemsByProduct');
    }
    /**
     * @param string $productIdType
     * @return Request
     */
    public function setProductIdType(string $productIdType) : Request
    {
        $this->getSpecialParameters()->getParameter('product_id_type')->setValue($productIdType);

        return $this;
    }
    /**
     * @param int $productId
     * @return Request
     */
    public function setProductId(int $productId) : Request
    {
        $this->getSpecialParameters()->getParameter('product_id')->setValue($productId);

        return $this;
    }
}