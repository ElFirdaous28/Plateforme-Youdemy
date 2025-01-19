<?php
require_once(__DIR__ . '/Content.php');

class DocumentContent extends Content
{
    public function __construct()
    {
        parent::__construct();
    }

    public function addContent($contentData)
    {
        try {
            $stmt = $this->conn->prepare("INSERT INTO document_content (course_id,document_url,pages_number)
                                          VALUES (:course_id, :document_url, :pages_number)");
            $stmt->bindParam(':course_id', $contentData['course_id']);
            $stmt->bindParam(':document_url', $contentData['document_url']);
            $stmt->bindParam(':pages_number', $contentData['pages_number']);

            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            error_log("Error adding document content: " . $e->getMessage());
            return false;
        }
    }
    public function getContent($course_id)
    {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM document_content WHERE course_id = :course_id");
            $stmt->bindParam(':course_id', $course_id);

            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error getting video content: " . $e->getMessage());
            return false;
        }
    }
}
