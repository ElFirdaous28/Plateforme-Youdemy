<?php
// require_once(__DIR__ . '/../models/User.php');
require_once(__DIR__ . '/../models/Course.php');
require_once(__DIR__ . '/../models/Enrollment.php');
require_once(__DIR__ . '/../models/Category.php');
class StudentController extends BaseController
{
    private $CourseModel;
    private $CourseTagsModel;
    private $EnrollmentModel;
    private $CategoryModel;
    public function __construct()
    {
        $this->CourseModel = new Course();
        $this->CourseTagsModel = new CourseTags();
        $this->EnrollmentModel = new Enrollment();
        $this->CategoryModel = new Category();
    }

    public function dashboard()
    {
        $this->render('/student/dashboard', []);
    }

    public function courses()
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

        // Add tags to each course
        foreach ($courses as $key => $course) {
            $courses[$key]['tags'] = $this->CourseTagsModel->getCoursetags($course['course_id']);
        }

        // Get courses the user is enrolled in
        $courseEnrolled_in_ids = $this->EnrollmentModel->getEnrolledInCoursesIds($_SESSION['user_loged_in_id']);

        // Get all categories for the filter dropdown
        $categories = $this->CategoryModel->getAllCategories();

        // Render the view
        $this->render('student/courses', [
            'courses' => $courses,
            'courseEnrolled_in_ids' => $courseEnrolled_in_ids,
            'categories' => $categories,
            'totalPages' => $totalPages,
            'currentPage' => $page,
        ]);
    }

    // methode to add enrolment
    public function enroll($course_id)
    {
        if (isset($_SESSION['user_loged_in_id'])) {
            $this->EnrollmentModel->createEnrollment($_SESSION['user_loged_in_id'], $course_id);
            header("Location:/student/courses");
        } else {
            header("Location:/login");
        }
    }

    // methode to show stident enrolled in courses
    public function myCourses()
    {
        $courseEnrolled_in_ids = $this->EnrollmentModel->getacceptedEnrollmentsCoursesIds($_SESSION['user_loged_in_id']);
        $studentCourses = [];

        foreach ($courseEnrolled_in_ids as $course_id) {
            $course = $this->CourseModel->getCourseById($course_id);
            if ($course) {
                $course['tags'] = $this->CourseTagsModel->getCoursetags($course['course_id']);
                $studentCourses[] = $course;
            }
        }
        $this->render('student/myCourses', ['studentCourses' => $studentCourses]);
    }
}
