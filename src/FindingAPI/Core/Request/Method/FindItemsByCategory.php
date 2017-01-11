<?php

namespace FindingAPI\Core\Request\Method;

use FindingAPI\Core\Request\Request;
use SDKBuilder\Dynamic\DynamicStorage;
use SDKBuilder\Request\RequestParameters;

class FindItemsByCategory extends Request
{
    /**
     * FindItemsByKeywords constructor.
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

        $this->getGlobalParameters()->getParameter('operation_name')->setValue('findItemsByCategory');
    }
    /**
     * @param int $categoryId
     * @return Request
     */
    public function setCategoryId(int $categoryId) : Request
    {
        $this->getSpecialParameters()->getParameter('category_id')->setValue($categoryId);

        return $this;
    }
}