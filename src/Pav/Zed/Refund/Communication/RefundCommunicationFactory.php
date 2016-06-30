<?php

namespace Pav\Zed\Refund\Communication;

use Pav\Zed\Refund\Communication\Table\RefundTable;
use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;


/**
 * @method \Pav\Zed\Refund\Persistence\RefundQueryContainer getQueryContainer()
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

}
