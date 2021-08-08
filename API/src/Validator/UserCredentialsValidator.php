<?php

namespace App\Validator;

function email_validation($email) {

    if($email == null) {
        return false;
    }

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return false;
    }

    return true;
}

function password_validation($password) {
    $uppercase = preg_match('/[a-z]+/', $password);
    $lowercase = preg_match('/[A-Z]+/', $password);
    $number    = preg_match('/\d+/', $password);
    $length = strlen($password) >= 8;

    if($uppercase && $lowercase && $number && $length) {
        return true;
    }

    return false;
}

function validate($email, $password) {
    return email_validation($email) && password_validation($password);
}