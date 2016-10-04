<?php

namespace FindingAPI\Processor;

interface ProcessorInterface
{
    /**
     * @return string
     */
    public function process() : ProcessorInterface;
    /**
     * @return string
     */
    public function getProcessed() : string;
}