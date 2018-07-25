<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Inxmail\Business\Mapper\Order;

use Generated\Shared\Transfer\InxmailRequestTransfer;
use Orm\Zed\Sales\Persistence\SpySalesOrder;
use Spryker\Zed\Oms\Business\Util\ReadOnlyArrayObject;
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
     * @param array $orderItems
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrder $orderEntity
     * @param \Spryker\Zed\Oms\Business\Util\ReadOnlyArrayObject $data
     *
     * @return \Generated\Shared\Transfer\InxmailRequestTransfer
     */
    public function map(array $orderItems, SpySalesOrder $orderEntity, ReadOnlyArrayObject $data): InxmailRequestTransfer
    {
        $inxmailRequestTransfer = new InxmailRequestTransfer();
        $inxmailRequestTransfer->setEvent($this->getEvent());
        $inxmailRequestTransfer->setTransactionId(uniqid()); //TODO: Ask ALEX about it
        $inxmailRequestTransfer->setPayload($this->getPayload($orderItems, $orderEntity, $data));

        return $inxmailRequestTransfer;
    }


    /**
     * @param array $orderItems
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrder $orderEntity
     * @param \Spryker\Zed\Oms\Business\Util\ReadOnlyArrayObject $data
     *
     * @return array
     */
    protected function getPayload(array $orderItems, SpySalesOrder $orderEntity, ReadOnlyArrayObject $data): array
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
                'Salutation' =>  $orderEntity->getBillingAddress()->getSalutation(),
                'Firstname' => $orderEntity->getBillingAddress()->getFirstName(),
                'Lastname' => $orderEntity->getBillingAddress()->getLastName(),
                'Company' => $orderEntity->getBillingAddress()->getCompany(),
                'Address1' => $orderEntity->getBillingAddress()->getAddress1(),
                'Address2' => $orderEntity->getBillingAddress()->getAddress2(),
                'Address3' => $orderEntity->getBillingAddress()->getAddress3(),
                'City' => $orderEntity->getBillingAddress()->getCity(),
                'Zip' => $orderEntity->getBillingAddress()->getZipCode(),
                'Country' => $orderEntity->getBillingAddress()->getCountry()->getName(),
            ],
            'Shipping' => [
                'Salutation' =>  $orderEntity->getShippingAddress()->getSalutation(),
                'Firstname' => $orderEntity->getShippingAddress()->getFirstName(),
                'Lastname' => $orderEntity->getShippingAddress()->getLastName(),
                'Company' => $orderEntity->getShippingAddress()->getCompany(),
                'Address1' => $orderEntity->getShippingAddress()->getAddress1(),
                'Address2' => $orderEntity->getShippingAddress()->getAddress2(),
                'Address3' => $orderEntity->getShippingAddress()->getAddress3(),
                'City' => $orderEntity->getShippingAddress()->getCity(),
                'Zip' => $orderEntity->getShippingAddress()->getZipCode(),
                'Country' => $orderEntity->getShippingAddress()->getCountry()->getName(),
            ],
            'Order' => [
                'Number' => $orderEntity->getIdSalesOrder(),
                'Comment' => $orderEntity->getNotes()->toArray(),
                'OrderDate' => $orderEntity->getCreatedAt()->format('m/d/U H:i:s'), //TODO: Format date
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
//                'DeliveryMethod' => $orderEntity->getSpySalesShipments()->getFirst()['name'],
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
