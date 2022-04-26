<?php

namespace LiaTec\DhlPhpClient\Manager;

use Exception;
use GuzzleHttp\Utils;
use LiaTec\Manager\Model;
use LiaTec\DhlPhpClient\Manager;
use LiaTec\DhlPhpClient\Model\PickupResponse;

class Pickup extends Manager
{

    /**
     * Creates a DHL Express pickup booking request
     *
     * @param  array  $data  Rate request params
     *
     * @return Model
     * @throws Exception
     */
    public function post(array $data = []): Model
    {
        $response = $this->client->post('pickups', $this->prepare($data));
        if (is_array($response)) {
            return PickupResponse::hydrateFromArray($response);
        }

        $body = $response->getBody();
        $data = $body->getSize() ? Utils::jsonDecode($body, true) : [];

        return PickupResponse::hydrateFromArray($data);
    }

    /**
     * Prepares rate request parameters
     *
     * @param  array  $params
     *
     * @return array
     */
    private function prepare(array $params = []): array
    {
        $details = [];

        if (array_key_exists('shipmentDetails', $params)) {
            $details = array_merge(
                $details,
                $this->accounts()
            );
        }

        return array_merge(
            $params,
            $this->accounts(),
            $details
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

}
