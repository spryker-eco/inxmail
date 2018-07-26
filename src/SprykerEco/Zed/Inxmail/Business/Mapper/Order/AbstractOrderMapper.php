<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Inxmail\Business\Mapper\Order;

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
                'Mail' => 'aptah199494@gmail.com',
                'Salutation' => 'Hello',
                'Firstname' => 'Volodymyr',
                'Lastname' => 'Hrychenko',
                'Id' => 'id',
                'Language' => 'En',
            ],
            'Billing' => [
                'Salutation' =>  $orderTransfer->getBillingAddress()->getSalutation(),
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
                'Salutation' =>  $orderTransfer->getShippingAddress()->getSalutation(),
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
                'SubTotal' => '',
                'GiftCard' => '',
                'Discount' => '',
                'Tax' => '',
                'GrandTotal' => '',
            ],
            'Payment' => [
                'PaymentMethod' => '',
                'PaymentMethodCosts' => '',
            ],
            'Delivery' => [
                'DeliveryMethod' => '',
                'DeliveryService' => '',
                'DeliveryCosts' => '',
            ],
        ];

//        foreach ($orderItems as $orderItem) {
//            $payload['OrderItem'][] = [
//
//            ];
//        }

        return $payload;
    }

    /**
     * @return string
     */
    abstract protected function getEvent(): string;
}
