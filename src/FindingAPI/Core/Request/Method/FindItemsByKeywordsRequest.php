<?php

namespace FindingAPI\Core\Request\Method;

use FindingAPI\Core\Information\OperationName;
use FindingAPI\Core\Request\Request;

class FindItemsByKeywordsRequest extends Request
{
    public function __construct()
    {
        parent::__construct(__DIR__.'/../config.yml');

        $this->setOperationName(OperationName::FIND_ITEMS_BY_KEYWORDS);
    }
}