<?php

namespace Pav\Zed\Refund\Communication\Table;

use Orm\Zed\Refund\Persistence\Map\PavRefundTableMap;
use Orm\Zed\Refund\Persistence\PavRefundQuery;
use Pav\Shared\Refund\RefundConstants;
use Spryker\Zed\Gui\Communication\Table\AbstractTable;
use Spryker\Zed\Gui\Communication\Table\TableConfiguration;

class RefundTable extends AbstractTable
{

    const COLUMN_ACTION = 'Action';

    /**
     * @var \Orm\Zed\Refund\Persistence\PavRefundQuery
     */
    protected $refundQuery;

    /**
     * @var int
     */
    protected $idSalesOrder;

    /**
     * @var string
     */
    protected $dataUrl;

    /**
     * @param \Orm\Zed\Refund\Persistence\PavRefundQuery $refundQuery
     * @param int $idSalesOrder
     * @param string $dataUrl
     */
    public function __construct(PavRefundQuery $refundQuery, $idSalesOrder, $dataUrl = '')
    {
        $this->refundQuery = $refundQuery;
        $this->idSalesOrder = $idSalesOrder;
        $this->dataUrl = $dataUrl;
    }

    /**
     * @param \Spryker\Zed\Gui\Communication\Table\TableConfiguration $config
     *
     * @return \Spryker\Zed\Gui\Communication\Table\TableConfiguration
     */
    protected function configure(TableConfiguration $config)
    {
        $config->setHeader(
            [
                PavRefundTableMap::COL_ID_REFUND => 'Id',
                PavRefundTableMap::COL_SUCCESSFUL => 'Successful',
                PavRefundTableMap::COL_COMMENT => 'Comment',
                PavRefundTableMap::COL_CREATED_AT => 'Created At',
                self::COLUMN_ACTION => self::COLUMN_ACTION
            ]
        );

        $url = '/index';

        if ($this->dataUrl !== '') {
            $url = $this->dataUrl;
        }

        $config->setUrl($url . '?' . RefundConstants::PARAM_ID_SALES_ORDER . '=' . $this->idSalesOrder);

        return $config;
    }

    /**
     * @param \Spryker\Zed\Gui\Communication\Table\TableConfiguration $config
     *
     * @return array
     */
    protected function prepareData(TableConfiguration $config)
    {
        $queryResults = $this->runQuery($this->refundQuery, $config);
        $refundCollection = [];

        foreach ($queryResults as $refund) {
            $refundCollection[] = [
                PavRefundTableMap::COL_ID_REFUND => $refund[PavRefundTableMap::COL_ID_REFUND],
                PavRefundTableMap::COL_SUCCESSFUL => $this->createSuccessfulLabel($refund[PavRefundTableMap::COL_SUCCESSFUL]),
                PavRefundTableMap::COL_COMMENT => $refund[PavRefundTableMap::COL_COMMENT],
                PavRefundTableMap::COL_CREATED_AT => $this->formatDate($refund[PavRefundTableMap::COL_CREATED_AT]),
                self::COLUMN_ACTION => $this->createActionColumn($refund),
            ];
        }

        return $refundCollection;
    }

    /**
     * @param array $refund
     *
     * @return array
     */
    protected function createActionColumn(array $refund)
    {
        $idRefund = $refund[PavRefundTableMap::COL_ID_REFUND];

        $buttons = [];

        $editRefundUrl = sprintf(
            '/refund/edit?%s=%s',
            RefundConstants::PARAM_ID_REFUND,
            $idRefund
        );

        $buttons[] = $this->generateEditButton($editRefundUrl, 'Edit');

        return $buttons;
    }

    /**
     * @param bool $successful
     *
     * @return array
     */
    protected function createSuccessfulLabel($successful)
    {
        $labels = [];

        if ($successful === true) {
            $labels[] = '<span class="label label-primary">successful</span>';
        } elseif ($successful === false) {
            $labels[] = '<span class="label label-danger">failed</span>';
        }

        return $labels;
    }

    /**
     * @param string $rawDate
     *
     * @return string
     */
    protected function formatDate($rawDate)
    {
        return (new \DateTime($rawDate))
            ->format('Y-m-d H:i:s');
    }

}
