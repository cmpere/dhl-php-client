<?php

namespace LiaTec\DhlPhpClient\Model;

use LiaTec\Manager\Model;

class ServiceBreakdown extends Model
{
    protected $bindings = [
        'name'     => 'string',
        'price'    => 'float',
        'typeCode' => 'string',
    ];
}
