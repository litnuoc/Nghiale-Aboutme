<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ form
    $firstName = filter_var(trim($_POST["first-name"]), FILTER_SANITIZE_STRING);
    $lastName = filter_var(trim($_POST["last-name"]), FILTER_SANITIZE_STRING);
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $phone = filter_var(trim($_POST["phone"]), FILTER_SANITIZE_STRING);
    $message = filter_var(trim($_POST["message"]), FILTER_SANITIZE_STRING);

    // Kiểm tra dữ liệu bắt buộc
    if (empty($firstName) || empty($lastName) || empty($email)) {
        http_response_code(400);
        echo "Vui lòng điền đầy đủ các trường bắt buộc.";
        exit;
    }

    // Cấu hình người nhận và tiêu đề email
    $recipient = "nghiaktsg@gmail.com";
    $subject = "New Contact From $firstName $lastName";
    $email_content = "First Name: $firstName\n";
    $email_content .= "Last Name: $lastName\n";
    $email_content .= "Email: $email\n";
    if (!empty($phone)) {
        $email_content .= "Phone: $phone\n";
    }
    $email_content .= "\nMessage:\n$message\n";

    // Gửi email
    if (mail($recipient, $subject, $email_content)) {
        http_response_code(200);
        echo "Cảm ơn! Tin nhắn của bạn đã được gửi.";
    } else {
        http_response_code(500);
        echo "Đã có lỗi xảy ra, không thể gửi tin nhắn.";
    }
} else {
    http_response_code(403);
    echo "Có lỗi xảy ra, vui lòng thử lại.";
}
?>