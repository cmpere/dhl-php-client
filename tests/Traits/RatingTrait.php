<?php

namespace Tests\Traits;

trait RatingTrait
{
    /***
     * Make rating request data
     */
    public function makeRatingPayload($overrides = [])
    {
        return array_merge([
            'originPostalCode'       => '06100',
            'originCountryCode'      => 'MX',
            'originCityName'         => 'CDMX',
            'destinationCountryCode' => 'MX',
            'destinationCityName'    => 'SLP',
            'destinationPostalCode'  => '79570',
            'weight'                 => 1,
            'length'                 => 10,
            'width'                  => 10,
            'height'                 => 10,
            'plannedShippingDate'    => date('Y-m-d'),
            'isCustomsDeclarable'    => 'false',
            'unitOfMeasurement'      => 'metric',
            'nextBusinessDay'        => true,
        ], $overrides);
    }

    public function makeLandedCostPayload($overrides = [])
    {
        return array_merge([
            'customerDetails' => [
                'shipperDetails' => [
                    'postalCode'   => '14800',
                    'cityName'     => 'Prague',
                    'countryCode'  => 'CZ',
                    'provinceCode' => 'CZ',
                    'addressLine1' => 'addres1',
                    'addressLine2' => 'addres2',
                    'addressLine3' => 'addres3',
                    'countyName'   => 'Central Bohemia',
                ],
                'receiverDetails' => [
                    'postalCode'   => '14800',
                    'cityName'     => 'Prague',
                    'countryCode'  => 'CZ',
                    'provinceCode' => 'CZ',
                    'addressLine1' => 'addres1',
                    'addressLine2' => 'addres2',
                    'addressLine3' => 'addres3',
                    'countyName'   => 'Central Bohemia',
                ],
            ],
            'accounts'                    => [['typeCode' => 'shipper', 'number' => '123456789']],
            'productCode'                 => 'P',
            'localProductCode'            => 'P',
            'unitOfMeasurement'           => 'metric',
            'currencyCode'                => 'CZK',
            'isCustomsDeclarable'         => true,
            'isDTPRequested'              => true,
            'isInsuranceRequested'        => false,
            'getCostBreakdown'            => true,
            'charges'                     => [['typeCode' => 'insurance', 'amount' => 1250, 'currencyCode' => 'CZK']],
            'shipmentPurpose'             => 'personal',
            'transportationMode'          => 'air',
            'merchantSelectedCarrierName' => 'DHL',
            'packages'                    => [
                ['typeCode' => '3BX', 'weight' => 10.5, 'dimensions' => ['length' => 25, 'width' => 35, 'height' => 15]],
            ],
            'items' => [
                [
                    'number'                        => 1,
                    'name'                          => 'KNITWEAR COTTON',
                    'description'                   => 'KNITWEAR 100% COTTON REDUCTION PRICE FALL COLLECTION',
                    'manufacturerCountry'           => 'CN',
                    'partNumber'                    => '12345555',
                    'quantity'                      => 2,
                    'quantityType'                  => 'prt',
                    'unitPrice'                     => 120,
                    'unitPriceCurrencyCode'         => 'EUR',
                    'customsValue'                  => 120,
                    'customsValueCurrencyCode'      => 'EUR',
                    'commodityCode'                 => '6110129090',
                    'weight'                        => 5,
                    'weightUnitOfMeasurement'       => 'metric',
                    'category'                      => '204',
                    'brand'                         => 'SHOE 1',
                    'goodsCharacteristics'          => [['typeCode' => 'IMPORTER', 'value' => 'Registered']],
                    'additionalQuantityDefinitions' => [['typeCode' => 'DPR', 'amount' => 2]],
                    'estimatedTariffRateType'       => 'default_rate',
                ],
            ],
            'getTariffFormula' => true,
            'getQuotationID'   => true,
        ], $overrides);
    }

