<?php
namespace Obiz\Challenges\CashMachine;

class CashDistributor
{

    /**
     *
     * @var array
     */
    public $availableBills = array();

    /**
     * @var array
     */
    public $bills = array();

    /**
     * Returns the bills that should be distributed for a given withdraw amount and available bills,
     * MINIMIZING the total number of distributed bills.
     * Ex: getBills(72) => array(50 => 1, 20 => 1, 2 => 1).
     *
     * @param int $withdrawAmount
     * @param array $availableBills
     * How much we want to withdraw from the cash distributor
     * @throws InvalidWithdrawException if the exact amount cannot be gathered with the available bills.
     * @return array Associative array representing the bills that should be distributed by the cash machine.
     */
    public function getMinimalAmountOfBills($withdrawAmount, $availableBills)
    {
        rsort($availableBills);
        $this->availableBills = $availableBills;
        $oneBill = 0;
        while ($this->validateAmount($withdrawAmount, $oneBill) === true) {
            $oneBill = $this->GetOneBill($withdrawAmount);
            $this->addBill($oneBill);
            $withdrawAmount -= $oneBill;
        }

        if ($this->validateWithdraw($withdrawAmount) === false) {
            throw new InvalidWithdrawException('Sorry, the exact amount cannot be gathered.');
        }

        return $this->bills;
    }

    /**
     * Return one bill, the best one.
     *
     * @param int $value
     * @return int
     */
    public function getOneBill($value)
    {
        foreach ($this->availableBills as $bill) {
            $bills = $this->getBills($value, $bill);
            $leftOver = gmp_div_r($value, $bill);

            if ($this->validateAmount($bills, $leftOver) === true) {
                return $bill;
            }
        }

         return min($this->availableBills);
    }


    /**
     * Calculate the number of bills to use
     * @param int $value
     * @param int $bill
     *
     * @return int
     */
    public function getBills($value, $bill)
    {
        return (int) floor($value / $bill);

    }


    /**
     * Validate the bill amount based on the left over value
     * @param int $billAmount
     * @param int $leftOver
     *
     * @return boolean
     */
    public function validateAmount($billAmount, $leftOver)
    {
        if ($billAmount > 0 && $this->validateBillByBill($leftOver) === true) {
            return true;
        }

        return false;

    }


    /**
     * Validate if a value is divisible by an available bill
     * @param unknown $value
     */
    public function validateBillByBill($value)
    {
        foreach ($this->availableBills as $bill) {
            if (gmp_div_r($value, $bill) === 0) {
                return true;
            }
        }

        return false;

    }


    /**
     * Add a defined bill to final bills array
     * @param int $bill
     */
    public function addBill($bill)
    {
        if (isset($this->bills[$bill]) === false) {
            $this->bills[$bill] = 1;
        } else {
            $this->bills[$bill]++;
        }

    }


    /**
     * Validate if the Withdraw is possible or not
     * @param int $withdrawAmount
     * @return boolean
     */
    public function validateWithdraw($withdrawAmount)
    {
        if ($withdrawAmount >= 0 && count($this->bills) > 0) {
            return true;
        }
        return false;

    }

}
