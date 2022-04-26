<?php

namespace LiaTec\DhlPhpClient\Model;

use LiaTec\Manager\Model;

class BarcodeInfo extends Model
{
    protected $bindings = [
        'shipmentIdentificationNumberBarcodeContent' => 'string',
        'originDestinationServiceTypeBarcodeContent' => 'string',
        'routingBarcodeContent'                      => 'string',
        'trackingNumberBarcodes'                     => 'array',
    ];
}
