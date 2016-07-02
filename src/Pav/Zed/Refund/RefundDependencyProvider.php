<?php

namespace Pav\Zed\Refund;

use Pav\Zed\Refund\Communication\Plugin\Aggregator\DiscountTotalPlugin;
use Pav\Zed\Refund\Communication\Plugin\Aggregator\ItemAmountPlugin;
use Pav\Zed\Refund\Communication\Plugin\Aggregator\ItemDiscountPlugin;
use Pav\Zed\Refund\Communication\Plugin\Aggregator\ItemTaxPlugin;
use Pav\Zed\Refund\Communication\Plugin\Aggregator\RefundTotalPlugin;
use Pav\Zed\Refund\Communication\Plugin\Aggregator\SubTotalPlugin;
use Pav\Zed\Refund\Communication\Plugin\Aggregator\TaxTotalPlugin;
use Pav\Zed\Refund\Dependency\Facade\RefundToSalesAggregatorBridge;
use Pav\Zed\Refund\Dependency\Facade\RefundToTaxBridge;
use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;

class RefundDependencyProvider extends AbstractBundleDependencyProvider
{

    const FACADE_TAX = 'tax facade';
    const REFUND_ITEM_AGGREGATOR_PLUGINS = 'refund item aggregator plugins';
    const REFUND_TOTAL_AGGREGATOR_PLUGINS = 'refund total aggregator plugins';
    const FACADE_SALES_AGGREGATOR = 'sales aggregator facade';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideBusinessLayerDependencies(Container $container)
    {
        $container[self::FACADE_TAX] = function (Container $container) {
            return new RefundToTaxBridge($container->getLocator()->tax()->facade());
        };

        $container[self::FACADE_SALES_AGGREGATOR] = function (Container $container) {
            return new RefundToSalesAggregatorBridge($container->getLocator()->salesAggregator()->facade());
        };

        $container[self::REFUND_TOTAL_AGGREGATOR_PLUGINS] = function () {
            return $this->getRefundTotalAggregatorPlugins();
        };

        $container[self::REFUND_ITEM_AGGREGATOR_PLUGINS] = function () {
            return $this->getRefundItemAggregatorPlugins();
        };

        return $container;
    }

    /**
     * @return \Pav\Zed\Refund\Dependency\Plugin\RefundItemAggregatorPluginInterface[]
     */
    protected function getRefundItemAggregatorPlugins()
    {
        return [
            new ItemAmountPlugin(),
            new ItemTaxPlugin(),
            new ItemDiscountPlugin(),
        ];
    }

    /**
     * @return \Pav\Zed\Refund\Dependency\Plugin\RefundAggregatorPluginInterface[]
     */
    protected function getRefundTotalAggregatorPlugins()
    {
        return [
            new DiscountTotalPlugin(),
            new SubTotalPlugin(),
            new RefundTotalPlugin(),
            new TaxTotalPlugin()
        ];
    }

}
