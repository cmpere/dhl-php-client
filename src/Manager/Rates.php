<?php

namespace LiaTec\DhlPhpClient\Manager;

use Exception;
use GuzzleHttp\Utils;
use LiaTec\Manager\Model;
use LiaTec\DhlPhpClient\Manager;
use LiaTec\DhlPhpClient\Model\RateResponse;

class Rates extends Manager
{

    /**
     * Get rates
     *
     * Rate request params
     *
     * accountNumber: DHL Express customer account number.
     * originPostalCode: Text specifying the postal code for an address. https://gs1.org/voc/postalCode.
     * originCountryCode: A short text string code (see values defined in ISO 3166) specifying the shipment
     * origin country. https://gs1.org/voc/Country, Alpha-2 Code.
     * originCityName: Text specifying the city name.
     * destinationCountryCode: A short text string code (see values defined in ISO 3166) specifying the shipment
     * destination country. https://gs1.org/voc/Country, Alpha-2 Code
     * destinationCityName: Text specifying the city name
     * destinationPostalCode: Text specifying the postal code for an address. https://gs1.org/voc/postalCode
     * weight: Gross weight of the shipment including packaging.
     * length: Total length of the shipment including packaging.
     * width: Total width of the shipment including packaging.
     * height: Total height of the shipment including packaging.
     * plannedShippingDate: Timestamp represents the date you plan to ship your prospected shipment, Example:
     * 2020-02-26
     * isCustomsDeclarable: Available values : true, false
     * unitOfMeasurement: The UnitOfMeasurement node conveys the unit of measurements used in the operation. This
     * single value corresponds to the units of weight and measurement which are used throughout the message
     * processing, Available values : metric, imperial
     * nextBusinessDay: When set to true and there are no products available for given plannedShippingDate then
     * products available for the next possible pickup date are returned, Available values : true, false
     *
     * @param  array  $data  Rate request params
     *
     * @return Model
     * @throws Exception
     */
    public function get(array $data = []): Model
    {
        $response = $this->client->get('rates', $this->prepare($data));

        if (is_array($response)) {
            return RateResponse::hydrateFromArray($response);
        }

        $body = $response->getBody();
        $data = $body->getSize() ? Utils::jsonDecode($body, true) : [];

        return RateResponse::hydrateFromArray($data);
    }

    /**
     * Prepares rate request parameters
     *
     * @param  array  $params
     *
     * @return array
     */
    private function prepare(array $params = []): array
    {
        $credential = $this->client->getCredential();

        return array_merge([
                               'accountNumber' => $credential->accountNumber,
                           ], $params);
    }

}
