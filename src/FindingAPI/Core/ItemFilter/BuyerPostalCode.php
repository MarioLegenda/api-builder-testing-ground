<?php

namespace FindingAPI\Core\ItemFilter;

use SDKBuilder\Dynamic\AbstractDynamic;
use SDKBuilder\Dynamic\DynamicInterface;

class BuyerPostalCode extends AbstractDynamic
{
    /**
     * @return bool
     */
    public function validateDynamic() : bool
    {
        return true;
    }
}