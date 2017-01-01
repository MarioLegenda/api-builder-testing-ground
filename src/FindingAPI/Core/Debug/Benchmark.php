<?php

namespace FindingAPI\Core\Debug;

class Benchmark
{
    /**
     * @var float $start
     */
    private $start;
    /**
     * @var float $end
     */
    private $end;
    /**
     * @void
     */
    public function startMicro()
    {
        $this->start = $this->microtimeFloat();
    }
    /**
     * @void
     */
    public function endMicro()
    {
        $this->end = $this->microtimeFloat();
    }

    /**
     * @void
     */
    public function startTimestamp()
    {
        $this->start = $this->timestamp();
    }

    /**
     * @void
     */
    public function endTimestamp()
    {
        $this->end = $this->timestamp();
    }
    /**
     * @return float
     */
    public function getResult()
    {
        $result = $this->end - $this->start;

        $this->start = 0;
        $this->end = 0;

        return $result;
    }

    private function microtimeFloat()
    {
        list($usec, $sec) = explode(" ", microtime());

        return ((float) $usec + (float) $sec);
    }

    private function timestamp()
    {
        return time();
    }
}