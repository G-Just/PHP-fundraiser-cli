<?php

namespace App\controllers;

use App\database\DataBase;
use App\services\Display;
use App\services\Validation;

class Donation
{
    /**
     * Creates a new donation and assigns it to the charity.
     */
    public function donate(): void
    {
        Display::out('New donation');
        $name = Display::in('Donor Name');
        $amount = Display::in('Amount (in USD)');
        if (!Validation::amount($amount)) {
            Display::out('Invalid amount entered');
            die();
        }
        Display::out("Charity (type list to display charity list)[\033[1;33m" . "list" . "\033[0m] :");
        $charity = Display::in('Charity ID');
        if ($charity === 'list') {
            (new Charity)->list();
            $charity = Display::in('Charity ID');
        }
        (new DataBase('donations'))->createDonation($name, $amount, $charity);
    }
}
