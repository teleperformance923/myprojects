<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capture and sanitize form inputs
    $name = htmlspecialchars(trim($_POST['name']));
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $message = htmlspecialchars(trim($_POST['message']));
    $phone = isset($_POST['phone']) ? htmlspecialchars(trim($_POST['phone'])) : 'Not provided';
    $subject = isset($_POST['subject']) ? htmlspecialchars(trim($_POST['subject'])) : 'No subject';

    // Validate required fields
    if (empty($name) || empty($email) || empty($message)) {
        echo "Please fill in all required fields.";
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Please enter a valid email address.";
        exit;
    }

    // Email configuration
    $to = "your-email@example.com"; // Replace with your email address
    $email_subject = "New Contact Form Submission: $subject";
    $email_body = "
        You have received a new message from your website contact form.\n\n
        Name: $name\n
        Email: $email\n
        Phone: $phone\n
        Subject: $subject\n
        Message:\n$message
    ";

    $headers = "From: $email\r\n";
    $headers .= "Reply-To: $email\r\n";

    // Send email
    if (mail($to, $email_subject, $email_body, $headers)) {
        echo "Thank you, $name! Your message has been sent.";
    } else {
        echo "Sorry, there was an error sending your message. Please try again later.";
    }
} else {
    echo "Invalid request.";
}
?>
