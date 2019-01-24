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
     * @var \DateTime
     */
    private $queryAtDate;

    /**
     * @var PaymentStoryModel
     */
    private $paymentStory;

    /**
     * DebtCalculateService constructor.
     *
     * @param \App\Model\PaymentStoryModel $paymentStory
     * @param \DateTime|null               $queryAtDate
     */
    public function __construct(PaymentStoryModel $paymentStory, \DateTime $queryAtDate = NULL)
    {
        $this->queryAtDate = $queryAtDate;
        $this->paymentStory = $paymentStory;
    }

    /**
     *
     * @return string
     */
    public function getDebtAmountSumm()
    {
        $this->calculateDebtByAtDate();

        $result = [
            'at Date Time' => $this->queryAtDate->format('Y-m-d H:i:s'),
            'debtAmountSumm' => $this->paymentStory->getDebtAmountSumm(),
            'debtPercentSumm' => $this->paymentStory->getDebtPercentSumm(),
            'debtBalanceSumm' => $this->paymentStory->getDebtLoanSumm()
        ];
        return $result;
    }


    /**
     * Main method
     * @throws \Exception
     */
    public function calculateDebtByAtDate()
    {
        if($this->queryAtDate === NULL) {
            throw new \Exception('Query date doesn`t exist');
        }

        // Платежи отстутствуют
        if (empty($this->paymentStory->getAmountList()) === TRUE) {
            return $this->calculateDebtWithoutPayment();
        }

        // Были платежи
        if (empty($this->paymentStory->getAmountList()) === FALSE) {
            return $this->calculateDebtWithPayment();
        }
    }

    /**
     * @param \DateTime $startDate
     * @param \DateTime $endDate
     *
     * @return int
     */
    private function getPeriodBetweenPayment(\DateTime $startDate, \DateTime $endDate) : int
    {
        $interval = new \DateInterval('P1D');
        $period = new \DatePeriod($startDate, $interval, $endDate);

        return iterator_count($period);
    }

    /**
     * calculate PaymentStory By Period
     *
     * @param $incomingSumm
     * @param $period
     * @param $percent
     *
     * @return void
     */
    private function calculatePaymentStoryByPeriod(float $incomingSumm, int $period, float $percent) : void
    {
        $percentSumm = 0;
        $debtBalance = $this->paymentStory->getDebtLoanSumm();
        if($debtBalance === 0.0) {
            $debtBalance = $this->paymentStory->getLoanBase();
            $this->paymentStory->setDebtLoanSumm($debtBalance);
        }

        for($i = 0; $i < $period; $i++) {
            $percentSumm += $debtBalance * $percent;

            $this->paymentStory->setDebtPercentSumm($percentSumm);
            $this->paymentStory->setDebtAmountSumm($debtBalance + $percentSumm);
        }

        $balancePercentSumm = $percentSumm - $incomingSumm;
        $balanceIncomingSumm = 0;
        if($incomingSumm > $percentSumm) {
            $balanceIncomingSumm = $incomingSumm - $percentSumm;
            $balancePercentSumm = 0;
        }

        $this->paymentStory->setDebtLoanSumm(
            $this->paymentStory->getDebtLoanSumm() - $balanceIncomingSumm
        );

        $this->paymentStory->setDebtPercentSumm($balancePercentSumm);

        $this->paymentStory->setDebtAmountSumm(
            $this->paymentStory->getDebtLoanSumm() + $this->paymentStory->getDebtPercentSumm()
        );

    }

    /**
     * Calculating PaymentStory from start loan date to end loan period or to query date.
     * Calculate Without Payments
     */
    private function calculateDebtWithoutPayment(): void
    {
        list($startDate, $endDate) = $this->getDebtPeriod();

        $period = $this->getPeriodBetweenPayment($startDate, $endDate);

        $this->calculatePaymentStoryByPeriod(
            0,
            $period,
            $this->paymentStory->getLoanPercent()
        );
    }

    /**
     * Calculating PaymentStory from start loan date to end loan period or to query date.
     * Calculate With Payments
     */
    private function calculateDebtWithPayment(): void
    {
        list($startDate, $endPeriodDate) = $this->getDebtPeriod();

        foreach ($this->paymentStory->getAmountList() as $amountTime => $amountSumm) {

            $endOfPeriod = FALSE;
            $incomingSumm = $amountSumm;

            // switch to next period
            if (isset($endDate) === true) {
                $startDate = clone($endDate);
            }

            $endDate = new \DateTime();
            $endDate->setTimestamp($amountTime);

            if($endDate->getTimestamp() > $endPeriodDate->getTimestamp()){
                $endDate = clone $endPeriodDate;
                $incomingSumm = 0;
                $endOfPeriod = TRUE;
            }

            $period = $this->getPeriodBetweenPayment($startDate, $endDate);
            $this->calculatePaymentStoryByPeriod(
                $incomingSumm,
                $period,
                $this->paymentStory->getLoanPercent()
            );

            // Exit from calc
            if($endOfPeriod === TRUE) {
                return;
            }

        }
    }


    /**
     * From start loan date to end loan period or to query date
     *
     * @return array
     */
    private function getDebtPeriod(): array
    {
        $startDate = clone $this->paymentStory->getLoanDate();
        $endDate = $this->queryAtDate;

        $endLoanDate = clone $this->paymentStory->getLoanDate();
        $endLoanDate->modify('+' . $this->paymentStory->getLoanDuration() . 'day');

        if ($endDate->getTimestamp() >= $endLoanDate->getTimestamp()) {
            $endDate = clone $endLoanDate;
        }

        return [$startDate, $endDate];
    }
}