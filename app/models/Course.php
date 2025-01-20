<?php
require_once(__DIR__ . '/../config/db.php');

class Course extends Db
{
    public function __construct()
    {
        parent::__construct();
    }

    // method to add a cousre
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

    // method to edit a course
    public function editCourse($course_id, $title, $description, $category_id)
    {
        try {
            $stmt = $this->conn->prepare("UPDATE courses 
                                          SET title = :title, 
                                          description = :description, 
                                          category_id = :category_id
                                          WHERE course_id = :course_id");

            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':category_id', $category_id);
            $stmt->bindParam(':course_id', $course_id);

            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            error_log("Error editing course: " . $e->getMessage());
        }
    }

    // method to get all courses
    public function getAllCourses()
    {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM courses");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    // method to get course by id
    public function getCourseById($course_id)
    {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM courses WHERE course_id = :course_id");
            $stmt->bindParam(':course_id', $course_id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    // method to get all teacher courses
    public function getAllTeacherCourses($teacher_id)
    {
        try {
            $stmt = $this->conn->prepare("SELECT c.*,cat.category_name FROM courses c
                                          JOIN categories cat ON cat.category_id = c.category_id
                                          WHERE teacher_id = :teacher_id");
            $stmt->bindParam(':teacher_id', $teacher_id);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    // method to delete a Course
    public function deleteCourse($courseId)
    {
        try {
            $deleteCourse = $this->conn->prepare("DELETE FROM courses WHERE course_id = :course_id");
            $deleteCourse->bindParam(':course_id', $courseId, PDO::PARAM_INT);
            $deleteCourse->execute();
        } catch (PDOException $e) {
            error_log("Error deleting Course: " . $e->getMessage());
        }
    }
}
