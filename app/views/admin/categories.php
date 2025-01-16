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
                <button onclick="openModal('add')" class="px-4 py-2 text-sm font-bold text-white bg-[#2E5077] border-2 border-[#2E5077] rounded transition hover:bg-transparent hover:text-[#2E5077] float-right">
                    Add Category
                </button>

                <h1 class="text-xl font-bold text-gray-700 my-10">Categories</h1>
                <?php
                    if (isset($_SESSION["add_category_error"])) {
                        echo "<p class='text-red-500'>" . $_SESSION["add_category_error"] . "</p>";
                        unset($_SESSION["add_category_error"]); // Unset the session variable after displaying
                    }
                ?>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-5">
                    <?php foreach ($categories as $category): ?>
                        <div class="bg-white border border-gray-300 rounded-lg shadow-md p-4">
                            <!-- Category Name -->
                            <h3 class="text-lg font-semibold text-gray-700 mb-4">
                                <?php echo htmlspecialchars($category['category_name']); ?>
                            </h3>

                            <!-- Action Buttons -->
                            <div class="flex justify-between">
                                <!-- Edit Button -->
                                <button onclick="openModal('edit', '<?php echo $category['category_id']; ?>', '<?php echo htmlspecialchars($category['category_name']); ?>')" class="text-blue-500 hover:underline">
                                    Edit
                                </button>

                                <!-- Delete Button -->
                                <form action="/admin/deleteCategory/<?php echo $category['category_id']; ?>" method="POST" onsubmit="return confirm('Are you sure you want to delete this category?');">
                                    <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                                    <button type="submit" class="text-red-500 hover:underline">Delete</button>
                                </form>
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
<?php include(__DIR__ . '/../admin/categoryPopUp.php'); ?>