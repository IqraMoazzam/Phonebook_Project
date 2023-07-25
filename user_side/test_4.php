<?php
// Set your ElasticEmail API key
$apiKey = '3F02346C2621CF5F57519E71141102EE73647057B738186CE76CBDE080325CFBA7BF8CDCC116D54A38E7875D8C6A2364';

// API endpoint for sending emails
$url = 'https://api.elasticemail.com/v2/email/send';

// Email parameters
$from = 'iqramoazzam22@gmail.com';
$to = 'ahmed.wwaallii@gmail.com';
$subject = 'Test Email';
$message = 'This is a test email sent from ElasticEmail using PHP cURL';

// Prepare the request data
$data = array(
    'apikey' => $apiKey,
    'from' => $from,
    'to' => $to,
    'subject' => $subject,
    'body' => $message,
    'isTransactional' => true, // Set to true for transactional emails
);

// Initialize cURL session
$ch = curl_init($url);

// Set cURL options
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Execute the cURL request
$response = curl_exec($ch);

// Check for cURL errors
if (curl_errno($ch)) {
    echo 'cURL Error: ' . curl_error($ch);
}

// Close cURL session
curl_close($ch);

// Process the response
$responseData = json_decode($response, true);

// Check the response status
if ($responseData['success']) {
    echo 'Email sent successfully!';
} else {
    echo 'Failed to send the email. Error: ' . $responseData['error'];
}
?>
*************************************
<?php
function sendEmail($to){
// Set your ElasticEmail API key
$apiKey = '3F02346C2621CF5F57519E71141102EE73647057B738186CE76CBDE080325CFBA7BF8CDCC116D54A38E7875D8C6A2364';

// API endpoint for sending emails
$url = 'https://api.elasticemail.com/v2/email/send';

// Email parameters
$from = 'iqramoazzam22@gmail.com';
// $to = 'ahmed.wwaallii@gmail.com';
$subject = 'Test Email';
$message = 'This is a test email sent from ElasticEmail using PHP cURL';

// Prepare the request data
$data = array(
    'apikey' => $apiKey,
    'from' => $from,
    'to' => $to,
    'subject' => $subject,
    'body' => $message,
    'isTransactional' => true, // Set to true for transactional emails
);

// Initialize cURL session
$ch = curl_init($url);

// Set cURL options
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Execute the cURL request
$response = curl_exec($ch);

// Check for cURL errors
if (curl_errno($ch)) {
    echo 'cURL Error: ' . curl_error($ch);
}

// Close cURL session
curl_close($ch);

// Process the response
$responseData = json_decode($response, true);

// Check the response status
if ($responseData['success']) {
    echo 'Email sent successfully!';
} else {
    echo 'Failed to send the email. Error: ' . $responseData['error'];
}

}
?>