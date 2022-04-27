<?php

namespace LiaTec\DhlPhpClient\Model;

use LiaTec\Manager\Model;

class LandedCostResponse extends Model
{
    protected $bindings = [
        'products'      => [Product::class],
        'exchangeRates' => [ExchangeRate::class],
        'warnings'      => 'array',
    ];
}
