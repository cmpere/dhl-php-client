<?php

namespace LiaTec\DhlPhpClient\Model;

use LiaTec\Manager\Model;

class Product extends Model
{

    protected $bindings = [
        'productName'             => 'string',
        'productCode'             => 'string',
        'localProductCode'        => 'string',
        'localProductCountryCode' => 'string',
        'networkTypeCode'         => 'string',
        'isCustomerAgreement'     => 'boolean',
        'weight'                  => Weight::class,
        'totalPrice'              => [TotalPrice::class],
        'totalPriceBreakdown'     => [TotalPriceBreakdown::class],
        'detailedPriceBreakdown'  => [DetailedPriceBreakdown::class],
        'pickupCapabilities'      => PickupCapabilities::class,
        'deliveryCapabilities'    => DeliveryCapabilities::class,
        'items'                   => [Item::class],
        'pricingDate'             => 'date',
    ];

}