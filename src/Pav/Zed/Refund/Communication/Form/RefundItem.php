<?php

namespace Pav\Zed\Refund\Communication\Form;

use Spryker\Shared\Kernel\Store;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
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

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'return_item';
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
            ->addNameField($builder)
            ->addReasonField($builder)
            ->addQuantityField($builder)
            ->addGrossPriceField($builder)
            ->addTotalGrossPriceField($builder)
            ->addDiscountAmountField($builder)
            ->addTaxRateField($builder)
            ->addTaxAmountField($builder);
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addIdRefundItemField(FormBuilderInterface $builder)
    {
        $builder->add(self::FIELD_ID_REFUND_ITEM, 'text', [
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
    protected function addNameField(FormBuilderInterface $builder)
    {
        $builder->add(self::FIELD_NAME, 'text', [
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
    protected function addReasonField(FormBuilderInterface $builder)
    {

        $builder->add(self::FIELD_REASON, 'text', [
            'constraints' => [
                new Required(),
                new NotBlank(),
            ],
            'disabled' => true,
            'attr' => [
                'foo' => true,
            ]
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
    protected function addTaxRateField(FormBuilderInterface $builder)
    {
        $builder->add(self::FIELD_TAX_RATE, 'integer', [
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
    protected function addTaxAmountField(FormBuilderInterface $builder)
    {
        $builder->add(self::FIELD_TAX_AMOUNT, 'money', [
            'currency' => Store::getInstance()->getCurrencyIsoCode(),
            'divisor' => 100,
            'constraints' => [
                new Required(),
                new NotBlank(),
            ]
        ]);

        return $this;
    }

}
