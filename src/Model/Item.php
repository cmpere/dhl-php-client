<?php

namespace LiaTec\DhlPhpClient\Model;

use LiaTec\Manager\Model;

class Item extends Model
{

    protected $bindings = [
        'number'      => 'float',
        'breakdown'   => [Breakdown::class],
        'pricingDate' => 'date',
    ];

}
