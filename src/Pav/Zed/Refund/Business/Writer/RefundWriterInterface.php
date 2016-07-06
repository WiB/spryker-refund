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

    /**
     * @param \Generated\Shared\Transfer\RefundTransfer $refundTransfer
     *
     * @throws \Pav\Zed\Refund\Business\Exception\RefundNotFoundException
     * @throws \Propel\Runtime\Exception\PropelException
     * @return \Generated\Shared\Transfer\RefundTransfer
     */
    public function updateRefund(RefundTransfer $refundTransfer);

    /**
     * @param \Generated\Shared\Transfer\RefundItemTransfer[] $refundItems
     *
     * @throws \Pav\Zed\Refund\Business\Exception\RefundItemNotFoundException
     * @return array
     */
    public function createOrUpdateRefundItems(array $refundItems);

    /**
     * @param int $idRefundItem
     *
     * @return bool
     */
    public function deleteRefundItem($idRefundItem);

    /**
     * @param int $idRefund
     *
     * @return int
     */
    public function setRefundNotSuccessful($idRefund);

    /**
     * @param int $idRefund
     *
     * @return int
     */
    public function setRefundSuccessful($idRefund);

    /**
     * @param int $idRefund
     *
     * @return int
     */
    public function setRefundIsNotManual($idRefund);

    /**
     * @param int $idRefund
     *
     * @return int
     */
    public function setRefundIsManual($idRefund);

}
