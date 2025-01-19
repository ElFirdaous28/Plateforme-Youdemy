<?php

require_once(__DIR__ . '/../models/Category.php');
require_once(__DIR__ . '/../models/Tag.php');
require_once(__DIR__ . '/../models/Course.php');
require_once(__DIR__ . '/../models/VideoContent.php');
require_once(__DIR__ . '/../models/DocumentContent.php');

require_once __DIR__ . '/../../vendor/autoload.php';
use Fpdf\Fpdf;
use setasign\Fpdi\Fpdi;
class TeacherController extends BaseController
{
    private $CategoryModel;
    private $TagModel;
    private $CourseModel;
    private $DocumentContentModel;
    private $VideoContentModel;

    public function __construct()
    {
        $this->CategoryModel = new Category();
        $this->TagModel = new Tag();
        $this->CourseModel = new Course();
        $this->DocumentContentModel = new DocumentContent();
        $this->VideoContentModel = new VideoContent();
    }

    // methode to show add course view
    public function addCourseView()
    {
        $categories = $this->CategoryModel->getAllCategories();
        $tags = $this->TagModel->getAllTags();
        $csrf_token = $_SESSION['csrf_token'];
        $this->render('/teacher/addCourse', ['categories' => $categories, 'tags' => $tags, 'csrf_token' => $csrf_token]);
    }

    public function SubmitAddCourse() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['csrf_token']) && $_POST['csrf_token'] === $_SESSION['csrf_token']) {
                $title = $_POST['title'];
                $description = $_POST['description'];
                $category_id = $_POST['category_id'];
                $teacher_id = $_SESSION['user_loged_in_id'];
                $content_type = $_POST['content_type'];
    
                // Insert course data into the database
                $courseInsertedId = $this->CourseModel->createCoure($title, $description, $category_id, $teacher_id, $content_type);
                $fileDetails = $this->uploadFile($content_type);
                
                if ($courseInsertedId && $fileDetails) {
                    if($content_type=='video'){
                        $this->VideoContentModel->addContent(['course_id'=>$courseInsertedId,'video_url'=>$fileDetails['fileUrl'],'duration'=>$fileDetails['contentInfo']]);
                    }
                    else if($content_type=='document'){
                        $this->DocumentContentModel->addContent(['course_id'=>$courseInsertedId,'document_url'=>$fileDetails['fileUrl'],'pages_number'=>$fileDetails['contentInfo']]);
                    }
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
                    $contentInfo = $file['playtime_string'] ?? 'Unknown duration';
                } elseif ($content_type === 'document') {
                    // Use FPDI to extract PDF page count
                    $pdf = new Fpdi();
                    $pdf->setSourceFile($targetFilePath);  // Load the existing PDF
                    $pageCount = $pdf->setSourceFile($targetFilePath);  // Get the total number of pages
                    $contentInfo = $pageCount;  // Return the number of pages
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
    
}