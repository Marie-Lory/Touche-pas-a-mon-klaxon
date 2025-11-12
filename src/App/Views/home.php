<?php
declare(strict_types=1);

/**
 * @var array<int, array<string, mixed>> $trips
 * @var array<string, mixed>|null $currentUser
 */

ob_start();
?>

<div class="container mt-4">
    <?php if (!empty($_SESSION['flash'])): ?>
        <div class="alert alert-success">
            <?= htmlspecialchars($_SESSION['flash']) ?>
        </div>
        <?php unset($_SESSION['flash']); ?>
    <?php endif; ?>

    <?php if ($currentUser === null): ?>
        <h2 class="text-center mb-4">Pour obtenir plus d'information sur un trajet, veuillez vous connecter</h2>
    <?php else: ?>
        <h2 class="text-center mb-4">Trajets proposés</h2>
    <?php endif; ?>

    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-primary">
                <tr>
                    <th>Départ</th>
                    <th>Date de départ</th>
                    <th>Arrivée</th>
                    <th>Date d’arrivée</th>
                    <th>Places dispo</th>
                    <?php if ($currentUser !== null): ?>
                        <th>Action</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($trips as $trip): ?>
                    <tr>
                        <td><?= htmlspecialchars($trip['from_name'] ?? 'N/A') ?></td>
                        <td><?= htmlspecialchars($trip['departure_datetime'] ?? '') ?></td>
                        <td><?= htmlspecialchars($trip['to_name'] ?? 'N/A') ?></td>
                        <td><?= htmlspecialchars($trip['arrival_datetime'] ?? '') ?></td>
                        <td><?= htmlspecialchars((string)($trip['seats_available'] ?? '')) ?></td>
                        <?php if ($currentUser !== null): ?>
                            <td>
                                <button 
                                    class="btn btn-info btn-sm" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#tripModal<?= (int)$trip['id'] ?>"
                                >Détails</button>

                                <?php if ((int)$trip['created_by_user_id'] === (int)$currentUser['id']): ?>
                                    <a href="/trip/edit?id=<?= (int)$trip['id'] ?>" class="btn btn-warning btn-sm">Modifier</a>
                                    <a href="/trip/delete?id=<?= (int)$trip['id'] ?>" class="btn btn-danger btn-sm">Supprimer</a>
                                <?php endif; ?>
                            </td>
                        <?php endif; ?>
                    </tr>

                    <!-- Modal Détails -->
                    <div class="modal fade" id="tripModal<?= (int)$trip['id'] ?>" tabindex="-1" aria-labelledby="tripModalLabel<?= (int)$trip['id'] ?>" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="tripModalLabel<?= (int)$trip['id'] ?>">Détails du trajet</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <p><strong>Auteur :</strong> <?= htmlspecialchars(($trip['prenom'] ?? '') . ' ' . ($trip['nom'] ?? '')) ?></p>
                                    <p><strong>Email :</strong> <?= htmlspecialchars($trip['email'] ?? '') ?></p>
                                    <p><strong>Téléphone :</strong> <?= htmlspecialchars($trip['phone'] ?? '') ?></p>
                                    <p><strong>Places totales :</strong> <?= htmlspecialchars((string)($trip['seats_total'] ?? '')) ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php
$content = ob_get_clean();
$title = 'Covoiturage - Accueil';
require __DIR__ . '/layout.php';
