<?php
/**
 * Copyright © Reach Digital (https://www.reachdigital.io/)
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace GraphCommerce\Metapack\Resolver;

use GraphCommerce\Metapack\Plugin\LoadBookingCodeForQuoteAddress;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\Quote\Model\Quote\Address;

class ShippingAddressBookingCode implements ResolverInterface
{
    public function resolve(Field $field, $context, ResolveInfo $info, array $value = null, array $args = null): ?string
    {
        if (!isset($value['model'])) {
            throw new LocalizedException(__('"model" value should be specified'));
        }
        /** @var Address $address */
        $address = $value['model'];
        $bookingCode = null;

        if ($address->getExtensionAttributes()) {
            $bookingCode = $address->getExtensionAttributes()->getMetapackBookingCode();
        }

        if (!$bookingCode) {
            // Load after saving new value with setShippingAddressesOnCart mutation
            $bookingCode = $address->getData(LoadBookingCodeForQuoteAddress::METAPACK_BOOKING_CODE);
        }

        return $bookingCode;
    }
}
