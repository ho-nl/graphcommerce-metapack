# GraphCommerce Metapack

Package installation:

```
composer require graphcommerce/magento2-metapack
php bin/magento module:enable GraphCommerce_Metapack
php bin/magento setup:upgrade
```

## Features

This Magento 2 module introduces an extra attribute on the cart's shipping address (`metapack_booking_code`), and a new shipping carrier (Metapack Pickup).

### Metapack Shipping Carrier
The configuration of the new Metapack Pickup carrier can be found at:

Stores > Configuration > Sales > Delivery Methods > Metapack Pickup

### Metapack Booking Code

The new booking code attribute is available in GraphQL as `metapack_booking_code`.

This attribute can be set by `setShippingAddressesOnCart`, and can be retrieved at the `shipping_addresses` of the cart.

The value of the attribute is saved at the quote and order, when set at the cart.
