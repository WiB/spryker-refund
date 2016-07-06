<?php

namespace Pav\Zed\Refund\Persistence;

interface RefundQueryContainerInterface
{

    /**
     * @return \Orm\Zed\Refund\Persistence\PavRefund
     */
    public function createPavRefund();

    /**
     * @return \Orm\Zed\Refund\Persistence\PavRefundItem
     */
    public function createPavRefundItem();

    /**
     * @param int $idRefund
     *
     * @return \Orm\Zed\Refund\Persistence\PavRefundQuery
     */
    public function queryRefundById($idRefund);

    /**
     * @param int $idRefundItem
     *
     * @return \Orm\Zed\Refund\Persistence\PavRefundItemQuery
     */
    public function queryRefundItemById($idRefundItem);

    /**
     * @param int $idSalesOrder
     *
     * @return \Orm\Zed\Refund\Persistence\PavRefundQuery
     */
    public function queryRefundByIdSalesOrder($idSalesOrder);


    /**
     * @param int[] $itemIds
     *
     * @return \Orm\Zed\Refund\Persistence\PavRefundQuery
     */
    public function queryRefundForOrderItems($itemIds);

}
