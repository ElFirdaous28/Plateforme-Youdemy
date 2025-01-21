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

    // // methode to show all courses
    // public function courses()
    // {
    //     $courseEnrolled_in_ids = $this->EnrollmentModel->getEnrolledInCoursesIds($_SESSION['user_loged_in_id']);
    //     $categories = $this->CategoryModel->getAllCategories();
    //     $courses = $this->CourseModel->getAllCourses();
    //     // Add tags to each course
    //     foreach ($courses as &$course) {
    //         $course['tags'] = $this->CourseTagsModel->getCoursetags($course['course_id']);
    //     }
    //     $this->render('student/courses', ['courses' => $courses, 'courseEnrolled_in_ids' => $courseEnrolled_in_ids,'categories'=>$categories]);
    // }

    public function courses()
    {
        $limit = 8;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($page - 1) * $limit;

        $totalCourses = $this->CourseModel->getTotalCoursesNumber();
        $totalPages = ceil($totalCourses / $limit);

        $courses = $this->CourseModel->getAllCoursesX($limit, $offset);

        foreach ($courses as $course) {
            $course['tags'] = $this->CourseTagsModel->getCoursetags($course['course_id']);
        }

        $courseEnrolled_in_ids = $this->EnrollmentModel->getEnrolledInCoursesIds($_SESSION['user_loged_in_id']);
        $categories = $this->CategoryModel->getAllCategories();

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
