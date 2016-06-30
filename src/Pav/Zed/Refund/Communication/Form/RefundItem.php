<?php

namespace Pav\Zed\Refund\Communication\Form;

use Symfony\Component\Form\AbstractType;

class RefundItem extends AbstractType
{

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'return_item';
    }

}
