<?php

namespace FindingAPI\Core\ItemFilter;

interface ConstraintInterface
{
    /**
     * @return bool
     */
    public function checkConstraint();
}