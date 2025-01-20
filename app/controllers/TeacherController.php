<?php

require_once(__DIR__ . '/../models/Category.php');
require_once(__DIR__ . '/../models/Tag.php');
require_once(__DIR__ . '/../models/Course.php');
require_once(__DIR__ . '/../models/VideoContent.php');
require_once(__DIR__ . '/../models/DocumentContent.php');
require_once(__DIR__ . '/../models/CourseTags.php');

require_once __DIR__ . '/../../vendor/autoload.php';

use setasign\Fpdf\Fpdf;
use setasign\Fpdi\Fpdi;

class TeacherController extends BaseController
{
    private $CategoryModel;
    private $TagModel;
    private $CourseModel;
    private $DocumentContentModel;
    private $VideoContentModel;
    private $CourseTagsModel;

    public function __construct()
    {
        $this->CategoryModel = new Category();
        $this->TagModel = new Tag();
        $this->CourseModel = new Course();
        $this->DocumentContentModel = new DocumentContent();
        $this->VideoContentModel = new VideoContent();
        $this->CourseTagsModel = new CourseTags();
    }

    // method to show add course view
    public function addCourseView()
    {
        $categories = $this->CategoryModel->getAllCategories();
        $tags = $this->TagModel->getAllTags();
        $csrf_token = $_SESSION['csrf_token'];
        $this->render('/teacher/addCourse', ['categories' => $categories, 'tags' => $tags, 'csrf_token' => $csrf_token]);
    }

