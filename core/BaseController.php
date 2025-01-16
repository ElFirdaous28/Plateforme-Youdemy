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
    
        // Check if the session role exists and matches one of the allowed roles
        if (isset($_SESSION['user_loged_in_role']) && in_array($urlRole, ['admin', 'teacher', 'student'])) {
            $sessionRole = $_SESSION['user_loged_in_role'];
    
            // If the session role doesn't match the URL role, redirect to unauthorized
            if ($sessionRole !== $urlRole) {
                header("Location: /unauthorized");
                exit;
            }
        }
    }
    
}
