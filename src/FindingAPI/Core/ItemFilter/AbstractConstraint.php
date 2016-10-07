<?php

namespace FindingAPI\Core\ItemFilter;

use FindingAPI\Core\Exception\FindingApiException;
use FindingAPI\Processor\UrlifyInterface;
use StrongType\Boolean;
use StrongType\Exceptions\CriticalTypeException;

abstract class AbstractConstraint implements UrlifyInterface
{
    /**
     * @var string $name
     */
    protected $name;
    /**
     * @var array $filter
     */
    protected $filter;
    /**
     * @var array $configuration
     */
    protected $configuration;
    /**
     * @var array $exceptionMessages
     */
    protected $exceptionMessages = array();
    /**
     * @oaran string $name
     * @param array $filter
     * @param array $configuration
     */
    public function __construct(string $name, array $filter, array $configuration)
    {
        $this->name = $name;
        $this->filter = $filter;
        $this->configuration = $configuration;
    }
    /**
     * @return string
     */
    public function __toString() : string
    {
        if (empty($this->exceptionMessages)) {
            return 'There are no exception messages for '.$this->name.' but there should be.';
        }

        return 'Errors: '.implode(', ', $this->exceptionMessages);
    }
    /**
     * @param int $counter
     * @return string
     */
    public function urlify(int $counter) : string
    {
        if ($this->configuration['multiple_values'] === false) {
            return 'itemFilter('.$counter.').name='.$this->name.'&itemFilter('.$counter.').value='.$this->filter[0].'&';
        }

        if ($this->configuration['multiple_values'] === true) {
            $toBeAppended = 'itemFilter('.$counter.').name='.$this->name;

            $internalCounter = 0;
            foreach ($this->filter as $filter) {
                $toBeAppended.='&itemFilter('.$counter.').value('.$internalCounter.')='.$filter;

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
            if (count($value) < $count) {
                $this->exceptionMessages[] = $this->name.' can receive an array argument with only '.$count.' value(s)';

                return false;
            }
        }

        return true;
    }

    protected function checkBoolean($value) : bool
    {
        try {
            new Boolean($value);
        } catch (CriticalTypeException $e) {
            $this->exceptionMessages[] = $this->name.' can only accept true or false boolean values';

            return false;
        }

        return true;
    }
}