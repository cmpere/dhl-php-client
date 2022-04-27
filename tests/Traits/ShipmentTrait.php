<?php

namespace Tests\Traits;

use Carbon\Carbon;
use DateTimeZone;
use LiaTec\DhlPhpClient\Model\BarcodeInfo;
use LiaTec\DhlPhpClient\Model\Document;
use LiaTec\DhlPhpClient\Model\Package;
use LiaTec\DhlPhpClient\Model\ServiceBreakdown;
use LiaTec\DhlPhpClient\Model\ShipmentCharge;
use LiaTec\DhlPhpClient\Model\ShipmentDetails;

trait ShipmentTrait
{
    /***
     * Makes shipment data
     */
    public function makeShipmentPayload($overrides = [])
    {
        $shippingDate = Carbon::tomorrow(new DateTimeZone('America/Mexico_City'))->format(
            'Y-m-d\TH:i:s\G\M\TP'
        );

        return [
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
    }

    public function makeShipmentResponse($overrides = [])
    {
        return array_merge([
            'url'                        => 'https://express.api.dhl.com/mydhlapi/shipments',
            'shipmentTrackingNumber'     => '123456790',
            'cancelPickupUrl'            => 'https://express.api.dhl.com/mydhlapi/shipment-pickups/PRG200227000256',
            'trackingUrl'                => 'https://express.api.dhl.com/mydhlapi/shipments/1234567890/tracking',
            'dispatchConfirmationNumber' => 'PRG200227000256',
            'packages'                   => [
                [
                    'referenceNumber'  => 1,
                    'trackingNumber'   => 'JD914600003889482921',
                    'trackingUrl'      => 'https://express.api.dhl.com/mydhlapi/shipments/1234567890/tracking?PieceID=JD014600003889482921',
                    'volumetricWeight' => 2.5,
                    'documents'        => [
                        [
                            'imageFormat' => 'PNG',
                            'content'     => 'base64 encoded document',
                            'typeCode'    => 'qr-code',
                        ],
                    ],
                ],
            ],
            'documents' => [
                [
                    'imageFormat' => 'PDF',
                    'content'     => 'base64 encoded document',
                    'typeCode'    => 'label',
                ],
            ],
            'onDemandDeliveryURL' => 'https://odd-test.dhl.com/odd-online/US/wH24aaaaa1',
            'shipmentDetails'     => [
                [
                    'serviceHandlingFeatureCodes' => [
                        'C',
                    ],
                    'volumetricWeight'   => 245.56,
                    'billingCode'        => 'IMP',
                    'serviceContentCode' => 'WPX',
                    'customerDetails'    => [
                        'shipperDetails' => [
                            'postalAddress' => [
                                'postalCode'       => '27801',
                                'cityName'         => 'Kralupy nad Vltavou',
                                'countryCode'      => 'CZ',
                                'provinceCode'     => 'CZ',
                                'addressLine1'     => 'Na Cukrovaru 1063',
                                'addressLine2'     => 'addres 2',
                                'addressLine3'     => 'address 3',
                                'cityDistrictName' => 'Kralupy',
                                'provinceName'     => 'Central Bohemia',
                                'countryName'      => 'Czech Republic',
                            ],
                            'contactInformation' => [
                                'companyName' => 'Better One s.r.o',
                                'fullName'    => 'Huahom Peral',
                            ],
                        ],
                        'receiverDetails' => [
                            'postalAddress' => [
                                'postalCode'       => '27801',
                                'cityName'         => 'Kralupy nad Vltavou',
                                'countryCode'      => 'CZ',
                                'provinceCode'     => 'CZ',
                                'addressLine1'     => 'Na Cukrovaru 1063',
                                'addressLine2'     => 'addres 2',
                                'addressLine3'     => 'address 3',
                                'cityDistrictName' => 'Kralupy',
                                'provinceName'     => 'Central Bohemia',
                                'countryName'      => 'Czech Republic',
                            ],
                            'contactInformation' => [
                                'companyName' => 'Better One s.r.o',
                                'fullName'    => 'Huahom Peral',
                            ],
                        ],
                    ],
                    'originServiceArea' => [
                        'facilityCode'     => 'TSS',
                        'serviceAreaCode'  => 'ZYP',
                        'outboundSortCode' => 'string',
                    ],
                    'destinationServiceArea' => [
                        'facilityCode'    => 'GUM',
                        'serviceAreaCode' => 'GUM',
                        'inboundSortCode' => 'string',
                    ],
                    'dhlRoutingCode'     => 'GBSE186PJ+48500001',
                    'dhlRoutingDataId'   => '2L',
                    'deliveryDateCode'   => 'S',
                    'deliveryTimeCode'   => 'X09',
                    'productShortName'   => 'EXPRESS WORLDWIDE',
                    'valueAddedServices' => [
                        [
                            'serviceCode' => 'II',
                            'description' => 'INSURANCE',
                        ],
                    ],
                    'pickupDetails' => [
                        'localCutoffDateAndTime' => '2021-10-04T16:30:00',
                        'gmtCutoffTime'          => '17:00:00',
                        'cutoffTimeOffset'       => 'PT30M',
                        'pickupEarliest'         => '09:00:00',
                        'pickupLatest'           => '17:00:00',
                        'totalTransitDays'       => '8',
                        'pickupAdditionalDays'   => '0',
                        'deliveryAdditionalDays' => '0',
                        'pickupDayOfWeek'        => '1',
                        'deliveryDayOfWeek'      => '2',
                    ],
                ],
            ],
            'shipmentCharges' => [
                [
                    'currencyType'     => 'BILLC',
                    'priceCurrency'    => 'USD',
                    'price'            => 147,
                    'serviceBreakdown' => [
                        [
                            'name'     => 'EXPRESS WORLDWIDE',
                            'price'    => 147,
                            'typeCode' => 'FF',
                        ],
                    ],
                ],
            ],
            'barcodeInfo' => [
                'shipmentIdentificationNumberBarcodeContent' => 'base64 encoded airwaybill number',
                'originDestinationServiceTypeBarcodeContent' => 'base64 encoded string',
                'routingBarcodeContent'                      => 'base64 encoded string',
                'trackingNumberBarcodes'                     => [
                    [
                        'referenceNumber'              => 1,
                        'trackingNumberBarcodeContent' => 'base64 encoded string',
                    ],
                ],
            ],
            'estimatedDeliveryDate' => [
                'estimatedDeliveryDate' => '2021-09-27',
                'estimatedDeliveryType' => 'QDDC',
            ],
            'warnings' => [
                "can't return prices",
            ],
        ], $overrides);
    }

    public function assertPackages($data)
    {
        if (is_array($data->packages)) {
            foreach ($data->packages as $it) {
                $this->assertInstanceOf(Package::class, $it);

                $this->assertIsString($it->referenceNumber);
                $this->assertIsString($it->trackingNumber);
                $this->assertIsString($it->trackingUrl);

                if (isset($it->volumetricWeight)) {
                    $this->assertIsString($it->volumetricWeight);
                }
            }
        }
    }

    public function assertDocuments($data)
    {
        if (is_array($data->documents)) {
            foreach ($data->documents as $it) {
                $this->assertInstanceOf(Document::class, $it);

                $this->assertIsString($it->imageFormat);
                $this->assertIsString($it->content);
                $this->assertIsString($it->typeCode);
            }
        }
    }

    public function assertShipmentDetails($data)
    {
        if (is_array($data->shipmentDetails)) {
            foreach ($data->shipmentDetails as $it) {
                $this->assertInstanceOf(ShipmentDetails::class, $it);

                $this->assertIsArray($it->serviceHandlingFeatureCodes);
                $this->assertIsNumeric($it->volumetricWeight);
                $this->assertIsString($it->billingCode);
                $this->assertIsString($it->serviceContentCode);
            }
        }
    }

    public function assertShipmentCharges($data)
    {
        if (is_array($data->shipmentCharges)) {
            foreach ($data->shipmentCharges as $it) {
                $this->assertInstanceOf(ShipmentCharge::class, $it);

                $this->assertIsString($it->currencyType);
                $this->assertIsString($it->priceCurrency);
                $this->assertIsNumeric($it->price);

                if (is_array($it->serviceBreakdown)) {
                    foreach ($it->serviceBreakdown as $it) {
                        $this->assertInstanceOf(ServiceBreakdown::class, $it);

                        $this->assertIsString($it->name);
                        $this->assertIsNumeric($it->price);
                        $this->assertIsString($it->typeCode);
                    }
                }
            }
        }
    }

    public function assertBarcodeInfo($data)
    {
        if (isset($data->barcodeInfo)) {
            $this->assertInstanceOf(BarcodeInfo::class, $data->barcodeInfo);
            $this->assertIsString($data->barcodeInfo->shipmentIdentificationNumberBarcodeContent);
            $this->assertIsString($data->barcodeInfo->originDestinationServiceTypeBarcodeContent);
            $this->assertIsString($data->barcodeInfo->routingBarcodeContent);
            $this->assertIsArray($data->barcodeInfo->trackingNumberBarcodes);
        }
    }

    public function makeShipmentTrackingResponse($overrides = [])
    {
        return array_merge([
            'shipments' => [
                [
                    'shipmentTrackingNumber' => '1234567890',
                    'status'                 => 'Success',
                    'shipmentTimestamp'      => '2020-05-14T18:00:31',
                    'productCode'            => 'N',
                    'description'            => 'Shipment Description',
                    'shipperDetails'         => [
                        'name'          => 'SABO SKIRT',
                        'postalAddress' => [
                            'cityName'     => 'Brno',
                            'countyName'   => 'Moravia',
                            'postalCode'   => '55500',
                            'provinceCode' => 'CZ',
                            'countryCode'  => 'CZ',
                        ],
                        'serviceArea' => [
                            [
                                'code'             => 'ABC',
                                'description'      => 'Alpha Beta Area',
                                'outboundSortCode' => 'string',
                            ],
                        ],
                        'accountNumber' => 'string',
                    ],
                    'receiverDetails' => [
                        'name'          => 'SABO SKIRT',
                        'postalAddress' => [
                            'cityName'     => 'Bratislava',
                            'countyName'   => 'Slovakia',
                            'postalCode'   => '77777',
                            'provinceCode' => 'SK',
                            'countryCode'  => 'SK',
                        ],
                        'serviceArea' => [
                            [
                                'code'            => 'BSA',
                                'description'     => 'BSA Area',
                                'facilityCode'    => 'facil area',
                                'inboundSortCode' => 'string',
                            ],
                        ],
                    ],
                    'totalWeight'        => 10,
                    'unitOfMeasurements' => 'metric',
                    'shipperReferences'  => [
                        [
                            'value'    => 'Customer reference',
                            'typeCode' => 'CU',
                        ],
                    ],
                    'events' => [
                        [
                            'date'        => '2020-06-10',
                            'time'        => '13:06:00',
                            'typeCode'    => 'PU',
                            'description' => 'Shipment picked up',
                            'serviceArea' => [
                                [
                                    'code'        => 'BNE',
                                    'description' => 'Brisbane-AU',
                                ],
                            ],
                            'signedBy' => 'Mr.Grey',
                        ],
                    ],
                    'numberOfPieces' => 1,
                    'pieces'         => [
                        [
                            'number'                 => 1,
                            'typeCode'               => 'string',
                            'shipmentTrackingNumber' => 'string',
                            'trackingNumber'         => 'string',
                            'description'            => 'string',
                            'weight'                 => 22.5,
                            'dimensionalWeight'      => 22.5,
                            'actualWeight'           => 22.5,
                            'dimensions'             => [
                                'length' => 15,
                                'width'  => 15,
                                'height' => 40,
                            ],
                            'actualDimensions' => [
                                'length' => 15,
                                'width'  => 15,
                                'height' => 40,
                            ],
                            'unitOfMeasurements' => 'string',
                            'shipperReferences'  => [
                                [
                                    'value'    => 'Customer reference',
                                    'typeCode' => 'CU',
                                ],
                            ],
                            'events' => [
                                [
                                    'date'        => 'string',
                                    'time'        => 'string',
                                    'typeCode'    => 'string',
                                    'description' => 'string',
                                    'serviceArea' => [
                                        [
                                            'code'        => 'string',
                                            'description' => 'string',
                                        ],
                                    ],
                                    'signedBy' => 'string',
                                ],
                            ],
                        ],
                    ],
                    'estimatedDeliveryDate'                 => '2020-06-12',
                    'childrenShipmentIdentificationNumbers' => [
                        '1234567890',
                    ],
                ],
            ],
        ], $overrides);
    }
}
