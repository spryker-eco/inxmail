<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Inxmail\Business\Mapper\Order;

use DateTime;
use Generated\Shared\Transfer\InxmailRequestTransfer;
use Generated\Shared\Transfer\OrderTransfer;
use SprykerEco\Zed\Inxmail\InxmailConfig;

abstract class AbstractOrderMapper implements OrderMapperInterface
{
    /**
     * @var \SprykerEco\Zed\Inxmail\InxmailConfig
     */
    protected $config;

    /**
     * @param \SprykerEco\Zed\Inxmail\InxmailConfig $config
     */
    public function __construct(InxmailConfig $config)
    {
        $this->config = $config;
    }

    /**
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     *
     * @return \Generated\Shared\Transfer\InxmailRequestTransfer
     */
    public function map(OrderTransfer $orderTransfer): InxmailRequestTransfer
    {
        $inxmailRequestTransfer = new InxmailRequestTransfer();
        $inxmailRequestTransfer->setEvent($this->getEvent());
        $inxmailRequestTransfer->setTransactionId(uniqid()); //TODO: Ask ALEX about it
        $inxmailRequestTransfer->setPayload($this->getPayload($orderTransfer));

        return $inxmailRequestTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     *
     * @return array
     */
    protected function getPayload(OrderTransfer $orderTransfer): array
    {
        $payload = [
            'Customer' => [
                'Mail' => $orderTransfer->getCustomer()->getEmail(),
                'Salutation' => $orderTransfer->getCustomer()->getSalutation(),
                'Firstname' => $orderTransfer->getCustomer()->getFirstName(),
                'Lastname' => $orderTransfer->getCustomer()->getLastName(),
                'Id' => $orderTransfer->getCustomer()->getIdCustomer(),
                'Language' => $orderTransfer->getCustomer()->getLocale() ? $orderTransfer->getCustomer()->getLocale()->getLocaleName() : '',
            ],
            'Billing' => [
                'Salutation' => $orderTransfer->getBillingAddress()->getSalutation(),
                'Firstname' => $orderTransfer->getBillingAddress()->getFirstName(),
                'Lastname' => $orderTransfer->getBillingAddress()->getLastName(),
                'Company' => $orderTransfer->getBillingAddress()->getCompany(),
                'Address1' => $orderTransfer->getBillingAddress()->getAddress1(),
                'Address2' => $orderTransfer->getBillingAddress()->getAddress2(),
                'Address3' => $orderTransfer->getBillingAddress()->getAddress3(),
                'City' => $orderTransfer->getBillingAddress()->getCity(),
                'Zip' => $orderTransfer->getBillingAddress()->getZipCode(),
                'Country' => $orderTransfer->getBillingAddress()->getCountry()->getName(),
            ],
            'Shipping' => [
                'Salutation' => $orderTransfer->getShippingAddress()->getSalutation(),
                'Firstname' => $orderTransfer->getShippingAddress()->getFirstName(),
                'Lastname' => $orderTransfer->getShippingAddress()->getLastName(),
                'Company' => $orderTransfer->getShippingAddress()->getCompany(),
                'Address1' => $orderTransfer->getShippingAddress()->getAddress1(),
                'Address2' => $orderTransfer->getShippingAddress()->getAddress2(),
                'Address3' => $orderTransfer->getShippingAddress()->getAddress3(),
                'City' => $orderTransfer->getShippingAddress()->getCity(),
                'Zip' => $orderTransfer->getShippingAddress()->getZipCode(),
                'Country' => $orderTransfer->getShippingAddress()->getCountry()->getName(),
            ],
            'Order' => [
                'Number' => $orderTransfer->getIdSalesOrder(),
                'Comment' => $orderTransfer->getCartNote(),
                'OrderDate' => $orderTransfer->getCreatedAt(), //TODO: Format date
                'SubTotal' => $orderTransfer->getTotals()->getSubtotal(),
                'GiftCard' => '',
                'Discount' => $orderTransfer->getTotals()->getDiscountTotal(),
                'Tax' => $orderTransfer->getTotals()->getTaxTotal(),
                'GrandTotal' => $orderTransfer->getTotals()->getGrandTotal(),
            ],
            'Payment' => $this->getPaymentMethodInfo($orderTransfer->getPayments()),
            'Delivery' => $this->getOrderDeliveryInfo($orderTransfer->getShipmentMethods()),
        ];

        foreach ($orderTransfer->getItems() as $item) {
            $payload['OrderItem'][] = [
                'Name' => $item->getName(),
                'Sku' => $item->getSku(),
                'Image' => $this->getItemImageLink($item->getImages()),
                'DeepLink' => '',
                'Price' => $item->getUnitGrossPrice(),
                'Quantity' => $item->getQuantity(),
                'Sum' => $item->getSumGrossPrice(),
                'OriginalPrice' => $item->getOriginUnitGrossPrice(),
                'TaxAmount' => $item->getSumGrossPrice() - $item->getSumNetPrice(),
                'TaxRate' => $item->getTaxRate(),
                'Discount' => $item->getUnitDiscountAmountFullAggregation(),
                'Size' => '',
                'Color' => '',
            ];
        }

        return $payload;
    }

    /**
     * @return string
     */
    abstract protected function getEvent(): string;

    /**
     * @param \Generated\Shared\Transfer\ProductImageTransfer[] $images
     *
     * @return string
     */
    protected function getItemImageLink(array $images): string
    {
        return is_array($images) ? array_shift($images)->getExternalUrlSmall() : '';
    }

    /**
     * @param \Generated\Shared\Transfer\ShipmentMethodTransfer[] $methods
     *
     * @return array
     */
    protected function getOrderDeliveryInfo(array $methods): array
    {
        if (!is_array($methods) || count($methods)) {
            return [];
        }

        $method = array_shift($methods);

        return [
            'DeliveryMethod' => $method->getName(),
            'DeliveryService' => $method->getName(),
            'DeliveryCosts' => '',
            'TrackingId' => '',
            'TrackingLink' => '',
            'ShippingDate' => $method->getDeliveryTime(),
            'MultiDelivery' => false,
        ];
    }

    /**
     * @param \Generated\Shared\Transfer\PaymentMethodTransfer[] $methods
     *
     * @return array
     */
    protected function getPaymentMethodInfo(array $methods): array
    {
        if (!is_array($methods) || count($methods)) {
            return [];
        }

        $method = array_shift($methods);

        return [
            'PaymentMethod' => $method->getMethodName(),
            'PaymentMethodCosts' => 0,
            'CheckDate' => new DateTime(),
        ];
    }
}
