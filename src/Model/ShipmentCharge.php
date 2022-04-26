<?php

namespace LiaTec\DhlPhpClient\Model;

use LiaTec\Manager\Model;

class ShipmentCharge extends Model
{
    protected $bindings = [
        'currencyType'     => 'string',
        'priceCurrency'    => 'string',
        'price'            => 'float',
        'serviceBreakdown' => [ServiceBreakdown::class],
    ];
}
