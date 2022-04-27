<?php

namespace LiaTec\DhlPhpClient\Manager;

use LiaTec\DhlPhpClient\Model\RateResponse;
use LiaTec\DhlPhpClient\Manager;
use LiaTec\Manager\Model;
use GuzzleHttp\Utils;
use Exception;

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
     * @param array $data Rate request params
     *
     * @return Model
     * @throws Exception
     */
    public function rates(array $data = []): Model
    {
        $response = $this->client->get('rates', $data);
        $body     = $response->getBody();
        $data     = $body->getSize() ? Utils::jsonDecode($body, true) : [];

        return RateResponse::hydrateFromArray($data);
    }

    /**
     * The Landed Cost section allows further information around products being sold to be provided.
     * In return the duty, tax and shipping charges are calculated in real time and provides
     * transparency about any extra costs the buyer may have to pay before they reach them.
     *
     * @param  array $data
     * @return Model
     */
    public function landedCost(array $data = []): Model
    {
        $response = $this->client->post('landed-cost', $data);
        $body     = $response->getBody();
        $data     = $body->getSize() ? Utils::jsonDecode($body, true) : [];

        return RateResponse::hydrateFromArray($data);
    }
}
