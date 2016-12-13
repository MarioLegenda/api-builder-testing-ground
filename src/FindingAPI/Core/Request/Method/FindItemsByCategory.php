<?php

namespace FindingAPI\Core\Request\Method;

use FindingAPI\Core\Information\OperationName;
use FindingAPI\Core\Request\Parameter;
use FindingAPI\Core\Request\Request;

class FindItemsByCategory extends Request
{
    public function __construct(Request $request)
    {
        parent::__construct($request->getRequestParameters());

        $this->setOperationName(OperationName::FIND_ITEMS_BY_CATEGORY);

        $this->getRequestParameters()->addParameter(new Parameter(array(
            'name' => 'categoryId',
            'value' => null,
            'valid' => array(),
            'deprecated' => false,
            'type' => 'required',
        )));
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