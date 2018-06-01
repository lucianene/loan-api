<?php

namespace LoanApi;

use LoanApi\Core\DependencyInjection\ContainerTrait;
use LoanApi\Core\DependencyInjection\Contracts\Locatable;

class Amortization implements Locatable
{
    use ContainerTrait;

    protected $amount;
    protected $interestRate;
    protected $months;
    protected $date;

    /**
     * The container handler
     *
     * @param float $amount
     * @param float $interestRate
     * @param int   $months
     * @param date  $date Y-m-d format
     */
    public function handle($amount, $interestRate, $months, $date)
    {
        $this->amount = $amount;
        $this->interestRate = $interestRate;
        $this->months = $months;
        $this->date = $date;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function getInterestRate()
    {
        return $this->interestRate;
    }

    public function getMonths()
    {
        return $this->months;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function getEndDate()
    {
        return date('Y-m-d', strtotime('+' . $this->months . ' months', strtotime($this->date)));
    }
}
