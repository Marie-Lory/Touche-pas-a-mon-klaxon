<?php
declare(strict_types=1);

/**
 * @var array<int, array<string, mixed>> $agencies Liste des agences
 * @var array<string, mixed>|null $trip Données du trajet si modification
 */

ob_start();

$isEditing = isset($trip);
$formAction = $isEditing ? '/trip/update' : '/trip/create';
$pageTitle = $isEditing ? 'Modifier un trajet' : 'Proposer un trajet';
?>

<div class="container mt-4">
    <h2 class="mb-4"><?= htmlspecialchars($pageTitle) ?></h2>

    <form method="post" action="<?= htmlspecialchars($formAction) ?>" class="card p-4 shadow-sm border-0">
        <?php if ($isEditing && isset($trip['id'])): ?>
            <input type="hidden" name="id" value="<?= (int)$trip['id'] ?>">
        <?php endif; ?>

        <div class="mb-3">
            <label for="agency_from_id" class="form-label fw-bold">Agence de départ</label>
            <select id="agency_from_id" name="agency_from_id" class="form-select" required>
                <?php foreach ($agencies as $a): ?>
                    <option 
                        value="<?= (int)$a['id'] ?>" 
                        <?= $isEditing && ((int)$trip['agency_from_id'] === (int)$a['id']) ? 'selected' : '' ?>
                    >
                        <?= htmlspecialchars($a['name'] ?? 'Nom inconnu') ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="agency_to_id" class="form-label fw-bold">Agence d’arrivée</label>
            <select id="agency_to_id" name="agency_to_id" class="form-select" required>
                <?php foreach ($agencies as $a): ?>
                    <option 
                        value="<?= (int)$a['id'] ?>" 
                        <?= $isEditing && ((int)$trip['agency_to_id'] === (int)$a['id']) ? 'selected' : '' ?>
                    >
                        <?= htmlspecialchars($a['name'] ?? 'Nom inconnu') ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="departure_datetime" class="form-label fw-bold">Départ (date et heure)</label>
                <input 
                    type="datetime-local"
                    id="departure_datetime"
                    name="departure_datetime"
                    class="form-control"
                    value="<?= htmlspecialchars($trip['departure_datetime'] ?? '') ?>"
                    required
                >
            </div>

            <div class="col-md-6 mb-3">
                <label for="arrival_datetime" class="form-label fw-bold">Arrivée (date et heure)</label>
                <input 
                    type="datetime-local"
                    id="arrival_datetime"
                    name="arrival_datetime"
                    class="form-control"
                    value="<?= htmlspecialchars($trip['arrival_datetime'] ?? '') ?>"
                    required
                >
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="seats_total" class="form-label fw-bold">Places totales</label>
                <input 
                    type="number"
                    id="seats_total"
                    name="seats_total"
                    class="form-control"
                    min="1"
                    value="<?= htmlspecialchars((string)($trip['seats_total'] ?? '4')) ?>"
                    required
                >
            </div>

            <div class="col-md-6 mb-3">
                <label for="seats_available" class="form-label fw-bold">Places disponibles</label>
                <input 
                    type="number"
                    id="seats_available"
                    name="seats_available"
                    class="form-control"
                    min="1"
                    value="<?= htmlspecialchars((string)($trip['seats_available'] ?? '4')) ?>"
                    required
                >
            </div>
        </div>

        <button type="submit" class="btn btn-primary w-100">
            <?= $isEditing ? 'Mettre à jour' : 'Créer le trajet' ?>
        </button>
    </form>
</div>

<?php
$content = ob_get_clean();
$title = $pageTitle;
require __DIR__ . '/layout.php';