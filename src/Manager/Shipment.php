<?php

namespace LiaTec\DhlPhpClient\Manager;

use Exception;
use GuzzleHttp\Utils;
use LiaTec\Manager\Model;
use LiaTec\DhlPhpClient\Manager;
use LiaTec\DhlPhpClient\Model\ShipmentResponse;
use LiaTec\DhlPhpClient\Model\TrackingResponse;

class Shipment extends Manager
{
    /**
     * The ShipmentRequest Operation will allow you to generate an AWB number and piece IDs, generate a shipping label,
     * transmit manifest shipment detail to DHL, and optionally book a courier for the pickup of a shipment.
     *
     * @param array $data
     *
     * @return Model
     * @throws Exception
     */
    public function shipments(array $data = []): Model
    {
        $response = $this->client->post('shipments', $data);
        $body     = $response->getBody();
        $data     = $body->getSize() ? Utils::jsonDecode($body, true) : [];

        return ShipmentResponse::hydrateFromArray($data);
    }

    /**
     * The Tracking service retrieves tracking statuses for a single or multiple DHL Express Shipments
     *
     * @param array $data
     *
     * @return Model
     * @throws Exception
     */
    public function tracking(string $shipmentTrackingNumber, array $data = []): Model
    {
        $response = $this->client->get("shipments/{$shipmentTrackingNumber}/tracking", $data);
        $body     = $response->getBody();
        $data     = $body->getSize() ? Utils::jsonDecode($body, true) : [];

        return TrackingResponse::hydrateFromArray($data);
    }
}
