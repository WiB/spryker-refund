<?php

namespace Pav\Zed\Refund\Dependency\Facade;

use Spryker\Zed\Tax\Business\TaxFacade;

class RefundToTaxBridge implements RefundToTaxInterface
{

    /**
     * @var \Spryker\Zed\Tax\Business\TaxFacade
     */
    protected $refundTaxFacade;

    /**
     * @param \Spryker\Zed\Tax\Business\TaxFacade $refundTaxFacade
     */
    public function __construct(TaxFacade $refundTaxFacade)
    {
        $this->refundTaxFacade = $refundTaxFacade;
    }

    /**
     * @param int $grossPrice
     * @param float $taxRate
     *
     * @return int
     */
    public function getTaxAmountFromGrossPrice($grossPrice, $taxRate)
    {
        return $this->refundTaxFacade->getTaxAmountFromGrossPrice($grossPrice, $taxRate);
    }

}
