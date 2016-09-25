<?php

namespace FindingAPI\Core;

use FindingAPI\Core\Cache\CacheProxy;
use FindingAPI\Core\Exception\ItemFilterException;
use Symfony\Component\Yaml\Yaml;

class ISO3166CountryCode
{
    /**
     * @var array $countryCodes
     */
    private $countryCodes = array();
    /**
     * @var GlobalId $instance
     */
    private static $instance;
    /**
     * @return GlobalId
     */
    public static function instance()
    {
        self::$instance = (self::$instance instanceof self) ? self::$instance : new self();

        self::$instance->createCodes();

        return self::$instance;
    }
    /**
     * @param string $id
     * @return mixed|null
     */
    public function getId(string $id, string $type)
    {
        if (!$this->hasId($id)) {
            return null;
        }

        foreach ($this->countryCodes as $codes) {
            if ($codes[$type] === strtoupper($id)) {
                return $codes[$type];
            }
        }

        return null;
    }
    /**
     * @param string $id
     * @return bool
     */
    public function hasId(string $id) : bool
    {
        $filtered = array_filter($this->countryCodes, function ($codes) use ($id) {
            foreach ($codes as $code) {
                if ($code === strtoupper($id)) {
                    return true;
                }
            }

            return false;
        });

        return !empty($filtered);
    }
    /**
     * @param string $name
     * @param array $values
     * @return GlobalId
     * @throws ItemFilterException
     */
    public function addId(string $name, array $values) : GlobalId
    {
        if ($this->hasId($name)) {
            throw new ItemFilterException('Country code'.$name.' already exists');
        }

        if (!array_key_exists('global-id', $values) and !empty($values['global-id'])) {
            throw new ItemFilterException('Country code '.$name.' value array has to have at least a global-id key and corresponding value');
        }

        $this->countryCodes[$name] = $values;

        return $this;
    }
    /**
     * @param string $id
     * @return bool
     */
    public function removeId(string $id, string $type) : bool
    {
        if (!$this->hasId($id)) {
            return false;
        }

        unset($this->countryCodes[$id]);

        return true;
    }

    private function createCodes()
    {
        if (!empty($this->countryCodes)) {
            return;
        }


        if (CacheProxy::instance()->has('country_codes.yml')) {
            $this->countryCodes = CacheProxy::instance()->get('country_codes.yml');

            return;
        }

        $this->countryCodes = Yaml::parse(file_get_contents(__DIR__.'/ItemFilter/country_codes.yml'))['iso-codes'];
    }
}