<?php
require_once(__DIR__ . '/Content.php');

class VideoContent extends Content
{
    public function __construct()
    {
        parent::__construct();
    }

    public function addContent($contentData){
        try {
            $stmt = $this->conn->prepare("INSERT INTO video_content (course_id,video_url,duration)
                                          VALUES (:course_id, :video_url, :duration)");
            $stmt->bindParam(':course_id', $contentData['course_id']);
            $stmt->bindParam(':video_url', $contentData['video_url']);
            $stmt->bindParam(':duration', $contentData['duration']);

            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            error_log("Error adding video content: " . $e->getMessage());
            return false;
        }
    }
    public function getContent($course_id){
        try {
            $stmt = $this->conn->prepare("SELECT * FROM video_content WHERE course_id = :course_id");
            $stmt->bindParam(':course_id', $course_id);

            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error getting video content: " . $e->getMessage());
            return false;
        }
    }
}