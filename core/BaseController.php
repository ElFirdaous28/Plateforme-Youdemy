<?php

class BaseController
{
    // Render a view
    public function render($view, $data = [])
    {

        extract($data);
        include __DIR__ . '/../app/views/' . $view . '.php';
    }
    public function renderDashboard($role, $data = [])
    {

        extract($data);
        include __DIR__ . '/../app/views/' . $role . '/dashboard.php';
    }
    public function index()
    {
        $this->render('auth/index');
    }
    public function dashboard()
    {
        $role = $_SESSION["user_loged_in_role"];
        $this->renderDashboard($role);
    }

    public function unauthorized()
    {
        $this->render('partials/unauthorized');
    }

    public function checkRole()
    {
        $url = $_SERVER['REQUEST_URI'];
        $parts = explode('/', trim($url, '/'));
        $urlRole = $parts[0] ?? '';

        if (isset($_SESSION['user_loged_in_role'])) {
            $sessionRole = $_SESSION['user_loged_in_role'];
            if (in_array($urlRole, ['admin', 'teacher', 'student'])) {

                if ($sessionRole !== $urlRole) {
                    header("Location: /unauthorized");
                    exit;
                }
            } else if ($urlRole === "login") {
                header("Location: $sessionRole/dashboard");
            }
        }
    }
}
