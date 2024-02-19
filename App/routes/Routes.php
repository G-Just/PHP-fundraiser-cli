<?php

namespace App\routes;

use App\controllers\Charity;
use App\controllers\Donation;

include __DIR__ . '/../banner.php';

class Routes
{
    public static function run()
    {
        echo BANNER;
        echo " List of available actions :\n\n";
        echo " - List all charities......................[\033[1;33m" . 'list' . "\033[0m]\n\n";
        echo " - Create a new charity....................[\033[1;33m" . 'create' . "\033[0m]\n\n";
        echo " - Edit an existing charity................[\033[1;33m" . 'edit' . "\033[0m]\n\n";
        echo " - Delete a charity........................[\033[1;33m" . 'delete' . "\033[0m]\n\n";
        echo " - Add a donation to an existing charity...[\033[1;33m" . 'donate' . "\033[0m]\n\n";
        echo " - Exit....................................[\033[1;33m" . 'exit' . "\033[0m]\n\n";

        $selected = readline(" > Selection : ");

        return match ($selected) {
            'list' => (new Charity)->list(),
            'create' => (new Charity)->create(),
            'edit' => (new Charity)->edit(),
            'delete' => (new Charity)->delete(),
            'donate' => (new Donation)->donate(),
            'exit' => die(),
            default => 'Action not recognized'
        };
    }
}
