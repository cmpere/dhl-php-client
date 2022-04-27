<?php

namespace Tests;

use LiaTec\DhlPhpClient\Credential\DHLBasicAuthCredential;
use LiaTec\DhlPhpClient\Model\DetailedPriceBreakdown;
use LiaTec\DhlPhpClient\Model\DeliveryCapabilities;
use LiaTec\DhlPhpClient\Model\TotalPriceBreakdown;
use LiaTec\DhlPhpClient\Model\PickupCapabilities;
use LiaTec\DhlPhpClient\Model\PriceBreakdown;
use LiaTec\DhlPhpClient\Model\RateResponse;
use LiaTec\DhlPhpClient\Model\ExchangeRate;
use LiaTec\DhlPhpClient\Model\TotalPrice;
use LiaTec\DhlPhpClient\Model\Breakdown;
use LiaTec\DhlPhpClient\DHL as Client;
use LiaTec\DhlPhpClient\Model\Product;
use LiaTec\DhlPhpClient\Testing\Stack;
use LiaTec\DhlPhpClient\Model\Weight;
use LiaTec\DhlPhpClient\Model\Item;
use PHPUnit\Framework\TestCase;
use Tests\Traits\RatingTrait;
use LiaTec\Http\Http;
use Carbon\Carbon;

class RatingTest extends TestCase
{
    use RatingTrait;

    protected $credential;

    public function setUp(): void
    {
        parent::setUp();

        $this->credential = new DHLBasicAuthCredential([
            'APIKey'        => 'YOUR_DATA_HERE',
            'APISecret'     => 'YOUR_DATA_HERE',
            'accountNumber' => 'YOUR_DATA_HERE',
            'test'          => true,
        ]);
    }

    /** @test */
    public function dhl_gets_landing_cost()
    {
        $client = Http::basic($this->credential, [], Stack::ok($this->makeLandedCostResponse()));

        /** @phpstan-ignore-next-line */
        $response = Client::rates($this->credential)
                            ->setClient($client)
                            ->landedCost($this->makeLandedCostPayload());

        $this->assertInstanceOf(RateResponse::class, $response);
    }

