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
     * @var array $exceptionMessages
     */
    protected $exceptionMessages = array();
    /**
     * @oaran string $name
     * @param array $filter
     */
    public function __construct(string $name, array $filter)
    {
        $this->name = $name;
        $this->filter = $filter;
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
        return 'itemFilter('.$counter.').name='.$this->name.'&itemFilter('.$counter.').value='.$this->filter[0].'&';
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