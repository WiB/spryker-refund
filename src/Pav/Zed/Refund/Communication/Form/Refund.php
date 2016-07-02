<?php

namespace Pav\Zed\Refund\Communication\Form;

class Refund extends AbstractTableForm
{

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
