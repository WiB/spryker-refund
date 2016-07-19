<?php

namespace Pav\Zed\Refund\Business\Writer;

use Generated\Shared\Transfer\RefundItemTransfer;
use Generated\Shared\Transfer\RefundTransfer;
use Pav\Zed\Refund\Business\Aggregator\RefundTotalsAggregatorInterface;
use Pav\Zed\Refund\Business\Exception\RefundItemNotFoundException;
use Pav\Zed\Refund\Business\Exception\RefundNotFoundException;
use Pav\Zed\Refund\Persistence\RefundQueryContainerInterface;

class RefundWriter implements RefundWriterInterface
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
     * @param \Generated\Shared\Transfer\RefundTransfer $refund
     *
     * @throws \Propel\Runtime\Exception\PropelException
     * @return \Generated\Shared\Transfer\RefundTransfer
     */
    public function writeRefund(RefundTransfer $refund)
    {
        $refundEntity = $this->queryContainer->createPavRefund();
        $refundEntity->fromArray($refund->toArray());
        $refundEntity->setIsCustom($this->isCustomRefund($refund));
        $refundEntity->save();

        $refund->setIdRefund($refundEntity->getIdRefund());

        foreach ($refund->getItems() as $item) {
            $item->setFkRefund($refund->getIdRefund());
            $this->writeRefundItem($item);
        }

        return $refund;
    }

    /**
     * @param \Generated\Shared\Transfer\RefundItemTransfer $refundItem
     *
     * @throws \Propel\Runtime\Exception\PropelException
     * @return \Generated\Shared\Transfer\RefundItemTransfer
     */
    public function writeRefundItem(RefundItemTransfer $refundItem)
    {
        $refundItem = $this->totalsAggregator->aggregateItem($refundItem);

        $refundItemEntity = $this->queryContainer->createPavRefundItem();
        $refundItemEntity->fromArray($refundItem->toArray());
        $refundItemEntity->save();

        $refundItem->setIdRefundItem($refundItemEntity->getIdRefundItem());

        return $refundItem;
    }

    /**
     * @param int $idRefund
     *
     * @return int
     */
    public function setRefundNotSuccessful($idRefund)
    {
        return $this->setRefundSuccess($idRefund, false);
    }

    /**
     * @param int $idRefund
     *
     * @return int
     */
    public function setRefundSuccessful($idRefund)
    {
        return $this->setRefundSuccess($idRefund, true);
    }

    /**
     * @param int $idRefund
     *
     * @return int
     */
    public function setRefundIsManual($idRefund)
    {
        return $this->setRefundIsManualFlag($idRefund, true);
    }

    /**
     * @param int $idRefund
     *
     * @return int
     */
    public function setRefundIsNotManual($idRefund)
    {
        return $this->setRefundIsManualFlag($idRefund, false);
    }

    /**
     * @param \Generated\Shared\Transfer\RefundTransfer $refundTransfer
     *
     * @throws \Pav\Zed\Refund\Business\Exception\RefundNotFoundException
     * @throws \Propel\Runtime\Exception\PropelException
     * @return \Generated\Shared\Transfer\RefundTransfer
     */
    public function updateRefund(RefundTransfer $refundTransfer)
    {
        $idRefund = $refundTransfer->getIdRefund();

        $refundEntity = $this->getRefundEntity($idRefund);

        $refundEntity->setComment($refundTransfer->getComment());
        $refundEntity->save();

        return $refundTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\RefundItemTransfer[] $refundItems
     *
     * @throws \Pav\Zed\Refund\Business\Exception\RefundItemNotFoundException
     * @return array
     */
    public function createOrUpdateRefundItems(array $refundItems)
    {
        foreach ($refundItems as $refundItem) {
            if ($refundItem->getIdRefundItem() === null) {
                $this->writeRefundItem($refundItem);
            } else {
                $this->updateRefundItem($refundItem);
            }
        }

        return $refundItems;
    }

    /**
     * @param int $idRefundItem
     * @throws \Pav\Zed\Refund\Business\Exception\RefundItemNotFoundException
     *
     * @return bool
     */
    public function deleteRefundItem($idRefundItem)
    {
        $refundItemEntity = $this->queryContainer
            ->queryRefundItemById($idRefundItem)
            ->findOne();

        if ($refundItemEntity === null) {
            throw new RefundItemNotFoundException(
                sprintf('Refund item %s not found', $idRefundItem)
            );
        }

        if ($refundItemEntity->getFkSalesOrderItem() === null) {
            $refundItemEntity->delete();

            return true;
        }

        return false;
    }

    /**
     * @param \Generated\Shared\Transfer\RefundItemTransfer $refundItem
     *
     * @throws \Pav\Zed\Refund\Business\Exception\RefundItemNotFoundException
     * @return \Generated\Shared\Transfer\RefundItemTransfer
     */
    protected function updateRefundItem(RefundItemTransfer $refundItem)
    {
        $idRefundItem = $refundItem->getIdRefundItem();

        $refundItemEntity = $this->queryContainer
            ->queryRefundItemById($idRefundItem)
            ->findOne();

        if ($refundItemEntity === null) {
            throw new RefundItemNotFoundException(
                sprintf('Refund item %s not found', $idRefundItem)
            );
        }

        $refundItemEntity->fromArray($refundItem->toArray());
        $refundItemEntity->save();

        return $refundItem;
    }

    /**
     * @param int $idRefund
     *
     * @throws \Pav\Zed\Refund\Business\Exception\RefundNotFoundException
     * @return \Orm\Zed\Refund\Persistence\PavRefund
     */
    protected function getRefundEntity($idRefund)
    {
        $refundEntity = $this->queryContainer
            ->queryRefundById($idRefund)
            ->findOne();

        if ($refundEntity === null) {
            throw new RefundNotFoundException(
                sprintf('Refund %s not found', $idRefund)
            );
        }

        return $refundEntity;
    }

    /**
     * @param int $idRefund
     * @param bool $successful
     *
     * @throws \Pav\Zed\Refund\Business\Exception\RefundNotFoundException
     * @throws \Propel\Runtime\Exception\PropelException
     * @return int
     */
    protected function setRefundSuccess($idRefund, $successful)
    {
        $refundEntity = $this->getRefundEntity($idRefund);
        $refundEntity->setSuccessful($successful);

        return $refundEntity->save();
    }

    /**
     * @param int $idRefund
     * @param bool $isManual
     *
     * @throws \Pav\Zed\Refund\Business\Exception\RefundNotFoundException
     * @throws \Propel\Runtime\Exception\PropelException
     * @return int
     */
    protected function setRefundIsManualFlag($idRefund, $isManual)
    {
        $refundEntity = $this->getRefundEntity($idRefund);
        $refundEntity->setIsManual($isManual);

        return $refundEntity->save();
    }

    /**
     * @param \Generated\Shared\Transfer\RefundTransfer $refundTransfer
     *
     * @return bool
     */
    protected function isCustomRefund(RefundTransfer $refundTransfer)
    {
        foreach ($refundTransfer->getItems() as $refundItem) {
            if ($refundItem->getFkSalesOrderItem() !== null) {
                return false;
            }
        }

        return true;
    }

}
