<?php

namespace LiaTec\DhlPhpClient\Model;

use LiaTec\Manager\Model;

class ShipmentDetails extends Model
{
    protected $bindings = [
        'serviceHandlingFeatureCodes' => 'array',
        'volumetricWeight'            => 'float',
        'billingCode'                 => 'string',
        'serviceContentCode'          => 'string',
    ];
}
