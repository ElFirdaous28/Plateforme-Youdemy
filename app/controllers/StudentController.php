<?php
// require_once(__DIR__ . '/../models/User.php');
require_once(__DIR__ . '/../models/Course.php');
require_once(__DIR__ . '/../models/Enrollment.php');
class StudentController extends BaseController
{
    private $CourseModel;
    private $CourseTagsModel;
    private $EnrollmentModel;
    public function __construct()
    {
        $this->CourseModel = new Course();
        $this->CourseTagsModel = new CourseTags();
        $this->EnrollmentModel = new Enrollment();
    }
    // methode to show all courses
    public function courses()
    {
        $courseEnrolled_in_ids = $this->EnrollmentModel->getEnrolledInCoursesIds($_SESSION['user_loged_in_id']);
        $courses = $this->CourseModel->getAllCourses();
        // Add tags to each course
        foreach ($courses as &$course) {
            $course['tags'] = $this->CourseTagsModel->getCoursetags($course['course_id']);
        }
        $this->render('student/courses', ['courses' => $courses, 'courseEnrolled_in_ids' => $courseEnrolled_in_ids]);
    }

    // methode to add enrolment
    public function enroll($course_id)
    {
        if (isset($_SESSION['user_loged_in_id'])) {
            $this->EnrollmentModel->createEnrollment($_SESSION['user_loged_in_id'], $course_id);
        } else {
            header("Location:/login");
        }
    }

    // methode to show all courses
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
        // echo '<pre>';
        // var_dump($studentCourses);
        // die;
        $this->render('student/myCourses', ['studentCourses' => $studentCourses]);
    }
    
    
}
