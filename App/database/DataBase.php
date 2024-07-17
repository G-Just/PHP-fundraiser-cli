<?php

namespace App\database;

use App\services\Display;
use PDO;

class DataBase
{
    private $dsn = "mysql:host=localhost;dbname=php_cli;charset=utf8mb4";

    private $pdo;
    private $table;

    public function __construct(string $table)
    {
        $this->createDatabase();
        $this->pdo = new PDO($this->dsn, 'root');
        $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        $this->table = $table;
        $this->createTables();
    }
    /**
     * Checks if database exists and creates on if not.
     */
    private function createDatabase(): void
    {
        $pdo = new PDO("mysql:host=localhost", 'root');
        $pdo->exec("CREATE DATABASE IF NOT EXISTS php_cli;");
    }

    /**
     * Checks if tables exist and creates them in the database if not.
     */
    private function createTables(): void
    {
        $charityColumns = "id INT( 11 ) UNSIGNED AUTO_INCREMENT PRIMARY KEY, name VARCHAR( 128 ) NOT NULL, email VARCHAR( 128 ) NOT NULL";
        $donationColumns = "id INT( 11 ) AUTO_INCREMENT PRIMARY KEY, donorName VARCHAR( 128 ) NOT NULL, donationAmount decimal( 10,0 ) NOT NULL, charity_id INT( 11 ) UNSIGNED, FOREIGN KEY (charity_id) REFERENCES charities(id) ON DELETE cascade, timestamp datetime DEFAULT current_timestamp()";
        $this->pdo->exec("CREATE TABLE IF NOT EXISTS `charities` ($charityColumns)");
        $this->pdo->exec("CREATE TABLE IF NOT EXISTS `donations` ($donationColumns)");
    }

    /**
     * Returns a list of all the charity objects.
     */
    public function all(): array
    {
        if ($this->table === 'charities') {
            $sql = "SELECT c.id, c.name, c.email, IFNULL(SUM(d.donationAmount), 0) as totalDonationsCollected, COUNT(d.donationAmount) as donationCount
            FROM charities as c
            LEFT JOIN donations as d
            ON c.id = d.charity_id
            GROUP BY c.id";
        } else {
            $sql = "SELECT * FROM $this->table";
        }
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Returns a charity object selected by ID.
     */
    public function get(int $id): object
    {
        $sql = "SELECT * FROM $this->table WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    /**
     * Edits a charity entry selected by ID.
     */
    public function edit(int $id, string $name, string $email): void
    {
        $sql = "UPDATE $this->table SET name = ?, email = ? WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$name, $email, $id]);
        Display::out('Update successful');
    }

    /**
     * Creates a charity entry.
     */
    public function create(string $name, string $email): void
    {
        $sql = "INSERT INTO $this->table (name, email) VALUES (?, ?)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$name, $email]);
        Display::out('Charity entry created successfully');
    }

    /**
     * Creates a donation entry.
     */
    public function createDonation(string $name, string $amount, int $id): void
    {
        $sql = "INSERT INTO $this->table (donorName, donationAmount, charity_id) VALUES (?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$name, $amount, $id]);
        Display::out('Donation entry created successfully');
    }

    /**
     * Deletes a charity entry selected by ID.
     */
    public function delete(int $id): void
    {
        $sql = "DELETE FROM $this->table WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        Display::out('Deleted successfully');
    }
}
