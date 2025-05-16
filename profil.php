
<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$mysqli = new mysqli("localhost", "root", "", "votre_base_de_donnees");
if ($mysqli->connect_errno) {
    die("Erreur DB : " . $mysqli->connect_error);
}

// Récupérer les infos actuelles
$stmt = $mysqli->prepare("SELECT nom, email, telephone FROM users WHERE id = ?");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Mise à jour du profil
$success = $error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST['nom'] ?? '';
    $email = $_POST['email'] ?? '';
    $telephone = $_POST['telephone'] ?? '';

    $stmt = $mysqli->prepare("UPDATE users SET nom = ?, email = ?, telephone = ? WHERE id = ?");
    $stmt->bind_param("sssi", $nom, $email, $telephone, $_SESSION['user_id']);
    if ($stmt->execute()) {
        $success = "Profil mis à jour avec succès.";
        // Mettre à jour les infos locales
        $user['nom'] = $nom;
        $user['email'] = $email;
        $user['telephone'] = $telephone;
<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

try {
    $pdo = new PDO('sqlite:./database/rdv.sqlite');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die("Erreur DB : " . $e->getMessage());
}

// Traitement du formulaire
$success = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'] ?? '';
    $email = $_POST['email'] ?? '';
    $telephone = $_POST['telephone'] ?? '';

    $stmt = $pdo->prepare("UPDATE users SET nom = ?, email = ?, telephone = ? WHERE id = ?");
    $stmt->execute([$nom, $email, $telephone, $_SESSION['user_id']]);
    $success = "✅ Informations mises à jour avec succès.";
}

// Récupérer les infos de l'utilisateur
$stmt = $pdo->prepare("SELECT nom, email, telephone FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier mon profil</title>
</head>
<body>
    <h1>Modifier mes informations</h1>

    <?php if ($success): ?>
        <p style="color: green"><?= $success ?></p>
    <?php endif; ?>

    <form method="post">
        <label>Nom :<br>
            <input type="text" name="nom" value="<?= htmlspecialchars($user['nom']) ?>" required>
        </label><br><br>

        <label>Email :<br>
            <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
        </label><br><br>

        <label>Téléphone :<br>
            <input type="text" name="telephone" value="<?= htmlspecialchars($user['telephone']) ?>" required>
        </label><br><br>

        <button type="submit">💾 Enregistrer</button>
    </form>

    <p><a href="compte-rdv.php">← Retour à mon compte</a></p>
</body>
</html>
