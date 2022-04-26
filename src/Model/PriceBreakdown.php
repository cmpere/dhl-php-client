<?php

namespace LiaTec\DhlPhpClient\Model;

use LiaTec\Manager\Model;

class PriceBreakdown extends Model
{

    protected $bindings = [
        'price'    => 'float',
        'typeCode' => 'string',
    ];

}
