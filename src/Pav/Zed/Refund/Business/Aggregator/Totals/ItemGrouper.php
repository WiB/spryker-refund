<?php

namespace Pav\Zed\Refund\Business\Aggregator\Totals;

use Generated\Shared\Transfer\GroupedRefundItemTransfer;
use Generated\Shared\Transfer\RefundItemTransfer;
use Generated\Shared\Transfer\RefundTransfer;

class ItemGrouper implements TotalAggregatorInterface
{

    /**
     * @param \Generated\Shared\Transfer\RefundTransfer $refundTransfer
     *
     * @return void
     */
    public function aggregate(RefundTransfer $refundTransfer)
    {
        $refundItems = $refundTransfer->getRefundItems();
        $groupedRefundItems = $this->groupItemsByName($refundItems);
        $refundTransfer->setGroupedItems(new \ArrayObject($groupedRefundItems));
    }

    /**
     * @param \ArrayObject $refundItems
     *
     * @return array
     */
    protected function groupItemsByName(\ArrayObject $refundItems)
    {
        $groupedRefundItems = [];

        /* @var \Generated\Shared\Transfer\RefundItemTransfer $refundItem */
        foreach ($refundItems as $refundItem) {
            $groupKey = $refundItem->getGroupKey();

            if (isset($groupedRefundItems[$groupKey])) {
                $groupedRefundItem = $groupedRefundItems[$groupKey];
                $groupedRefundItem = $this->aggregateItem($groupedRefundItem, $refundItem);
            } else {
                $groupedRefundItem = $this->createNewItem($refundItem);
            }

            $groupedRefundItems[] = $groupedRefundItem;
        }

        return $groupedRefundItems;
    }

    /**
     * @param \Generated\Shared\Transfer\RefundItemTransfer $refundItem
     *
     * @return \Generated\Shared\Transfer\GroupedRefundItemTransfer
     */
    protected function createNewItem(RefundItemTransfer $refundItem)
    {
        $groupedRefundItem = new GroupedRefundItemTransfer();

        $groupedRefundItem->setName($refundItem->getName());
        $groupedRefundItem->setTotalGrossPriceWithDiscount($refundItem->getTotalGrossPriceWithDiscount());
        $groupedRefundItem->setTotalGrossPrice($refundItem->getTotalGrossPrice());
        $groupedRefundItem->setGrossPrice($refundItem->getGrossPrice());
        $groupedRefundItem->setQuantity(1);
        $groupedRefundItem->setTaxRate($refundItem->getTaxRate());
        $groupedRefundItem->setTaxAmount($refundItem->getTaxAmount());
        $groupedRefundItem->setDiscountAmount($refundItem->getDiscountAmount());

        return $groupedRefundItem;
    }

    /**
     * @param \Generated\Shared\Transfer\GroupedRefundItemTransfer $groupedRefundItem
     * @param \Generated\Shared\Transfer\RefundItemTransfer $refundItem
     *
     * @return \Generated\Shared\Transfer\GroupedRefundItemTransfer
     */
    protected function aggregateItem(GroupedRefundItemTransfer $groupedRefundItem, RefundItemTransfer $refundItem)
    {
        $groupTaxAmount = $groupedRefundItem->getTaxAmount() + $refundItem->getTaxAmount();
        $groupTotalGrossPrice = $groupedRefundItem->getTotalGrossPrice() + $refundItem->getTotalGrossPrice();
        $groupTotalGrossPriceWithDiscount = $groupedRefundItem->getTotalGrossPriceWithDiscount() + $refundItem->getTotalGrossPriceWithDiscount();
        $groupQuantity = $groupedRefundItem->getQuantity() + 1;
        $groupDiscountAmount = $groupedRefundItem->getDiscountAmount() + $refundItem->getDiscountAmount();

        $groupedRefundItem->setTotalGrossPriceWithDiscount($groupTotalGrossPriceWithDiscount);
        $groupedRefundItem->setTotalGrossPrice($groupTotalGrossPrice);
        $groupedRefundItem->setQuantity($groupQuantity);
        $groupedRefundItem->setTaxAmount($groupTaxAmount);
        $groupedRefundItem->setDiscountAmount($groupDiscountAmount);

        return $groupedRefundItem;
    }

}
