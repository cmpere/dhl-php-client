<?php

namespace Tests;

use LiaTec\DhlPhpClient\Credential\DHLBasicAuthCredential;
use LiaTec\DhlPhpClient\Model\ShipmentResponse;
use LiaTec\DhlPhpClient\Model\TrackingResponse;
use LiaTec\DhlPhpClient\Model\Shipment;
use LiaTec\DhlPhpClient\DHL as Client;
use LiaTec\DhlPhpClient\Testing\Stack;
use PHPUnit\Framework\TestCase;
use Tests\Traits\ShipmentTrait;
use LiaTec\Http\Http;

class ShipmentTest extends TestCase
{
    use ShipmentTrait;

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
    public function dhl_create_shipment()
    {
        $client = Http::basic($this->credential, [], Stack::ok($this->makeShipmentResponse()));

        /** @phpstan-ignore-next-line */
        $response = Client::shipment($this->credential)->setClient($client)->shipments(
            $this->makeShipmentPayload()
        );

        $this->assertInstanceOf(ShipmentResponse::class, $response);

        $this->assertIsString($response->shipmentTrackingNumber);
        $this->assertIsString($response->cancelPickupUrl);
        $this->assertIsString($response->trackingUrl);
        $this->assertIsString($response->dispatchConfirmationNumber);

        $this->assertPackages($response);
        $this->assertDocuments($response);

        if (isset($response->onDemandDeliveryURL)) {
            $this->assertIsString($response->onDemandDeliveryURL);
        }

        $this->assertShipmentDetails($response);
        $this->assertShipmentCharges($response);
        $this->assertBarcodeInfo($response);

        if (isset($response->estimatedDeliveryDate)) {
            $this->assertIsArray($response->estimatedDeliveryDate);
        }

        if (isset($response->warnings)) {
            $this->assertIsArray($response->warnings);
        }
    }

    /** @test */
    public function dhl_track_shipment()
    {
        $client = Http::basic($this->credential, [], Stack::ok($this->makeShipmentTrackingResponse()));

        /** @phpstan-ignore-next-line */
        $response = Client::shipment($this->credential)->setClient($client)->tracking(
            '1234567890',
            ['trackingView' => 'all-checkpoints', 'levelOfDetail' => 'all']
        );

        $this->assertInstanceOf(TrackingResponse::class, $response);
        $this->assertIsArray($response->shipments);
        $this->assertTrue(count($response->shipments) > 0);

        if (is_array($response->shipments)) {
            foreach ($response->shipments as $it) {
                $this->assertInstanceOf(Shipment::class, $it);
                $this->assertIsString($it->shipmentTrackingNumber);
                $this->assertIsString($it->status);
                $this->assertIsString($it->shipmentTimestamp);
                $this->assertIsString($it->productCode);
                $this->assertIsArray($it->shipperReferences);
                $this->assertIsArray($it->events);
            }
        }
    }
}
