<?php

class Account {
    private $balance;

    public function __construct($initialBalance) {
        $this->balance = $initialBalance;
    }

    public function getBalance() {
        return $this->balance;
    }

    public function deposit($amount) {
        if ($amount > 0) {
            $this->balance += $amount;
            echo "Deposited: $amount. New Balance: " . $this->getBalance() . "\n";
        } else {
            echo "Deposit amount must be positive.\n";
        }
    }

    public function withdraw($amount) {
        if ($amount > 0 && $amount <= $this->balance) {
            $this->balance -= $amount;
            echo "Withdrew: $amount. New Balance: " . $this->getBalance() . "\n";
        } else {
            echo "Withdrawal amount must be positive and less than or equal to the current balance.\n";
        }
    }
}

class Savings extends Account {
    private $balance;

    public function __construct($initialBalance) {
        parent::__construct($initialBalance);
    }
}

$account = new Account(100);
$account->deposit(100);
echo "Initial Balance: " . $account->getBalance() . "\n";
$account->withdraw(50);
echo "Final Balance: " . $account->getBalance() . "\n";

$savings = new Savings(1000);
echo "Savings Initial Balance: " . $savings->getBalance() . "\n";
$savings->deposit(100);
echo "Savings Balance after deposit: " . $savings->getBalance() . "\n";