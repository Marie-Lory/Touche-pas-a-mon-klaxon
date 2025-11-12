<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Models\Database;
use PDO;

/**
 * Contrôleur d'administration
 * Gère les utilisateurs, agences et trajets.
 */
class AdminController
{
    /** @var PDO Connexion active */
    private PDO $pdo;

    public function __construct()
    {
        $pdo = Database::getConnection();
        $this->pdo = $pdo;
    }

    /**
     * Vérifie que l'utilisateur connecté est administrateur.
     *
     * @return void
     */
    private function ensureAdmin(): void
    {
        session_start();
        /** @var array<string, mixed>|null $user */
        $user = $_SESSION['user'] ?? null;

        if (!is_array($user) || ($user['role'] ?? '') !== 'admin') {
            header('Location: /login');
            exit;
        }
    }

    /**
     * Tableau de bord admin.
     *
     * @return void
     */
    public function dashboard(): void
    {
        $this->ensureAdmin();
        $stmt = $this->pdo->query('SELECT id, nom, prenom, email, role FROM users');
        assert($stmt !== false);
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $stmt = $this->pdo->query('SELECT * FROM agencies');
        assert($stmt !== false);
        $agencies = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $stmt = $this->pdo->query('
            SELECT t.*, a1.name AS from_name, a2.name AS to_name
            FROM trips t
            JOIN agencies a1 ON a1.id = t.agency_from_id
            JOIN agencies a2 ON a2.id = t.agency_to_id
            ');
        assert($stmt !== false);
        $trips = $stmt->fetchAll(PDO::FETCH_ASSOC);

        require __DIR__ . '/../Views/admin/dashboard.php';
    }

    /**
     * Crée une nouvelle agence.
     *
     * @return never
     */
    public function createAgency(): never
    {
        $this->ensureAdmin();
        $name = trim((string)($_POST['name'] ?? ''));
        $city = trim((string)($_POST['city'] ?? ''));

        if ($name !== '') {
            $stmt = $this->pdo->prepare('INSERT INTO agencies (name, city) VALUES (?, ?)');
            $stmt->execute([$name, $city]);
            $_SESSION['flash'] = 'Agence créée.';
        }

        header('Location: /admin');
        exit;
    }

    /**
     * Modifie une agence existante.
     *
     * @return never
     */
    public function editAgency(): never
    {
        $this->ensureAdmin();
        $id = (int)($_POST['id'] ?? 0);
        $name = (string)($_POST['name'] ?? '');
        $city = (string)($_POST['city'] ?? '');

        if ($id > 0) {
            $stmt = $this->pdo->prepare('UPDATE agencies SET name = ?, city = ? WHERE id = ?');
            $stmt->execute([$name, $city, $id]);
            $_SESSION['flash'] = 'Agence modifiée.';
        }

        header('Location: /admin');
        exit;
    }

    /**
     * Supprime une agence.
     *
     * @return never
     */
    public function deleteAgency(): never
    {
        $this->ensureAdmin();
        $id = (int)($_GET['id'] ?? 0);

        if ($id > 0) {
            $stmt = $this->pdo->prepare('DELETE FROM agencies WHERE id = ?');
            $stmt->execute([$id]);
            $_SESSION['flash'] = 'Agence supprimée.';
        }

        header('Location: /admin');
        exit;
    }

    /**
     * Supprime un trajet.
     *
     * @return never
     */
    public function deleteTrip(): never
    {
        $this->ensureAdmin();
        $id = (int)($_GET['id'] ?? 0);

        if ($id > 0) {
            $stmt = $this->pdo->prepare('DELETE FROM trips WHERE id = ?');
            $stmt->execute([$id]);
            $_SESSION['flash'] = 'Trajet supprimé.';
        }

        header('Location: /admin');
        exit;
    }
}