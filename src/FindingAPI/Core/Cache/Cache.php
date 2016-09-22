<?php

namespace FindingAPI\Core\Cache;

class Cache implements CacheInterface
{
    /**
     * @var array $cache
     */
    private $cache = array();

    /**
     * @param string $key
     * @param $values
     * @return CacheInterface
     */
    public function put(string $key, $values) : CacheInterface
    {
        if (!$this->has($key)) {
            $this->cache[$key] = $values;
        }

        return $this;
    }

    /**
     * @param string $key
     * @return bool
     */
    public function has(string $key) : bool
    {
        return array_key_exists($key, $this->cache);
    }

    /**
     * @param string $key
     * @return mixed|null
     */
    public function get(string $key)
    {
        return ($this->has($key)) ? $this->cache[$key] : null;
    }

    /**
     * @param string $key
     * @return bool
     */
    public function remove(string $key) : bool
    {
        if (!$this->has($key)) {
            return false;
        }

        unset($this->cache[$key]);

        return true;
    }
}