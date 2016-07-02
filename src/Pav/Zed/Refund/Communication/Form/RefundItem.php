<?php

namespace Pav\Zed\Refund\Communication\Form;

use Spryker\Shared\Kernel\Store;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Required;

class RefundItem extends AbstractType
{

    const FIELD_ID_REFUND_ITEM = 'id_refund_item';
    const FIELD_NAME = 'name';
    const FIELD_REASON = 'reason';
    const FIELD_GROSS_PRICE = 'gross_price';
    const FIELD_TOTAL_GROSS_PRICE = 'total_gross_price';
    const FIELD_QUANTITY = 'quantity';
    const FIELD_DISCOUNT_AMOUNT = 'dicount_amount';
    const FIELD_TAX_AMOUNT = 'tax_amount';
    const FIELD_TAX_RATE = 'tax_rate';
    const FIELD_FK_REFUND = 'fk_refund';
    const FIELD_REMOVE = 'remove';
    const OPTION_REMOVE_BUTTON_HIDDEN = 'remove_button_hidden';
    const FIELD_FK_SALES_ORDER_ITEM = 'fk_sales_order_item';

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'refund_item';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setOptional([self::OPTION_REMOVE_BUTTON_HIDDEN]);

        parent::setDefaultOptions($resolver);
    }


    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array $options
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this
            ->addIdRefundItemField($builder)
            ->addFkRefundField($builder)
            ->addFkSalesOrderItemField($builder)
            ->addNameField($builder)
            ->addReasonField($builder)
            ->addQuantityField($builder)
            ->addGrossPriceField($builder)
            ->addTotalGrossPriceField($builder)
            ->addDiscountAmountField($builder)
            ->addTaxRateField($builder)
            ->addTaxAmountField($builder)
            ->addRemoveButtonField($builder);
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addIdRefundItemField(FormBuilderInterface $builder)
    {
        $builder->add(self::FIELD_ID_REFUND_ITEM, 'text', [
            'label' => '#',
            'constraints' => [
                new Required(),
                new NotBlank(),
            ],
            'disabled' => true,
        ]);

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addFkRefundField(FormBuilderInterface $builder)
    {
        $builder->add(self::FIELD_FK_REFUND, 'hidden', [
            'constraints' => [
                new Required(),
                new NotBlank(),
            ],
        ]);

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addFkSalesOrderItemField(FormBuilderInterface $builder)
    {
        $builder->add(self::FIELD_FK_SALES_ORDER_ITEM, 'hidden')
            ->addEventListener(
                FormEvents::POST_SET_DATA,
                function (FormEvent $event) {
                    $data = $event->getData();
                    $form = $event->getForm();

                    if (isset($data[self::FIELD_FK_SALES_ORDER_ITEM])) {
                        $form->offsetUnset(self::FIELD_REMOVE);
                        $form->add(self::FIELD_REMOVE, 'hidden');
                    }
                }
            );


        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addNameField(FormBuilderInterface $builder)
    {
        $builder->add(self::FIELD_NAME, 'text', [
            'label' => 'Name',
            'disabled' => true,
            'constraints' => [
                new Required(),
                new NotBlank(),
            ],
        ]);
        $builder->get(self::FIELD_NAME);
        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addReasonField(FormBuilderInterface $builder)
    {

        $builder->add(self::FIELD_REASON, 'textarea', [
            'label' => 'Reason',
        ]);

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addGrossPriceField(FormBuilderInterface $builder)
    {
        $builder->add(self::FIELD_GROSS_PRICE, 'money', [
            'currency' => Store::getInstance()->getCurrencyIsoCode(),
            'divisor' => 100,
            'label' => 'Gross Price',
            'constraints' => [
                new Required(),
                new NotBlank(),
            ]
        ]);

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addTotalGrossPriceField(FormBuilderInterface $builder)
    {
        $builder->add(self::FIELD_TOTAL_GROSS_PRICE, 'money', [
            'currency' => Store::getInstance()->getCurrencyIsoCode(),
            'divisor' => 100,
            'disabled' => true,
            'label' => 'Total Gross Price',
            'constraints' => [
                new Required(),
                new NotBlank(),
            ]
        ]);

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addQuantityField(FormBuilderInterface $builder)
    {
        $builder->add(self::FIELD_QUANTITY, 'integer', [
            'disabled' => true,
            'label' => 'Quantity',
            'constraints' => [
                new Required(),
                new NotBlank(),
            ]
        ]);

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addDiscountAmountField(FormBuilderInterface $builder)
    {
        $builder->add(self::FIELD_DISCOUNT_AMOUNT, 'money', [
            'currency' => Store::getInstance()->getCurrencyIsoCode(),
            'divisor' => 100,
            'label' => 'Discount Amount',
        ]);

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addTaxRateField(FormBuilderInterface $builder)
    {
        $builder->add(self::FIELD_TAX_RATE, 'integer', [
            'label' => 'TaxRate',
            'constraints' => [
                new Required(),
                new NotBlank(),
            ],
            'attr' => [
                'class' => 'col-sm-4'
            ],
        ]);

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addTaxAmountField(FormBuilderInterface $builder)
    {
        $builder->add(self::FIELD_TAX_AMOUNT, 'money', [
            'currency' => Store::getInstance()->getCurrencyIsoCode(),
            'divisor' => 100,
            'label' => 'Tax Amount',
            'disabled' => true,
            'constraints' => [
                new Required(),
                new NotBlank(),
            ]
        ]);

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addRemoveButtonField(FormBuilderInterface $builder)
    {
        $options = [
            'attr' => [
                'class' => 'btn btn-xs btn-danger remove-form-collection',
            ],
        ];

        $builder->add(self::FIELD_REMOVE, 'button', $options);

        return $this;
    }

}
