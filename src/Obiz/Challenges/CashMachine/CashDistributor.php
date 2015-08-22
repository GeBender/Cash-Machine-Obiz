<?php

namespace Obiz\Challenges\CashMachine;

class CashDistributor
{
    /**
     * @var array
     */
    private $availableBills = array(100, 50, 20, 10, 5, 2);

    /**
     * Returns the bills that should be distributed for a given withdraw amount and available bills,
     * MINIMIZING the total number of distributed bills.
     * Ex: getBills(72) => array(50 => 1, 20 => 1, 2 => 1).
     *
     * @param int $withdrawAmount How much we want to withdraw from the cash distributor
     * @throws InvalidWithdrawException if the exact amount cannot be gathered with the available bills.
     * @return array Associative array representing the bills that should be distributed by the cash machine.
     */
    public function getMinimalAmountOfBills($withdrawAmount)
    {
        $billsCollection = array();
        foreach ($this->availableBills as $v) {
            $bills = $this->getMaximunBills($v);
        }
        throw new InvalidWithdrawException('Sorry, the exact amount cannot be gathered. Please try again.');

    }


    /**
     * Returns the maximun amount of bills for a bill value
     * @param int $value The bill value
     * @return int
     */
    public function getMaximunBills($value)
    {
        return 2;
    }

}
