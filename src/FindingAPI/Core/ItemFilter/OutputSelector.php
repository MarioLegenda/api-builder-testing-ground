<?php

namespace FindingAPI\Core\ItemFilter;

class OutputSelector extends AbstractFilter implements FilterInterface
{
    /**
     * @param array $filter
     * @return bool
     */
    public function validateFilter() : bool
    {
        $validSelectors = array('SellerInfo', 'StoreInfo', 'AspectHistogram', 'AspectHistogram');

        foreach ($this->filter as $filter) {
            if (in_array($filter, $validSelectors) === false) {
                $this->exceptionMessages[] = 'Invalid output selector '.$filter.'. Valid outputSelector types are '.implode(', ', $validSelectors);

                return false;
            }
        }

        return true;
    }
    /**
     * @param int $counter
     * @return string
     */
    public function urlify(int $counter) : string
    {
        $final = '';
        foreach ($this->filter as $filter) {
            $final.='outputSelector('.$counter.')='.$filter.'&';
        }

        return $final;
    }
}