    /** @test */
    public function dhl_gets_rates()
    {
        $client = Http::basic($this->credential, [], Stack::ok($this->makeLandedCostResponse()));

        /** @phpstan-ignore-next-line */
        $response = Client::rates($this->credential)
                            ->setClient($client)
                            ->rates($this->makeRatingPayload());

        $this->assertInstanceOf(RateResponse::class, $response);

        if (is_array($response->products)) {
            foreach ($response->products as $it) {
                $this->assertInstanceOf(Product::class, $it);

                $this->assertIsString($it->productName);
                $this->assertIsString($it->productCode);
                $this->assertIsString($it->localProductCode);
                $this->assertIsString($it->localProductCountryCode);
                $this->assertIsString($it->networkTypeCode);
                $this->assertIsBool($it->isCustomerAgreement);

                if ($it->weight) {
                    $this->assertInstanceOf(Weight::class, $it->weight);
                    $this->assertIsNumeric($it->weight->volumetric);
                    $this->assertIsString($it->weight->unitOfMeasurement);
                }

                if (is_array($it->totalPrice)) {
                    foreach ($it->totalPrice as $totalPrice) {
                        $this->assertInstanceOf(TotalPrice::class, $totalPrice);
                        $this->assertIsNumeric($totalPrice->price);
                        $this->assertIsString($totalPrice->currencyType);
                        $this->assertIsString($totalPrice->priceCurrency);
                    }
                }

                if (is_array($it->totalPriceBreakdown)) {
                    foreach ($it->totalPriceBreakdown as $totalPriceBreakdown) {
                        $this->assertInstanceOf(TotalPriceBreakdown::class, $totalPriceBreakdown);
                        $this->assertIsString($totalPriceBreakdown->currencyType);
                        $this->assertIsString($totalPriceBreakdown->priceCurrency);

                        if (is_array($totalPriceBreakdown->priceBreakdown)) {
                            foreach ($totalPriceBreakdown->priceBreakdown as $priceBreakdown) {
                                $this->assertInstanceOf(PriceBreakdown::class, $priceBreakdown);
                                $this->assertIsNumeric($priceBreakdown->price);
                                $this->assertIsString($priceBreakdown->typeCode);
                            }
                        }
                    }
                }

                if (is_array($it->detailedPriceBreakdown)) {
                    foreach ($it->detailedPriceBreakdown as $detailedPriceBreakdown) {
                        $this->assertInstanceOf(DetailedPriceBreakdown::class, $detailedPriceBreakdown);
                        $this->assertIsString($detailedPriceBreakdown->currencyType);
                        $this->assertIsString($detailedPriceBreakdown->priceCurrency);

                        if (is_array($detailedPriceBreakdown->breakdown)) {
                            foreach ($detailedPriceBreakdown->breakdown as $breakdown) {
                                $this->assertInstanceOf(Breakdown::class, $breakdown);

                                $this->assertIsString($breakdown->name);
                                $this->assertIsString($breakdown->serviceCode);
                                $this->assertIsString($breakdown->localServiceCode);
                                $this->assertIsString($breakdown->typeCode);
                                $this->assertIsString($breakdown->serviceTypeCode);
                                $this->assertIsNumeric($breakdown->price);
                                $this->assertIsString($breakdown->priceCurrency);
                                $this->assertIsBool($breakdown->isCustomerAgreement);
                                $this->assertIsBool($breakdown->isMarketedService);
                                $this->assertIsBool($breakdown->isBillingServiceIndicator);
                            }
                        }
                    }
                }

                if ($it->pickupCapabilities) {
                    $this->assertInstanceOf(PickupCapabilities::class, $it->pickupCapabilities);

                    $this->assertIsBool($it->pickupCapabilities->nextBusinessDay);
                    $this->assertInstanceOf(Carbon::class, $it->pickupCapabilities->localCutoffDateAndTime);
                    $this->assertIsString($it->pickupCapabilities->GMTCutoffTime);
                    $this->assertIsString($it->pickupCapabilities->pickupEarliest);
                    $this->assertIsString($it->pickupCapabilities->pickupLatest);
                    $this->assertIsString($it->pickupCapabilities->originServiceAreaCode);
                    $this->assertIsString($it->pickupCapabilities->originFacilityAreaCode);
                    $this->assertIsNumeric($it->pickupCapabilities->pickupAdditionalDays);
                    $this->assertIsNumeric($it->pickupCapabilities->pickupDayOfWeek);
                }

                if ($it->deliveryCapabilities) {
                    $this->assertInstanceOf(DeliveryCapabilities::class, $it->deliveryCapabilities);

                    $this->assertIsString($it->deliveryCapabilities->deliveryTypeCode);
                    $this->assertInstanceOf(Carbon::class, $it->deliveryCapabilities->estimatedDeliveryDateAndTime);
                    $this->assertIsString($it->deliveryCapabilities->destinationServiceAreaCode);
                    $this->assertIsString($it->deliveryCapabilities->destinationFacilityAreaCode);
                    $this->assertIsNumeric($it->deliveryCapabilities->deliveryAdditionalDays);
                    $this->assertIsNumeric($it->deliveryCapabilities->deliveryDayOfWeek);
                    $this->assertIsNumeric($it->deliveryCapabilities->totalTransitDays);
                }

                if (is_array($it->items)) {
                    foreach ($it->items as $item) {
                        $this->assertInstanceOf(Item::class, $item);
                        $this->assertIsNumeric($item->number);

                        if (is_array($it->breakdown)) {
                            foreach ($it->breakdown as $breakdown) {
                                $this->assertInstanceOf(Breakdown::class, $breakdown);

                                $this->assertIsString($breakdown->name);
                                $this->assertIsString($breakdown->serviceCode);
                                $this->assertIsString($breakdown->localServiceCode);
                                $this->assertIsString($breakdown->typeCode);
                                $this->assertIsString($breakdown->serviceTypeCode);
                                $this->assertIsNumeric($breakdown->price);
                                $this->assertIsString($breakdown->priceCurrency);
                                $this->assertIsBool($breakdown->isCustomerAgreement);
                                $this->assertIsBool($breakdown->isMarketedService);
                                $this->assertIsBool($breakdown->isBillingServiceIndicator);
                            }
                        }
                    }
                }

                $this->assertInstanceOf(Carbon::class, $it->pricingDate);
            }
        }

        if (is_array($response->exchangeRates)) {
            foreach ($response->exchangeRates as $it) {
                $this->assertInstanceOf(ExchangeRate::class, $it);
                $this->assertIsNumeric($it->currentExchangeRate);
                $this->assertIsString($it->currency);
                $this->assertIsString($it->baseCurrency);
            }
        }

        if (is_array($response->warnings)) {
            $this->assertIsArray($response->warnings);
        }
    }
}
