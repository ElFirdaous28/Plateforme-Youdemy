<?php

require_once(__DIR__ . '/../models/User.php');

require_once(__DIR__ . '/../services/sendTeacherActivationEmail.php');
class AdminController extends BaseController
{
    private $UserModel;
    public function __construct()
    {
        $this->UserModel = new User();
    }
    public function dashboard(){
        $this->render('/admin/dashboard');
    }

    // all users view
    public function users(){
        $users=$this->UserModel->getAllUsers();
        $csrf_token = $_SESSION['csrf_token'];
        $this->render('/admin/users',["users"=>$users,'csrf_token' => $csrf_token]);
    }

    // all users view
    public function inactiveTeachers(){
        $inactiveTeachers=$this->UserModel->getInactiveTeachers();
        $csrf_token = $_SESSION['csrf_token'];
        $this->render('/admin/inactiveTeachers',["inactiveTeachers"=>$inactiveTeachers,'csrf_token' => $csrf_token]);
    }
    public function activateTeacher($user_id){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['csrf_token']) && $_POST['csrf_token'] === $_SESSION['csrf_token']) {
                $this->UserModel->setUserStatus($user_id,"active");
                $user=$this->UserModel->getUserById($user_id);
                sendTeacherActivationEmail($user["email"], $user["full_name"]);
                header("Location:/admin/users");
            }
        }
    }

    // delete a user
    public function deleteUSer($user_id){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['csrf_token']) && $_POST['csrf_token'] === $_SESSION['csrf_token']) {
                $this->UserModel->deleteUSer($user_id);
                header("Location:/admin/users");
            }
        }
    }
    public function changeUserStatus($user_id){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['csrf_token']) && $_POST['csrf_token'] === $_SESSION['csrf_token']) {
                $newStatus=$_POST["status"]=='active'? "suspended" : "active";
                $this->UserModel->setUserStatus($user_id,$newStatus);
                header("Location:/admin/users");
            }
        }
    }
}
