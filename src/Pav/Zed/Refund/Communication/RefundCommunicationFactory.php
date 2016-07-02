<?php

namespace Pav\Zed\Refund\Communication;

use Pav\Zed\Refund\Communication\Form\DataFormatter\RefundDataFormatter;
use Pav\Zed\Refund\Communication\Form\Handler\RefundHandler;
use Pav\Zed\Refund\Communication\Form\Refund;
use Pav\Zed\Refund\Communication\Form\RefundItem;
use Pav\Zed\Refund\Communication\Table\RefundTable;
use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;

/**
 * @method \Pav\Zed\Refund\Persistence\RefundQueryContainer getQueryContainer()
 * @method \Pav\Zed\Refund\Business\RefundFacade getFacade()
 */
class RefundCommunicationFactory extends AbstractCommunicationFactory
{

    /**
     * @param int $idSalesOrder
     * @param string $dataUrl
     *
     * @return \Pav\Zed\Refund\Communication\Table\RefundTable
     */
    public function createRefundTable($idSalesOrder, $dataUrl)
    {
        return new RefundTable(
            $this->getQueryContainer()->queryRefundByIdSalesOrder($idSalesOrder),
            $idSalesOrder,
            $dataUrl
        );
    }

    /**
     * @param array $formData
     * @param array $options
     *
     * @return \Symfony\Component\Form\FormInterface
     */
    public function createRefundForm(array $formData, array $options)
    {
        $refundForm = new Refund();

        return $this->getFormFactory()->create($refundForm, $formData, $options);
    }

    /**
     * @param array $formData
     * @param array $options
     *
     * @return \Symfony\Component\Form\FormInterface
     */
    public function createRefundItemForm(array $formData, array $options)
    {
        $refundItemForm = new RefundItem();

        return $this->getFormFactory()->create($refundItemForm, $formData, $options);
    }

    /**
     * @return \Pav\Zed\Refund\Communication\Form\DataFormatter\RefundDataFormatter
     */
    public function createRefundDataFormatter()
    {
        return new RefundDataFormatter();
    }

    /**
     * @return \Pav\Zed\Refund\Communication\Form\Handler\RefundHandler
     */
    public function createRefundHandler()
    {
        return new RefundHandler(
            $this->getFacade()
        );
    }

}
