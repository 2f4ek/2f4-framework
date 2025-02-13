<?php

require 'vendor/autoload.php';

use Framework2f4\Database\Database;

try {
    $db = Database::getInstance();
    $migrationFiles = glob(__DIR__ . '/../migrations/*.sql');

    foreach ($migrationFiles as $file) {
        $query = file_get_contents($file);
        $db->exec($query);
    }

    echo "Migration completed successfully.\n";
} catch (PDOException $e) {
    echo "Migration failed: " . $e->getMessage() . "\n";
}