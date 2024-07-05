<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize form data
    $name = filter_var(trim($_POST['name']), FILTER_SANITIZE_STRING);
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $phone = filter_var(trim($_POST['phone']), FILTER_SANITIZE_STRING);
    $message = filter_var(trim($_POST['message']), FILTER_SANITIZE_STRING);

    // Validate form data
    $errors = [];

    if (empty($name)) {
        $errors[] = "Name is required.";
    }

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Valid email is required.";
    }

    if (empty($phone)) {
        $errors[] = "Phone number is required.";
    }

    if (empty($message)) {
        $errors[] = "Message is required.";
    }

    // Check if there are any errors
    if (count($errors) === 0) {
        // Recipient email address
        $to = "k.nirsia@gmail.com"; // Change this to your email address

        // Email subject
        $subject = "New Client Information Submission";

        // Email body
        $email_body = "You have received a new message from the client information form.\n\n".
                      "Name: $name\n".
                      "Email: $email\n".
                      "Phone: $phone\n".
                      "Message:\n$message";

        // Email headers
        $headers = "From: no-reply@example.com\r\n"; // You can change this to your desired From email address
        $headers .= "Reply-To: $email\r\n";

        // Send email
        if (mail($to, $subject, $email_body, $headers)) {
            $feedback = "Message sent successfully!";
        } else {
            $feedback = "Failed to send message.";
        }
    } else {
        // Concatenate all error messages into a single string
        $feedback = "The following errors occurred:\n" . implode("\n", $errors);
    }

    // Provide feedback to the user
    echo "<!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <title>Client Information Form</title>
    </head>
    <body>
        <h2>Client Information Form</h2>
        <p>$feedback</p>
        <a href='index.html'>Go back to the form</a>
    </body>
    </html>";
}
?>
