<?php

namespace Tests\Traits;

use Carbon\Carbon;
use DateTimeZone;

trait PickupTrait
{
    /***
     * Make rating request data
     */
    public function makePickupRequest($overrides = [])
    {
        $shippingDate = Carbon::tomorrow(new DateTimeZone('America/Mexico_City'))->format(
            'Y-m-d\TH:i:s\G\M\TP'
        );

        return array_merge([
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
        ], $overrides);
    }

    public function makePickupResponse($overrides = [])
    {
        return array_merge([
            'dispatchConfirmationNumbers' => [
                'PRG201220123456',
            ],
            'readyByTime'    => '12:00',
            'nextPickupDate' => '2020-06-01',
            'warnings'       => [
                'Pickup created bu somthing went wrong',
            ],
        ], $overrides);
    }
}
