<?php
if (mail('sirine.mzabi2000@gmail.com', 'Test mail', 'Ceci est un test.')) {
    echo "Mail envoyé";
} else {
    echo "Erreur envoi mail";
}
?>
