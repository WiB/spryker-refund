<?php

namespace Pav\Zed\Refund\Communication\Form\Handler;

use Generated\Shared\Transfer\RefundItemTransfer;
use Pav\Zed\Refund\Business\RefundFacade;
use Pav\Zed\Refund\Communication\Form\Refund;
use Symfony\Component\Form\FormInterface;

class RefundHandler
{

    /**
     * @var \Pav\Zed\Refund\Business\RefundFacade
     */
    protected $refundFacade;

    /**
     * @param \Pav\Zed\Refund\Business\RefundFacade $refundFacade
     */
    public function __construct(RefundFacade $refundFacade)
    {
        $this->refundFacade = $refundFacade;
    }

    /**
     * @param \Symfony\Component\Form\FormInterface $refundForm
     *
     * @return void
     */
    public function handleForm(FormInterface $refundForm)
    {
        $refundData = $refundForm->getData();
        $refundItemData = $refundData[Refund::FIELD_TABLE_BODY];

        $refundItems = [];

        foreach ($refundItemData as $itemData) {
            $refundItem = new RefundItemTransfer();
            $refundItem->fromArray($itemData, true);
            $refundItems[] = $refundItem;
        }

        $this->refundFacade
            ->updateRefundItems($refundItems);
    }

}
