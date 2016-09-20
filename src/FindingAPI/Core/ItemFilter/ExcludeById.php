<?php

namespace FindingAPI\Core\ItemFilter;

use Ebay\Finding\Exception\ArgumentException;
use Ebay\Finding\Exception\ConstraintException;
use FindingAPI\Core\Exception\ItemFilterException;

class ExcludeById extends AbstractConstraint implements ConstraintInterface
{
    /**
     * @throws ItemFilterException
     */
    public function checkConstraint()
    {
        if (count($this->value) > 25) {
            throw new ItemFilterException('Invalid argument for Category item filter. Up to 25 categories can be specified');
        }

        foreach ($this->value as $categoryId) {
            if (!is_numeric($categoryId)) {
                throw new ItemFilterException('Invalid argument for Category item filter. Values have to be category ids');
            }
        }
    }
}