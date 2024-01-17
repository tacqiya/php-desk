<?php

declare(strict_types=1);

require 'vendor/autoload.php';

use \SendGrid\Mail\Mail;

$email = new Mail();
// Replace the email address and name with your verified sender
$email->setFrom(
    'sender@example.com',
    'Example Sender'
);
$email->setSubject('Sending with Twilio SendGrid is Fun');
// Replace the email address and name with your recipient
$email->addTo(
    'recipient@example.com',
    'Example Recipient'
);
$email->addContent(
    'text/html',
    '<strong>and fast with the PHP helper library.</strong>'
);
$sendgrid = new \SendGrid(getenv('SENDGRID_API_KEY'));
try {
    $response = $sendgrid->send($email);
    printf("Response status: %d\n\n", $response->statusCode());

    $headers = array_filter($response->headers());
    echo "Response Headers\n\n";
    foreach ($headers as $header) {
        echo '- ' . $header . "\n";
    }
} catch (Exception $e) {
    echo 'Caught exception: '. $e->getMessage() ."\n";
}
