<?php

namespace FindingAPI\Processor;

use FindingAPI\Core\Exception\FindingApiException;

class RequestProducer
{
    /**
     * @var string $processed
     */
    private $product;
    /**
     * @var array $processors
     */
    private $processors;
    /**
     * RequestProducer constructor.
     * @param array $processors
     * @throws FindingApiException
     */
    public function __construct(array $processors)
    {
        foreach ($processors as $key => $processor) {
            if (!$processor instanceof ProcessorInterface) {
                throw new FindingApiException('Invalid argument supplied to '.get_class($this).'. $processors should be an array of ProcessorInterface objects');
            }
        }

        $this->processors = $processors;
    }
    /**
     * @return RequestProducer
     */
    public function produce() : RequestProducer
    {
        $processed = '';
        foreach ($this->processors as $processor) {
            $processed.=$processor->process()->getProcessed();
        }

        $this->product = rtrim($processed, '&');

        return $this;
    }
    /**
     * @return string
     */
    public function getFinalProduct() : string
    {
        return $this->product;
    }
}