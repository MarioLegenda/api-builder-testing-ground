<?php

namespace Test\TestDynamic;

use SDKBuilder\Dynamic\AbstractDynamic;

class ConfigurationDynamic extends AbstractDynamic
{
    /**
     * @return bool
     */
    public function validateDynamic(): bool
    {
        return true;
    }
    /**
     * @param int $counter
     * @return string
     */
    public function urlify(int $counter): string
    {
        return '';
    }
}