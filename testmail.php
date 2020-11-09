<?php

        
        $mail_body = "<p>salut tous le monde just eteseyt.</p>";
        $subject = "Confirmation Mail";
        $email = "ldwpfe2020@gmail.com";
        $header = 'From: Support@sgdsz.com' . "\r\n" .
            'MIME-Version: 1.0' . "\r\n" .
            'Content-type: text/html; charset=utf-8';
        if (mail($email, $subject, $mail_body, $header))
            echo "mail sended";
        else
            echo "Error";
