<?php
namespace Obiz\Challenges\CashMachine;

class CashDistributor
{

    /**
     *
     * @var array
     */
    private $availableBills = array(100, 50, 20, 10, 5, 2);

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
     * How much we want to withdraw from the cash distributor
     * @throws InvalidWithdrawException if the exact amount cannot be gathered with the available bills.
     * @return array Associative array representing the bills that should be distributed by the cash machine.
     */
    public function getMinimalAmountOfBills($withdrawAmount)
    {
        $oneBill = 0;
        while ($this->validateAmount($withdrawAmount, $oneBill) === true) {
            $oneBill = $this->GetOneBill($withdrawAmount);
            $this->addBill($oneBill);
            $withdrawAmount -= $oneBill;
        }

        if ($this->validateWithdraw() === false) {
            throw new InvalidWithdrawException('Sorry, the exact amount cannot be gathered.');
        }

        return $this->bills;
    }

    /**
     * Set the maximun amount of bills for a bill value
     *
     * @param int $value
     *
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

         return 2;
    }


    public function getBills($value, $bill)
    {
        return (int) floor($value / $bill);

    }


    public function validateAmount($billAmount, $leftOver)
    {
        if ($billAmount > 0 && $leftOver !== 3 && $leftOver !== 1) {
            return true;
        }

        return false;

    }


    public function addBill($bill)
    {
        if (isset($this->bills[$bill]) === false) {
            $this->bills[$bill] = 1;
        } else {
            $this->bills[$bill]++;
        }

    }


    public function validateWithdraw()
    {
        return (bool) count($this->bills);

    }

}
