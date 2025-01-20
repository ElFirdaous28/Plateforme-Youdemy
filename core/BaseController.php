<?php
require_once(__DIR__ . '/../app/models/Course.php');
require_once(__DIR__ . '/../app/models/CourseTags.php');

class BaseController
{
    private $CourseModel;
    private $CourseTagsModel;
    
    public function __construct()
    {
        $this->CourseModel = new Course();
        $this->CourseTagsModel = new CourseTags();
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
        $courses = $this->CourseModel->getAllCourses();
        // Add tags to each course
        foreach ($courses as &$course) {
            $course['tags'] = $this->CourseTagsModel->getCoursetags($course['course_id']);
        }
        $this->render('auth/index',['courses' => $courses, 'csrf_token' => $_SESSION['csrf_token']]);
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
        $urlFirstPart = $parts[0] ?? '';

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
        }
        else if($urlFirstPart==="enroll"){
            header("Location:/login");
        }
    }
}
