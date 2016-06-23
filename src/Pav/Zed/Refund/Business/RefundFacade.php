<?php

namespace Pav\Zed\Refund\Business;

use Generated\Shared\Transfer\OrderTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \Pav\Zed\Refund\Business\RefundBusinessFactory getFactory()
 */
class RefundFacade extends AbstractFacade
{

    /**
     * @param \Generated\Shared\Transfer\OrderTransfer $order
     * @param \Generated\Shared\Transfer\ItemTransfer[] $orderItems
     *
     * @return \Generated\Shared\Transfer\RefundTransfer
     */
    public function createRefund(OrderTransfer $order, array $orderItems)
    {
        return $this->getFactory()->createRefundManager()->createRefund($order, $orderItems);
    }

}
