<?php

namespace FindingAPI\Definition;


interface SearchDefinitionInterface
{
    /**
     * @return string
     */
    public function getDefinition() : string;

    /**
     * @return mixed
     */
    public function validateDefinition();
}