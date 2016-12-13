<?php

namespace FindingAPI\Core\Request\Method;

use FindingAPI\Core\Information\OperationName;
use FindingAPI\Core\Request\Request;

class FindItemsByKeywordsRequest extends Request
{
    public function __construct(Request $request)
    {
        parent::__construct($request->getRequestParameters());

        $this->setOperationName(OperationName::FIND_ITEMS_BY_KEYWORDS);
    }
}