<?php

namespace Pav\Zed\Refund\Communication\Controller;

use Generated\Shared\Transfer\RefundTransfer;
use Pav\Shared\Refund\RefundConstants;
use Pav\Zed\Refund\Communication\Form\Refund;
use Pav\Zed\Refund\Communication\Form\RefundItem;
use Spryker\Zed\Application\Communication\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
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
        $idRefund = $this->castId($request->get(RefundConstants::PARAM_ID_REFUND));
        $refundTransfer = $this->getFacade()->getRefund($idRefund);

        $refundForm = $this->getRefundForm($request, $refundTransfer);

        if ($refundForm->isValid()) {
            $this->handleRefundForm($refundForm);
        }

        return [
            'refund' => $refundTransfer,
            'refundForm' => $refundForm->createView(),
        ];
    }

    protected function getItemMock()
    {
        return [
            Refund::FIELD_TABLE_BODY => [
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
        ];

    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \Generated\Shared\Transfer\RefundTransfer $refundTransfer
     *
     * @return \Symfony\Component\Form\FormInterface
     */
    protected function getRefundForm(Request $request, RefundTransfer $refundTransfer)
    {
        $formData = $this->getFactory()
            ->createRefundDataFormatter()
            ->formatData($refundTransfer);

        return $this->getFactory()
            ->createRefundForm($formData, [])
            ->handleRequest($request);
    }

    /**
     * @param \Symfony\Component\Form\FormInterface $refundForm
     *
     * @return void
     */
    protected function handleRefundForm(FormInterface $refundForm)
    {
        try {
            $this->getFactory()
                ->createRefundHandler()
                ->handleForm($refundForm);

            $this->addSuccessMessage('Refund items successfully updated.');
        } catch (\Exception $exception) {
            $this->addErrorMessage(
                $exception->getMessage(),
                $exception->getTraceAsString()
            );
        }
    }

}
