<?php

namespace FindingAPI\Definition;

class CustomDefinition extends AbstractDefinition
{
    public function validateDefinition()
    {
        $this->isValidated = true;
    }
}