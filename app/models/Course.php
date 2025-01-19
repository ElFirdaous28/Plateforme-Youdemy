<?php
require_once(__DIR__ . '/../config/db.php');

class Course extends Db
{
    public function __construct()
    {
        parent::__construct();
    }

    // methode to add a cousre
    public function createCoure($title, $description, $category_id, $teacher_id, $content_type)
    {
        try {
            $stmt = $this->conn->prepare("INSERT INTO courses (title, description, category_id, teacher_id, content_type)
                                          VALUES (:title, :description, :category_id, :teacher_id, :content_type)");
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':category_id', $category_id);
            $stmt->bindParam(':teacher_id', $teacher_id);
            $stmt->bindParam(':content_type', $content_type);

            $stmt->execute();
            return $this->conn->lastInsertId();
        } catch (PDOException $e) {
            error_log("Error adding course: " . $e->getMessage());
            throw new Exception("Database error occurred");
        }
    }

    // methode to get all courses
    public function getAllCourses(){
        try {
            $stmt = $this->conn->prepare("SELECT * FROM courses");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    // methode to get all teacher courses
    public function getAllTeacherCourses($teacher_id){
        try {
            $stmt = $this->conn->prepare("SELECT * FROM courses WHERE teacher_id = :teacher_id");
            $stmt->bindParam(':teacher_id',$teacher_id);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}