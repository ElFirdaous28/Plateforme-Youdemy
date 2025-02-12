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

    // // method to get all courses
    public function getAllCourses()
    {
        try {
            $stmt = $this->conn->prepare("SELECT c.*,cat.category_name,u.full_name as teacher_name FROM courses c
                                          JOIN categories cat ON cat.category_id = c.category_id
                                          JOIN users u ON u.user_id=c.teacher_id");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function getAllCoursesX($limit, $offset, $search_value = null, $category = null)
    {
        try {
            $query = "SELECT c.*, cat.category_name, u.full_name AS teacher_name 
                  FROM courses c
                  JOIN categories cat ON cat.category_id = c.category_id
                  JOIN users u ON u.user_id = c.teacher_id";

            // Add filters for search_value and category
            $conditions = [];

            if ($search_value) {
                $conditions[] = "(c.title LIKE :search_value OR u.full_name LIKE :search_value)";
            }

            if ($category) {
                $conditions[] = "cat.category_id = :category";
            }

            if (!empty($conditions)) {
                $query .= " WHERE " . implode(' AND ', $conditions);
            }

            // Add pagination
            $query .= " LIMIT :limit OFFSET :offset";

            $stmt = $this->conn->prepare($query);

            // Bind parameters
            if ($search_value) {
                $stmt->bindValue(':search_value', '%' . $search_value . '%', PDO::PARAM_STR);
            }

            if ($category) {
                $stmt->bindValue(':category', $category, PDO::PARAM_INT);
            }

            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

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
            $stmt = $this->conn->prepare("SELECT course.*,cat.category_name,u.full_name as teacher_name FROM courses course
                                          JOIN categories cat ON cat.category_id = course.category_id
                                          JOIN users u ON u.user_id = course.teacher_id
                                          WHERE course_id = :course_id");
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

    // teacher number of courses
    public function getTeacherCourseCount($teacher_id)
    {
        try {
            $stmt = $this->conn->prepare("SELECT COUNT(*) AS course_count
                                            FROM courses
                                            WHERE teacher_id = ?;");
            $stmt->execute([$teacher_id]);
            return $stmt->fetchColumn();
        } catch (PDOException $e) {
            error_log("Error getting the number of courses for the teacher: " . $e->getMessage());
            return false;
        }
    }

    public function getTotalCoursesNumber()
    {
        try {
            $stmt = $this->conn->prepare("SELECT COUNT(*) AS total_courses FROM courses");
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total_courses'];
        } catch (PDOException $e) {
            error_log("Error getting total courses: " . $e->getMessage());
            return false;
        }
    }

    public function getTopCoursesByEnrollment()
    {
        try {
            $stmt = $this->conn->prepare("SELECT co.title, COUNT(*) AS student_number
                                          FROM enrollments en
                                          JOIN courses co ON co.course_id = en.course_id
                                          GROUP BY en.course_id
                                          ORDER BY student_number DESC
                                          LIMIT 3");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC); // Returns top 3 courses with the highest number of enrollments
        } catch (PDOException $e) {
            error_log("Error getting top courses by enrollment: " . $e->getMessage());
            return false;
        }
    }

    public function getTopTeachersByEnrollment()
    {
        try {
            $stmt = $this->conn->prepare("SELECT u.full_name, COUNT(*) AS student_number
                                        FROM enrollments en
                                        JOIN courses co ON co.course_id = en.course_id
                                        JOIN users u ON u.user_id = co.teacher_id
                                        GROUP BY u.user_id
                                        ORDER BY student_number DESC
                                        LIMIT 3;");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC); // Returns the top 3 teachers with their courses and the number of enrollments
        } catch (PDOException $e) {
            error_log("Error getting top teachers by enrollment: " . $e->getMessage());
            return false;
        }
    }
}
