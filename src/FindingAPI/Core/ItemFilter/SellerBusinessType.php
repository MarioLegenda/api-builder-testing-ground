<?php

namespace FindingAPI\Core\ItemFilter;

use FindingAPI\Core\Information\GlobalId;

class SellerBusinessType extends AbstractConstraint implements FilterInterface
{
    /**
     * @param array $filter
     * @return bool
     */
    public function validateFilter(array $filters) : bool
    {
        if (!$this->genericValidation($filters, 2)) {
            return false;
        }

        $validSites = array(
            'EBAY-AT',
            'EBAY-NLBE',
            'EBAY-NLBE',
            'EBAY-FR',
            'EBAY-DE',
            'EBAY-IE',
            'EBAY-IT',
            'EBAY-PL',
            'EBAY-ES',
            'EBAY-CH',
            'EBAY-GB',
        );

        $filter = $filters[0];
        $siteId = $filters[1];

        if (!GlobalId::instance()->has($siteId)) {
            $this->exceptionMessages[] = $this->name.' item filter can be used only on '.implode(', ', $validSites).' ebay sites. '.$siteId.' given';

            return false;
        }

        foreach ($validSites as $validSiteId) {
            if (!GlobalId::instance()->has($validSiteId)) {
                $this->exceptionMessages[] = $this->name.' item filter can be used only on '.implode(', ', $validSites).' ebay sites. '.$validSiteId.' given';

                return false;
            }
        }

        $validFilters = array('Business', 'Private');

        if (in_array($filter, $validFilters) === false) {
            $this->exceptionMessages[] = $this->name.' item filter can only accept '.implode(', ', $validFilters);

            return false;
        }

        $this->filter = array($filters[0]);

        return true;

    }
}