<?php

namespace Pav\Zed\Refund\Business\Reader;

use Generated\Shared\Transfer\RefundItemTransfer;
use Generated\Shared\Transfer\RefundTransfer;
use Orm\Zed\Refund\Persistence\PavRefund;
use Pav\Zed\Refund\Business\Aggregator\RefundTotalsAggregatorInterface;
use Pav\Zed\Refund\Business\Exception\MultipleRefundsFoundException;
use Pav\Zed\Refund\Business\Exception\RefundNotFoundException;
use Pav\Zed\Refund\Persistence\RefundQueryContainerInterface;

class RefundReader
{

    /**
     * @var \Pav\Zed\Refund\Persistence\RefundQueryContainerInterface
     */
    protected $queryContainer;

    /**
     * @var \Pav\Zed\Refund\Business\Aggregator\RefundTotalsAggregatorInterface
     */
    protected $totalsAggregator;

    /**
     * @param \Pav\Zed\Refund\Persistence\RefundQueryContainerInterface $queryContainer
     * @param \Pav\Zed\Refund\Business\Aggregator\RefundTotalsAggregatorInterface $totalsAggregator
     */
    public function __construct(
        RefundQueryContainerInterface $queryContainer,
        RefundTotalsAggregatorInterface $totalsAggregator
    ) {
        $this->queryContainer = $queryContainer;
        $this->totalsAggregator = $totalsAggregator;
    }

    /**
     * @param int $idRefund
     *
     * @throws \Pav\Zed\Refund\Business\Exception\RefundNotFoundException
     * @return \Generated\Shared\Transfer\RefundTransfer
     */
    public function getRefund($idRefund)
    {
        $refundEntity = $this->queryContainer
            ->queryRefundById($idRefund)
            ->findOne();

        if ($refundEntity === null) {
            throw new RefundNotFoundException(
                sprintf('Refund entity id: %s not found', $idRefund)
            );
        }

        $refundTransfer = $this->convertToTransfer($refundEntity);
        $refundTransfer = $this->totalsAggregator->aggregate($refundTransfer);

        return $refundTransfer;
    }


    /**
     * @param int[] $itemIds
     * @param bool $aggregateTotals
     *
     * @throws \Exception
     * @return \Generated\Shared\Transfer\RefundTransfer|null
     */
    public function getRefundForOrderItems(array $itemIds, $aggregateTotals = false)
    {
        $refunds = $this->queryContainer
            ->queryRefundForOrderItems($itemIds)
            ->find();

        $refundCount = count($refunds);

        if ($refundCount === 0) {
            return null;
        }

        if ($refundCount > 1) {
            throw new MultipleRefundsFoundException(
                'Multiple refunds found for items.'
            );
        }

        $refundEntity = $refunds[0];
        $refundTransfer = $this->convertToTransfer($refundEntity);

        if ($aggregateTotals) {
            $this->totalsAggregator->aggregate($refundTransfer);
        }

        return $refundTransfer;
    }

    /**
     * @param \Orm\Zed\Refund\Persistence\PavRefund $refundEntity
     *
     * @return \Generated\Shared\Transfer\RefundTransfer
     */
    protected function convertToTransfer(PavRefund $refundEntity)
    {
        $refundTransfer = new RefundTransfer();
        $refundTransfer->fromArray($refundEntity->toArray(), true);

        foreach ($refundEntity->getRefundItems() as $refundItem) {
            $refundItemTransfer = new RefundItemTransfer();
            $refundItemTransfer->fromArray($refundItem->toArray(), true);

            $refundTransfer->addItem($refundItemTransfer);
        }

        return $refundTransfer;
    }

}
