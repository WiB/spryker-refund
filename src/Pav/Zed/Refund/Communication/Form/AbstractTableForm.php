<?php

namespace Pav\Zed\Refund\Communication\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Valid;

abstract class AbstractTableForm extends AbstractType
{

    const FIELD_HEADER_ROW = 'header_row';
    const FIELD_TABLE_BODY = 'table_body';

    /**
     * @return \Symfony\Component\Form\AbstractType
     */
    abstract protected function getTableItemType();

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array $options
     *
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->addHeaderRowField($builder);
        $this->addRefundItemsField($builder);
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addRefundItemsField(FormBuilderInterface $builder)
    {
        $builder->add(self::FIELD_TABLE_BODY, 'collection', [
            'type' => $this->getTableItemType(),
            'label' => false,
            'allow_add' => true,
            'allow_delete' => true,
            'allow_extra_fields' => true,
            'constraints' => [
                new Valid(),
            ],
        ]);

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addHeaderRowField(FormBuilderInterface $builder)
    {
        $builder->add(self::FIELD_HEADER_ROW, $this->getTableItemType(), [
            'attr' => [
                'novalidate' => 'novalidate'
            ]
        ]);

        return $this;
    }

}
