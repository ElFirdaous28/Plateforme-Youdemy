<?php

require_once(__DIR__ . '/../models/User.php');
require_once(__DIR__ . '/../models/Category.php');
require_once(__DIR__ . '/../models/Tag.php');

require_once(__DIR__ . '/../services/sendTeacherActivationEmail.php');
class AdminController extends BaseController
{
    private $UserModel;
    private $CategoryModel;
    private $TagModel;
    public function __construct()
    {
        $this->UserModel = new User();
        $this->CategoryModel = new Category();
        $this->TagModel = new Tag();
    }

    // all users view
    public function users()
    {
        $users = $this->UserModel->getAllUsers();
        $csrf_token = $_SESSION['csrf_token'];
        $this->render('/admin/users', ["users" => $users, 'csrf_token' => $csrf_token]);
    }

    // all users view
    public function inactiveTeachers()
    {
        $inactiveTeachers = $this->UserModel->getInactiveTeachers();
        $csrf_token = $_SESSION['csrf_token'];
        $this->render('/admin/inactiveTeachers', ["inactiveTeachers" => $inactiveTeachers, 'csrf_token' => $csrf_token]);
    }
    public function activateTeacher($user_id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['csrf_token']) && $_POST['csrf_token'] === $_SESSION['csrf_token']) {
                $this->UserModel->setUserStatus($user_id, "active");
                $user = $this->UserModel->getUserById($user_id);
                sendTeacherActivationEmail($user["email"], $user["full_name"]);
                header("Location:/admin/users");
            }
        }
    }

    // delete a user
    public function deleteUSer($user_id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['csrf_token']) && $_POST['csrf_token'] === $_SESSION['csrf_token']) {
                $this->UserModel->deleteUSer($user_id);
                header("Location:/admin/users");
            }
        }
    }
    public function changeUserStatus($user_id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['csrf_token']) && $_POST['csrf_token'] === $_SESSION['csrf_token']) {
                $newStatus = $_POST["status"] == 'active' ? "suspended" : "active";
                $this->UserModel->setUserStatus($user_id, $newStatus);
                header("Location:/admin/users");
            }
        }
    }

    // methode to show all catgories
    public function categories()
    {
        $categories = $this->CategoryModel->getAllCategories();
        $csrf_token = $_SESSION['csrf_token'];
        $this->render('/admin/categories', ['categories' => $categories, 'csrf_token' => $csrf_token]);
    }
    // methode to add a category
    public function addCategory()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['csrf_token']) && $_POST['csrf_token'] === $_SESSION['csrf_token']) {
                $catgory_name = $_POST["category_name"];
                $addCatStatus = $this->CategoryModel->addCategoty($catgory_name);
                if (!$addCatStatus)
                    $_SESSION["add_category_error"] = "category name should be unique";
                header("Location:/admin/categories");
            }
        }
    }

    // methode to edite a category
    public function editCategory($categoryId)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['csrf_token']) && $_POST['csrf_token'] === $_SESSION['csrf_token']) {
                $catgory_name = $_POST["category_name"];
                $addCatStatus = $this->CategoryModel->editCategory($categoryId, $catgory_name);
                header("Location:/admin/categories");
            }
        }
    }
    // metjode to delete category
    public function deleteCategory($category_id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['csrf_token']) && $_POST['csrf_token'] === $_SESSION['csrf_token']) {
                $this->CategoryModel->deleteCategory($category_id);
                header("Location:/admin/categories");
            }
        }
    }

    // methode to show the admin tags page
    public function tags()
    {
        $tags = $this->TagModel->getAllTags();
        $csrf_token = $_SESSION['csrf_token'];
        $this->render('/admin/tags', ['tags' => $tags, 'csrf_token' => $csrf_token]);
    }

    // Method to add a tag
    public function addTag()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['csrf_token']) && $_POST['csrf_token'] === $_SESSION['csrf_token']) {
                $tag_name = $_POST["tag_name"];
                $addTagStatus = $this->TagModel->addTag($tag_name);
                if (!$addTagStatus)
                    $_SESSION["add_tag_error"] = "Tag name should be unique";
                header("Location:/admin/tags");
            }
        }
    }

    // Method to edit a tag
    public function editTag($tagId)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['csrf_token']) && $_POST['csrf_token'] === $_SESSION['csrf_token']) {
                $tag_name = $_POST["tag_name"];
                $editTagStatus = $this->TagModel->editTag($tagId, $tag_name);
                header("Location:/admin/tags");
            }
        }
    }

    // Method to delete a tag
    public function deleteTag($tag_id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['csrf_token']) && $_POST['csrf_token'] === $_SESSION['csrf_token']) {
                $this->TagModel->deleteTag($tag_id);
                header("Location:/admin/tags");
            }
        }
    }
}
