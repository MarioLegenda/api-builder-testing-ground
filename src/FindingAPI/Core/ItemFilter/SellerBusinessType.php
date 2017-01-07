<?php

namespace FindingAPI\Core\ItemFilter;

use FindingAPI\Core\Information\GlobalIdInformation;

class SellerBusinessType extends AbstractFilter implements FilterInterface
{
    /**
     * @return bool
     */
    public function validateFilter() : bool
    {
        if (!$this->genericValidation($this->filter, 2)) {
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

        $filter = $this->filter[0];
        $siteId = $this->filter[1];

        if (!GlobalIdInformation::instance()->has($siteId)) {
            $this->exceptionMessages[] = $this->name.' item filter can be used only on '.implode(', ', $validSites).' ebay sites. '.$siteId.' given';

            return false;
        }

        foreach ($validSites as $validSiteId) {
            if (!GlobalIdInformation::instance()->has($validSiteId)) {
                $this->exceptionMessages[] = $this->name.' item filter can be used only on '.implode(', ', $validSites).' ebay sites. '.$validSiteId.' given';

                return false;
            }
        }

        $validFilters = array('Business', 'Private');

        if (in_array($filter, $validFilters) === false) {
            $this->exceptionMessages[] = $this->name.' item filter can only accept '.implode(', ', $validFilters);

            return false;
        }

        $this->filter = array($this->filter[0]);

        return true;

    }
}