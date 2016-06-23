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
     * @param int $idRefundItem
     *
     * @return \Orm\Zed\Refund\Persistence\PavRefundItemQuery
     */
    public function queryRefundItemById($idRefundItem);

}
