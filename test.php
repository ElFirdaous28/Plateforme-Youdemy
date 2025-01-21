<?php
// Database connection
$host = 'localhost';
$dbname = 'youdemy_database';
$username = 'root'; // Replace with your DB username
$password = ''; // Replace with your DB password

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Pagination variables
$limit = 5; // Number of records per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Fetch total courses
$totalQuery = $pdo->query("SELECT COUNT(*) AS total FROM courses");
$totalCourses = $totalQuery->fetch(PDO::FETCH_ASSOC)['total'];
$totalPages = ceil($totalCourses / $limit);

// Fetch paginated courses
$query = $pdo->prepare("SELECT * FROM courses LIMIT :limit OFFSET :offset");
$query->bindValue(':limit', $limit, PDO::PARAM_INT);
$query->bindValue(':offset', $offset, PDO::PARAM_INT);
$query->execute();
$courses = $query->fetchAll(PDO::FETCH_ASSOC);

// Display courses
echo "<h2>Courses List</h2>";
foreach ($courses as $course) {
    echo "<p><strong>{$course['title']}</strong> - {$course['description']}</p>";
}

// Display pagination links
echo "<div>";
for ($i = 1; $i <= $totalPages; $i++) {
    echo "<a href='?page=$i' style='margin-right: 5px;'>Page $i</a>";
}
echo "</div>";
?>
