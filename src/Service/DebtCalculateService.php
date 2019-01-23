<?php
/**
 * Created by PhpStorm.
 * User: apremiera
 * Date: 23.01.19
 * Time: 13:56
 */

namespace App\Service;

use App\Model\PaymentStoryModel;

class DebtCalculateService
{
    /**
     * @var PaymentStoryModel
     */
    private $paymentStory;

    /**
     * DebtCalculateService constructor.
     *
     * @param \App\Model\PaymentStoryModel $paymentStory
     */
    public function __construct(PaymentStoryModel $paymentStory)
    {
        $this->paymentStory = $paymentStory;
    }

    /**
     * @return float
     */
    public function getDebtAmountSumm()
    {
        $this->calculateDebt();

        return __METHOD__;
        return $this->paymentStory->getDebtAmountSumm();
    }

    private function calculateDebt() : void
    {

        foreach ($this->paymentStory->getAmountList() as $key => $value) {

        }
    }

    /**
     * Метод расчета задолженности за период
     *
     * @param $loanSumm
     * @param $period
     * @param $percent
     *
     * @return float
     */
    private function calculateDebtSummByPeriod($loanSumm, $period, $percent) : float
    {

    }
}