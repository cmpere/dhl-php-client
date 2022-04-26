<?php

namespace LiaTec\DhlPhpClient\Model;

use LiaTec\Manager\Model;

class Package extends Model
{
    protected $bindings = [
        'referenceNumber'  => 'string',
        'trackingNumber'   => 'string',
        'trackingUrl'      => 'string',
        'volumetricWeight' => 'float',
    ];
}
