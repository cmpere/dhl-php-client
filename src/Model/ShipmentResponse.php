<?php

namespace LiaTec\DhlPhpClient\Model;

use LiaTec\Manager\Model;

class ShipmentResponse extends Model
{
    protected $bindings = [
        'url'                        => 'string',
        'shipmentTrackingNumber'     => 'string',
        'cancelPickupUrl'            => 'string',
        'trackingUrl'                => 'string',
        'dispatchConfirmationNumber' => 'string',
        'packages'                   => [Package::class],
        'documents'                  => [Document::class],
        'onDemandDeliveryURL'        => 'string',
        'shipmentDetails'            => [ShipmentDetails::class],
        'shipmentCharges'            => [ShipmentCharge::class],
        'barcodeInfo'                => BarcodeInfo::class,
        'estimatedDeliveryDate'      => 'array',
        'warnings'                   => 'array',
    ];
}
