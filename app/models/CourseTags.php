<?php
require_once(__DIR__ . '/../config/db.php');

class CourseTags extends Db
{
    public function __construct()
    {
        parent::__construct();
    }

    // methode to insert courseTags
    public function addCourseTags($course_id,$tag_id){
        try{
            $stmt = $this->conn->prepare("INSERT INTO course_tags (course_id,tag_id)
                            VALUES (:course_id,:tag_id)");
            $stmt->bindParam(':course_id',$course_id);
            $stmt->bindParam(':tag_id',$tag_id);

            $stmt->execute();
        }
        catch(PDOException $e){
            error_log("erroe inserting tag: ".$e);
        }
    }

    // methode to get course tags
    public function getCoursetags($course_id) {
        try {
            $stmt = $this->conn->prepare("SELECT t.tag_name FROM course_tags ct 
                                          JOIN tags t ON t.tag_id = ct.tag_id
                                          WHERE ct.course_id = :course_id;");
            $stmt->bindParam(':course_id', $course_id);
            $stmt->execute();
            
            // Fetch all tag names directly as an indexed array
            return $stmt->fetchAll(PDO::FETCH_COLUMN);
        } catch (PDOException $e) {
            error_log("error getting tags: " . $e);
        }
    }    

}