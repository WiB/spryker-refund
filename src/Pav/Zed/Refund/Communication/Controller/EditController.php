<?php

namespace Pav\Zed\Refund\Communication\Controller;

use Pav\Zed\Refund\Communication\Form\RefundItem;
use Pav\Zed\Refund\Communication\Form\RefundItemCollection;
use Spryker\Zed\Application\Communication\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method \Pav\Zed\Refund\Communication\RefundCommunicationFactory getFactory()
 * @method \Pav\Zed\Refund\Business\RefundFacade getFacade()
 */
class EditController extends AbstractController
{

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return array
     */
    public function indexAction(Request $request)
    {
        $form = $this->getFactory()->createRefundItemCollectionForm(
            [
                RefundItemCollection::FIELD_REFUND_ITEMS => [
                    [
                        RefundItem::FIELD_ID_REFUND_ITEM => 1,
                        RefundItem::FIELD_NAME => 'Refund item 1',
                        RefundItem::FIELD_REASON => 'Reason',
                        RefundItem::FIELD_GROSS_PRICE => 110,
                        RefundItem::FIELD_TOTAL_GROSS_PRICE => 99,
                        RefundItem::FIELD_QUANTITY => 1,
                        RefundItem::FIELD_TAX_AMOUNT => 112,
                        RefundItem::FIELD_TAX_RATE => 19,
                        RefundItem::FIELD_DISCOUNT_AMOUNT => 100,
                    ],
                    [
                        RefundItem::FIELD_ID_REFUND_ITEM => 1,
                        RefundItem::FIELD_NAME => 'Refund item 2',
                        RefundItem::FIELD_REASON => 'Reason',
                        RefundItem::FIELD_GROSS_PRICE => 110,
                        RefundItem::FIELD_TOTAL_GROSS_PRICE => 99,
                        RefundItem::FIELD_QUANTITY => 1,
                        RefundItem::FIELD_TAX_AMOUNT => 112,
                        RefundItem::FIELD_TAX_RATE => 19,
                        RefundItem::FIELD_DISCOUNT_AMOUNT => 100,
                    ],
                    [
                        RefundItem::FIELD_ID_REFUND_ITEM => 1,
                        RefundItem::FIELD_NAME => 'Refund item 3',
                        RefundItem::FIELD_REASON => 'Reason',
                        RefundItem::FIELD_GROSS_PRICE => 100,
                        RefundItem::FIELD_TOTAL_GROSS_PRICE => 199,
                        RefundItem::FIELD_QUANTITY => 1,
                        RefundItem::FIELD_TAX_AMOUNT => 112,
                        RefundItem::FIELD_TAX_RATE => 19,
                        RefundItem::FIELD_DISCOUNT_AMOUNT => 100,
                    ],
                ],
            ],
            []
        );

        return [
            'refundItemCollectionForm' => $form->createView(),
        ];
    }

}
