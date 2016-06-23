<?php

namespace Pav\Zed\Refund\Business;

use Pav\Zed\Refund\Business\Manager\RefundManager;
use Pav\Zed\Refund\Business\Writer\RefundWriter;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \Pav\Zed\Refund\Persistence\RefundQueryContainer getQueryContainer()
 */
class RefundBusinessFactory extends AbstractBusinessFactory
{

    /**
     * @return \Pav\Zed\Refund\Business\Manager\RefundManager
     */
    public function createRefundManager()
    {
        return new RefundManager(
            $this->createRefundWriter()
        );
    }

    /**
     * @return \Pav\Zed\Refund\Business\Writer\RefundWriterInterface
     */
    protected function createRefundWriter()
    {
        return new RefundWriter(
            $this->getQueryContainer()
        );
    }


}
