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
     * @param array $data Rate request params
     *
     * @return Model
     * @throws Exception
     */
    public function pickups(array $data = []): Model
    {
        $response = $this->client->post('pickups', $data);
        $body     = $response->getBody();
        $data     = $body->getSize() ? Utils::jsonDecode($body, true) : [];

        return PickupResponse::hydrateFromArray($data);
    }
}
