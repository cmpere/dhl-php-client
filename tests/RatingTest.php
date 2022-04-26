<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use LiaTec\DhlPhpClient\DHL as Client;
use LiaTec\DhlPhpClient\Model\Product;
use LiaTec\DhlPhpClient\Manager\Rates;
use LiaTec\DhlPhpClient\Model\RateResponse;
use LiaTec\DhlPhpClient\Model\ExchangeRate;
use LiaTec\DhlPhpClient\Credential\DHLBasicAuthCredential;

class RatingTest extends TestCase
{
    /**
     * @var array
     */
    protected $managers = [
        'rates' => Rates::class,
    ];

    protected $payload;

    protected $credential;

    public function setUp(): void
    {
        parent::setUp();

        $this->payload = [
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
            'nextBusinessDay'        => 'true',
        ];

        $this->credential = new DHLBasicAuthCredential([
            'APIKey'        => 'YOUR_DATA_HERE',
            'APISecret'     => 'YOUR_DATA_HERE',
            'accountNumber' => 'YOUR_DATA_HERE',
            'test'          => true,
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
    public function it_gets_rates()
    {
        /** @phpstan-ignore-next-line */
        $response = Client::rates($this->credential)->get(
            $this->payload
        );

        $this->assertInstanceOf(RateResponse::class, $response);

        if (!isset($response->products) && !is_array($response->products)) {
            return;
        }

        foreach ($response->products as $it) {
            $this->assertInstanceOf(Product::class, $it);
            $this->assertIsString($it->productName);
            $this->assertIsString($it->productCode);
            $this->assertIsString($it->localProductCode);
            $this->assertIsString($it->localProductCountryCode);
            $this->assertIsString($it->networkTypeCode);
            $this->assertIsBool($it->isCustomerAgreement);
        }

        if (!isset($response->exchangeRates) && !is_array($response->exchangeRates)) {
            return;
        }

        foreach ($response->exchangeRates as $it) {
            $this->assertInstanceOf(ExchangeRate::class, $it);
            $this->assertIsNumeric($it->currentExchangeRate);
            $this->assertIsString($it->currency);
            $this->assertIsString($it->baseCurrency);
        }

        if (isset($response->warnings) && is_array($response->warnings)) {
            $this->assertIsArray($response->warnings);
        }
    }
}
