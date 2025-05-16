<?php
session_start();
try {
    $pdo = new PDO('sqlite:./database/rdv.sqlite');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die("Erreur DB : " . $e->getMessage());
}

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $telephone = trim($_POST['telephone'] ?? '');
    $password = $_POST['password'] ?? '';
    $password_confirm = $_POST['password_confirm'] ?? '';

    // Validation simple
    if (!$nom || !$email || !$password || !$password_confirm) {
        $errors[] = "Tous les champs obligatoires doivent être remplis.";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Email invalide.";
    }
    if ($password !== $password_confirm) {
        $errors[] = "Les mots de passe ne correspondent pas.";
    }

    // Vérifier si email existe déjà
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->fetch()) {
        $errors[] = "Cet email est déjà utilisé.";
    }

    // Insérer si pas d’erreur
    if (empty($errors)) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO users (nom, email, telephone, password) VALUES (?, ?, ?, ?)");
        $stmt->execute([$nom, $email, $telephone, $hash]);
        $_SESSION['user_id'] = $pdo->lastInsertId();
        header('Location: compte.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head><meta charset="UTF-8"><title>Inscription</title></head>
<body>
<h1>Inscription</h1>

<?php if ($errors): ?>
    <ul style="color:red;">
        <?php foreach($errors as $e): ?><li><?= htmlspecialchars($e) ?></li><?php endforeach; ?>
    </ul>
<?php endif; ?>

<form method="post" action="">
    <label>Nom complet* : <input type="text" name="nom" required></label><br>
    <label>Email* : <input type="email" name="email" required></label><br>
    <label>Téléphone : <input type="text" name="telephone"></label><br>
    <label>Mot de passe* : <input type="password" name="password" required></label><br>
    <label>Confirmer mot de passe* : <input type="password" name="password_confirm" required></label><br>
    <button type="submit">S'inscrire</button>
</form>

<a href="login.php">Déjà inscrit ? Se connecter</a>

</body>
</html>

