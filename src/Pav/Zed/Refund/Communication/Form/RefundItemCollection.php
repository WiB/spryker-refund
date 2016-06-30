<?php

namespace Pav\Zed\Refund\Communication\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Valid;

class RefundItemCollection extends AbstractType
{

    const FIELD_REFUND_ITEMS = 'refund_items';

    /**
     * @return string
     */
    public function getName()
    {
        return 'refund_item_collection';
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array $options
     *
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->addRefundItemsField($builder);
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addRefundItemsField(FormBuilderInterface $builder)
    {
        $builder->add(self::FIELD_REFUND_ITEMS, 'collection', [
            'type' => new RefundItem(),
            'label' => false,
            'allow_add' => true,
            'allow_delete' => true,
            'allow_extra_fields' => true,
            'constraints' => [
                new Valid(),
            ]
        ]);

        return $this;
    }

}
