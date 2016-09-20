<?php

namespace FindingAPI\Core\ItemFilter;

use FindingAPI\Core\Exception\ItemFilterException;
use StrongType\ArrayType;

class Condition extends AbstractConstraint implements ConstraintInterface
{
    private $allowedValues;
    /**
     * @param string $key
     * @param string $value
     */
    public function __construct($key, $value)
    {
        parent::__construct($key, $value);

        $this->allowedValues = new ArrayType(array(
            'text-values' => array('New', 'Used', 'Unspecified'),
            'id-values' => array(1000, 1500, 1750, 2000, 2500, 3000, 4000, 5000, 6000, 7000),
        ));
    }
    /**
     * @throws ItemFilterException
     */
    public function checkConstraint()
    {
        $uniqueValues = array_unique($this->value);

        foreach ($uniqueValues as $val) {
            if (!$this->allowedValues->inArray($val, 'text-values') and !$this->allowedValues->inArray($val, 'id-values')) {
                throw new ItemFilterException('Invalid value supplied for condition item filter');
            }
        }
    }
}