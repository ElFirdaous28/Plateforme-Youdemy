<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" />
    <script src="https://cdn.tailwindcss.com"></script>

    <title>Youdemy Platform - Course Details</title>
</head>

<body class="bg-gray-50">
    <div class="flex">
        <?php include(__DIR__ . '/../partials/header.php'); ?>
        <!-- Main Content -->
        <div class="flex flex-col flex-1 lg:ml-64">
            <?php include(__DIR__ . '/../partials/sidebar.php'); ?>
            <!-- Main -->
            <main class="flex-1 bg-white min-h-screen overflow-y-auto py-6 px-8">
                <h1 class="text-3xl font-semibold pt-4 text-gray-800"><?= htmlspecialchars($course['title']) ?></h1>
                <div class="bg-white border border-gray-300 rounded-lg shadow-lg mt-6">
                    <!-- Course Cover -->
                    <div class="w-full h-48 bg-gray-200 flex items-center justify-center rounded-t-lg">
                        <span class="text-gray-500 font-medium">Course Cover</span>
                    </div>

                    <div class="p-6 space-y-6">
                        <!-- Description -->
                        <p class="text-sm text-gray-700"><?= htmlspecialchars($course['description']) ?></p>

                        <!-- Content Type & Category -->
                        <div class="mt-4">
                            <span class="text-sm text-gray-500"><?= htmlspecialchars($course['content_type']) ?> |</span>
                            <span class="text-sm text-gray-500"><?= htmlspecialchars($course['category_name']) ?></span>
                        </div>

                        <!-- Teacher Name -->
                        <p class="text-sm text-gray-600 mt-2">Instructor: <span class="font-medium"><?= htmlspecialchars($course['teacher_name']) ?></span></p>

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

                        <!-- Created At -->
                        <p class="text-xs text-gray-400 mt-4"><?= date('Y-m-d', strtotime($course['created_at'])) ?></p>
                    </div>
                </div>

                <!-- Content -->
                <?php if (isset($course['content']) && is_array($course['content']) && $course['content_type'] === 'document' && $course['content']['document_url'] != NULL): ?>
                    <div class="mt-6">
                        <p class="text-sm text-gray-600 font-medium">Course Document</p>
                        <iframe src="<?= $course['content']['document_url'] ?>" frameborder="0" class="w-full h-screen mt-2 rounded-lg shadow-md"></iframe>
                    </div>
                <?php elseif (isset($course['content']) && is_array($course['content']) && $course['content_type'] === 'video' && $course['content']['video_url'] != NULL): ?>
                    <div class="mt-6">
                        <p class="text-sm text-gray-600 font-medium">Course Video</p>
                        <video width="640" controls class="rounded-lg shadow-md w-full">
                            <source src="<?= $course['content']['video_url'] ?>" type="video/mp4">
                        </video>
                    </div>
                <?php else: ?>
                    <div class="mt-6">
                        <p class="text-sm text-gray-500">No content available yet.</p>
                    </div>
                <?php endif; ?>

            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>
</body>

</html>