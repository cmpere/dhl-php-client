<?php

namespace LiaTec\DhlPhpClient\Model;

use LiaTec\Manager\Model;

class Shipment extends Model
{
    protected $bindings = [
        'shipmentTrackingNumber'                => 'string',
        'status'                                => 'string',
        'shipmentTimestamp'                     => 'string',
        'productCode'                           => 'string',
        'description'                           => 'string',
        'shipperDetails'                        => 'array',
        'receiverDetails'                       => 'array',
        'totalWeight'                           => 'float',
        'unitOfMeasurements'                    => 'string',
        'shipperReferences'                     => 'array',
        'events'                                => 'array',
        'numberOfPieces'                        => 'integer',
        'pieces'                                => 'array',
        'estimatedDeliveryDate'                 => 'string',
        'childrenShipmentIdentificationNumbers' => 'array',
    ];
}
