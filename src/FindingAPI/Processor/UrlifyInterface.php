<?php

namespace FindingAPI\Processor;

interface UrlifyInterface
{
    /**
     * @param int $counter
     * @return string
     */
    public function urlify(int $counter) : string;
}