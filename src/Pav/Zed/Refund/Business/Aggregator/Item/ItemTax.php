<?php

namespace Pav\Zed\Refund\Business\Aggregator\Item;

use Generated\Shared\Transfer\RefundItemTransfer;

class ItemTax
{

    /**
     * @var \Pav\Zed\Refund\Dependency\Facade\RefundToTaxInterface
     */
    protected $taxBridge;

    /**
     * @param \Pav\Zed\Refund\Dependency\Facade\RefundToTaxInterface $taxBridge
     */
    public function __construct(RefundToTaxInterface $taxBridge)
    {
        $this->taxBridge = $taxBridge;
    }

    /**
     * @param \Generated\Shared\Transfer\RefundItemTransfer $itemTransfer
     *
     * @return void
     */
    public function aggregate(RefundItemTransfer $itemTransfer)
    {
        if (!$itemTransfer->getTaxRate()) {
            return;
        }

        $itemTransfer
            ->requireGrossPrice()
            ->requireTotalGrossPrice();

        $itemTransfer->setTaxAmount(
            $this->taxBridge->getTaxAmountFromGrossPrice(
                $itemTransfer->getTotalGrossPrice(),
                $itemTransfer->getTaxRate()
            )
        );
    }

}
