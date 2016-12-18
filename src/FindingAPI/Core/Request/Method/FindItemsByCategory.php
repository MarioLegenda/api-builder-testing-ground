<?php

namespace FindingAPI\Core\Request\Method;

use FindingAPI\Core\Information\OperationName;
use FindingAPI\Core\Request\Request;
use FindingAPI\Core\Request\RequestParameters;

class FindItemsByCategory extends Request
{
    /**
     * FindItemsByCategory constructor.
     * @param RequestParameters $parameters
     */
    public function __construct(RequestParameters $parameters)
    {
        parent::__construct($parameters);

        $this->setOperationName(OperationName::FIND_ITEMS_BY_CATEGORY);
    }
    /**
     * @param int $categoryId
     * @return Request
     */
    public function setCategoryId(int $categoryId) : Request
    {
        $this->getRequestParameters()->setParameter('categoryId', $categoryId);

        return $this;
    }
}