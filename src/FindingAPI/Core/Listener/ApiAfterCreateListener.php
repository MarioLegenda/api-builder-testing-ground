<?php

namespace FindingAPI\Core\Listener;

use SDKBuilder\Event\ApiAfterCreationEvent;

class ApiAfterCreateListener
{
    /**
     * @param ApiAfterCreationEvent $event
     */
    public function onApiCreate(ApiAfterCreationEvent $event)
    {

        $dynamics = array(
            array(
                'name' => 'AuthorizedSellerOnly',
                'object' => 'FindingAPI\\Core\\ItemFilter'.'\\AuthorizedSellerOnly',
                'value' => null,
                'multiple_values' => false,
                'date_time' => false,
            ),
            array(
                'name' => 'AvailableTo',
                'object' => 'FindingAPI\\Core\\ItemFilter'.'\\AvailableTo',
                'value' => null,
                'multiple_values' => false,
                'date_time' => false,
            ),
            array(
                'name' => 'BestOfferOnly',
                'object' => 'FindingAPI\\Core\\ItemFilter'.'\\BestOfferOnly',
                'value' => null,
                'multiple_values' => false,
                'date_time' => false,
            ),
            array(
                'name' => 'CharityOnly',
                'object' => 'FindingAPI\\Core\\ItemFilter'.'\\CharityOnly',
                'value' => null,
                'multiple_values' => false,
                'date_time' => false,
            ),
            array(
                'name' => 'Condition',
                'object' => 'FindingAPI\\Core\\ItemFilter'.'\\Condition',
                'value' => null,
                'multiple_values' => true,
                'date_time' => false,
            ),
            array(
                'name' => 'Currency',
                'object' => 'FindingAPI\\Core\\ItemFilter'.'\\Currency',
                'value' => null,
                'multiple_values' => false,
                'date_time' => false,
            ),
            array(
                'name' => 'EndTimeFrom',
                'object' => 'FindingAPI\\Core\\ItemFilter'.'\\EndTimeFrom',
                'value' => null,
                'multiple_values' => false,
                'date_time' => true,
            ),
            array(
                'name' => 'EndTimeTo',
                'object' => 'FindingAPI\\Core\\ItemFilter'.'\\EndTimeTo',
                'value' => null,
                'multiple_values' => false,
                'date_time' => true,
            ),
            array(
                'name' => 'ExcludeAutoPay',
                'object' => 'FindingAPI\\Core\\ItemFilter'.'\\ExcludeAutoPay',
                'value' => null,
                'multiple_values' => false,
                'date_time' => false,
            ),
            array(
                'name' => 'ExcludeCategory',
                'object' => 'FindingAPI\\Core\\ItemFilter'.'\\ExcludeCategory',
                'value' => null,
                'multiple_values' => true,
                'date_time' => false,
            ),
            array(
                'name' => 'ExcludeSeller',
                'object' => 'FindingAPI\\Core\\ItemFilter'.'\\ExcludeSeller',
                'value' => null,
                'multiple_values' => true,
                'date_time' => false,
            ),
            array(
                'name' => 'ExpeditedShippingType',
                'object' => 'FindingAPI\\Core\\ItemFilter'.'\\ExpeditedShippingType',
                'value' => null,
                'multiple_values' => false,
                'date_time' => false,
            ),
            array(
                'name' => 'FeaturedOnly',
                'object' => 'FindingAPI\\Core\\ItemFilter'.'\\FeaturedOnly',
                'value' => null,
                'multiple_values' => false,
                'date_time' => false,
            ),
            array(
                'name' => 'FeedbackScoreMax',
                'object' => 'FindingAPI\\Core\\ItemFilter'.'\\FeedbackScoreMax',
                'value' => null,
                'multiple_values' => false,
                'date_time' => false,
            ),
            array(
                'name' => 'FeedbackScoreMin',
                'object' => 'FindingAPI\\Core\\ItemFilter'.'\\FeedbackScoreMin',
                'value' => null,
                'multiple_values' => false,
                'date_time' => false,
            ),
            array(
                'name' => 'FreeShippingOnly',
                'object' => 'FindingAPI\\Core\\ItemFilter'.'\\FreeShippingOnly',
                'value' => null,
                'multiple_values' => false,
                'date_time' => false,
            ),
            array(
                'name' => 'GetItFastOnly',
                'object' => 'FindingAPI\\Core\\ItemFilter'.'\\GetItFastOnly',
                'value' => null,
                'multiple_values' => false,
                'date_time' => false,
            ),
            array(
                'name' => 'HideDuplicateItems',
                'object' => 'FindingAPI\\Core\\ItemFilter'.'\\HideDuplicateItems',
                'value' => null,
                'multiple_values' => false,
                'date_time' => false,
            ),
            array(
                'name' => 'ListedIn',
                'object' => 'FindingAPI\\Core\\ItemFilter'.'\\ListedIn',
                'value' => null,
                'multiple_values' => false,
                'date_time' => false,
            ),
            array(
                'name' => 'ListingType',
                'object' => 'FindingAPI\\Core\\ItemFilter'.'\\ListingType',
                'value' => null,
                'multiple_values' => true,
                'date_time' => false,
            ),
            array(
                'name' => 'LocalPickupOnly',
                'object' => 'FindingAPI\\Core\\ItemFilter'.'\\LocalPickupOnly',
                'value' => null,
                'multiple_values' => false,
                'date_time' => false,
            ),
            array(
                'name' => 'LocalSearchOnly',
                'object' => 'FindingAPI\\Core\\ItemFilter'.'\\LocalSearchOnly',
                'value' => null,
                'multiple_values' => false,
                'date_time' => false,
            ),
            array(
                'name' => 'LocatedIn',
                'object' => 'FindingAPI\\Core\\ItemFilter'.'\\LocatedIn',
                'value' => null,
                'multiple_values' => true,
                'date_time' => false,
            ),
            array(
                'name' => 'LotsOnly',
                'object' => 'FindingAPI\\Core\\ItemFilter'.'\\LotsOnly',
                'value' => null,
                'multiple_values' => false,
                'date_time' => false,
            ),
            array(
                'name' => 'MaxBids',
                'object' => 'FindingAPI\\Core\\ItemFilter'.'\\MaxBids',
                'value' => null,
                'multiple_values' => false,
                'date_time' => false,
            ),
            array(
                'name' => 'MaxDistance',
                'object' => 'FindingAPI\\Core\\ItemFilter'.'\\MaxDistance',
                'value' => null,
                'multiple_values' => false,
                'date_time' => false,
            ),
            array(
                'name' => 'MaxHandlingTime',
                'object' => 'FindingAPI\\Core\\ItemFilter'.'\\MaxHandlingTime',
                'value' => null,
                'multiple_values' => false,
                'date_time' => false,
            ),
            array(
                'name' => 'SortOrder',
                'object' => 'FindingAPI\\Core\\ItemFilter'.'\\SortOrder',
                'value' => null,
                'multiple_values' => false,
                'date_time' => false,
            ),
            array(
                'name' => 'BuyerPostalCode',
                'object' => 'FindingAPI\\Core\\ItemFilter'.'\\BuyerPostalCode',
                'value' => null,
                'multiple_values' => false,
                'date_time' => false,
            ),
            array(
                'name' => 'PaginationInput',
                'object' => 'FindingAPI\\Core\\ItemFilter'.'\\PaginationInput',
                'value' => null,
                'multiple_values' => false,
                'date_time' => false,
            ),
            array(
                'name' => 'MaxPrice',
                'object' => 'FindingAPI\\Core\\ItemFilter'.'\\MaxPrice',
                'value' => null,
                'multiple_values' => false,
                'date_time' => false,
            ),
            array(
                'name' => 'MaxQuantity',
                'object' => 'FindingAPI\\Core\\ItemFilter'.'\\MaxQuantity',
                'value' => null,
                'multiple_values' => false,
                'date_time' => false,
            ),
            array(
                'name' => 'MinBids',
                'object' => 'FindingAPI\\Core\\ItemFilter'.'\\MinBids',
                'value' => null,
                'multiple_values' => false,
                'date_time' => false,
            ),
            array(
                'name' => 'MinPrice',
                'object' => 'FindingAPI\\Core\\ItemFilter'.'\\MinPrice',
                'value' => null,
                'multiple_values' => false,
                'date_time' => false,
            ),
            array(
                'name' => 'MinQuantity',
                'object' => 'FindingAPI\\Core\\ItemFilter'.'\\MinQuantity',
                'value' => null,
                'multiple_values' => false,
                'date_time' => false,
            ),
            array(
                'name' => 'ModTimeFrom',
                'object' => 'FindingAPI\\Core\\ItemFilter'.'\\ModTimeFrom',
                'value' => null,
                'multiple_values' => false,
                'date_time' => true,
            ),
            array(
                'name' => 'OutletSellerOnly',
                'object' => 'FindingAPI\\Core\\ItemFilter'.'\\OutletSellerOnly',
                'value' => null,
                'multiple_values' => false,
                'date_time' => false,
            ),
            array(
                'name' => 'PaymentMethod',
                'object' => 'FindingAPI\\Core\\ItemFilter'.'\\PaymentMethod',
                'value' => null,
                'multiple_values' => false,
                'date_time' => false,
            ),
            array(
                'name' => 'ReturnsAcceptedOnly',
                'object' => 'FindingAPI\\Core\\ItemFilter'.'\\ReturnsAcceptedOnly',
                'value' => null,
                'multiple_values' => false,
                'date_time' => false,
            ),
            array(
                'name' => 'Seller',
                'object' => 'FindingAPI\\Core\\ItemFilter'.'\\Seller',
                'value' => null,
                'multiple_values' => true,
                'date_time' => false,
            ),
            array(
                'name' => 'SellerBusinessType',
                'object' => 'FindingAPI\\Core\\ItemFilter'.'\\SellerBusinessType',
                'value' => null,
                'multiple_values' => true,
                'date_time' => false,
            ),
            array(
                'name' => 'SoldItemsOnly',
                'object' => 'FindingAPI\\Core\\ItemFilter'.'\\SoldItemsOnly',
                'value' => null,
                'multiple_values' => false,
                'date_time' => false,
            ),
            array(
                'name' => 'StartTimeFrom',
                'object' => 'FindingAPI\\Core\\ItemFilter'.'\\StartTimeFrom',
                'value' => null,
                'multiple_values' => false,
                'date_time' => true,
            ),
            array(
                'name' => 'StartTimeTo',
                'object' => 'FindingAPI\\Core\\ItemFilter'.'\\StartTimeTo',
                'value' => null,
                'multiple_values' => false,
                'date_time' => true,
            ),
            array(
                'name' => 'TopRatedSellerOnly',
                'object' => 'FindingAPI\\Core\\ItemFilter'.'\\TopRatedSellerOnly',
                'value' => null,
                'multiple_values' => false,
                'date_time' => false,
            ),
            array(
                'name' => 'WorldOfGoodOnly',
                'object' => 'FindingAPI\\Core\\ItemFilter'.'\\WorldOfGoodOnly',
                'value' => null,
                'multiple_values' => false,
                'date_time' => false,
            ),
            array(
                'name' => 'OutputSelector',
                'object' => 'FindingAPI\\Core\\ItemFilter'.'\\OutputSelector',
                'value' => null,
                'multiple_values' => false,
                'date_time' => false,
            )
        );

        $dynamicStorage = $event->getApi()->getRequest()->getDynamicStorage();

        foreach ($dynamics as $dynamic) {
            $dynamicStorage->addDynamic($dynamic);
        }
    }
}