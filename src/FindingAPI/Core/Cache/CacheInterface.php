<?php

namespace FindingAPI\Core\Cache;

interface CacheInterface
{
    /**
     * @param $key
     * @param $values
     * @return CacheInterface
     */
    public function put(string $key, $values) : CacheInterface;
    /**
     * @param $key
     * @return mixed
     */
    public function get(string $key);
    /**
     * @param $key
     * @return bool
     */
    public function has(string $key) : bool;
    /**
     * @param $key
     * @return bool
     */
    public function remove(string $key) : bool;
}