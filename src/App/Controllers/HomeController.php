<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Models\Trip;

/**
 * Contrôleur principal gérant la page d’accueil.
 */
class HomeController
{
    /**
     * Affiche la page d'accueil en fonction de la session.
     *
     * @return void
     */
    public function index(): void
    {
        session_start();

        /** @var array<string, mixed>|null $user */
        $user = $_SESSION['user'] ?? null;

        if (is_array($user) && isset($user['role'])) {
            if ($user['role'] === 'admin') {
                $trips = Trip::getAllAvailable();
            } else {
                $trips = Trip::findByUser((int)$user['id']);
            }
        } else {
            $trips = Trip::getAllAvailable();
        }

        
        $currentUser = $user ?? null;

        require __DIR__ . '/../Views/home.php';
    }
}