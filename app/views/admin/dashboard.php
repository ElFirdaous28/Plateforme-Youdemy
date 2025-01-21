<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" />
    <script src="https://cdn.tailwindcss.com"></script>

    <title>Admin Dashboard - Youdemy</title>
</head>

<body class="bg-gray-100">
    <div class="flex">
        <?php include(__DIR__ . '/../partials/header.php'); ?>

        <div class="flex flex-col flex-1 lg:ml-64">
            <?php include(__DIR__ . '/../partials/sidebar.php'); ?>

            <main class="flex-1 py-24 px-20">
                <h1 class="text-2xl font-semibold mb-8">Admin Dashboard</h1>

                <!-- Total Courses -->
                <div class="bg-white p-6 rounded-lg shadow-md mb-6">
                    <h2 class="text-xl font-semibold text-gray-700">Total Courses</h2>
                    <p class="text-lg text-gray-600"><?= $totalCoursesNumber ?></p>
                </div>

                <!-- Top Categories -->
                <div class="bg-white p-6 rounded-lg shadow-md mb-6">
                    <h2 class="text-xl font-semibold text-gray-700">Top Categories</h2>
                    <ul class="list-disc pl-6">
                        <?php foreach ($topCategories as $category): ?>
                            <li class="text-gray-600"><?= htmlspecialchars($category['category_name']) ?>: <?= $category['category_count'] ?> courses</li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <!-- Top Courses by Number of Students -->
                <div class="bg-white p-6 rounded-lg shadow-md mb-6">
                    <h2 class="text-xl font-semibold text-gray-700">Top Courses by Number of Students</h2>
                    <ul class="list-disc pl-6">
                        <?php foreach ($topCoursesByNumnerStudnts as $course): ?>
                            <li class="text-gray-600"><?= htmlspecialchars($course['title']) ?>: <?= $course['student_number'] ?> students</li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <!-- Top Teachers by Enrollment -->
                <div class="bg-white p-6 rounded-lg shadow-md mb-6">
                    <h2 class="text-xl font-semibold text-gray-700">Top Teachers by Enrollment</h2>
                    <ul class="list-disc pl-6">
                        <?php foreach ($topTeachers as $teacher): ?>
                            <li class="text-gray-600"><?= htmlspecialchars($teacher['full_name']) ?>: <?= $teacher['student_number'] ?> students</li>
                        <?php endforeach; ?>
                    </ul>
                </div>

            </main>
        </div>
    </div>
</body>

</html>