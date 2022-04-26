<?php

namespace LiaTec\DhlPhpClient\Model;

use LiaTec\Manager\Model;

class PickupCapabilities extends Model
{

    protected $bindings = [
        'nextBusinessDay'        => 'boolean',
        'localCutoffDateAndTime' => 'date',
        'GMTCutoffTime'          => 'string',
        'pickupEarliest'         => 'string',
        'pickupLatest'           => 'string',
        'originServiceAreaCode'  => 'string',
        'originFacilityAreaCode' => 'string',
        'pickupAdditionalDays'   => 'float',
        'pickupDayOfWeek'        => 'float',
    ];

}
