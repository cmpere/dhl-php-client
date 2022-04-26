<?php

namespace LiaTec\DhlPhpClient\Model;

use LiaTec\Manager\Model;

class TotalPriceBreakdown extends Model
{

    protected $bindings = [
        'currencyType'   => 'string',
        'priceCurrency'  => 'string',
        'priceBreakdown' => [PriceBreakdown::class],
    ];

}
