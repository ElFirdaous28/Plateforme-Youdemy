<?php
require_once(__DIR__ . '/../config/db.php');
class Category extends Db
{

    public function __construct()
    {
        parent::__construct();
    }
    // methode to get all categories
    public function getAllCategories()
    {
        $resul = $this->conn->prepare("SELECT * FROM categories");
        $resul->execute();

        $categories = $resul->fetchAll(PDO::FETCH_ASSOC);
        return $categories;
    }

    // methode to add a category
    public function addCategoty($categoryName)
    {
        try {
            $stmt = $this->conn->prepare("INSERT INTO categories (category_name) VALUES(?)");
            $stmt->execute([$categoryName]);
            return true;
        } catch (PDOException $e) {
            error_log("error deltting user: " . $e->getMessage());
            return false;
        }
    }

    // methode to edite category
    public function editCategory($categoryId, $categoryName)
    {
        try {
            $stmt = $this->conn->prepare("UPDATE categories SET category_name = :category_name WHERE category_id = :category_id");
            $stmt->bindParam(':category_name', $categoryName);
            $stmt->bindParam(':category_id', $categoryId, PDO::PARAM_INT);
            $stmt->execute();

            return true;
        } catch (PDOException $e) {
            error_log("Error updating category: " . $e->getMessage());
            return false;
        }
    }

    // method to delete a user
    public function deleteCategory($categoryId)
{
    try {
        $deleteCategory = $this->conn->prepare("DELETE FROM categories WHERE category_id = :category_id");
        $deleteCategory->bindParam(':category_id', $categoryId, PDO::PARAM_INT);
        $deleteCategory->execute();
    } catch (PDOException $e) {
        error_log("Error deleting category: " . $e->getMessage());
    }
}
}