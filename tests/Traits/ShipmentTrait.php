<?php

namespace Tests\Traits;

use LiaTec\DhlPhpClient\Model\BarcodeInfo;
use LiaTec\DhlPhpClient\Model\Document;
use LiaTec\DhlPhpClient\Model\Package;
use LiaTec\DhlPhpClient\Model\ServiceBreakdown;
use LiaTec\DhlPhpClient\Model\ShipmentCharge;
use LiaTec\DhlPhpClient\Model\ShipmentDetails;

trait ShipmentTrait
{
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
}
