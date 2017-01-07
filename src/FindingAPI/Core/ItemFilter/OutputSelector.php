<?php

namespace FindingAPI\Core\ItemFilter;

use FindingAPI\Core\Information\OutputSelector as InformationOutputSelector;

class OutputSelector extends AbstractFilter implements FilterInterface
{
    /**
     * @return bool
     */
    public function validateFilter() : bool
    {
        $validSelectors = InformationOutputSelector::instance()->getAll();

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
        $counter = 0;
        $final = '';
        foreach ($this->filter as $filter) {
            $final.='outputSelector('.$counter.')='.$filter.'&';

            $counter++;
        }

        return $final;
    }
}