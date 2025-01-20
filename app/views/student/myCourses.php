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
        <!-- Main Content -->
        <div class="flex flex-col flex-1 lg:ml-64">
            <?php include(__DIR__ . '/../partials/sidebar.php'); ?>
            <!-- Main -->
            <main class="flex-1 bg-gray-100 min-h-screen overflow-y-auto py-24 px-20">
                <h1 class="text-xl font-semibold pt-4 text-gray-700">My Enrolled Courses</h1>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-10">
                    <?php foreach ($studentCourses as $course): ?>
                        <div class="bg-white border border-gray-300 rounded-lg shadow-md hover:shadow-xl transition-transform transform hover:scale-105 flex flex-col overflow-hidden">
                            <!-- Course Cover -->
                            <div class="w-full h-48 bg-gray-200 flex items-center justify-center rounded-t-lg">
                                <span class="text-gray-400">Course Cover</span>
                            </div>

                            <div class="p-6 flex flex-col flex-grow space-y-4">
                                <!-- Title -->
                                <a href="/student/courseDetails/<?= $course['course_id'] ?>" class="text-xl font-semibold text-gray-600 truncate hover:text-[#2E5077]"><?= htmlspecialchars($course['title']) ?></a>

                                <!-- Description -->
                                <p class="text-sm text-gray-600 mt-2 truncate"><?= htmlspecialchars($course['description']) ?></p>

                                <!-- Content Type & Category -->
                                <div class="mt-2 flex items-center space-x-2">
                                    <span class="text-sm text-gray-500"><?= htmlspecialchars($course['content_type']) ?></span>
                                    <span class="text-sm text-gray-500">|</span>
                                    <span class="text-sm text-gray-500"><?= htmlspecialchars($course['category_name']) ?></span>
                                </div>

                                <!-- Teacher Name -->
                                <p class="text-sm text-gray-600">Instructor: <span class="font-medium"><?= htmlspecialchars($course['teacher_name']) ?></span></p>

                                <!-- Tags -->
                                <?php if (!empty($course['tags'])): ?>
                                    <div class="mt-2">
                                        <span class="text-sm text-gray-500">Tags:</span>
                                        <div class="flex flex-wrap mt-2 space-x-2">
                                            <?php foreach ($course['tags'] as $tag): ?>
                                                <span class="text-xs inline-block bg-gray-200 text-gray-700 py-1 px-2 rounded-full"><?= '#' . htmlspecialchars($tag) ?></span>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>
</body>

</html>