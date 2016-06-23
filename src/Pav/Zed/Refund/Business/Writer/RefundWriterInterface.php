<?php

namespace Pav\Zed\Refund\Business\Writer;

use Generated\Shared\Transfer\RefundItemTransfer;
use Generated\Shared\Transfer\RefundTransfer;

interface RefundWriterInterface
{

    /**
     * @param \Generated\Shared\Transfer\RefundTransfer $refund
     *
     * @throws \Propel\Runtime\Exception\PropelException
     * @return \Generated\Shared\Transfer\RefundTransfer
     */
    public function writeRefund(RefundTransfer $refund);

    /**
     * @param \Generated\Shared\Transfer\RefundItemTransfer $refundItem
     *
     * @throws \Propel\Runtime\Exception\PropelException
     * @return \Generated\Shared\Transfer\RefundItemTransfer
     */
    public function writeRefundItem(RefundItemTransfer $refundItem);

}
