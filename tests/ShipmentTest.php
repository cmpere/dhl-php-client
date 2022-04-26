<?php

namespace Tests;

use LiaTec\DhlPhpClient\Credential\DHLBasicAuthCredential;
use LiaTec\DhlPhpClient\Model\ShipmentResponse;
use LiaTec\DhlPhpClient\Model\TrackingResponse;
use LiaTec\DhlPhpClient\Model\Shipment;
use LiaTec\DhlPhpClient\DHL as Client;
use PHPUnit\Framework\TestCase;
use Tests\Traits\ShipmentTrait;
use Carbon\Carbon;
use DateTimeZone;
use LiaTec\DhlPhpClient\Manager\Shipment as ManagerShipment;

class ShipmentTest extends TestCase
{
    use ShipmentTrait;

    /**
     * @var array
     */
    protected $managers = [
        'shipment' => ManagerShipment::class,
    ];

    protected $payload;

    protected $credential;

    public function setUp(): void
    {
        parent::setUp();

        $shippingDate = Carbon::tomorrow(new DateTimeZone('America/Mexico_City'))->format(
            'Y-m-d\TH:i:s\G\M\TP'
        );

        $this->payload = [
            'plannedShippingDateAndTime' => $shippingDate,
            /**
             * N -> EXPRESS DOMESTIC
             * G -> ECONOMY SELECT DOMESTIC
             */
            'productCode' => 'N',
            'pickup'      => [
                'isRequested'   => true,
                'closeTime'     => '18:00',
                'location'      => 'front door',
                'pickupDetails' => [
                    'postalAddress' => [
                        'postalCode'   => '07870',
                        'cityName'     => 'CDMX',
                        'countryCode'  => 'MX',
                        'addressLine1' => 'Borodin 92 B102, Vallejo, CP. 07870, CDMX', //max 45
                    ],
                    'contactInformation' => [
                        'fullName'    => 'Carlos Manuel Perez Cruz',
                        'companyName' => 'Store Name',
                        'phone'       => '5585308643',
                        'email'       => 'cmpere@gmail.com',
                    ],
                    'typeCode' => 'private', // ["business","direct_consumer","government","other","private","reseller"]
                ],
                'specialInstructions' => [
                    [
                        'value' => 'Tocar Timbre B102',
                    ],
                ],
            ],
            'customerDetails' => [
                'shipperDetails' => [
                    'postalAddress' => [
                        'postalCode'   => '07870',
                        'cityName'     => 'CDMX',
                        'countryCode'  => 'MX',
                        'addressLine1' => 'Borodin 92 B102, Vallejo, CP. 07870, CDMX',
                    ],
                    'contactInformation' => [
                        'fullName'    => 'Carlos Manuel Perez Cruz',
                        'companyName' => 'Store Name',
                        'phone'       => '5585308643',
                        'email'       => 'cmpere@gmail.com',
                    ],
                    'typeCode' => 'private', // ["business","direct_consumer","government","other","private","reseller"]
                ],
                'receiverDetails' => [
                    'postalAddress' => [
                        'postalCode'   => '07870',
                        'cityName'     => 'CDMX',
                        'countryCode'  => 'MX',
                        'addressLine1' => 'Borodin 92 B102, Vallejo, CP. 07870, CDMX',
                    ],
                    'contactInformation' => [
                        'fullName'    => 'Carlos Manuel Perez Cruz',
                        'companyName' => 'Store Name',
                        'phone'       => '5585308643',
                        'email'       => 'cmpere@gmail.com',
                    ],
                    'typeCode' => 'private', // ["business","direct_consumer","government","other","private","reseller"]
                ],
            ],
            'content' => [
                'isCustomsDeclarable'   => false,
                'declaredValue'         => 0,
                'declaredValueCurrency' => 'MXN',
                'description'           => 'Envio de zapatos',
                'incoterm'              => 'DAP',
                'unitOfMeasurement'     => 'metric',
                'packages'              => [
                    [
                        'labelDescription' => 'Custom description',
                        'weight'           => 1.00,
                        'dimensions'       => [
                            'length' => 10,
                            'width'  => 10,
                            'height' => 10,
                        ],
                    ],
                ],
            ],
        ];

        $this->credential = new DHLBasicAuthCredential([
            'APIKey'          => 'YOUR_DATA_HERE',
            'APISecret'       => 'YOUR_DATA_HERE',
            'accountNumber'   => 'YOUR_DATA_HERE',
            'accountTypeCode' => 'shipper',
            'test'            => true,
        ]);
    }

    /** @test */
    public function it_resolve_subscribed_managers()
    {
        foreach ($this->managers as $accessor => $manager) {
            $this->assertInstanceOf(
                $manager,
                Client::$accessor($this->credential)
            );
        }
    }

    /** @test */
    public function it_create_shipment()
    {
        /** @phpstan-ignore-next-line */
        $response = Client::shipment($this->credential)->post($this->payload);

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
    public function it_track_shipment()
    {
        /** @phpstan-ignore-next-line */
        $response = Client::shipment($this->credential)->tracking([
            'shipmentTrackingNumber' => '1234567890',
            'trackingView'           => 'all-checkpoints',
            'levelOfDetail'          => 'all',
        ]);

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
