<?php

namespace FindingAPI\Processor;

interface ProcessorInterface
{
    /**
     * @return ProcessorInterface
     */
    public function process() : ProcessorInterface;
    /**
     * @return string
     */
    public function getProcessed() : string;
}