    public function makeLandedCostResponse($overrides = [])
    {
        return array_merge([
            'products' => [
                [
                    'productName'             => 'EXPRESS DOMESTIC',
                    'productCode'             => 'N',
                    'localProductCode'        => 'N',
                    'localProductCountryCode' => 'CZ',
                    'networkTypeCode'         => 'TD',
                    'isCustomerAgreement'     => false,
                    'weight'                  => $this->weight(),
                    'totalPrice'              => [$this->totalPrice()],
                    'totalPriceBreakdown'     => [$this->totalPriceBreakdown()],
                    'detailedPriceBreakdown'  => [
                        [
                            'currencyType'  => 'BILLC',
                            'priceCurrency' => 'GBP',
                            'breakdown'     => [
                                [
                                    'name'                      => '12=>00 PREMIUM',
                                    'serviceCode'               => 'YK',
                                    'localServiceCode'          => 'YK',
                                    'typeCode'                  => 'string',
                                    'serviceTypeCode'           => 'SCH',
                                    'price'                     => 5,
                                    'priceCurrency'             => 'GBP',
                                    'isCustomerAgreement'       => false,
                                    'isMarketedService'         => false,
                                    'isBillingServiceIndicator' => false,
                                    'priceBreakdown'            => [
                                        [
                                            'priceType' => 'TAX',
                                            'typeCode'  => 'All Bu',
                                            'price'     => 0,
                                            'rate'      => 0,
                                            'basePrice' => 5,
                                        ],
                                    ],
                                    'tariffRateFormula' => '((0.3464 % COST) MAX (528.33))',
                                ],
                            ],
                        ],
                    ],
                    'pickupCapabilities' => [
                        'nextBusinessDay'        => false,
                        'localCutoffDateAndTime' => '2019-09-18T15:00:00',
                        'GMTCutoffTime'          => '16:00:00',
                        'pickupEarliest'         => '09:30:00',
                        'pickupLatest'           => '16:00:00',
                        'originServiceAreaCode'  => 'ELA',
                        'originFacilityAreaCode' => 'HHR',
                        'pickupAdditionalDays'   => 0,
                        'pickupDayOfWeek'        => 3,
                    ],
                    'deliveryCapabilities' => [
                        'deliveryTypeCode'             => 'QDDC',
                        'estimatedDeliveryDateAndTime' => '2019-09-20T12:00:00',
                        'destinationServiceAreaCode'   => 'PRG',
                        'destinationFacilityAreaCode'  => 'PR3',
                        'deliveryAdditionalDays'       => 0,
                        'deliveryDayOfWeek'            => 5,
                        'totalTransitDays'             => 2,
                    ],
                    'items' => [
                        [
                            'number'    => 1,
                            'breakdown' => [
                                [
                                    'name'                      => 'DUTY',
                                    'serviceCode'               => 'II',
                                    'localServiceCode'          => 'II',
                                    'typeCode'                  => 'DUTY',
                                    'serviceTypeCode'           => 'FEE',
                                    'price'                     => 20,
                                    'priceCurrency'             => 'CZK',
                                    'isCustomerAgreement'       => false,
                                    'isMarketedService'         => false,
                                    'isBillingServiceIndicator' => false,
                                    'priceBreakdown'            => [
                                        [
                                            'priceType' => 'P',
                                            'typeCode'  => 'TAX',
                                            'price'     => 110,
                                            'rate'      => 10,
                                            'basePrice' => 100,
                                        ],
                                    ],
                                    'tariffRateFormula' => '((0.3464 % COST) MAX (528.33))',
                                ],
                            ],
                        ],
                    ],
                    'pricingDate' => '2020-02-25',
                ],
            ],
            'exchangeRates' => [
                [
                    'currentExchangeRate' => 1.188411,
                    'currency'            => 'GBP',
                    'baseCurrency'        => 'EUR',
                ],
            ],
            'warnings' => [
                "Price can't be calculated",
            ],
        ], $overrides);
    }

