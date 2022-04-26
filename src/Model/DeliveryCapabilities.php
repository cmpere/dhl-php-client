<?php

namespace LiaTec\DhlPhpClient\Model;

use LiaTec\Manager\Model;

class DeliveryCapabilities extends Model
{

    protected $bindings = [
        'deliveryTypeCode'             => 'string',
        'estimatedDeliveryDateAndTime' => 'date',
        'destinationServiceAreaCode'   => 'string',
        'destinationFacilityAreaCode'  => 'string',
        'deliveryAdditionalDays'       => 'float',
        'deliveryDayOfWeek'            => 'float',
        'totalTransitDays'             => 'float',
    ];

}
