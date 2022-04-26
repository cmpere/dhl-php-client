<?php

namespace LiaTec\DhlPhpClient\Model;

use LiaTec\Manager\Model;

class TotalPrice extends Model
{

    protected $bindings = [
        'price'         => 'float',
        'currencyType'  => 'string',
        'priceCurrency' => 'string',
    ];

}