    public function makeRatingResponse($overrides = [])
    {
        return array_merge([
            'products' => [
                [
                    'productName'             => 'EXPRESS DOMESTIC',
                    'productCode'             => 'N',
                    'localProductCode'        => 'N',
                    'localProductCountryCode' => 'CZ',
                    'networkTypeCode'         => 'TD',
                    'isCustomerAgreement'     => false,
                    'weight'                  => $this->weight(),
                    'totalPrice'              => [$this->totalPrice()],
                    'totalPriceBreakdown'     => [$this->totalPriceBreakdown()],
                    'detailedPriceBreakdown'  => [
                        [
                            'currencyType'  => 'BILLC',
                            'priceCurrency' => 'GBP',
                            'breakdown'     => [
                                [
                                    'name'                      => '12=>00 PREMIUM',
                                    'serviceCode'               => 'YK',
                                    'localServiceCode'          => 'YK',
                                    'typeCode'                  => 'string',
                                    'serviceTypeCode'           => 'SCH',
                                    'price'                     => 5,
                                    'priceCurrency'             => 'GBP',
                                    'isCustomerAgreement'       => false,
                                    'isMarketedService'         => false,
                                    'isBillingServiceIndicator' => false,
                                    'priceBreakdown'            => [
                                        [
                                            'priceType' => 'TAX',
                                            'typeCode'  => 'All Bu',
                                            'price'     => 0,
                                            'rate'      => 0,
                                            'basePrice' => 5,
                                        ],
                                    ],
                                    'tariffRateFormula' => '((0.3464 % COST) MAX (528.33))',
                                ],
                            ],
                        ],
                    ],
                    'pickupCapabilities' => [
                        'nextBusinessDay'        => false,
                        'localCutoffDateAndTime' => '2019-09-18T15:00:00',
                        'GMTCutoffTime'          => '16:00:00',
                        'pickupEarliest'         => '09:30:00',
                        'pickupLatest'           => '16:00:00',
                        'originServiceAreaCode'  => 'ELA',
                        'originFacilityAreaCode' => 'HHR',
                        'pickupAdditionalDays'   => 0,
                        'pickupDayOfWeek'        => 3,
                    ],
                    'deliveryCapabilities' => [
                        'deliveryTypeCode'             => 'QDDC',
                        'estimatedDeliveryDateAndTime' => '2019-09-20T12:00:00',
                        'destinationServiceAreaCode'   => 'PRG',
                        'destinationFacilityAreaCode'  => 'PR3',
                        'deliveryAdditionalDays'       => 0,
                        'deliveryDayOfWeek'            => 5,
                        'totalTransitDays'             => 2,
                    ],
                    'items' => [
                        [
                            'number'    => 1,
                            'breakdown' => [
                                [
                                    'name'                      => 'DUTY',
                                    'serviceCode'               => 'II',
                                    'localServiceCode'          => 'II',
                                    'typeCode'                  => 'DUTY',
                                    'serviceTypeCode'           => 'FEE',
                                    'price'                     => 20,
                                    'priceCurrency'             => 'CZK',
                                    'isCustomerAgreement'       => false,
                                    'isMarketedService'         => false,
                                    'isBillingServiceIndicator' => false,
                                    'priceBreakdown'            => [
                                        [
                                            'priceType' => 'P',
                                            'typeCode'  => 'TAX',
                                            'price'     => 110,
                                            'rate'      => 10,
                                            'basePrice' => 100,
                                        ],
                                    ],
                                    'tariffRateFormula' => '((0.3464 % COST) MAX (528.33))',
                                ],
                            ],
                        ],
                    ],
                    'pricingDate' => '2020-02-25',
                ],
            ],
            'exchangeRates' => [
                [
                    'currentExchangeRate' => 1.188411,
                    'currency'            => 'GBP',
                    'baseCurrency'        => 'EUR',
                ],
            ],
            'warnings' => [
                "Price can't be calculated",
            ],
        ], $overrides);
    }

    public function weight($overrides = [])
    {
        return array_merge([
            'volumetric'        => 0,
            'provided'          => 1.5,
            'unitOfMeasurement' => 'metric',
        ], $overrides);
    }

    public function totalPrice($overrides = [])
    {
        return array_merge([
            'currencyType'  => 'BILLC',
            'priceCurrency' => 'GBP',
            'price'         => 141.51,
        ], $overrides);
    }

    public function totalPriceBreakdown($overrides = [])
    {
        return array_merge([
            'currencyType'   => 'BILLC',
            'priceCurrency'  => 'GBP',
            'priceBreakdown' => [$this->priceBreakdown()],
        ], $overrides);
    }

    public function priceBreakdown($overrides = [])
    {
        return array_merge([
            'typeCode' => 'SPRQT',
            'price'    => 114.92,
        ], $overrides);
    }
}
