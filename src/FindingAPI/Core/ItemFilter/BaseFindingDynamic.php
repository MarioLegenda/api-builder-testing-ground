<?php

namespace FindingAPI\Core\ItemFilter;

use SDKBuilder\Dynamic\AbstractDynamic;
use FindingAPI\Core\Helper;

abstract class BaseFindingDynamic extends AbstractDynamic
{
    /**
     * @param int $counter
     * @return string
     */
    public function urlify(int $counter) : string
    {
        $multipleValues = $this->configuration['multiple_values'];
        $dateTime = $this->configuration['date_time'];

        if ($multipleValues === false and $dateTime === false) {
            $dynamicValue = $this->refactorDynamicValue($this->dynamicValue);

            return 'itemFilter('.$counter.').name='.$this->name.'&itemFilter('.$counter.').value='.$dynamicValue[0].'&';
        }

        if ($multipleValues === true and $dateTime === false) {
            $toBeAppended = 'itemFilter('.$counter.').name='.$this->name;

            $internalCounter = 0;
            foreach ($this->dynamicValue as $dynamic) {
                $dynamicValue = $this->refactorDynamicValue((is_array($dynamic)) ? $dynamic : array($dynamic));

                $toBeAppended.='&itemFilter('.$counter.').value('.$internalCounter.')='.$dynamicValue[0];

                $internalCounter++;
            }

            return $toBeAppended.'&';
        }

        if ($multipleValues === false and $dateTime === true) {
            $dateTime = $this->dynamicValue[0];

            return 'itemFilter('.$counter.').name='.$this->name.'&itemFilter('.$counter.').value='.Helper::convertToGMT($dateTime).'&';
        }

        if ($multipleValues === true and $dateTime === true) {
            $toBeAppended = 'itemFilter('.$counter.').name='.$this->name;

            $internalCounter = 0;
            foreach ($this->dynamicValue as $dynamic) {
                $dynamicValue = '';
                if ($dynamic instanceof \DateTime) {
                    $dynamicValue = Helper::convertToGMT($dynamic);
                } else {
                    $dynamicValue = $this->refactorDynamicValue($dynamic);
                }

                $toBeAppended.='&itemFilter('.$counter.').value('.$internalCounter.')='.$dynamicValue[0];

                $internalCounter++;
            }

            return $toBeAppended.'&';
        }
    }

    protected function genericValidation(array $value, $count = null) : bool
    {
        if (empty($value)) {
            $this->exceptionMessages[] = 'Argument for item filter '.$this->name.' cannot be empty.';

            return false;
        }

        if ($count !== null) {
            if (count($value) > $count) {
                $this->exceptionMessages[] = $this->name.' can receive an array argument with only '.$count.' value(s)';

                return false;
            }
        }

        return true;
    }

    protected function checkBoolean($value) : bool
    {
        if (!is_bool($value)) {
            $this->exceptionMessages[] = $this->name.' can only accept true or false boolean values';

            return false;
        }

        return true;
    }

    private function refactorDynamicValue(array $dynamics)
    {
        if (count($dynamics) === 1) {
            $dynamic = $dynamics[0];
            if (is_bool($dynamics[0])) {
                return ($dynamic === true) ? array('true') : array('false');
            }
        }

        return $dynamics;
    }
}