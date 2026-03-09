<?php
trait Logger {
    public function log($message) {
        echo "Log: $message\n";
    }
}

trait Timestamp {
    public function getCurrentTimestamp() {
        return date('Y-m-d H:i:s');
    }
}

class User {
    use Logger;
    use Timestamp;
}

$user = new User();
$user->log("User created successfully.");
echo "Current Timestamp: " . $user->getCurrentTimestamp() . "\n";