    // method to submit the add course form
    public function SubmitAddCourse()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['csrf_token']) && $_POST['csrf_token'] === $_SESSION['csrf_token']) {
                $title = $_POST['title'];
                $description = $_POST['description'];
                $category_id = $_POST['category_id'];
                $teacher_id = $_SESSION['user_loged_in_id'];
                $content_type = $_POST['content_type'];
                $tags = $_POST['tags'];
                $tagsIdsArray = explode(',', trim($tags));

                // Insert course data into the database
                $courseInsertedId = $this->CourseModel->createCoure($title, $description, $category_id, $teacher_id, $content_type);
                $fileDetails = $this->uploadFile($content_type);

                if ($courseInsertedId && $fileDetails) {
                    // insert courseTgas
                    foreach ($tagsIdsArray as $tag_id) {
                        $this->CourseTagsModel->addCourseTags($courseInsertedId, $tag_id);
                    }

                    // insert content
                    if ($content_type == 'video') {
                        $this->VideoContentModel->addContent(['course_id' => $courseInsertedId, 'video_url' => $fileDetails['fileUrl'], 'duration' => $fileDetails['contentInfo']]);
                    } else if ($content_type == 'document') {
                        $this->DocumentContentModel->addContent(['course_id' => $courseInsertedId, 'document_url' => $fileDetails['fileUrl'], 'pages_number' => $fileDetails['contentInfo']]);
                    }
                    // header("Location:/teacher/myCourses");
                } else {
                    echo 'Failed to add course to the database';
                }
            }
        }
    }

    public function uploadFile($content_type)
    {
        if (isset($_FILES['content']) && $_FILES['content']['error'] === UPLOAD_ERR_OK) {
            $fileTmpName = $_FILES['content']['tmp_name'];
            $fileName = $_FILES['content']['name'];
            $basePath = 'C:/laragon/www/Plateforme-Youdemy/public/assets/uploads/';
            $targetDir = $content_type === 'video' ? $basePath . 'videocourses/' : $basePath . 'documentcourses/';
            $targetFilePath = $targetDir . basename($fileName);

            if (move_uploaded_file($fileTmpName, $targetFilePath)) {
                $fileUrl = '/assets/uploads/' . ($content_type === 'video' ? 'videocourses' : 'documentcourses') . '/' . basename($fileName);
                $contentInfo = '';

                if ($content_type === 'video') {
                    $getID3 = new \getID3;
                    $file = $getID3->analyze($targetFilePath);
                    $contentInfo = isset($file['playtime_seconds']) ? (int) $file['playtime_seconds'] : 0;
                } elseif ($content_type === 'document') {
                    // Use FPDI to extract PDF page count
                    $pdf = new Fpdi();
                    $pageCount = $pdf->setSourceFile($targetFilePath);
                    $contentInfo = $pageCount;
                }

                return ['fileUrl' => $fileUrl, 'contentInfo' => $contentInfo];
            } else {
                echo 'Failed to move uploaded file to: ' . $targetFilePath;
                return false;
            }
        } else {
            echo 'File upload error: ' . $_FILES['content']['error'];
            return false;
        }
    }


    // method to show all teaacher courses
    public function teacherCourses()
    {
        $courses = $this->CourseModel->getAllTeacherCourses($_SESSION['user_loged_in_id']);
        // Add tags to each course
        foreach ($courses as &$course) {
            $course['tags'] = $this->CourseTagsModel->getCoursetags($course['course_id']);
        }
        $this->render('/teacher/myCourses', ['courses' => $courses, 'csrf_token' => $_SESSION['csrf_token']]);
    }

    // method to delete a course
    public function deletCourse($courseId)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['csrf_token']) && $_POST['csrf_token'] === $_SESSION['csrf_token']) {
                $this->CourseModel->deleteCourse($courseId);
                header("Location:/teacher/myCourses");
            }
        }
    }

    // method to show the course details
    public function editeCourse($course_id)
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

        $categories = $this->CategoryModel->getAllCategories();
        $tags = $this->TagModel->getAllTags();
        $this->render('/teacher/editeCourse', ['course' => $course, 'categories' => $categories, 'tags' => $tags, 'csrf_token' => $_SESSION['csrf_token']]);
    }

    // methode to submiit edite course
    public function SubmitEditCourse($course_id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['csrf_token']) && $_POST['csrf_token'] === $_SESSION['csrf_token']) {
                $title = $_POST['title'];
                $description = $_POST['description'];
                $category_id = $_POST['category_id'];
                $content_type = $_POST['content_type'];
                $tags = $_POST['tags'];
                $tagsIdsArray = explode(',', trim($tags));

                // Update course data in the database
                $courseUpdated = $this->CourseModel->editCourse($course_id, $title, $description, $category_id);

                if ($courseUpdated) {
                    // Update course tags: remove existing tags and insert the new ones
                    $this->CourseTagsModel->deleteCourseTags($course_id);
                    foreach ($tagsIdsArray as $tag_id) {
                        $this->CourseTagsModel->addCourseTags($course_id, $tag_id);
                    }

                    // Update content
                    if (isset($_FILES['content'])) {
                        if ($_FILES['content']['error'] !== 4 && $_FILES['content']['size'] !== 0) {
                            if ($content_type === 'video') {
                                $oldContentUrl = $this->VideoContentModel->getContent($course_id)['video_url'];
                                if ($oldContentUrl === NULL || basename($oldContentUrl) !== basename($_FILES['content']['name'])) {
                                    $fileDetails = $this->uploadFile($content_type);
                                    $this->VideoContentModel->editContent(['course_id' => $course_id, 'video_url' => $fileDetails['fileUrl'], 'duration' => $fileDetails['contentInfo']]);
                                }
                            } else if ($content_type === 'document') {
                                $oldContentUrl = $this->DocumentContentModel->getContent($course_id)['document_url'];
                                if ($oldContentUrl === NULL || basename($oldContentUrl) !== basename($_FILES['content']['name'])) {
                                    $fileDetails = $this->uploadFile($content_type);
                                    $this->DocumentContentModel->editContent(['course_id' => $course_id, 'document_url' => $fileDetails['fileUrl'], 'pages_number' => $fileDetails['contentInfo']]);
                                }
                            }
                        }
                    }

                    // header("Location:/teacher/myCourses");
                } else {
                    echo 'Failed to update course in the database';
                }
            }
        }
    }
}
