<?php
try {
    $pdo = new PDO('sqlite:./database/rdv.sqlite');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Table utilisateurs
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS users (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            nom TEXT NOT NULL,
            email TEXT UNIQUE NOT NULL,
            telephone TEXT,
            password TEXT NOT NULL
        )
    ");

    // Table rendez-vous
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS rdv (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            user_id INTEGER NOT NULL,
            type_rdv TEXT NOT NULL,
            observation TEXT,
            date_reservation DATETIME DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY(user_id) REFERENCES users(id)
        )
    ");

    echo "Base et tables créées avec succès.";
} catch (Exception $e) {
    die("Erreur lors de la création de la base : " . $e->getMessage());
}
