<?php

namespace Pav\Zed\Refund\Communication\Plugin\Gui;

use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \Pav\Zed\Refund\Communication\RefundCommunicationFactory getFactory()
 */
class RefundTablePlugin extends AbstractPlugin
{

    /**
     * @param int $idSalesOrder
     * @param string $dataUrl
     *
     * @return string
     */
    public function renderTable($idSalesOrder, $dataUrl)
    {
        $refundTable = $this->createRefundTable($idSalesOrder, $dataUrl);

        return $refundTable->render();
    }

    /**
     * @param int $idSalesOrder
     * @param string $dataUrl
     *
     * @return array
     */
    public function fetchData($idSalesOrder, $dataUrl)
    {
        $refundTable = $this->createRefundTable($idSalesOrder, $dataUrl);

        return $refundTable->fetchData();
    }

    /**
     * @param int $idSalesOrder
     * @param string $dataUrl
     *
     * @return \Pav\Zed\Refund\Communication\Table\RefundTable
     */
    protected function createRefundTable($idSalesOrder, $dataUrl)
    {
        $refundTable = $this->getFactory()
            ->createRefundTable($idSalesOrder, $dataUrl);

        return $refundTable;
    }

}
