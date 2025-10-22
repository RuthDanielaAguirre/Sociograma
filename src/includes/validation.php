<?php
function validate_required(string $value): bool {
    return trim($value) !== '';
}

function validate_email(string $email): bool {
    if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
        return false;
    }
    return true;
}

function validate_length(string $value, int $min, int $max): bool {
    $length = strlen(trim($value));
    return $length >= $min && $length <= $max;
}

function validate_range(int $value, int $min, int $max): bool {
    return $value >= $min && $value <= $max;
}

function validate_enum(string $value, array $valid_options): bool {
    if (in_array($value, $valid_options) == false) {
        return false;
    }
    return true;
}

function validate_date(string $date): bool{
    $dt = DateTime::createFromFormat("Y-m-d", $date);
    if($dt === false){
        return false;
    }
    return true;
}