<?php
require_once(__DIR__ . '/Content.php');

class VideoContent extends Content
{
    public function __construct()
    {
        parent::__construct();
    }

    public function addContent($contentData)
    {
        $duration = sprintf('%02d:%02d:%02d', 0, (int) ($contentData['duration'] / 60), $contentData['duration'] % 60);

        try {
            $stmt = $this->conn->prepare("INSERT INTO video_content (course_id, video_url, duration)
                                          VALUES (:course_id, :video_url, :duration)");
            $stmt->bindParam(':course_id', $contentData['course_id']);
            $stmt->bindParam(':video_url', $contentData['video_url']);
            $stmt->bindParam(':duration',$duration);
    
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            error_log("Error adding video content: " . $e->getMessage());
            return false;
        }
    }
    

    public function editContent($contentData)
    {
        try {
            $stmt = $this->conn->prepare("UPDATE video_content 
                                      SET video_url = :video_url, 
                                          duration = :duration 
                                      WHERE course_id = :course_id");

            $stmt->bindParam(':course_id', $contentData['course_id']);
            $stmt->bindParam(':video_url', $contentData['video_url']);
            $stmt->bindParam(':duration', $contentData['duration']);

            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            error_log("Error updating document content: " . $e->getMessage());
            return false;
        }
    }

    public function getContent($course_id)
    {
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
