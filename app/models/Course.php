<?php
require_once(__DIR__ . '/../config/db.php');

class Course extends Db
{
    public function __construct()
    {
        parent::__construct();
    }

    // methode to add a cousre
    public function addCoure($title,$description){
        try{
        // INSERT INTO `courses` (`course_id`, `title`, `description`, `content_url`, `category_id`, `teacher_id`, `created_at`, `updated_at`) VALUES (NULL, 'course1', 'descreption of course 1', 'url', '4', '6', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
            $this->conn->prepare("INSERT INTO courses (title,description,content_url,category_id,teacher_id
                                  VALUES (:title, :description,:content_url,:category_id,:teacher_id)");
        }
        catch(PDOException $e){
            error_log("error adding a course ".$e->getMessage());
        }
    }
}
?>