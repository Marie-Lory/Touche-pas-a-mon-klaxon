<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Models\Database;
use App\Models\User;
use PDO;

/**
 * Gère l’authentification des utilisateurs.
 */
class AuthController
{
    /**
     * Affiche la page de connexion.
     *
     * @return void
     */
    public function showLogin(): void
    {
        require __DIR__ . '/../Views/login.php';
    }

    /**
     * Traite la connexion utilisateur.
     *
     * @return void
     */
    public function login(): void
    {
        session_start();
        $email = (string)($_POST['email'] ?? '');
        $password = (string)($_POST['password'] ?? '');

        $pdo = Database::getConnection();
        

        $userModel = new User($pdo);
        $user = $userModel->findByEmail($email);

        // Validation d’existence
        if (is_array($user) && $password === 'test123') {
            $_SESSION['user'] = [
                'id'       => (int)$user['id'],
                'nom'      => (string)($user['nom'] ?? ''),
                'prenom'   => (string)($user['prenom'] ?? ''),
                'email'    => (string)$user['email'],
                'role'     => (string)$user['role'],
            ];
            header('Location: /');
            exit;
        }

        $error = 'Identifiants invalides (utilise un email existant et mot de passe test123).';
        require __DIR__ . '/../Views/login.php';
    }

    /**
     * Déconnecte l’utilisateur.
     *
     * @return never
     */
    public function logout(): never
    {
        session_start();
        session_destroy();
        header('Location: /');
        exit;
    }
}