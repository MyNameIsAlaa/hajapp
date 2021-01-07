<?php

class Misc
{

    public function Generate_Password($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function SendMail($to, $from, $subject, $message)
    {
        $headers = "From: " + $from;
        return mail($to, $subject, $message, $headers);
    }
}
