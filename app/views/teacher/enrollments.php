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
                <h1 class="text-xl font-bold text-gray-700 my-10">Enrollments for Course: <?= htmlspecialchars($course['title']) ?></h1>

                <?php if (!empty($enrollments)): ?>
                    <table class="min-w-full table-auto bg-white border border-gray-300 rounded-lg shadow-md mt-10">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Student Name</th>
                                <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Email</th>
                                <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Status</th>
                                <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($enrollments as $enrollment): ?>
                                <tr class="border-b border-gray-200 hover:bg-gray-50">
                                    <td class="px-4 py-2 text-sm text-gray-600"><?= htmlspecialchars($enrollment['full_name']) ?></td>
                                    <td class="px-4 py-2 text-sm text-gray-600"><?= htmlspecialchars($enrollment['email']) ?></td>
                                    <td class="px-4 py-2 text-sm text-gray-600"><?= htmlspecialchars($enrollment['status']) ?></td>

                                    <!-- actions td -->
                                    <td class="px-4 py-2 text-sm text-gray-600">
                                        <?php if ($enrollment['status']==='requested'): ?>
                                            <!-- Accept Button -->
                                            <form action="/teacher/acceptEnrollment/<?= $enrollment['enrollment_id'] ?>" method="POST" class="inline ml-4">
                                                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token) ?>">
                                                <button type="submit" class="inline-flex items-center text-[#2E5077] hover:text-[#3b82f6]" title="Accept Enrollment">
                                                    <i class="bx bx-check text-xl mr-1"></i> Accept
                                                </button>
                                            </form>
                                        <?php endif ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p class="text-gray-600 text-center mt-10">No enrollments yet for this course.</p>
                <?php endif; ?>

            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>
</body>

</html>