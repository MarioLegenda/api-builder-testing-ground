<?php

namespace FindingAPI\Core\Response;

interface ArrayConvertableInterface
{
    /**
     * @return array
     */
    public function toArray() : array;
}