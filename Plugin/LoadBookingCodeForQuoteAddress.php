<?php
/**
 * Copyright © Reach Digital (https://www.reachdigital.io/)
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace GraphCommerce\Metapack\Plugin;

use Magento\Quote\Api\Data\AddressExtensionInterfaceFactory;
use Magento\Quote\Model\Quote\Address;
use Magento\Quote\Model\ResourceModel\Quote\Address\Collection;

class LoadBookingCodeForQuoteAddress
{
    const METAPACK_BOOKING_CODE = 'metapack_booking_code';

    private AddressExtensionInterfaceFactory $addressExtensionInterfaceFactory;

    public function __construct(
        AddressExtensionInterfaceFactory $addressExtensionInterfaceFactory,
    ) {
        $this->addressExtensionInterfaceFactory = $addressExtensionInterfaceFactory;
    }

    public function afterLoadWithFilter(
        Collection $collection,
        $result
    ): Collection {
        foreach ($collection as $address) {
            $this->processAddress($address);
        }

        return $result;
    }

    public function processAddress(Address $address): void
    {
        $hasDataChanges = $address->hasDataChanges();
        if ($address->getData(self::METAPACK_BOOKING_CODE)) {
            $this->addBookingCodeToExtensionAttributes($address);
        }
        $address->unsetData(self::METAPACK_BOOKING_CODE);
        $address->setDataChanges($hasDataChanges);
    }

    public function addBookingCodeToExtensionAttributes(Address $item): void
    {
        if (!$item->getExtensionAttributes()) {
            $item->setExtensionAttributes($this->addressExtensionInterfaceFactory->create());
        }

        $item->getExtensionAttributes()->setMetapackBookingCode(
            $item->getData(self::METAPACK_BOOKING_CODE)
        );
    }
}
