<?php

namespace Pav\Zed\Refund\Business\Writer;

use Generated\Shared\Transfer\RefundItemTransfer;
use Generated\Shared\Transfer\RefundTransfer;
use Pav\Zed\Refund\Business\Exception\RefundItemNotFoundException;
use Pav\Zed\Refund\Persistence\RefundQueryContainerInterface;

class RefundWriter implements RefundWriterInterface
{

    /**
     * @var \Pav\Zed\Refund\Persistence\RefundQueryContainerInterface
     */
    protected $queryContainer;

    /**
     * @param \Pav\Zed\Refund\Persistence\RefundQueryContainerInterface $queryContainer
     */
    public function __construct(RefundQueryContainerInterface $queryContainer)
    {
        $this->queryContainer = $queryContainer;
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
        $refundItemEntity = $this->queryContainer->createPavRefundItem();
        $refundItemEntity->fromArray($refundItem->toArray());
        $refundItemEntity->save();

        $refundItem->setIdRefundItem($refundItemEntity->getIdRefundItem());

        return $refundItem;
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

}
