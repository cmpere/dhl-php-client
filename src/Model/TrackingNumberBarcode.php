<?php

namespace LiaTec\DhlPhpClient\Model;

use LiaTec\Manager\Model;

class TrackingNumberBarcode extends Model
{
    protected $bindings = [
        'referenceNumber'              => 'string',
        'trackingNumberBarcodeContent' => 'string',
    ];
}
