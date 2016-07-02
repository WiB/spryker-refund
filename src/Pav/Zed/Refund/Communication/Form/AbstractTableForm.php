<?php

namespace Pav\Zed\Refund\Communication\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Valid;

abstract class AbstractTableForm extends AbstractType
{

    const FIELD_HEADER_ROW = 'header_row';
    const FIELD_TABLE_BODY = 'table_body';
    const FIELD_SUBMIT = 'submit';

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
        $this->addRefundItemsField($builder);
        $this->addSubmitField($builder);
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
            'prototype' => true,
            'constraints' => [
                new Valid(),
            ],
            'options' => [
                'label' => false,
            ],
        ]);

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addSubmitField(FormBuilderInterface $builder)
    {
        $builder->add(self::FIELD_SUBMIT, 'submit', [
            'label' => 'Save All',
            'attr' => [
                'class' => 'btn btn-primary'
            ]
        ]);

        return $this;
    }

}
