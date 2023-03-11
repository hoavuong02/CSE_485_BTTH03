<?php
require 'vendor/autoload.php';
    interface EmailServerInterface {
        public function sendEmail($to, $subject, $message);
    }
?>

