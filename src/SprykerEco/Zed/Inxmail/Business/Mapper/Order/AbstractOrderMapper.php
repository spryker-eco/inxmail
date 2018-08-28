<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */
namespace SprykerEco\Zed\Inxmail\Business\Mapper\Order;

use ArrayObject;
use DateTime;
use Generated\Shared\Transfer\InxmailRequestTransfer;
use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\OrderTransfer;
use Generated\Shared\Transfer\ProductAbstractTransfer;
use Spryker\Shared\Shipment\ShipmentConstants;
use SprykerEco\Zed\Inxmail\Dependency\Facade\InxmailToLocaleFacadeInterface;
use SprykerEco\Zed\Inxmail\Dependency\Facade\InxmailToMoneyFacadeInterface;
use SprykerEco\Zed\Inxmail\Dependency\Facade\InxmailToProductFacadeInterface;
use SprykerEco\Zed\Inxmail\Dependency\Service\InxmailToUtilDateTimeServiceInterface;
use SprykerEco\Zed\Inxmail\InxmailConfig;

abstract class AbstractOrderMapper implements OrderMapperInterface
{
    /**
     * @var \SprykerEco\Zed\Inxmail\InxmailConfig
     */
    protected $config;

    /**
     * @var \SprykerEco\Zed\Inxmail\Dependency\Service\InxmailToUtilDateTimeServiceInterface
     */
    protected $dateTimeService;

    /**
     * @var \SprykerEco\Zed\Inxmail\Dependency\Facade\InxmailToMoneyFacadeInterface
     */
    protected $moneyFacade;

    /**
     * @var \SprykerEco\Zed\Inxmail\Dependency\Facade\InxmailToProductFacadeInterface
     */
    protected $productFacade;

    /**
     * @var \SprykerEco\Zed\Inxmail\Dependency\Facade\InxmailToLocaleFacadeInterface
     */
    protected $localeFacade;

    /**
     * @param \SprykerEco\Zed\Inxmail\InxmailConfig $config
     * @param \SprykerEco\Zed\Inxmail\Dependency\Service\InxmailToUtilDateTimeServiceInterface $dateTimeService
     * @param \SprykerEco\Zed\Inxmail\Dependency\Facade\InxmailToMoneyFacadeInterface $moneyFacade
     * @param \SprykerEco\Zed\Inxmail\Dependency\Facade\InxmailToProductFacadeInterface $productFacade
     * @param \SprykerEco\Zed\Inxmail\Dependency\Facade\InxmailToLocaleFacadeInterface $localeFacade
     */
    public function __construct(
        InxmailConfig $config,
        InxmailToUtilDateTimeServiceInterface $dateTimeService,
        InxmailToMoneyFacadeInterface $moneyFacade,
        InxmailToProductFacadeInterface $productFacade,
        InxmailToLocaleFacadeInterface $localeFacade
    ) {
        $this->config = $config;
        $this->dateTimeService = $dateTimeService;
        $this->moneyFacade = $moneyFacade;
        $this->productFacade = $productFacade;
        $this->localeFacade = $localeFacade;
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
        $inxmailRequestTransfer->setTransactionId($orderTransfer->getOrderReference());
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
        $locale = $orderTransfer->getCustomer()->getLocale() ?
            $orderTransfer->getCustomer()->getLocale()->getLocaleName() :
            $this->localeFacade->getCurrentLocaleName();

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
                'CancelComment' => '',
                'OrderDate' => $this->dateTimeService->formatDateTime($orderTransfer->getCreatedAt()),
                'SubTotal' => $this->getFormattedPriceFromInt($orderTransfer->getTotals()->getSubtotal()),
                'Discount' => $this->getFormattedPriceFromInt($orderTransfer->getTotals()->getDiscountTotal()),
                'Tax' => $this->getFormattedPriceFromInt($orderTransfer->getTotals()->getTaxTotal()->getAmount()),
                'GrandTotal' => $this->getFormattedPriceFromInt($orderTransfer->getTotals()->getGrandTotal()),
                'TotalDeliveryCosts' => $this->getDeliveryCosts($orderTransfer->getExpenses()),
                'TotalPaymentCosts' => $this->getPaymentMethodsTotal($orderTransfer->getPayments()),
            ],
            'Payment' => $this->getPaymentMethodInfo($orderTransfer->getPayments()),
            'Delivery' => $this->getOrderDeliveryInfo($orderTransfer->getShipmentMethods(), $orderTransfer->getExpenses()),
            'Shop' => [
                'ShopLocale' => $this->localeFacade->getCurrentLocaleName(),
                'ShopUrl' => $this->config->getHostYves(),
            ],
        ];

        foreach ($orderTransfer->getItems() as $item) {
            $payload['OrderItem'][] = [
                'Name' => $item->getName(),
                'Sku' => $item->getSku(),
                'Image' => $this->getItemImageLink($item->getImages()),
                'DeepLink' => $this->getDeepLink($item, $locale),
                'Price' => $this->getFormattedPriceFromInt($item->getRefundableAmount()),
                'Quantity' => $item->getQuantity(),
                'Sum' => $this->getFormattedPriceFromInt($item->getSumPriceToPayAggregation()),
                'OriginalPrice' => $this->getFormattedPriceFromInt($item->getUnitPrice()),
                'TaxAmount' => $this->getFormattedPriceFromInt($item->getUnitTaxAmount()),
                'TaxRate' => $item->getTaxRate(),
                'Discount' => $this->getFormattedPriceFromInt($item->getUnitDiscountAmountAggregation()),
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
         * @var \Generated\Shared\Transfer\ProductImageTransfer $image
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
                'MultiDelivery' => "No",
            ];
        }

        return $result;
    }

    /**
     * @param \ArrayObject|\Generated\Shared\Transfer\PaymentTransfer $methods
     *
     * @return array
     */
    protected function getPaymentMethodInfo(ArrayObject $methods): array
    {
        $result = [];

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
     * @param \ArrayObject $methods
     *
     * @return string
     */
    protected function getPaymentMethodsTotal(ArrayObject $methods): string
    {
        $sum = 0;

        /**
         * @var \Generated\Shared\Transfer\PaymentTransfer $method
         */
        foreach ($methods as $method) {
            $sum += $method->getAmount();
        }

        return $this->getFormattedPriceFromInt($sum);
    }

    /**
     * @param int $value
     *
     * @return string
     */
    protected function getFormattedPriceFromInt(int $value): string
    {
        $moneyTransfer = $this->moneyFacade->fromInteger($value);

        return $this->moneyFacade->formatWithSymbol($moneyTransfer);
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

        $urls = $this->productFacade->getProductUrl($transfer)->getUrls();
        foreach ($urls as $url) {
            if ($url->getLocale() === $locale) {
                return $this->config->getHostYves() . $url->getUrl();
            }
        }

        return $this->config->getHostYves() . $urls->offsetGet(0)->getUrl();
    }

    /**
     * @param \ArrayObject $expenses
     *
     * @return string
     */
    protected function getDeliveryCosts(ArrayObject $expenses): string
    {
        foreach ($expenses as $expense) {
            if ($expense->getType() === ShipmentConstants::SHIPMENT_EXPENSE_TYPE) {
                return $this->getFormattedPriceFromInt($expense->getSumGrossPrice());
            }
        }

        return $this->getFormattedPriceFromInt(0);
    }
}
