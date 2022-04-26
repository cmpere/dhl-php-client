<?php

namespace LiaTec\DhlPhpClient\Model;

use LiaTec\Manager\Model;

class ExchangeRate extends Model
{

    protected $bindings = [
        'currentExchangeRate' => 'float',
        'currency'            => 'string',
        'baseCurrency'        => 'string',
    ];

}