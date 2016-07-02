<?php

namespace Pav\Zed\Refund\Business;

use Pav\Zed\Refund\Business\Aggregator\Item\ItemAmount;
use Pav\Zed\Refund\Business\Aggregator\Item\ItemDiscount;
use Pav\Zed\Refund\Business\Aggregator\Item\ItemTax;
use Pav\Zed\Refund\Business\Aggregator\RefundTotalsAggregator;
use Pav\Zed\Refund\Business\Aggregator\Totals\DiscountTotal;
use Pav\Zed\Refund\Business\Aggregator\Totals\RefundTotal;
use Pav\Zed\Refund\Business\Aggregator\Totals\SubTotal;
use Pav\Zed\Refund\Business\Aggregator\Totals\TaxTotal;
use Pav\Zed\Refund\Business\Manager\OrderRefundManager;
use Pav\Zed\Refund\Business\Reader\RefundReader;
use Pav\Zed\Refund\Business\Writer\RefundWriter;
use Pav\Zed\Refund\RefundDependencyProvider;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \Pav\Zed\Refund\Persistence\RefundQueryContainer getQueryContainer()
 */
class RefundBusinessFactory extends AbstractBusinessFactory
{

    /**
     * @return \Pav\Zed\Refund\Business\Manager\OrderRefundManager
     */
    public function createOrderRefundManager()
    {
        return new OrderRefundManager(
            $this->createRefundWriter(),
            $this->getSalesAggregatorFacade()
        );
    }

    /**
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException
     * @return \Pav\Zed\Refund\Business\Aggregator\RefundTotalsAggregatorInterface
     */
    public function createRefundTotalsAggregator()
    {
        return new RefundTotalsAggregator(
            $this->getProvidedDependency(RefundDependencyProvider::REFUND_TOTAL_AGGREGATOR_PLUGINS),
            $this->getProvidedDependency(RefundDependencyProvider::REFUND_ITEM_AGGREGATOR_PLUGINS)
        );
    }

    /**
     * @return \Pav\Zed\Refund\Business\Reader\RefundReader
     */
    public function createRefundReader()
    {
        return new RefundReader(
            $this->getQueryContainer(),
            $this->createRefundTotalsAggregator()
        );
    }

    /**
     * @return \Pav\Zed\Refund\Business\Writer\RefundWriterInterface
     */
    public function createRefundWriter()
    {
        return new RefundWriter(
            $this->getQueryContainer()
        );
    }

    /**
     * @return \Pav\Zed\Refund\Business\Aggregator\Item\ItemAmount
     */
    public function createItemAmountAggregator()
    {
        return new ItemAmount();
    }

    /**
     * @return \Pav\Zed\Refund\Business\Aggregator\Item\ItemDiscount
     */
    public function createItemDiscountAggregator()
    {
        return new ItemDiscount();
    }

    /**
     * @return \Pav\Zed\Refund\Business\Aggregator\Item\ItemTax
     */
    public function createItemTaxAggregator()
    {
        return new ItemTax(
            $this->getTaxFacade()
        );
    }

    /**
     * @return \Pav\Zed\Refund\Business\Aggregator\Totals\DiscountTotal
     */
    public function createDiscountTotalAggregator()
    {
        return new DiscountTotal();
    }

    /**
     * @return \Pav\Zed\Refund\Business\Aggregator\Totals\RefundTotal
     */
    public function createRefundTotalAggregator()
    {
        return new RefundTotal();
    }

    /**
     * @return \Pav\Zed\Refund\Business\Aggregator\Totals\SubTotal
     */
    public function createSubTotalAggregator()
    {
        return new SubTotal();
    }

    /**
     * @return \Pav\Zed\Refund\Business\Aggregator\Totals\TaxTotal
     */
    public function createTaxTotalAggregator()
    {
        return new TaxTotal(
            $this->getTaxFacade()
        );
    }

    /**
     * @return \Pav\Zed\Refund\Dependency\Facade\RefundToTaxInterface
     */
    protected function getTaxFacade()
    {
        return $this->getProvidedDependency(RefundDependencyProvider::FACADE_TAX);
    }

    /**
     * @return \Pav\Zed\Refund\Dependency\Facade\RefundToSalesAggregatorInterface
     */
    protected function getSalesAggregatorFacade()
    {
        return $this->getProvidedDependency(RefundDependencyProvider::FACADE_SALES_AGGREGATOR);
    }

}
