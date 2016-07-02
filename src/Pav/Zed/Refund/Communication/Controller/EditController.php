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
        $refundItemForm = $this->getRefundItemForm($request, $refundTransfer);

        if ($refundForm->isValid()) {
            $this->handleRefundForm($refundForm);

            return $this->redirectResponse('/refund/edit?id-refund=' . $idRefund);
        }

        return [
            'refund' => $refundTransfer,
            'refundForm' => $refundForm->createView(),
            'refundItemForm' => $refundItemForm->createView(),
        ];
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function addShippingCostsAction(Request $request)
    {
        $idRefund = $this->castId($request->get(RefundConstants::PARAM_ID_REFUND));
        $refundTransfer = $this->getFacade()->getRefund($idRefund);

        return $this->redirectResponse('/refund/edit?id-refund=' . $idRefund);
    }

    public function deleteItem(Request $request)
    {
        $idRefundItem = $this->castId($request->get(RefundConstants::PARAM_ID_REFUND_ITEM));

//        return $this->redirectResponse('/refund/edit?id-refund=' . $idRefund);
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

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \Generated\Shared\Transfer\RefundTransfer $refundTransfer
     *
     * @return \Symfony\Component\Form\FormInterface
     */
    protected function getRefundItemForm(Request $request, RefundTransfer $refundTransfer)
    {
        return $this->getFactory()->createRefundItemForm(
            [],
            []
        );
    }

}
