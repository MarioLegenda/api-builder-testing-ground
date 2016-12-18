<?php

namespace FindingAPI\Core\Request;

use FindingAPI\Core\Exception\{
    FindingApiException, ItemFilterException, RequestParametersException
};
use FindingAPI\Core\Request\Method\FindItemsByKeywordsRequest;

class RequestValidator
{
    /**
     * @var array $itemFilters
     */
    private $request;
    /**
     * RequestValidator constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    /**
     * @throws FindingApiException
     * @throws ItemFilterException
     */
    public function validate()
    {
        $globalParameters = $this->request->getGlobalParameters();

        $domainParameter = $globalParameters[0];

        if (!$domainParameter->getType()->isStandalone()) {
            throw new RequestParametersException('The first configuration value under \'global_parameters\' has to be of \'standalone\' type because it is meant to be the domain part of the url');
        }

        $itemFilterStorage = $this->request->getItemFilterStorage();

        $addedItemFilters = $itemFilterStorage->filterAddedFilter(array('SortOrder', 'PaginationInput'));

        foreach ($addedItemFilters as $name => $value) {
            $itemFilterData = $itemFilterStorage->getItemFilter($name);

            $itemFilter = $itemFilterStorage->getItemFilterInstance($name);
            $itemFilterValue = $itemFilterData['value'];

            if ($itemFilter->validateFilter($itemFilterValue) !== true) {
                throw new ItemFilterException((string) $itemFilter);
            }
        }
    }
}