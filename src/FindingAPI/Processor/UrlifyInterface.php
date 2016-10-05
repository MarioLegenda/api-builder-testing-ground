<?php

namespace FindingAPI\Processor;

interface UrlifyInterface
{
    /**
     * @param string $counter
     * @return string
     */
    public function urlify(int $counter) : string;
}