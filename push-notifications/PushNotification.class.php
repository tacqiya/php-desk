class PushNotification {
    private $title;
    private $body;
    private $url;

    public function __construct($title, $body, $url) {
        $this->title = $title;
        $this->body = $body;
        $this->url = $url;
    }

    public function send() {
        // Replace this with your actual implementation using a push notification service
        // such as Firebase Cloud Messaging.
        // Here's a simplified example using curl to send a notification to FCM:
        
        $url = 'https://fcm.googleapis.com/v1/projects/your-project-id/messages:send';
        $fields = json_encode([
            'to' => '/topics/your-topic', // Replace with your target topic
            'notification' => [
                'title' => $this->title,
                'body' => $this->body
            ]
        ]);

        $headers = [
            'Authorization: key=YOUR_SERVER_KEY',
            'Content-Type: application/json'
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        $result = curl_exec($ch);
        curl_close($ch);

        if ($result === false) {
            die('Curl error: ' . curl_error($ch));
        }

        echo 'Notification sent successfully';
    }
}

// Example usage:
$notification = new PushNotification('New message!', 'You have a new message in your inbox', '/messages');
$notification->send();
