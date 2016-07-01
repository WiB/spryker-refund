<?php

namespace Pav\Zed\Refund\Communication\Form;

class Refund extends AbstractTableForm
{

    const FIELD_HEADER_ROW = 'header_row';
    const FIELD_TABLE_BODY = 'table_body';

    /**
     * @return string
     */
    public function getName()
    {
        return 'refund_item_collection';
    }

    /**
     * @return \Pav\Zed\Refund\Communication\Form\RefundItem
     */
    protected function getTableItemType()
    {
        return new RefundItem();
    }

}
