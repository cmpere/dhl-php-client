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
     * @param  array  $data
     *
     * @return Model
     * @throws Exception
     */
    public function post(array $data = []): Model
    {
        $response = $this->client->post('shipments', $this->prepareShipmentPayload($data));

        if (is_array($response)) {
            return ShipmentResponse::hydrateFromArray($response);
        }

        $body = $response->getBody();
        $data = $body->getSize() ? Utils::jsonDecode($body, true) : [];

        return ShipmentResponse::hydrateFromArray($data);
    }

    /**
     * Prepares rate request parameters
     *
     * @param  array  $params
     *
     * @return array
     */
    protected function prepareShipmentPayload(array $params = []): array
    {
        $credential = $this->client->getCredential();

        return array_merge(
            [],
            $this->accounts(),
            $params
        );
    }

    /**
     * Adds accounts to payload
     *
     * @return array
     */
    protected function accounts(): array
    {
        $credential = $this->client->getCredential();

        return [
            // Only one account, fork repo if you need more
            'accounts' => [
                [
                    'typeCode' => $credential->accountTypeCode,
                    'number'   => $credential->accountNumber,
                ],
            ],
        ];
    }

    /**
     * The Tracking service retrieves tracking statuses for a single or multiple DHL Express Shipments
     *
     * @param  array  $data
     *
     * @return Model
     * @throws Exception
     */
    public function tracking(array $data = []): Model
    {
        if (!array_key_exists('shipmentTrackingNumber', $data)) {
            throw new Exception('shipmentTrackingNumber missing', 1);
        }

        $number = (string) $data['shipmentTrackingNumber'];

        unset($data['shipmentTrackingNumber']);

        $response = $this->client->get("shipments/{$number}/tracking", $data);

        if (is_array($response)) {
            return TrackingResponse::hydrateFromArray($response);
        }

        $body = $response->getBody();
        $data = $body->getSize() ? Utils::jsonDecode($body, true) : [];

        return TrackingResponse::hydrateFromArray($data);
    }

}
