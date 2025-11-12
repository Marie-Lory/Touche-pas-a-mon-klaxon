<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Models\Database;
use App\Models\Trip;
use PDO;

/**
 * Contrôleur des trajets.
 */
class TripController
{
    /**
     * Affiche le formulaire de création de trajet.
     *
     * @return void
     */
    public function createForm(): void
    {
        session_start();
        $pdo = Database::getConnection();
        

        $stmt = $pdo->query('SELECT * FROM agencies');
        assert($stmt !== false);

        $agencies = $stmt->fetchAll(PDO::FETCH_ASSOC);
        

        require __DIR__ . '/../Views/trip_form.php';
    }

    /**
     * Crée un nouveau trajet.
     *
     * @return never
     */
    public function create(): never
    {
        session_start();
        if (!isset($_SESSION['user'])) {
            header('Location: /login');
            exit;
        }

        /** @var array<string, mixed> $user */
        $user = $_SESSION['user'];
        $userId = (int)$user['id'];

        $data = [
            'agency_from_id'     => (int)($_POST['agency_from_id'] ?? 0),
            'agency_to_id'       => (int)($_POST['agency_to_id'] ?? 0),
            'departure_datetime' => (string)($_POST['departure_datetime'] ?? ''),
            'arrival_datetime'   => (string)($_POST['arrival_datetime'] ?? ''),
            'seats_total'        => (int)($_POST['seats_total'] ?? 0),
            'seats_available'    => (int)($_POST['seats_available'] ?? 0),
            'contact_user_id'    => $userId,
            'created_by_user_id' => $userId
        ];

        Trip::create($data);

        $_SESSION['flash'] = "Trajet créé avec succès.";
        header('Location: /');
        exit;
    }

    /**
     * Affiche le formulaire d’édition.
     *
     * @return void
     */
    public function editForm(): void
    {
        session_start();
        $id = (int)($_GET['id'] ?? 0);
        $pdo = Database::getConnection();
        

        $stmt = $pdo->prepare('SELECT * FROM trips WHERE id = ?');
        $stmt->execute([$id]);
        $trip = $stmt->fetch(PDO::FETCH_ASSOC);
        assert(is_array($trip) || $trip === false);

        $stmt = $pdo->query('SELECT * FROM agencies');
        assert($stmt !== false);
        $agencies = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        require __DIR__ . '/../Views/trip_form.php';
    }

    /**
     * Met à jour un trajet existant.
     *
     * @return never
     */
    public function update(): never
    {
        session_start();

        if (!isset($_SESSION['user'])) {
            header('Location: /login');
            exit;
        }

        /** @var array<string, mixed> $user */
        $user = $_SESSION['user'];
        $userId = (int)$user['id'];
        $id = (int)($_POST['id'] ?? 0);

        $data = [
            'agency_from_id'     => (int)($_POST['agency_from_id'] ?? 0),
            'agency_to_id'       => (int)($_POST['agency_to_id'] ?? 0),
            'departure_datetime' => (string)($_POST['departure_datetime'] ?? ''),
            'arrival_datetime'   => (string)($_POST['arrival_datetime'] ?? ''),
            'seats_total'        => (int)($_POST['seats_total'] ?? 0),
            'seats_available'    => (int)($_POST['seats_available'] ?? 0),
            'contact_user_id'    => $userId,
            'created_by_user_id' => $userId
        ];

        Trip::update($id, $data);
        $_SESSION['flash'] = "Trajet modifié avec succès.";
        header('Location: /');
        exit;
    }

    /**
     * Supprime un trajet.
     *
     * @return never
     */
    public function delete(): never
    {
        session_start();
        $id = (int)($_GET['id'] ?? 0);
        Trip::deleteById($id);
        $_SESSION['flash'] = 'Trajet supprimé.';
        header('Location: /');
        exit;
    }
}