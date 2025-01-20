<?php
// require_once(__DIR__ . '/../models/User.php');
require_once(__DIR__.'/../models/Course.php');
class StudentController extends BaseController
{
    private $CourseModel;
    private $CourseTagsModel;
    public function __construct()
    {
        $this->CourseModel=new Course();
        $this->CourseTagsModel=new CourseTags();
    }

    public function courses()
    {
        $courses = $this->CourseModel->getAllCourses();
        // Add tags to each course
        foreach ($courses as &$course) {
            $course['tags'] = $this->CourseTagsModel->getCoursetags($course['course_id']);
        }
        $this->render('student/courses',['courses' => $courses, 'csrf_token' => $_SESSION['csrf_token']]);
    }

}
