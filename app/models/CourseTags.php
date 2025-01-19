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

        }
    }
}