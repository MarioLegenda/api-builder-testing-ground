<?php

namespace FindingAPI\Core\ResponseParser\ResponseItem\Child\Item;

use FindingAPI\Core\ResponseParser\ResponseItem\AbstractItemIterator;

class GalleryInfoContainer extends AbstractItemIterator
{
    /**
     * GalleryInfoContainer constructor.
     * @param \SimpleXMLElement $simpleXML
     */
    public function __construct(\SimpleXMLElement $simpleXML)
    {
        parent::__construct($simpleXML);

        $this->loadItems($simpleXML);
    }

    private function loadItems(\SimpleXMLElement $simpleXml)
    {
        foreach ($simpleXml->galleryURL as $galleryUrl) {
            $this->addItem(new GalleryUrl($galleryUrl));
        }
    }
}