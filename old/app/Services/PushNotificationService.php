<?php


namespace App\Services;


use Illuminate\Support\Facades\Log;

class PushNotificationService
{
    /**
     * Notification configuration.
     *
     * @var array
     */
    private $config;

    /**
     * Notification Url.
     *
     * @var string
     */
    private $apiUrl;

    private $status = 'sandbox';

    /**
     * NotificationService constructor.
     */
    public function __construct()
    {
        $this->config = config('notification');
        if ($this->config['mode'] === 'sandbox') {
            $this->apiUrl = 'https://fcm.googleapis.com/fcm/send';
            $this->status = 'sandbox';

        } else {
            $this->apiUrl = 'https://fcm.googleapis.com/fcm/send';
            $this->status = 'live';
        }
    }

    /**
     * @param $fields
     * @return bool
     */
    private function sendNotification($fields)
    {
        $headers = array(
            'Authorization: key=' . $this->config[$this->status]['server_key'],
            'Content-Type: application/json'
        );
        // Open connection
        $ch = curl_init();

        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $this->apiUrl);

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Disabling SSL Certificate support temporarily
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // return json_encode($fields);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

        // Execute post
        $result = curl_exec($ch);
        if ($result === FALSE) {
            \Log::error('FCM Send Error: ' . curl_error($ch));
            return false;
        }

        // Close connection
        curl_close($ch);
        return true;
    }

    /**
     * @param $title
     * @param $body
     * @return bool
     */
    public function sendGeneralNotification($title, $body)
    {
        $msg = array
        (
            'body' => $body,
            'title' => $title,
            'pushType' => "GENERAL"
        );
        $newarray['message'] = $msg;
        $fields = array(
            'to' => "/topics/" . $this->config[$this->status]['topic_name_android'],
            'priority' => "high",
            'data' => $msg,
        );

        \Log::info('General Notification request: <br>' . json_encode($fields));
        // Open connection
        return $this->sendNotification($fields);
    }

    /**
     * @param $title
     * @param $body
     * @return bool
     */
    public function sendGeneralNotificationForIOS($title, $body)
    {
        $msg = array
        (
            'body' => $body,
            'title' => $title,
            'sound' => 'notificationCupcake.caf',
            'pushType' => "GENERAL"
        );
        $newarray['message'] = $msg;
        $fields = array(
            'to' => "/topics/" . $this->config[$this->status]['topic_name_ios'],
            'priority' => "high",
            'mutable_content' => true,
            'notification' => $msg,
        );

        \Log::info('General Notification request: <br>' . json_encode($fields));
        // Open connection
        return $this->sendNotification($fields);
    }

    /**
     * @param $gcm_id
     * @param $title
     * @param $body
     * @return bool
     */
    public function sendSpecificNotification($gcm_id, $title, $body)
    {
        $msg = array
        (
            'body' => $body,
            'title' => $title,
            'pushType' => "GENERAL"
        );
        $newarray['message'] = $msg;
        $fields = array(
            'to' => $gcm_id,
            'priority' => "high",
            'data' => $msg,
        );
        \Log::info('Specific Notification request: <br>' . json_encode($fields));

        // Open connection
        return $this->sendNotification($fields);
    }

    /**
     * @param $gcm_id
     * @param $title
     * @param $body
     * @return bool
     */
    public function sendSpecificNotificationForIOS($gcm_id, $title, $body)
    {
        $msg = array
        (
            'body' => $body,
            'title' => $title,
            'sound' => 'notificationCupcake.caf',
            'pushType' => "GENERAL"
        );
        $newarray['message'] = $msg;
        $fields = array(
            'to' => $gcm_id,
            'priority' => "high",
            'mutable_content' => true,
            'notification' => $msg,
        );
        \Log::info('Specific Notification request: <br>' . json_encode($fields));

        // Open connection
        return $this->sendNotification($fields);
    }

    /**
     * @param $gcm_id
     * @param array $options
     * @return bool
     */
    public function sendAutoNotification($gcm_id, array $options = []): bool
    {
        $msg = [
            'body' => $options['body'] ?? '',
            'title' => $options['title'] ?? '',
            'type' => $options['type'] ?? 'general',
            'image' => $options['image'] ?? '/assets/svg/bell.svg',
            'id' => $options['id'] ?? 0, //tarikul vai ref
            'extra' => $options['extra'] ?? [],
            'time' => $options['time'] ?? date('Y-m-d H:i:s')
        ];

        $fields = array(
            'to' => $gcm_id,
            'priority' => "high",
            'data' => $msg,
        );
        \Log::info('Auto Notification request: <br>' . json_encode($fields));
        // Open connection
        return $this->sendNotification($fields);
    }

    /**
     * @param $gcm_id
     * @param array $options
     * @return bool
     */
    public function sendAutoNotificationForIOS($gcm_id, array $options = []): bool
    {
        $msg = [
            'body' => $options['body'] ?? '',
            'title' => $options['title'] ?? '',
            'type' => $options['type'] ?? 'general',
            'image' => $options['image'] ?? '/assets/svg/bell.svg',
            'id' => $options['id'] ?? 0, //tarikul vai ref
            'extra' => $options['extra'] ?? [],
            'time' => $options['time'] ?? date('Y-m-d H:i:s')
        ];

        $fields = array(
            'to' => $gcm_id,
            'priority' => "high",
            'mutable_content' => true,
            'notification' => $msg,
        );

        \Log::info('Auto Notification request: <br>' . json_encode($fields));
        // Open connection
        return $this->sendNotification($fields);
    }
}
