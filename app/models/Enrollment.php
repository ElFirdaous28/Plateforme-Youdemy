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
    public function getacceptedEnrollmentsCoursesIds($student_id)
    {
        try {
            $stmt = $this->conn->prepare("SELECT course_id FROM enrollments WHERE student_id = :student_id AND status !='requested'");
            $stmt->bindParam(':student_id', $student_id, PDO::PARAM_INT);

            $stmt->execute();
            $course_ids = $stmt->fetchAll(PDO::FETCH_COLUMN);
            return $course_ids;
        } catch (PDOException $e) {
            error_log("Error retrieving course IDs: " . $e->getMessage());
            return false;
        }
    }

    // methode to get student's courses enrolled in
    public function getEnrolledInCoursesIds($student_id)
    {
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

    // methode to get course erolments
    public function getClassEnrollment($course_id)
    {
        try {
            $stmt = $this->conn->prepare("SELECT enroll.*, u.full_name, u.email 
                                          FROM enrollments enroll
                                          JOIN users u ON u.user_id = enroll.student_id
                                          WHERE enroll.course_id = :course_id");

            $stmt->bindParam(':course_id', $course_id, PDO::PARAM_INT);

            $stmt->execute();
            $enrollments = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $enrollments;
        } catch (PDOException $e) {
            error_log("Error fetching class enrollments: " . $e->getMessage());
            return false;
        }
    }


    // update enrollment status
    public function setStatus($enrollment_id, $new_status)
    {
        try {
            $stmt = $this->conn->prepare("UPDATE enrollments SET status = :new_status 
                                      WHERE enrollment_id = :enrollment_id");

            $stmt->bindParam(':new_status', $new_status, PDO::PARAM_STR); // Use PDO::PARAM_STR if it's a string (enum type)
            $stmt->bindParam(':enrollment_id', $enrollment_id, PDO::PARAM_INT);

            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            error_log("Error updating enrollment status: " . $e->getMessage());
            return false;
        }
    }


    // Get the number of enrollments
    public function getNumberEnrollments($course_id)
    {
        try {
            $stmt = $this->conn->prepare("SELECT COUNT(*) AS student_count, c.title
                                            FROM enrollments e
                                            JOIN courses c ON c.course_id = e.course_id
                                            WHERE e.course_id = ? AND e.status = 'enrolled';");
            $stmt->execute([$course_id]);
            return $stmt->fetch(PDO::FETCH_ASSOC); // Ensure associative array for clarity
        } catch (PDOException $e) {
            error_log("Error getting the number of enrollments: " . $e->getMessage());
            return false;
        }
    }
}
