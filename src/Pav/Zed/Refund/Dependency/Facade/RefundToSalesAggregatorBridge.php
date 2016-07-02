<?php

namespace Pav\Zed\Refund\Dependency\Facade;

use Generated\Shared\Transfer\OrderTransfer;
use Spryker\Zed\SalesAggregator\Business\SalesAggregatorFacade;

class RefundToSalesAggregatorBridge implements RefundToSalesAggregatorInterface
{

    /**
     * @var \Spryker\Zed\SalesAggregator\Business\SalesAggregatorFacade
     */
    protected $salesAggregatorFacade;

    /**
     * @param \Spryker\Zed\SalesAggregator\Business\SalesAggregatorFacade $salesAggregatorFacade
     */
    public function __construct(SalesAggregatorFacade $salesAggregatorFacade)
    {
        $this->salesAggregatorFacade = $salesAggregatorFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     *
     * @return \Generated\Shared\Transfer\OrderTransfer
     */
    public function getOrderTotalByOrderTransfer(OrderTransfer $orderTransfer)
    {
        return $this->salesAggregatorFacade->getOrderTotalByOrderTransfer($orderTransfer);
    }

}
