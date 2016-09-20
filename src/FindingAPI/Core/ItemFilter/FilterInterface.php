<?php

namespace FindingAPI\Core\ItemFilter;

interface FilterInterface
{
    /**
     * @return bool
     */
    public function validateFilter(array $filter) : bool;
}