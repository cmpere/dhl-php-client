<?php

namespace LiaTec\DhlPhpClient;

use LiaTec\Http\Http;
use LiaTec\Manager\Factory;

class DHL extends Factory
{
    /** @var array */
    protected $managers = [
        'rates'    => Manager\Rates::class,
        'shipment' => Manager\Shipment::class,
        'pickups'  => Manager\Pickup::class,
    ];

    /** @var array */
    protected $environments = [
        'test'       => 'express.api.dhl.com/mydhlapi/test',
        'production' => 'express.api.dhl.com/mydhlapi',
    ];

    /**
     * Manager init
     *
     * @param mixed  $manager
     * @param array  $parameters
     * @param string $name
     *
     */
    public function boot($manager, $parameters, $name = null)
    {
        [$credential] = $parameters;

        $client = Http::basic($credential)->baseUrl(
            $this->getResourceUrl($credential)
        )->protocol('https');

        return new $manager($client);
    }

    /**
     * Get env base url
     *
     * @param mixed $credential
     *
     * @return string
     */
    private function getResourceUrl($credential): string
    {
        $mode = $credential->inProduction() ? 'production' : 'test';

        return $this->environments[$mode];
    }
}
