<?php

namespace App\services;

class Validation
{
    /**
     * Validates an email address and returns true or false.
     */
    public static function email(string $email): bool
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Validates a donation amount and returns true or false.
     */
    public static function amount(float $amount): bool
    {
        if ($amount <= 0) {
            return false;
        }
        return true;
    }
}
