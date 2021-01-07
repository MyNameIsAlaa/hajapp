<?php

class  Input
{
    static $errors = true;

    static function check($arr, $on = false)
    {
        $errors = [];
        if ($on === false) {
            $on = $_REQUEST;
        }
        foreach ($arr as $value) {
            if (empty($on[$value])) {
                array_push($errors, $value . " is required");
            }
        }
        return $errors;
    }

    static function email($val)
    {
        $errors = [];
        $val = filter_var($val, FILTER_VALIDATE_EMAIL);
        if ($val === false) {
            array_push($errors, 'Invalid E-mail');
        }
        return $errors;
    }

    static function url($val)
    {
        $errors = [];
        $val = filter_var($val, FILTER_VALIDATE_URL);
        if ($val === false) {
            array_push($errors, 'Invalid URL');
        }
        return $errors;
    }
}
