<?php

namespace FindingAPI\Core;

use FindingAPI\Core\Exception\FindingApiException;
use FindingAPI\Core\Exception\ItemFilterException;
use FindingAPI\Core\Request;
use Symfony\Component\Yaml\Yaml;
use StrongType\ArrayType;

class RequestValidator
{
    /**
     * @var array $itemFilters
     */
    private $request;
    /**
     * ItemFilterProcessor constructor.
     * @param Request $itemFilters
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    /**
     * @void
     */
    public function validate()
    {
        $itemFilters = $this->request->getItemFilterStorage();
        $definitions = $this->request->getDefinitions();

        if (empty($definitions)) {
            throw new FindingApiException('You have\'t specified any search words');
        }

        $addedItemFilters = $itemFilters->filterAddedFilter();

        foreach ($addedItemFilters as $name => $value) {
            $itemFilterData = $itemFilters->getItemFilter($name);

            $validator = $itemFilterData['object'];
            $itemFilterValue = $itemFilterData['value'];

            if (is_string($validator)) {
                $itemFilter = new $validator($name);

                if ($itemFilter->validateFilter($itemFilterValue) !== true) {
                    throw new ItemFilterException((string) $itemFilter);
                }

                continue;
            }

            if (is_callable($validator)) {
                $valid = $validator->__invoke($name, $itemFilterValue);

                if ($valid !== true) {
                    if (!is_string($valid)) {
                        throw new ItemFilterException('If you add a callable validator to a filter, validator must return either true (if valid) or a string that will be the exception message if validation has failed');
                    }

                    throw new ItemFilterException($valid);
                }

                continue;
            }

            throw new \RuntimeException('Unable to validate item filter '.$name.'. If you added a new filter or change an existing one, check you closure validator');
        }
    }
}