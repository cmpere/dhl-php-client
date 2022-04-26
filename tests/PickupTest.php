<?php

namespace Tests;

use DateTimeZone;
use Carbon\Carbon;
use PHPUnit\Framework\TestCase;
use LiaTec\DhlPhpClient\DHL as Client;
use LiaTec\DhlPhpClient\Manager\Pickup;
use LiaTec\DhlPhpClient\Model\PickupResponse;
use LiaTec\DhlPhpClient\Credential\DHLBasicAuthCredential;

class PickupTest extends TestCase
{
    /**
     * @var array
     */
    protected $managers = [
        'pickups' => Pickup::class,
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
            'plannedPickupDateAndTime' => $shippingDate,
            'closeTime'                => '18:00',
            'location'                 => 'front door',
            'locationType'             => 'residence', //["business","residence"]
            'specialInstructions'      => [
                [
                    'value' => 'Tocar Timbre B102',
                ],
            ],
            'remark'          => 'Observaciones',
            'customerDetails' => [
                'shipperDetails' => [
                    'postalAddress' => [
                        'postalCode'   => '07870',
                        'cityName'     => 'CDMX',
                        'countryCode'  => 'MX',
                        'addressLine1' => 'Borodin 99 A102, Vallejo, CP. 07870, CDMX',
                    ],
                    'contactInformation' => [
                        'fullName'    => 'Customer name',
                        'companyName' => 'Store Name',
                        'phone'       => '5585308629',
                        'email'       => 'cmpere@gmail.com',
                    ],
                ],
                'pickupDetails' => [
                    'postalAddress' => [
                        'postalCode'   => '07870',
                        'cityName'     => 'CDMX',
                        'countryCode'  => 'MX',
                        'addressLine1' => 'Borodin 88 A102, Vallejo, CP. 07870, CDMX', //max 45
                    ],
                    'contactInformation' => [
                        'fullName'    => 'Pickup name',
                        'companyName' => 'Store Name',
                        'phone'       => '5585308629',
                        'email'       => 'cmpere@gmail.com',
                    ],
                ],
            ],
            'shipmentDetails' => [
                [
                    'productCode'           => 'N',
                    'localProductCode'      => 'N',
                    'isCustomsDeclarable'   => false,
                    'declaredValue'         => 0,
                    'declaredValueCurrency' => 'MXN',
                    'unitOfMeasurement'     => 'metric',
                    'packages'              => [
                        [
                            'weight'     => 1.00,
                            'dimensions' => [
                                'length' => 10,
                                'width'  => 10,
                                'height' => 10,
                            ],
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
    public function it_create_pickup()
    {
        /** @phpstan-ignore-next-line */
        $response = Client::pickups($this->credential)->post($this->payload);

        $this->assertInstanceOf(PickupResponse::class, $response);
        $this->assertIsArray($response->dispatchConfirmationNumbers);
        $this->assertNotEmpty($response->dispatchConfirmationNumbers, 'No confirmation number available');
    }
}
