<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Youdemy Platform</title>
</head>

<body>
    <div class="flex">
        <?php include(__DIR__ . '/../partials/header.php'); ?>
        <div class="flex flex-col flex-1 lg:ml-64">
            <?php include(__DIR__ . '/../partials/sidebar.php'); ?>
            <main class="flex-1 bg-gray-100 min-h-screen overflow-y-auto py-24 px-20">
                <!-- Total Courses Card -->
                <div class="bg-white p-6 rounded-lg shadow-md mb-6">
                    <h2 class="text-2xl font-semibold text-gray-700">Total Courses</h2>
                    <p class="text-lg text-gray-500"><?= $numberOfCourses ?></p>
                </div>

                <h1 class="text-xl font-semibold pt-4 text-[#2E5077] mb-4">Enrollments By Courses</h1>
                <!-- Courses and Enrollments Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php foreach ($coursesNumberEnrollments as $course): ?>
                        <div class="bg-white border border-gray-300 rounded-lg shadow-md hover:shadow-xl transition-transform transform hover:scale-105 p-6">
                            <h3 class="text-xl font-semibold text-gray-700"><?= htmlspecialchars($course['course_title']) ?></h3>
                            <p class="text-sm text-gray-500 mt-2">Enrollments: <?= htmlspecialchars($course['enrollment_count']) ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>
</body>

</html>