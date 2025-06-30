<?php
require_once '../Model/admin.php';

class AdminController {
    private $model;

    public function __construct($db) {
        $this->model = new AdminModel($db);
    }

    // Show login form
    /*public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $admin = $this->model->verifyAdmin($username, $password);

            if ($admin) {
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['admin_username'] = $admin['username'];
                header("Location: /admin/dashboard");
            } else {
                $error = "Invalid credentials!";
                include 'views/admin/login.php';
            }
        } else {
            include 'views/admin/login.php';
        }
    }

    // Logout admin
    public function logout() {
        session_destroy();
        header("Location: /admin/login");
    }*/
}
?>