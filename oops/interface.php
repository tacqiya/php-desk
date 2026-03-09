<!-- 
| Feature              | Interface                | Abstract Class                         |
| -------------------- | ------------------------ | -------------------------------------- |
| Methods              | Only declarations        | Can have both abstract and implemented |
| Properties           | No properties            | Can have properties                    |
| Access Modifiers     | Public only              | Public, protected, private             |
| Multiple inheritance | Can implement multiple   | Can extend only one                    |
| Purpose              | Define behavior contract | Provide base functionality             | -->


<?php
// An Interface defines a contract.
// Any class that implements the interface must implement all its methods.

// Key Characteristics
// Contains only method declarations (no method bodies).
// Methods are public by default.
// Can also contain constants.
// A class can implement multiple interfaces.

// Use Interface → when you want to enforce what a class must do

interface PaymentGateway {
    public function processPayment($amount);
}

interface Refundable {
    public function processRefund($amount);
}

class Paypal implements PaymentGateway, Refundable {
    public function processPayment($amount) {
        echo "Processing payment of $amount through PayPal.\n";
    }

    public function processRefund($amount) {
        echo "Processing refund of $amount through PayPal.\n";
    }
}

class Stripe implements PaymentGateway {
    public function processPayment($amount) {
        echo "Processing payment of $amount through Stripe.\n";
    }
}

$paypal = new Paypal();
$paypal->processPayment(100);
$paypal->processRefund(50);
$stripe = new Stripe();
$stripe->processPayment(200);