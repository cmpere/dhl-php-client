<?php

namespace Tests;

use LiaTec\DhlPhpClient\Credential\DHLBasicAuthCredential;
use LiaTec\DhlPhpClient\Manager\Shipment;
use LiaTec\DhlPhpClient\Manager\Pickup;
use LiaTec\DhlPhpClient\Manager\Rates;
use LiaTec\DhlPhpClient\DHL as Client;
use PHPUnit\Framework\TestCase;

class ManagerTest extends TestCase
{
    /** @test */
    public function it_resolve_subscribed_managers()
    {
        $managers = [
            'rates'    => Rates::class,
            'pickups'  => Pickup::class,
            'shipment' => Shipment::class,
        ];

        $credential = new DHLBasicAuthCredential([
            'APIKey'          => 'YOUR_DATA_HERE',
            'APISecret'       => 'YOUR_DATA_HERE',
            'accountNumber'   => 'YOUR_DATA_HERE',
            'accountTypeCode' => 'shipper',
            'test'            => true,
        ]);

        foreach ($managers as $accessor => $manager) {
            $this->assertInstanceOf(
                $manager,
                Client::$accessor($credential)
            );
        }
    }
}
