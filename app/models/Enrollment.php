<?php
require_once(__DIR__ . '/../config/db.php');

class Enrollment extends Db
{
    public function __construct()
    {
        parent::__construct();
    }

    // methode to add enrollment
    public function createEnrollment($student_id, $course_id)
    {
        try {
            $stmt = $this->conn->prepare("INSERT INTO enrollments (student_id, course_id) VALUES (:student_id, :course_id)");

            $stmt->bindParam(':student_id', $student_id);
            $stmt->bindParam(':course_id', $course_id);

            $stmt->execute();
            echo "Enrollment added";
            return true;
        } catch (PDOException $e) {
            error_log("Error adding enrollment: " . $e->getMessage());
            return false;
        }
    }

    // methode to get student's courses enrolled in
    public function getEnrolledInCoursesIds($student_id) {
        try {
            $stmt = $this->conn->prepare("SELECT course_id FROM enrollments WHERE student_id = :student_id");
            $stmt->bindParam(':student_id', $student_id, PDO::PARAM_INT);
    
            $stmt->execute();
            $course_ids = $stmt->fetchAll(PDO::FETCH_COLUMN);
            return $course_ids;
        } catch (PDOException $e) {
            error_log("Error retrieving course IDs: " . $e->getMessage());
            return false;
        }
    }    
}
