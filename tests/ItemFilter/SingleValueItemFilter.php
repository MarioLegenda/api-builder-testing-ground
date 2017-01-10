<?php

namespace Test\ItemFilter;

use FindingAPI\Core\ItemFilter\AbstractFilter;
use FindingAPI\Core\ItemFilter\FilterInterface;
use SDKBuilder\Dynamic\AbstractDynamic;
use SDKBuilder\Dynamic\DynamicInterface;

class SingleValueItemFilter extends AbstractDynamic implements DynamicInterface
{
    /**
     * @return bool
     */
    public function validateDynamic() : bool
    {
        if (!$this->genericValidation($this->dynamicValue, 1)) {
            return false;
        }

        if (parent::checkBoolean($this->dynamicValue[0]) === false) {
            return false;
        }

        return true;
    }
}