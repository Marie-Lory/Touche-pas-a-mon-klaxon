<?php
declare(strict_types=1);

/**
 * @var string $title   Titre de la page
 * @var string $content Contenu HTML injecté
 */

$currentUser = $_SESSION['user'] ?? null;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($title) ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link 
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
        rel="stylesheet"
    >
    <style>
        :root {
            --color-bg: #f1f8fc;
            --color-primary: #0074c7;
            --color-dark: #384050;
            --color-danger: #cd2c2e;
            --color-success: #82b864;
        }
        body {
            background-color: var(--color-bg);
        }
        header {
            background-color: var(--color-primary);
            color: white;
        }
        footer {
            color: black;
            text-align: center;
            padding: 10px;
        }
        .btn-black {
            background-color: black;
            color: white;
        }
        .btn-black:hover {
            background-color: #333;
        }
    </style>
</head>
<body>
    <header class="d-flex justify-content-between align-items-center p-3">
        <h3 class="m-0">
            <a href="/" class="text-white text-decoration-none">🚗 Touche pas au klaxon</a>
        </h3>
        <div>
            <?php if (isset($currentUser) && is_array($currentUser)): ?>
                <?php if (($currentUser['role'] ?? '') === 'admin'): ?>
                    <nav class="d-inline-flex align-items-center gap-3">
                        <a href="/admin" class="btn btn-light">Tableau de bord</a>
                        <a href="/logout" class="btn btn-danger">Déconnexion</a>
                    </nav>
                <?php else: ?>
                    <span>Bonjour, <strong><?= htmlspecialchars($currentUser['prenom'] . ' ' . $currentUser['nom']) ?></strong></span>
                    <a href="/trip/create" class="btn btn-black ms-3">Proposer un trajet</a>
                    <a href="/logout" class="btn btn-danger ms-2">Déconnexion</a>
                <?php endif; ?>
            <?php else: ?>
                <a href="/login" class="btn btn-light">Connexion</a>
            <?php endif; ?>
        </div>
    </header>

    <main class="container py-4">
        <?= $content ?>
    </main>

    <footer>
        <p class="m-0">© Touche pas au klaxon 2025</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>