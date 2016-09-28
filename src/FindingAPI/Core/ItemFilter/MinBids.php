<?php
/**
 * Created by PhpStorm.
 * User: marioskrlec
 * Date: 28/09/16
 * Time: 17:15
 */

namespace FindingAPI\Core\ItemFilter;


class MinBids extends AbstractConstraint implements FilterInterface
{
    /**
     * @param array $filter
     * @return bool
     */
    public function validateFilter(array $filter) : bool
    {
        if (!$this->genericValidation($filter, 1)) {
            return false;
        }

        $filter = $filter[0];

        if ($filter < 0) {
            $this->exceptionMessages[] = $this->name.' has to be an integer greater than or equal to 0';

            return false;
        }

        return true;
    }
}