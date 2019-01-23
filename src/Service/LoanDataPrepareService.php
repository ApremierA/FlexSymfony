<?php
/**
 * Created by PhpStorm.
 * User: apremiera
 * Date: 23.01.19
 * Time: 15:57
 */

namespace App\Service;


class LoanDataPrepareService
{
    /**
     * @param array $data
     *
     * @return array
     */
    public static function preparePaymentAmountList(array $data) : array
    {
        $result = [];
        foreach ($data as $item) {
            $result[ strtotime($item->date) ] = $item->amount;
        }
        ksort($result);

        return $result;
    }

}