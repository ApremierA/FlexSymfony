<?php
/**
 * Created by PhpStorm.
 * User: apremiera
 * Date: 23.01.19
 * Time: 13:25
 */

namespace App\Handler;

use App\Model\PaymentStoryModel;
use App\Service\DebtCalculateService;
use App\Service\LoanDataPrepareService;

class LoanCalculateHandler
{
    /**
     * @var \DateTime
     */
    private $queryAtDate;

    /**
     * @var \stdClass
     */
    private $loanData;

    public function __construct($loanData)
    {
        $this->loanData = $loanData;
    }

    /**
     * @return array
     */
    public function handle()
    {
        try {
            $paymentStory = $this->loanDataMapperToStory();

            $result = $this->getAmountSumm($paymentStory);

        } catch (\Exception $result) {}

        return $this->prepareResponse($result);
    }

    /**
     * @param \App\Model\PaymentStoryModel $paymentStory
     *
     * @return float
     */
    private function getAmountSumm(PaymentStoryModel $paymentStory)
    {
        $debtService = new DebtCalculateService($paymentStory, $this->queryAtDate);
        $debtSumm = $debtService->getDebtAmountSumm();

        return $debtSumm;
    }

    /**
     * Если результат - Exception, возвращает ошибку
     * @param $result
     *
     * @return array
     */
    private function prepareResponse($result)
    {
        if($result instanceof \Exception) {
            return [
                "error" => $result->getMessage()
            ];
        }

        return [
            "summ" => $result
        ];
    }

    /**
     * @return \App\Model\PaymentStoryModel
     * @throws \Exception
     */
    private function loanDataMapperToStory() : PaymentStoryModel
    {
        if(empty($this->loanData) === true) {
            throw new \Exception('Request data is empty');
        }

        //@TODO Validator here
        $this->queryAtDate = new \DateTime($this->loanData->atDate);

        $paymentStory = new PaymentStoryModel();
        $paymentStory->setLoanBase($this->loanData->loan->base);
        $paymentStory->setLoanDate($this->loanData->loan->date);
        $paymentStory->setLoanPercent($this->loanData->loan->percent);
        $paymentStory->setLoanDuration($this->loanData->loan->duration);

        $amountList = LoanDataPrepareService::preparePaymentAmountList($this->loanData->payments);
        $paymentStory->setAmountList($amountList);

        return $paymentStory;
    }


}