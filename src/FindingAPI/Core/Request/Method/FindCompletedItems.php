<?php

namespace FindingAPI\Core\Request\Method;

use FindingAPI\Core\Request\Request;
use FindingAPI\Core\Request\RequestParameters;

class FindCompletedItems extends Request
{
    /**
     * FindItemsByKeywords constructor.
     * @param RequestParameters $globalParameters
     * @param RequestParameters $specialParameters
     */
    public function __construct(RequestParameters $globalParameters, RequestParameters $specialParameters)
    {
        parent::__construct($globalParameters, $specialParameters);

        $this->getGlobalParameters()->getParameter('operation_name')->setValue('findCompletedItems');
    }

    /**
     * @param string $searchString
     * @return Request
     */
    public function addKeywords(string $searchString) : Request
    {
        $this->getSpecialParameters()->getParameter('keywords')->setValue(urlencode($searchString));

        return $this;
    }

    public function setCategoryId(int $categoryId) : Request
    {
        $this->getSpecialParameters()->getParameter('category_id')->setValue($categoryId);

        return $this;
    }
}