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
    public function getContent($contentId){}
}