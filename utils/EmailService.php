<?php

namespace Utils;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Config\Config;

class EmailSender
{
    private $mailer;

    public function __construct()
    {
        $this->mailer = new PHPMailer(true);

        // SMTP Configuration
        $this->mailer->isSMTP();
        $this->mailer->Host = Config::getSmtpServer(); // Replace with your SMTP server
        $this->mailer->SMTPAuth = true;
        $this->mailer->Username = Config::getSmtpUsername(); // SMTP username
        $this->mailer->Password = Config::getSmtpPassword(); // SMTP password
        $this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $this->mailer->Port = Config::getSmtpPort(); // SMTP port
    }

    public function sendEmail($to, $subject, $body)
    {
        try {
            $this->mailer->setFrom(Config::getSmtpFromAddress(), Config::getSmtpFromName());
            $this->mailer->addAddress($to);
            $this->mailer->Subject = $subject;
            $this->mailer->Body = $body;
            $this->mailer->isHTML(true);

            $this->mailer->send();
            return "Email sent successfully!";
        } catch (Exception $e) {
            return "Email could not be sent. Error: {$this->mailer->ErrorInfo}";
        }
    }
}
