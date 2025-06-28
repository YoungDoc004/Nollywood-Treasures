<?php
$secretKey = "sk_live_635f0eda8e6987b1d38a2c5af9d07fb9c8e56c6f";
$input = @file_get_contents("php://input");
$event = json_decode($input);

if (isset($event->reference)) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://api.paystack.co/transaction/verify/' . $event->reference);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Bearer $secretKey"
    ]);
    $result = curl_exec($ch);
    curl_close($ch);
    $resultData = json_decode($result, true);

    if ($resultData['data']['status'] == 'success') {
        $firstName = $event->firstName;
        $lastName = $event->lastName;
        $email = $event->email;
        $amountPaid = $resultData['data']['amount'] / 100;

        $to = "emmanuelojide97@gmail.com";
        $subject = "New Payment Received";
        $message = "Payment of ₦$amountPaid was made by $firstName $lastName ($email).";
        $headers = "From: no-reply@nollytvacademy.com";

        if (mail($to, $subject, $message, $headers)) {
            http_response_code(200);
            echo json_encode(["status" => "success", "message" => "Email sent successfully."]);
        } else {
            http_response_code(500);
            echo json_encode(["status" => "error", "message" => "Failed to send email."]);
        }
    } else {
        http_response_code(400);
        echo json_encode(["status" => "error", "message" => "Transaction verification failed."]);
    }
} else {
    http_response_code(400);
    echo json_encode(["status" => "error", "message" => "Invalid request."]);
}
?>