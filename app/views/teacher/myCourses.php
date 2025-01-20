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
                <a href="/teacher/addCourse" class="px-4 py-2 text-sm font-bold text-white bg-[#2E5077] border-2 border-[#2E5077] rounded transition hover:bg-transparent hover:text-[#2E5077] float-right">Add Course</a>

                <h1 class="text-xl font-bold text-gray-700 my-10">Add Course</h1>

                <table class="min-w-full table-auto bg-white border border-gray-300 rounded-lg shadow-md mt-10">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Title</th>
                            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Description</th>
                            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Content Type</th>
                            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Category</th>
                            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Created At</th>
                            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($courses as $course): ?>
                            <tr class="border-b border-gray-200 hover:bg-gray-50">
                                <td class="px-4 py-2 text-sm text-gray-600"><?= htmlspecialchars($course['title']) ?></td>
                                <td class="px-4 py-2 text-sm text-gray-600"><?= htmlspecialchars($course['description']) ?></td>
                                <td class="px-4 py-2 text-sm text-gray-600"><?= htmlspecialchars($course['content_type']) ?></td>
                                <td class="px-4 py-2 text-sm text-gray-600"><?= htmlspecialchars($course['category_name']) ?></td>
                                <td class="px-4 py-2 text-sm text-gray-600"><?= date('Y-m-d', strtotime($course['created_at'])) ?></td>

                                <!-- actions td -->
                                <td class="px-4 py-2 text-sm text-gray-600">
                                    <?php if ($_SESSION['user_loged_in_role']==='teacher'): ?>
                                        <!-- Edit Icon -->
                                        <a href="/teacher/editeCourse/<?= $course['course_id'] ?>" class="text-[#2E5077] hover:text-[#3b82f6]" title="Edit Course">
                                            <i class="bx bx-edit text-xl"></i>
                                        </a>
                                        <!-- View Enrollments Icon -->
                                        <a href="/teacher/viewEnrollments/<?= $course['course_id'] ?>" class="text-[#2E5077] hover:text-[#3b82f6] ml-4" title="View Enrollments">
                                            <i class="bx bx-group text-xl"></i>
                                        </a>
                                    <?php endif ?>
                                    <!-- Delete Icon -->
                                    <form action="/admin/deletCourse/<?= $course['course_id'] ?>" method="POST" class="inline ml-4">
                                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token) ?>">
                                        <button type="button" onclick="if (confirm('Are you sure you want to delete this course?')) { this.form.submit(); }" class="text-[#2E5077] hover:text-[#3b82f6]" title="Delete Course">
                                            <i class="bx bx-trash text-xl"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>
</body>

</html>