<?php

namespace Test\ItemFilter;

use FindingAPI\Core\ItemFilter\BaseFindingDynamic;

class MultipleValueItemFilter extends BaseFindingDynamic
{
    public function validateDynamic() : bool
    {
        if (!$this->genericValidation($this->dynamicValue)) {
            return false;
        }

        $allowedValues = new ArrayType(array(
            'text-values' => array('New', 'Used', 'Unspecified'),
            'id-values' => array(1000, 1500, 1750, 2000, 2500, 3000, 4000, 5000, 6000, 7000),
        ));

        $uniques = array_unique($this->dynamicValue);

        foreach ($uniques as $val) {
            if (!$allowedValues->inArray($val, 'text-values') and !$allowedValues->inArray($val, 'id-values')) {
                $this->exceptionMessages['Invalid argument for item filter '.$this->name.'. Please, refer to http://developer.ebay.com/devzone/finding/callref/types/ItemFilterType.html'];

                return false;
            }
        }

        $this->dynamicValue = $uniques;

        return true;
    }

    /**
     * @param int $counter
     * @return string
     */
    public function urlify(int $counter) : string
    {
        $toBeAppended = 'itemFilter('.$counter.').name='.$this->name;

        $internalCounter = 0;
        foreach ($this->dynamicValue as $filter) {
            $toBeAppended.='&itemFilter('.$counter.').value('.$internalCounter.')='.$filter;

            $internalCounter++;
        }

        return $toBeAppended.'&';
    }
}