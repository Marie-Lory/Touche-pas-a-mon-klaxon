<?php
declare(strict_types=1);

/**
 * @var array<int, array<string, mixed>> $users
 * @var array<int, array<string, mixed>> $agencies
 * @var array<int, array<string, mixed>> $trips
 */

ob_start();
?>

<div class="container mt-4">
    <h1 class="mb-4 text-center">Tableau de bord administrateur</h1>

    <?php if (!empty($_SESSION['flash'])): ?>
        <div class="alert alert-success"><?= htmlspecialchars($_SESSION['flash']) ?></div>
        <?php unset($_SESSION['flash']); ?>
    <?php endif; ?>

    <!-- UTILISATEURS -->
    <section class="mb-5">
        <h2 class="mb-3">Utilisateurs</h2>
        <table class="table table-striped table-bordered align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Email</th>
                    <th>Rôle</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $u): ?>
                    <tr>
                        <td><?= (int)$u['id'] ?></td>
                        <td><?= htmlspecialchars($u['nom']) ?></td>
                        <td><?= htmlspecialchars($u['prenom']) ?></td>
                        <td><?= htmlspecialchars($u['email']) ?></td>
                        <td><?= htmlspecialchars($u['role']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>

    <!-- AGENCES -->
    <section class="mb-5">
        <h2 class="mb-3">Agences</h2>
        <form method="post" action="/admin/create-agency" class="mb-4 d-flex gap-2">
            <input name="name" class="form-control" placeholder="Nom de l'agence" required>
            <input name="city" class="form-control" placeholder="Ville" required>
            <button class="btn btn-success">Ajouter</button>
        </form>

        <table class="table table-striped table-bordered align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Ville</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($agencies as $a): ?>
                    <tr>
                        <td><?= (int)$a['id'] ?></td>
                        <td><?= htmlspecialchars($a['name']) ?></td>
                        <td><?= htmlspecialchars($a['city']) ?></td>
                        <td>
                            <form method="post" action="/admin/edit-agency" class="d-inline-block">
                                <input type="hidden" name="id" value="<?= (int)$a['id'] ?>">
                                <input type="text" name="name" value="<?= htmlspecialchars($a['name']) ?>" class="form-control d-inline w-auto">
                                <input type="text" name="city" value="<?= htmlspecialchars($a['city']) ?>" class="form-control d-inline w-auto">
                                <button class="btn btn-warning btn-sm">Modifier</button>
                            </form>
                            <a href="/admin/delete-agency?id=<?= (int)$a['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Supprimer cette agence ?')">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>

    <!-- TRAJETS -->
    <section>
        <h2 class="mb-3">Trajets</h2>
        <table class="table table-striped table-bordered align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Départ</th>
                    <th>Arrivée</th>
                    <th>Date départ</th>
                    <th>Date arrivée</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($trips as $t): ?>
                    <tr>
                        <td><?= (int)$t['id'] ?></td>
                        <td><?= htmlspecialchars($t['from_name']) ?></td>
                        <td><?= htmlspecialchars($t['to_name']) ?></td>
                        <td><?= htmlspecialchars($t['departure_datetime']) ?></td>
                        <td><?= htmlspecialchars($t['arrival_datetime']) ?></td>
                        <td>
                            <a href="/admin/delete-trip?id=<?= (int)$t['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Supprimer ce trajet ?')">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>
</div>

<?php
$content = ob_get_clean();
$title = 'Admin - Tableau de bord';
require __DIR__ . '/../layout.php';