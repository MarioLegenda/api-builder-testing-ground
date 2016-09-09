<?php

namespace FindingAPI\Definition;

interface SearchDefinitionInterface
{
    public function getProcessedDefinition() : array;
    public function validateDefinition();
}