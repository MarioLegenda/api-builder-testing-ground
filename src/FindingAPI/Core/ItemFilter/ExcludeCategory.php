<?php

namespace FindingAPI\Core\ItemFilter;

class ExcludeCategory extends AbstractFilter implements FilterInterface
{
    /**
     * @return bool
     */
    public function validateFilter() : bool
    {
        if (count($this->filter) > 25) {
            $this->exceptionMessages[] = 'ExcludeCategory item filter can accept up to 25 category ids';

            return false;
        }

        foreach ($this->filter as $value) {
            if (!is_numeric($value)) {
                $this->exceptionMessages['Value '.$value.' has to be a valid category number or a numeric string'];

                return false;
            }
        }

        return true;
    }
}