<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Inxmail\Business\Mapper\Order;

use DateTime;
use Generated\Shared\Transfer\InxmailRequestTransfer;
use Generated\Shared\Transfer\OrderTransfer;
use Spryker\Service\UtilDateTime\UtilDateTimeServiceInterface;
use SprykerEco\Zed\Inxmail\Dependency\Facade\InxmailToMoneyFacadeBridgeInterface;
use SprykerEco\Zed\Inxmail\InxmailConfig;

abstract class AbstractOrderMapper implements OrderMapperInterface
{
    /**
     * @var \SprykerEco\Zed\Inxmail\InxmailConfig
     */
    protected $config;

    /**
     * @var \Spryker\Service\UtilDateTime\UtilDateTimeServiceInterface
     */
    protected $dateTimeService;

    /**
     * @var \SprykerEco\Zed\Inxmail\Dependency\Facade\InxmailToMoneyFacadeBridgeInterface
     */
    protected $moneyFacadeBridge;

    /**
     * @param \SprykerEco\Zed\Inxmail\InxmailConfig $config
     * @param \Spryker\Service\UtilDateTime\UtilDateTimeServiceInterface $dateTimeService
     * @param \SprykerEco\Zed\Inxmail\Dependency\Facade\InxmailToMoneyFacadeBridgeInterface $moneyFacadeBridge
     */
    public function __construct(
        InxmailConfig $config,
        UtilDateTimeServiceInterface $dateTimeService,
        InxmailToMoneyFacadeBridgeInterface $moneyFacadeBridge
    ) {
        $this->config = $config;
        $this->dateTimeService = $dateTimeService;
        $this->moneyFacadeBridge = $moneyFacadeBridge;
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
                'OrderDate' => $this->dateTimeService->formatDateTime($orderTransfer->getCreatedAt()),
                'SubTotal' => $this->getFormattedPriceFromInt($orderTransfer->getTotals()->getSubtotal()),
                'GiftCard' => '',
                'Discount' => $orderTransfer->getTotals()->getDiscountTotal(),
                'Tax' => $orderTransfer->getTotals()->getTaxTotal()->getAmount(),
                'GrandTotal' => $this->getFormattedPriceFromInt($orderTransfer->getTotals()->getGrandTotal()),
            ],
            'Payment' => $this->getPaymentMethodInfo($orderTransfer->getPayments()->offsetGet(0)),
            'Delivery' => $this->getOrderDeliveryInfo($orderTransfer->getShipmentMethods()->offsetGet(0)),
        ];

        foreach ($orderTransfer->getItems() as $item) {
            $payload['OrderItem'][] = [
                'Name' => $item->getName(),
                'Sku' => $item->getSku(),
                'Image' => $this->getItemImageLink($item->getImages()),
                'DeepLink' => '',
                'Price' => $this->getFormattedPriceFromInt($item->getUnitGrossPrice()),
                'Quantity' => $item->getQuantity(),
                'Sum' => $this->getFormattedPriceFromInt($item->getSumGrossPrice()),
                'OriginalPrice' => $item->getOriginUnitGrossPrice(),
                'TaxAmount' => $this->getFormattedPriceFromInt($item->getSumGrossPrice() - $item->getSumNetPrice()),
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
     * @param \Generated\Shared\Transfer\ProductImageTransfer $images
     *
     * @return string
     */
    protected function getItemImageLink($images): string
    {
        return is_array($images) ? array_shift($images)->getExternalUrlSmall() : '';
    }

    /**
     * @param \Generated\Shared\Transfer\ShipmentMethodTransfer $method
     *
     * @return array
     */
    protected function getOrderDeliveryInfo($method): array
    {
        return [
            'DeliveryMethod' => $method->getName(),
            'DeliveryService' => $method->getCarrierName(),
            'DeliveryCosts' => '',
            'TrackingId' => '',
            'TrackingLink' => '',
            'ShippingDate' => $this->dateTimeService->formatDateTime((new DateTime())::createFromFormat('U', $method->getDeliveryTime())),
            'MultiDelivery' => false,
        ];
    }

    /**
     * @param \Generated\Shared\Transfer\PaymentTransfer $method
     *
     * @return array
     */
    protected function getPaymentMethodInfo($method): array
    {
        return [
            'PaymentMethod' => $method->getPaymentMethod(),
            'PaymentMethodCosts' => 0,
            'CheckDate' => $this->dateTimeService->formatDateTime(new DateTime()),
        ];
    }

    /**
     * @param int $value
     *
     * @return string
     */
    protected function getFormattedPriceFromInt(int $value): string
    {
        $moneyTransfer = $this->moneyFacadeBridge->fromInteger($value);

        return $this->moneyFacadeBridge->formatWithSymbol($moneyTransfer);
    }
}
