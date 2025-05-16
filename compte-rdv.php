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

// Récupérer utilisateur
$stmt = $pdo->prepare("SELECT nom, email, telephone FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Récupérer ses RDV
$stmt2 = $pdo->prepare("SELECT * FROM rdv WHERE user_id = ? ORDER BY date_reservation DESC");
$stmt2->execute([$_SESSION['user_id']]);
$rdvs = $stmt2->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head><meta charset="UTF-8"><title>Mon compte</title></head>
<body>
<h1>Bienvenue, <?= htmlspecialchars($user['nom']) ?></h1>



<p>Email : <?= htmlspecialchars($user['email']) ?></p>
<p>Téléphone : <?= htmlspecialchars($user['telephone']) ?></p>

<h2>Mes rendez-vous</h2>
<?php if (empty($rdvs)): ?>
    <p>Vous n'avez pas encore pris de rendez-vous.</p>
<?php else: ?>
    <ul>
        <?php foreach($rdvs as $r): ?>
            <li>
                Type: <?= htmlspecialchars($r['type_rdv']) ?> -  
                Observation: <?= nl2br(htmlspecialchars($r['observation'])) ?> -  
                Date: <?= htmlspecialchars($r['date_reservation']) ?>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<p><a href="logout.php">Se déconnecter</a></p>
</body>
</html>
