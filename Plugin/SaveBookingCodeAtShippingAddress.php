<?php
/**
 * Copyright © Reach Digital (https://www.reachdigital.io/)
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace GraphCommerce\Metapack\Plugin;

use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\QuoteGraphQl\Model\Resolver\SetShippingAddressesOnCart;

class SaveBookingCodeAtShippingAddress
{
    public function beforeResolve(
        SetShippingAddressesOnCart $subject,
        Field $field,
        $context,
        ResolveInfo $info,
        array $value = null,
        array $args = null
    ): array {
        foreach ($args['input']['shipping_addresses'] as &$inputAddress) {
            if (!isset($inputAddress[LoadBookingCodeForQuoteAddress::METAPACK_BOOKING_CODE])) {
                continue;
            }
            $bookingCode = $inputAddress[LoadBookingCodeForQuoteAddress::METAPACK_BOOKING_CODE];
            $inputAddress['address']['metapack_booking_code'] = $bookingCode;
        }

        return [$field, $context, $info, $value, $args];
    }
}
