<?php

namespace LiaTec\DhlPhpClient\Model;

use LiaTec\Manager\Model;

class Weight extends Model
{

    protected $bindings = [
        'volumetric'        => 'float',
        'provided'          => 'float',
        'unitOfMeasurement' => 'string',
    ];

}
