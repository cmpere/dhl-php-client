<?php

namespace LiaTec\DhlPhpClient\Model;

use LiaTec\Manager\Model;

class DetailedPriceBreakdown extends Model
{

    protected $bindings = [
        'currencyType'  => 'string',
        'priceCurrency' => 'string',
        'breakdown'     => [Breakdown::class],
    ];

}
