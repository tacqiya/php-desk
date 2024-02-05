<?php
class DigitalWallet {
    private $balance;

    public function __construct($initialBalance) {
        if ($initialBalance < 0) {
            throw new Exception("Initial balance cannot be negative.");
        }
        $this->balance = $initialBalance;
    }

    public function getBalance() {
        return $this->balance;
    }

    public function deposit($amount) {
        if ($amount <= 0) {
            throw new Exception("Deposit amount must be positive.");
        }
        $this->balance += $amount;
    }

    public function withdraw($amount) {
        if ($amount <= 0) {
            throw new Exception("Withdrawal amount must be positive.");
        }
        if ($amount > $this->balance) {
            throw new Exception("Insufficient balance.");
        }
        $this->balance -= $amount;
    }

    public function transfer($recipient, $amount) {
        if ($amount <= 0) {
            throw new Exception("Transfer amount must be positive.");
        }
        if ($amount > $this->balance) {
            throw new Exception("Insufficient balance for the transfer.");
        }
        $this->balance -= $amount;
        $recipient->deposit($amount);
    }
}

// Example Usage:
try {
    $walletA = new DigitalWallet(100);
    $walletB = new DigitalWallet(50);

    $walletA->deposit(30);
    $walletB->withdraw(20);

    echo "Wallet A Balance: " . $walletA->getBalance() . "<br>";
    echo "Wallet B Balance: " . $walletB->getBalance() . "<br>";

    $walletA->transfer($walletB, 25);

    echo "Wallet A Balance after transfer: " . $walletA->getBalance() . "<br>";
    echo "Wallet B Balance after transfer: " . $walletB->getBalance() . "<br>";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
