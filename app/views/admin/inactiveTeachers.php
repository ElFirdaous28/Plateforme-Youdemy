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
            <main class="flex-1 bg-gray-100 min-h-screen overflow-y-auto pt-24 px-20">
                <h1 class="text-xl font-bold text-gray-700 my-10">Inactive Teachers</h1>

                <!-- users table -->
                <table class="min-w-full table-auto bg-white border border-gray-300 rounded-lg shadow-md mt-10">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Profile Picture</th>
                            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Full Name</th>
                            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Email</th>
                            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Role</th>
                            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Status</th>
                            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Created At</th>
                            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($inactiveTeachers as $inactiveTeacher): ?>
                            <tr class="border-b border-gray-200 hover:bg-gray-50">
                                <td class="px-8 py-2">
                                    <?php if ($inactiveTeacher['profile_picture']): ?>
                                        <img src="/assets/usersPics/5.jpg" alt="Profile Picture" class="w-14 h-14 rounded-full object-cover">
                                    <?php else: ?>
                                        <div class="w-14 h-14 flex items-center justify-center bg-gray-200 text-gray-500 text-xs rounded-full">
                                            No Pic
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td class="px-4 py-2 text-sm text-gray-600"><?= htmlspecialchars($inactiveTeacher['full_name']) ?></td>
                                <td class="px-4 py-2 text-sm text-gray-600"><?= htmlspecialchars($inactiveTeacher['email']) ?></td>
                                <td class="px-4 py-2 text-sm text-gray-600"><?= htmlspecialchars($inactiveTeacher['role']) ?></td>
                                <td class="px-4 py-2 text-sm text-gray-600">
                                    <form action="/admin/activateTeacher/<?php echo $inactiveTeacher['user_id']; ?>" method="POST">
                                        <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                                        <input type="hidden" name="status" value="<?php echo $inactiveTeacher['status']; ?>">
                                        <button type="button" onclick="if (confirm('Are you sure you want to activate this user\'s status?')) { this.form.submit(); }"
                                                class="inline-block py-1 px-2 text-xs font-semibold <?= $inactiveTeacher['status'] === 'active' ? 'text-green-800 bg-green-100' : 'text-yellow-800 bg-yellow-100' ?> rounded-full">
                                            <?= htmlspecialchars($inactiveTeacher['status']) ?>
                                        </button>
                                    </form>

                                </td>
                                <td class="px-4 py-2 text-sm text-gray-600"><?= htmlspecialchars($inactiveTeacher['created_at']) ?></td>
                                <td class="px-4 py-2 text-sm text-gray-600">
                                    <form action="/admin/deleteUser/<?php echo $inactiveTeacher['user_id']; ?>" method="POST">
                                        <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                                        <button type="button" onclick="if (confirm('Are you sure you want to delete this user?')) { this.form.submit(); }" class="text-[#2E5077] hover:underline">Delete</button>
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