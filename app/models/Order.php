<?php


class Order
{
    private int $orderId;
    private string $customerName;
    private string $customerShippingAddress;
    private string $customerBillingAddress;
    private int $customerPhone;
    private string $customerEmail;
    private int $itemId;
    private int $itemQuantity;

    /**
     * Order constructor.
     * @param int $orderId
     * @param string $customerName
     * @param string $customerShippingAddress
     * @param string $customerBillingAddress
     * @param int $customerPhone
     * @param string $customerEmail
     * @param int $itemId
     * @param int $itemQuantity
     */
    public function __construct(int $orderId, string $customerName, string $customerShippingAddress,
                                string $customerBillingAddress, int $customerPhone, string $customerEmail,
                                int $itemId, int $itemQuantity)
    {
        $this->orderId = $orderId;
        $this->customerName = $customerName;
        $this->customerShippingAddress = $customerShippingAddress;
        $this->customerBillingAddress = $customerBillingAddress;
        $this->customerPhone = $customerPhone;
        $this->customerEmail = $customerEmail;
        $this->itemId = $itemId;
        $this->itemQuantity = $itemQuantity;
    }


}