<?php

namespace FindingAPI\Core\Debug;


use FindingAPI\Core\Exception\DebugException;

class Debug
{
    const DEBUG_TIMESTAMP = 0;
    const DEBUG_MICROTIME = 1;

    /**
     * @var int $option
     */
    private $option;
    /**
     * @var Benchmark $benchmark
     */
    private $benchmark;
    /**
     * @var Debug static $instance
     */
    private static $instance;
    /**
     * @return Debug
     */
    public static function instance()
    {
        self::$instance = (self::$instance instanceof self) ? self::$instance : new self();

        return self::$instance;
    }

    /**
     * @param int $option
     * @throws DebugException
     */
    public function setOption(int $option)
    {
        if ($option !== Debug::DEBUG_TIMESTAMP and $option !== Debug::DEBUG_MICROTIME) {
            throw new DebugException('Unknown debug option '.$option);
        }

        $this->option = $option;
    }
    /**
     * @void
     */
    public function benchmarkStart()
    {
        if ($this->option === Debug::DEBUG_TIMESTAMP) {
            self::$instance->createBenchmark()->startTimestamp();

            return;
        }

        if ($this->option === Debug::DEBUG_MICROTIME) {
            self::$instance->createBenchmark()->startMicro();

            return;
        }
    }
    /**
     * @void
     */
    public function benchmarkEnd()
    {
        if ($this->option === Debug::DEBUG_TIMESTAMP) {
            self::$instance->createBenchmark()->endTimestamp();

            return;
        }

        if ($this->option === Debug::DEBUG_MICROTIME) {
            self::$instance->createBenchmark()->endMicro();

            return;
        }
    }
    /**
     * @return float
     */
    public function benchmarkResult()
    {
        return self::$instance->createBenchmark()->getResult();
    }

    private function createBenchmark() : Benchmark
    {
        if (!self::$instance->benchmark instanceof Benchmark) {
            self::$instance->benchmark = new Benchmark();
        }

        return self::$instance->benchmark;
    }
}