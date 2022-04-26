<?php

namespace LiaTec\DhlPhpClient\Model;

use LiaTec\Manager\Model;

class TrackingResponse extends Model
{
    protected $bindings = [
        'shipments' => [Shipment::class],
    ];
}
