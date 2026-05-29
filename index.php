<?php
session_start();
include 'config/koneksi.php';

include 'models/AuthModel.php';
include 'models/KamarModel.php';
include 'models/PembayaranModel.php';
include 'models/LaporanModel.php';

include 'controllers/AuthController.php';
include 'controllers/AdminController.php';
include 'controllers/UserController.php';

$authModel = new AuthModel($koneksi);
$kamarModel = new KamarModel($koneksi);
$pembayaranModel = new PembayaranModel($koneksi);
$laporanModel = new LaporanModel($koneksi);

$authController = new AuthController($authModel, $kamarModel);
$adminController = new AdminController($authModel, $kamarModel, $pembayaranModel, $laporanModel);
$userController = new UserController($authModel, $kamarModel, $pembayaranModel, $laporanModel);

$page = isset($_GET['page']) ? $_GET['page'] : 'login';

switch ($page) {
    case 'login':
        $authController->handleLogin();
        break;
    case 'register':
        $authController->handleRegister();
        break;
    case 'admin':
        $adminController->index();
        break;
    case 'user':
        $userController->index();
        break;
    default:
        $authController->handleLogin();
        break;
}
?>