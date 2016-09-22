<?php

namespace FindingAPI\Core\Cache;

use FindingAPI\Core\Exception\FindingApiException;

class CacheProxy implements CacheInterface
{
    /**
     * @var CacheInterface
     */
    private $cache;
    /**
     * @var CacheProxy $instance
     */
    private static $instance;

    /**
     * @return CacheProxy
     */
    public static function instance()
    {
        return (self::$instance instanceof self) ? self::$instance : self::$instance = new self();
    }
    /**
     * @param string $key
     * @param $values
     * @return CacheInterface
     */
    public function put(string $key, $values) : CacheInterface
    {
        return $this->getCache()->put($key, $values);
    }
    /**
     * @param string $key
     * @return bool
     */
    public function has(string $key) : bool
    {
        return $this->getCache()->has($key);
    }
    /**
     * @param string $key
     * @return mixed|null
     */
    public function get(string $key)
    {
        return $this->getCache()->get($key);
    }
    /**
     * @param string $key
     * @return bool
     */
    public function remove(string $key) : bool
    {
        return $this->getCache()->remove($key);
    }
    /**
     * @void
     */
    private function createCache()
    {
        if (!$this->cache instanceof CacheInterface) {
            $this->cache = new Cache();
        }
    }

    private function hasCache()
    {
        return $this->cache instanceof CacheInterface;
    }

    private function getCache()
    {
        if (!$this->hasCache()) {
            $this->createCache();

            return $this->cache;
        }

        return $this->cache;
    }
}