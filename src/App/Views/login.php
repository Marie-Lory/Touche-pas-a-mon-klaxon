<?php
declare(strict_types=1);

/**
 * @var string|null $error Message d'erreur éventuel
 */

ob_start();
?>

<div class="row justify-content-center mt-5">
    <div class="col-md-6">
        <h2 class="mb-4 text-center">Connexion</h2>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger text-center"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="post" action="/login" class="card p-4 shadow-sm border-0">
            <div class="mb-3">
                <label for="email" class="form-label fw-bold">Adresse e-mail</label>
                <input 
                    type="email" 
                    class="form-control" 
                    id="email" 
                    name="email" 
                    placeholder="exemple@entreprise.com" 
                    required
                >
            </div>

            <div class="mb-3">
                <label for="password" class="form-label fw-bold">Mot de passe</label>
                <input 
                    type="password" 
                    class="form-control" 
                    id="password" 
                    name="password" 
                    placeholder="test123"
                    required
                >
                <div class="form-text">Utilisez le mot de passe <strong>test123</strong> pour les tests.</div>
            </div>

            <button type="submit" class="btn btn-primary w-100">Se connecter</button>
        </form>
    </div>
</div>

<?php
$content = ob_get_clean();
$title = 'Connexion - Covoiturage';
require __DIR__ . '/layout.php';