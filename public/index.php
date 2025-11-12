<?php
declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use App\Controllers\{
    HomeController,
    AuthController,
    TripController,
    AdminController
};

// sécurité sur $_SERVER
$path = isset($_SERVER['REQUEST_URI']) ? (string) parse_url((string) $_SERVER['REQUEST_URI'], PHP_URL_PATH) : '/';
$method = (string) ($_SERVER['REQUEST_METHOD'] ?? 'GET');

switch (true) {
    case ($path === '/' || $path === '/index.php'):
        (new HomeController())->index();
        break;

    case ($path === '/login' && $method === 'GET'):
        (new AuthController())->showLogin();
        break;

    case ($path === '/login' && $method === 'POST'):
        (new AuthController())->login();
        break;

    case ($path === '/logout'):
        (new AuthController())->logout();
        break;

    case ($path === '/trip/create' && $method === 'GET'):
        (new TripController())->createForm();
        break;

    case ($path === '/trip/create' && $method === 'POST'):
        (new TripController())->create();
        break;

    case ($path === '/trip/edit' && $method === 'GET'):
        (new TripController())->editForm();
        break;

    case ($path === '/trip/update' && $method === 'POST'):
        (new TripController())->update();
        break;

    case ($path === '/trip/delete'):
        (new TripController())->delete();
        break;

    case ($path === '/admin'):
        (new AdminController())->dashboard();
        break;

    case ($path === '/admin/create-agency' && $method === 'POST'):
        (new AdminController())->createAgency();
        break;

    case ($path === '/admin/edit-agency' && $method === 'POST'):
        (new AdminController())->editAgency();
        break;

    case ($path === '/admin/delete-agency'):
        (new AdminController())->deleteAgency();
        break;

    case ($path === '/admin/delete-trip'):
        (new AdminController())->deleteTrip();
        break;

    default:
        http_response_code(404);
        echo '<h1>404 Not Found</h1>';
        break;
}