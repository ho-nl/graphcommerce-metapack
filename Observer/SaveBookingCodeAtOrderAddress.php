<?php
/**
 * Copyright © Reach Digital (https://www.reachdigital.io/)
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace GraphCommerce\Metapack\Observer;

use GraphCommerce\Metapack\Plugin\LoadBookingCodeForQuoteAddress;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Quote\Model\Quote;
use Magento\Sales\Model\Order;

class SaveBookingCodeAtOrderAddress implements ObserverInterface
{
    public function execute(Observer $observer): self
    {
        /** @var Order $order */
        $order = $observer->getData('order');
        /** @var Quote $quote */
        $quote = $observer->getData('quote');

        $shippingAddress = $quote->getShippingAddress();
        if (
            $shippingAddress->getExtensionAttributes() &&
            $shippingAddress->getExtensionAttributes()->getMetapackBookingCode()
        ) {
            $order->getShippingAddress()->setData(
                LoadBookingCodeForQuoteAddress::METAPACK_BOOKING_CODE,
                $shippingAddress->getExtensionAttributes()->getMetapackBookingCode()
            );
        }

        return $this;
    }
}
