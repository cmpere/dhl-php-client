<?php

namespace LiaTec\DhlPhpClient\Model;

use LiaTec\Manager\Model;

class Breakdown extends Model
{

    protected $bindings = [
        'name'                      => 'string',
        'serviceCode'               => 'string',
        'localServiceCode'          => 'string',
        'typeCode'                  => 'string',
        'serviceTypeCode'           => 'string',
        'price'                     => 'float',
        'priceCurrency'             => 'string',
        'isCustomerAgreement'       => 'boolean',
        'isMarketedService'         => 'boolean',
        'isBillingServiceIndicator' => 'boolean',
    ];

}
