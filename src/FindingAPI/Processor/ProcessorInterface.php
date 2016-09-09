<?php

namespace FindingAPI\Processor;

interface ProcessorInterface
{
    /**
     * @return string
     */
    public function process() : string;
}