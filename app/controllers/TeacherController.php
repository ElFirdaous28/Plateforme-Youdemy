<?php
require_once(__DIR__ . '/../models/Category.php');
require_once(__DIR__ . '/../models/Tag.php');
class TeacherController extends BaseController
{
    private $CategoryModel;
    private $TagModel;

    public function __construct()
    {
        $this->CategoryModel = new Category();
        $this->TagModel = new Tag();
    }

    public function addCourseView(){
        $categories = $this->CategoryModel->getAllCategories();
        $tags = $this->TagModel->getAllTags();
        var_dump($tags);
        $csrf_token = $_SESSION['csrf_token'];
        $this->render('/teacher/addCourse',['categories' => $categories,'tags' => $tags, 'csrf_token' => $csrf_token]);
    }
}
