<?php
session_start();

// Connexion  MySQLi
$host = 'localhost';
$user = 'root'; // ou ton utilisateur MySQL
$password = ''; // ton mot de passe
$dbname = 'test';

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Erreur DB : " . $conn->connect_error);
}

$error = '';
$success = '';
$rdv_confirm = false;
$date_rdv = '';
$heure_rdv = '';
$obs = '';

// Inscription
if (isset($_POST['action']) && $_POST['action'] == 'register') {
    $new_id = trim($_POST['new_anef_id']);
    $new_pass = password_hash($_POST['new_anef_pass'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("SELECT id FROM users WHERE anef_id = ?");
    $stmt->bind_param("s", $new_id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $error = "Identifiant déjà utilisé.";
    } else {
        $stmt = $conn->prepare("INSERT INTO users (anef_id, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $new_id, $new_pass);
        if ($stmt->execute()) {
            $success = "Compte créé avec succès. Vous pouvez maintenant vous connecter.";
        } else {
            $error = "Erreur lors de la création du compte.";
        }
    }
    $stmt->close();
}

// Connexion
if (isset($_POST['action']) && $_POST['action'] == 'login') {
    $anef_id = trim($_POST['anef_id']);
    $anef_pass = $_POST['anef_pass'];

    $stmt = $conn->prepare("SELECT password FROM users WHERE anef_id = ?");
    $stmt->bind_param("s", $anef_id);
    $stmt->execute();
    $stmt->bind_result($hashed_pass);
    if ($stmt->fetch() && password_verify($anef_pass, $hashed_pass)) {
        $_SESSION['user'] = $anef_id;
        header("Location: rdv-pref.php#rdv");
        exit;
    } else {
        $error = "Identifiant ou mot de passe incorrect.";
    }
    $stmt->close();
}

// Déconnexion
if (isset($_GET['action']) && $_GET['action'] == 'logout') {
    session_destroy();
    header("Location: rdv-pref.php");
    exit;
}

// Traitement du RDV
if (isset($_POST['action']) && $_POST['action'] == 'rdv') {
    $date_rdv = $_POST['date_rdv'] ?? '';
    $heure_rdv = $_POST['heure_rdv'] ?? '';
    $obs = $_POST['obs'] ?? '';
    $rdv_confirm = true;

    // Récupérer user_id à partir de l'anef_id
    $stmt = $conn->prepare("SELECT id FROM users WHERE anef_id = ?");
    $stmt->bind_param("s", $_SESSION['user']);
    $stmt->execute();
    $stmt->bind_result($user_id);
    $stmt->fetch();
    $stmt->close();

    // Format date et heure pour champ datetime
    $datetime = date('Y-m-d H:i:s', strtotime("$date_rdv $heure_rdv"));
    $type_rdv = 'Préfecture'; // ou un autre type si besoin

    // Insertion du RDV
    $stmt = $conn->prepare("INSERT INTO rdv (user_id, type_rdv, observation, date_reservation) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $user_id, $type_rdv, $obs, $datetime);
    $stmt->execute();
    $stmt->close();
}

?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>RDV Préfecture - Espace ANEF</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f1f3f6;
            padding: 30px;
        }

        h2, h3 {
            color: #2c3e50;
        }

        .container {
            background: #fff;
            padding: 25px;
            max-width: 700px;
            margin: auto;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        label {
            font-weight: bold;
        }

        input[type="text"],
        input[type="password"],
        input[type="date"],
        input[type="time"],
        textarea {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        input[type="submit"] {
            background-color: #2980b9;
            color: white;
            padding: 10px 18px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #1c5980;
        }

        .success { color: green; }
        .error { color: red; }

        .logout {
            float: right;
            font-size: 14px;
        }

        .info-box {
            background-color: #dff9fb;
            padding: 10px;
            border-left: 5px solid #2980b9;
            margin-bottom: 20px;
        }

        .confirmation-box {
            background-color: #e8f5e9;
            border-left: 6px solid #27ae60;
            padding: 15px;
            border-radius: 8px;
            margin-top: 20px;
            margin-bottom: 30px;
        }

        .confirmation-box h3 {
            color: #27ae60;
            margin-top: 0;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Objectif : Prendre un Rendez-vous en Préfecture</h2>
    <div class="info-box">
        Pour prendre un rendez-vous, veuillez d'abord créer un compte ou vous connecter avec vos identifiants ANEF.
    </div>

    <?php if (!empty($error)) : ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
    <?php if (!empty($success)) : ?>
        <p class="success"><?= htmlspecialchars($success) ?></p>
    <?php endif; ?>

    <?php if (!isset($_SESSION['user'])): ?>

        <!-- Connexion -->
        <h3>Connexion à votre compte ANEF</h3>
        <form method="post">
            <input type="hidden" name="action" value="login">
            <label>Identifiant ANEF :</label>
            <input type="text" name="anef_id" required>

            <label>Mot de passe ANEF :</label>
            <input type="password" name="anef_pass" required>

            <input type="submit" value="Se connecter">
        </form>

        <hr>

        <!-- Inscription -->
        <h3>Créer un nouveau compte ANEF</h3>
        <form method="post">
            <input type="hidden" name="action" value="register">
            <label>Identifiant souhaité :</label>
            <input type="text" name="new_anef_id" required>

            <label>Mot de passe :</label>
            <input type="password" name="new_anef_pass" required>

            <input type="submit" value="Créer le compte">
        </form>

    <?php else: ?>

        <p>Bienvenue <strong><?= htmlspecialchars($_SESSION['user']) ?></strong> !
            <a class="logout" href="rdv-pref.php?action=logout">Se déconnecter</a>
        </p>

        <?php if ($rdv_confirm): ?>
            <div class="confirmation-box">
                <h3>✅ Confirmation de votre RDV</h3>
                <p><strong>Identifiant ANEF :</strong> <?= htmlspecialchars($_SESSION['user']) ?></p>
                <p><strong>Date :</strong> <?= htmlspecialchars($date_rdv) ?></p>
                <p><strong>Heure :</strong> <?= htmlspecialchars($heure_rdv) ?></p>
                <p><strong>Observation :</strong> <?= nl2br(htmlspecialchars($obs)) ?: 'Aucune' ?></p>
            </div>
        <?php else: ?>
            <!-- Formulaire RDV -->
            <h3 id="rdv">Formulaire de prise de rendez-vous</h3>
            <form method="post">
                <input type="hidden" name="action" value="rdv">

                <label>Date souhaitée :</label>
                <input type="date" name="date_rdv" required>

                <label>Heure souhaitée :</label>
                <input type="time" name="heure_rdv" required>

                <label>Observation :</label>
                <textarea name="obs" rows="4"></textarea>

                <input type="submit" value="Envoyer la demande de RDV">
            </form>
        <?php endif; ?>

    <?php endif; ?>
</div>
</body>
</html>










