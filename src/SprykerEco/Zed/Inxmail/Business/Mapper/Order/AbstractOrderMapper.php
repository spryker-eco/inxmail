<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Inxmail\Business\Mapper\Order;

use ArrayObject;
use DateTime;
use Generated\Shared\Transfer\InxmailRequestTransfer;
use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\OrderTransfer;
use Generated\Shared\Transfer\ProductAbstractTransfer;
use Generated\Shared\Transfer\ProductImageTransfer;
use Spryker\Service\UtilDateTime\UtilDateTimeServiceInterface;
use Spryker\Shared\Shipment\ShipmentConstants;
use SprykerEco\Zed\Inxmail\Dependency\Facade\InxmailToMoneyFacadeBridgeInterface;
use SprykerEco\Zed\Inxmail\Dependency\Facade\InxmailToProductFacadeBridgeInterface;
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
     * @var \SprykerEco\Zed\Inxmail\Dependency\Facade\InxmailToProductFacadeBridgeInterface
     */
    protected $productFacadeBridge;

    /**
     * @param \SprykerEco\Zed\Inxmail\InxmailConfig $config
     * @param \Spryker\Service\UtilDateTime\UtilDateTimeServiceInterface $dateTimeService
     * @param \SprykerEco\Zed\Inxmail\Dependency\Facade\InxmailToMoneyFacadeBridgeInterface $moneyFacadeBridge
     * @param \SprykerEco\Zed\Inxmail\Dependency\Facade\InxmailToProductFacadeBridgeInterface $productFacadeBridge
     */
    public function __construct(
        InxmailConfig $config,
        UtilDateTimeServiceInterface $dateTimeService,
        InxmailToMoneyFacadeBridgeInterface $moneyFacadeBridge,
        InxmailToProductFacadeBridgeInterface $productFacadeBridge
    ) {
        $this->config = $config;
        $this->dateTimeService = $dateTimeService;
        $this->moneyFacadeBridge = $moneyFacadeBridge;
        $this->productFacadeBridge = $productFacadeBridge;
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
        $inxmailRequestTransfer->setTransactionId(uniqid('order_'));
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
        $locale = $orderTransfer->getCustomer()->getLocale() ? $orderTransfer->getCustomer()->getLocale()->getLocaleName() : '';

        $payload = [
            'Customer' => [
                'Mail' => $orderTransfer->getCustomer()->getEmail(),
                'Salutation' => $orderTransfer->getCustomer()->getSalutation(),
                'Firstname' => $orderTransfer->getCustomer()->getFirstName(),
                'Lastname' => $orderTransfer->getCustomer()->getLastName(),
                'Id' => $orderTransfer->getCustomer()->getIdCustomer(),
                'Language' => $locale,
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
                'Discount' => $this->getFormattedPriceFromInt($orderTransfer->getTotals()->getDiscountTotal()),
                'Tax' => $this->getFormattedPriceFromInt($orderTransfer->getTotals()->getTaxTotal()->getAmount()),
                'GrandTotal' => $this->getFormattedPriceFromInt($orderTransfer->getTotals()->getGrandTotal()),
            ],
            'Payment' => $this->getPaymentMethodInfo($orderTransfer->getPayments()),
            'Delivery' => $this->getOrderDeliveryInfo($orderTransfer->getShipmentMethods(), $orderTransfer->getExpenses()),
        ];

        foreach ($orderTransfer->getItems() as $item) {
            $payload['OrderItem'][] = [
                'Name' => $item->getName(),
                'Sku' => $item->getSku(),
                'Image' => $this->getItemImageLink($item->getImages()),
                'DeepLink' => $this->getDeepLink($item, $locale),
                'Price' => $this->getFormattedPriceFromInt($item->getUnitGrossPrice()),
                'Quantity' => $item->getQuantity(),
                'Sum' => $this->getFormattedPriceFromInt($item->getSumGrossPrice()),
                'OriginalPrice' => $item->getOriginUnitGrossPrice() ? $this->getFormattedPriceFromInt($item->getOriginUnitGrossPrice()) : null,
                'TaxAmount' => $this->getFormattedPriceFromInt($item->getSumGrossPrice() - $item->getSumNetPrice()),
                'TaxRate' => $item->getTaxRate(),
                'Discount' => $this->getFormattedPriceFromInt($item->getUnitDiscountAmountFullAggregation()),
            ];
        }

        return $payload;
    }

    /**
     * @return string
     */
    abstract protected function getEvent(): string;

    /**
     * @param \ArrayObject $images
     *
     * @return string
     */
    protected function getItemImageLink(ArrayObject $images): string
    {
        /**
         * @var ProductImageTransfer $image
         */
        foreach ($images as $image) {
            return $image->getExternalUrlSmall();
        }

        return '';
    }

    /**
     * @param \ArrayObject $methods
     * @param \ArrayObject $expenses
     *
     * @return array
     */
    protected function getOrderDeliveryInfo(ArrayObject $methods, ArrayObject $expenses): array
    {
        $result = [];

        /**
         * @var \Generated\Shared\Transfer\ShipmentMethodTransfer $method
         */
        foreach ($methods as $method) {
            $result[] = [
                'DeliveryMethod' => $method->getName(),
                'DeliveryService' => $method->getCarrierName(),
                'DeliveryCosts' => $this->getDeliveryCosts($expenses),
                'ShippingDate' => $this->dateTimeService->formatDateTime((new DateTime())::createFromFormat('U', $method->getDeliveryTime())),
                'MultiDelivery' => false,
            ];
        }

        return $result;
    }

    /**
     * @param \ArrayObject $methods
     *
     * @return array
     */
    protected function getPaymentMethodInfo(ArrayObject $methods): array
    {
        $result = [];

        /**
         * @var \Generated\Shared\Transfer\PaymentTransfer $method
         */
        foreach ($methods as $method) {
            $result[] = [
                'PaymentMethod' => $method->getPaymentMethod(),
                'PaymentMethodCosts' => $this->getFormattedPriceFromInt($method->getAmount()),
                'CheckDate' => $this->dateTimeService->formatDateTime(new DateTime()),
            ];
        }

        return $result;
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

    /**
     * @param \Generated\Shared\Transfer\ItemTransfer $itemTransfer
     * @param string $locale
     *
     * @return string
     */
    protected function getDeepLink(ItemTransfer $itemTransfer, string $locale): string
    {
        $transfer = new ProductAbstractTransfer();
        $transfer->setIdProductAbstract($itemTransfer->getIdProductAbstract());
        $transfer->setSku($itemTransfer->getSku());

        $urls = $this->productFacadeBridge->getProductUrl($transfer)->getUrls();
        foreach ($urls as $url) {
            if ($url->getLocale() === $locale) {
                return $url->getUrl();
            }
        }

        return $urls->offsetGet(0)->getUrl();
    }

    /**
     * @param \ArrayObject $expenses
     *
     * @return string
     */
    protected function getDeliveryCosts(ArrayObject $expenses): string
    {

        foreach ($expenses as $expens) {
            if ($expens->getType() === ShipmentConstants::SHIPMENT_EXPENSE_TYPE) {
                return $this->getFormattedPriceFromInt($expens->getSumGrossPrice());
            }
        }

        return $this->getFormattedPriceFromInt(0);
    }
}
