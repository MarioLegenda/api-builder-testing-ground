<?php

namespace FindingAPI\Core\ResponseParser\ResponseItem;

use FindingAPI\Core\ResponseParser\ResponseItem\Child\Error\ErrorMessage;

class ErrorContainer extends AbstractItemIterator
{
    /**
     * ErrorContainer constructor.
     * @param \SimpleXMLElement $simpleXML
     */
    public function __construct(\SimpleXMLElement $simpleXML)
    {
        parent::__construct($simpleXML);

        $this->loadErrors($simpleXML);
    }
    /**
     * @param \SimpleXMLElement $simpleXml
     */
    public function loadErrors(\SimpleXMLElement $simpleXml)
    {
        foreach ($simpleXml as $errorMessage) {
            $this->addItem(new ErrorMessage($errorMessage));
        }
    }
}