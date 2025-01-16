<?php
require_once(__DIR__ . '/../config/db.php');

class Tag extends Db
{
    public function __construct()
    {
        parent::__construct();
    }

    // method to get all tags
    public function getAllTags()
    {
        $result = $this->conn->prepare("SELECT * FROM tags ORDER BY tag_id");
        $result->execute();

        $tags = $result->fetchAll(PDO::FETCH_ASSOC);
        return $tags;
    }

    // method to add a new tag
    public function addTag($tagName)
    {
        try {
            $stmt = $this->conn->prepare("INSERT INTO tags (tag_name) VALUES(?)");
            $stmt->execute([$tagName]);
            return true;
        } catch (PDOException $e) {
            error_log("Error adding tag: " . $e->getMessage());
            return false;
        }
    }

    // method to edit an existing tag
    public function editTag($tagId, $tagName)
    {
        try {
            $stmt = $this->conn->prepare("UPDATE tags SET tag_name = :tag_name WHERE tag_id = :tag_id");
            $stmt->bindParam(':tag_name', $tagName);
            $stmt->bindParam(':tag_id', $tagId, PDO::PARAM_INT);
            $stmt->execute();

            return true;
        } catch (PDOException $e) {
            error_log("Error updating tag: " . $e->getMessage());
            return false;
        }
    }

    // method to delete a tag
    public function deleteTag($tagId)
    {
        try {
            $deleteTag = $this->conn->prepare("DELETE FROM tags WHERE tag_id = :tag_id");
            $deleteTag->bindParam(':tag_id', $tagId, PDO::PARAM_INT);
            $deleteTag->execute();
        } catch (PDOException $e) {
            error_log("Error deleting tag: " . $e->getMessage());
        }
    }
}
?>