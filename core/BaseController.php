<?php
require_once(__DIR__ . '/../app/models/Course.php');
require_once(__DIR__ . '/../app/models/CourseTags.php');
require_once(__DIR__ . '/../app/models/DocumentContent.php');
require_once(__DIR__ . '/../app/models/VideoContent.php');
require_once(__DIR__ . '/../app/models/Category.php');

class BaseController
{
    private $CourseModel;
    private $CourseTagsModel;
    private $DocumentContentModel;
    private $VideoContentModel;
    private $CategoryModel;

    public function __construct()
    {
        $this->CourseModel = new Course();
        $this->CourseTagsModel = new CourseTags();
        $this->DocumentContentModel = new DocumentContent();
        $this->VideoContentModel = new VideoContent();
        $this->CategoryModel = new Category();
    }
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
        $limit = 8;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($page - 1) * $limit;

        $totalCourses = $this->CourseModel->getTotalCoursesNumber();
        $totalPages = ceil($totalCourses / $limit);

        // Get category and search value from query params
        $category_id = isset($_GET['category']) ? $_GET['category'] : null;
        $search_value = isset($_GET['search_value']) ? $_GET['search_value'] : null;

        // Pass the category_id and search_value to getAllCoursesX
        $courses = $this->CourseModel->getAllCoursesX($limit, $offset, $search_value, $category_id);

        foreach ($courses as $course) {
            $course['tags'] = $this->CourseTagsModel->getCoursetags($course['course_id']);
        }

        $categories = $this->CategoryModel->getAllCategories();

        $this->render('auth/index', [
            'courses' => $courses,
            'categories' => $categories,
            'totalPages' => $totalPages,
            'currentPage' => $page
        ]);
    }

    public function unauthorized()
    {
        $this->render('partials/unauthorized');
    }

    public function checkRole()
    {
        $url = $_SERVER['REQUEST_URI'];
        $parts = explode('/', trim($url, '/'));
        $urlFirstPart = $parts[0] ?? '';
        $urlSecondPart = $parts[1] ?? '';

        if (isset($_SESSION['user_loged_in_role'])) {
            $sessionRole = $_SESSION['user_loged_in_role'];
            if (in_array($urlFirstPart, ['admin', 'teacher', 'student'])) {

                if ($sessionRole !== $urlFirstPart) {
                    header("Location: /unauthorized");
                    exit;
                }
            } else if ($urlFirstPart === "login") {
                header("Location: $sessionRole/dashboard");
            }
        } else {
            if (in_array($urlFirstPart, ['admin', 'teacher', 'student'])) {
                header("Location: /unauthorized");
                exit;
            }
        }
    }

    // methode to see course details
    public function courseDetails($course_id)
    {
        $course = $this->CourseModel->getCourseById($course_id);
        // get tags
        $course['tags'] = $this->CourseTagsModel->getCoursetags($course['course_id']);
        // get content
        if ($course['content_type'] === 'document') {
            $course['content'] = $this->DocumentContentModel->getContent($course_id);
        } else if ($course['content_type'] === 'video') {
            $course['content'] = $this->VideoContentModel->getContent($course_id);
        }
        // echo '<pre>';
        // var_dump($course);
        // die;
        $this->render('auth/courseDetails', ['course' => $course]);
    }
}
