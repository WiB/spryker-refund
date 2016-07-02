<?php

namespace Pav\Zed\Refund\Communication\Form\DataFormatter;

use Cocur\Slugify\Slugify;
use Generated\Shared\Transfer\RefundTransfer;
use Pav\Zed\Refund\Communication\Form\Refund;
use Pav\Zed\Refund\Communication\Form\RefundItem;

class RefundDataFormatter
{

    /**
     * @param \Generated\Shared\Transfer\RefundTransfer $refundTransfer
     *
     * @return array
     */
    public function formatData(RefundTransfer $refundTransfer)
    {
        $refundData = [
            Refund::FIELD_TABLE_BODY => $this->getRefundItems($refundTransfer),
        ];

        return $refundData;
    }

    /**
     * @param \Generated\Shared\Transfer\RefundTransfer $refundTransfer
     *
     * @return array
     */
    protected function getRefundItems(RefundTransfer $refundTransfer)
    {
        $refundItems = [];

        foreach ($refundTransfer->getItems() as $item) {

            $refundItems[] = [
                RefundItem::FIELD_ID_REFUND_ITEM => $item->getIdRefundItem(),
                RefundItem::FIELD_FK_REFUND => $refundTransfer->getIdRefund(),
                RefundItem::FIELD_FK_SALES_ORDER_ITEM => $item->getFkSalesOrderItem(),
                RefundItem::FIELD_NAME => $item->getName(),
                RefundItem::FIELD_REASON => $item->getReason(),
                RefundItem::FIELD_QUANTITY => $item->getQuantity(),
                RefundItem::FIELD_GROSS_PRICE => $item->getGrossPrice(),
                RefundItem::FIELD_TOTAL_GROSS_PRICE => $item->getTotalGrossPrice(),
                RefundItem::FIELD_DISCOUNT_AMOUNT => $item->getDiscountAmount(),
                RefundItem::FIELD_TAX_RATE => $item->getTaxRate(),
                RefundItem::FIELD_TAX_AMOUNT => $item->getTaxAmount(),
            ];

        }

        return $refundItems;
    }

}
