<?php

namespace App\controllers;

use App\database\DataBase;
use App\services\Display;
use App\services\Table;
use App\services\Validation;

class Charity
{
    /**
     * Displays a list of all the charities.
     */
    public function list(): void
    {
        $charities = (new DataBase('charities'))->all();
        if ($charities) {
            Table::charityTable($charities);
        } else {
            Display::out('No data found');
        }
    }

    /**
     * Creates a new charity entry.
     */
    public function create(): void
    {
        Display::out('New charity :');
        $name = Display::in('Charity name');
        $email = Display::in('Charity email');
        if (Validation::email($email)) {
            (new DataBase('charities'))->create($name, $email);
        } else {
            Display::out('Invalid email address');
        }
    }

    /**
     * Edits a charity entry.
     */
    public function edit(): void
    {
        $this->list();
        $id = readline(" > ID of the charity you want to edit : ");
        $charity = (new DataBase('charities'))->get($id);
        Display::out('Current :');
        Display::out(' - Name: ' . $charity->name, 1);
        Display::out(' - Email: ' . $charity->email, 1);
        Display::out("Edit (leave empty to keep previous) :");
        $newName = Display::in('New name');
        $newEmail = Display::in('New email');
        $newName = $newName ? $newName : $charity->name;
        $newEmail = $newEmail ? $newEmail : $charity->email;
        if (Validation::email($newEmail)) {
            (new DataBase('charities'))->edit($charity->id, $newName, $newEmail);
        } else {
            Display::out('Invalid email address');
        }
    }

    /**
     * Deletes a charity entry.
     */
    public function delete(): void
    {
        $this->list();
        $id = Display::in('ID of the charity you want to delete');
        $charity = (new DataBase('charities'))->get($id);
        Display::out('Selected charity :', 1);
        Display::out(' - ID : ' . $charity->id, 1);
        Display::out(' - Name : ' . $charity->name, 1);
        Display::out(' - Email : ' . $charity->email, 1);
        Display::out("Are you sure : YES[\033[1;33m" . 'y' . "\033[0m] NO[\033[1;33m" . 'n' . "\033[0m]");
        $confirmation = Display::in('Selection');
        echo match ($confirmation) {
            'y' => (new DataBase('charities'))->delete($charity->id),
            'n' => Display::out('Canceled'),
            default => Display::out('Action not recognized')
        };
    }
}
