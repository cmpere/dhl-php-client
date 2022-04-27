<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use LiaTec\DhlPhpClient\DHL as Client;
use LiaTec\DhlPhpClient\Model\PickupResponse;
use LiaTec\DhlPhpClient\Credential\DHLBasicAuthCredential;
use LiaTec\DhlPhpClient\Testing\Stack;
use LiaTec\Http\Http;
use Tests\Traits\PickupTrait;

class PickupTest extends TestCase
{
    use PickupTrait;

    protected $credential;

    public function setUp(): void
    {
        parent::setUp();

        $this->credential = new DHLBasicAuthCredential([
            'APIKey'          => 'YOUR_DATA_HERE',
            'APISecret'       => 'YOUR_DATA_HERE',
            'accountNumber'   => 'YOUR_DATA_HERE',
            'accountTypeCode' => 'shipper',
            'test'            => true,
        ]);
    }

    /** @test */
    public function dhl_creates_pickup()
    {
        $client = Http::basic($this->credential, [], Stack::ok($this->makePickupResponse()));

        /** @phpstan-ignore-next-line */
        $response = Client::pickups($this->credential)
                            ->setClient($client)
                            ->pickups($this->makePickupRequest());

        $this->assertInstanceOf(PickupResponse::class, $response);
        $this->assertIsArray($response->dispatchConfirmationNumbers);
        $this->assertNotEmpty($response->dispatchConfirmationNumbers, 'No confirmation number available');
    }
}
