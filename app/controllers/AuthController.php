<?php
require_once(__DIR__ . '/../models/User.php');
class AuthController extends BaseController
{

    private $UserModel;
    public function __construct()
    {

        $this->UserModel = new User();
    }

    public function showRegister()
    {

        $this->render('auth/register');
    }
    public function showleLogin()
    {

        $this->render('auth/login');
    }

    public function handleRegister()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $number_of_users = $this->UserModel->getNumberOfUsers();

            if (isset($_POST['register'])) {
                $full_name = $_POST['full_name'];
                $email = $_POST['email'];
                $password = $_POST['password'];
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                // status has also to take a value!!!

                $role = $number_of_users == 0 ? "admin" : $_POST['role'];

                $user = [$full_name, $email, $hashed_password, $role];

                $lastInsertId = $this->UserModel->register($user);
                $_SESSION['user_loged_in_id'] = $lastInsertId;
                $_SESSION['user_loged_in_role'] = $role;
                $_SESSION['user_loged_in_name'] = $full_name;

                if ($lastInsertId && $role == "admin") {
                    header('Location: /admin/dashboard');
                } else if ($lastInsertId && $role == "teacher") {
                    header('Location: /teacher/dashboard');
                } else if ($lastInsertId && $role == "student") {
                    header('Location: /student/dashboard');
                }
                exit;
            }
        }
    }
    public function handleLogin()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['login'])) {
                $email = $_POST['email'];
                $password = $_POST['password'];
                $userData = [$email, $password];
                $user = $this->UserModel->login($userData);
                $role = $user['role'];
                $_SESSION['user_loged_in_id'] = $user["user_id"];
                $_SESSION['user_loged_in_role'] = $role;
                $_SESSION['user_loged_in_name'] = $user['full_name'];

                if ($user && $role == "admin") {
                    header('Location: /admin/dashboard');
                } else if ($user && $role == "teacher") {
                    header('Location: /teacher/dashboard');
                } else if ($user && $role == "student") {
                    header('Location: /student/dashboard');
                }
            }
        }
    }

    public function logout()
    {
        if (isset($_SESSION['user_loged_in_id']) && isset($_SESSION['user_loged_in_role'])) {
            unset($_SESSION['user_loged_in_id']);
            unset($_SESSION['user_loged_in_role']);
            session_destroy();
        }
        header("Location:/login");
        exit;
    }
}
