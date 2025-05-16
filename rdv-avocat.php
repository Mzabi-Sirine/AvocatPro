<?php
// Affichage des erreurs (à enlever en production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

// Vérifier que l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); 
    exit();
}

try {
    // Connexion à la base SQLite
    $pdo = new PDO('sqlite:./database/rdv.sqlite');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Création de la table rdv si elle n'existe pas
    $createTableSQL = "
        CREATE TABLE IF NOT EXISTS rdv (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            user_id INTEGER NOT NULL,
            type_rdv TEXT NOT NULL,
            observation TEXT NOT NULL,
            date_demande TEXT NOT NULL
        )
    ";
    $pdo->exec($createTableSQL);

} catch (Exception $e) {
    die("Erreur base de données : " . $e->getMessage());
}

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $observation = trim($_POST['observation'] ?? '');

    if (empty($observation)) {
        $error = "Veuillez saisir une observation ou message.";
    } else {
        $type_rdv = "Avocat";

        try {
            $stmt = $pdo->prepare("INSERT INTO rdv (user_id, type_rdv, observation, date_demande) VALUES (?, ?, ?, datetime('now'))");
            $stmt->execute([$_SESSION['user_id'], $type_rdv, $observation]);
            $success = "Rendez-vous pris avec succès !";
        } catch (Exception $e) {
            $error = "Erreur lors de l'insertion en base : " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title>Prendre rendez-vous avocat</title>
    <style>
        body {
            margin: 0;
            background-color: #f9fafb;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        main {
            background: white;
            padding: 30px 40px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 500px;
        }
        h1 {
            color: #002b55;
            margin-bottom: 25px;
            text-align: center;
        }
        form label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #002b55;
        }
        textarea {
            width: 100%;
            min-height: 120px;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 1rem;
            resize: vertical;
        }
        button {
            margin-top: 20px;
            background-color: #002b55;
            color: white;
            border: none;
            padding: 12px 20px;
            font-size: 1.1rem;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #004080;
        }
        .message {
            margin-bottom: 15px;
            padding: 12px 15px;
            border-radius: 6px;
            font-weight: 600;
            text-align: center;
        }
        .success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        p.back-link {
            text-align: center;
            margin-top: 25px;
        }
        p.back-link a {
            color: #002b55;
            text-decoration: none;
            font-weight: 600;
        }
        p.back-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<main>
    <h1>Prendre rendez-vous chez l'avocat</h1>

    <?php if ($success): ?>
        <div class="message success"><?= htmlspecialchars($success) ?></div>
    <?php elseif ($error): ?>
        <div class="message error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="post" action="">
        <label for="observation">Observation ou message :</label>
        <textarea name="observation" id="observation" required><?= isset($_POST['observation']) ? htmlspecialchars($_POST['observation']) : '' ?></textarea>

        <button type="submit">Envoyer la demande</button>
    </form>

    <p class="back-link"><a href="compte.php">← Retour à mon compte</a></p>
</main>
</body>
</html>















