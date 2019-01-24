<?php
/**
 * Created by PhpStorm.
 * User: apremiera
 * Date: 23.01.19
 * Time: 13:53
 */

namespace App\Model;


class PaymentStoryModel
{
    /**
     * @var float
     */
    private $loanBase;

    /**
     * @var float
     */
    private $loanPercent;

    /**
     * @var integer
     */
    private $loanDuration;

    /**
     * @var \DateTime
     */
    private $loanDate;

    /**
     * @var array
     * [
     *    [
     *      dateTime (int) => float
     *    ]
     * ]
     */
    private $amountList = [];

    /**
     * @var float
     */
    private $debtLoanSumm = 0.0;

    /**
     * @var float
     */
    private $debtPercentSumm = 0.0;

    /**
     * @var float
     */
    private $debtAmountSumm = 0.0;

    /**
     * @return float
     */
    public function getLoanBase(): float
    {
        return $this->loanBase;
    }

    /**
     * @param float $loanBase
     */
    public function setLoanBase(float $loanBase)
    {
        $this->loanBase = $loanBase;
    }

    /**
     * @return float
     */
    public function getLoanPercent(): float
    {
        return $this->loanPercent;
    }

    /**
     * @param float $loanPercent
     */
    public function setLoanPercent(float $loanPercent)
    {
        $this->loanPercent = $loanPercent;
    }

    /**
     * @return int
     */
    public function getLoanDuration(): int
    {
        return $this->loanDuration;
    }

    /**
     * @param int $loanDuration
     */
    public function setLoanDuration(int $loanDuration)
    {
        $this->loanDuration = $loanDuration;
    }

    /**
     * @return \DateTime
     */
    public function getLoanDate(): \DateTime
    {
        return $this->loanDate;
    }

    /**
     * @param string $loanDate
     */
    public function setLoanDate($loanDate)
    {
        $this->loanDate = new \DateTime($loanDate);
    }

    /**
     * @return array
     */
    public function getAmountList(): array
    {
        return $this->amountList;
    }

    /**
     * @param array $amountList
     */
    public function setAmountList(array $amountList)
    {
        $this->amountList = $amountList;
    }

    /**
     * @return float
     */
    public function getDebtLoanSumm(): float
    {
        return $this->debtLoanSumm;
    }

    /**
     * @param float $debtLoanSumm
     */
    public function setDebtLoanSumm(float $debtLoanSumm)
    {
        $this->debtLoanSumm = $debtLoanSumm;
    }

    /**
     * @return float
     */
    public function getDebtPercentSumm(): float
    {
        return $this->debtPercentSumm;
    }

    /**
     * @param float $debtPercentSumm
     */
    public function setDebtPercentSumm(float $debtPercentSumm)
    {
        $this->debtPercentSumm = $debtPercentSumm;
    }

    /**
     * @return float
     */
    public function getDebtAmountSumm(): float
    {
        return $this->debtAmountSumm;
    }

    /**
     * @param float $debtAmountSumm
     */
    public function setDebtAmountSumm(float $debtAmountSumm)
    {
        $this->debtAmountSumm = $debtAmountSumm;
    }

}